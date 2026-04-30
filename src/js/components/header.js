export function initHeader($) {
  const $drawer = $('#mobile-drawer');
  const $content = $('#drawer-content');

  $('#mobile-menu-open').on('click', function () {
    $drawer.removeClass('opacity-0 pointer-events-none');
    $content.removeClass('translate-x-full');
  });

  const closeDrawer = () => {
    $drawer.addClass('opacity-0 pointer-events-none');
    $content.addClass('translate-x-full');
  };

  $('#mobile-menu-close, #mobile-drawer').on('click', function (e) {
    if (e.target === this || $(e.target).closest('#mobile-menu-close').length) {
      closeDrawer();
    }
  });
}