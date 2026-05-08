<?php
/**
 * Checkout Form - Premium High-Conversion UX
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<div class="checkout-wrapper">
    <div class="checkout-container">
        
        <!-- Header -->
        <div class="checkout-header">
            <div class="checkout-eyebrow">Fast + Secure</div>
            <div class="checkout-header-actions">
                <a class="checkout-back-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <svg aria-hidden="true" focusable="false" viewBox="0 0 20 20" fill="none" class="checkout-back-icon">
                        <path d="M12.5 4.5L7 10l5.5 5.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Return to Cart</span>
                </a>
            </div>
        </div>

        <form name="checkout" method="post" class="checkout woocommerce-checkout checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

            <!-- Left Column - Form -->
            <div class="checkout-left-column">

                <?php if ( $checkout->get_checkout_fields() ) : ?>
                    <div id="customer_details" class="space-y-6">
                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <!-- Step 1: Contact Information -->
                        <div class="checkout-card" data-step="1">
                            <div class="card-header">
                                <div class="step-badge">1</div>
                                <div>
                                    <h2 class="card-title">Contact Information</h2>
                                    <p class="card-subtitle">Used for order confirmation and delivery updates.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php 
                                $billing_fields = $checkout->get_checkout_fields( 'billing' );
                                $contact_fields = array_intersect_key( $billing_fields, array_flip( ['billing_email', 'billing_phone'] ) );
                                foreach ( $contact_fields as $key => $field ) {
                                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Step 2: Shipping Address -->
                        <div class="checkout-card" data-step="2">
                            <div class="card-header">
                                <div class="step-badge">2</div>
                                <div>
                                    <h2 class="card-title">Shipping Address</h2>
                                    <p class="card-subtitle">Where we should send your order.</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php 
                                $billing_fields = $checkout->get_checkout_fields( 'billing' );
                                $address_fields = array_diff_key( $billing_fields, array_flip( ['billing_email', 'billing_phone'] ) );
                                foreach ( $address_fields as $key => $field ) {
                                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                                }
                                ?>
                                
                                <!-- Ship to Different Address -->
                                <div class="shipping-section">
                                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                </div>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Right Column - Order Summary (Sticky) -->
            <div class="checkout-right-column">
                <div class="order-summary">
                    
                    <!-- Order Summary Header -->
                    <div class="order-summary-header">
                        <h3 class="order-summary-title">Review &amp; Payment</h3>
                        <p class="order-summary-kicker">Verify your items and place the order securely.</p>
                    </div>

                    <div class="order-summary-body">

                        <!-- Cart Items -->
                        <div id="order_review" class="woocommerce-checkout-review-order order-items">
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>

                        <!-- Trust Signals -->
                        <div class="trust-badges">
                            <div class="trust-badge-item">
                                <svg class="trust-icon ssl" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.707 6.707a1 1 0 010 1.414L5.414 9.414a1 1 0 11-1.414-1.414l1.293-1.293a1 1 0 011.414 0zm2.828-2.828a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zm2.828-2.829a1 1 0 010 1.415L9.586 5.586a1 1 0 11-1.414-1.414l4.243-4.243a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="trust-label">SSL Secure</span>
                            </div>
                            <div class="trust-badge-item">
                                <svg class="trust-icon protected" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="trust-label">Protected</span>
                            </div>
                            <div class="trust-badge-item">
                                <svg class="trust-icon returns" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                </svg>
                                <span class="trust-label">30-Day Returns</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
