<?php
/**
 * Hero Carousel Template
 * Dynamic carousel section with Embla Carousel
 * Fetches slides from custom post type "carousel_slide" via database
 */

// Get hero slides from database (custom post type)
$hero_slides = julias_get_carousel_slides();
$carousel_schema = julias_get_carousel_schema_markup($hero_slides);

if (empty($hero_slides)) {
    return;
}
?>

<?php
// Preload the first slide image to improve LCP when available
$first_slide = $hero_slides[0] ?? null;
if (!empty($first_slide) && !empty($first_slide['image']['url'])) {
    printf(
        '<link rel="preload" as="image" href="%s" imagesrcset="%s" imagesizes="%s">',
        esc_url($first_slide['image']['url']),
        esc_attr($first_slide['image']['srcset'] ?? ''),
        esc_attr($first_slide['image']['sizes'] ?? '(min-width:1024px)600px,100vw')
    );
}
?>

<section id="hero-carousel" class="relative bg-gray-50/50 dark:bg-slate-900 transition-colors duration-1000 overflow-hidden" aria-roledescription="carousel" aria-label="Featured hero carousel">
    <div class="embla overflow-hidden relative" tabindex="0" aria-label="Hero carousel viewport" aria-live="off">
        <div class="embla__container flex">
            
            <?php foreach ($hero_slides as $index => $slide) : ?>
            <article class="embla__slide relative flex-[0_0_100%] min-w-0 min-h-[700px] lg:min-h-[85vh] flex items-center" role="group" aria-roledescription="slide" aria-label="Slide <?php echo esc_attr($index + 1); ?> of <?php echo esc_attr(count($hero_slides)); ?>" <?php echo $index === 0 ? '' : 'aria-hidden="true"'; ?>>
                
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
                            
                            <h2 class="font-['Bubblegum_Sans'] text-5xl md:text-6xl lg:text-7xl xl:text-8xl leading-[1.1] text-gray-800 dark:text-gray-100 mb-6 drop-shadow-sm">
                                <?php echo esc_html($slide['title']); ?>
                            </h2>
                            
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
                        <?php
                        $aspect_attr = '';
                        if (!empty($slide['image']['width']) && !empty($slide['image']['height'])) {
                            $aspect_attr = 'style="aspect-ratio: ' . esc_attr((int) $slide['image']['width']) . '/' . esc_attr((int) $slide['image']['height']) . ';"';
                        }
                        ?>
                        <div class="flex-1 relative w-full max-w-[500px] lg:max-w-[600px] mx-auto lg:mr-0 h-[400px] lg:h-[600px]" <?php echo $aspect_attr; ?>>
                            <div class="relative w-full h-full flex items-center justify-center">
                                <!-- Animated Blobs -->
                                <div class="absolute top-[10%] right-[10%] w-40 h-40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob1']); ?>" style="animation-duration: 4s;"></div>
                                <div class="absolute bottom-[10%] left-[10%] w-48 h-48 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob2']); ?>" style="animation-duration: 5s; animation-delay: 1s;"></div>
                                
                                <!-- Image Card -->
                                <div class="absolute inset-4 lg:inset-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-[3rem] p-4 shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] rotate-3 transform hover:rotate-0 hover:scale-[1.02] transition-all duration-500 border border-white/50 dark:border-slate-700/50 overflow-hidden">
                                    <?php if (!empty($slide['image']['id'])) : ?>
                                        <?php
                                        echo wp_get_attachment_image(
                                            $slide['image']['id'],
                                            'large',
                                            false,
                                            [
                                                'class'        => 'w-full h-full object-cover rounded-[2.5rem] transition-transform duration-700',
                                                'alt'          => $slide['image']['alt'],
                                                'loading'      => $index === 0 ? 'eager' : 'lazy',
                                                'fetchpriority' => $index === 0 ? 'high' : 'auto',
                                                'decoding'     => 'async',
                                                'sizes'        => $slide['image']['sizes'] ?: '(min-width: 1024px) 600px, (min-width: 640px) 80vw, 100vw',
                                            ]
                                        );
                                        ?>
                                        <?php if (!empty($slide['sale']['enabled'])) : ?>
                                            <?php
                                            $sale = $slide['sale'];
                                            $sale_label = $sale['label'] ?: 'Flash Sale';
                                            $sale_discount = $sale['discount'] ?: '';
                                            $sale_code = $sale['code'] ?: '';
                                            $sale_link = $sale['link'] ?: '';
                                            ?>
                                            <div class="absolute bottom-6 right-6 z-30 pointer-events-auto transform translate-y-6 opacity-0 animate-slide-up">
                                                <div class="bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-pink-100 dark:border-slate-700/50 max-w-[320px]">
                                                    <div class="text-xs font-bold text-pink-500 uppercase tracking-wide mb-1"><?php echo esc_html($sale_label); ?></div>
                                                    <div class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white leading-tight mb-2"><?php echo esc_html($sale_discount); ?></div>
                                                    <?php if ($sale_code) : ?>
                                                        <div class="inline-flex items-center gap-3 bg-gray-50 dark:bg-slate-700/60 px-3 py-2 rounded-full text-sm font-medium">
                                                            <span class="font-mono tracking-wide text-sm"><?php echo esc_html($sale_code); ?></span>
                                                            <button type="button" class="ml-auto text-xs px-2 py-1 bg-pink-50 text-pink-600 rounded" onclick="(function(e){navigator.clipboard && navigator.clipboard.writeText('<?php echo esc_js($sale_code); ?>'); e.target.innerText = 'Copied'; setTimeout(()=>e.target.innerText='Copy',1200)})(event)">Copy</button>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($sale_link) : ?>
                                                        <div class="mt-3">
                                                            <a href="<?php echo esc_url($sale_link); ?>" class="inline-block text-sm font-bold text-white bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-4 py-2 rounded-full shadow-md">Shop Sale</a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div class="flex h-full w-full items-center justify-center rounded-[2.5rem] bg-gradient-to-br from-pink-100 to-blue-100 text-sm font-bold text-slate-500 dark:from-slate-700 dark:to-slate-600 dark:text-slate-200" aria-hidden="true">
                                            <?php esc_html_e('Slide image unavailable', 'julias-cartoonery'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            
        </div>

        <!-- Carousel Controls: Arrows & Dots -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-6 z-20 bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl px-6 py-4 rounded-full border border-white/60 dark:border-slate-700 shadow-xl" aria-label="Carousel controls">
            <!-- Previous Button -->
            <button 
                type="button"
                class="embla__prev p-2 text-gray-800 dark:text-gray-200 hover:text-[#FFB7C5] dark:hover:text-pink-400 hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/50" 
                aria-label="Previous slide"
                aria-controls="hero-carousel"
            >
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            
            <!-- Dot Pagination -->
            <div class="embla__dots flex items-center gap-3" aria-label="Choose a slide"></div>
            
            <!-- Next Button -->
            <button 
                type="button"
                class="embla__next p-2 text-gray-800 dark:text-gray-200 hover:text-[#FFB7C5] dark:hover:text-pink-400 hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/50" 
                aria-label="Next slide"
                aria-controls="hero-carousel"
            >
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<?php if ($carousel_schema) : ?>
<script type="application/ld+json"><?php echo $carousel_schema; ?></script>
<?php endif; ?>
