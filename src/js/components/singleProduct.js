/**
 * Single Product Page — GLightbox + Gallery + Quantity
 */
import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';

export function initSingleProduct($) {
  // Only run on single product pages
  const productPage = document.querySelector('.julias-single-product');
  if (!productPage) return;

  // ==============================
  // 1. GLightbox Initialization
  // ==============================
  const lightbox = GLightbox({
    selector: '.glightbox',
    touchNavigation: true,
    loop: true,
    closeButton: true,
    skin: 'clean',
    zoomable: true,
    draggable: true,
    preload: true,
  });

  // ==============================
  // 2. Thumbnail Gallery Swapping
  // ==============================
  const mainImage     = document.getElementById('julias-main-image');
  const mainLightbox  = document.getElementById('julias-main-lightbox');
  const thumbButtons  = document.querySelectorAll('.julias-thumb-btn');

  thumbButtons.forEach((btn) => {
    btn.addEventListener('click', function () {
      const fullSrc = this.dataset.fullSrc;

      // Swap main image
      if (mainImage && fullSrc) {
        // Fade out, swap, fade in
        mainImage.style.opacity = '0';
        setTimeout(() => {
          mainImage.src    = fullSrc;
          mainImage.srcset = '';
          mainImage.style.opacity = '1';
        }, 200);
      }

      // Update lightbox href
      if (mainLightbox && fullSrc) {
        mainLightbox.href = fullSrc;
      }

      // Update active thumb border
      thumbButtons.forEach((t) => {
        t.classList.remove('border-[#FFB7C5]', 'shadow-[0_0_0_2px_rgba(255,183,197,0.3)]');
        t.classList.add('border-transparent');
      });
      this.classList.remove('border-transparent');
      this.classList.add('border-[#FFB7C5]', 'shadow-[0_0_0_2px_rgba(255,183,197,0.3)]');
    });
  });

  // ==============================
  // 3. Quantity +/- Controls
  // ==============================
  const minusBtn = document.querySelector('.julias-qty-minus');
  const plusBtn  = document.querySelector('.julias-qty-plus');
  const qtyInput = productPage.querySelector('input.qty');

  if (minusBtn && plusBtn && qtyInput) {
    minusBtn.addEventListener('click', () => {
      const current = parseInt(qtyInput.value, 10) || 1;
      const min     = parseInt(qtyInput.min, 10) || 1;
      if (current > min) {
        qtyInput.value = current - 1;
        qtyInput.dispatchEvent(new Event('change'));
      }
    });

    plusBtn.addEventListener('click', () => {
      const current = parseInt(qtyInput.value, 10) || 1;
      const max     = parseInt(qtyInput.max, 10) || Infinity;
      if (current < max) {
        qtyInput.value = current + 1;
        qtyInput.dispatchEvent(new Event('change'));
      }
    });
  }

  // ==============================
  // 4. AJAX Add to Cart (custom toast)
  // ==============================
  const cartForm = productPage.querySelector('form.julias-cart-form');
  if (cartForm) {
    cartForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const submitBtn = cartForm.querySelector('button[name="add-to-cart"]');
      if (!submitBtn) return;

      const productId = submitBtn.value;
      const quantity  = cartForm.querySelector('input.qty')?.value || 1;

      // Disable button during request
      submitBtn.disabled = true;
      const originalHTML = submitBtn.innerHTML;
      submitBtn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Adding...`;

      $.post(
        wc_add_to_cart_params?.wc_ajax_url?.replace('%%endpoint%%', 'add_to_cart') || '/?wc-ajax=add_to_cart',
        {
          product_id: productId,
          quantity: quantity,
        },
        function (response) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalHTML;

          if (response.error) {
            if (window.showToast) window.showToast(response.error, 'error');
            return;
          }

          // Trigger WooCommerce cart fragments refresh
          $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $(submitBtn)]);

          // The toast is already triggered by the 'added_to_cart' listener in app.js
        }
      ).fail(function () {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHTML;
        if (window.showToast) window.showToast('Something went wrong. Please try again.', 'error');
      });
    });
  }
}
