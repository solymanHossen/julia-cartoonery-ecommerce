<?php get_header(); ?>

<main>
	<?php get_template_part('template-parts/hero', 'carousel'); ?>
	<?php get_template_part( 'template-parts/sections/latest-products', 'section' ); ?>
	<?php get_template_part( 'template-parts/sections/favorite-toys', 'section' ); ?>
	<?php get_template_part('template-parts/sections/videos', 'section'); ?>
	<?php get_template_part( 'template-parts/reviews-section' ); ?>
</main>

<?php get_footer(); ?>