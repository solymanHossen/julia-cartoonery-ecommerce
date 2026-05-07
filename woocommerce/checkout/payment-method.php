<?php
/**
 * Output a single payment method
 * @version 3.5.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?> group relative">
    <input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio sr-only peer" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

    <label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="flex cursor-pointer items-start justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-all duration-300 hover:border-slate-300 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800/40 dark:hover:border-slate-600 dark:hover:bg-slate-800 peer-checked:border-[#FFB7C5] peer-checked:bg-white peer-checked:shadow-md dark:peer-checked:border-[#FFB7C5]/50 dark:peer-checked:bg-slate-800">
        <div class="flex items-start gap-3">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 bg-white transition-colors peer-checked:border-[#FFB7C5] dark:border-slate-600 dark:bg-slate-800">
                <span class="h-2.5 w-2.5 rounded-full <?php echo $gateway->chosen ? 'bg-[#FFB7C5]' : 'bg-transparent'; ?>"></span>
            </span>
            <div class="min-w-0">
                <span class="block text-sm font-bold text-slate-900 dark:text-white md:text-base"><?php echo esc_html( $gateway->get_title() ); ?></span>
                <?php if ( $gateway->get_icon() ) : ?>
                    <div class="payment-icon mt-2 opacity-80"><?php echo $gateway->get_icon(); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <span class="mt-1 hidden rounded-full bg-[#FFB7C5]/10 px-2.5 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-[#D96F85] peer-checked:inline-flex dark:bg-[#FFB7C5]/15 dark:text-[#FFB7C5]">
            <?php esc_html_e( 'Selected', 'woocommerce' ); ?>
        </span>
    </label>

    <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?> overflow-hidden transition-all duration-300 <?php echo ( $gateway->chosen ) ? 'mt-3 max-h-[1000px] opacity-100' : 'max-h-0 opacity-0 pointer-events-none'; ?>">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400 md:p-5">
                <?php $gateway->payment_fields(); ?>
            </div>
        </div>
    <?php endif; ?>
</li>