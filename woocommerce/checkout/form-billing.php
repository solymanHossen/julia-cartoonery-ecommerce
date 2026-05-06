<?php
/**
 * Checkout billing form
 * @version 3.6.0
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
    <?php if ( wc_ship_to_billing_address_only() && $checkout->get_checkout_fields( 'shipping' ) ) : ?>
        <h3 class="text-xl font-bold mb-6 text-slate-800 dark:text-white"><?php esc_html_e( 'Billing & Shipping', 'woocommerce' ); ?></h3>
    <?php endif; ?>

    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="woocommerce-billing-fields__field-wrapper grid grid-cols-1 sm:grid-cols-2 gap-x-4">
        <?php
        $fields = $checkout->get_checkout_fields( 'billing' );
        foreach ( $fields as $key => $field ) {
            if ( in_array($key, ['billing_email', 'billing_phone', 'billing_address_1', 'billing_address_2', 'billing_country']) ) {
                $field['class'][] = 'form-row-wide sm:col-span-2';
            } else {
                $field['class'][] = 'sm:col-span-1';
            }
            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
        }
        ?>
    </div>

    <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
    <div class="woocommerce-account-fields mt-8 pt-8 border-t border-slate-100 dark:border-slate-700/50">
        <?php if ( ! $checkout->is_registration_required() ) : ?>
            <div class="create-account flex items-center gap-3 mb-4">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox w-5 h-5 rounded border-slate-300 text-[#FFB7C5] focus:ring-[#FFB7C5]" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" />
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox text-sm font-bold text-slate-700 dark:text-slate-200 cursor-pointer" for="createaccount">
                    <?php esc_html_e( 'Create an account?', 'woocommerce' ); ?>
                </label>
            </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

        <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
            <div class="create-account-fields grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
    </div>
<?php endif; ?>