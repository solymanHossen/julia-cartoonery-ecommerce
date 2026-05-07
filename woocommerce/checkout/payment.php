<?php
/**
 * Checkout Payment Section
 * @version 8.1.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
    do_action( 'woocommerce_review_order_before_payment' );
}
?>

<div id="payment" class="woocommerce-checkout-payment mt-12">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h3 class="font-['Bubblegum_Sans'] text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
        <?php esc_html_e( 'Payment Method', 'woocommerce' ); ?>
            </h3>
            <p class="mt-2 text-sm md:text-base text-slate-600 dark:text-slate-300">
                <?php esc_html_e( 'Choose the secure option that works best for you.', 'woocommerce' ); ?>
            </p>
        </div>

        <div class="hidden sm:inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-900/20 dark:text-emerald-300">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
            <?php esc_html_e( 'Secure checkout', 'woocommerce' ); ?>
        </div>
    </div>
    
    <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm transition-shadow duration-300 dark:border-slate-700 dark:bg-slate-800 sm:p-5 md:p-6 lg:p-8">
        <?php if ( WC()->cart->needs_payment() ) : ?>
            <ul class="wc_payment_methods payment_methods methods list-none p-0 m-0 space-y-4">
                <?php
                if ( ! empty( $available_gateways ) ) {
                    foreach ( $available_gateways as $gateway ) {
                        wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                    }
                } else {
                    echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
                }
                ?>
            </ul>
        <?php endif; ?>

        <div class="form-row place-order mt-6 md:mt-8 border-t border-slate-200 pt-6 dark:border-slate-700 md:pt-8">
            <noscript>
                <?php
                /* translators: $1 and $2: opening and closing emphasis tags respectively */
                printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
                ?>
                <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
            </noscript>
            
            <?php wc_get_template( 'checkout/terms.php' ); ?>
            <?php do_action( 'woocommerce_review_order_before_submit' ); ?>
            
            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt w-full sm:w-auto px-10 py-4 bg-[#FFB7C5] hover:bg-[#ff9eaa] text-white font-black text-lg rounded-full transition-all duration-300 shadow-[0_10px_25px_rgba(255,183,197,0.4)] hover:shadow-[0_15px_30px_rgba(255,183,197,0.6)] hover:-translate-y-1" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>
            </div>
            
            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
        </div>
    </div>
</div>

<?php
if ( ! is_ajax() ) {
    do_action( 'woocommerce_review_order_after_payment' );
}
?>