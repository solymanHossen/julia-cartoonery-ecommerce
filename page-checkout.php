<?php
/**
 * Custom Checkout Page Template
 * 
 * Template Name: Custom Checkout Page
 */
get_header(); ?>

<main class="container mx-auto px-4 lg:px-8 py-12 animate-in fade-in">
    <?php
    if ( class_exists( 'WooCommerce' ) ) {
        // WooCommerce এর ডিফল্ট চেকআউট ফাংশনালিটি কল করা হচ্ছে
        echo do_shortcode('[woocommerce_checkout]'); 
    } else {
        echo '<p class="text-center text-red-500 font-bold">Please install and activate WooCommerce.</p>';
    }
    ?>
</main>

<?php get_footer(); ?>