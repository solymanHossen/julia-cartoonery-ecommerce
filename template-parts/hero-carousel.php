<?php
/**
 * Hero Carousel Template
 * Dynamic carousel section with Embla Carousel
 * Fetches slides from custom post type "carousel_slide" via database
 */

// Get hero slides from database (custom post type)
$hero_slides = julias_get_carousel_slides();

if (empty($hero_slides)) {
    return;
}
?>

<section class="relative bg-gray-50/50 dark:bg-slate-900 transition-colors duration-1000 overflow-hidden">
    <div class="embla overflow-hidden relative">
        <div class="embla__container flex">
            
            <?php foreach ($hero_slides as $index => $slide) : ?>
            <div class="embla__slide relative flex-[0_0_100%] min-w-0 min-h-[700px] lg:min-h-[85vh] flex items-center">
                
                <div class="absolute inset-0 bg-gradient-to-b <?php echo esc_attr($slide['bgClass']); ?> to-transparent"></div>

                <div class="container mx-auto max-w-7xl px-4 lg:px-8 relative z-10 py-20 lg:py-0">
                    <div class="flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">
                        
                        <!-- Left: Text Content -->
                        <div class="flex-1 text-center lg:text-left relative flex flex-col justify-center">
                            <div class="mb-6">
                                <span class="inline-flex items-center gap-2 py-2 px-6 rounded-full bg-white/90 dark:bg-slate-800/90 backdrop-blur-md text-gray-800 dark:text-gray-200 font-bold text-sm shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/50 dark:border-slate-700">
                                    <svg width="16" height="16" fill="currentColor" class="text-yellow-400" viewBox="0 0 24 24"><path d="M12 2L15 9l7 1-5 5.5L15.5 22 12 18l-3.5 4L10 15.5 5 10l7-1z"/></svg> 
                                    <?php echo esc_html($slide['badge']); ?>
                                </span>
                            </div>
                            
                            <h1 class="font-['Bubblegum_Sans'] text-5xl md:text-6xl lg:text-7xl xl:text-8xl leading-[1.1] text-gray-800 dark:text-gray-100 mb-6 drop-shadow-sm">
                                <?php echo esc_html($slide['title']); ?>
                            </h1>
                            
                            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-lg mx-auto lg:mx-0 leading-relaxed mb-10">
                                <?php echo esc_html($slide['desc']); ?>
                            </p>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 w-full sm:w-auto">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="w-full sm:w-auto text-lg py-4 px-10 bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] text-white rounded-full shadow-xl shadow-pink-500/20 hover:shadow-2xl hover:scale-105 transition-all duration-300 text-center font-bold uppercase tracking-wide">
                                    Shop Now
                                </a>
                                <a href="#" class="w-full sm:w-auto text-lg py-4 px-8 bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border-2 border-gray-300 dark:border-slate-700 rounded-full hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 flex items-center justify-center gap-2 font-bold">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> 
                                    Watch Videos
                                </a>
                            </div>
                        </div>
                        
                        <!-- Right: Hero Image with Blobs -->
                        <div class="flex-1 relative w-full aspect-square max-w-[500px] lg:max-w-[600px] mx-auto lg:mr-0 h-[400px] lg:h-[600px]">
                            <div class="relative w-full h-full flex items-center justify-center">
                                <!-- Animated Blobs -->
                                <div class="absolute top-[10%] right-[10%] w-40 h-40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob1']); ?>" style="animation-duration: 4s;"></div>
                                <div class="absolute bottom-[10%] left-[10%] w-48 h-48 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob2']); ?>" style="animation-duration: 5s; animation-delay: 1s;"></div>
                                
                                <!-- Image Card -->
                                <div class="absolute inset-4 lg:inset-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-[3rem] p-4 shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] rotate-3 transform hover:rotate-0 hover:scale-[1.02] transition-all duration-500 border border-white/50 dark:border-slate-700/50 overflow-hidden">
                                    <img 
                                        src="<?php echo esc_url($slide['img']); ?>" 
                                        alt="<?php echo esc_attr($slide['title']); ?>" 
                                        class="w-full h-full object-cover rounded-[2.5rem] transition-transform duration-700"
                                    />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
        </div>

        <!-- Carousel Controls: Arrows & Dots -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-6 z-20 bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl px-6 py-4 rounded-full border border-white/60 dark:border-slate-700 shadow-xl">
            <!-- Previous Button -->
            <button 
                class="embla__prev p-2 text-gray-800 dark:text-gray-200 hover:text-[#FFB7C5] dark:hover:text-pink-400 hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/50" 
                aria-label="Previous slide"
            >
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            
            <!-- Dot Pagination -->
            <div class="embla__dots flex items-center gap-3"></div>
            
            <!-- Next Button -->
            <button 
                class="embla__next p-2 text-gray-800 dark:text-gray-200 hover:text-[#FFB7C5] dark:hover:text-pink-400 hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/50" 
                aria-label="Next slide"
            >
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
    </div>
</section>
