<?php
/**
 * Thankyou page
 * @version 8.1.0
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-order py-8 px-3 sm:py-12 sm:px-4 md:px-6 lg:px-8 max-w-5xl mx-auto">
    <?php if ( $order ) : ?>
        <?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
        
        <?php if ( $order->has_status( 'failed' ) ) : ?>
            <div class="bg-gradient-to-br from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 border border-red-200 dark:border-red-800/30 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 md:p-10 lg:p-12 text-center shadow-[0_8px_30px_rgb(239,68,68,0.06)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.2)] mb-6 sm:mb-8">
                <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-red-100 dark:bg-red-800/40 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 md:mb-8 shadow-lg shadow-red-200/50 dark:shadow-red-900/30 animate-pulse">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed text-red-800 dark:text-red-200 font-bold text-xs sm:text-base md:text-lg lg:text-xl mb-3 sm:mb-4 md:mb-6 leading-relaxed">
                    <?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
                </p>
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions flex flex-col gap-2 sm:gap-3 justify-center">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-red-600 text-white font-bold text-sm sm:text-base rounded-full hover:bg-red-700 hover:shadow-lg hover:shadow-red-600/30 transition-all duration-300 ease-out group w-full sm:w-auto">
                        <?php esc_html_e( 'Try Payment Again', 'woocommerce' ); ?>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-sm sm:text-base rounded-full hover:bg-slate-300 dark:hover:bg-slate-600 transition-all duration-300 ease-out w-full sm:w-auto">
                            <?php esc_html_e( 'My Account', 'woocommerce' ); ?>
                        </a>
                    <?php endif; ?>
                </p>
            </div>
        <?php else : ?>
            <!-- Success Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 md:p-10 lg:p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/50 mb-8 sm:mb-12">
                <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#A8D8EA] to-[#8DC6DB] rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-6 md:mb-8 animate-bounce shadow-lg shadow-[#A8D8EA]/30 dark:shadow-[#A8D8EA]/20">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-2 sm:mb-3 md:mb-4 text-slate-800 dark:text-white leading-tight" style="font-family: 'Bubblegum Sans', cursive;">
                    <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you! Order Received.', 'woocommerce' ), $order ); ?>
                </h2>
                <p class="text-xs sm:text-sm md:text-base lg:text-lg text-slate-500 dark:text-slate-400 mb-6 sm:mb-8 md:mb-12 max-w-2xl mx-auto leading-relaxed">
                    <?php esc_html_e( 'Hooray! Your adventure has begun. We have received your order and are getting it ready for you.', 'woocommerce' ); ?>
                </p>
                
                <!-- Order Meta Grid - Fully Responsive -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4 md:gap-6 text-left border-t border-slate-50 dark:border-slate-700/50 pt-4 sm:pt-6 md:pt-10">
                    <div class="woocommerce-order-overview__order order bg-slate-50 dark:bg-slate-700/40 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-5">
                        <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1 sm:mb-2 text-[0.65rem]"><?php esc_html_e( 'Order number', 'woocommerce' ); ?></span>
                        <span class="block text-sm sm:text-base md:text-lg font-black text-slate-800 dark:text-white break-words leading-tight"><?php echo $order->get_order_number(); ?></span>
                    </div>
                    <div class="woocommerce-order-overview__date date bg-slate-50 dark:bg-slate-700/40 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-5">
                        <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1 sm:mb-2 text-[0.65rem]"><?php esc_html_e( 'Date', 'woocommerce' ); ?></span>
                        <span class="block text-sm sm:text-base md:text-lg font-black text-slate-800 dark:text-white leading-tight"><?php echo wc_format_datetime( $order->get_date_created() ); ?></span>
                    </div>
                    <div class="woocommerce-order-overview__total total bg-gradient-to-br from-[#FFB7C5]/10 to-[#FFB7C5]/5 dark:from-[#FFB7C5]/5 dark:to-[#FFB7C5]/2 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-5 border border-[#FFB7C5]/20">
                        <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1 sm:mb-2 text-[0.65rem]"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
                        <span class="block text-sm sm:text-base md:text-lg font-black text-[#FF6B9D] leading-tight"><?php echo $order->get_formatted_order_total(); ?></span>
                    </div>
                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <div class="woocommerce-order-overview__payment-method method bg-slate-50 dark:bg-slate-700/40 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-5">
                            <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1 sm:mb-2 text-[0.65rem]"><?php esc_html_e( 'Payment', 'woocommerce' ); ?></span>
                            <span class="block text-sm sm:text-base md:text-lg font-black text-slate-800 dark:text-white leading-tight"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 sm:mt-8 md:mt-10 lg:mt-12 pt-4 sm:pt-6 md:pt-8 lg:pt-10 border-t border-slate-50 dark:border-slate-700/50 flex md:flex-row flex-col gap-2 sm:gap-3 md:gap-4">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#A8D8EA] to-[#8DC6DB] text-white font-bold text-sm sm:text-base rounded-full shadow-lg shadow-[#A8D8EA]/30 hover:shadow-xl hover:shadow-[#A8D8EA]/40 hover:scale-105 transition-all duration-300 ease-out group w-full">
                        <?php esc_html_e( 'Continue Shopping', 'woocommerce' ); ?>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white dark:bg-slate-700 text-slate-800 dark:text-white font-bold text-sm sm:text-base rounded-full border-2 border-slate-200 dark:border-slate-600 hover:border-[#A8D8EA] dark:hover:border-[#A8D8EA] hover:bg-slate-50 dark:hover:bg-slate-600 transition-all duration-300 ease-out w-full">
                            <?php esc_html_e( 'View Orders', 'woocommerce' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="thankyou-receipt-shell mt-6 sm:mt-8 md:mt-12 grid gap-3 sm:gap-4 md:gap-6 lg:grid-cols-[280px_1fr] xl:grid-cols-[320px_1fr]">
            <aside class="thankyou-receipt-note order-2 lg:order-1 rounded-2xl sm:rounded-3xl lg:rounded-[32px] border border-[#A8D8EA]/25 bg-gradient-to-br from-[#f8fcfe] via-white to-[#fff7f9] p-4 sm:p-6 md:p-8 shadow-[0_12px_30px_rgba(15,23,42,0.06)] dark:border-slate-700/60 dark:from-slate-800 dark:via-slate-800 dark:to-slate-900 dark:shadow-[0_12px_30px_rgba(0,0,0,0.22)]">
                <div class="inline-flex items-center gap-2 rounded-full bg-[#A8D8EA]/15 px-2 sm:px-3 py-1 text-[0.6rem] sm:text-[0.65rem] md:text-[0.72rem] font-black uppercase tracking-[0.1em] sm:tracking-[0.15em] md:tracking-[0.22em] text-slate-700 dark:text-slate-200 whitespace-nowrap">
                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-[#A8D8EA]"></span>
                    <?php esc_html_e( 'Receipt summary', 'woocommerce' ); ?>
                </div>

                <h3 class="mt-3 sm:mt-4 text-base sm:text-lg md:text-2xl font-black text-slate-900 dark:text-white leading-tight" style="font-family: 'Bubblegum Sans', cursive;">
                    <?php esc_html_e( 'Keep this order receipt handy', 'woocommerce' ); ?>
                </h3>

                <p class="mt-2 sm:mt-3 text-xs sm:text-xs md:text-sm leading-5 sm:leading-6 text-slate-600 dark:text-slate-300">
                    <?php esc_html_e( 'Your order has been recorded and will be prepared for delivery. Pay the courier in cash when your package arrives.', 'woocommerce' ); ?>
                </p>

                <dl class="mt-4 sm:mt-6 space-y-2 sm:space-y-3 md:space-y-4 text-xs sm:text-xs md:text-sm">
                    <div class="flex items-start justify-between gap-2 sm:gap-3 md:gap-4 border-b border-slate-100 pb-2 sm:pb-3 md:pb-4 dark:border-slate-700/60">
                        <dt class="font-semibold text-slate-500 dark:text-slate-400 flex-shrink-0"><?php esc_html_e( 'Order', 'woocommerce' ); ?></dt>
                        <dd class="font-black text-slate-900 dark:text-white text-right break-words text-xs sm:text-xs"><?php echo esc_html( $order->get_order_number() ); ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-2 sm:gap-3 md:gap-4 border-b border-slate-100 pb-2 sm:pb-3 md:pb-4 dark:border-slate-700/60">
                        <dt class="font-semibold text-slate-500 dark:text-slate-400 flex-shrink-0"><?php esc_html_e( 'Payment', 'woocommerce' ); ?></dt>
                        <dd class="font-black text-slate-900 dark:text-white text-right break-words text-xs sm:text-xs"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></dd>
                    </div>
                    <div class="flex items-start justify-between gap-2 sm:gap-3 md:gap-4">
                        <dt class="font-semibold text-slate-500 dark:text-slate-400 flex-shrink-0"><?php esc_html_e( 'Total', 'woocommerce' ); ?></dt>
                        <dd class="font-black text-[#FF6B9D] text-right text-xs sm:text-xs"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></dd>
                    </div>
                </dl>
            </aside>

            <div class="thankyou-receipt-content order-1 lg:order-2 space-y-6 sm:space-y-8">
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

                <?php
                // Modern customer details block (uses theme styles in src/css/checkout-overrides.css)
                $billing_first = $order->get_billing_first_name();
                $billing_last  = $order->get_billing_last_name();
                $billing_name  = trim( $billing_first . ' ' . $billing_last );
                $billing_company = $order->get_billing_company();
                $billing_address_1 = $order->get_billing_address_1();
                $billing_address_2 = $order->get_billing_address_2();
                $billing_city = $order->get_billing_city();
                $billing_state = $order->get_billing_state();
                $billing_postcode = $order->get_billing_postcode();
                $billing_country = $order->get_billing_country();
                $billing_phone = $order->get_billing_phone();
                $billing_email = $order->get_billing_email();

                $shipping_first = $order->get_shipping_first_name();
                $shipping_last  = $order->get_shipping_last_name();
                $shipping_name  = trim( $shipping_first . ' ' . $shipping_last );
                $shipping_company = $order->get_shipping_company();
                $shipping_address_1 = $order->get_shipping_address_1();
                $shipping_address_2 = $order->get_shipping_address_2();
                $shipping_city = $order->get_shipping_city();
                $shipping_state = $order->get_shipping_state();
                $shipping_postcode = $order->get_shipping_postcode();
                $shipping_country = $order->get_shipping_country();
                ?>

                <section class="woocommerce-customer-details">
                    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
                        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                            <h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>
                            <address>
                                <?php if ( $billing_name ) : ?><?php echo esc_html( $billing_name ); ?><br><?php endif; ?>
                                <?php if ( $billing_company ) : ?><?php echo esc_html( $billing_company ); ?><br><?php endif; ?>
                                <?php if ( $billing_address_1 ) : ?><?php echo esc_html( $billing_address_1 ); ?><br><?php endif; ?>
                                <?php if ( $billing_address_2 ) : ?><?php echo esc_html( $billing_address_2 ); ?><br><?php endif; ?>
                                <?php if ( $billing_city || $billing_state || $billing_postcode ) : ?>
                                    <?php
                                    $parts = array_filter( array( $billing_city, $billing_state, $billing_postcode ) );
                                    echo esc_html( implode( ', ', $parts ) );
                                    ?><br>
                                <?php endif; ?>
                                <?php if ( $billing_country ) : ?><?php echo esc_html( WC()->countries->countries[ $billing_country ] ?? $billing_country ); ?><br><?php endif; ?>

                                <?php if ( $billing_phone ) : ?>
                                    <p class="woocommerce-customer-details--phone"><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $billing_phone ) ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-white">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.2a2 2 0 011.9 1.4l.6 2.2a2 2 0 01-.45 1.9l-1.2 1.5a16 16 0 006.1 6.1l1.5-1.2a2 2 0 011.9-.45l2.2.6A2 2 0 0121 18.8V21a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                                        <?php echo esc_html( $billing_phone ); ?></a></p>
                                <?php endif; ?>

                                <?php if ( $billing_email ) : ?>
                                    <p class="woocommerce-customer-details--email"><a href="mailto:<?php echo esc_attr( $billing_email ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-white">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6"></path><path stroke-linecap="round" stroke-linejoin="round" d="M21 8v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8"></path></svg>
                                        <?php echo esc_html( $billing_email ); ?></a></p>
                                <?php endif; ?>
                            </address>
                        </div><!-- /.col-1 -->

                        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
                            <h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
                            <address>
                                <?php if ( $shipping_name ) : ?><?php echo esc_html( $shipping_name ); ?><br><?php endif; ?>
                                <?php if ( $shipping_company ) : ?><?php echo esc_html( $shipping_company ); ?><br><?php endif; ?>
                                <?php if ( $shipping_address_1 ) : ?><?php echo esc_html( $shipping_address_1 ); ?><br><?php endif; ?>
                                <?php if ( $shipping_address_2 ) : ?><?php echo esc_html( $shipping_address_2 ); ?><br><?php endif; ?>
                                <?php if ( $shipping_city || $shipping_state || $shipping_postcode ) : ?>
                                    <?php
                                    $parts = array_filter( array( $shipping_city, $shipping_state, $shipping_postcode ) );
                                    echo esc_html( implode( ', ', $parts ) );
                                    ?><br>
                                <?php endif; ?>
                                <?php if ( $shipping_country ) : ?><?php echo esc_html( WC()->countries->countries[ $shipping_country ] ?? $shipping_country ); ?><br><?php endif; ?>
                            </address>
                        </div><!-- /.col-2 -->
                    </section><!-- /.col2-set -->
                </section>
            </div>
        </div>

    <?php else : ?>
        <div class="bg-gradient-to-br from-slate-50 to-slate-50/50 dark:from-slate-800 dark:to-slate-900 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 md:p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-700/50">
            <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-slate-200 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-6 md:mb-8">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-4 leading-tight" style="font-family: 'Bubblegum Sans', cursive;">
                <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?>
            </h2>
            <p class="text-xs sm:text-sm md:text-base lg:text-lg text-slate-500 dark:text-slate-400 mb-6 sm:mb-8 leading-relaxed">
                <?php esc_html_e( 'We appreciate your business and will be in touch shortly to confirm your order details.', 'woocommerce' ); ?>
            </p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-[#A8D8EA] to-[#8DC6DB] text-white font-bold text-sm sm:text-base rounded-full shadow-lg shadow-[#A8D8EA]/30 hover:shadow-xl hover:shadow-[#A8D8EA]/40 hover:scale-105 transition-all duration-300 ease-out group">
                <?php esc_html_e( 'Continue Shopping', 'woocommerce' ); ?>
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    <?php endif; ?>
</div>