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
}
