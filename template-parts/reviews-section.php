<?php
/**
 * Template part for displaying the Dynamic Customer Reviews Section.
 *
 * Uses a responsive carousel layout with compact spacing and accessible controls.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$transient_key = 'julia_latest_verified_reviews_v2';
$reviews_data  = get_transient( $transient_key );

if ( false === $reviews_data ) {
	$comments = get_comments(
		array(
			'status'     => 'approve',
			'post_type'  => 'product',
			'type'       => 'review',
			'number'     => 8,
			'meta_query' => array(
				array(
					'key'     => 'rating',
					'compare' => 'EXISTS',
				),
			),
		)
	);

	$reviews_data = array();

	foreach ( $comments as $comment ) {
		$product_id = $comment->comment_post_ID;
		$product    = wc_get_product( $product_id );

		if ( ! $product || ! $product->is_visible() ) {
			continue;
		}

		$rating       = (int) get_comment_meta( $comment->comment_ID, 'rating', true );
		$verified     = function_exists( 'wc_review_is_from_verified_owner' ) ? wc_review_is_from_verified_owner( $comment->comment_ID ) : false;
		$product_image = get_the_post_thumbnail_url( $product_id, 'thumbnail' );

		if ( $rating >= 4 ) {
			$reviews_data[] = array(
				'author'       => $comment->comment_author,
				'avatar'       => get_avatar_url( $comment->comment_author_email, array( 'size' => 96, 'default' => 'mp' ) ),
				'content'      => wp_trim_words( $comment->comment_content, 20, '...' ),
				'rating'       => $rating,
				'date'         => get_comment_date( 'M j, Y', $comment->comment_ID ),
				'is_verified'  => $verified,
				'product_name' => $product->get_name(),
				'product_link' => $product->get_permalink(),
				'product_image' => $product_image ? $product_image : wc_placeholder_img_src(),
			);
		}
	}

	set_transient( $transient_key, $reviews_data, 12 * HOUR_IN_SECONDS );
}

if ( empty( $reviews_data ) ) {
	return;
}
?>

<section class="md:py-16 py-10 relative overflow-hidden bg-gradient-to-br from-white via-[#fcf4f4] to-white">
	<div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
		<div class=" mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
			<div>
				<div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white shadow-sm border border-slate-100 mb-4">
					<div class="flex gap-1 text-yellow-400" aria-hidden="true">
						<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
							<svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
						<?php endfor; ?>
					</div>
					<span class="text-xs font-bold text-slate-800">4.9 / 5.0</span>
				</div>
				<h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">Happy Customers</h2>
				<p class="mt-4 text-base text-slate-600 max-w-xl">Real reviews from verified buyers.</p>
			</div>
		</div>

		<div class="review-carousel-wrapper">
			<div class="relative group">
				<div class="overflow-hidden rounded-2xl lg:rounded-3xl relative" id="reviews-viewport">
					<div class="carousel-track flex py-4 items-stretch box-border transition-transform duration-700 ease-out will-change-transform" style="transform: translateX(0);">
					<?php foreach ( $reviews_data as $review ) : ?>
						<div class="carousel-slide flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 px-3 flex">
							<div class="w-full flex-1 bg-white rounded-[24px] p-6 shadow-sm border-2 border-slate-100 hover:border-[#FF93AB] hover:-translate-y-1 transition-all duration-300 flex flex-col relative group/review min-h-[20rem]">
								<div class="flex items-start justify-between mb-5">
									<div class="flex items-center gap-3 min-w-0">
										<img src="<?php echo esc_url( $review['avatar'] ); ?>" alt="<?php echo esc_attr( $review['author'] ); ?>" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-sm flex-shrink-0" loading="lazy" decoding="async" />
										<div class="min-w-0">
											<h4 class="font-bold text-slate-900 text-sm leading-none mb-1 truncate"><?php echo esc_html( $review['author'] ); ?></h4>
											<?php if ( $review['is_verified'] ) : ?>
												<div class="flex items-center gap-1 text-[#22c55e]">
													<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
													<span class="text-[10px] font-bold uppercase tracking-wider">Verified</span>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<div class="flex gap-1 text-yellow-400 mb-3 drop-shadow-sm" aria-label="<?php echo esc_attr( $review['rating'] . ' star rating' ); ?>">
									<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
										<svg class="w-4 h-4 <?php echo $i <= $review['rating'] ? 'fill-current' : 'text-slate-200 fill-current'; ?>" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
									<?php endfor; ?>
								</div>

								<p class="text-slate-600 text-sm leading-relaxed flex-1 mb-6 font-medium italic">"<?php echo esc_html( $review['content'] ); ?>"</p>

								<a href="<?php echo esc_url( $review['product_link'] ); ?>" class="flex items-center gap-3 pt-3 border-t border-slate-100 group/product hover:bg-slate-50 -mx-2 px-2 pb-1 rounded-lg transition-colors">
									<img src="<?php echo esc_url( $review['product_image'] ); ?>" alt="<?php echo esc_attr( $review['product_name'] ); ?>" class="w-8 h-8 rounded object-cover bg-slate-100 flex-shrink-0" loading="lazy" decoding="async" />
									<div class="flex-1 min-w-0">
										<h5 class="text-xs font-bold text-slate-800 truncate group-hover/product:text-[#FF93AB] transition-colors"><?php echo esc_html( $review['product_name'] ); ?></h5>
										<span class="text-[9px] text-slate-400 uppercase tracking-wider font-bold">View Product</span>
									</div>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
			
			<button class="carousel-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-6 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-md border border-slate-100 hover:bg-[#FF93AB] hover:border-[#FF93AB] hover:text-white transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100" aria-label="Previous reviews">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
			</button>
			<button class="carousel-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-6 z-10 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white shadow-md border border-slate-100 hover:bg-[#FF93AB] hover:border-[#FF93AB] hover:text-white transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100" aria-label="Next reviews">
				<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
			</button>
		</div>

		<div class="carousel-indicators flex justify-center gap-2 px-4 mt-8" aria-label="Carousel Pagination"></div>
	</div>
	</div>
</section>

<script>
(function () {
	const root = document.querySelector('.review-carousel-wrapper');
	if (!root) return;

	const track = root.querySelector('.carousel-track');
	const slides = Array.from(root.querySelectorAll('.carousel-slide'));
	const prevBtn = root.querySelector('.carousel-prev');
	const nextBtn = root.querySelector('.carousel-next');
	const dotsWrap = root.querySelector('.carousel-indicators');
	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	let index = 0;
	let dots = [];

	function getItemsPerView() {
		if (window.innerWidth < 640) return 1;
		if (window.innerWidth < 1024) return 2;
		if (window.innerWidth < 1280) return 3;
		return 4;
	}

	function getMaxIndex() {
		return Math.max(0, slides.length - getItemsPerView());
	}

	function buildDots() {
		dotsWrap.innerHTML = '';
		const pages = getMaxIndex() + 1;
		for (let i = 0; i < pages; i += 1) {
			const dot = document.createElement('button');
			dot.type = 'button';
			dot.className = 'h-2.5 w-2.5 rounded-full transition-all duration-300 bg-slate-300 hover:bg-slate-400';
			dot.setAttribute('aria-label', 'Go to review slide ' + (i + 1));
			dot.addEventListener('click', function () {
				index = i;
				update();
			});
			dotsWrap.appendChild(dot);
		}
		dots = Array.from(dotsWrap.querySelectorAll('button'));
	}

	function updateDots() {
		dots.forEach(function (dot, dotIndex) {
			const active = dotIndex === index;
			dot.classList.toggle('bg-[#FF93AB]', active);
			dot.classList.toggle('w-8', active);
			dot.classList.toggle('bg-slate-300', !active);
			dot.classList.toggle('w-2.5', !active);
		});
	}

	function updateButtons() {
		const max = getMaxIndex();
		prevBtn.disabled = index <= 0;
		nextBtn.disabled = index >= max;
		prevBtn.classList.toggle('opacity-40', prevBtn.disabled);
		nextBtn.classList.toggle('opacity-40', nextBtn.disabled);
	}

	function update() {
		const itemsPerView = getItemsPerView();
		const max = getMaxIndex();
		if (index > max) index = max;
		if (index < 0) index = 0;

		track.style.transitionDuration = reducedMotion ? '1ms' : '700ms';
		track.style.transform = 'translate3d(-' + (index * (100 / itemsPerView)) + '%, 0, 0)';

		updateButtons();
		updateDots();
	}

	function next() {
		index = Math.min(index + 1, getMaxIndex());
		update();
	}

	function prev() {
		index = Math.max(index - 1, 0);
		update();
	}

	prevBtn.addEventListener('click', prev);
	nextBtn.addEventListener('click', next);
	root.addEventListener('keydown', function (event) {
		if (event.key === 'ArrowLeft') prev();
		if (event.key === 'ArrowRight') next();
	});
	window.addEventListener('resize', function () {
		buildDots();
		update();
	}, { passive: true });

	buildDots();
	update();
})();
</script>