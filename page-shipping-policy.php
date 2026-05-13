<?php
/**
 * Template Name: Shipping & Delivery Policy
 * Template Post Type: page
 *
 * Displays the shipping and delivery policy for Julia's Cartoonery
 * All content is managed through wp-admin Customizer
 */

get_header(); ?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<!-- Hero Section -->
		<section class="py-12 lg:py-20 bg-gradient-to-b from-pink-50 via-white to-blue-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900">
			<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center">
					<h1 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-4" style="font-family: 'Bubblegum Sans', cursive;">
						<?php echo esc_html( get_theme_mod( 'julia_shipping_hero_title', 'Shipping & Delivery' ) ); ?>
					</h1>
					<p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
						<?php echo esc_html( get_theme_mod( 'julia_shipping_hero_description', 'We ensure your toys reach safely and on time! Fast, reliable delivery across Bangladesh.' ) ); ?>
					</p>
				</div>
			</div>
		</section>

		<!-- Main Content -->
		<section class="py-12 lg:py-20 bg-white dark:bg-slate-950">
			<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
				
				<!-- Delivery Options Grid -->
				<div class="grid md:grid-cols-2 gap-8 mb-16">
					
					<!-- Inside Dhaka -->
					<div class="bg-gradient-to-br from-pink-50 to-rose-50 dark:from-slate-800 dark:to-slate-800 rounded-2xl p-8 border-2 border-pink-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
						<div class="flex items-center mb-6">
							<!-- Delivery Truck Icon -->
							<svg class="w-16 h-16 text-pink-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path d="M18 18.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0M2 3h14v9H2V3m1 12h11v2H3v-2m15-2V8h3l2 4v6h-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0h1v-5h-2V9h-3v7a2 2 0 0 0-2 2v2h1"></path>
							</svg>
							<h2 class="text-2xl font-black text-slate-900 dark:text-white ml-4" style="font-family: 'Bubblegum Sans', cursive;">
								<?php echo esc_html( get_theme_mod( 'julia_shipping_dhaka_title', 'Inside Dhaka' ) ); ?>
							</h2>
						</div>
						<div class="space-y-4">
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-pink-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Delivery Time</p>
									<p class="text-slate-600 dark:text-slate-300">
										<?php echo esc_html( get_theme_mod( 'julia_shipping_dhaka_time', '24-48 hours' ) ); ?>
									</p>
								</div>
							</div>
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-pink-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Shipping Cost</p>
									<p class="text-2xl font-black text-pink-500 dark:text-pink-400">
										৳<?php echo esc_html( get_theme_mod( 'julia_shipping_dhaka_cost', '60' ) ); ?>
									</p>
								</div>
							</div>
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-pink-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Coverage</p>
									<p class="text-slate-600 dark:text-slate-300">
										<?php echo esc_html( get_theme_mod( 'julia_shipping_dhaka_coverage', 'All areas within Dhaka city' ) ); ?>
									</p>
								</div>
							</div>
						</div>
					</div>

					<!-- Outside Dhaka -->
					<div class="bg-gradient-to-br from-blue-50 to-sky-50 dark:from-slate-800 dark:to-slate-800 rounded-2xl p-8 border-2 border-blue-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
						<div class="flex items-center mb-6">
							<!-- Delivery Box Icon -->
							<svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7M3 7l1.5-3h15L21 7M7.5 12v4M12 12v4M16.5 12v4"></path>
							</svg>
							<h2 class="text-2xl font-black text-slate-900 dark:text-white ml-4" style="font-family: 'Bubblegum Sans', cursive;">
								<?php echo esc_html( get_theme_mod( 'julia_shipping_outside_title', 'Outside Dhaka' ) ); ?>
							</h2>
						</div>
						<div class="space-y-4">
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-blue-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Delivery Time</p>
									<p class="text-slate-600 dark:text-slate-300">
										<?php echo esc_html( get_theme_mod( 'julia_shipping_outside_time', '3-5 business days' ) ); ?>
									</p>
								</div>
							</div>
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-blue-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Shipping Cost</p>
									<p class="text-2xl font-black text-blue-500 dark:text-blue-400">
										৳<?php echo esc_html( get_theme_mod( 'julia_shipping_outside_cost', '120' ) ); ?>
									</p>
								</div>
							</div>
							<div class="flex items-start">
								<span class="inline-block w-3 h-3 bg-blue-500 rounded-full mt-1.5 mr-3 flex-shrink-0"></span>
								<div>
									<p class="font-bold text-slate-900 dark:text-slate-100">Partners</p>
									<p class="text-slate-600 dark:text-slate-300">
										<?php echo esc_html( get_theme_mod( 'julia_shipping_outside_partners', 'Pathao & Steadfast' ) ); ?>
									</p>
								</div>
							</div>
						</div>
					</div>

				</div>

				<!-- COD Section -->
				<div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-slate-800 dark:to-slate-800 rounded-2xl p-8 mb-12 border-l-4 border-emerald-500">
					<div class="flex items-start">
						<!-- Cash Icon -->
						<svg class="w-10 h-10 text-emerald-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
						</svg>
						<div class="ml-4">
							<h3 class="text-xl font-black text-slate-900 dark:text-white mb-2" style="font-family: 'Bubblegum Sans', cursive;">
								<?php echo esc_html( get_theme_mod( 'julia_shipping_cod_title', '💳 Cash on Delivery (COD)' ) ); ?>
							</h3>
							<p class="text-slate-700 dark:text-slate-300">
								<?php echo esc_html( get_theme_mod( 'julia_shipping_cod_description', 'Pay when you receive your order! Cash on Delivery is available for all areas across Bangladesh. Order with confidence—pay only when you see your package!' ) ); ?>
							</p>
						</div>
					</div>
				</div>

				<!-- Important Information Section -->
				<div class="mb-12">
					<h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6" style="font-family: 'Bubblegum Sans', cursive;">
						📦 Important Information
					</h3>
					<div class="space-y-4">
						<div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 border-l-4 border-pink-500">
							<p class="text-slate-700 dark:text-slate-300">
								<strong>Order Processing:</strong> Orders are processed and dispatched within 24 hours of confirmation.
							</p>
						</div>
						<div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 border-l-4 border-blue-500">
							<p class="text-slate-700 dark:text-slate-300">
								<strong>Tracking:</strong> You'll receive a tracking number via email/SMS to track your delivery in real-time.
							</p>
						</div>
						<div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 border-l-4 border-emerald-500">
							<p class="text-slate-700 dark:text-slate-300">
								<strong>Packaging:</strong> All toys are carefully packaged to ensure they arrive in perfect condition. We use eco-friendly materials whenever possible.
							</p>
						</div>
						<div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 border-l-4 border-amber-500">
							<p class="text-slate-700 dark:text-slate-300">
								<strong>Delays:</strong> In case of unexpected delays, we'll keep you updated with a new delivery estimate.
							</p>
						</div>
					</div>
				</div>

				<!-- FAQ Section -->
				<div>
					<h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6" style="font-family: 'Bubblegum Sans', cursive;">
						❓ Frequently Asked Questions
					</h3>
					<div class="space-y-4">
						<details class="group bg-slate-50 dark:bg-slate-800 rounded-lg overflow-hidden">
							<summary class="flex items-center justify-between w-full p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
								<span class="font-bold text-slate-900 dark:text-white">What if I'm ordering on a weekend or holiday?</span>
								<svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
								</svg>
							</summary>
							<div class="px-4 pb-4 text-slate-700 dark:text-slate-300">
								<p>Orders placed on weekends or public holidays will be processed on the next working day. Delivery times will be calculated from your processing date.</p>
							</div>
						</details>

						<details class="group bg-slate-50 dark:bg-slate-800 rounded-lg overflow-hidden">
							<summary class="flex items-center justify-between w-full p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
								<span class="font-bold text-slate-900 dark:text-white">Can I change my delivery address after placing an order?</span>
								<svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
								</svg>
							</summary>
							<div class="px-4 pb-4 text-slate-700 dark:text-slate-300">
								<p>If your order hasn't been dispatched yet, you can contact us immediately to update your delivery address. Please note that once an order is dispatched, the address cannot be changed.</p>
							</div>
						</details>

						<details class="group bg-slate-50 dark:bg-slate-800 rounded-lg overflow-hidden">
							<summary class="flex items-center justify-between w-full p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
								<span class="font-bold text-slate-900 dark:text-white">What if my package is damaged upon delivery?</span>
								<svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
								</svg>
							</summary>
							<div class="px-4 pb-4 text-slate-700 dark:text-slate-300">
								<p>Please refuse the delivery or contact us immediately with photos of the damaged package. We'll arrange a replacement or refund at no extra cost.</p>
							</div>
						</details>

						<details class="group bg-slate-50 dark:bg-slate-800 rounded-lg overflow-hidden">
							<summary class="flex items-center justify-between w-full p-4 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
								<span class="font-bold text-slate-900 dark:text-white">Is there free shipping for orders above a certain amount?</span>
								<svg class="w-5 h-5 text-slate-600 dark:text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
								</svg>
							</summary>
							<div class="px-4 pb-4 text-slate-700 dark:text-slate-300">
								<p>Currently, our shipping rates are fixed as mentioned above. Check our promotions page regularly for special offers and free shipping events!</p>
							</div>
						</details>

					</div>
				</div>

			</div>
		</section>

		<!-- Contact CTA -->
		<section class="py-12 bg-gradient-to-r from-pink-100 to-blue-100 dark:from-slate-800 dark:to-slate-800">
			<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
				<h2 class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white mb-4" style="font-family: 'Bubblegum Sans', cursive;">
					Still have questions?
				</h2>
				<p class="text-slate-700 dark:text-slate-300 mb-6">
					Our customer support team is here to help! Reach out to us anytime.
				</p>
				<div class="flex flex-col sm:flex-row gap-4 justify-center">
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-black py-3 px-6 rounded-full transition-colors" style="font-family: 'Bubblegum Sans', cursive;">
						📞 Contact Us
					</a>
					<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="inline-block bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 font-black py-3 px-6 rounded-full transition-colors" style="font-family: 'Bubblegum Sans', cursive;">
						🛍️ Back to Shop
					</a>
				</div>
			</div>
		</section>

	</article>
</main>

<?php get_footer();

