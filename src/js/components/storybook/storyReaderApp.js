import { StoryHistoryManager } from './historyManager.js';
import { StoryPageCache } from './domCache.js';
import { StoryPageLoader } from './pageLoader.js';
import { StoryTransitionController } from './transitionController.js';

const STORY_READER_SELECTOR = '[data-story-reader]';
const FLIP_DURATION = 760;

function prefersReducedMotion() {
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function isInteractiveElement(target) {
  if (!target || !(target instanceof HTMLElement)) {
    return false;
  }

  return Boolean(
    target.closest('a, button, input, textarea, select, summary, [contenteditable="true"]')
  );
}

function buildState(url, reader) {
  return {
    url,
    page: reader.dataset.currentPage || '1',
    totalPages: reader.dataset.totalPages || '1',
    scrollY: window.scrollY,
    title: document.title
  };
}

function getSlot(reader, selector) {
  return reader.querySelector(selector);
}

function updateSlot(currentNode, newHTML) {
  if (!currentNode) {
    return;
  }

  currentNode.outerHTML = newHTML;
}

export class StoryReaderApp {
  constructor(reader) {
    this.reader = reader;
    this.cache = new StoryPageCache(10);
    this.loader = new StoryPageLoader(this.cache);
    this.history = new StoryHistoryManager();
    this.transition = new StoryTransitionController();
    this.abortController = null;
    this.activeNavToken = 0;
    this.boundHandlers = [];
  }

  init() {
    if (this.reader.dataset.storyReaderBound === 'true') {
      return;
    }

    this.reader.dataset.storyReaderBound = 'true';
    history.scrollRestoration = 'manual';

    const initialState = buildState(window.location.href, this.reader);
    this.history.syncInitialState(initialState);
    this.history.onPopState((event) => {
      const state = event.state;
      if (!state || !state.url) {
        return;
      }

      const currentPage = parseInt(this.reader.dataset.currentPage || '1', 10);
      const targetPage = parseInt(state.page || '1', 10);
      const direction = targetPage < currentPage ? 'prev' : 'next';

      this.navigate(state.url, {
        direction,
        pushState: false,
        restoreScroll: true,
        restoreScrollY: state.scrollY || 0,
        fromHistory: true
      });
    });

    this.reader.addEventListener('click', (event) => this.handleClick(event));
    this.reader.addEventListener('keydown', (event) => this.handleKeyDown(event));
    this.reader.addEventListener('mouseover', (event) => this.handlePrefetch(event));
    this.reader.addEventListener('focusin', (event) => this.handlePrefetch(event));

    this.prefetchNeighbors();
  }

  destroy() {
    this.history.destroy();
    if (this.abortController) {
      this.abortController.abort();
    }
  }

  handleClick(event) {
    const link = event.target.closest('[data-story-nav], [data-story-exit]');
    if (!link || !this.reader.contains(link)) {
      return;
    }

    event.preventDefault();

    const exit = link.dataset.storyExit === 'true';
    const direction = link.dataset.storyNav === 'prev' ? 'prev' : 'next';
    this.navigate(link.href, {
      direction,
      exit,
      pushState: !exit,
      restoreScroll: false
    });
  }

  handleKeyDown(event) {
    if (isInteractiveElement(event.target)) {
      return;
    }

    if (event.key === 'ArrowRight') {
      const nextLink = this.reader.querySelector('[data-story-nav="next"], [data-story-exit="true"]');
      if (nextLink) {
        event.preventDefault();
        this.navigate(nextLink.href, {
          direction: 'next',
          exit: nextLink.dataset.storyExit === 'true',
          pushState: nextLink.dataset.storyExit !== 'true',
          restoreScroll: false
        });
      }
    }

    if (event.key === 'ArrowLeft') {
      const prevLink = this.reader.querySelector('[data-story-nav="prev"]');
      if (prevLink) {
        event.preventDefault();
        this.navigate(prevLink.href, {
          direction: 'prev',
          pushState: true,
          restoreScroll: false
        });
      }
    }
  }

  handlePrefetch(event) {
    const link = event.target.closest('[data-story-nav]');
    if (!link || !this.reader.contains(link)) {
      return;
    }

    this.loader.prefetch(link.href);
  }

  prefetchNeighbors() {
    const nextLink = this.reader.querySelector('[data-story-nav="next"]');
    const prevLink = this.reader.querySelector('[data-story-nav="prev"]');

    if (nextLink) {
      this.loader.prefetch(nextLink.href);
    }

    if (prevLink) {
      this.loader.prefetch(prevLink.href);
    }
  }

  async navigate(url, { direction = 'next', pushState = true, restoreScroll = false, restoreScrollY = 0, exit = false } = {}) {
    if (!url) {
      return;
    }

    const navToken = ++this.activeNavToken;

    if (this.abortController) {
      this.abortController.abort();
    }

    this.abortController = new AbortController();
    const signal = this.abortController.signal;
    const currentReader = this.reader;
    const currentHeight = currentReader.getBoundingClientRect().height;

    currentReader.style.minHeight = `${currentHeight}px`;

    const pagePromise = exit ? Promise.resolve(null) : this.loader.load(url, { signal });
    const transition = this.transition.play(currentReader, direction);

    const commitPage = async () => {
      if (exit) {
        return null;
      }

      await new Promise((resolve) => window.setTimeout(resolve, FLIP_DURATION * 0.42));

      const pageData = await pagePromise;

      if (navToken !== this.activeNavToken || signal.aborted || !pageData) {
        return null;
      }

      this.applyPage(currentReader, pageData);
      document.title = pageData.title;

      if (pushState) {
        this.history.push(buildState(url, currentReader));
      }

      if (restoreScroll) {
        window.scrollTo({ top: restoreScrollY, behavior: 'auto' });
      }

      this.cacheNeighborPages(currentReader);
      this.announce(pageData.liveRegionText);

      return pageData;
    };

    const commitPromise = commitPage();

    try {
      const [pageData] = await Promise.all([commitPromise, transition.finished]);

      if (navToken !== this.activeNavToken || signal.aborted) {
        return;
      }

      if (!pageData && !exit) {
        throw new Error('Page data was not available for the story turn.');
      }
    } catch (error) {
      currentReader.style.minHeight = '';
      this.transition.end(currentReader);
      if (signal.aborted) {
        return;
      }

      window.location.href = url;
      return;
    }

    if (exit) {
      window.location.href = url;
      return;
    }

    requestAnimationFrame(() => {
      const stage = currentReader.querySelector('[data-story-stage]');
      if (stage) {
        stage.classList.add('is-stage-entering');
        requestAnimationFrame(() => {
          stage.classList.remove('is-stage-entering');
        });
      }
      currentReader.style.minHeight = '';
      this.transition.end(currentReader);
    });
  }

  applyPage(reader, pageData) {
    const stage = getSlot(reader, '[data-story-stage]');
    if (stage) {
      stage.outerHTML = pageData.stageHTML;
    }

    reader.dataset.currentPage = pageData.currentPage;
    reader.dataset.totalPages = pageData.totalPages;

    requestAnimationFrame(() => {
      reader.focus({ preventScroll: true });
    });
  }

  announce(message) {
    const liveRegion = this.reader.querySelector('[data-story-live-region]');
    if (liveRegion) {
      liveRegion.textContent = message;
    }
  }

  cacheNeighborPages(reader) {
    const nextLink = reader.querySelector('[data-story-nav="next"]');
    const prevLink = reader.querySelector('[data-story-nav="prev"]');

    if (nextLink) {
      this.loader.prefetch(nextLink.href);
    }

    if (prevLink) {
      this.loader.prefetch(prevLink.href);
    }
  }
}

export function initStoryReaderApp() {
  const readers = document.querySelectorAll(STORY_READER_SELECTOR);

  if (!readers.length) {
    return;
  }

  readers.forEach((reader) => {
    const app = new StoryReaderApp(reader);
    app.init();
  });
}
