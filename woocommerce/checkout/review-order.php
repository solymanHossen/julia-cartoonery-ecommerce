<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<div class="space-y-6 mb-8">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div class="flex items-center gap-4 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<!-- Product Image with Quantity Badge -->
					<div class="relative flex-shrink-0">
						<div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
							<?php echo $_product->get_image('thumbnail', array('class' => 'w-full h-full object-cover')); ?>
						</div>
						<span class="absolute -top-2 -right-2 w-5 h-5 bg-slate-800 dark:bg-slate-100 text-white dark:text-slate-800 text-[10px] font-black rounded-full flex items-center justify-center shadow-sm">
							<?php echo $cart_item['quantity']; ?>
						</span>
					</div>

					<!-- Product Info -->
					<div class="flex-grow">
						<h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
						</h4>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						
						<?php 
						// Savings Badge if applicable
						if ( $_product->is_on_sale() ) {
							$regular_price = $_product->get_regular_price();
							$sale_price = $_product->get_sale_price();
							$savings = (float)$regular_price - (float)$sale_price;
							if ( $savings > 0 ) {
								echo '<span class="inline-block mt-1 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-[10px] font-bold rounded-full uppercase tracking-wider">Save ' . wc_price($savings * $cart_item['quantity']) . '</span>';
							}
						}
						?>
					</div>

					<!-- Product Total -->
					<div class="text-right flex flex-col items-end">
						<span class="text-sm font-black text-slate-800 dark:text-white">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<?php if ( $_product->is_on_sale() ) : ?>
							<span class="text-[10px] text-slate-400 line-through">
								<?php echo wc_price( $_product->get_regular_price() * $cart_item['quantity'] ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</div>

	<!-- Totals -->
	<div class="border-t border-slate-100 dark:border-slate-700/50 pt-6 space-y-3">
		
		<div class="flex justify-between items-center text-sm">
			<span class="text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
			<span class="font-bold text-slate-800 dark:text-white"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="flex justify-between items-center text-sm cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span class="text-slate-500 dark:text-slate-400 flex items-center gap-1">
					<svg class="w-3.5 h-3.5 text-[#FFB7C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3.28a1 1 0 01-.3.7l-1.42 1.42a1 1 0 000 1.41l1.41 1.42a1 1 0 01.3.7V17a2 2 0 002 2h14a2 2 0 002-2v-3.28a1 1 0 01.3-.7l1.42-1.42a1 1 0 000-1.41l-1.41-1.42a1 1 0 01-.3-.7V7a2 2 0 00-2-2H5z"></path></svg>
					<?php wc_cart_totals_coupon_label( $coupon ); ?>
				</span>
				<span class="font-bold text-[#FFB7C5]"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="flex justify-between items-center text-sm fee">
				<span class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $fee->name ); ?></span>
				<span class="font-bold text-slate-800 dark:text-white"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<div class="flex justify-between items-center text-sm tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<span class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $tax->label ); ?></span>
						<span class="font-bold text-slate-800 dark:text-white"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="flex justify-between items-center text-sm tax-total">
					<span class="text-slate-500 dark:text-slate-400"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
					<span class="font-bold text-slate-800 dark:text-white"><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="flex justify-between items-end pt-4 border-t border-slate-100 dark:border-slate-700/50 order-total">
			<div class="flex flex-col">
				<span class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
				<span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">Includes <?php echo WC()->cart->get_taxes_total(); ?> in taxes</span>
			</div>
			<span class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">
				<?php wc_cart_totals_order_total_html(); ?>
			</span>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>
</div>
