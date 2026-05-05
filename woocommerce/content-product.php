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
    <div class="flex h-full flex-col rounded-[24px] bg-white p-4 shadow-[0_4px_24px_rgba(15,23,42,0.06)] transition-all duration-400 hover:-translate-y-2 hover:shadow-[0_12px_36px_rgba(255,183,197,0.25)] dark:bg-slate-800 dark:shadow-[0_4px_24px_rgba(0,0,0,0.4)]">
        
        <!-- Image & Wishlist Section -->
        <div class="relative mb-4 overflow-hidden rounded-[18px] bg-slate-50 dark:bg-slate-700 aspect-[4/3] w-full">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block h-full w-full relative z-10">
                <?php
                if ( $product->get_image_id() ) {
                    echo wp_get_attachment_image(
                        $product->get_image_id(),
                        'woocommerce_thumbnail',
                        false,
                        array(
                            'class' => 'h-full w-full object-cover object-center mix-blend-multiply dark:mix-blend-normal transition-transform duration-700 group-hover:scale-105',
                        )
                    );
                } else {
                    echo wc_placeholder_img( 'woocommerce_thumbnail' );
                }
                ?>
            </a>

            <!-- Custom Native Wishlist Button -->
            <div class="absolute right-3 top-3 z-20">
                <?php 
                $wishlist = function_exists('julias_get_wishlist') ? julias_get_wishlist() : [];
                $product_id = $product->get_id();
                $is_in_wishlist = in_array($product_id, $wishlist);
                ?>
                <button type="button" class="julias-wishlist-btn inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 backdrop-blur-md text-slate-400 shadow-[0_2px_10px_rgba(0,0,0,0.05)] transition-all hover:text-[#FFB7C5] hover:scale-105 <?php echo $is_in_wishlist ? 'text-[#FFB7C5]' : ''; ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="Add to wishlist">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 transition-colors duration-300 wishlist-icon" fill="<?php echo $is_in_wishlist ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="flex flex-1 flex-col px-1 pb-1">
            <!-- Category -->
            <div class="mb-1 text-[0.8rem] font-semibold text-slate-400 dark:text-slate-500 line-clamp-1">
                <?php echo strip_tags( wc_get_product_category_list( $product->get_id(), ', ' ) ); ?>
            </div>

            <!-- Title -->
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="mb-2 block">
                <h3 class="line-clamp-1 text-[1.15rem] font-extrabold text-slate-800 transition-colors duration-300 group-hover:text-[#FFB7C5] dark:text-slate-100">
                    <?php echo esc_html( $product->get_name() ); ?>
                </h3>
            </a>

            <!-- Rating -->
            <div class="mb-4 flex items-center gap-1.5">
                <svg class="h-4 w-4 text-yellow-400 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" />
                </svg>
                <span class="text-[0.85rem] font-bold text-slate-600 dark:text-slate-300 mt-0.5">
                    <?php echo esc_html( number_format_i18n( (float) $product->get_average_rating(), 1 ) ); ?>
                </span>
            </div>

            <!-- Price & Native Add to Cart -->
            <div class="mt-auto flex items-center justify-between gap-3 pt-1">
                <div class="custom-price-color text-[1.35rem] font-black text-[#FFB7C5] leading-none tracking-tight">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>

                <!-- WooCommerce Cart Button overrides via CSS -->
                <div class="custom-premium-cart shrink-0 relative z-20">
                    <?php 
                    woocommerce_template_loop_add_to_cart(); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</li>