import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

export const showToast = (message, type = 'success') => {
  const isSuccess = type === 'success';
  const iconSvg = isSuccess
    ? `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>`
    : `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>`;

  const colorClass = isSuccess ? 'bg-[#FFB7C5]/20 text-[#FFB7C5]' : 'bg-red-500/20 text-red-500';
  const titleText = isSuccess ? 'Success!' : 'Error!';

  const nodeHTML = document.createElement('div');
  nodeHTML.innerHTML = `
        <div class="relative overflow-hidden flex items-center gap-4 bg-white/70 dark:bg-slate-900/50 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 rounded-[24px] p-4 pr-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] dark:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.5)]">
            <div class="absolute -left-6 -top-6 w-24 h-24 ${isSuccess ? 'bg-[#FFB7C5]/30' : 'bg-red-500/20'} blur-2xl rounded-full pointer-events-none"></div>
            <div class="flex items-center justify-center w-11 h-11 ${colorClass} rounded-2xl shrink-0 shadow-sm relative z-10">
                ${iconSvg}
            </div>
            <div class="flex flex-col relative z-10">
                <p class="text-[0.95rem] font-extrabold text-slate-800 dark:text-white tracking-tight leading-tight">${titleText}</p>
                <p class="text-[0.8rem] font-semibold text-slate-500 dark:text-slate-300 mt-0.5">${message}</p>
            </div>
        </div>
    `;

  Toastify({
    text: message,
    duration: 3000,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    className: "premium-glass-toast",
    style: {
      background: "transparent",
      boxShadow: "none",
      padding: "0"
    },
    escapeMarkup: false,
    node: nodeHTML
  }).showToast();
};

window.showToast = showToast;