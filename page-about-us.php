<?php
/**
 * Template Name: About Us
 * Template Post Type: page
 *
 * Brand story page for Julia Cartoonery.
 */

get_header(); ?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<section class="relative overflow-hidden bg-gradient-to-b from-pink-50 via-white to-sky-50 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900">
			<div class="absolute inset-x-0 top-0 h-72 bg-[radial-gradient(circle_at_top_left,_rgba(255,183,197,0.30),_transparent_54%),radial-gradient(circle_at_top_right,_rgba(168,216,234,0.28),_transparent_48%)] pointer-events-none"></div>
			<div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
				<div class="grid gap-10 lg:grid-cols-2 lg:items-center">
					<div class="order-2 lg:order-1">
						<div class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-white/80 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-200">
							<span class="h-2 w-2 rounded-full bg-pink-500"></span>
							A toy store built on love, safety, and imagination
						</div>
						<h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">About Julia Cartoonery</h1>
						<p class="mt-5 max-w-2xl text-base sm:text-lg leading-8 text-slate-600 dark:text-slate-300">Julia Cartoonery began with a simple belief: childhood should feel magical, safe, and full of discovery. We help parents choose toys that spark creativity, support learning, and bring genuine joy into everyday play.</p>
						<div class="mt-8 grid gap-4 sm:grid-cols-3">
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Safe toys</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Parent-first</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Educational</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Play with purpose</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Joyful</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Made to delight</p>
							</div>
						</div>
					</div>

					<div class="order-1 lg:order-2">
						<div class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-[0_20px_60px_rgba(15,23,42,0.12)] dark:border-slate-700 dark:bg-slate-900/80">
							<div class="aspect-[4/5] min-h-[420px] bg-[linear-gradient(135deg,_rgba(255,183,197,0.22),_rgba(168,216,234,0.22))] dark:bg-[linear-gradient(135deg,_rgba(255,183,197,0.08),_rgba(168,216,234,0.08))] flex items-center justify-center p-6">
								<div class="w-full max-w-sm rounded-[2rem] border border-dashed border-white/80 bg-white/70 p-8 text-center backdrop-blur dark:border-slate-600 dark:bg-slate-900/60">
									<div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-pink-100 to-sky-100 text-pink-500 dark:from-pink-500/15 dark:to-sky-500/15 dark:text-pink-300">
										<svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
											<path d="M12 2c1.9 0 3.6 1.06 4.45 2.76A5 5 0 0 1 21 10v2a3 3 0 0 1-3 3h-1v-1a5 5 0 0 0-5-5H9a5 5 0 0 0-5 5v1H3a3 3 0 0 1-3-3v-2a5 5 0 0 1 4.55-5.24A5 5 0 0 1 12 2Zm-1 8h2a3 3 0 0 1 3 3v1H8v-1a3 3 0 0 1 3-3Zm-5 7h12a4 4 0 0 1-4 4H10a4 4 0 0 1-4-4Z"></path>
										</svg>
									</div>
									<p class="mt-6 text-sm font-semibold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Image placeholder</p>
									<h2 class="mt-3 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Place Julia here</h2>
									<p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">Swap this placeholder with a brand portrait, illustration, or a joyful toy moment that represents Julia Cartoonery's playful spirit.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-14 lg:py-20 bg-white dark:bg-slate-950">
			<div class="container mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
					<div class="rounded-[2rem] border border-pink-100 bg-pink-50/70 p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
						<p class="text-sm font-semibold uppercase tracking-[0.24em] text-pink-600 dark:text-pink-300">Meet Julia</p>
						<h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">The playful imagination behind the brand</h2>
						<p class="mt-4 text-slate-600 dark:text-slate-300 leading-8">Julia is not just a name. She is our friendly imagination guide: curious, kind, and always looking for the next little adventure. She represents the childlike wonder we want every family to feel when choosing a new toy.</p>
						<div class="mt-6 space-y-4">
							<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-800">
								<p class="font-bold text-slate-950 dark:text-white">What Julia stands for</p>
								<p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">Endless imagination, safe exploration, and joyful learning through play.</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-800">
								<p class="font-bold text-slate-950 dark:text-white">Our promise to parents</p>
								<p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">Every product is chosen to feel fun for kids and reassuring for grown-ups.</p>
							</div>
						</div>
					</div>

					<div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-8 dark:border-slate-800 dark:bg-slate-900">
						<p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600 dark:text-sky-300">Why we exist</p>
						<h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Safe, educational, and joyful toys</h2>
						<p class="mt-4 text-slate-600 dark:text-slate-300 leading-8">Parents want toys that do more than entertain. They want confidence. They want good value. They want something their child will actually love. Julia Cartoonery is built around that emotional need.</p>
						<div class="mt-8 grid gap-4 sm:grid-cols-3">
							<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-800">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Safety</p>
								<p class="mt-2 text-base font-bold text-slate-950 dark:text-white">Chosen with care</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-800">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Learning</p>
								<p class="mt-2 text-base font-bold text-slate-950 dark:text-white">Play with purpose</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-800">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Joy</p>
								<p class="mt-2 text-base font-bold text-slate-950 dark:text-white">Made to smile</p>
							</div>
						</div>
						<div class="mt-8 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">
							<p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Brand voice</p>
							<p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Warm, trustworthy, and playful, with a focus on helping families make better toy choices without pressure or confusion.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="border-t border-pink-100 bg-gradient-to-r from-pink-100 via-white to-sky-100 py-12 dark:border-slate-800 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900">
			<div class="container mx-auto px-4 sm:px-6 lg:px-8">
				<div class="rounded-[2rem] bg-white p-8 shadow-lg ring-1 ring-slate-100 dark:bg-slate-900 dark:ring-slate-800">
					<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
						<div>
							<p class="text-sm font-semibold uppercase tracking-[0.24em] text-pink-600 dark:text-pink-300">Our mission</p>
							<h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Helping childhood feel joyful and safe</h2>
							<p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-300">Julia Cartoonery is here to make every purchase feel thoughtful: toys that inspire imagination, support learning, and bring happiness to both children and parents.</p>
						</div>
						<div class="flex flex-col gap-3 sm:flex-row">
							<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="inline-flex items-center justify-center rounded-full bg-pink-500 px-6 py-3 text-sm font-black text-white transition-colors hover:bg-pink-600" style="font-family: 'Bubblegum Sans', cursive;">Shop Toys</a>
							<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-black text-white transition-colors hover:bg-slate-800 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100" style="font-family: 'Bubblegum Sans', cursive;">Contact Us</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</article>
</main>

<?php get_footer();