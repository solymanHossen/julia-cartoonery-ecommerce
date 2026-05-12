/**
 * Embla Carousel Component
 * Hero carousel with arrow navigation and dot pagination
 * Follows Julia's Cartoonery component pattern
 */

import EmblaCarousel from 'embla-carousel';

export function initCarousel() {
  const emblaNode = document.querySelector('.embla');
  if (!emblaNode) return; // Exit if no carousel on page

  const options = { loop: true, speed: 8 };
  const emblaApi = EmblaCarousel(emblaNode, options);
  const slideNodes = emblaApi.slideNodes();
  const AUTOPLAY_DELAY = 5000;
  let autoplayTimer = null;

  const startAutoplay = () => {
    if (autoplayTimer || slideNodes.length <= 1) return;

    autoplayTimer = window.setInterval(() => {
      emblaApi.scrollNext();
    }, AUTOPLAY_DELAY);
  };

  const stopAutoplay = () => {
    if (!autoplayTimer) return;

    window.clearInterval(autoplayTimer);
    autoplayTimer = null;
  };

  const resetAutoplay = () => {
    stopAutoplay();
    startAutoplay();
  };

  // Arrow Navigation Buttons
  const prevBtn = emblaNode.querySelector('.embla__prev');
  const nextBtn = emblaNode.querySelector('.embla__next');

  if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => {
      emblaApi.scrollPrev();
      resetAutoplay();
    });
    nextBtn.addEventListener('click', () => {
      emblaApi.scrollNext();
      resetAutoplay();
    });
  }

  // Dot Pagination Setup
  const dotsContainer = emblaNode.querySelector('.embla__dots');
  if (!dotsContainer) return;

  const dots = [];

  // Create dots dynamically
  slideNodes.forEach((_, index) => {
    const dot = document.createElement('button');
    dot.className = 'embla__dot transition-all duration-500 rounded-full w-3 h-3 bg-gray-400/30 dark:bg-gray-500/50 hover:bg-gray-600 dark:hover:bg-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';
    dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
    dot.setAttribute('aria-pressed', 'false');
    dot.addEventListener('click', () => {
      emblaApi.scrollTo(index);
      resetAutoplay();
    });
    dotsContainer.appendChild(dot);
    dots.push(dot);
  });

  const updateSlideA11y = () => {
    const selected = emblaApi.selectedScrollSnap();

    slideNodes.forEach((slideNode, index) => {
      slideNode.setAttribute('aria-hidden', index === selected ? 'false' : 'true');
    });
  };

  // Update dots on slide change
  const updateDots = () => {
    const previous = emblaApi.previousScrollSnap();
    const selected = emblaApi.selectedScrollSnap();

    // Reset previous dot
    dots[previous].className = 'embla__dot transition-all duration-500 rounded-full w-3 h-3 bg-gray-400/30 dark:bg-gray-500/50 hover:bg-gray-600 dark:hover:bg-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';
    dots[previous].setAttribute('aria-pressed', 'false');

    // Activate current dot
    dots[selected].className = 'embla__dot transition-all duration-500 rounded-full w-10 h-3 bg-gradient-to-r from-[#FFB7C5] to-[#A8D8EA] dark:from-pink-400 dark:to-sky-400 shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';
    dots[selected].setAttribute('aria-pressed', 'true');

    updateSlideA11y();
  };

  emblaApi.on('select', updateDots);
  emblaApi.on('init', updateDots);

  emblaNode.addEventListener('mouseenter', stopAutoplay);
  emblaNode.addEventListener('mouseleave', startAutoplay);
  emblaNode.addEventListener('focusin', stopAutoplay);
  emblaNode.addEventListener('focusout', startAutoplay);

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      stopAutoplay();
      return;
    }

    startAutoplay();
  });

  // Keyboard Navigation
  emblaNode.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      emblaApi.scrollPrev();
      resetAutoplay();
    }

    if (e.key === 'ArrowRight') {
      e.preventDefault();
      emblaApi.scrollNext();
      resetAutoplay();
    }
  });

  updateDots();
  startAutoplay();

  return emblaApi;
}
