import { showToast } from './toast.js';

export const initWishlist = ($) => {
    $(document).on('click', '.julias-wishlist-btn', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const $icon = $btn.find('.wishlist-icon');

        if (typeof juliasSettings === 'undefined' || !juliasSettings.ajaxUrl) {
            console.error('Wishlist settings not found.');
            return;
        }

        // Prevent multiple clicks
        if ($btn.hasClass('is-loading')) return;
        $btn.addClass('is-loading opacity-70 pointer-events-none');

        // Add a small bounce animation class during loading
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
                    
                    // Update button styling
                    if (isAdded) {
                        $btn.addClass('text-[#FFB7C5]');
                        $icon.attr('fill', 'currentColor');
                        showToast('Added to your wishlist!', 'success');
                    } else {
                        $btn.removeClass('text-[#FFB7C5]');
                        $icon.attr('fill', 'none');
                        showToast('Removed from your wishlist.', 'info');
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
};
