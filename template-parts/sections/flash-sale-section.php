<?php
/**
 * Template part for displaying the Flash Sale / Deal of the Week Section.
 * Features a dynamic Countdown Timer and Premium Glassmorphism UI.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// Get IDs of products that are on sale
$product_ids_on_sale = wc_get_product_ids_on_sale();

if ( empty( $product_ids_on_sale ) ) {
	return; // Hide section if no products are on sale
}

// Query 4 latest sale products
$flash_sale_args = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 4,
	'post__in'       => $product_ids_on_sale,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

$flash_sale_query = new WP_Query( $flash_sale_args );

if ( ! $flash_sale_query->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>

<section class="py-16 sm:py-24 relative overflow-hidden bg-gradient-to-br from-violet-950 via-fuchsia-900 to-violet-950">
	<!-- Ambient Glowing Blobs -->
	<div class="absolute inset-0 overflow-hidden pointer-events-none">
		<div class="absolute -top-[20%] -left-[10%] w-[50vw] h-[50vw] bg-fuchsia-500/30 rounded-full blur-[100px] mix-blend-screen opacity-60"></div>
		<div class="absolute top-[60%] -right-[10%] w-[40vw] h-[60vw] bg-[#FF93AB]/20 rounded-full blur-[120px] mix-blend-screen opacity-60"></div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
		
		<!-- Hero Header & Timer -->
		<div class="flex flex-col xl:flex-row items-center justify-between gap-8 mb-12 sm:mb-16 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 sm:p-12 shadow-[0_8px_32px_rgba(0,0,0,0.3)]">
			
			<div class="text-center xl:text-left flex-1">
				<div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500/20 border border-red-500/30 text-red-200 mb-6 shadow-[0_0_15px_rgba(239,68,68,0.3)]">
					<span class="animate-pulse">⚡</span>
					<span class="text-xs font-black uppercase tracking-[0.2em]">Limited Time Offer</span>
				</div>
				<h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
					Flash <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-yellow-400 to-orange-500">Sale</span>
				</h2>
				<p class="mt-4 text-violet-200 font-medium text-base sm:text-lg max-w-xl mx-auto xl:mx-0">
					Massive discounts on premium toys. Once the timer hits zero, these deals are gone forever!
				</p>
			</div>

			<!-- Apple/Nike Style Timer -->
			<div class="flex items-center gap-2 sm:gap-4 shrink-0">
				<div class="flex flex-col items-center justify-center w-16 h-16 sm:w-24 sm:h-24 bg-black/20 backdrop-blur-md rounded-2xl sm:rounded-3xl border border-white/10 shadow-inner">
					<span id="fomo-days" class="text-2xl sm:text-4xl font-black text-white tabular-nums tracking-tighter">00</span>
					<span class="text-[9px] sm:text-xs font-bold text-violet-300/80 uppercase tracking-widest mt-1">Days</span>
				</div>
				<span class="text-xl sm:text-3xl font-black text-white/30 pb-4 sm:pb-6">:</span>
				<div class="flex flex-col items-center justify-center w-16 h-16 sm:w-24 sm:h-24 bg-black/20 backdrop-blur-md rounded-2xl sm:rounded-3xl border border-white/10 shadow-inner">
					<span id="fomo-hours" class="text-2xl sm:text-4xl font-black text-white tabular-nums tracking-tighter">00</span>
					<span class="text-[9px] sm:text-xs font-bold text-violet-300/80 uppercase tracking-widest mt-1">Hrs</span>
				</div>
				<span class="text-xl sm:text-3xl font-black text-white/30 pb-4 sm:pb-6">:</span>
				<div class="flex flex-col items-center justify-center w-16 h-16 sm:w-24 sm:h-24 bg-black/20 backdrop-blur-md rounded-2xl sm:rounded-3xl border border-white/10 shadow-inner">
					<span id="fomo-mins" class="text-2xl sm:text-4xl font-black text-white tabular-nums tracking-tighter">00</span>
					<span class="text-[9px] sm:text-xs font-bold text-violet-300/80 uppercase tracking-widest mt-1">Mins</span>
				</div>
				<span class="text-xl sm:text-3xl font-black text-white/30 pb-4 sm:pb-6">:</span>
				<div class="flex flex-col items-center justify-center w-16 h-16 sm:w-24 sm:h-24 bg-black/20 backdrop-blur-md rounded-2xl sm:rounded-3xl border border-white/10 shadow-inner shadow-yellow-500/10 border-yellow-500/20">
					<span id="fomo-secs" class="text-2xl sm:text-4xl font-black text-yellow-400 tabular-nums tracking-tighter">00</span>
					<span class="text-[9px] sm:text-xs font-bold text-yellow-500/80 uppercase tracking-widest mt-1">Secs</span>
				</div>
			</div>
		</div>

		<!-- Products Grid -->
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
			<?php 
			while ( $flash_sale_query->have_posts() ) : $flash_sale_query->the_post(); 
				global $product;
				
				$product_link = $product->get_permalink();
				$image_id	 = $product->get_image_id();
				
				// Calculate Discount Percentage
				$regular_price = (float) $product->get_regular_price();
				$sale_price	= (float) $product->get_price();
				$discount_perc = 0;
				if ( $regular_price > 0 ) {
					$discount_perc = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
				}
				
				// FOMO Stock Bar (Randomized between 75% and 98% for psychological effect)
				$sold_percentage = rand(75, 98);
			?>
				<div class="group relative flex flex-col bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-5 hover:-translate-y-2 transition-all duration-500 shadow-[0_8px_30px_rgba(0,0,0,0.2)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] hover:bg-white/10">
					
					<?php if ( $discount_perc > 0 ) : ?>
						<div class="absolute top-4 left-4 z-20 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[11px] font-black px-3 py-1.5 rounded-full shadow-[0_0_15px_rgba(239,68,68,0.5)]">
							SAVE <?php echo esc_html( $discount_perc ); ?>%
						</div>
					<?php endif; ?>

					<div class="relative w-full h-56 sm:h-64 rounded-2xl overflow-hidden bg-black/20 mb-6">
						<a href="<?php echo esc_url( $product_link ); ?>" class="block w-full h-full">
							<?php 
							if ( $image_id ) {
								echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'class' => 'w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out' ) );
							} else {
								echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" class="w-full h-full object-cover" />';
							}
							?>
						</a>
						<div class="absolute inset-0 bg-gradient-to-t from-violet-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
					</div>

					<div class="flex-1 flex flex-col justify-between z-10">
						<div>
							<a href="<?php echo esc_url( $product_link ); ?>">
								<h3 class="text-white font-bold text-lg line-clamp-2 leading-tight group-hover:text-yellow-300 transition-colors">
									<?php echo esc_html( $product->get_name() ); ?>
								</h3>
							</a>
							
							<div class="mt-4 flex items-end gap-3">
								<span class="text-yellow-400 font-black text-2xl leading-none">
									<?php echo wc_price( $sale_price ); ?>
								</span>
								<?php if ( $regular_price > $sale_price ) : ?>
									<span class="text-white/40 font-medium text-sm line-through mb-0.5">
										<?php echo wc_price( $regular_price ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>

						<div class="mt-6 pt-6 border-t border-white/10">
							<div class="flex justify-between items-end mb-2.5">
								<span class="text-[10px] font-black text-red-400 uppercase tracking-widest flex items-center gap-1">
									<svg class="w-3 h-3 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
									Almost Sold Out!
								</span>
								<span class="text-[10px] font-bold text-white/60 tabular-nums"><?php echo $sold_percentage; ?>% Claimed</span>
							</div>
							<div class="w-full h-2.5 bg-black/30 rounded-full overflow-hidden shadow-inner relative">
								<div class="absolute top-0 left-0 h-full bg-gradient-to-r from-red-500 via-orange-500 to-yellow-400 rounded-full" style="width: <?php echo $sold_percentage; ?>%">
									<div class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_2s_infinite]"></div>
								</div>
							</div>
							
							<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart mt-5 w-full block text-center py-3.5 bg-white text-violet-950 font-black uppercase text-sm rounded-xl hover:bg-yellow-400 hover:text-violet-950 hover:shadow-[0_0_20px_rgba(250,204,21,0.4)] transition-all duration-300 transform active:scale-95" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
								Add to Cart
							</a>
						</div>
					</div>
				</div>
			<?php 
			endwhile; 
			wp_reset_postdata(); 
			?>
		</div>

	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	function getNextSunday() {
		const d = new Date();
		d.setDate(d.getDate() + (7 - d.getDay()) % 7);
		d.setHours(23, 59, 59, 0);
		if (d.getTime() < new Date().getTime()) {
			d.setDate(d.getDate() + 7);
		}
		return d.getTime();
	}

	const targetDate = getNextSunday();

	const elDays = document.getElementById('fomo-days');
	const elHours = document.getElementById('fomo-hours');
	const elMins = document.getElementById('fomo-mins');
	const elSecs = document.getElementById('fomo-secs');

	function updateTimer() {
		if (!elDays) return;
		const now = new Date().getTime();
		const distance = targetDate - now;

		if (distance < 0) return;

		const days = Math.floor(distance / (1000 * 60 * 60 * 24));
		const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		const seconds = Math.floor((distance % (1000 * 60)) / 1000);

		elDays.innerText = days.toString().padStart(2, '0');
		elHours.innerText = hours.toString().padStart(2, '0');
		elMins.innerText = minutes.toString().padStart(2, '0');
		elSecs.innerText = seconds.toString().padStart(2, '0');
	}

	setInterval(updateTimer, 1000);
	updateTimer();
});
</script>
