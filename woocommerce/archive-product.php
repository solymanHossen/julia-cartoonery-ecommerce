<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="container mx-auto px-4 lg:px-8 py-10 animate-in fade-in">
    
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="font-['Bubblegum_Sans'] text-5xl text-gray-800 dark:text-gray-100">
            <?php woocommerce_page_title(); ?>
        </h1>
        
        <!-- Default WooCommerce Sorting Filter with your design -->
        <div class="flex items-center gap-3 bg-white dark:bg-slate-800 px-4 py-2 rounded-full shadow-sm border border-gray-100 dark:border-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar (Categories) -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 sticky top-28">
                <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b dark:border-slate-700 pb-2">Categories</h3>
                <ul class="space-y-2">
                    <?php
                    // ডায়নামিক ক্যাটাগরি লিস্ট
                    $product_categories = get_terms( 'product_cat', array('hide_empty' => true) );
                    foreach( $product_categories as $category ) {
                        $cat_link = get_term_link( $category );
                        echo '<li><a href="' . esc_url( $cat_link ) . '" class="block w-full text-left px-3 py-2 rounded-xl transition-colors text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">' . esc_html( $category->name ) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            <?php if ( woocommerce_product_loop() ) : ?>
                
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-0 m-0">
                    <?php
                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();
                            /**
                             * এটি আপনার content-product.php ফাইলকে কল করবে
                             */
                            wc_get_template_part( 'content', 'product' );
                        }
                    }
                    ?>
                </ul>
                
                <!-- Pagination -->
                <div class="mt-10">
                    <?php woocommerce_pagination(); ?>
                </div>

            <?php else : ?>
                <div class="text-center py-20 text-gray-500 dark:text-gray-400">
                    <?php wc_no_products_found(); ?>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<?php get_footer( 'shop' ); ?>