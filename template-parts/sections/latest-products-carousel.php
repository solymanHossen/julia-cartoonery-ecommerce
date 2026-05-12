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

// Get header settings from customizer
$header_subtitle = get_theme_mod( 'julia_latest_products_subtitle', __( 'NEW ARRIVALS', 'julia-cartoonery' ) );
$header_title = get_theme_mod( 'julia_latest_products_title', __( 'Fresh toys in stock', 'julia-cartoonery' ) );
$header_description = get_theme_mod( 'julia_latest_products_description', __( 'Scroll through the latest additions to our collection. Each toy is carefully selected for quality and fun.', 'julia-cartoonery' ) );

// Get video settings from customizer
$video_url = get_theme_mod( 'julia_latest_products_video_url', '' );
$video_title = get_theme_mod( 'julia_latest_products_video_title', __( 'See toys in action', 'julia-cartoonery' ) );
$video_description = get_theme_mod( 'julia_latest_products_video_description', __( 'Watch kids play with their favorite toys and discover what makes them special.', 'julia-cartoonery' ) );
$video_button_text = get_theme_mod( 'julia_latest_products_video_button_text', __( 'Watch Now', 'julia-cartoonery' ) );

// Helper function to extract YouTube video ID
function get_youtube_video_id( $url ) {
	if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?\s]{11})%i', $url, $match ) ) {
		return $match[1];
	}
	return false;
}

// Determine if URL is YouTube
$youtube_id = $video_url ? get_youtube_video_id( $video_url ) : false;
$is_youtube = $youtube_id !== false;

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

