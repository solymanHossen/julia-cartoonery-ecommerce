import { showToast } from './toast.js';

export const initWishlist = ($) => {
    // 1. Wishlist Add/Remove Toggle
    $(document).on('click', '.julias-wishlist-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const $icon = $btn.find('svg');

        if (typeof juliasSettings === 'undefined' || !juliasSettings.ajaxUrl) {
            console.error('Wishlist settings not found.');
            return;
        }

        // Prevent multiple clicks
        if ($btn.hasClass('is-loading')) return;
        $btn.addClass('is-loading opacity-70 pointer-events-none');
        $icon.addClass('animate-pulse');

        $.ajax({
            url: juliasSettings.ajaxUrl,
            type: 'POST',
            data: {
                action: 'toggle_wishlist',
                product_id: productId,
                security: juliasSettings.nonce
            },
            success: function (response) {
                $btn.removeClass('is-loading opacity-70 pointer-events-none');
                $icon.removeClass('animate-pulse');

                if (response.success) {
                    const isAdded = response.data.is_added;
                    
                    // Note: If removing from inside the drawer, we might want to refresh the drawer or just remove the element
                    if ($btn.closest('#wishlist-drawer').length > 0) {
                        $btn.closest('li').fadeOut(300, function() { 
                            $(this).remove(); 
                            // If empty, reload drawer content to show empty state
                            if ($('#wishlist-drawer-items ul li').length === 0) {
                                loadWishlistDrawer();
                            }
                        });
                        showToast('Removed from your wishlist.', 'info');
                    } else {
                        // Regular product card
                        if (isAdded) {
                            $btn.addClass('text-[#FFB7C5]');
                            $icon.attr('fill', 'currentColor');
                            showToast('Added to your wishlist!', 'success');
                        } else {
                            $btn.removeClass('text-[#FFB7C5]');
                            $icon.attr('fill', 'none');
                            showToast('Removed from your wishlist.', 'info');
                        }
                    }

                    // Update all wishlist fragments in header
                    if (response.data.fragment) {
                        $('.julias-wishlist-count').replaceWith(response.data.fragment);
                    }
                } else {
                    showToast(response.data.message || 'Failed to update wishlist.', 'error');
                }
            },
            error: function () {
                $btn.removeClass('is-loading opacity-70 pointer-events-none');
                $icon.removeClass('animate-pulse');
                showToast('Network error occurred.', 'error');
            }
        });
    });

    // 2. Wishlist Drawer Logic
    const $drawer = $('#wishlist-drawer');
    const $drawerContent = $('#wishlist-drawer-content');
    const $drawerItems = $('#wishlist-drawer-items');

    function openWishlistDrawer() {
        $drawer.removeClass('opacity-0 pointer-events-none').addClass('opacity-100 pointer-events-auto');
        $drawerContent.removeClass('translate-x-full').addClass('translate-x-0');
        $('body').addClass('overflow-hidden');
        loadWishlistDrawer();
    }

    function closeWishlistDrawer() {
        $drawer.removeClass('opacity-100 pointer-events-auto').addClass('opacity-0 pointer-events-none');
        $drawerContent.removeClass('translate-x-0').addClass('translate-x-full');
        $('body').removeClass('overflow-hidden');
    }

    function loadWishlistDrawer() {
        $drawerItems.html('<div class="flex flex-col items-center justify-center h-full text-[#FFB7C5]"><svg class="w-8 h-8 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>');

        $.ajax({
            url: juliasSettings.ajaxUrl,
            type: 'POST',
            data: {
                action: 'get_wishlist_content',
                security: juliasSettings.nonce
            },
            success: function (response) {
                if (response.success && response.data.html) {
                    $drawerItems.html(response.data.html);
                }
            }
        });
    }

    $('#wishlist-drawer-open').on('click', function (e) {
        e.preventDefault();
        openWishlistDrawer();
    });

    $('#wishlist-drawer-close').on('click', function (e) {
        e.preventDefault();
        closeWishlistDrawer();
    });

    $('#wishlist-drawer').on('click', function (e) {
        if (e.target === this) {
            closeWishlistDrawer();
        }
    });
};
