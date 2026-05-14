<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 *
 * Contact page for Julia Cartoonery.
 */

get_header();

$contact_status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
$whatsapp_number = preg_replace( '/[^0-9]/', '', (string) get_theme_mod( 'julia_contact_whatsapp', '+8801XXXXXXXXX' ) );
$whatsapp_link = $whatsapp_number ? 'https://wa.me/' . $whatsapp_number . '?text=' . rawurlencode( 'Hello Julia Cartoonery, I need help with an order.' ) : 'https://wa.me/8801XXXXXXXXX';
?>

<main id="primary" class="site-main">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<section class="relative overflow-hidden bg-gradient-to-b from-pink-50 via-white to-violet-50 dark:from-slate-950 dark:via-slate-950 dark:to-slate-900">
			<div class="absolute inset-x-0 top-0 h-80 bg-[radial-gradient(circle_at_top_left,_rgba(255,147,171,0.34),_transparent_52%),radial-gradient(circle_at_top_right,_rgba(196,181,253,0.26),_transparent_46%)] pointer-events-none"></div>
			<div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
				<div class="grid gap-10 lg:grid-cols-2 lg:items-center">
					<div>
						<div class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-white/80 px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70 dark:text-slate-200">
							<span class="h-2 w-2 rounded-full bg-[#FF93AB]"></span>
							Fast responses for parents and gift buyers
						</div>
						<h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Contact Julia Cartoonery</h1>
						<p class="mt-5 max-w-2xl text-base sm:text-lg leading-8 text-slate-600 dark:text-slate-300">Need help choosing the right toy, checking an order, or asking about delivery? Reach out anytime. We keep the experience simple, warm, and reassuring for busy parents.</p>
						<div class="mt-8 grid gap-4 sm:grid-cols-3">
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Response style</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Friendly</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Support focus</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Quick help</p>
							</div>
							<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Tone</p>
								<p class="mt-2 text-lg font-black text-slate-950 dark:text-white">Calm & clear</p>
							</div>
						</div>
					</div>

					<div class="relative">
						<div class="rounded-[2rem] border border-white/70 bg-white/90 p-6 shadow-[0_20px_60px_rgba(15,23,42,0.12)] backdrop-blur dark:border-slate-700 dark:bg-slate-900/80">
							<div class="flex items-start gap-4">
								<div class="rounded-2xl bg-gradient-to-br from-pink-100 to-violet-100 p-4 text-[#FF93AB] dark:from-pink-500/15 dark:to-violet-500/15 dark:text-pink-300">
									<svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
										<path d="M16.24 11.51c.74-.74.74-1.95 0-2.69l-1.06-1.06c-.74-.74-1.95-.74-2.69 0l-.71.71-3.54-3.54.71-.71c.74-.74.74-1.95 0-2.69L7.89.47C7.15-.27 5.94-.27 5.2.47L3.78 1.89C2.82 2.85 2.4 4.22 2.66 5.56c.73 3.76 3.88 8.57 7.74 12.43s8.67 7.01 12.43 7.74c1.34.26 2.71-.16 3.67-1.12l1.42-1.42c.74-.74.74-1.95 0-2.69l-1.06-1.06c-.74-.74-1.95-.74-2.69 0l-.71.71-3.54-3.54.71-.71Z"></path>
									</svg>
								</div>
								<div>
									<p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">WhatsApp first</p>
									<h2 class="mt-2 text-2xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Prefer chat? Reach us instantly</h2>
									<p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">The WhatsApp button is perfect for quick product questions, order support, and parents who want a faster response.</p>
								</div>
							</div>
							<div class="mt-6 rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200 dark:bg-slate-800 dark:ring-slate-700">
								<p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Public contact details</p>
								<div class="mt-4 space-y-4">
									<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-900">
										<p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Address</p>
										<p class="mt-2 text-sm font-bold text-slate-950 dark:text-white"><?php echo esc_html( get_theme_mod( 'julia_contact_address', 'Dhaka, Bangladesh' ) ); ?></p>
									</div>
									<div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-slate-900">
										<p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Email</p>
										<p class="mt-2 text-sm font-bold text-slate-950 dark:text-white"><?php echo esc_html( get_theme_mod( 'julia_contact_email', get_option( 'admin_email' ) ) ); ?></p>
									</div>
								</div>
								<a href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex w-full items-center justify-center gap-3 rounded-full bg-gradient-to-r from-[#FF93AB] to-violet-500 px-6 py-4 text-base font-black text-white shadow-[0_0_0_6px_rgba(255,147,171,0.14),0_18px_35px_rgba(255,147,171,0.35)] transition-transform hover:-translate-y-0.5 hover:shadow-[0_0_0_6px_rgba(255,147,171,0.18),0_22px_40px_rgba(255,147,171,0.42)]" style="font-family: 'Bubblegum Sans', cursive;">
									<svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.966-.272-.099-.47-.149-.67.149-.198.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.787-1.48-1.758-1.654-2.057-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.15-.174.198-.298.297-.496.099-.198.05-.372-.025-.52-.074-.149-.67-1.612-.916-2.208-.242-.579-.487-.5-.67-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.073.148.198 2.095 3.2 5.076 4.487.71.306 1.263.488 1.694.624.711.226 1.36.194 1.871.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.29.173-1.413-.074-.124-.272-.198-.57-.347z"></path><path d="M12.004 2.003c-5.524 0-10 4.477-10 10 0 1.767.464 3.5 1.343 5.016L2 22l4.988-1.303a9.96 9.96 0 0 0 5.016 1.343c5.523 0 10-4.477 10-10s-4.477-10-10-10Zm0 18.126a8.04 8.04 0 0 1-4.089-1.115l-.293-.174-2.957.774.79-2.882-.191-.297a8.04 8.04 0 1 1 6.74 3.694Z"></path></svg>
									Chat on WhatsApp
								</a>
								<p class="mt-4 text-xs leading-6 text-slate-500 dark:text-slate-400"><?php echo esc_html( get_theme_mod( 'julia_contact_intro', 'We usually reply quickly during business hours.' ) ); ?></p>
							</div>
						</div>
					</div>

					<div class="relative">
						<div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.08)] dark:border-slate-800 dark:bg-slate-900">
							<p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Message us</p>
							<h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">Tell us what you need</h2>
							<p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">Use this form for order questions, product advice, or delivery support. We keep it short so parents can message quickly.</p>

							<?php if ( 'sent' === $contact_status ) : ?>
								<div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 dark:border-emerald-900/40 dark:bg-emerald-500/10 dark:text-emerald-300">Thanks. Your message has been sent successfully.</div>
							<?php elseif ( 'missing' === $contact_status || 'invalid' === $contact_status ) : ?>
								<div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700 dark:border-rose-900/40 dark:bg-rose-500/10 dark:text-rose-300">Please fill in all fields and try again.</div>
							<?php endif; ?>

							<form class="mt-6 space-y-4" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
								<input type="hidden" name="action" value="julias_contact_submit">
								<?php wp_nonce_field( 'julias_contact_submit', 'julias_contact_nonce' ); ?>
								<div>
									<label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_name">Name</label>
									<input id="contact_name" name="contact_name" type="text" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-950 outline-none transition focus:border-[#FF93AB] focus:bg-white focus:ring-4 focus:ring-[#FF93AB]/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900" placeholder="Your name">
								</div>
								<div>
									<label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_phone">Phone</label>
									<input id="contact_phone" name="contact_phone" type="tel" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-950 outline-none transition focus:border-[#FF93AB] focus:bg-white focus:ring-4 focus:ring-[#FF93AB]/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900" placeholder="01XXXXXXXXX">
								</div>
								<div>
									<label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300" for="contact_message">Message</label>
									<textarea id="contact_message" name="contact_message" rows="6" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-950 outline-none transition focus:border-[#FF93AB] focus:bg-white focus:ring-4 focus:ring-[#FF93AB]/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:bg-slate-900" placeholder="How can we help?"></textarea>
								</div>
								<button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-gradient-to-r from-[#FF93AB] to-violet-500 px-6 py-4 text-base font-black text-white shadow-[0_0_0_6px_rgba(255,147,171,0.12),0_18px_35px_rgba(255,147,171,0.28)] transition-transform hover:-translate-y-0.5" style="font-family: 'Bubblegum Sans', cursive;">Send Message</button>
							</form>
					</div>
				</div>
			</div>
		</section>
	</article>
</main>

<?php get_footer();