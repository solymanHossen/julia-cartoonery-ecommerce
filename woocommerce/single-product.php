<?php
/**
 * The Template for displaying all single products
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<!-- Back to Shop -->
<div class="container mx-auto px-4 lg:px-8 pt-6">
    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-[#FFB7C5] dark:hover:text-[#FFB7C5] transition-colors group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        Back to Shop
    </a>
</div>

<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>
    <?php wc_get_template_part( 'content', 'single-product' ); ?>
<?php endwhile; ?>

<?php get_footer(); ?>
