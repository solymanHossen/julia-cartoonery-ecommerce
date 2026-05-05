<?php
/**
 * The template for displaying product content in the single-product.php template
 * Matches the screenshot design exactly: two-column layout, gallery + details
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
    return;
}

// Gather product data
$product_id       = $product->get_id();
$categories       = strip_tags( wc_get_product_category_list( $product_id, ', ' ) );
$average_rating   = $product->get_average_rating();
$review_count     = $product->get_review_count();
$short_desc       = $product->get_short_description();
$description      = $product->get_description();
$display_desc     = $short_desc ? $short_desc : $description;
$in_stock         = $product->is_in_stock();

// Get all gallery images
$attachment_ids   = $product->get_gallery_image_ids();
$main_image_id    = $product->get_image_id();
$all_images       = array_merge( [$main_image_id], $attachment_ids );

// Wishlist
$wishlist         = function_exists('julias_get_wishlist') ? julias_get_wishlist() : [];
$is_in_wishlist   = in_array( $product_id, $wishlist );
?>

<?php
// Suppress default WooCommerce notices on single product — we use custom toast.js
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
do_action( 'woocommerce_before_single_product' );
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'julias-single-product container mx-auto px-4 lg:px-8 py-8 lg:py-12', $product ); ?>>
    
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-14 max-w-6xl mx-auto">
        
        <!-- ========== LEFT: Gallery ========== -->
        <div class="w-full lg:w-[50%] xl:w-[45%] shrink-0">
            <!-- Main Image -->
            <div class="relative rounded-[28px] overflow-hidden bg-[#f3f4f6] dark:bg-slate-800 aspect-square mb-4 group">
                <a id="julias-main-lightbox" href="<?php echo esc_url( wp_get_attachment_url( $main_image_id ) ); ?>" class="glightbox block w-full h-full" data-gallery="product-gallery">
                    <?php
                    echo wp_get_attachment_image( $main_image_id, 'large', false, [
                        'id'    => 'julias-main-image',
                        'class' => 'w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105',
                    ]);
                    ?>
                </a>

                <!-- Wishlist Button -->
                <button type="button" class="julias-wishlist-btn absolute top-4 right-4 z-20 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/90 dark:bg-slate-700/80 backdrop-blur-md shadow-[0_2px_12px_rgba(0,0,0,0.08)] transition-all hover:scale-110 <?php echo $is_in_wishlist ? 'text-[#FFB7C5]' : 'text-slate-400 hover:text-[#FFB7C5]'; ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="Add to wishlist">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 transition-colors duration-300 wishlist-icon" fill="<?php echo $is_in_wishlist ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" />
                    </svg>
                </button>

                <!-- Zoom hint -->
                <div class="absolute bottom-4 left-4 z-20 bg-white/80 dark:bg-slate-700/80 backdrop-blur-md rounded-full px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <span class="flex items-center gap-1.5 text-xs font-bold text-slate-500 dark:text-slate-300">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                        Click to zoom
                    </span>
                </div>
            </div>

            <!-- Thumbnails -->
            <?php if ( count( $all_images ) > 1 ) : ?>
            <div class="flex gap-3 overflow-x-auto pb-2 julias-thumb-scroll">
                <?php foreach ( $all_images as $index => $img_id ) :
                    $thumb_url = wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' );
                    $full_url  = wp_get_attachment_url( $img_id );
                ?>
                <button type="button" class="julias-thumb-btn shrink-0 w-20 h-20 sm:w-[88px] sm:h-[88px] rounded-2xl overflow-hidden border-2 transition-all duration-300 cursor-pointer <?php echo $index === 0 ? 'border-[#FFB7C5] shadow-[0_0_0_2px_rgba(255,183,197,0.3)]' : 'border-transparent hover:border-slate-200 dark:hover:border-slate-600'; ?>" data-full-src="<?php echo esc_url( $full_url ); ?>" data-img-id="<?php echo esc_attr( $img_id ); ?>">
                    <?php echo wp_get_attachment_image( $img_id, 'woocommerce_thumbnail', false, [
                        'class' => 'w-full h-full object-cover object-center',
                    ]); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Hidden lightbox anchors for gallery images (non-first) -->
            <div class="hidden">
                <?php foreach ( $all_images as $index => $img_id ) :
                    if ( $index === 0 ) continue;
                    $full_url = wp_get_attachment_url( $img_id );
                ?>
                <a href="<?php echo esc_url( $full_url ); ?>" class="glightbox" data-gallery="product-gallery"></a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ========== RIGHT: Product Details ========== -->
        <div class="w-full lg:flex-1 flex flex-col">
            
            <!-- Category Badge -->
            <?php if ( $categories ) : ?>
            <div class="mb-3">
                <span class="inline-block px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-[#A8D8EA]/20 text-[#5BA4C9] dark:bg-[#A8D8EA]/10 dark:text-[#A8D8EA]">
                    <?php echo esc_html( $categories ); ?>
                </span>
            </div>
            <?php endif; ?>

            <!-- Product Title -->
            <h1 class="text-3xl sm:text-4xl lg:text-[2.75rem] font-extrabold text-slate-800 dark:text-white leading-tight mb-3 font-['Bubblegum_Sans'] tracking-wide">
                <?php the_title(); ?>
            </h1>

            <!-- Rating -->
            <?php if ( $review_count > 0 ) : ?>
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center gap-0.5">
                    <?php
                    $full_stars  = floor( $average_rating );
                    $half_star   = ( $average_rating - $full_stars ) >= 0.5;
                    $empty_stars = 5 - $full_stars - ( $half_star ? 1 : 0 );

                    for ( $i = 0; $i < $full_stars; $i++ ) {
                        echo '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>';
                    }
                    if ( $half_star ) {
                        echo '<svg class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24"><defs><linearGradient id="halfGrad"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#e2e8f0"/></linearGradient></defs><path fill="url(#halfGrad)" d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>';
                    }
                    for ( $i = 0; $i < $empty_stars; $i++ ) {
                        echo '<svg class="w-5 h-5 text-slate-200 dark:text-slate-600" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>';
                    }
                    ?>
                </div>
                <span class="text-sm font-bold text-slate-500 dark:text-slate-400">
                    (<?php echo esc_html( number_format_i18n( (float) $average_rating, 1 ) ); ?> / 5 based on <?php echo esc_html( $review_count ); ?> <?php echo $review_count === 1 ? 'Review' : 'Reviews'; ?>)
                </span>
            </div>
            <?php endif; ?>

            <!-- Price -->
            <div class="mb-6">
                <div class="julias-single-price text-[2rem] font-black text-[#FFB7C5] leading-none tracking-tight">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>
            </div>

            <!-- Description -->
            <?php if ( $display_desc ) : ?>
            <div class="mb-8 text-[0.95rem] leading-relaxed text-slate-600 dark:text-slate-400 font-medium">
                <?php echo wp_kses_post( $display_desc ); ?>
            </div>
            <?php endif; ?>

            <!-- Quantity + Add to Cart + Buy Now -->
            <?php if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $in_stock ) : ?>
            <form class="cart julias-cart-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                
                <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

                <!-- Quantity -->
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">Quantity</span>
                    <div class="flex items-center bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                        <button type="button" class="julias-qty-minus w-10 h-10 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition-colors cursor-pointer text-lg font-bold">−</button>
                        <input type="number" id="quantity_<?php echo esc_attr( $product_id ); ?>" class="input-text qty text w-12 text-center bg-transparent border-none text-sm font-bold text-slate-800 dark:text-white focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" name="quantity" value="1" min="1" max="<?php echo esc_attr( $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : '' ); ?>" step="1" />
                        <button type="button" class="julias-qty-plus w-10 h-10 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition-colors cursor-pointer text-lg font-bold">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>" class="flex-1 !flex items-center justify-center gap-2.5 py-4 px-6 bg-[#FFB7C5]/10 hover:bg-[#FFB7C5]/20 text-[#FFB7C5] rounded-full font-bold text-base transition-all duration-300 border-2 border-[#FFB7C5]/30 hover:border-[#FFB7C5]/60 group">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                        Add to Cart
                    </button>
                    <a href="<?php echo esc_url( wc_get_checkout_url() . '?add-to-cart=' . $product_id ); ?>" class="flex-1 !flex items-center justify-center gap-2 py-4 px-6 bg-[#A8D8EA] hover:bg-[#8ec8dd] text-white rounded-full font-bold text-base transition-all duration-300 shadow-[0_4px_15px_rgba(168,216,234,0.4)] hover:shadow-[0_4px_20px_rgba(168,216,234,0.6)] group">
                        Buy Now
                    </a>
                </div>

                <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

            </form>
            <?php elseif ( $product->is_type( 'variable' ) ) : ?>
                <?php woocommerce_variable_add_to_cart(); ?>
            <?php elseif ( $product->is_type( 'grouped' ) ) : ?>
                <?php woocommerce_grouped_add_to_cart(); ?>
            <?php elseif ( $product->is_type( 'external' ) ) : ?>
                <?php woocommerce_external_add_to_cart(); ?>
            <?php endif; ?>

            <!-- Stock & Delivery Badges -->
            <div class="flex flex-wrap items-center gap-4">
                <?php if ( $in_stock ) : ?>
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-400">In Stock</span>
                </div>
                <?php else : ?>
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Out of Stock</span>
                </div>
                <?php endif; ?>

                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Fast Delivery</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== TABS: Description / Reviews ========== -->
    <div class="max-w-6xl mx-auto mt-12 lg:mt-16">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary
         * Outputs product tabs (Description, Reviews, etc.)
         */
        woocommerce_output_product_data_tabs();
        ?>
    </div>

    <!-- ========== Related Products ========== -->
    <div class="max-w-6xl mx-auto mt-12 lg:mt-16">
        <?php woocommerce_output_related_products(); ?>
    </div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
