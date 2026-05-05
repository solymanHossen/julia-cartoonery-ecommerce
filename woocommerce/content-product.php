<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$categories = wc_get_product_category_list( $product->get_id(), ', ' );
?>

<li <?php wc_product_class( 'group h-full', $product ); ?>>
    <div class="flex h-full flex-col rounded-[30px] bg-white p-4 shadow-[0_2px_14px_rgba(15,23,42,0.06)] transition-transform duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_28px_rgba(15,23,42,0.08)] dark:bg-slate-800">
        <div class="relative mb-4 aspect-square overflow-hidden rounded-[24px] bg-slate-100 dark:bg-slate-700">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block h-full w-full">
                <?php
                if ( $product->get_image_id() ) {
                    echo wp_get_attachment_image(
                        $product->get_image_id(),
                        'woocommerce_thumbnail',
                        false,
                        array(
                            'class' => 'h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105',
                        )
                    );
                } else {
                    echo wc_placeholder_img( 'woocommerce_thumbnail' );
                }
                ?>
            </a>

            <button type="button" class="jc-wishlist-card-btn absolute right-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/95 text-slate-400 shadow-sm backdrop-blur transition-colors hover:text-[#FFB7C5]" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="Add to wishlist">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" />
                </svg>
            </button>
        </div>

        <div class="flex flex-1 flex-col px-1 pb-1">
            <div class="mb-1 text-xs text-slate-400">
                <?php echo wp_kses_post( $categories ); ?>
            </div>

            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="mb-2 block">
                <h3 class="line-clamp-1 text-[1.05rem] font-bold leading-tight text-slate-800 transition-colors group-hover:text-[#FFB7C5] dark:text-slate-100">
                    <?php echo esc_html( $product->get_name() ); ?>
                </h3>
            </a>

            <div class="mb-4 flex items-center gap-1">
                <svg class="h-4 w-4 shrink-0 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" />
                </svg>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-300"><?php echo esc_html( number_format_i18n( (float) $product->get_average_rating(), 1 ) ); ?></span>
            </div>

            <div class="mt-auto flex items-end justify-between gap-3">
                <div class="custom-price-color text-[1.55rem] leading-none">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>

                <div class="custom-cart-button shrink-0">
                    <?php woocommerce_template_loop_add_to_cart(); ?>
                </div>
            </div>
        </div>
    </div>
</li>