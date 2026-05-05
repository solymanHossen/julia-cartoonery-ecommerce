<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$current_sort = sanitize_text_field( wp_unslash( $_GET['sort'] ?? 'newest' ) );
?>

<div class="container mx-auto max-w-[1360px] px-4 lg:px-8 pt-6 pb-12">
	<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8 lg:mb-10">
		<h1 class="font-['Bubblegum_Sans'] text-[3.35rem] leading-none tracking-tight text-slate-800 dark:text-slate-100">
			<?php woocommerce_page_title(); ?>
		</h1>

<form method="get" class="m-0">
      <div class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white px-4 py-2.5 shadow-[0_2px_10px_rgba(15,23,42,0.06)] dark:border-slate-700 dark:bg-slate-800">
        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M3 5h18l-7 8v5l-4 2v-7L3 5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
        </svg>
        
        <!-- Changed name="sort" to name="orderby" -->
        <select name="orderby" onchange="this.form.submit()" class="appearance-none border-0 bg-transparent pr-6 text-sm font-semibold text-slate-600 outline-none dark:text-slate-200">
          <!-- Changed values to WooCommerce native keys -->
          <option value="date" <?php selected( 'date', $current_sort ); ?>>Sort by Newest</option>
          <option value="price" <?php selected( 'price', $current_sort ); ?>>Price: Low to High</option>
          <option value="price-desc" <?php selected( 'price-desc', $current_sort ); ?>>Price: High to Low</option>
          <option value="rating" <?php selected( 'rating', $current_sort ); ?>>Top Rated</option>
        </select>
        
        <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="none" aria-hidden="true">
          <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
    </form>
	</div>

	<div class="grid gap-8 lg:grid-cols-[250px_minmax(0,1fr)] lg:gap-10 items-start">
		<aside class="lg:sticky lg:top-28">
			<?php get_template_part( 'template-parts/sidebar-shop' ); ?>
		</aside>

		<div class="min-w-0">
			<?php if ( woocommerce_product_loop() ) : ?>
				<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 xl:gap-7">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
				</div>

				<div class="mt-12 flex justify-center">
					<?php woocommerce_pagination(); ?>
				</div>
			<?php else : ?>
				<div class="rounded-[32px] border border-slate-200 bg-white p-12 text-center text-slate-500 shadow-sm dark:border-slate-700 dark:bg-slate-800">
					No toys found in this category.
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer( 'shop' ); ?>