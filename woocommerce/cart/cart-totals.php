<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals bg-white dark:bg-slate-800 rounded-[32px] p-6 sm:p-8 shadow-[0_4px_30px_rgba(15,23,42,0.03)] dark:shadow-[0_4px_30px_rgba(0,0,0,0.3)] sticky top-8 <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h2 class="text-xl font-extrabold text-slate-800 dark:text-white mb-6"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h2>

    <div class="flex flex-col gap-4 mb-6 text-sm">

        <!-- Subtotal -->
        <div class="flex justify-between items-center cart-subtotal">
            <span class="text-slate-500 font-semibold"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
            <span class="font-bold text-slate-800 dark:text-white" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <!-- Coupons -->
        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="flex justify-between items-center coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <span class="text-slate-500 font-semibold"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
            <span class="font-bold text-[#FFB7C5]" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Shipping -->
        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
            <div class="flex flex-col gap-2">
                <?php wc_cart_totals_shipping_html(); ?>
            </div>
            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
            <div class="flex justify-between items-center shipping">
                <span class="text-slate-500 font-semibold"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></span>
                <span class="font-bold text-slate-800 dark:text-white"><?php woocommerce_shipping_calculator(); ?></span>
            </div>
        <?php endif; ?>

        <!-- Fees -->
        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="flex justify-between items-center fee">
            <span class="text-slate-500 font-semibold"><?php echo esc_html( $fee->name ); ?></span>
            <span class="font-bold text-slate-800 dark:text-white" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></span>
        </div>
        <?php endforeach; ?>

        <!-- Taxes -->
        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                /* translators: %s location. */
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
                    ?>
                    <div class="flex justify-between items-center tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <span class="text-slate-500 font-semibold"><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                        <span class="font-bold text-slate-800 dark:text-white"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="flex justify-between items-center tax-total">
                    <span class="text-slate-500 font-semibold"><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span class="font-bold text-slate-800 dark:text-white"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    <div class="h-[1px] w-full bg-slate-100 dark:bg-slate-700/50 mb-6"></div>

    <!-- Grand Total -->
    <div class="flex justify-between items-center order-total mb-8">
        <span class="text-xl font-extrabold text-slate-800 dark:text-white"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
        <span class="text-2xl font-extrabold text-[#FFB7C5]" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></span>
    </div>

    <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    <!-- Proceed to Checkout Button -->
    <div class="wc-proceed-to-checkout w-full">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
