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

  // Arrow Navigation Buttons
  const prevBtn = emblaNode.querySelector('.embla__prev');
  const nextBtn = emblaNode.querySelector('.embla__next');

  if (prevBtn && nextBtn) {
    prevBtn.addEventListener('click', () => emblaApi.scrollPrev());
    nextBtn.addEventListener('click', () => emblaApi.scrollNext());
  }

  // Dot Pagination Setup
  const dotsContainer = emblaNode.querySelector('.embla__dots');
  if (!dotsContainer) return;

  const slideNodes = emblaApi.slideNodes();
  const dots = [];

  // Create dots dynamically
  slideNodes.forEach((_, index) => {
    const dot = document.createElement('button');
    dot.className = 'embla__dot transition-all duration-500 rounded-full w-3 h-3 bg-gray-400/30 dark:bg-gray-500/50 hover:bg-gray-600 dark:hover:bg-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';
    dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
    dot.addEventListener('click', () => emblaApi.scrollTo(index));
    dotsContainer.appendChild(dot);
    dots.push(dot);
  });

  // Update dots on slide change
  const updateDots = () => {
    const previous = emblaApi.previousScrollSnap();
    const selected = emblaApi.selectedScrollSnap();

    // Reset previous dot
    dots[previous].className = 'embla__dot transition-all duration-500 rounded-full w-3 h-3 bg-gray-400/30 dark:bg-gray-500/50 hover:bg-gray-600 dark:hover:bg-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';

    // Activate current dot
    dots[selected].className = 'embla__dot transition-all duration-500 rounded-full w-10 h-3 bg-gradient-to-r from-[#FFB7C5] to-[#A8D8EA] dark:from-pink-400 dark:to-sky-400 shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]';
  };

  emblaApi.on('select', updateDots);
  emblaApi.on('init', updateDots);

  // Keyboard Navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') emblaApi.scrollPrev();
    if (e.key === 'ArrowRight') emblaApi.scrollNext();
  });

  return emblaApi;
}
