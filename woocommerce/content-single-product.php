<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined( 'ABSPATH' ) || exit;

global $product;

// প্রোডাক্ট লোড হওয়ার আগে উকমার্সের ডিফল্ট হুক
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form();
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'container mx-auto px-4 lg:px-8 py-12 animate-in slide-in-from-right-8', $product ); ?>>

    <!-- Main Content Wrapper -->
    <div class="bg-white dark:bg-slate-800 rounded-[40px] p-6 lg:p-12 shadow-sm border border-gray-50 dark:border-slate-700 flex flex-col lg:flex-row gap-12 mb-12">
        
        <!-- Left Side: Product Image & Gallery -->
        <div class="flex-1 relative">
            <?php
            /**
             * এই হুকটি স্বয়ংক্রিয়ভাবে উকমার্সের ইমেজ, জুম ফিচার এবং গ্যালারি থাম্বনেইল লোড করবে।
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>

        <!-- Right Side: Product Details Summary -->
        <div class="flex-1 flex flex-col summary entry-summary">
            
            <!-- Category Tag -->
            <div class="mb-2">
                <span class="text-xs font-bold tracking-wider text-[#A8D8EA] dark:text-sky-400 uppercase bg-sky-50 dark:bg-sky-900/30 px-3 py-1 rounded-full">
                    <?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
                </span>
            </div>

            <!-- Product Title -->
            <h1 class="font-['Bubblegum_Sans'] text-4xl lg:text-5xl text-gray-800 dark:text-gray-100 mb-4">
                <?php the_title(); ?>
            </h1>

            <!-- Ratings / Reviews -->
            <div class="mb-6 flex items-center gap-4 text-gray-500 dark:text-gray-400 text-sm">
                <?php woocommerce_template_single_rating(); ?>
            </div>
            
            <!-- Price -->
            <div class="text-4xl font-bold text-[#FFB7C5] dark:text-pink-400 mb-6">
                <?php woocommerce_template_single_price(); ?>
            </div>
            
            <!-- Short Description -->
            <div class="text-gray-600 dark:text-gray-300 mb-8 leading-relaxed prose prose-indigo max-w-none">
                <?php woocommerce_template_single_excerpt(); ?>
            </div>

            <!-- Add to Cart Form (Quantity & Button) -->
            <div class="mt-auto space-y-6">
                <?php 
                /**
                 * এই ফাংশনটি কোয়ান্টিটি ইনপুট এবং 'Add to Cart' বাটন তৈরি করবে।
                 */
                woocommerce_template_single_add_to_cart(); 
                ?>
                
                <!-- Stock Status & Delivery Info -->
                <div class="flex items-center gap-6 pt-6 border-t border-gray-100 dark:border-slate-700 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                        <?php echo $product->is_in_stock() ? 'In Stock' : 'Out of Stock'; ?>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                        Fast Delivery
                    </div>
                </div>

                <!-- Product Meta (SKU, Tags) -->
                <div class="mt-4 text-sm text-gray-400">
                    <?php woocommerce_template_single_meta(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Description, Additional Info, and Reviews Tabs -->
    <div class="bg-white dark:bg-slate-800 rounded-[40px] p-6 lg:p-12 shadow-sm border border-gray-50 dark:border-slate-700 mb-12">
        <?php 
        /**
         * এই হুকটি কাস্টমার রিভিউ এবং বড় ডেসক্রিপশন ট্যাব জেনারেট করবে।
         */
        do_action( 'woocommerce_after_single_product_summary' ); 
        ?>
    </div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>