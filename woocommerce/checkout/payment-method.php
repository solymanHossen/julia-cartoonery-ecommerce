<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?> relative">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio sr-only peer" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-transparent cursor-pointer transition-all duration-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:border-[#FFB7C5]/30 peer-checked:shadow-sm">
		<div class="flex items-center gap-3">
			<div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-600 flex items-center justify-center peer-checked:border-[#FFB7C5]">
				<div class="w-2.5 h-2.5 rounded-full transition-colors <?php echo ( $gateway->chosen ) ? 'bg-[#FFB7C5]' : 'bg-transparent'; ?>"></div>
			</div>
			<div class="flex flex-col">
				<span class="text-sm font-bold text-slate-800 dark:text-white"><?php echo $gateway->get_title(); ?></span>
				<?php if ( $gateway->get_icon() ) : ?>
					<div class="payment-icon mt-1 opacity-70"><?php echo $gateway->get_icon(); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</label>
	
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?> transition-all duration-300 overflow-hidden <?php echo ( $gateway->chosen ) ? 'max-h-[1000px] opacity-100 mt-4' : 'max-h-0 opacity-0 pointer-events-none'; ?>">
			<div class="p-5 bg-slate-50 dark:bg-slate-900/50 rounded-2xl text-sm text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-800/50">
				<?php $gateway->payment_fields(); ?>
			</div>
		</div>
	<?php endif; ?>
</li>
