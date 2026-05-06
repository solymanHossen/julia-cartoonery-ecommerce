<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the input field should not be displayed.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout mt-8" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="lg:grid lg:grid-cols-12 lg:gap-12 items-start">
		
		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<div class="lg:col-span-7 space-y-8" id="customer_details">
				
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<!-- Billing Details Card -->
				<div class="bg-white dark:bg-slate-800 rounded-[40px] p-8 sm:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/50">
					<h3 class="text-3xl font-bold mb-8 text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
						<?php esc_html_e( 'Billing details', 'woocommerce' ); ?>
					</h3>
					
					<div class="julias-form-fields">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
				</div>

				<!-- Shipping Details Card -->
				<div class="bg-white dark:bg-slate-800 rounded-[40px] p-8 sm:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/50">
					<div class="julias-form-fields">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			</div>

		<?php endif; ?>

		<!-- Order Review Sidebar -->
		<div class="lg:col-span-5 mt-12 lg:mt-0 sticky top-8">
			
			<div id="order_review_heading_container" class="mb-6 px-4">
				<h3 id="order_review_heading" class="text-3xl font-bold text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
					<?php esc_html_e( 'Your order', 'woocommerce' ); ?>
				</h3>
			</div>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order bg-white dark:bg-slate-800 rounded-[40px] p-8 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.06)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-slate-100 dark:border-slate-700/50">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			
			<div class="mt-8 px-6 text-center">
				<p class="text-xs text-slate-400 dark:text-slate-500 leading-relaxed">
					<?php esc_html_e( 'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our ', 'woocommerce' ); ?>
					<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>" class="text-[#FFB7C5] hover:underline font-bold"><?php esc_html_e( 'privacy policy', 'woocommerce' ); ?></a>.
				</p>
			</div>
		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
