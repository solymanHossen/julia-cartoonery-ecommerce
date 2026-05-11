<?php
/**
 * The template for displaying all single pages
 */

get_header(); ?>

<div class="container mx-auto px-4 lg:px-8 py-6 lg:py-12 min-h-[60vh] animate-in fade-in">
    <?php
    // Start the Loop.
    while ( have_posts() ) :
        the_post();
        the_content();

    endwhile; // End of the loop.
    ?>
</div>

<?php get_footer(); ?>