<?php
/**
 * Checkout Form
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<div class="container mx-auto px-4 lg:px-8 py-10 animate-in fade-in">
    <h1 class="font-['Bubblegum_Sans'] text-4xl text-gray-800 dark:text-gray-100 mb-8">Checkout Details</h1>

    <form name="checkout" method="post" class="checkout woocommerce-checkout flex flex-col lg:flex-row gap-8" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <!-- Left Side: Billing & Shipping Forms -->
        <div class="flex-[2] space-y-6" id="customer_details">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-gray-50 dark:border-slate-700">
                <?php if ( $checkout->get_checkout_fields() ) : ?>
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Side: Order Review & Payment -->
        <div class="flex-1">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-50 dark:border-slate-700 sticky top-28" id="order_review_wrapper">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-6 border-b pb-4 dark:border-slate-700">
                    Your Order
                </h3>
                
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>