<section class="relative overflow-hidden py-20 sm:py-24 lg:py-28 bg-[#FAFAFA] dark:bg-slate-950">
	<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-sky-100/40 rounded-full blur-3xl pointer-events-none dark:bg-sky-900/10"></div>

	<div class="container mx-auto px-4 lg:px-8 relative z-10">
		<!-- Header -->
		<div>
			<div class="mb-12 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
				<div class="max-w-3xl">
					<p class="text-[11px] font-black uppercase tracking-[0.3em] text-[#FFB7C5] dark:text-pink-400">
						<?php echo esc_html( $header_subtitle ); ?>
					</p>
					<h2 class="mt-3 font-['Bubblegum_Sans'] text-[42px] leading-[1.1] text-slate-800 dark:text-slate-100 lg:text-[54px]">
						<?php echo esc_html( $header_title ); ?>
					</h2>
					<p class="mt-4 max-w-2xl text-[15px] leading-relaxed text-slate-500 dark:text-slate-400">
						<?php echo esc_html( $header_description ); ?>
					</p>
				</div>

				<div class="flex flex-wrap items-center gap-4 mt-6 sm:mt-0">
					<div class="rounded-full border border-pink-100 bg-white px-5 py-2.5 text-[13px] font-bold text-[#FFB7C5] shadow-sm dark:border-slate-700 dark:bg-slate-800 dark:text-pink-400">
						<?php echo esc_html( sprintf( _n( '%s item', '%s items', 8, 'julia-cartoonery' ), 8 ) ); ?>
					</div>
					<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#0EA5E9] px-7 py-2.5 text-[13px] font-bold text-white shadow-md transition-all duration-300 hover:bg-sky-500 hover:shadow-lg hover:-translate-y-0.5">
						<?php esc_html_e( 'Browse Shop', 'julia-cartoonery' ); ?>
						<svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
					</a>
				</div>
			</div>

			<!-- Two Column: Video + Carousel Layout -->
			<div class="mt-12 grid gap-6 lg:grid-cols-[300px_1fr] lg:gap-8 lg:items-start">
				<!-- Featured Video - Desktop Only -->
				<div class="hidden lg:flex lg:flex-col lg:gap-6">
					<!-- Video Player / Thumbnail -->
					<div class="group relative overflow-hidden rounded-[24px] bg-gradient-to-br from-[#A7F3D0] to-[#86E8D0] shadow-sm transition-transform duration-300 hover:-translate-y-1 dark:from-emerald-900 dark:to-teal-900" style="aspect-ratio: 4/3;">
						<?php if ( $video_url ) : ?>
							<?php if ( $is_youtube ) : ?>
								<!-- YouTube Embed -->
								<iframe 
									width="100%" 
									height="100%" 
									src="https://www.youtube.com/embed/<?php echo esc_attr( $youtube_id ); ?>?autoplay=0&controls=1" 
									frameborder="0" 
									allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
									allowfullscreen
									class="absolute inset-0 h-full w-full z-10"
									title="<?php echo esc_attr( $video_title ); ?>">
								</iframe>
							<?php else : ?>
								<!-- Video File Player -->
								<video 
									controls 
									class="absolute inset-0 h-full w-full object-cover z-10"
									title="<?php echo esc_attr( $video_title ); ?>">
									<source src="<?php echo esc_attr( $video_url ); ?>" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							<?php endif; ?>
						<?php else : ?>
							<!-- Placeholder / Mockup Style -->
							<div class="absolute inset-0 flex items-center justify-center">
								<svg class="h-[72px] w-[72px] text-white/50 transition-all duration-300 group-hover:scale-110 group-hover:text-white/70" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
							</div>
						<?php endif; ?>
						
						<!-- Featured Badge -->
						<div class="absolute left-4 top-4 z-20">
							<span class="inline-flex items-center justify-center rounded-full bg-white px-3.5 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-800 shadow-sm dark:bg-slate-800 dark:text-slate-100">
								<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
							</span>
						</div>
					</div>

					<!-- Video Description Card -->
					<div class="rounded-[24px] bg-white p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:bg-slate-900 dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)]">
						<h3 class="font-['Bubblegum_Sans'] text-[24px] leading-tight text-slate-800 dark:text-slate-100">
							<?php echo esc_html( $video_title ); ?>
						</h3>
						<p class="mt-3 text-[14px] leading-relaxed text-slate-500 dark:text-slate-400">
							<?php echo esc_html( $video_description ); ?>
						</p>
						<a href="<?php echo esc_url( $shop_url ); ?>" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0EA5E9] px-5 py-3 text-[14px] font-bold text-white shadow-lg shadow-sky-500/30 transition-all hover:bg-sky-500 hover:shadow-sky-500/40 dark:bg-sky-600 dark:hover:bg-sky-500">
							<?php echo esc_html( $video_button_text ); ?>
							<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
						</a>
					</div>
				</div>

				<!-- Products Carousel - Right Column -->
				<div>
				<?php if ( $use_carousel ) : ?>
					<!-- CAROUSEL VIEW: 4+ Products -->
					<div class="embla relative overflow-hidden" aria-roledescription="carousel" aria-label="Latest products carousel" tabindex="0">
						<div class="embla__container flex gap-4 lg:gap-6">
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
								<article class="embla__slide flex-[0_0_100%] min-w-0 sm:flex-[0_0_calc(50%-0.5rem)] lg:flex-[0_0_100%]">
									<div class="group relative h-full min-h-[400px] lg:min-h-[500px] overflow-hidden rounded-[24px] bg-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:bg-slate-900">
										<!-- Product Image Background -->
										<div class="absolute inset-0 h-full w-full">
											<?php if ( $product_image_id ) : ?>
												<?php echo wp_get_attachment_image( $product_image_id, 'full', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $product_name ) ); ?>
											<?php else : ?>
												<div class="flex h-full w-full items-center justify-center bg-slate-200 text-sm font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-500">
													<?php esc_html_e( 'Product Image', 'julia-cartoonery' ); ?>
												</div>
											<?php endif; ?>
											
											<!-- Gradient Overlay -->
											<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 transition-opacity duration-500 group-hover:opacity-90"></div>
										</div>

										<!-- Badges -->
										<div class="absolute right-5 top-5 flex flex-col gap-2 z-20">
											<?php if ( $is_featured ) : ?>
												<div class="rounded-full bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-3.5 py-1.5 text-[10px] font-black text-white shadow-md">
													<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
												</div>
											<?php endif; ?>
											<div class="rounded-full bg-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-800 shadow-md dark:bg-slate-800 dark:text-slate-100">
												<?php esc_html_e( 'New', 'julia-cartoonery' ); ?>
											</div>
										</div>

										<!-- Product Info Overlay -->
										<div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8 z-20 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
											<div class="flex-1">
												<!-- Rating -->
												<div class="mb-3 flex items-center gap-1.5">
													<div class="flex gap-0.5">
														<?php for ( $i = 0; $i < 5; $i++ ) : ?>
															<svg class="h-4 w-4 <?php echo $i < (int) $product->get_average_rating() ? 'text-yellow-400' : 'text-slate-400/50'; ?>" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
														<?php endfor; ?>
													</div>
													<span class="text-xs font-bold text-white/90 ml-1"><?php echo esc_html( $product_rating ); ?></span>
												</div>
												
												<h3 class="text-2xl lg:text-3xl font-extrabold leading-tight text-white transition-colors group-hover:text-sky-300">
													<a href="<?php echo esc_url( $product_link ); ?>" class="before:absolute before:inset-0">
														<?php echo esc_html( $product_name ); ?>
													</a>
												</h3>
												<div class="mt-2 text-xl font-black text-[#38BDF8]">
													<?php echo wp_kses_post( $product_price ); ?>
												</div>
											</div>

											<div class="flex items-center gap-3 relative z-30">
												<a href="<?php echo esc_url( $product_link ); ?>" class="rounded-xl bg-white/10 backdrop-blur-md border border-white/20 px-5 py-3 text-[13px] font-bold text-white transition-all hover:bg-white hover:text-slate-900">
													<?php esc_html_e( 'Details', 'julia-cartoonery' ); ?>
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
					<div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between px-2">
						<div class="embla__dots flex items-center justify-center gap-2 sm:justify-start" aria-label="Latest products carousel pagination"></div>
						<div class="flex items-center justify-center gap-3 sm:justify-end">
							<button type="button" class="embla__prev inline-flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition-all duration-300 hover:border-[#38BDF8] hover:text-[#38BDF8] hover:shadow-md dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-sky-400 dark:hover:text-sky-400" aria-label="Previous product">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6" /></svg>
							</button>
							<button type="button" class="embla__next inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#38BDF8] text-white shadow-md transition-all duration-300 hover:bg-[#0EA5E9] hover:shadow-lg" aria-label="Next product">
								<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6" /></svg>
							</button>
						</div>
					</div>

				<?php else : ?>
					<!-- GRID VIEW: 1-3 Products -->
					<div class="w-full">
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
								<article class="group relative h-full min-h-[400px] overflow-hidden rounded-[24px] bg-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:bg-slate-900">
									<!-- Product Image Background -->
									<div class="absolute inset-0 h-full w-full">
										<?php if ( $product_image_id ) : ?>
											<?php echo wp_get_attachment_image( $product_image_id, 'full', false, array( 'class' => 'h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $product_name ) ); ?>
										<?php else : ?>
											<div class="flex h-full w-full items-center justify-center bg-slate-200 text-sm font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-500">
												<?php esc_html_e( 'Product Image', 'julia-cartoonery' ); ?>
											</div>
										<?php endif; ?>
										
										<!-- Gradient Overlay -->
										<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 transition-opacity duration-500 group-hover:opacity-90"></div>
									</div>

									<!-- Badges -->
									<div class="absolute right-5 top-5 flex flex-col gap-2 z-20">
										<?php if ( $is_featured ) : ?>
											<div class="rounded-full bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-3.5 py-1.5 text-[10px] font-black text-white shadow-md">
												<?php esc_html_e( 'Featured', 'julia-cartoonery' ); ?>
											</div>
										<?php endif; ?>
										<div class="rounded-full bg-white px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] text-slate-800 shadow-md dark:bg-slate-800 dark:text-slate-100">
											<?php esc_html_e( 'New', 'julia-cartoonery' ); ?>
										</div>
									</div>

									<!-- Product Info Overlay -->
									<div class="absolute bottom-0 left-0 right-0 p-6 z-20 flex flex-col gap-4">
										<div>
											<!-- Rating -->
											<div class="mb-3 flex items-center gap-1.5">
												<div class="flex gap-0.5">
													<?php for ( $i = 0; $i < 5; $i++ ) : ?>
														<svg class="h-4 w-4 <?php echo $i < (int) $product->get_average_rating() ? 'text-yellow-400' : 'text-slate-400/50'; ?>" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
													<?php endfor; ?>
												</div>
												<span class="text-xs font-bold text-white/90 ml-1"><?php echo esc_html( $product_rating ); ?></span>
											</div>
											
											<h3 class="text-2xl font-extrabold leading-tight text-white transition-colors group-hover:text-sky-300">
												<a href="<?php echo esc_url( $product_link ); ?>" class="before:absolute before:inset-0">
													<?php echo esc_html( $product_name ); ?>
												</a>
											</h3>
											<div class="mt-2 text-xl font-black text-[#38BDF8]">
												<?php echo wp_kses_post( $product_price ); ?>
											</div>
										</div>

										<div class="flex items-center gap-3 relative z-30 pt-2 border-t border-white/10">
											<a href="<?php echo esc_url( $product_link ); ?>" class="flex-1 text-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 px-4 py-3 text-[13px] font-bold text-white transition-all hover:bg-white hover:text-slate-900">
												<?php esc_html_e( 'Details', 'julia-cartoonery' ); ?>
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

