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
            <article class="embla__slide relative flex-[0_0_100%] min-w-0 min-h-[520px] sm:min-h-[580px] lg:min-h-[85vh] flex items-center" role="group" aria-roledescription="slide" aria-label="Slide <?php echo esc_attr($index + 1); ?> of <?php echo esc_attr(count($hero_slides)); ?>" <?php echo $index === 0 ? '' : 'aria-hidden="true"'; ?>>
                
                <div class="absolute inset-0 bg-gradient-to-b <?php echo esc_attr($slide['bgClass']); ?> to-transparent"></div>

                <div class="container mx-auto px-4 lg:px-8 relative z-10 pt-8 pb-10 sm:pt-10 sm:pb-12 lg:py-0">
                    <div class="flex flex-col-reverse lg:flex-row items-center gap-4 sm:gap-6 lg:gap-20">
                        
                        <!-- Left: Text Content -->
                        <div class="flex-1 text-center lg:text-left relative flex flex-col justify-center">
                            <div class="mb-4 lg:mb-6">
                                <span class="inline-flex items-center gap-1.5 sm:gap-2 py-1.5 sm:py-2 px-4 sm:px-6 rounded-full bg-white/90 dark:bg-slate-800/90 backdrop-blur-md text-gray-800 dark:text-gray-200 font-bold text-xs sm:text-sm shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/50 dark:border-slate-700">
                                    <svg width="14" height="14" class="sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15 9l7 1-5 5.5L15.5 22 12 18l-3.5 4L10 15.5 5 10l7-1z"/></svg>
                                    <?php echo esc_html($slide['badge']); ?>
                                </span>
                            </div>
                            
                            <h2 class="font-['Bubblegum_Sans'] text-3xl sm:text-4xl md:text-6xl lg:text-7xl xl:text-8xl leading-[1.1] text-gray-800 dark:text-gray-100 mb-3 sm:mb-4 lg:mb-6 drop-shadow-sm">
                                <?php echo esc_html($slide['title']); ?>
                            </h2>
                            
                            <p class="text-sm sm:text-base md:text-xl text-gray-600 dark:text-gray-300 max-w-md sm:max-w-lg mx-auto lg:mx-0 leading-relaxed mb-6 sm:mb-8 lg:mb-10 px-1 sm:px-0">
                                <?php echo esc_html($slide['desc']); ?>
                            </p>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 sm:gap-4 w-full sm:w-auto">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="w-full sm:w-auto text-sm sm:text-base lg:text-lg py-2.5 sm:py-3.5 lg:py-4 px-6 sm:px-8 lg:px-10 bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] text-white rounded-full shadow-xl shadow-pink-500/20 hover:shadow-2xl hover:scale-105 transition-all duration-300 text-center font-bold uppercase tracking-wide">
                                    Shop Now
                                </a>
                                <?php if (!empty($slide['video'])) : ?>
                                    <button type="button" onclick="openVideoModal('<?php echo esc_url($slide['video']); ?>')" class="w-full sm:w-auto text-sm sm:text-base lg:text-lg py-2.5 sm:py-3 px-6 sm:px-8 bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border-2 border-gray-300 dark:border-slate-700 rounded-full hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 flex items-center justify-center gap-2 sm:gap-3 font-bold group shadow-sm hover:shadow-md">
                                        <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#FFB7C5] text-white group-hover:scale-110 group-hover:bg-[#FF93AB] transition-all">
                                            <svg width="13" height="13" class="sm:w-[14px] sm:h-[14px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                        Watch Video
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Right: Hero Image with Blobs -->
                        <?php
                        $aspect_attr = '';
                        if (!empty($slide['image']['width']) && !empty($slide['image']['height'])) {
                            $aspect_attr = 'style="aspect-ratio: ' . esc_attr((int) $slide['image']['width']) . '/' . esc_attr((int) $slide['image']['height']) . ';"';
                        }
                        ?>
                        <div class="flex-1 relative w-full max-w-[360px] sm:max-w-[500px] lg:max-w-[600px] mx-auto lg:mr-0 h-[250px] sm:h-[400px] lg:h-[600px]" <?php echo $aspect_attr; ?>>
                            <div class="relative w-full h-full flex items-center justify-center">
                                <!-- Animated Blobs -->
                                <div class="absolute top-[10%] right-[10%] w-28 h-28 sm:w-40 sm:h-40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob1']); ?>" style="animation-duration: 4s;"></div>
                                <div class="absolute bottom-[10%] left-[10%] w-32 h-32 sm:w-48 sm:h-48 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-pulse shadow-2xl <?php echo esc_attr($slide['blob2']); ?>" style="animation-duration: 5s; animation-delay: 1s;"></div>
                                
                                <!-- Image Card -->
                                <div class="absolute inset-1.5 sm:inset-4 lg:inset-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-[1.5rem] sm:rounded-[3rem] p-2.5 sm:p-4 shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] rotate-2 sm:rotate-3 transform hover:rotate-0 hover:scale-[1.02] transition-all duration-500 border border-white/50 dark:border-slate-700/50 overflow-hidden">
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
                                            <div class="absolute bottom-3 right-3 sm:bottom-6 sm:right-6 z-30 pointer-events-auto animate-[float_6s_ease-in-out_infinite] origin-bottom-right">
                                                <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-xl sm:rounded-2xl p-3 sm:p-4 shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 dark:border-slate-700/50 w-[190px] sm:w-[240px] flex flex-col gap-2 sm:gap-3">
                                                    <!-- Header -->
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <span class="relative flex h-2 w-2">
                                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                              <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                                            </span>
                                                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider"><?php echo esc_html($sale_label); ?></span>
                                                        </div>
                                                        <?php if ($sale_link) : ?>
                                                            <a href="<?php echo esc_url($sale_link); ?>" class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white hover:bg-[#FFB7C5] hover:text-white transition-colors" aria-label="Shop Sale">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Body -->
                                                    <div>
                                                        <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white leading-none tracking-tight mb-1">
                                                            <?php echo esc_html($sale_discount); ?>
                                                        </div>
                                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-snug">Limited time offer. Apply code at checkout.</p>
                                                    </div>

                                                    <!-- Footer / Code -->
                                                    <?php if ($sale_code) : ?>
                                                        <div class="flex items-center justify-between bg-slate-50 dark:bg-slate-800 rounded-lg p-1.5 border border-slate-100 dark:border-slate-700 mt-1">
                                                            <span class="font-mono text-xs font-bold text-slate-800 dark:text-slate-200 px-2"><?php echo esc_html($sale_code); ?></span>
                                                            <button type="button" class="bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-md px-2.5 sm:px-3 py-1.5 text-[10px] font-bold text-slate-700 dark:text-slate-200 hover:bg-[#FFB7C5] hover:text-white hover:border-[#FFB7C5] transition-all shadow-sm flex items-center gap-1" onclick="(function(e){navigator.clipboard && navigator.clipboard.writeText('<?php echo esc_js($sale_code); ?>'); const originalText = e.currentTarget.innerHTML; e.currentTarget.innerHTML = '<svg class=\'w-3 h-3 inline\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Copied'; e.currentTarget.classList.add('bg-green-500', 'text-white', 'border-green-500'); setTimeout(()=>{e.currentTarget.innerHTML=originalText; e.currentTarget.classList.remove('bg-green-500', 'text-white', 'border-green-500');}, 1500)})(event)">
                                                                Copy
                                                            </button>
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
        <div class="absolute bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1 rounded-full border border-white/75 bg-white/90 px-2 py-1.5 sm:px-3 sm:py-2 shadow-[0_8px_24px_rgba(15,23,42,0.1)] backdrop-blur-xl dark:border-slate-700/60 dark:bg-slate-900/72" aria-label="Carousel controls">
            <!-- Previous Button -->
            <button 
                type="button"
                class="embla__prev flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition-all duration-300 hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/60 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white" 
                aria-label="Previous slide"
                aria-controls="hero-carousel"
            >
                <svg width="14" height="14" class="sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            
            <!-- Dot Pagination -->
            <div class="embla__dots flex items-center gap-1" aria-label="Choose a slide"></div>
            
            <!-- Next Button -->
            <button 
                type="button"
                class="embla__next flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition-all duration-300 hover:bg-slate-50 hover:text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFB7C5]/60 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white" 
                aria-label="Next slide"
                aria-controls="hero-carousel"
            >
                <svg width="14" height="14" class="sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<?php if ($carousel_schema) : ?>
<script type="application/ld+json"><?php echo $carousel_schema; ?></script>
<?php endif; ?>

<!-- Video Modal -->
<div id="hero-video-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-sm" onclick="closeVideoModal()"></div>
    <div class="relative w-full max-w-5xl aspect-video mx-4 sm:mx-8 md:mx-12 rounded-2xl overflow-hidden shadow-2xl bg-black transform scale-95 transition-transform duration-300" id="hero-video-container">
        <button type="button" onclick="closeVideoModal()" class="absolute top-4 right-4 sm:-top-12 sm:-right-12 text-white/70 hover:text-white transition-colors p-2 z-10 bg-black/50 sm:bg-transparent rounded-full backdrop-blur-md" aria-label="Close Video">
            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <iframe id="hero-video-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<script>
    function openVideoModal(url) {
        const modal = document.getElementById('hero-video-modal');
        const container = document.getElementById('hero-video-container');
        const iframe = document.getElementById('hero-video-iframe');
        
        // Convert standard YouTube/Vimeo URLs to embed URLs if needed
        let embedUrl = url;
        if (url.includes('youtube.com/watch?v=')) {
            embedUrl = url.replace('watch?v=', 'embed/') + (url.includes('?') ? '&' : '?') + 'autoplay=1';
        } else if (url.includes('youtu.be/')) {
            embedUrl = url.replace('youtu.be/', 'youtube.com/embed/') + '?autoplay=1';
        } else if (url.includes('vimeo.com/')) {
            embedUrl = url.replace('vimeo.com/', 'player.vimeo.com/video/') + '?autoplay=1';
        }

        iframe.src = embedUrl;
        
        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Trigger reflow for transition
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        container.classList.remove('scale-95');
    }

    function closeVideoModal() {
        const modal = document.getElementById('hero-video-modal');
        const container = document.getElementById('hero-video-container');
        const iframe = document.getElementById('hero-video-iframe');
        
        modal.classList.add('opacity-0');
        container.classList.add('scale-95');
        document.body.style.overflow = '';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            iframe.src = ''; // Stop video playback
        }, 300);
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('hero-video-modal');
            if (modal && !modal.classList.contains('hidden')) {
                closeVideoModal();
            }
        }
    });
</script>
