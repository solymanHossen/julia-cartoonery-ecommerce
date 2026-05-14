<?php
/**
 * Template Name: FAQ
 * Template Post Type: page
 *
 * High-converting FAQ page for Julia's Cartoonery.
 */

get_header();

$faq_sections = julias_cartoonery_get_faq_sections();
$faq_eyebrow = get_theme_mod( 'julia_faq_eyebrow', 'Cash on Delivery, fast shipping, and easy returns' );
$faq_title = get_theme_mod( 'julia_faq_title', 'Frequently Asked Questions' );
$faq_description = get_theme_mod( 'julia_faq_description', 'Find quick answers about delivery, payments, COD, and returns. Everything here is designed to reduce hesitation and help shoppers complete checkout with confidence.' );
$faq_inside_dhaka = get_theme_mod( 'julia_faq_inside_dhaka', '24-48 hours' );
$faq_outside_dhaka = get_theme_mod( 'julia_faq_outside_dhaka', '3-5 business days' );
$faq_payment = get_theme_mod( 'julia_faq_payment', 'COD available' );
$faq_trust_title = get_theme_mod( 'julia_faq_trust_title', 'Why shoppers feel safe ordering here' );
$faq_trust_description = get_theme_mod( 'julia_faq_trust_description', 'Clear delivery windows, simple returns, and COD support help reduce friction for Bangladeshi shoppers who want confidence before they click buy.' );
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<section class="relative overflow-hidden bg-gradient-to-b from-pink-50 via-white to-sky-50 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900">
			<div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top_left,_rgba(255,183,197,0.36),_transparent_38%),radial-gradient(circle_at_top_right,_rgba(168,216,234,0.32),_transparent_34%),radial-gradient(circle_at_bottom_center,_rgba(255,183,197,0.16),_transparent_40%)]"></div>
			<div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
				<div class="mx-auto max-w-4xl text-center">
					<div class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-white/80 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-200">
						<span class="h-2 w-2 rounded-full bg-[#FFB7C5]"></span>
						<?php echo esc_html( $faq_eyebrow ); ?>
					</div>
					<h1 class="mt-6 text-4xl font-black tracking-tight text-slate-950 sm:text-5xl lg:text-6xl dark:text-white" style="font-family: 'Bubblegum Sans', cursive;"><?php echo esc_html( $faq_title ); ?></h1>
					<p class="mx-auto mt-5 max-w-3xl text-base leading-8 text-slate-600 sm:text-lg dark:text-slate-300"><?php echo esc_html( $faq_description ); ?></p>

					<div class="mt-8 grid gap-4 sm:grid-cols-3">
						<div class="rounded-3xl bg-white/90 p-5 text-left shadow-[0_14px_40px_rgba(15,23,42,0.08)] ring-1 ring-pink-100 backdrop-blur dark:bg-slate-900/80 dark:ring-slate-700">
							<p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Inside Dhaka</p>
							<p class="mt-2 text-2xl font-black text-slate-950 dark:text-white"><?php echo esc_html( $faq_inside_dhaka ); ?></p>
						</div>
						<div class="rounded-3xl bg-white/90 p-5 text-left shadow-[0_14px_40px_rgba(15,23,42,0.08)] ring-1 ring-sky-100 backdrop-blur dark:bg-slate-900/80 dark:ring-slate-700">
							<p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Outside Dhaka</p>
							<p class="mt-2 text-2xl font-black text-slate-950 dark:text-white"><?php echo esc_html( $faq_outside_dhaka ); ?></p>
						</div>
						<div class="rounded-3xl bg-white/90 p-5 text-left shadow-[0_14px_40px_rgba(15,23,42,0.08)] ring-1 ring-emerald-100 backdrop-blur dark:bg-slate-900/80 dark:ring-slate-700">
							<p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Payment</p>
							<p class="mt-2 text-2xl font-black text-slate-950 dark:text-white"><?php echo esc_html( $faq_payment ); ?></p>
						</div>
					</div>
				</div>

				<div class="mx-auto mt-10 max-w-4xl rounded-[2rem] border border-white/70 bg-white/90 p-4 shadow-[0_18px_60px_rgba(15,23,42,0.12)] backdrop-blur dark:border-slate-700 dark:bg-slate-900/85 sm:p-5" data-faq-root>
					<label for="faq-search" class="sr-only">Search frequently asked questions</label>
					<div class="flex items-center gap-3 rounded-[1.4rem] border border-slate-200 bg-slate-50 px-4 py-3 transition focus-within:border-[#FFB7C5] focus-within:bg-white focus-within:ring-4 focus-within:ring-[#FFB7C5]/20 dark:border-slate-700 dark:bg-slate-800 dark:focus-within:border-[#A8D8EA] dark:focus-within:bg-slate-900 dark:focus-within:ring-[#A8D8EA]/20">
						<svg class="h-5 w-5 shrink-0 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"></path>
						</svg>
						<input id="faq-search" type="search" autocomplete="off" placeholder="Search delivery, COD, refunds, or any question" class="faq-search w-full border-0 bg-transparent p-0 text-base text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500" data-faq-search>
						<button type="button" class="hidden rounded-full bg-slate-200 px-3 py-1 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600" data-faq-clear>Clear</button>
					</div>
					<div class="mt-3 flex flex-wrap items-center justify-between gap-2 px-2 text-sm text-slate-500 dark:text-slate-400">
						<p data-faq-count>Showing all questions</p>
						<p>Try terms like COD, Dhaka, refund, tracking, or exchange.</p>
					</div>

					<div class="mt-8 space-y-8">
						<?php $section_index = 0; ?>
						<?php foreach ( $faq_sections as $section_label => $faqs ) : ?>
							<section class="faq-category" data-faq-category data-category-label="<?php echo esc_attr( strtolower( $section_label ) ); ?>">
								<div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
									<div>
										<p class="text-xs font-bold uppercase tracking-[0.3em] text-[#FF93AB] dark:text-[#FFB7C5]">Section</p>
										<h2 class="mt-2 text-2xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;"><?php echo esc_html( $section_label ); ?></h2>
									</div>
									<p class="text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( count( $faqs ) ); ?> questions</p>
								</div>

								<div class="space-y-4" data-faq-group>
									<?php foreach ( $faqs as $faq_index => $faq ) : ?>
										<?php
										$panel_id = sprintf( 'faq-panel-%d-%d', $section_index, $faq_index );
										$button_id = sprintf( 'faq-button-%d-%d', $section_index, $faq_index );
										?>
										<article class="faq-item overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_18px_45px_rgba(15,23,42,0.09)] dark:border-slate-700 dark:bg-slate-900" data-faq-item data-faq-text="<?php echo esc_attr( strtolower( $section_label . ' ' . $faq['question'] . ' ' . $faq['answer'] ) ); ?>">
											<h3 class="m-0">
												<button id="<?php echo esc_attr( $button_id ); ?>" type="button" class="faq-trigger flex w-full items-center justify-between gap-4 px-5 py-5 text-left transition-colors hover:bg-pink-50/70 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-[#FFB7C5]/25 dark:hover:bg-slate-800" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>" data-faq-trigger>
													<span class="pr-4 text-lg font-extrabold leading-7 text-slate-950 dark:text-white"><?php echo esc_html( $faq['question'] ); ?></span>
													<span class="faq-icon grid h-10 w-10 shrink-0 place-items-center rounded-full bg-slate-100 text-slate-700 transition-transform duration-300 dark:bg-slate-800 dark:text-slate-200" aria-hidden="true">
														<span class="faq-icon-plus relative block h-4 w-4">
															<span class="absolute left-1/2 top-1/2 h-0.5 w-4 -translate-x-1/2 -translate-y-1/2 rounded-full bg-current transition-transform duration-300"></span>
															<span class="absolute left-1/2 top-1/2 h-4 w-0.5 -translate-x-1/2 -translate-y-1/2 rounded-full bg-current transition-transform duration-300"></span>
														</span>
													</span>
												</button>
											</h3>
											<div id="<?php echo esc_attr( $panel_id ); ?>" class="faq-panel max-h-0 overflow-hidden opacity-0 transition-[max-height,opacity] duration-300 ease-out" role="region" aria-labelledby="<?php echo esc_attr( $button_id ); ?>" aria-hidden="true" data-faq-panel>
												<div class="px-5 pb-5 pt-0 text-base leading-8 text-slate-600 dark:text-slate-300">
													<p><?php echo esc_html( $faq['answer'] ); ?></p>
												</div>
											</div>
										</article>
									<?php endforeach; ?>
								</div>
							</section>
							<?php $section_index++; ?>
						<?php endforeach; ?>
					</div>

					<div class="mt-8 hidden rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50 p-6 text-center dark:border-slate-700 dark:bg-slate-800" data-faq-empty>
						<h2 class="text-2xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">No results found</h2>
						<p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">Try a different keyword like delivery, COD, Dhaka, exchange, or refund.</p>
						<div class="mt-5 flex flex-wrap items-center justify-center gap-3">
							<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="inline-flex items-center justify-center rounded-full bg-[#FF93AB] px-5 py-3 text-sm font-black text-white shadow-[0_10px_30px_rgba(255,147,171,0.28)] transition-transform hover:-translate-y-0.5" style="font-family: 'Bubblegum Sans', cursive;">Contact support</a>
							<a href="<?php echo esc_url( home_url( '/shipping-policy' ) ); ?>" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-black text-white transition-transform hover:-translate-y-0.5 dark:bg-white dark:text-slate-900" style="font-family: 'Bubblegum Sans', cursive;">View shipping policy</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="border-t border-slate-200 bg-white py-12 dark:border-slate-800 dark:bg-slate-950">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<div class="grid gap-6 lg:grid-cols-[1.5fr_1fr] lg:items-center">
					<div>
						<p class="text-xs font-bold uppercase tracking-[0.3em] text-[#FF93AB] dark:text-[#FFB7C5]">Trust factors</p>
							<h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;"><?php echo esc_html( $faq_trust_title ); ?></h2>
							<p class="mt-3 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300"><?php echo esc_html( $faq_trust_description ); ?></p>
					</div>
					<div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
						<div class="rounded-3xl bg-pink-50 p-5 ring-1 ring-pink-100 dark:bg-slate-900 dark:ring-slate-700">
							<p class="text-sm font-bold text-slate-900 dark:text-white">COD</p>
							<p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Pay when you receive the package.</p>
						</div>
						<div class="rounded-3xl bg-sky-50 p-5 ring-1 ring-sky-100 dark:bg-slate-900 dark:ring-slate-700">
							<p class="text-sm font-bold text-slate-900 dark:text-white">Fast shipping</p>
							<p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Quick dispatch inside and outside Dhaka.</p>
						</div>
						<div class="rounded-3xl bg-emerald-50 p-5 ring-1 ring-emerald-100 dark:bg-slate-900 dark:ring-slate-700">
							<p class="text-sm font-bold text-slate-900 dark:text-white">Easy returns</p>
							<p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Simple support if something arrives wrong.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</article>
</main>

<?php get_footer();