import '../css/app.css';

document.addEventListener('DOMContentLoaded', function () {
  const root = document.documentElement;
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');
  const openBtn = document.getElementById('mobile-menu-open');
  const closeBtn = document.getElementById('mobile-menu-close');
  const drawer = document.getElementById('mobile-drawer');
  const content = document.getElementById('drawer-content');
  const themeQuery = window.matchMedia('(prefers-color-scheme: dark)');
  const storageKey = 'theme';

  const getStoredTheme = () => {
    try {
      const value = localStorage.getItem(storageKey);
      return value === 'dark' || value === 'light' ? value : null;
    } catch (error) {
      return null;
    }
  };

  const getPreferredTheme = () => getStoredTheme() ?? (themeQuery.matches ? 'dark' : 'light');

  const syncIcons = (isDark) => {
    if (darkIcon) {
      darkIcon.classList.toggle('hidden', isDark);
    }

    if (lightIcon) {
      lightIcon.classList.toggle('hidden', !isDark);
    }

    if (themeToggleBtn) {
      themeToggleBtn.setAttribute('aria-pressed', String(isDark));
    }
  };

  const applyTheme = (theme, persist = false) => {
    const isDark = theme === 'dark';

    root.classList.toggle('dark', isDark);
    root.style.colorScheme = theme;
    syncIcons(isDark);

    if (persist) {
      try {
        localStorage.setItem(storageKey, theme);
      } catch (error) { }
    }
  };

  const openDrawer = () => {
    if (!drawer || !content) {
      return;
    }

    drawer.classList.remove('opacity-0', 'pointer-events-none');
    content.classList.remove('translate-x-full');
  };

  const closeDrawer = () => {
    if (!drawer || !content) {
      return;
    }

    drawer.classList.add('opacity-0', 'pointer-events-none');
    content.classList.add('translate-x-full');
  };

  applyTheme(getPreferredTheme());

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', function () {
      applyTheme(root.classList.contains('dark') ? 'light' : 'dark', true);
    });
  }

  if (themeQuery.addEventListener) {
    themeQuery.addEventListener('change', function () {
      if (!getStoredTheme()) {
        applyTheme(themeQuery.matches ? 'dark' : 'light');
      }
    });
  }

  if (openBtn) {
    openBtn.addEventListener('click', openDrawer);
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeDrawer);
  }

  if (drawer) {
    drawer.addEventListener('click', function (event) {
      if (event.target === drawer) {
        closeDrawer();
      }
    });
  }
});