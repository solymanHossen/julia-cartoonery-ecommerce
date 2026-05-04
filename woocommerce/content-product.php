<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// প্রোডাক্ট না থাকলে বা ভিজিবল না হলে কিছু দেখাবে না
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<!-- உকমার্সের ডিফল্ট ক্লাসগুলোর সাথে আপনার টেইলউইন্ড ক্লাসগুলো যুক্ত করা হলো -->
<li <?php wc_product_class( 'flex flex-col h-full group list-none', $product ); ?>>
    
    <!-- Product Image & Wishlist -->
    <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 bg-gray-50 dark:bg-slate-700">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
            <?php 
            // உকমার্সের ইমেজ ফাংশন, সাথে আপনার টেইলউইন্ড ক্লাস
            echo $product->get_image( 'woocommerce_thumbnail', array( 
                'class' => 'w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal group-hover:scale-105 transition-transform duration-500' 
            ) ); 
            ?>
        </a>
        
        <!-- Wishlist Button (আপাতত স্ট্যাটিক, পরে AJAX করা যাবে) -->
        <button class="absolute top-3 right-3 p-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur rounded-full text-gray-400 dark:text-gray-300 hover:text-red-400 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
        </button>
    </div>

    <!-- Product Details -->
    <div class="flex flex-col flex-grow">
        
        <!-- Category -->
        <span class="text-xs text-gray-400 dark:text-gray-500 mb-1">
            <?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
        </span>
        
        <!-- Title -->
        <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-2 line-clamp-1">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                <?php echo $product->get_name(); ?>
            </a>
        </h3>
        
        <!-- Rating -->
        <div class="flex items-center gap-1 mb-3 text-sm text-gray-600 dark:text-gray-400 font-bold">
            <?php 
            if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && $product->get_review_count() > 0 ) {
                echo wc_get_rating_html( $product->get_average_rating() ); 
            } else {
                echo '<span class="text-xs text-gray-400">No reviews yet</span>';
            }
            ?>
        </div>
        
        <!-- Price & Add to Cart -->
        <div class="mt-auto flex items-center justify-between">
            <span class="font-bold text-xl text-[#FFB7C5] dark:text-pink-400">
                <?php echo $product->get_price_html(); ?>
            </span>
            
            <?php
            // உকমার্সের AJAX Add to Cart বাটন, আপনার টেইলউইন্ড ডিজাইন সহ
            woocommerce_template_loop_add_to_cart( array(
                'class' => 'w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-[#A8D8EA] dark:hover:bg-sky-500 hover:text-white transition-colors ajax_add_to_cart add_to_cart_button',
            ) );
            ?>
        </div>
    </div>
</li>