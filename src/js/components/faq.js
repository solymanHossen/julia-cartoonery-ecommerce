export function initFaq() {
  const root = document.querySelector('[data-faq-root]');
  if (!root) return;

  const searchInput = root.querySelector('[data-faq-search]');
  const clearButton = root.querySelector('[data-faq-clear]');
  const countLabel = root.querySelector('[data-faq-count]');
  const emptyState = root.querySelector('[data-faq-empty]');
  const categorySections = Array.from(root.querySelectorAll('[data-faq-category]'));
  const items = Array.from(root.querySelectorAll('[data-faq-item]'));

  const closeItem = (item) => {
    const trigger = item.querySelector('[data-faq-trigger]');
    const panel = item.querySelector('[data-faq-panel]');
    if (!trigger || !panel) return;

    trigger.setAttribute('aria-expanded', 'false');
    panel.style.maxHeight = '0px';
    panel.style.opacity = '0';
    panel.setAttribute('aria-hidden', 'true');
    item.dataset.state = 'closed';
  };

  const openItem = (item) => {
    const trigger = item.querySelector('[data-faq-trigger]');
    const panel = item.querySelector('[data-faq-panel]');
    if (!trigger || !panel) return;

    trigger.setAttribute('aria-expanded', 'true');
    panel.setAttribute('aria-hidden', 'false');
    panel.style.maxHeight = `${panel.scrollHeight}px`;
    panel.style.opacity = '1';
    item.dataset.state = 'open';
  };

  const toggleItem = (item) => {
    if (item.dataset.state === 'open') {
      closeItem(item);
      return;
    }

    openItem(item);
  };

  const refreshOpenPanels = () => {
    items.forEach((item) => {
      if (item.dataset.state !== 'open') return;
      const panel = item.querySelector('[data-faq-panel]');
      if (panel) panel.style.maxHeight = `${panel.scrollHeight}px`;
    });
  };

  const applyFilter = () => {
    const query = (searchInput?.value || '').trim().toLowerCase();
    let visibleCount = 0;

    items.forEach((item) => {
      const text = (item.dataset.faqText || '').toLowerCase();
      const matches = !query || text.includes(query);
      item.classList.toggle('hidden', !matches);

      if (!matches) closeItem(item);
      if (matches) visibleCount += 1;
    });

    categorySections.forEach((section) => {
      const sectionVisible = section.querySelector('[data-faq-item]:not(.hidden)');
      section.classList.toggle('hidden', !sectionVisible);
    });

    if (countLabel) {
      countLabel.textContent = query
        ? `Showing ${visibleCount} result${visibleCount === 1 ? '' : 's'} for “${query}”`
        : 'Showing all questions';
    }

    if (emptyState) {
      emptyState.classList.toggle('hidden', visibleCount !== 0 || !query);
    }

    if (clearButton) {
      clearButton.classList.toggle('hidden', !query);
    }
  };

  items.forEach((item) => {
    const trigger = item.querySelector('[data-faq-trigger]');
    const panel = item.querySelector('[data-faq-panel]');

    if (!trigger || !panel) return;

    closeItem(item);

    trigger.addEventListener('click', () => {
      toggleItem(item);
    });

    trigger.addEventListener('keydown', (event) => {
      const buttons = items
        .filter((faqItem) => !faqItem.classList.contains('hidden'))
        .map((faqItem) => faqItem.querySelector('[data-faq-trigger]'))
        .filter(Boolean);

      if (!buttons.length) return;

      const currentIndex = buttons.indexOf(trigger);

      if (event.key === 'ArrowDown') {
        event.preventDefault();
        const nextButton = buttons[(currentIndex + 1) % buttons.length];
        nextButton?.focus();
      }

      if (event.key === 'ArrowUp') {
        event.preventDefault();
        const previousButton = buttons[(currentIndex - 1 + buttons.length) % buttons.length];
        previousButton?.focus();
      }

      if (event.key === 'Home') {
        event.preventDefault();
        buttons[0]?.focus();
      }

      if (event.key === 'End') {
        event.preventDefault();
        buttons[buttons.length - 1]?.focus();
      }
    });
  });

  searchInput?.addEventListener('input', applyFilter);
  clearButton?.addEventListener('click', () => {
    if (searchInput) searchInput.value = '';
    applyFilter();
    searchInput?.focus();
  });

  window.addEventListener('resize', refreshOpenPanels);
  applyFilter();
}