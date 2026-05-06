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
            <h1 class="checkout-title">Secure Checkout</h1>
            <p class="checkout-subtitle">Complete your order securely in a few simple steps</p>
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
                                <h2 class="card-title">Contact Information</h2>
                            </div>
                            <div class="card-body">
                                <?php 
                                $billing_fields = $checkout->get_checkout_fields( 'billing' );
                                $contact_fields = array_intersect_key( $billing_fields, array_flip( ['billing_email', 'billing_phone'] ) );
                                foreach ( $contact_fields as $key => $field ) {
                                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                                }
                                ?>
                                
                                <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
                                    <div class="login-section">
                                        <p class="login-text">
                                            Have an account? 
                                            <a href="#" class="checkout-login-toggle">Log in</a>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Step 2: Shipping Address -->
                        <div class="checkout-card" data-step="2">
                            <div class="card-header">
                                <div class="step-badge">2</div>
                                <h2 class="card-title">Shipping Address</h2>
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

                <!-- Payment Method -->
                <div class="checkout-card" data-step="4">
                    <div class="card-header">
                        <div class="step-badge">3</div>
                        <h2 class="card-title">Payment Method</h2>
                    </div>
                    <div class="card-body">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                </div>

                <!-- Desktop: Back to Cart Link -->
                <div class="back-to-cart">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="back-link">
                        <svg class="back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Return to Cart
                    </a>
                </div>

            </div>

            <!-- Right Column - Order Summary (Sticky) -->
            <div class="checkout-right-column">
                <div class="order-summary">
                    
                    <!-- Order Summary Header -->
                    <div class="order-summary-header">
                        <h3 class="order-summary-title">Order Summary</h3>
                        <div class="order-details">
                            <svg class="order-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.15a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06m0 0a1 1 0 001.037 1.852m0 0L9.5 15.5m-7.5-4l7.5 4m0 0l4 2.372c.537.317 1.29.004 1.469-.797l.821-4.91a1 1 0 00-.44-1.06m0 0L9.5 9.5"></path>
                            </svg>
                            <span id="cart-items-count">Order Details</span>
                        </div>
                    </div>

                    <div class="order-summary-body">

                        <!-- Cart Items -->
                        <div id="order_review" class="woocommerce-checkout-review-order order-items">
                            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                        </div>

                        <!-- Coupon Code Section -->
                        <div class="coupon-section">
                            <details class="coupon-details">
                                <summary class="coupon-summary">
                                    <span class="coupon-label">
                                        <svg class="coupon-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Add discount code
                                    </span>
                                    <svg class="coupon-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </summary>
                                <div class="coupon-input-group">
                                    <input type="text" name="coupon_code" id="coupon_code" class="coupon-input" placeholder="Enter coupon code" />
                                    <button type="submit" name="apply_coupon" class="coupon-button">Apply</button>
                                </div>
                            </details>
                        </div>

                        <!-- Place Order Button -->
                        <div class="place-order-section">
                            <?php wc_get_template( 'checkout/terms.php' ); ?>
                            <?php do_action( 'woocommerce_review_order_before_submit' ); ?>
                            
                            <button type="submit" class="place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e( 'Place Order', 'woocommerce' ); ?>" data-value="<?php esc_attr_e( 'Place Order', 'woocommerce' ); ?>">
                                <?php esc_html_e( 'Complete Purchase', 'woocommerce' ); ?>
                            </button>
                            
                            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
                            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
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

                <!-- Mobile: Back to Cart Link -->
                <div class="mobile-back-to-cart">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="back-link">
                        <svg class="back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Return to Cart
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
