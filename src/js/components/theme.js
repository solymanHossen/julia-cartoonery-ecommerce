export function initTheme($) {
  const themeQuery = window.matchMedia('(prefers-color-scheme: dark)');
  const storageKey = 'theme';
  const $html = $('html');
  const $darkIcon = $('#theme-toggle-dark-icon');
  const $lightIcon = $('#theme-toggle-light-icon');
  const $themeToggleBtn = $('#theme-toggle');

  const applyTheme = (theme, persist = false) => {
    const isDark = theme === 'dark';

    $html.toggleClass('dark', isDark);
    $html.css('color-scheme', theme);

    if ($darkIcon.length) $darkIcon.toggleClass('hidden', isDark);
    if ($lightIcon.length) $lightIcon.toggleClass('hidden', !isDark);
    if ($themeToggleBtn.length) $themeToggleBtn.attr('aria-pressed', isDark);

    if (persist) {
      try {
        localStorage.setItem(storageKey, theme);
      } catch (error) { }
    }
  };

  // Set initial state
  if ($html.hasClass('dark')) {
    if ($darkIcon.length) $darkIcon.addClass('hidden');
    if ($lightIcon.length) $lightIcon.removeClass('hidden');
    if ($themeToggleBtn.length) $themeToggleBtn.attr('aria-pressed', 'true');
  } else {
    if ($darkIcon.length) $darkIcon.removeClass('hidden');
    if ($lightIcon.length) $lightIcon.addClass('hidden');
    if ($themeToggleBtn.length) $themeToggleBtn.attr('aria-pressed', 'false');
  }

  $themeToggleBtn.on('click', function () {
    const newTheme = $html.hasClass('dark') ? 'light' : 'dark';
    applyTheme(newTheme, true);
  });

  if (themeQuery.addEventListener) {
    themeQuery.addEventListener('change', function () {
      let storedTheme = null;
      try {
        storedTheme = localStorage.getItem(storageKey);
      } catch (e) { }

      if (!storedTheme || (storedTheme !== 'dark' && storedTheme !== 'light')) {
        applyTheme(themeQuery.matches ? 'dark' : 'light');
      }
    });
  }
}