<?php
/**
 * Template part for displaying the Product Categories Section.
 * Premium Apple-style Glassmorphism UI with Tailwind CSS.
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// Fetch top 6 product categories
$categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true, // Show only categories with products
	'number'     => 6,    // Number of categories to display
	'orderby'    => 'count', // Sort by most popular
	'order'      => 'DESC',
	'exclude'    => array( get_option( 'default_product_cat' ) ), // Hide 'Uncategorized'
) );

if ( empty( $categories ) || is_wp_error( $categories ) ) {
	return;
}
?>

<section class="py-16 sm:py-20 relative overflow-hidden bg-white dark:bg-slate-950">
	<!-- Soft ambient background glow -->
	<div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-[#FF93AB]/5 via-white to-white dark:from-[#FF93AB]/10 dark:via-slate-900 dark:to-slate-950 pointer-events-none"></div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
		
		<div class="text-center max-w-2xl mx-auto mb-16">
			<p class="text-xs font-black uppercase tracking-[0.3em] text-[#FF93AB] mb-4">Explore the Magic</p>
			<h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
				Shop by <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF93AB] to-[#FFB7C5]">Category</span>
			</h2>
		</div>

		<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 sm:gap-8">
			<?php foreach ( $categories as $category ) : 
				$cat_link = get_term_link( $category );
				$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : wc_placeholder_img_src();
			?>
				
				<a href="<?php echo esc_url( $cat_link ); ?>" class="group flex flex-col items-center text-center outline-none">
					
					<!-- Premium Glassmorphism Outer Ring -->
					<div class="relative w-36 h-36 sm:w-44 sm:h-44 rounded-full p-[6px] bg-gradient-to-br from-white/80 to-white/30 dark:from-slate-800/85 dark:to-slate-800/45 backdrop-blur-md shadow-[0_8px_32px_rgba(0,0,0,0.06)] dark:shadow-[0_8px_32px_rgba(2,6,23,0.45)] hover:shadow-[0_20px_48px_rgba(255,147,171,0.25)] transition-all duration-500 ease-out group-hover:-translate-y-2 group-focus-visible:ring-4 ring-[#FF93AB]/50 ring-offset-2 dark:ring-offset-slate-900 z-10">
						
						<!-- Inner Image Container -->
						<div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-800 relative ring-1 ring-slate-900/5 dark:ring-slate-700/60 group-hover:ring-[#FF93AB]/50 transition-all duration-500">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out will-change-transform" loading="lazy" decoding="async" />
							
							<!-- Soft overlay on hover -->
							<div class="absolute inset-0 bg-gradient-to-t from-[#FF93AB]/20 dark:from-[#FF93AB]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none mix-blend-overlay"></div>
						</div>
					</div>

					<div class="mt-6 flex flex-col items-center transform transition-transform duration-500 group-hover:-translate-y-1">
						<h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-[#FF93AB] transition-colors duration-300">
							<?php echo esc_html( $category->name ); ?>
						</h3>
						<span class="inline-flex items-center mt-1.5 px-2.5 py-0.5 rounded-full bg-slate-50 dark:bg-slate-800 text-[11px] font-bold text-slate-500 dark:text-slate-300 uppercase tracking-wider group-hover:bg-[#FF93AB]/10 group-hover:text-[#FF93AB] transition-colors duration-300">
							<?php echo esc_html( $category->count ); ?> Items
						</span>
					</div>
					
				</a>

			<?php endforeach; ?>
		</div>

	</div>
</section>
