<?php
/**
 * Template part for displaying the Latest Products section.
 * 
 * Features:
 * - Smart layout switching: Carousel for 4+ products, Grid for 1-3 products
 * - Displays up to 8 latest products sorted by date (newest first)
 * - Carousel: 4 items visible on desktop with Embla library
 * - Grid: Responsive layout (1 col mobile, 2 cols tablet, 3 cols desktop)
 * - Graceful fallback with "Coming Soon" message for low product counts
 * - Full dark mode support & keyboard accessibility
 * - Modern glassmorphism design with smooth animations
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$shop_url = wc_get_page_permalink( 'shop' );

// Get latest 8 products
$latest_query = new WP_Query(
	array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

if ( ! $latest_query->have_posts() ) {
	wp_reset_postdata();
	return;
}

$latest_products = array();
while ( $latest_query->have_posts() ) {
	$latest_query->the_post();
	$product = wc_get_product( get_the_ID() );
	if ( $product ) {
		$latest_products[] = $product;
	}
}
wp_reset_postdata();

if ( empty( $latest_products ) ) {
	return;
}

// Determine layout: carousel if 4+ products, grid if fewer
$use_carousel = count( $latest_products ) >= 4;
$product_count = count( $latest_products );


?>

<section class="relative overflow-hidden py-20 sm:py-24 lg:py-28">
	<div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(168,216,234,0.15),transparent_60%),linear-gradient(180deg,#fffdfb_0%,#f8fbff_50%,#f0f9ff_100%)] dark:bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(168,216,234,0.08),transparent_60%),linear-gradient(180deg,#020617_0%,#0c1220_60%,#051030_100%)]"></div>

	<div class="container mx-auto px-4 lg:px-8 relative z-10">
		<!-- Header -->
		<div class="mx-auto max-w-7xl">
			<div class="mb-12 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
				<div class="max-w-3xl">
					<p class="text-xs font-black uppercase tracking-[0.4em] text-sky-500 dark:text-sky-300"><?php esc_html_e( 'New Arrivals', 'julia-cartoonery' ); ?></p>
					<h2 class="mt-4 font-['Bubblegum_Sans'] text-5xl leading-[0.95] text-slate-800 dark:text-slate-100 lg:text-6xl">
						<?php esc_html_e( 'Fresh toys in stock', 'julia-cartoonery' ); ?>
					</h2>
					<p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-500 dark:text-slate-300 sm:text-lg">
						<?php esc_html_e( 'Scroll through the latest additions to our collection. Each toy is carefully selected for quality and fun.', 'julia-cartoonery' ); ?>
					</p>
				</div>

				<div class="flex flex-wrap items-center gap-3">
					<div class="rounded-full border border-sky-200/50 bg-sky-50/40 px-4 py-2.5 text-sm font-black text-sky-700 shadow-sm backdrop-blur dark:border-sky-700/50 dark:bg-sky-950/30 dark:text-sky-200">
						<?php echo esc_html( sprintf( _n( '%s item', '%s items', 8, 'julia-cartoonery' ), 8 ) ); ?>
					</div>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-sky-400 to-[#A8D8EA] px-6 py-3 text-sm font-black text-white shadow-[0_12px_28px_rgba(168,216,234,0.3)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_16px_36px_rgba(168,216,234,0.4)]">
						<?php esc_html_e( 'Browse Shop', 'julia-cartoonery' ); ?>
						<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
					</a>
				</div>
			</div>

			<!-- Two Column: Video + Carousel Layout -->
			<div class="mt-12 grid gap-6 lg:grid-cols-[1.2fr_1fr] lg:items-start">
				<!-- Featured Video - Desktop Only -->
				<div class="hidden lg:flex lg:flex-col lg:gap-4">
					<!-- Video Player -->
					<div class="group relative overflow-hidden rounded-3xl border border-white/60 shadow-2xl dark:border-slate-700/60" style="aspect-ratio: 16/9;">
						<div class="absolute inset-0 bg-gradient-to-br from-sky-200 to-emerald-200 dark:from-slate-800 dark:to-slate-900"></div>
						<div class="absolute inset-0 flex items-center justify-center bg-gradient-to-t from-black/40 via-black/0 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100">
							<div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/95 shadow-xl backdrop-blur">
								<svg class="h-7 w-7 text-sky-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
							</div>
						</div>
						<div class="absolute inset-0 flex items-center justify-center">
							<svg class="h-20 w-20 animate-pulse text-sky-400 opacity-30 dark:text-sky-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
						</div>
						<div class="absolute left-4 top-4 rounded-full bg-white/95 px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-slate-700 shadow-lg backdrop-blur dark:bg-slate-800/95 dark:text-slate-100">
							<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
						</div>
					</div>

					<!-- Video Description Card -->
					<div class="rounded-2xl border border-slate-100/60 bg-white p-6 shadow-lg dark:border-slate-700/60 dark:bg-slate-900 sm:p-7">
						<h3 class="font-['Bubblegum_Sans'] text-2xl leading-[0.95] text-slate-800 dark:text-slate-100">
							<?php esc_html_e( 'See toys in action', 'julia-cartoonery' ); ?>
						</h3>
						<p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
							<?php esc_html_e( 'Watch kids play with their favorite toys and discover what makes them special.', 'julia-cartoonery' ); ?>
						</p>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-sky-500 to-sky-600 px-5 py-2.5 text-sm font-black text-white transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 dark:from-sky-600 dark:to-sky-700">
							<?php esc_html_e( 'Watch Now', 'julia-cartoonery' ); ?>
							<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
						</a>
					</div>
				</div>

				<!-- Products Carousel - Right Column -->
				<div>
				<?php if ( $use_carousel ) : ?>
					<!-- CAROUSEL VIEW: 4+ Products -->
					<div class="embla relative overflow-hidden rounded-3xl border border-white/60 bg-white/40 shadow-xl backdrop-blur-xl dark:border-slate-700/60 dark:bg-slate-900/50" aria-roledescription="carousel" aria-label="Latest products carousel" tabindex="0">
						<div class="embla__container flex gap-5 lg:gap-6">
							<?php foreach ( $latest_products as $product ) : ?>
								<?php
								$product_id = $product->get_id();
								$product_name = $product->get_name();
								$product_link = $product->get_permalink();
								$product_image_id = $product->get_image_id();
								$product_price = $product->get_price_html();
								$product_rating = number_format_i18n( (float) $product->get_average_rating(), 1 );
								$product_label = $product->is_in_stock() ? __( 'In Stock', 'julia-cartoonery' ) : __( 'Sold Out', 'julia-cartoonery' );
								$is_featured = $product->is_featured();
								?>
								<article class="embla__slide flex-[0_0_calc(25%-1.25rem)] min-w-0 lg:flex-[0_0_calc(25%-1.5rem)]">
									<div class="group h-full overflow-hidden rounded-2xl border border-slate-100/60 bg-white shadow-[0_8px_24px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(168,216,234,0.2)] dark:border-slate-700/60 dark:bg-slate-900">
										<!-- Product Image -->
										<div class="relative min-h-[220px] overflow-hidden bg-gradient-to-br from-sky-100 via-white to-emerald-50/40 dark:from-slate-800 dark:via-slate-900 dark:to-slate-950">
											<?php if ( $product_image_id ) : ?>
												<?php echo wp_get_attachment_image( $product_image_id, 'woocommerce_gallery_thumbnail', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $product_name ) ); ?>
											<?php else : ?>
												<div class="flex h-full min-h-[220px] w-full items-center justify-center bg-gradient-to-br from-sky-100 to-emerald-100 text-xs font-bold text-slate-400 dark:text-slate-500">
													<?php esc_html_e( 'Product', 'julia-cartoonery' ); ?>
												</div>
											<?php endif; ?>

											<!-- Badges -->
											<div class="absolute right-3 top-3 flex flex-col gap-2">
												<?php if ( $is_featured ) : ?>
													<div class="rounded-full bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-3 py-1 text-[10px] font-black text-white shadow-md">
														<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
													</div>
												<?php endif; ?>
												<div class="rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 shadow-md backdrop-blur dark:bg-slate-800/95 dark:text-slate-100">
													<?php esc_html_e( 'New', 'julia-cartoonery' ); ?>
												</div>
											</div>

											<!-- Rating Badge -->
											<div class="absolute bottom-3 left-3 flex items-center gap-1.5 rounded-full bg-white/90 px-2.5 py-1.5 text-[10px] font-bold text-slate-700 shadow-md backdrop-blur dark:bg-slate-800/90 dark:text-slate-100">
												<svg class="h-3.5 w-3.5 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" /></svg>
												<span><?php echo esc_html( $product_rating ); ?></span>
											</div>
											<div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
										</div>

										<!-- Product Info -->
										<div class="flex flex-col justify-between p-4">
											<div>
												<h3 class="line-clamp-2 text-sm font-extrabold leading-snug text-slate-800 transition-colors group-hover:text-sky-600 dark:text-slate-100 dark:group-hover:text-sky-400">
													<a href="<?php echo esc_url( $product_link ); ?>">
														<?php echo esc_html( $product_name ); ?>
													</a>
												</h3>
												<div class="mt-2 text-lg font-black text-sky-600 dark:text-sky-400">
													<?php echo wp_kses_post( $product_price ); ?>
												</div>
											</div>

											<div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 dark:border-slate-800">
												<a href="<?php echo esc_url( $product_link ); ?>" class="flex-1 rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-center text-xs font-bold text-slate-700 transition-all duration-300 hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-sky-600 dark:hover:bg-sky-950/30 dark:hover:text-sky-300">
													<?php esc_html_e( 'View', 'julia-cartoonery' ); ?>
												</a>
												<div class="custom-premium-cart">
													<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to your cart', 'julia-cartoonery' ), $product_name ) ); ?>"></a>
												</div>
											</div>
										</div>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Carousel Controls -->
					<div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
						<div class="embla__dots flex items-center justify-center gap-3 sm:justify-start" aria-label="Latest products carousel pagination"></div>
						<div class="flex items-center justify-center gap-2 sm:justify-end">
							<button type="button" class="embla__prev inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-sky-600 dark:hover:text-sky-400" aria-label="Previous product">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6" /></svg>
							</button>
							<button type="button" class="embla__next inline-flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-r from-sky-400 to-[#A8D8EA] text-white shadow-[0_12px_26px_rgba(168,216,234,0.3)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_16px_32px_rgba(168,216,234,0.4)]" aria-label="Next product">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
							</button>
						</div>
					</div>

				<?php else : ?>
					<!-- GRID VIEW: 1-3 Products -->
					<div class="rounded-3xl border border-white/60 bg-white/40 p-6 shadow-xl backdrop-blur-xl dark:border-slate-700/60 dark:bg-slate-900/50 sm:p-8">
						<?php if ( $product_count === 1 ) : ?>
							<div class="flex justify-center">
								<div class="w-full max-w-md">
						<?php elseif ( $product_count === 2 ) : ?>
							<div class="grid gap-6 sm:grid-cols-2">
						<?php else : ?>
							<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
						<?php endif; ?>
							<?php foreach ( $latest_products as $product ) : ?>
								<?php
								$product_id = $product->get_id();
								$product_name = $product->get_name();
								$product_link = $product->get_permalink();
								$product_image_id = $product->get_image_id();
								$product_price = $product->get_price_html();
								$product_rating = number_format_i18n( (float) $product->get_average_rating(), 1 );
								$is_featured = $product->is_featured();
								?>
								<article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-100/60 bg-white shadow-[0_8px_24px_rgba(15,23,42,0.08)] transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_12px_36px_rgba(168,216,234,0.2)] dark:border-slate-700/60 dark:bg-slate-900">
									<!-- Product Image -->
									<div class="relative min-h-[260px] overflow-hidden bg-gradient-to-br from-sky-100 via-white to-emerald-50/40 dark:from-slate-800 dark:via-slate-900 dark:to-slate-950 sm:min-h-[300px]">
										<?php if ( $product_image_id ) : ?>
											<?php echo wp_get_attachment_image( $product_image_id, 'woocommerce_gallery_thumbnail', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $product_name ) ); ?>
										<?php else : ?>
											<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sky-100 to-emerald-100 text-sm font-bold text-slate-400 dark:text-slate-500">
												<?php esc_html_e( 'Product Image', 'julia-cartoonery' ); ?>
											</div>
										<?php endif; ?>

										<!-- Badges -->
										<div class="absolute right-3 top-3 flex flex-col gap-2">
											<?php if ( $is_featured ) : ?>
												<div class="rounded-full bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-3 py-1 text-[10px] font-black text-white shadow-md">
													<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
												</div>
											<?php endif; ?>
											<div class="rounded-full bg-white/95 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 shadow-md backdrop-blur dark:bg-slate-800/95 dark:text-slate-100">
												<?php esc_html_e( 'New', 'julia-cartoonery' ); ?>
											</div>
										</div>

										<!-- Rating Badge -->
										<div class="absolute bottom-3 left-3 flex items-center gap-1.5 rounded-full bg-white/90 px-2.5 py-1.5 text-[10px] font-bold text-slate-700 shadow-md backdrop-blur dark:bg-slate-800/90 dark:text-slate-100">
											<svg class="h-3.5 w-3.5 text-yellow-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" /></svg>
											<span><?php echo esc_html( $product_rating ); ?></span>
										</div>
										<div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
									</div>

									<!-- Product Info -->
									<div class="flex flex-1 flex-col justify-between p-5 sm:p-6">
										<div>
											<h3 class="line-clamp-2 text-base font-extrabold leading-snug text-slate-800 transition-colors group-hover:text-sky-600 dark:text-slate-100 dark:group-hover:text-sky-400 sm:text-lg">
												<a href="<?php echo esc_url( $product_link ); ?>">
													<?php echo esc_html( $product_name ); ?>
												</a>
											</h3>
											<div class="mt-3 text-xl font-black text-sky-600 dark:text-sky-400 sm:text-2xl">
												<?php echo wp_kses_post( $product_price ); ?>
											</div>
										</div>

										<div class="mt-6 flex flex-col gap-2 border-t border-slate-100 pt-4 dark:border-slate-800 sm:flex-row sm:items-center sm:gap-3">
											<a href="<?php echo esc_url( $product_link ); ?>" class="flex-1 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-center text-sm font-bold text-slate-700 transition-all duration-300 hover:border-sky-300 hover:bg-sky-50 hover:text-sky-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-sky-600 dark:hover:bg-sky-950/30 dark:hover:text-sky-300 sm:py-3">
												<?php esc_html_e( 'View Details', 'julia-cartoonery' ); ?>
											</a>
											<div class="custom-premium-cart">
												<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow" aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to your cart', 'julia-cartoonery' ), $product_name ) ); ?>"></a>
											</div>
										</div>
									</div>
								</article>
							<?php endforeach; ?>
						</div>
						<?php if ( $product_count === 1 ) : ?>
							</div>
						<?php endif; ?>

						<!-- Info Message for Limited Products -->
						<?php if ( $product_count < 4 ) : ?>
							<div class="mt-8 flex flex-col items-center justify-center gap-4 rounded-2xl border border-sky-200/50 bg-gradient-to-r from-sky-50/80 to-emerald-50/50 p-6 dark:border-sky-800/50 dark:from-sky-950/50 dark:to-emerald-950/30 sm:mt-10 sm:p-8">
								<svg class="h-12 w-12 text-sky-400 dark:text-sky-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
								<div class="text-center">
									<h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 sm:text-xl">
										<?php esc_html_e( 'Coming Soon', 'julia-cartoonery' ); ?>
									</h4>
									<p class="mt-2 max-w-md text-sm text-slate-600 dark:text-slate-300 sm:text-base">
										<?php echo esc_html( sprintf( __( 'We currently have %s new arrival%s. Browse our full shop for more amazing toys!', 'julia-cartoonery' ), $product_count, $product_count !== 1 ? 's' : '' ) ); ?>
									</p>
								</div>
								<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-sky-400 to-[#A8D8EA] px-6 py-3 text-sm font-black text-white shadow-[0_12px_28px_rgba(168,216,234,0.3)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_16px_36px_rgba(168,216,234,0.4)]">
									<?php esc_html_e( 'Browse Full Shop', 'julia-cartoonery' ); ?>
									<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		</div>
	</div>
	</div>
	</div>
</section>

