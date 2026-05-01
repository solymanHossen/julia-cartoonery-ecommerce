<?php
/**
 * The template for displaying Characters Archive
 */
get_header(); ?>

<style>
    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes pulse-soft {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
    }

    .animate-pulse-soft {
        animation: pulse-soft 3s infinite;
    }

    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }
</style>

<main
    class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-pink-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-16 lg:py-24 relative overflow-hidden">

    <!-- Decorative background elements -->
    <div
        class="absolute top-20 left-10 w-64 h-64 bg-pink-300/20 dark:bg-pink-900/20 rounded-full blur-3xl pointer-events-none">
    </div>
    <div
        class="absolute bottom-20 right-10 w-80 h-80 bg-blue-300/20 dark:bg-blue-900/20 rounded-full blur-3xl pointer-events-none">
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">

        <!-- Header Section -->
        <div
            class="text-center mb-12 sm:mb-16 max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-8 duration-700">
            <span
                class="inline-block py-1 px-4 rounded-full bg-pink-100 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400 text-xs sm:text-sm font-bold tracking-widest uppercase mb-4 sm:mb-6 shadow-sm border border-pink-200 dark:border-pink-800">Free
                Goodies</span>
            <h1
                class="font-['Bubblegum_Sans'] text-5xl md:text-6xl lg:text-7xl text-slate-800 dark:text-white mb-4 sm:mb-6 drop-shadow-sm leading-tight">
                Meet the Characters</h1>
            <p class="text-base sm:text-lg lg:text-xl text-slate-600 dark:text-slate-300 px-4 sm:px-0">Download
                high-quality coloring pages and vector art of your favorite friends! Perfect for kids and kids at heart.
            </p>
        </div>

        <!-- Characters Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10 max-w-6xl mx-auto">
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>

                    <div
                        class="group relative flex flex-col items-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-[40px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-white/50 dark:border-slate-700/50 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] dark:hover:shadow-[0_20px_40px_rgb(0,0,0,0.3)] transition-all duration-300 ease-out">

                        <!-- Decorative blob behind image -->
                        <div
                            class="absolute top-8 w-48 h-48 bg-gradient-to-tr from-blue-200 to-pink-200 dark:from-blue-600/30 dark:to-pink-600/30 rounded-full blur-2xl opacity-50 group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <!-- Character Image -->
                        <div
                            class="relative w-48 h-48 rounded-full overflow-hidden border-[6px] border-white dark:border-slate-700 shadow-xl mb-8 bg-slate-50 dark:bg-slate-800 z-10 group-hover:rotate-3 transition-transform duration-300">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                            <?php else: ?>
                                <div
                                    class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h3 class="font-['Bubblegum_Sans'] text-3xl text-slate-800 dark:text-white mb-2 z-10 tracking-wide">
                            <?php the_title(); ?></h3>
                        <div
                            class="w-12 h-1 bg-pink-400 rounded-full mb-6 z-10 opacity-50 group-hover:w-20 transition-all duration-300">
                        </div>

                        <!-- Download Button (Triggers Modal) -->
                        <button
                            class="char-download-btn w-full px-6 py-4 bg-slate-50 dark:bg-slate-900/50 hover:bg-pink-50 dark:hover:bg-pink-900/20 border-2 border-slate-100 dark:border-slate-700 hover:border-pink-200 dark:hover:border-pink-800 text-slate-700 dark:text-slate-200 hover:text-pink-600 dark:hover:text-pink-400 rounded-2xl font-bold transition-all duration-300 flex items-center justify-center gap-3 z-10 group/btn"
                            data-char-name="<?php echo esc_attr(get_the_title()); ?>"
                            data-download-url="<?php echo esc_url(get_permalink()); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                class="group-hover/btn:-translate-y-1 transition-transform duration-300">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" x2="12" y1="15" y2="3" />
                            </svg>
                            <span>Download Free</span>
                        </button>
                    </div>

                <?php endwhile; else: ?>
                <div
                    class="col-span-full py-20 text-center bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm rounded-[40px] border border-slate-200 dark:border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="mx-auto mb-4 text-slate-400">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m15 9-6 6" />
                        <path d="m9 9 6 6" />
                    </svg>
                    <h3 class="text-2xl font-['Bubblegum_Sans'] text-slate-700 dark:text-slate-300 mb-2">No characters yet!
                    </h3>
                    <p class="text-slate-500">Check back later for awesome downloads.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- SUBSCRIPTION MODAL                             -->
    <!-- ============================================== -->
    <div id="subModal"
        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-500 ease-out p-4 sm:p-6">
        <!-- Backdrop -->
        <div id="modalBackdrop"
            class="absolute inset-0 bg-slate-900/60 dark:bg-slate-900/80 backdrop-blur-md transition-opacity duration-500">
        </div>

        <!-- Modal Content -->
        <div id="modalContent"
            class="relative bg-white dark:bg-slate-800 p-8 sm:p-12 rounded-[2.5rem] shadow-2xl max-w-lg w-full transform scale-90 translate-y-8 transition-all duration-500 ease-out border border-white/20">

            <!-- Close Button -->
            <button id="closeModalBtn"
                class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-full transition-colors z-10 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:focus:ring-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" x2="6" y1="6" y2="18" />
                    <line x1="6" x2="18" y1="6" y2="18" />
                </svg>
            </button>

            <div class="text-center relative z-0">
                <!-- Icon container with animated background -->
                <div class="relative w-24 h-24 mx-auto mb-8">
                    <div class="absolute inset-0 bg-red-100 dark:bg-red-900/40 rounded-full animate-pulse-soft"></div>
                    <div
                        class="absolute inset-2 bg-red-50 dark:bg-red-800/50 rounded-full flex items-center justify-center border border-red-100 dark:border-red-700/50 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-red-500 dark:text-red-400 translate-x-0.5">
                            <path
                                d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                            <path d="m10 15 5-3-5-3z" />
                        </svg>
                    </div>
                </div>

                <h2
                    class="font-['Bubblegum_Sans'] text-4xl sm:text-5xl text-slate-800 dark:text-white mb-4 tracking-wide">
                    Subscriber Exclusive!</h2>
                <p class="text-slate-600 dark:text-slate-300 mb-8 leading-relaxed text-base sm:text-lg px-2 sm:px-6">
                    To download <strong id="dynamicCharName"
                        class="text-slate-900 dark:text-white font-bold bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded-md">Character</strong>,
                    please subscribe to Julia's Cartoonery on YouTube. It's free and helps us make more cartoons!
                </p>

                <!-- Action Buttons Area -->
                <div id="modalActionArea" class="space-y-4">
                    <button onclick="window.open('https://youtube.com', '_blank')"
                        class="group relative w-full overflow-hidden rounded-2xl bg-[#ef4444] hover:bg-[#dc2626] text-white font-bold text-lg py-4 px-6 transition-all shadow-[0_8px_20px_rgba(239,68,68,0.3)] hover:shadow-[0_8px_25px_rgba(239,68,68,0.4)] hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        <div
                            class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                        </div>
                        <span class="relative flex items-center justify-center gap-2">
                            1. Subscribe to Channel
                        </span>
                    </button>

                    <button id="verifyBtn"
                        class="w-full bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white font-bold text-lg py-4 px-6 rounded-2xl transition-all shadow-[0_8px_20px_rgba(30,41,59,0.2)] hover:shadow-[0_8px_25px_rgba(30,41,59,0.3)] hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none focus:outline-none focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-800">
                        <span id="verifyBtnContent" class="flex items-center justify-center gap-2">
                            2. I've Subscribed - Verify & Download
                        </span>
                    </button>
                </div>

                <!-- Success Message Area -->
                <div id="modalSuccessArea" class="hidden overflow-hidden">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 p-6 rounded-2xl flex flex-col items-center justify-center gap-3 font-bold animate-in zoom-in duration-300 shadow-inner">
                        <div
                            class="w-12 h-12 bg-emerald-100 dark:bg-emerald-800/50 rounded-full flex items-center justify-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-emerald-500 animate-[bounce_1s_ease-in-out_infinite]">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <path d="m9 11 3 3L22 4" />
                            </svg>
                        </div>
                        <span class="text-lg">Verified! Downloading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toastNotification"
        class="fixed bottom-8 right-8 bg-slate-800 dark:bg-white text-white dark:text-slate-900 px-6 py-4 rounded-2xl shadow-2xl font-bold flex items-center gap-4 transform translate-y-24 opacity-0 transition-all duration-500 z-50 border border-slate-700 dark:border-white/20">
        <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <path d="m9 11 3 3L22 4" />
            </svg>
        </div>
        <div class="flex flex-col">
            <span class="text-sm text-slate-300 dark:text-slate-500 font-medium leading-none mb-1">Success</span>
            <span id="toastMsg" class="leading-none text-base">Download started!</span>
        </div>
    </div>

</main>



<?php get_footer(); ?>