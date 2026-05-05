<?php
/**
 * The template for displaying product content within loops
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$categories = wc_get_product_category_list( $product->get_id(), ', ' );
?>

<li <?php wc_product_class( 'group h-full list-none', $product ); ?>>
    <!-- Card Container: Compact padding (p-3.5) to prevent it from being too tall -->
    <div class="flex h-full flex-col rounded-[28px] bg-white p-3.5 shadow-[0_4px_20px_rgba(15,23,42,0.04)] transition-all duration-400 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(255,183,197,0.2)] dark:bg-slate-800 dark:border dark:border-slate-700">
        
        <!-- Image & Wishlist Section -->
        <div class="relative mb-3 aspect-square overflow-hidden rounded-[20px] bg-[#F8FAFC] dark:bg-slate-700 transition-colors duration-500 group-hover:bg-[#FFF5F7] dark:group-hover:bg-slate-700/80">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block h-full w-full relative z-10">
                <?php
                if ( $product->get_image_id() ) {
                    echo wp_get_attachment_image(
                        $product->get_image_id(),
                        'woocommerce_thumbnail',
                        false,
                        array(
                            'class' => 'h-full w-full object-cover object-center mix-blend-multiply dark:mix-blend-normal transition-transform duration-700 group-hover:scale-110',
                        )
                    );
                } else {
                    echo wc_placeholder_img( 'woocommerce_thumbnail' );
                }
                ?>
            </a>

            <!-- Native Wishlist Integration Wrapper -->
            <div class="custom-wishlist-ui absolute right-3 top-3 z-20">
                <?php 
                // WooCommerce doesn't have native wishlist. This integrates YITH Wishlist perfectly if installed.
                if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
                    echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                } else {
                    // Fallback to your beautiful UI if plugin is not installed yet
                ?>
                    <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/90 backdrop-blur-md text-slate-400 shadow-sm transition-all hover:text-[#FFB7C5] hover:scale-105" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="Add to wishlist">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" />
                        </svg>
                    </button>
                <?php } ?>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="flex flex-1 flex-col px-1.5 pb-1">
            <!-- Category -->
            <div class="mb-1 text-[0.7rem] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                <?php echo wp_kses_post( $categories ); ?>
            </div>

            <!-- Title -->
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="mb-2 block">
                <h3 class="line-clamp-1 text-[1.1rem] font-extrabold leading-tight text-slate-800 transition-colors duration-300 group-hover:text-[#FFB7C5] dark:text-slate-100">
                    <?php echo esc_html( $product->get_name() ); ?>
                </h3>
            </a>

            <!-- Rating -->
            <div class="mb-3 flex items-center gap-1">
                <svg class="h-3.5 w-3.5 shrink-0 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" />
                </svg>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 mt-0.5">
                    <?php echo esc_html( number_format_i18n( (float) $product->get_average_rating(), 1 ) ); ?>
                </span>
            </div>

            <!-- Price & Native Add to Cart -->
            <div class="mt-auto flex items-end justify-between gap-3 pt-2">
                <div class="custom-price-color text-[1.4rem] font-black text-[#FFB7C5] leading-none drop-shadow-sm">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>

                <!-- 100% Native WooCommerce Cart Wrapper -->
                <div class="custom-premium-cart shrink-0 relative z-20">
                    <?php 
                    // This calls standard WooCommerce Add to Cart logic (AJAX, Variable support, etc.)
                    woocommerce_template_loop_add_to_cart(); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</li>