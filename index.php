<?php get_header(); ?>

<main class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
	<section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-12">
		<h1 class="text-3xl font-semibold tracking-tight text-slate-950 dark:text-white">
			Latest posts
		</h1>
		<div class="mt-8 space-y-6 text-slate-600 dark:text-slate-300">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'rounded-2xl border border-slate-200/70 p-6 dark:border-slate-800' ); ?>>
						<h2 class="text-xl font-medium text-slate-950 dark:text-white">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="mt-3 leading-7">
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<p>No posts found.</p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
