export function initCart($) {

  /**
   * Find the qty input relative to a +/- button.
   * WooCommerce wraps the input inside <div class="quantity">,
   * so we look for a sibling .quantity div and find inside it.
   */
  function findQtyInput($btn) {
    // Try direct sibling first (bare input, no wrapper)
    let $input = $btn.siblings('input.qty');
    // If not found, look inside a sibling .quantity wrapper
    if (!$input.length) {
      $input = $btn.siblings('.quantity').find('input.qty');
    }
    return $input;
  }

  // Delegate qty minus — scoped to cart form only
  $(document.body).on('click', '.woocommerce-cart-form .julias-qty-minus', function () {
    const $btn   = $(this);
    const $input = findQtyInput($btn);
    if (!$input.length) return;

    const current = parseInt($input.val(), 10) || 0;
    const min     = parseInt($input.attr('min'), 10) || 0;

    if (current > min) {
      $input.val(current - 1).trigger('change');
      // Unlock and auto-trigger the WooCommerce update button
      $('[name="update_cart"]').prop('disabled', false).trigger('click');
    }
  });

  // Delegate qty plus — scoped to cart form only
  $(document.body).on('click', '.woocommerce-cart-form .julias-qty-plus', function () {
    const $btn   = $(this);
    const $input = findQtyInput($btn);
    if (!$input.length) return;

    const current = parseInt($input.val(), 10) || 0;
    const max     = parseInt($input.attr('max'), 10);
    const maxVal  = isNaN(max) ? Infinity : max;

    if (current < maxVal) {
      $input.val(current + 1).trigger('change');
      // Unlock and auto-trigger the WooCommerce update button
      $('[name="update_cart"]').prop('disabled', false).trigger('click');
    }
  });

  // Progressive enhancement: AJAX remove from cart (animate item out, then replace cart area)
  $(document.body).on('click', '.woocommerce-cart-form .julias-ajax-remove, .product-remove a.remove', function (e) {
    const $link = $(this);

    // If user has JS disabled, this won't run and the link will work normally.
    e.preventDefault();

    const href = $link.attr('href');
    if (!href) return;

    // Locate cart item node
    const $cartItem = $link.closest('.woocommerce-cart-form__cart-item, .cart_item');

    // Provide immediate visual feedback
    $link.prop('disabled', true).addClass('opacity-60');

    // Animate item collapse for perceived performance
    if ($cartItem.length) {
      $cartItem.css({ transition: 'all 300ms ease', overflow: 'hidden' }).animate({ opacity: 0, height: 0 }, 300);
    }

    // Call the remove URL (WooCommerce remove link). On success fetch current page and swap cart grid.
    $.get(href).done(function () {
      // Fetch updated page HTML and replace main cart grid to reflect new totals/empty state
      $.get(window.location.href).done(function (pageHtml) {
        try {
          const $tmp = $('<div>').html(pageHtml);
          const $newGrid = $tmp.find('.lg\\:grid').first();
          const $oldGrid = $('.lg\\:grid').first();

          if ($newGrid.length && $oldGrid.length) {
            $oldGrid.replaceWith($newGrid);
          } else {
            // Fallback to full reload if selector not found
            window.location.reload();
            return;
          }

          if (window.showToast) window.showToast('Item removed from cart.', 'success');
        } catch (err) {
          // If anything fails, reload to ensure a correct state
          window.location.reload();
        }
      }).fail(function () {
        window.location.reload();
      });
    }).fail(function () {
      // On failure restore item and show error
      if ($cartItem.length) {
        $cartItem.css({ opacity: 1, height: 'auto' });
      }
      if (window.showToast) window.showToast('Unable to remove item. Please try again.', 'error');
      $link.prop('disabled', false).removeClass('opacity-60');
    });
  });
}
