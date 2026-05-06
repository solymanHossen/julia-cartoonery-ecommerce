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

<form name="checkout" method="post" class="checkout woocommerce-checkout py-8 lg:py-16" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="lg:grid lg:grid-cols-12 lg:gap-16 items-start">
		
		<!-- LEFT COLUMN: Contact, Address, Shipping & Payment -->
		<div class="lg:col-span-7 space-y-12">
			
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<div id="customer_details" class="space-y-10">
					
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<!-- Section 1: Contact Information -->
					<div class="checkout-section">
						<div class="flex items-center justify-between mb-6">
							<h3 class="text-2xl font-bold text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
								<?php esc_html_e( 'Contact Information', 'woocommerce' ); ?>
							</h3>
							<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
								<p class="text-sm text-slate-500">
									<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="text-[#FFB7C5] font-bold hover:underline">Log in</a>
								</p>
							<?php endif; ?>
						</div>
						
						<div class="bg-white dark:bg-slate-800 rounded-[32px] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 dark:border-slate-700/50">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</div>

					<!-- Section 2: Shipping Address -->
					<div class="checkout-section">
						<h3 class="text-2xl font-bold mb-6 text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
							<?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?>
						</h3>
						<div class="bg-white dark:bg-slate-800 rounded-[32px] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 dark:border-slate-700/50">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				</div>

			<?php endif; ?>

			<!-- Section 3 & 4: Shipping Methods & Payment (Handled via Order Review Hook) -->
			<div id="order_review" class="woocommerce-checkout-review-order space-y-10">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<!-- Bottom Action Bar -->
			<div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-200 dark:border-slate-700/50">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
					<?php esc_html_e( 'Return to cart', 'woocommerce' ); ?>
				</a>
			</div>

		</div>

		<!-- RIGHT COLUMN: Order Summary Sidebar (Sticky) -->
		<div class="lg:col-span-5 mt-12 lg:mt-0 lg:sticky lg:top-8 h-fit">
			<div class="bg-white dark:bg-slate-800 rounded-[32px] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.06)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-slate-100 dark:border-slate-700/50">
				<h3 class="text-2xl font-bold mb-8 text-slate-800 dark:text-white" style="font-family: 'Bubblegum Sans', cursive;">
					<?php esc_html_e( 'Order summary', 'woocommerce' ); ?>
				</h3>
				
				<!-- We need a separate container for the product list that doesn't duplicate the full review-order -->
				<div class="julias-order-summary-sidebar">
					<?php 
					// We'll use a custom template or just the cart fragments for the sidebar
					// For simplicity and to ensure AJAX updates, we can wrap this in a way that our JS can target,
					// or just keep it as is if we only have one review-order.
					// Since WooCommerce AJAX targets .woocommerce-checkout-review-order, 
					// having two of them will actually update BOTH.
					?>
					<div class="woocommerce-checkout-review-order">
						<?php wc_get_template( 'checkout/review-order.php' ); ?>
					</div>
				</div>

				<!-- Coupon Dropdown -->
				<div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-700/50">
					<details class="group">
						<summary class="flex items-center justify-between cursor-pointer list-none text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-[#FFB7C5] transition-colors">
							<span class="flex items-center gap-2">
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3.28a1 1 0 01-.3.7l-1.42 1.42a1 1 0 000 1.41l1.41 1.42a1 1 0 01.3.7V17a2 2 0 002 2h14a2 2 0 002-2v-3.28a1 1 0 01.3-.7l1.42-1.42a1 1 0 000-1.41l-1.41-1.42a1 1 0 01-.3-.7V7a2 2 0 00-2-2H5z"></path></svg>
								<?php esc_html_e( 'Add a discount code', 'woocommerce' ); ?>
							</span>
							<svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
						</summary>
						<div class="mt-4">
							<div class="flex gap-2">
								<input type="text" name="coupon_code" class="flex-grow px-4 py-2.5 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm outline-none focus:border-[#FFB7C5]" id="coupon_code" value="" placeholder="Discount code" />
								<button type="submit" class="px-6 py-2.5 bg-slate-800 dark:bg-slate-100 text-white dark:text-slate-800 font-bold rounded-xl text-sm hover:opacity-90 transition-opacity" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply', 'woocommerce' ); ?></button>
							</div>
						</div>
					</details>
				</div>
			</div>
		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
