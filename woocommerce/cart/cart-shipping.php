<?php
/**
 * Shipping Methods Display
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<div class="woocommerce-shipping-totals shipping space-y-6">
	<h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4"><?php echo wp_kses_post( $package_name ); ?></h3>
	
	<ul id="shipping_method" class="woocommerce-shipping-methods list-none p-0 m-0 space-y-3">
		<?php foreach ( $shipping_methods as $method ) : ?>
			<li class="relative">
				<?php
				if ( 1 < count( $shipping_methods ) ) {
					printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method sr-only peer" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
				} else {
					printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
				}
				?>
				<label for="shipping_method_<?php echo esc_attr( $index ); ?>_<?php echo esc_attr( sanitize_title( $method->id ) ); ?>" class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-transparent cursor-pointer transition-all duration-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:border-[#FFB7C5]/30 peer-checked:shadow-sm">
					<div class="flex items-center gap-3">
						<div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 flex items-center justify-center peer-checked:border-[#FFB7C5] peer-checked:after:content-[''] peer-checked:after:w-2.5 peer-checked:after:h-2.5 peer-checked:after:bg-[#FFB7C5] peer-checked:after:rounded-full">
							<!-- Custom Radio Visual -->
							<div class="w-2.5 h-2.5 rounded-full bg-transparent transition-colors <?php echo ( $method->id === $chosen_method ) ? 'bg-[#FFB7C5]' : ''; ?>"></div>
						</div>
						<span class="text-sm font-bold text-slate-700 dark:text-slate-200"><?php echo wc_cart_totals_shipping_method_label( $method ); ?></span>
					</div>
					<?php if ( $method->cost > 0 ) : ?>
						<span class="text-sm font-black text-slate-800 dark:text-white"><?php echo wc_price( $method->cost ); ?></span>
					<?php else : ?>
						<span class="text-xs font-black text-green-500 uppercase tracking-widest"><?php esc_html_e( 'Free', 'woocommerce' ); ?></span>
					<?php endif; ?>
				</label>
				<?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php if ( $show_shipping_calculator ) : ?>
		<?php woocommerce_shipping_calculator( $calculator_text ); ?>
	<?php endif; ?>
</div>
