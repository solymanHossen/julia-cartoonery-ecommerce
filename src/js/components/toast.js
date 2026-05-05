import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

export const showToast = (message, type = 'success') => {
  const duration = 3000;
  
  const types = {
    success: {
      title: 'Success!',
      bg: 'bg-[#FFB7C5]/10',
      color: 'text-[#FFB7C5]',
      border: 'border-[#FFB7C5]/30',
      glow: 'bg-[#FFB7C5]/40',
      progress: 'bg-[#FFB7C5]',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    },
    error: {
      title: 'Error!',
      bg: 'bg-red-500/10',
      color: 'text-red-500',
      border: 'border-red-500/30',
      glow: 'bg-red-500/40',
      progress: 'bg-red-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    },
    warning: {
      title: 'Warning!',
      bg: 'bg-amber-500/10',
      color: 'text-amber-500',
      border: 'border-amber-500/30',
      glow: 'bg-amber-500/40',
      progress: 'bg-amber-500',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`
    },
    info: {
      title: 'Info',
      bg: 'bg-[#A8D8EA]/10',
      color: 'text-[#A8D8EA]',
      border: 'border-[#A8D8EA]/30',
      glow: 'bg-[#A8D8EA]/40',
      progress: 'bg-[#A8D8EA]',
      icon: `<svg class="w-5 h-5 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`
    }
  };

  const config = types[type] || types.success;
  
  // Unique ID for the animation keyframes to prevent conflicts
  const progressId = `progress-${Math.random().toString(36).substring(2, 9)}`;

  const nodeHTML = document.createElement('div');
  // Pointer-events-auto so we can interact with our custom HTML, while the wrapper is pointer-events-none
  nodeHTML.className = 'group w-full max-w-sm pointer-events-auto'; 
  
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
                animation: toast-slide-in 0.4s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            }
            @keyframes toast-slide-in {
                0% { opacity: 0; transform: translateX(50px) scale(0.9); }
                100% { opacity: 1; transform: translateX(0) scale(1); }
            }
        </style>
        
        <div class="premium-toast-enter relative overflow-hidden flex items-start gap-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-3xl border border-white/60 dark:border-slate-700/50 rounded-[24px] p-4 pr-12 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.7)] transform transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] dark:hover:shadow-[0_25px_50px_-12px_rgba(0,0,0,0.9)] cursor-default">
            
            <!-- Dynamic Glowing Blobs -->
            <div class="absolute -left-10 -top-10 w-32 h-32 ${config.glow} blur-[40px] rounded-full pointer-events-none transition-transform duration-1000 group-hover:scale-[1.5]"></div>
            <div class="absolute -right-10 -bottom-10 w-32 h-32 ${config.glow} opacity-60 blur-[40px] rounded-full pointer-events-none transition-transform duration-1000 group-hover:scale-[1.5]"></div>

            <!-- Icon Container with inner glow and hover spin -->
            <div class="flex items-center justify-center w-12 h-12 ${config.bg} ${config.color} rounded-[18px] shrink-0 shadow-inner border border-white/40 dark:border-white/10 relative z-10 overflow-hidden transition-all duration-300 group-hover:rotate-[15deg] group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-br from-white/50 to-transparent dark:from-white/20 dark:to-transparent opacity-60"></div>
                <div class="relative z-10 animate-[pulse_3s_ease-in-out_infinite]">
                    ${config.icon}
                </div>
            </div>

            <!-- Text Content -->
            <div class="flex flex-col relative z-10 pt-1 w-full">
                <p class="text-[1.05rem] font-bold text-slate-800 dark:text-white tracking-tight leading-tight mb-1 font-['Bubblegum_Sans',sans-serif]">${config.title}</p>
                <p class="text-[0.85rem] font-medium text-slate-600 dark:text-slate-300 leading-snug break-words pr-2">${message}</p>
            </div>

            <!-- Close Button -->
            <button type="button" class="toast-close-btn absolute top-3 right-3 text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 bg-transparent hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full p-1.5 transition-colors duration-200 z-20 cursor-pointer focus:outline-none focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <!-- Progress Bar -->
            <div class="absolute bottom-0 left-0 h-1.5 w-full bg-slate-100 dark:bg-slate-800/50 rounded-b-[24px] overflow-hidden">
                <div class="h-full ${config.progress} animate-shrink-${progressId} rounded-bl-[24px] shadow-[0_0_10px_rgba(0,0,0,0.2)]"></div>
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
      margin: "0 0 16px 0",
      pointerEvents: "none" // The wrapper doesn't block clicks, the inner content does
    },
    escapeMarkup: false,
    node: nodeHTML
  });
  
  // Attach close event
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