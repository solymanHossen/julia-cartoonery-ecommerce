export function initFlashSale() {
  const section = document.querySelector('.flash-sale-section');
  if (!section) {
    return;
  }

  const deadlineAttr = section.getAttribute('data-sale-deadline');
  const deadline = deadlineAttr ? new Date(deadlineAttr).getTime() : Number.NaN;

  if (!Number.isFinite(deadline)) {
    return;
  }

  const elDays = section.querySelector('[data-timer-unit="days"]');
  const elHours = section.querySelector('[data-timer-unit="hours"]');
  const elMinutes = section.querySelector('[data-timer-unit="minutes"]');
  const elSeconds = section.querySelector('[data-timer-unit="seconds"]');

  if (!elDays || !elHours || !elMinutes || !elSeconds) {
    return;
  }

  const renderRemaining = () => {
    const now = Date.now();
    const distance = Math.max(0, deadline - now);

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    elDays.textContent = String(days).padStart(2, '0');
    elHours.textContent = String(hours).padStart(2, '0');
    elMinutes.textContent = String(minutes).padStart(2, '0');
    elSeconds.textContent = String(seconds).padStart(2, '0');

    if (distance <= 0 && ticker) {
      window.clearInterval(ticker);
    }
  };

  const ticker = window.setInterval(renderRemaining, 1000);
  renderRemaining();
}