import GLightbox from 'glightbox';

export function initVideos() {
  const section = document.getElementById('videos-section');

  if (!section) {
    return;
  }

  const tabs = section.querySelectorAll('.js-video-tab');
  const contents = section.querySelectorAll('.js-video-content');
  const activeClasses = [
    'bg-white',
    'text-[#FF93AB]',
    'ring-1',
    'ring-[#FFB7C5]/30',
    'shadow-[0_10px_30px_rgba(255,183,197,0.14)]',
    'dark:bg-slate-800',
    'dark:text-pink-300',
  ];
  const inactiveClasses = ['text-slate-500', 'dark:text-slate-400'];

  const lightbox = GLightbox({
    selector: '.js-videos-lightbox',
    touchNavigation: true,
    loop: true,
    autoplayVideos: true,
    zoomable: false,
  });

  if (tabs.length && contents.length) {
    const setActiveTab = (targetId) => {
      contents.forEach((content) => {
        const isActive = content.id === targetId;
        content.classList.toggle('hidden', !isActive);
        content.setAttribute('aria-hidden', String(!isActive));
      });

      tabs.forEach((tab) => {
        const isActive = tab.getAttribute('data-target') === targetId;
        tab.classList.remove(...activeClasses, ...inactiveClasses);
        tab.classList.add(...(isActive ? activeClasses : inactiveClasses));
        tab.setAttribute('aria-selected', String(isActive));
        tab.tabIndex = isActive ? 0 : -1;
      });
    };

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        const targetId = tab.getAttribute('data-target');

        if (targetId) {
          setActiveTab(targetId);
        }
      });
    });

    setActiveTab(tabs[0].getAttribute('data-target'));
  }

  return lightbox;
}