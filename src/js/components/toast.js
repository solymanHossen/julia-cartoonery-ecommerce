import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

export const showToast = (message, type = 'success') => {
  const duration = 3000;

  const types = {
    success: {
      title: 'Success!',
      bg: 'bg-emerald-500/15 dark:bg-emerald-500/20',
      color: 'text-emerald-600 dark:text-emerald-400',
      border: 'border-emerald-500/30',
      glow: 'bg-emerald-500/30 dark:bg-emerald-500/40',
      progress: 'bg-emerald-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    },
    error: {
      title: 'Error!',
      bg: 'bg-rose-500/15 dark:bg-rose-500/20',
      color: 'text-rose-600 dark:text-rose-400',
      border: 'border-rose-500/30',
      glow: 'bg-rose-500/30 dark:bg-rose-500/40',
      progress: 'bg-rose-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    },
    warning: {
      title: 'Warning!',
      bg: 'bg-amber-500/15 dark:bg-amber-500/20',
      color: 'text-amber-600 dark:text-amber-400',
      border: 'border-amber-500/30',
      glow: 'bg-amber-500/30 dark:bg-amber-500/40',
      progress: 'bg-amber-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`
    },
    info: {
      title: 'Info',
      bg: 'bg-sky-500/15 dark:bg-sky-500/20',
      color: 'text-sky-600 dark:text-sky-400',
      border: 'border-sky-500/30',
      glow: 'bg-sky-500/30 dark:bg-sky-500/40',
      progress: 'bg-sky-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    }
  };

  const config = types[type] || types.success;
  const progressId = `progress-${Math.random().toString(36).substring(2, 9)}`;

  const nodeHTML = document.createElement('div');
  nodeHTML.className = 'group w-full max-w-[340px] pointer-events-auto mt-4';

  nodeHTML.innerHTML = `
        <style>
            @keyframes shrink-${progressId} {
                from { width: 100%; }
                to { width: 0%; }
            }
            .animate-shrink-${progressId} {
                animation: shrink-${progressId} ${duration}ms linear forwards;
            }
            .group:hover .animate-shrink-${progressId} {
                animation-play-state: paused;
            }
            .premium-toast-enter {
                animation: toast-slide-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }
            @keyframes toast-slide-in {
                0% { opacity: 0; transform: translateY(30px) scale(0.9); }
                100% { opacity: 1; transform: translateY(0) scale(1); }
            }
        </style>
        
        <div class="premium-toast-enter relative overflow-hidden flex items-center gap-4 bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl border border-slate-100/80 dark:border-slate-700/80 rounded-[28px] p-4 shadow-[0_10px_40px_-10px_rgba(15,23,42,0.1)] dark:shadow-[0_10px_40px_-10px_rgba(0,0,0,0.5)] transform transition-transform duration-300 hover:-translate-y-1 hover:shadow-[0_15px_50px_-10px_rgba(15,23,42,0.15)] dark:hover:shadow-[0_15px_50px_-10px_rgba(0,0,0,0.6)] cursor-default">
            
            <div class="absolute -left-8 -top-8 w-28 h-28 ${config.glow} blur-[36px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-150"></div>

            <div class="flex items-center justify-center w-11 h-11 ${config.bg} ${config.color} rounded-[16px] shrink-0 shadow-[inset_0_2px_10px_rgba(255,255,255,0.4)] dark:shadow-[inset_0_2px_10px_rgba(255,255,255,0.05)] border border-white/50 dark:border-white/10 relative z-10 overflow-hidden transition-all duration-400 group-hover:rotate-12 group-hover:scale-110">
                <div class="relative z-10">
                    ${config.icon}
                </div>
            </div>

            <div class="flex flex-col relative z-10 w-full pr-6">
                <p class="text-[1rem] font-extrabold text-slate-800 dark:text-slate-100 tracking-tight leading-none mb-1 font-['Bubblegum_Sans',sans-serif]">${config.title}</p>
                <p class="text-[0.8rem] font-semibold text-slate-500 dark:text-slate-400 leading-snug">${message}</p>
            </div>

            <button type="button" class="toast-close-btn absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-colors duration-200 z-20 cursor-pointer focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="absolute bottom-0 left-0 h-[4px] w-full bg-slate-100 dark:bg-slate-700/50 rounded-b-[28px] overflow-hidden">
                <div class="h-full ${config.progress} animate-shrink-${progressId} shadow-[0_0_12px_${config.progress}]"></div>
            </div>
        </div>
    `;

  let toastInstance = Toastify({
    text: message,
    duration: duration,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    className: "premium-glass-toast-wrapper",
    style: {
      background: "transparent",
      boxShadow: "none",
      padding: "0",
      margin: "0 16px 0 0",
      pointerEvents: "none"
    },
    escapeMarkup: false,
    node: nodeHTML
  });

  const closeBtn = nodeHTML.querySelector('.toast-close-btn');
  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      toastInstance.hideToast();
    });
  }

  toastInstance.showToast();
};

window.showToast = showToast;