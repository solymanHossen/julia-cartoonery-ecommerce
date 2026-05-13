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
		<div class="relative">
			<!-- Carousel Track -->
			<div class="overflow-hidden rounded-2xl lg:rounded-3xl">
				<div class="carousel-track flex transition-transform duration-500 ease-out" style="transform: translateX(0);">
					<?php foreach ( $products as $product ) : ?>
						<?php
						$product_id = $product->get_id();
						$product_name = $product->get_name();
						$product_link = $product->get_permalink();
						$product_image_id = $product->get_image_id();
						$product_price = $product->get_price_html();
						$product_rating = number_format_i18n( (float) $product->get_average_rating(), 1 );
						$is_in_stock = $product->is_in_stock();
						?>
						<div class="carousel-slide flex-shrink-0 w-full sm:w-1/2 lg:w-1/4 px-3">
							<a href="<?php echo esc_url( $product_link ); ?>" class="block h-full">
								<div class="group overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
									
									<!-- Product Image -->
									<div class="relative overflow-hidden bg-slate-100 h-56 sm:h-64 lg:h-72">
										<?php 
										if ( $product_image_id ) {
											echo wp_get_attachment_image( $product_image_id, 'woocommerce_single', false, array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110' ) );
										} else {
											echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Product" class="w-full h-full object-cover" />';
										}
										?>
										
										<!-- Stock Badge -->
										<div class="absolute top-3 right-3 inline-flex items-center gap-1 px-3 py-1.5 bg-white/95 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur shadow-sm">
											<span class="w-2 h-2 <?php echo $is_in_stock ? 'bg-green-500' : 'bg-red-500'; ?> rounded-full"></span>
											<?php echo $is_in_stock ? 'In Stock' : 'Out'; ?>
										</div>
										
										<!-- Rating -->
										<?php if ( $product_rating > 0 ) : ?>
											<div class="absolute bottom-3 left-3 flex items-center gap-1 px-3 py-1.5 bg-white/95 rounded-full text-xs font-bold backdrop-blur shadow-sm">
												<svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2Z" /></svg>
												<span><?php echo esc_html( $product_rating ); ?></span>
											</div>
										<?php endif; ?>
									</div>
									
									<!-- Product Info -->
									<div class="flex-1 flex flex-col justify-between p-4 sm:p-5">
										<div>
											<h3 class="font-bold text-slate-900 line-clamp-2 group-hover:text-[#FF93AB] transition-colors">
												<?php echo esc_html( $product_name ); ?>
											</h3>
										</div>
										
										<div class="mt-4 flex items-end justify-between">
											<div class="text-lg font-black text-[#FF93AB]">
												<?php echo wp_kses_post( $product_price ); ?>
											</div>
											<div class="custom-premium-cart">
												<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart text-xs px-3 py-2 rounded-full bg-[#FFB7C5] text-white font-bold hover:bg-[#FF93AB] transition-colors" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow"></a>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Navigation Buttons -->
			<button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-6 lg:-translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center" aria-label="Previous slide">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
			</button>

			<button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-6 lg:translate-x-8 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-lg hover:shadow-xl hover:bg-[#FFB7C5] hover:text-white transition-all duration-300 flex items-center justify-center" aria-label="Next slide">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
			</button>

			<!-- Carousel Indicators (Dots) -->
			<div class="carousel-indicators mt-6 flex justify-center gap-2">
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
				dot.classList.remove('w-2.5', 'bg-slate-300');
				dot.classList.add('bg-[#FF93AB]', 'w-8');
			} else {
				dot.classList.remove('bg-[#FF93AB]', 'w-8');
				dot.classList.add('w-2.5', 'bg-slate-300');
			}
		});
	}
	
	function next() {
		currentIndex = (currentIndex + 1) % (slides.length - itemsPerView + 1);
		updateCarousel();
	}
	
	function prev() {
		currentIndex = (currentIndex - 1 + (slides.length - itemsPerView + 1)) % (slides.length - itemsPerView + 1);
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

