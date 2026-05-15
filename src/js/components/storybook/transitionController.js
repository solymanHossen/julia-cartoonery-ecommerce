const FLIP_DURATION = 760;

function prefersReducedMotion() {
  return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function buildFlipOverlay(direction) {
  const overlay = document.createElement('div');
  overlay.className = `story-book-page-turn story-book-page-turn--${direction}`;
  overlay.dataset.direction = direction;
  overlay.setAttribute('aria-hidden', 'true');
  overlay.innerHTML = `
    <div class="story-book-page-turn__shadow"></div>
    <div class="story-book-page-turn__curl"></div>
    <div class="story-book-page-turn__face story-book-page-turn__face--front"></div>
    <div class="story-book-page-turn__face story-book-page-turn__face--back"></div>
  `;

  return overlay;
}

function getTurnKeyframes(direction) {
  const nextTurn = direction === 'next';
  const rotateMid = nextTurn ? '-94deg' : '94deg';
  const rotateEnd = nextTurn ? '-180deg' : '180deg';
  const translateMid = nextTurn ? '-1.3%' : '1.3%';
  const translateEnd = nextTurn ? '-2.6%' : '2.6%';

  return {
    frame: [
      { transform: 'translateX(0) rotateY(0deg) scale(1)', filter: 'drop-shadow(0 10px 18px rgba(15, 23, 42, 0.08))' },
      { offset: 0.42, transform: `translateX(${translateMid}) rotateY(${rotateMid}) rotateZ(${nextTurn ? '-1.2deg' : '1.2deg'}) scale(0.995)`, filter: 'drop-shadow(0 24px 42px rgba(15, 23, 42, 0.25))' },
      { transform: `translateX(${translateEnd}) rotateY(${rotateEnd}) rotateZ(0deg) scale(0.988)`, filter: 'drop-shadow(0 12px 26px rgba(15, 23, 42, 0.14))' }
    ],
    faceFront: [
      { opacity: 1, transform: 'translateZ(1px)', filter: 'brightness(1) saturate(1)' },
      { offset: 0.42, opacity: 0.94, transform: 'translateZ(1px) scale(0.995)', filter: 'brightness(0.98) saturate(0.98)' },
      { opacity: 0.8, transform: 'translateZ(1px) scale(0.985)', filter: 'brightness(0.94) saturate(0.96)' }
    ],
    faceBack: [
      { opacity: 0.1, transform: 'rotateY(180deg) translateZ(1px)' },
      { offset: 0.42, opacity: 0.5, transform: 'rotateY(180deg) translateZ(1px)' },
      { opacity: 1, transform: 'rotateY(180deg) translateZ(1px)' }
    ],
    shadow: [
      { opacity: 0.08, transform: 'scaleX(0.68) translateX(0)' },
      { offset: 0.42, opacity: 0.34, transform: `scaleX(0.94) translateX(${nextTurn ? '-1.5%' : '1.5%'})` },
      { opacity: 0.12, transform: `scaleX(0.75) translateX(${nextTurn ? '-2.8%' : '2.8%'})` }
    ],
    curl: [
      { opacity: 0, transform: 'translateX(0) skewY(0deg)' },
      { offset: 0.28, opacity: 1, transform: `translateX(${nextTurn ? '-18%' : '18%'}) skewY(${nextTurn ? '-8deg' : '8deg'})` },
      { opacity: 0, transform: `translateX(${nextTurn ? '-44%' : '44%'}) skewY(0deg)` }
    ]
  };
}

function waitForAnimation(animation) {
  if (!animation) {
    return Promise.resolve();
  }

  if (animation.finished) {
    return animation.finished.catch(() => undefined);
  }

  return new Promise((resolve) => {
    animation.onfinish = () => resolve();
    animation.oncancel = () => resolve();
  });
}

export class StoryTransitionController {
  constructor() {
    this.isTransitioning = false;
  }

  async play(reader, direction) {
    if (prefersReducedMotion()) {
      return;
    }

    const stage = reader.querySelector('[data-story-stage]');
    if (!stage) {
      return;
    }

    const overlay = buildFlipOverlay(direction);
    stage.appendChild(overlay);
    reader.classList.add('is-transitioning', `is-transitioning-${direction}`);

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        overlay.classList.add('is-active');
      });
    });

    const { frame, faceFront, faceBack, shadow, curl } = getTurnKeyframes(direction);
    const duration = FLIP_DURATION;

    const frameAnimation = overlay.animate(frame, {
      duration,
      easing: 'cubic-bezier(0.22, 0.75, 0.18, 1)',
      fill: 'forwards'
    });

    const frontFace = overlay.querySelector('.story-book-page-turn__face--front');
    const backFace = overlay.querySelector('.story-book-page-turn__face--back');
    const shadowLayer = overlay.querySelector('.story-book-page-turn__shadow');
    const curlLayer = overlay.querySelector('.story-book-page-turn__curl');

    if (frontFace) {
      frontFace.animate(faceFront, {
        duration,
        easing: 'ease-in-out',
        fill: 'forwards'
      });
    }

    if (backFace) {
      backFace.animate(faceBack, {
        duration,
        easing: 'ease-in-out',
        fill: 'forwards'
      });
    }

    if (shadowLayer) {
      shadowLayer.animate(shadow, {
        duration,
        easing: 'ease-in-out',
        fill: 'forwards'
      });
    }

    if (curlLayer) {
      curlLayer.animate(curl, {
        duration,
        easing: 'ease-in-out',
        fill: 'forwards'
      });
    }

    stage.animate(
      [
        { transform: 'translateZ(0) scale(1)' },
        { offset: 0.35, transform: 'translateZ(0) scale(0.999)' },
        { transform: 'translateZ(0) scale(1)' }
      ],
      {
        duration,
        easing: 'ease-in-out'
      }
    );

    await waitForAnimation(frameAnimation);
  }

  end(reader) {
    reader.classList.remove('is-transitioning', 'is-transitioning-next', 'is-transitioning-prev');
    const overlay = reader.querySelector('.story-book-page-turn');
    if (overlay) {
      overlay.remove();
    }
  }
}
