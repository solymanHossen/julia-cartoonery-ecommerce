<?php
/**
 * Template part for displaying the Flash Sale section.
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

$sale_deadline_gmt = function_exists( 'julias_cartoonery_get_flash_sale_deadline' ) ? julias_cartoonery_get_flash_sale_deadline() : '';

if ( empty( $sale_deadline_gmt ) ) {
	$next_sunday = new DateTimeImmutable( 'next sunday 23:59:59', wp_timezone() );
	$sale_deadline_gmt = $next_sunday->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'c' );
}
?>


<section class="flash-sale-section py-16 sm:py-24" data-sale-deadline="<?php echo esc_attr( $sale_deadline_gmt ); ?>">
	<div class="flash-sale-section__bg" aria-hidden="true"></div>
	<div class="flash-sale-section__container container  mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
		<div class="flash-sale-hero max-w-7xl mx-auto">
			<div class="flash-sale-hero__content">
				<div class="flash-sale-hero__badge">
					<span class="flash-sale-hero__badge-dot" aria-hidden="true"></span>
					<span><?php esc_html_e( 'Limited Time Offer', 'julias-cartoonery' ); ?></span>
				</div>
				<h2 class="flash-sale-hero__title">
					<?php esc_html_e( 'Flash Sale', 'julias-cartoonery' ); ?>
				</h2>
				<p class="flash-sale-hero__description">
					<?php esc_html_e( 'Big savings on Julia\'s favorite toys. New prices refresh weekly, so grab your picks before this window closes.', 'julias-cartoonery' ); ?>
				</p>
			</div>

			<div class="flash-sale-timer" role="timer" aria-live="polite" aria-label="<?php esc_attr_e( 'Countdown until this sale ends', 'julias-cartoonery' ); ?>">
				<div class="flash-sale-timer__unit">
					<span class="flash-sale-timer__value" data-timer-unit="days">00</span>
					<span class="flash-sale-timer__label"><?php esc_html_e( 'Days', 'julias-cartoonery' ); ?></span>
				</div>
				<div class="flash-sale-timer__unit">
					<span class="flash-sale-timer__value" data-timer-unit="hours">00</span>
					<span class="flash-sale-timer__label"><?php esc_html_e( 'Hours', 'julias-cartoonery' ); ?></span>
				</div>
				<div class="flash-sale-timer__unit">
					<span class="flash-sale-timer__value" data-timer-unit="minutes">00</span>
					<span class="flash-sale-timer__label"><?php esc_html_e( 'Mins', 'julias-cartoonery' ); ?></span>
				</div>
				<div class="flash-sale-timer__unit flash-sale-timer__unit--accent">
					<span class="flash-sale-timer__value" data-timer-unit="seconds">00</span>
					<span class="flash-sale-timer__label"><?php esc_html_e( 'Secs', 'julias-cartoonery' ); ?></span>
				</div>
			</div>
		</div>

		<div class="flash-sale-grid grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
			<?php 
			while ( $flash_sale_query->have_posts() ) : $flash_sale_query->the_post(); 
				global $product;

				if ( ! $product instanceof WC_Product ) {
					continue;
				}
				
				$product_link = $product->get_permalink();
				$image_id     = $product->get_image_id();
				
				$regular_price = (float) $product->get_regular_price();
				$sale_price    = (float) $product->get_price();
				$discount_perc = 0;
				if ( $regular_price > 0 ) {
					$discount_perc = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
				}

				// Keep progress stable per product so cards do not jump between refreshes.
				$sold_percentage = 65 + ( $product->get_id() % 26 );
				if ( $product->managing_stock() && null !== $product->get_stock_quantity() ) {
					$stock_qty = (int) $product->get_stock_quantity();
					if ( $stock_qty <= 10 ) {
						$sold_percentage = max( $sold_percentage, 82 );
					}
					if ( $stock_qty <= 5 ) {
						$sold_percentage = max( $sold_percentage, 90 );
					}
				}
			?>
				<article class="flash-sale-card group">
					
					<?php if ( $discount_perc > 0 ) : ?>
						<div class="flash-sale-card__discount">
							SAVE <?php echo esc_html( $discount_perc ); ?>%
						</div>
					<?php endif; ?>

					<div class="flash-sale-card__media">
						<a href="<?php echo esc_url( $product_link ); ?>" class="block w-full h-full">
							<?php 
							if ( $image_id ) {
								echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'class' => 'flash-sale-card__image' ) );
							} else {
								echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" class="flash-sale-card__image" alt="" />';
							}
							?>
						</a>
					</div>

					<div class="flash-sale-card__body">
						<div>
							<a href="<?php echo esc_url( $product_link ); ?>">
								<h3 class="flash-sale-card__title line-clamp-2">
									<?php echo esc_html( $product->get_name() ); ?>
								</h3>
							</a>
							
							<div class="flash-sale-card__price-wrap">
								<span class="flash-sale-card__sale-price">
									<?php echo wc_price( $sale_price ); ?>
								</span>
								<?php if ( $regular_price > $sale_price ) : ?>
									<span class="flash-sale-card__regular-price">
										<?php echo wc_price( $regular_price ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>

						<div class="flash-sale-card__meta">
							<div class="flash-sale-card__stock-row">
								<span class="flash-sale-card__stock-label">
									<?php esc_html_e( 'Almost sold out', 'julias-cartoonery' ); ?>
								</span>
								<span class="flash-sale-card__stock-value"><?php echo esc_html( $sold_percentage ); ?>% <?php esc_html_e( 'claimed', 'julias-cartoonery' ); ?></span>
							</div>
							<div class="flash-sale-card__stock-track" aria-hidden="true">
								<div class="flash-sale-card__stock-fill" style="width: <?php echo esc_attr( $sold_percentage ); ?>%"></div>
							</div>
							
							<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart flash-sale-card__cta" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
								<?php esc_html_e( 'Add to Cart', 'julias-cartoonery' ); ?>
							</a>
						</div>
					</div>
				</article>
			<?php 
			endwhile; 
			wp_reset_postdata(); 
			?>
		</div>

	</div>
</section>
