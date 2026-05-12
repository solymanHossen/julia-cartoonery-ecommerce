<?php
/**
 * Template part for displaying the Favorite Toys section.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$shop_url = wc_get_page_permalink( 'shop' );

$products_query = new WP_Query(
	array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

if ( ! $products_query->have_posts() ) {
	wp_reset_postdata();
	return;
}

$featured_product = null;
$supporting_products = array();

while ( $products_query->have_posts() ) {
	$products_query->the_post();
	$product = wc_get_product( get_the_ID() );

	if ( ! $product ) {
		continue;
	}

	if ( ! $featured_product ) {
		$featured_product = $product;
		continue;
	}

	$supporting_products[] = $product;
}

wp_reset_postdata();

if ( ! $featured_product ) {
	return;
}

$featured_id    = $featured_product->get_id();
$featured_image = $featured_product->get_image_id();
$featured_terms = wc_get_product_category_list( $featured_id, ', ' );
$featured_price = $featured_product->get_price_html();
$featured_rating = number_format_i18n( (float) $featured_product->get_average_rating(), 1 );
$featured_excerpt = wp_trim_words( wp_strip_all_tags( $featured_product->get_short_description() ?: $featured_product->get_description() ), 18 );
$stock_label = $featured_product->is_in_stock() ? __( 'In Stock', 'julia-cartoonery' ) : __( 'Sold Out', 'julia-cartoonery' );
?>

<section class="relative overflow-hidden py-16 sm:py-20">
	<div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,183,197,0.16),transparent_42%),linear-gradient(180deg,#fffdfd_0%,#fff8fb_44%,#f8fbff_100%)] dark:bg-[radial-gradient(circle_at_top,rgba(255,183,197,0.1),transparent_42%),linear-gradient(180deg,#020617_0%,#020617_60%,#0f172a_100%)]"></div>
	<div class="absolute left-1/2 top-10 h-56 w-[52rem] -translate-x-1/2 rounded-full bg-white/30 blur-3xl dark:bg-pink-500/10"></div>

	<div class="container mx-auto px-4 lg:px-8 relative z-10">
		<div>
			<div class="flex flex-col gap-5 border-b border-slate-200/70 pb-5 dark:border-slate-700/70 lg:flex-row lg:items-end lg:justify-between">
				<div class="max-w-2xl">
					<p class="text-[10px] font-black uppercase tracking-[0.35em] text-[#FF93AB] dark:text-pink-300"><?php esc_html_e( 'Favorite Toys', 'julia-cartoonery' ); ?></p>
					<h2 class="mt-3 font-['Bubblegum_Sans'] text-4xl leading-[0.95] text-slate-800 dark:text-slate-100 sm:text-5xl">
						<?php esc_html_e( 'Latest picks kids actually click first', 'julia-cartoonery' ); ?>
					</h2>
					<p class="mt-3 max-w-xl text-sm leading-relaxed text-slate-500 dark:text-slate-300 sm:text-base">
						<?php esc_html_e( 'Fresh from the shop, styled like a premium collection, and organized so the newest toys stand out immediately.', 'julia-cartoonery' ); ?>
					</p>
				</div>

				<div class="flex flex-wrap items-center gap-3">
					<div class="rounded-full border border-[#FFB7C5]/30 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm dark:border-pink-400/20 dark:bg-slate-800 dark:text-slate-100">
						<?php echo esc_html( sprintf( _n( '%s new toy', '%s new toys', 4, 'julia-cartoonery' ), 4 ) ); ?>
					</div>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-5 py-3 text-sm font-black text-white shadow-[0_14px_36px_rgba(255,183,197,0.28)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_42px_rgba(255,183,197,0.35)]">
						<?php esc_html_e( 'View All Toys', 'julia-cartoonery' ); ?>
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
					</a>
				</div>
			</div>

			<div class="mt-8 grid gap-6 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)] lg:items-stretch">
				<article class="group relative overflow-hidden rounded-[30px] border border-slate-100 bg-white shadow-[0_14px_40px_rgba(15,23,42,0.08)] transition-transform duration-500 hover:-translate-y-1 dark:border-slate-700/70 dark:bg-slate-900">
					<div class="grid h-full gap-0 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]">
						<div class="relative min-h-[320px] overflow-hidden bg-gradient-to-br from-[#fff1f4] via-white to-[#eefbff] dark:from-slate-800 dark:via-slate-900 dark:to-slate-950">
							<?php if ( $featured_image ) : ?>
								<?php echo wp_get_attachment_image( $featured_image, 'large', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-105', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $featured_product->get_name() ) ); ?>
							<?php else : ?>
								<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#FFB7C5]/20 to-[#A8D8EA]/20 text-sm font-bold text-slate-500 dark:text-slate-300">
									<?php esc_html_e( 'Featured toy image', 'julia-cartoonery' ); ?>
								</div>
							<?php endif; ?>

							<div class="absolute inset-0 bg-gradient-to-t from-slate-950/30 via-transparent to-transparent"></div>
							<div class="absolute left-4 top-4 inline-flex rounded-full bg-white/90 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.24em] text-[#FF93AB] shadow-sm backdrop-blur dark:bg-slate-800/90 dark:text-pink-300">
								<?php echo esc_html( $stock_label ); ?>
							</div>
							<div class="absolute bottom-4 left-4 flex items-center gap-2 rounded-full bg-white/90 px-3 py-1.5 text-xs font-bold text-slate-700 shadow-sm backdrop-blur dark:bg-slate-800/90 dark:text-slate-100">
								<svg class="h-4 w-4 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" /></svg>
								<span><?php echo esc_html( $featured_rating ); ?></span>
							</div>
						</div>

						<div class="flex h-full flex-col justify-between p-5 sm:p-6 lg:p-7">
							<div>
								<div class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
									<?php echo wp_kses_post( $featured_terms ); ?>
								</div>
								<h3 class="mt-3 font-['Bubblegum_Sans'] text-3xl leading-[0.95] text-slate-800 dark:text-slate-100 sm:text-4xl">
									<a href="<?php echo esc_url( $featured_product->get_permalink() ); ?>" class="hover:text-[#FF93AB] dark:hover:text-pink-300">
										<?php echo esc_html( $featured_product->get_name() ); ?>
									</a>
								</h3>
								<?php if ( $featured_excerpt ) : ?>
									<p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-500 dark:text-slate-300 sm:text-[0.95rem]">
										<?php echo esc_html( $featured_excerpt ); ?>
									</p>
								<?php endif; ?>
							</div>

							<div class="mt-6 flex flex-col gap-4 border-t border-slate-100 pt-5 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
								<div>
									<div class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500"><?php esc_html_e( 'From', 'julia-cartoonery' ); ?></div>
									<div class="mt-1 text-2xl font-black text-[#FF93AB] dark:text-pink-300">
										<?php echo wp_kses_post( $featured_price ); ?>
									</div>
								</div>

								<div class="flex flex-wrap gap-3">
									<a href="<?php echo esc_url( $featured_product->get_permalink() ); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 transition-all duration-300 hover:border-[#FFB7C5] hover:text-[#FF93AB] dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-pink-400 dark:hover:text-pink-300">
										<?php esc_html_e( 'View Details', 'julia-cartoonery' ); ?>
									</a>
									<div class="custom-premium-cart">
										<a href="<?php echo esc_url( $featured_product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $featured_id ); ?>" data-product_sku="<?php echo esc_attr( $featured_product->get_sku() ); ?>" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to your cart', 'julia-cartoonery' ), $featured_product->get_name() ) ); ?>"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>

				<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
					<?php foreach ( $supporting_products as $product ) : ?>
						<?php
						$product_id   = $product->get_id();
						$product_name = $product->get_name();
						$product_link = $product->get_permalink();
						$product_img  = $product->get_image_id();
						$product_price = $product->get_price_html();
						$product_cat   = strip_tags( wc_get_product_category_list( $product_id, ', ' ) );
						?>
						<article class="group flex h-full gap-4 overflow-hidden rounded-[24px] border border-slate-100 bg-white p-3 shadow-[0_10px_28px_rgba(15,23,42,0.06)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_14px_36px_rgba(255,183,197,0.16)] dark:border-slate-700/70 dark:bg-slate-900 sm:p-4 lg:flex-col xl:flex-row">
							<a href="<?php echo esc_url( $product_link ); ?>" class="relative block aspect-square w-28 shrink-0 overflow-hidden rounded-2xl bg-slate-100 dark:bg-slate-800 sm:w-32 lg:w-full xl:w-32">
								<?php if ( $product_img ) : ?>
									<?php echo wp_get_attachment_image( $product_img, 'woocommerce_thumbnail', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-105', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $product_name ) ); ?>
								<?php else : ?>
									<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#FFB7C5]/20 to-[#A8D8EA]/20 text-xs font-bold text-slate-500 dark:text-slate-300">
										<?php esc_html_e( 'Toy', 'julia-cartoonery' ); ?>
									</div>
								<?php endif; ?>
							</a>

							<div class="min-w-0 flex-1">
								<p class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-400 dark:text-slate-500">
									<?php echo esc_html( $product_cat ); ?>
								</p>
								<h3 class="mt-2 line-clamp-2 text-base font-extrabold leading-snug text-slate-800 transition-colors group-hover:text-[#FF93AB] dark:text-slate-100">
									<a href="<?php echo esc_url( $product_link ); ?>">
										<?php echo esc_html( $product_name ); ?>
									</a>
								</h3>

								<div class="mt-3 flex items-center justify-between gap-3">
									<div class="text-lg font-black text-[#FF93AB] dark:text-pink-300">
										<?php echo wp_kses_post( $product_price ); ?>
									</div>
									<div class="custom-premium-cart shrink-0">
										<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to your cart', 'julia-cartoonery' ), $product_name ) ); ?>"></a>
									</div>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
