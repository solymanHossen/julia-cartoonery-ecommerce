<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800/30 rounded-[32px] p-8 text-center shadow-sm mb-8">
				<div class="w-16 h-16 bg-red-100 dark:bg-red-800/40 rounded-full flex items-center justify-center mx-auto mb-6">
					<svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
				</div>
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed text-red-800 dark:text-red-200 font-bold text-xl mb-4"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay inline-block px-8 py-3 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 transition-colors"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay inline-block px-8 py-3 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-full font-bold hover:bg-slate-300 transition-colors ml-4"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>
			</div>

		<?php else : ?>

			<!-- Success Card -->
			<div class="bg-white dark:bg-slate-800 rounded-[40px] p-8 sm:p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/50 mb-10">
				
				<div class="w-20 h-20 bg-[#A8D8EA]/20 dark:bg-[#A8D8EA]/10 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
					<svg class="w-10 h-10 text-[#A8D8EA]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
						<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
					</svg>
				</div>

				<h2 class="text-4xl sm:text-5xl font-bold mb-4 text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
					<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you! Order Received.', 'woocommerce' ), $order ); ?>
				</h2>
				
				<p class="text-slate-500 dark:text-slate-400 text-lg mb-10 max-w-lg mx-auto">
					<?php esc_html_e( 'Hooray! Your adventure has begun. We have received your order and are getting it ready for you.', 'woocommerce' ); ?>
				</p>

				<!-- Order Meta Grid -->
				<div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-left border-t border-slate-50 dark:border-slate-700/50 pt-10">
					<div class="woocommerce-order-overview__order order">
						<span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></span>
						<span class="block text-lg font-black text-slate-800 dark:text-white"><?php echo $order->get_order_number(); ?></span>
					</div>

					<div class="woocommerce-order-overview__date date">
						<span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></span>
						<span class="block text-lg font-black text-slate-800 dark:text-white"><?php echo wc_format_datetime( $order->get_date_created() ); ?></span>
					</div>

					<div class="woocommerce-order-overview__total total">
						<span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
						<span class="block text-lg font-black text-[#FFB7C5]"><?php echo $order->get_formatted_order_total(); ?></span>
					</div>

					<?php if ( $order->get_payment_method_title() ) : ?>
					<div class="woocommerce-order-overview__payment-method method">
						<span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></span>
						<span class="block text-lg font-black text-slate-800 dark:text-white"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></span>
					</div>
					<?php endif; ?>
				</div>
			</div>

		<?php endif; ?>

		<div class="space-y-8">
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		</div>

	<?php else : ?>

		<div class="bg-white dark:bg-slate-800 rounded-[40px] p-12 text-center shadow-lg border border-slate-100 dark:border-slate-700/50">
			<h2 class="text-3xl font-bold text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
				<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?>
			</h2>
		</div>

	<?php endif; ?>

</div>
