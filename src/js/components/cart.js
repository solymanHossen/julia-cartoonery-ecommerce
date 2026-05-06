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
}
