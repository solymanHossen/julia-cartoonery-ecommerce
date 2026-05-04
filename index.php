<?php
/**
 * The template for displaying all single pages
 */

get_header(); ?>

<div class="container mx-auto px-4 lg:px-8 py-12 min-h-[60vh] animate-in fade-in">
    <?php
    // Start the Loop.
    while ( have_posts() ) :
        the_post();

        // পেজের টাইটেল (যদি আপনি দেখাতে চান, না চাইলে মুছে দিতে পারেন)
        // echo '<h1 class="font-[\'Bubblegum_Sans\'] text-4xl text-gray-800 dark:text-gray-100 mb-8">' . get_the_title() . '</h1>';

        // এই the_content() ফাংশনটিই হলো আসল ম্যাজিক! 
        // এটি ওয়ার্ডপ্রেসের শর্টকোড রিড করে আপনার woocommerce/checkout/form-checkout.php এবং cart.php কে কল করবে।
        the_content();

    endwhile; // End of the loop.
    ?>
</div>

<?php get_footer(); ?>