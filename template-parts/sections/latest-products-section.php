<?php
/**
 * Template part for displaying the Latest Products section with modern carousel.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$shop_url = wc_get_page_permalink( 'shop' );

$latest_query = new WP_Query(
    array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
    )
);

if ( ! $latest_query->have_posts() ) {
    wp_reset_postdata();
    return;
}

$products = array();
while ( $latest_query->have_posts() ) {
    $latest_query->the_post();
    $product = wc_get_product( get_the_ID() );
    if ( $product ) {
        $products[] = $product;
    }
}
wp_reset_postdata();

if ( empty( $products ) ) {
    return;
}
?>

<section class="py-16 sm:py-24 bg-gradient-to-br from-white via-[#fcf4f4] to-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[#FF93AB] mb-3">NEW ARRIVALS</p>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">Fresh toys in stock</h2>
                <p class="mt-4 text-base text-slate-600 max-w-xl">Scroll through our newest handpicked toys with a smooth, modern experience.</p>
            </div>
            <div>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] text-white font-black uppercase text-sm rounded-full shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="js-latest-products-carousel relative" aria-roledescription="carousel" aria-label="Latest products" tabindex="0">
            <div class="overflow-hidden rounded-2xl lg:rounded-3xl" id="latest-products-viewport">
                <div class="js-carousel-track -mx-2 sm:-mx-3 flex transition-transform duration-700 ease-out will-change-transform">
                    <?php foreach ( $products as $product ) : ?>
                        <?php
                        $product_id           = $product->get_id();
                        $product_name         = $product->get_name();
                        $product_link         = $product->get_permalink();
                        $product_image_id     = $product->get_image_id();
                        $product_price        = $product->get_price_html();
                        $product_rating       = number_format_i18n( (float) $product->get_average_rating(), 1 );
                        $product_review_count = $product->get_review_count();
                        $is_in_stock          = $product->is_in_stock();
                        $on_sale              = $product->is_on_sale();
                        ?>
                        <article class="js-carousel-slide flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 px-2 sm:px-3">
                            <div class="group/card h-full overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col min-h-[24rem] sm:min-h-[26rem] lg:min-h-[28rem]">
                                <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100 h-56 sm:h-60 lg:h-64">
                                    <a href="<?php echo esc_url( $product_link ); ?>" class="block w-full h-full">
                                        <?php
                                        if ( $product_image_id ) {
                                            echo wp_get_attachment_image( $product_image_id, 'woocommerce_single', false, array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110', 'loading' => 'lazy', 'decoding' => 'async' ) );
                                        } else {
                                            echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Product" class="w-full h-full object-cover" loading="lazy" decoding="async" />';
                                        }
                                        ?>
                                    </a>

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300"></div>

                                    <?php if ( $on_sale ) : ?>
                                        <div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">Sale</div>
                                    <?php endif; ?>

                                    <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 <?php echo $is_in_stock ? 'bg-green-500' : 'bg-red-500'; ?> text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                                        <span class="w-2 h-2 bg-white rounded-full"></span>
                                        <?php echo $is_in_stock ? 'In Stock' : 'Out'; ?>
                                    </div>

                                    <?php if ( $product_rating > 0 ) : ?>
                                        <div class="absolute bottom-3 left-3 flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur rounded-full text-xs font-bold shadow-md">
                                            <span class="text-gray-700"><?php echo esc_html( $product_rating ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-1 flex flex-col justify-between p-4 sm:p-5">
                                    <div>
                                        <a href="<?php echo esc_url( $product_link ); ?>" class="inline-block">
                                            <h3 class="font-bold text-slate-900 line-clamp-2 group-hover/card:text-[#FF93AB] transition-colors duration-300 text-sm sm:text-base">
                                                <?php echo esc_html( $product_name ); ?>
                                            </h3>
                                        </a>
                                        <?php if ( $product_review_count > 0 ) : ?>
                                            <p class="text-xs text-slate-500 mt-1">
                                                <?php echo sprintf( _n( '%d review', '%d reviews', $product_review_count, 'julia-cartoonery' ), $product_review_count ); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-end justify-between gap-3">
                                        <div class="flex items-baseline gap-3">
                                            <?php
                                            $regular_price = $product->get_regular_price();
                                            $sale_price    = $product->get_sale_price();
                                            if ( $on_sale && $sale_price ) :
                                            ?>
                                                <del class="text-sm text-slate-400 line-through whitespace-nowrap" aria-hidden="true"><?php echo wp_kses_post( wc_price( $regular_price ) ); ?></del>
                                                <span class="sr-only"><?php echo esc_html__( 'Original price was:', 'julia-cartoonery' ) . ' ' . wp_strip_all_tags( wc_price( $regular_price ) ); ?></span>
                                                <ins class="text-lg sm:text-xl font-black text-[#FF93AB] whitespace-nowrap" aria-hidden="true"><?php echo wp_kses_post( wc_price( $sale_price ) ); ?></ins>
                                                <span class="sr-only"><?php echo esc_html__( 'Current price is:', 'julia-cartoonery' ) . ' ' . wp_strip_all_tags( wc_price( $sale_price ) ); ?></span>
                                            <?php else : ?>
                                                <span class="text-lg sm:text-xl font-black text-[#FF93AB] whitespace-nowrap" aria-hidden="true"><?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?></span>
                                                <span class="sr-only"><?php echo esc_html__( 'Price is:', 'julia-cartoonery' ) . ' ' . wp_strip_all_tags( wc_price( $product->get_price() ) ); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="custom-premium-cart hidden sm:block">
                                            <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#FFB7C5] text-white font-bold hover:bg-[#FF93AB] transition-all duration-300 shadow-md" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'julia-cartoonery' ), $product_name ) ); ?>">
                                                <span class="sr-only"><?php echo esc_html( sprintf( __( 'Add %s to cart', 'julia-cartoonery' ), $product_name ) ); ?></span>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="button" class="js-carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-6 lg:-translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center" aria-label="Previous products" aria-controls="latest-products-viewport">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button type="button" class="js-carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-6 lg:translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center" aria-label="Next products" aria-controls="latest-products-viewport">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div class="js-carousel-dots mt-8 flex justify-center gap-2" aria-label="Carousel Pagination"></div>
        </div>
    </div>
</section>

<script>
(function () {
    const root = document.querySelector('.js-latest-products-carousel');
    if (!root) return;

    const track = root.querySelector('.js-carousel-track');
    const slides = Array.from(root.querySelectorAll('.js-carousel-slide'));
    const prevBtn = root.querySelector('.js-carousel-prev');
    const nextBtn = root.querySelector('.js-carousel-next');
    const dotsWrap = root.querySelector('.js-carousel-dots');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let index = 0;
    let dots = [];
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    function getItemsPerView() {
        if (window.innerWidth < 640) return 1;
        if (window.innerWidth < 1024) return 2;
        return 4;
    }

    function getMaxIndex() {
        return Math.max(0, slides.length - getItemsPerView());
    }

    function getOffsetPercent() {
        return index * (100 / getItemsPerView());
    }

    function buildDots() {
        dotsWrap.innerHTML = '';
        const pages = getMaxIndex() + 1;
        for (let i = 0; i < pages; i += 1) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'h-2.5 rounded-full transition-all duration-300 w-2.5 bg-slate-300 hover:bg-slate-400';
            dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
            dot.addEventListener('click', function () {
                index = i;
                update();
            });
            dotsWrap.appendChild(dot);
        }
        dots = Array.from(dotsWrap.querySelectorAll('button'));
    }

    function updateButtons() {
        const max = getMaxIndex();
        prevBtn.disabled = index <= 0;
        nextBtn.disabled = index >= max;
        prevBtn.classList.toggle('opacity-40', prevBtn.disabled);
        nextBtn.classList.toggle('opacity-40', nextBtn.disabled);
    }

    function updateDots() {
        dots.forEach(function (dot, dotIndex) {
            const active = dotIndex === index;
            dot.classList.toggle('bg-[#FF93AB]', active);
            dot.classList.toggle('w-8', active);
            dot.classList.toggle('bg-slate-300', !active);
            dot.classList.toggle('w-2.5', !active);
        });
    }

    function update() {
        const max = getMaxIndex();
        if (index > max) index = max;
        if (index < 0) index = 0;

        track.style.transitionDuration = reducedMotion ? '1ms' : '700ms';
        track.style.transform = 'translate3d(-' + getOffsetPercent() + '%, 0, 0)';

        updateButtons();
        updateDots();
    }

    function next() {
        index = Math.min(index + 1, getMaxIndex());
        update();
    }

    function prev() {
        index = Math.max(index - 1, 0);
        update();
    }

    function onPointerDown(event) {
        isDragging = true;
        startX = event.clientX;
        currentX = event.clientX;
    }

    function onPointerMove(event) {
        if (!isDragging) return;
        currentX = event.clientX;
    }

    function onPointerUp() {
        if (!isDragging) return;
        const delta = currentX - startX;
        if (Math.abs(delta) > 50) {
            if (delta < 0) {
                next();
            } else {
                prev();
            }
        }
        isDragging = false;
    }

    prevBtn.addEventListener('click', prev);
    nextBtn.addEventListener('click', next);
    root.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowRight') next();
        if (event.key === 'ArrowLeft') prev();
    });
    track.addEventListener('pointerdown', onPointerDown, { passive: true });
    window.addEventListener('pointermove', onPointerMove, { passive: true });
    window.addEventListener('pointerup', onPointerUp, { passive: true });
    window.addEventListener('resize', function () {
        buildDots();
        update();
    }, { passive: true });

    buildDots();
    update();
})();
</script>