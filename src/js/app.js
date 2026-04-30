import '../css/app.css';

const storageKey = 'jc-theme';
const root = document.documentElement;
const themeToggleBtn = document.getElementById('jc-theme-toggle');
const themeToggleLabel = themeToggleBtn?.querySelector('[data-theme-toggle-label]');
const themeQuery = window.matchMedia('(prefers-color-scheme: dark)');

function readStoredTheme() {
  try {
    const storedTheme = localStorage.getItem(storageKey);
    return storedTheme === 'light' || storedTheme === 'dark' ? storedTheme : null;
  } catch (error) {
    return null;
  }
}

function getPreferredTheme() {
  return readStoredTheme() ?? (themeQuery.matches ? 'dark' : 'light');
}

function applyTheme(theme) {
  const isDark = theme === 'dark';

  root.classList.toggle('dark', isDark);
  root.style.colorScheme = theme;

  if (themeToggleBtn) {
    themeToggleBtn.setAttribute('aria-pressed', String(isDark));
  }

  if (themeToggleLabel) {
    themeToggleLabel.textContent = isDark ? 'Light mode' : 'Dark mode';
  }
}

function setTheme(theme) {
  applyTheme(theme);

  try {
    localStorage.setItem(storageKey, theme);
  } catch (error) { }
}

applyTheme(getPreferredTheme());

if (themeToggleBtn) {
  themeToggleBtn.addEventListener('click', function () {
    setTheme(root.classList.contains('dark') ? 'light' : 'dark');
  });
}

if (typeof themeQuery.addEventListener === 'function') {
  themeQuery.addEventListener('change', function () {
    if (!readStoredTheme()) {
      applyTheme(themeQuery.matches ? 'dark' : 'light');
    }
  });
}