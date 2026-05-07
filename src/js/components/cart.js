export function initCart($) {

  // Debounce for plus/minus to prevent rapid-fire requests
  const debounceMap = {};
  function debounce(key, fn, delay = 300) {
    if (debounceMap[key]) clearTimeout(debounceMap[key]);
    debounceMap[key] = setTimeout(fn, delay);
  }

  // ============================================
  // COUPON APPLY HANDLER (Separate from cart update)
  // ============================================
  $(document.body).on('click', 'button[name="apply_coupon"]', function (e) {
    e.preventDefault();
    
    const $btn = $(this);
    const $input = $btn.closest('.coupon').find('input[name="coupon_code"]');
    const couponCode = $input.val().trim();

    // Validation: ensure coupon code is not empty
    if (!couponCode) {
      if (window.showToast) {
        window.showToast('Please enter a coupon code.', 'warning');
      }
      $input.focus();
      return;
    }

    // Show loading state
    $btn.prop('disabled', true).addClass('opacity-60');
    const originalText = $btn.text();
    $btn.html('<span class="inline-flex items-center gap-2"><span class="w-3 h-3 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>Applying...</span>');

    // Get form for data (to include nonce)
    const $form = $btn.closest('form.woocommerce-cart-form');
    let postData = $form.serialize() + '&apply_coupon=1&coupon_code=' + encodeURIComponent(couponCode);

    // Send AJAX request to apply coupon
    $.post($form.attr('action') || window.location.href, postData).done(function (respHtml) {
      try {
        const $tmp = $('<div>').html(respHtml);
        
        // Check for error messages in WooCommerce response
        const $messages = $tmp.find('.woocommerce-message, .woocommerce-error, .woocommerce-info');
        let hasError = false;
        let errorMsg = '';

        if ($messages.length) {
          $messages.each(function () {
            const $msg = $(this);
            const msgText = $msg.text().trim();
            
            if ($msg.hasClass('woocommerce-error')) {
              hasError = true;
              errorMsg = msgText;
            } else if (msgText.toLowerCase().includes('coupon') || msgText.toLowerCase().includes('invalid')) {
              hasError = true;
              errorMsg = msgText;
            }
          });
        }

        // Update cart grid to reflect new totals with coupon applied
        const $newGrid = $tmp.find('#julias-cart-grid').first();
        const $oldGrid = $('#julias-cart-grid').first();

        if ($newGrid.length && $oldGrid.length) {
          $oldGrid.replaceWith($newGrid);
          
          // Show success message
          if (!hasError) {
            if (window.showToast) {
              window.showToast('Coupon applied successfully!', 'success');
            }
            // Clear input after successful application
            $input.val('');
          } else {
            if (window.showToast) {
              window.showToast(errorMsg || 'Unable to apply coupon. Please check the code and try again.', 'error');
            }
          }

          // Update header cart count if present
          const $newCount = $tmp.find('span.julias-cart-count').first();
          const $oldCount = $('span.julias-cart-count').first();
          if ($newCount.length && $oldCount.length) {
            $oldCount.replaceWith($newCount);
          }
        } else {
          // Fallback: reload page if elements not found
          window.location.reload();
        }
      } catch (err) {
        console.error('Error processing coupon response:', err);
        window.location.reload();
      }
    }).fail(function () {
      if (window.showToast) {
        window.showToast('Unable to apply coupon. Please try again.', 'error');
      }
    }).always(function () {
      // Restore button state
      $btn.prop('disabled', false).removeClass('opacity-60').text(originalText);
    });
  });

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
      // Debounce the form submission to prevent rapid updates
      debounce('qty-update', function () {
        const $form = $btn.closest('form.woocommerce-cart-form');
        if ($form.length && !$form.data('updating')) {
          $form.trigger('submit');
        } else {
          // Fallback: click update button
          $('[name="update_cart"]').prop('disabled', false).trigger('click');
        }
      });
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
      // Debounce the form submission to prevent rapid updates
      debounce('qty-update', function () {
        const $form = $btn.closest('form.woocommerce-cart-form');
        if ($form.length && !$form.data('updating')) {
          $form.trigger('submit');
        } else {
          // Fallback: click update button
          $('[name="update_cart"]').prop('disabled', false).trigger('click');
        }
      });
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
          const $newGrid = $tmp.find('#julias-cart-grid').first();
          const $oldGrid = $('#julias-cart-grid').first();

          if ($newGrid.length && $oldGrid.length) {
            $oldGrid.replaceWith($newGrid);
            // Also update header cart count fragment if present
            const $newCount = $tmp.find('span.julias-cart-count').first();
            const $oldCount = $('span.julias-cart-count').first();
            if ($newCount.length && $oldCount.length) {
              $oldCount.replaceWith($newCount);
            }
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

  // AJAX submit for cart form to update quantities without full page reload
  $(document.body).on('submit', 'form.woocommerce-cart-form', function (e) {
    const $form = $(this);

    // Check if this is a coupon submission - if so, skip (handled separately above)
    if (e.originalEvent && $(e.originalEvent.submitter).attr('name') === 'apply_coupon') {
      return; // Let the button click handler take over
    }

    // Prevent default full-page submit
    e.preventDefault();

    // Avoid concurrent updates
    if ($form.data('updating')) return;
    $form.data('updating', true);

    const action = $form.attr('action') || window.location.href;

    // Disable submit buttons and qty controls to prevent double submits
    const $submitButtons = $form.find('button[type="submit"], input[type="submit"]');
    const $qtyButtons = $form.find('.julias-qty-minus, .julias-qty-plus');
    $submitButtons.prop('disabled', true);
    $qtyButtons.prop('disabled', true);

    // Ensure WooCommerce sees an update request
    const postData = $form.serialize() + '&update_cart=1';

    $.post(action, postData).done(function (respHtml) {
      try {
        const $tmp = $('<div>').html(respHtml);
        const $newGrid = $tmp.find('#julias-cart-grid').first();
        const $oldGrid = $('#julias-cart-grid').first();

        if ($newGrid.length && $oldGrid.length) {
          $oldGrid.replaceWith($newGrid);
          // Also update header cart count fragment if present
          const $newCount = $tmp.find('span.julias-cart-count').first();
          const $oldCount = $('span.julias-cart-count').first();
          if ($newCount.length && $oldCount.length) {
            $oldCount.replaceWith($newCount);
          }
          if (window.showToast) window.showToast('Cart updated.', 'success');
        } else {
          // Fallback: reload the page to ensure correct state
          window.location.reload();
        }
      } catch (err) {
        window.location.reload();
      }
    }).fail(function () {
      if (window.showToast) window.showToast('Unable to update cart. Please try again.', 'error');
    }).always(function () {
      $submitButtons.prop('disabled', false);
      $qtyButtons.prop('disabled', false);
      $form.data('updating', false);
    });
  });
}
