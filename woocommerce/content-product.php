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
    <!-- Card Container -->
    <div class="flex h-full flex-col rounded-[20px] bg-white p-3 sm:p-4 shadow-[0_8px_32px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(255,183,197,0.2)] dark:bg-slate-800 dark:shadow-[0_8px_32px_rgba(0,0,0,0.3)] dark:hover:shadow-[0_16px_48px_rgba(255,183,197,0.15)] border border-slate-50/50 dark:border-slate-700/50">
        
        <!-- Image & Wishlist Section -->
        <div class="relative mb-3 overflow-hidden rounded-2xl bg-slate-50 dark:bg-slate-700 aspect-square w-full">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block h-full w-full relative z-10">
                <?php
                if ( $product->get_image_id() ) {
                    echo wp_get_attachment_image(
                        $product->get_image_id(),
                        'woocommerce_thumbnail',
                        false,
                        array(
                            'class'    => 'h-full w-full object-cover object-center mix-blend-multiply dark:mix-blend-normal transition-transform duration-700 group-hover:scale-105',
                            'loading'  => 'lazy',
                            'decoding' => 'async',
                        )
                    );
                } else {
                    echo wc_placeholder_img( 'woocommerce_thumbnail' );
                }
                ?>
            </a>

            <!-- Stock Status Badge -->
            <?php if ( ! $product->is_in_stock() ) : ?>
                <div class="absolute left-3 top-3 z-20">
                    <span class="inline-block bg-gradient-to-r from-red-500 to-red-600 text-white px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider shadow-[0_4px_12px_rgba(239,68,68,0.4)]">
                        Out of Stock
                    </span>
                </div>
            <?php elseif ( $product->get_stock_quantity() > 0 && $product->get_stock_quantity() < 5 ) : ?>
                <div class="absolute left-3 top-3 z-20">
                    <span class="inline-block bg-gradient-to-r from-orange-400 to-orange-500 text-white px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider shadow-[0_4px_12px_rgba(251,146,60,0.4)]">
                        Only <?php echo esc_html( (int) $product->get_stock_quantity() ); ?> left
                    </span>
                </div>
            <?php endif; ?>

            <!-- Custom Native Wishlist Button -->
            <div class="absolute right-3 top-3 z-20">
                <?php 
                $wishlist = function_exists('julias_get_wishlist') ? julias_get_wishlist() : [];
                $product_id = $product->get_id();
                $is_in_wishlist = in_array($product_id, $wishlist);
                ?>
                <button type="button" class="julias-wishlist-btn inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/95 backdrop-blur-xl text-slate-300 shadow-[0_4px_16px_rgba(0,0,0,0.1)] transition-all duration-300 hover:text-[#FFB7C5] hover:scale-110 hover:bg-white dark:bg-slate-800/95 dark:text-slate-400 dark:shadow-[0_4px_16px_rgba(0,0,0,0.4)] dark:hover:bg-slate-700 <?php echo $is_in_wishlist ? 'text-[#FFB7C5]' : ''; ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="Add to wishlist">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 transition-colors duration-300 wishlist-icon" fill="<?php echo $is_in_wishlist ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="flex flex-1 flex-col">
            <!-- Category -->
            <div class="mb-2 text-xs font-semibold text-slate-500 dark:text-slate-400 line-clamp-1 uppercase tracking-wider">
                <?php echo strip_tags( wc_get_product_category_list( $product->get_id(), ', ' ) ); ?>
            </div>

            <!-- Title -->
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="mb-2 block">
                <h3 class="line-clamp-2 text-sm font-extrabold text-slate-800 transition-colors duration-300 group-hover:text-[#FFB7C5] dark:text-slate-100 leading-snug">
                    <?php echo esc_html( $product->get_name() ); ?>
                </h3>
            </a>

            <!-- Rating & Price & Button Row -->
            <div class="mt-auto flex items-center justify-between gap-2">
                <!-- Rating -->
                <div class="flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-yellow-400 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" />
                    </svg>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">
                        <?php echo esc_html( number_format_i18n( (float) $product->get_average_rating(), 1 ) ); ?>
                    </span>
                </div>

                <!-- Price -->
                <div class="custom-price-color text-base font-black text-[#FFB7C5] leading-none tracking-tight">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>

                <!-- WooCommerce Cart Button -->
                <div class="custom-premium-cart shrink-0 relative z-20">
                    <?php 
                    woocommerce_template_loop_add_to_cart(); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</li>