<?php
/**
 * The Template for displaying all single products
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<!-- Back to Shop -->
<div class="container mx-auto px-4 lg:px-8 pt-6">
    <?php get_template_part( 'template-parts/components/button-back', null, [
        'url'  => wc_get_page_permalink( 'shop' ),
        'text' => 'Back to Shop',
    ]); ?>
</div>

<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>
    <?php wc_get_template_part( 'content', 'single-product' ); ?>
<?php endwhile; ?>

<?php get_footer(); ?>
