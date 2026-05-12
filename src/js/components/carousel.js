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
    updateDynamicVideo(selected);
  };

  // --- Dynamic Video Integration ---
  const videoStage = document.getElementById('julia-dynamic-video-stage');
  const videoPlayer = document.getElementById('julia-dynamic-video-player');
  const videoOverlay = document.getElementById('julia-video-overlay');
  const videoPlayBtn = document.getElementById('julia-dynamic-video-play');
  
  let defaultVideoUrl = '';
  let defaultIsYoutube = false;
  let defaultYoutubeId = '';

  if (videoStage) {
    defaultVideoUrl = videoStage.getAttribute('data-default-video') || '';
    defaultIsYoutube = videoStage.getAttribute('data-default-is-youtube') === 'true';
    defaultYoutubeId = videoStage.getAttribute('data-default-youtube-id') || '';
  }

  const getYoutubeId = (url) => {
    const match = url.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i);
    return match ? match[1] : null;
  };

  const buildVideoHtml = (url, isYoutube, ytId) => {
    if (!url) {
      return `<div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 opacity-80">
                <svg class="h-[72px] w-[72px] text-white/50" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
              </div>`;
    }
    if (isYoutube && ytId) {
      return `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${ytId}?autoplay=0&controls=1&rel=0&enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute inset-0 h-full w-full z-10 transition-opacity duration-500"></iframe>`;
    }
    return `<video controls class="absolute inset-0 h-full w-full object-cover z-10 bg-black transition-opacity duration-500">
              <source src="${url}" type="video/mp4">
            </video>`;
  };

  const updateDynamicVideo = (selectedIndex) => {
    if (!videoStage || !videoPlayer) return;

    const currentSlide = slideNodes[selectedIndex];
    const productVideoUrl = currentSlide ? currentSlide.getAttribute('data-video-url') : '';
    
    let targetUrl = productVideoUrl;
    let targetIsYoutube = false;
    let targetYtId = null;

    if (targetUrl) {
      targetYtId = getYoutubeId(targetUrl);
      targetIsYoutube = !!targetYtId;
    } else {
      // Fallback to default
      targetUrl = defaultVideoUrl;
      targetIsYoutube = defaultIsYoutube;
      targetYtId = defaultYoutubeId;
    }

    // Only update if it's different from what might already be there
    const currentIframe = videoPlayer.querySelector('iframe');
    const currentVideo = videoPlayer.querySelector('video');
    const hasCurrentIframe = !!currentIframe;
    const hasCurrentVideo = !!currentVideo;

    let needsUpdate = false;
    if (targetUrl) {
      if (targetIsYoutube && (!hasCurrentIframe || !currentIframe.src.includes(targetYtId))) needsUpdate = true;
      if (!targetIsYoutube && (!hasCurrentVideo || !currentVideo.querySelector('source').src.includes(targetUrl))) needsUpdate = true;
    } else {
      if (hasCurrentIframe || hasCurrentVideo) needsUpdate = true;
    }

    if (needsUpdate) {
      videoPlayer.style.opacity = 0;
      setTimeout(() => {
        videoPlayer.innerHTML = buildVideoHtml(targetUrl, targetIsYoutube, targetYtId);
        videoPlayer.style.opacity = 1;
        
        if (videoOverlay) {
          if (targetUrl) {
            videoOverlay.classList.remove('hidden');
            videoOverlay.style.opacity = 1;
          } else {
            videoOverlay.classList.add('hidden');
          }
        }
      }, 300); // Wait for fade out
    } else {
      // Just make sure overlay is correct
      if (videoOverlay) {
         if (targetUrl) {
            videoOverlay.classList.remove('hidden');
            videoOverlay.style.opacity = 1;
         } else {
            videoOverlay.classList.add('hidden');
         }
      }
    }
  };

  // Play button logic
  if (videoOverlay && videoPlayBtn) {
    const playVideo = () => {
      videoOverlay.style.opacity = 0;
      setTimeout(() => videoOverlay.classList.add('hidden'), 300);
      
      const iframe = videoPlayer.querySelector('iframe');
      if (iframe) {
        iframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
      } else {
        const video = videoPlayer.querySelector('video');
        if (video) video.play();
      }
    };
    
    videoPlayBtn.addEventListener('click', playVideo);
    videoOverlay.addEventListener('click', (e) => {
      if (e.target === videoOverlay) playVideo();
    });
  }

  // Handle clicking on slides directly
  slideNodes.forEach((slideNode, index) => {
    slideNode.addEventListener('click', (e) => {
      // Don't interfere if they clicked the 'Details' or 'Add to Cart' buttons
      if (e.target.closest('a')) return;
      
      emblaApi.scrollTo(index);
      resetAutoplay();
      
      // If mobile layout, maybe we want to scroll to the video stage?
      if (window.innerWidth < 1024 && videoStage && slideNode.getAttribute('data-video-url')) {
        videoStage.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  });

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
