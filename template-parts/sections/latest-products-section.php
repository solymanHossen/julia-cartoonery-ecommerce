<?php
/**
 * Template part for displaying the Latest Products section in a 4-column grid.
 * Optimized for home page with premium card layout.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$shop_url = wc_get_page_permalink( 'shop' );

// Query for the latest 4 products (as you want 4 products in one line)
$latest_query = new WP_Query(
    array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 4, // 4-ti product show hobe
        'orderby'        => 'date',
        'order'          => 'DESC',
    )
);

if ( ! $latest_query->have_posts() ) {
    wp_reset_postdata();
    return;
}
?>

<section class="py-16 sm:py-24 bg-gradient-to-br from-white via-[#fcf4f4] to-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[#FF93AB] mb-3">NEW ARRIVALS</p>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
                    Fresh toys in stock
                </h2>
                <p class="mt-4 text-base text-slate-600 max-w-xl">
                    Check out our latest collection of handpicked toys, selected for quality and endless fun.
                </p>
            </div>
            <div>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] text-white font-black uppercase text-sm rounded-full shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    View All Shop
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php 
            while ( $latest_query->have_posts() ) : $latest_query->the_post(); 
                // Ekhane apnar content-product.php template-ti call hobe
                wc_get_template_part( 'content', 'product' ); 
            endwhile; 
            wp_reset_postdata();
            ?>
        </div>

    </div>
</section>