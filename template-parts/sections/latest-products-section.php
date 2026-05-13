<?php
/**
 * Template part for displaying the Latest Products section with modern carousel.
 *
 * Premium carousel layout with smooth sliding animation.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$shop_url = wc_get_page_permalink( 'shop' );

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

$products = array();
while ( $latest_query->have_posts() ) {
	$latest_query->the_post();
	$product = wc_get_product( get_the_ID() );
	if ( $product ) {
		$products[] = $product;
	}
}
wp_reset_postdata();

if ( empty( $products ) ) {
	return;
}
?>

<section class="py-16 sm:py-24 bg-gradient-to-br from-white via-[#fcf4f4] to-white overflow-hidden">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		
		<!-- Header -->
		<div class="mb-12 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
			<div>
				<p class="text-[10px] font-black uppercase tracking-[0.35em] text-[#FF93AB] mb-3">NEW ARRIVALS</p>
				<h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
					Fresh toys in stock
				</h2>
				<p class="mt-4 text-base text-slate-600 max-w-xl">
					Scroll through the latest additions to our collection. Each toy is carefully selected for quality and fun.
				</p>
			</div>
			<div>
				<a href="<?php echo esc_url( $shop_url ); ?>" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] text-white font-black uppercase text-sm rounded-full shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
					View All
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
				</a>
			</div>
		</div>

		<!-- Carousel Container -->
		<div class="relative group">
			<!-- Carousel Track -->
			<div class="overflow-hidden rounded-2xl lg:rounded-3xl">
				<div class="carousel-track flex transition-transform duration-700 ease-out" style="transform: translateX(0);">
					<?php foreach ( $products as $product ) : ?>
						<?php
						$product_id = $product->get_id();
						$product_name = $product->get_name();
						$product_link = $product->get_permalink();
						$product_image_id = $product->get_image_id();
						$product_price = $product->get_price_html();
						$product_rating = number_format_i18n( (float) $product->get_average_rating(), 1 );
						$product_review_count = $product->get_review_count();
						$is_in_stock = $product->is_in_stock();
						$on_sale = $product->is_on_sale();
						?>
						<div class="carousel-slide flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 px-3">
							<div class="group/card h-full overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-500 flex flex-col">
								
								<!-- Product Image Container -->
								<div class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100 h-56 sm:h-64 lg:h-72">
									<a href="<?php echo esc_url( $product_link ); ?>" class="block w-full h-full">
										<?php 
										if ( $product_image_id ) {
											echo wp_get_attachment_image( $product_image_id, 'woocommerce_single', false, array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110' ) );
										} else {
											echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Product" class="w-full h-full object-cover" />';
										}
										?>
									</a>
									
									<!-- Overlay Gradient -->
									<div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300"></div>
									
									<!-- Sale Badge -->
									<?php if ( $on_sale ) : ?>
										<div class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
											<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13 13H11V7H13V13ZM13 17H11V15H13V17ZM12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2Z"/></svg>
											Sale
										</div>
									<?php endif; ?>
									
									<!-- Stock Status Badge -->
									<div class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 <?php echo $is_in_stock ? 'bg-green-500' : 'bg-red-500'; ?> text-white rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
										<span class="w-2 h-2 bg-white rounded-full"></span>
										<?php echo $is_in_stock ? 'In Stock' : 'Out'; ?>
									</div>
									
									<!-- Rating Badge -->
									<?php if ( $product_rating > 0 ) : ?>
										<div class="absolute bottom-3 left-3 flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur rounded-full text-xs font-bold shadow-md">
											<div class="flex items-center gap-0.5">
												<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
													<svg class="w-4 h-4 <?php echo $i <= round( $product_rating ) ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" /></svg>
												<?php endfor; ?>
											</div>
											<span class="text-gray-700"><?php echo esc_html( $product_rating ); ?></span>
										</div>
									<?php endif; ?>
									
									<!-- Quick Add to Cart Button (Hover) -->
									<div class="absolute bottom-3 right-3 opacity-0 group-hover/card:opacity-100 transition-opacity duration-300">
										<div class="custom-premium-cart">
											<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full bg-[#FF93AB] text-white font-bold text-sm hover:bg-[#FFB7C5] transition-all duration-300 shadow-lg" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow">
												<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
												Add
											</a>
										</div>
									</div>
								</div>
								
								<!-- Product Info -->
								<div class="flex-1 flex flex-col justify-between p-4 sm:p-5">
									
									<!-- Product Title & Link -->
									<div>
										<a href="<?php echo esc_url( $product_link ); ?>" class="inline-block">
											<h3 class="font-bold text-slate-900 line-clamp-2 group-hover/card:text-[#FF93AB] transition-colors duration-300 text-sm sm:text-base">
												<?php echo esc_html( $product_name ); ?>
											</h3>
										</a>
									</div>
									
									<!-- Product Meta (Reviews Count) -->
									<?php if ( $product_review_count > 0 ) : ?>
										<p class="text-xs text-slate-500 mt-1">
											<?php echo sprintf( _n( '%d review', '%d reviews', $product_review_count, 'julia-cartoonery' ), $product_review_count ); ?>
										</p>
									<?php endif; ?>
									
									<!-- Price & Add to Cart -->
									<div class="mt-4 pt-4 border-t border-slate-100 flex items-end justify-between gap-3">
										<div class="text-lg sm:text-xl font-black text-[#FF93AB]">
											<?php echo wp_kses_post( $product_price ); ?>
										</div>
										<div class="custom-premium-cart hidden sm:block">
											<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#FFB7C5] text-white font-bold hover:bg-[#FF93AB] transition-all duration-300 shadow-md" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow">
												<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
											</a>
										</div>
									</div>
									
									<!-- View Details Link (Mobile) -->
									<a href="<?php echo esc_url( $product_link ); ?>" class="mt-3 block sm:hidden px-3 py-2 text-center text-xs font-bold text-[#FF93AB] hover:text-[#FFB7C5] transition-colors">
										View Details →
									</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Navigation Buttons -->
			<button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-6 lg:-translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100" aria-label="Previous slide">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
			</button>

			<button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-6 lg:translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100" aria-label="Next slide">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
			</button>

			<!-- Carousel Indicators (Dots) -->
			<div class="carousel-indicators mt-8 flex justify-center gap-2">
				<?php for ( $i = 0; $i < count( $products ); $i++ ) : ?>
					<button class="carousel-dot w-2.5 h-2.5 rounded-full transition-all duration-300 <?php echo $i === 0 ? 'bg-[#FF93AB] w-8' : 'bg-slate-300 hover:bg-slate-400'; ?>" data-slide="<?php echo $i; ?>" aria-label="Go to slide <?php echo $i + 1; ?>"></button>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const carousel = document.querySelector('.carousel-track');
	const slides = document.querySelectorAll('.carousel-slide');
	const prevBtn = document.querySelector('.carousel-prev');
	const nextBtn = document.querySelector('.carousel-next');
	const dots = document.querySelectorAll('.carousel-dot');
	
	let currentIndex = 0;
	const itemsPerView = window.innerWidth < 640 ? 1 : window.innerWidth < 1024 ? 2 : 4;
	
	function updateCarousel() {
		const offset = currentIndex * (100 / itemsPerView);
		carousel.style.transform = `translateX(-${offset}%)`;
		
		dots.forEach((dot, index) => {
			if ( index === currentIndex ) {
				dot.classList.remove('w-2.5', 'bg-slate-300', 'hover:bg-slate-400');
				dot.classList.add('bg-[#FF93AB]', 'w-8');
			} else {
				dot.classList.remove('bg-[#FF93AB]', 'w-8');
				dot.classList.add('w-2.5', 'bg-slate-300', 'hover:bg-slate-400');
			}
		});
	}
	
	function next() {
		const maxIndex = Math.max(0, slides.length - itemsPerView);
		currentIndex = (currentIndex + 1) % (maxIndex + 1);
		updateCarousel();
	}
	
	function prev() {
		const maxIndex = Math.max(0, slides.length - itemsPerView);
		currentIndex = (currentIndex - 1 + (maxIndex + 1)) % (maxIndex + 1);
		updateCarousel();
	}
	
	prevBtn.addEventListener('click', prev);
	nextBtn.addEventListener('click', next);
	
	dots.forEach(dot => {
		dot.addEventListener('click', function() {
			currentIndex = parseInt(this.dataset.slide);
			updateCarousel();
		});
	});
	
	window.addEventListener('resize', function() {
		updateCarousel();
	});
});
</script>

