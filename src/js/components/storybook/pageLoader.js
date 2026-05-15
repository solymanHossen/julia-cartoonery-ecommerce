function buildPartialUrl(url) {
  const partialUrl = new URL(url, window.location.href);
  partialUrl.searchParams.set('story_reader', '1');
  return partialUrl.toString();
}

function extractStoryPage(doc, requestUrl) {
  const reader = doc.querySelector('[data-story-reader]');

  if (!reader) {
    throw new Error('Story reader markup was not found in the response.');
  }

  const stage = reader.querySelector('[data-story-stage]');
  if (!stage) {
    throw new Error('Story reader stage was not found in the response.');
  }

  const currentPage = reader.dataset.currentPage || '1';
  const totalPages = reader.dataset.totalPages || '1';
  const liveRegion = reader.querySelector('[data-story-live-region]');

  return {
    url: new URL(requestUrl, window.location.href).toString(),
    title: reader.dataset.storyTitle || doc.title || document.title,
    currentPage,
    totalPages,
    stageHTML: stage.outerHTML,
    liveRegionText: liveRegion ? liveRegion.textContent.trim() : `Page ${currentPage} of ${totalPages}`
  };
}

export class StoryPageLoader {
  constructor(cache) {
    this.cache = cache;
    this.pending = new Map();
  }

  async load(url, { signal } = {}) {
    const requestUrl = buildPartialUrl(url);

    if (this.cache.has(requestUrl)) {
      return this.cache.get(requestUrl);
    }

    if (this.pending.has(requestUrl)) {
      return this.pending.get(requestUrl);
    }

    const request = fetch(requestUrl, {
      credentials: 'same-origin',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      signal
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Story page request failed with status ${response.status}`);
        }

        return response.text();
      })
      .then((html) => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const page = extractStoryPage(doc, url);
        this.cache.set(requestUrl, page);
        return page;
      })
      .finally(() => {
        this.pending.delete(requestUrl);
      });

    this.pending.set(requestUrl, request);
    return request;
  }

  prefetch(url) {
    if (!url) {
      return Promise.resolve(null);
    }

    return this.load(url).catch(() => null);
  }
}
