<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<!-- Shopping Cart Title -->
<h1 class="text-4xl sm:text-5xl font-extrabold text-slate-800 dark:text-white mb-8 tracking-wide" style="font-family: 'Bubblegum Sans', cursive;">
    Shopping Cart
</h1>

<!-- Beautiful Stepper -->
<div class="flex items-center justify-start gap-3 sm:gap-4 mb-12 text-sm font-bold overflow-x-auto pb-4 scrollbar-hide">
    <div class="flex items-center gap-2 text-white bg-gradient-to-r from-[#FFB7C5] to-[#ff9eaa] px-5 py-2.5 rounded-full shadow-[0_4px_15px_rgba(255,183,197,0.4)] shrink-0">
        <span class="w-6 h-6 rounded-full bg-white text-[#FFB7C5] flex items-center justify-center text-xs shadow-sm">1</span>
        <span>Cart</span>
    </div>
    <div class="h-[2px] w-8 sm:w-12 bg-slate-200 dark:bg-slate-700 rounded-full shrink-0"></div>
    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 shrink-0">
        <span class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 flex items-center justify-center text-xs">2</span>
        <span>Checkout Details</span>
    </div>
    <div class="h-[2px] w-8 sm:w-12 bg-slate-200 dark:bg-slate-700 rounded-full shrink-0"></div>
    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 shrink-0">
        <span class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 flex items-center justify-center text-xs">3</span>
        <span>Order Complete</span>
    </div>
</div>

<!-- Two-column grid wrapper -->
<div class="lg:grid lg:grid-cols-12 lg:gap-10 items-start">

    <!-- LEFT COLUMN: Cart Form -->
    <div class="lg:col-span-8 mb-10 lg:mb-0">

        <form class="woocommerce-cart-form julias-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <div class="flex flex-col gap-6">
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <!-- Individual Cart Item Card -->
                        <div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?> bg-white dark:bg-slate-800 p-4 sm:p-6 rounded-[32px] shadow-[0_4px_20px_rgba(15,23,42,0.03)] dark:shadow-[0_4px_20px_rgba(0,0,0,0.2)] border border-slate-50 dark:border-slate-700/50 flex flex-col sm:flex-row items-center gap-5 sm:gap-6 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(15,23,42,0.06)] hover:-translate-y-1 group">

                            <!-- Image -->
                            <div class="product-thumbnail w-full sm:w-[120px] h-[120px] shrink-0 rounded-[24px] overflow-hidden bg-slate-50 dark:bg-slate-700 relative flex items-center justify-center">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover mix-blend-multiply dark:mix-blend-normal transition-transform duration-700 group-hover:scale-105' ) ), $cart_item, $cart_item_key );
                                if ( ! $product_permalink ) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf( '<a href="%s" class="block w-full h-full">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                }
                                ?>
                            </div>

                            <!-- Details & Actions wrapper -->
                            <div class="flex-1 w-full flex flex-col sm:flex-row items-center sm:items-start justify-between gap-5 sm:gap-6">
                                
                                <!-- Info -->
                                <div class="flex flex-col text-center sm:text-left gap-1.5 w-full sm:w-auto flex-1">
                                    <!-- Category -->
                                    <div class="text-[0.7rem] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-0.5">
                                        <?php echo strip_tags( wc_get_product_category_list( $product_id, ', ' ) ); ?>
                                    </div>
                                    
                                    <!-- Product Name -->
                                    <div class="product-name text-[1.1rem] sm:text-[1.2rem] font-extrabold text-slate-800 dark:text-white leading-tight hover:text-[#FFB7C5] transition-colors" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( $product_name . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }

                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                        // Meta data.
                                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification mt-2 text-xs text-orange-500 font-bold bg-orange-50 dark:bg-orange-500/10 inline-block px-3 py-1 rounded-full">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                        }
                                        ?>
                                    </div>

                                    <!-- Price -->
                                    <div class="product-price text-[#FFB7C5] font-black text-xl sm:text-2xl mt-1 tracking-tight" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                        <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
                                    </div>
                                </div>

                                <!-- Quantity & Remove -->
                                <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-3 sm:gap-4 shrink-0 mt-2 sm:mt-0">
                                    <!-- Quantity Pill -->
                                    <div class="product-quantity bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center p-1 border border-slate-100 dark:border-slate-700/50 transition-all shadow-inner" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                        <button type="button" class="julias-qty-minus w-9 h-9 flex items-center justify-center text-slate-400 hover:text-[#FFB7C5] hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>

                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $min_quantity = 1;
                                            $max_quantity = 1;
                                        } else {
                                            $min_quantity = 0;
                                            $max_quantity = $_product->get_max_purchase_quantity();
                                        }

                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $max_quantity,
                                                'min_value'    => $min_quantity,
                                                'product_name' => $product_name,
                                                'classes'      => array( 'input-text', 'qty', 'text', 'w-10', 'text-center', 'font-extrabold', 'text-slate-800', 'dark:text-white', 'bg-transparent', 'border-none', 'focus:ring-0', 'p-0', 'appearance-none', 'm-0', 'text-lg' ),
                                            ),
                                            $_product,
                                            false
                                        );
                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                        ?>

                                        <button type="button" class="julias-qty-plus w-9 h-9 flex items-center justify-center text-slate-400 hover:text-[#FFB7C5] hover:bg-white dark:hover:bg-slate-700 rounded-full transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="product-remove">
                                        <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a role="button" href="%s" class="remove w-11 h-11 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-500/10 text-red-400 hover:bg-red-400 hover:text-white hover:rotate-90 transition-all duration-300" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php do_action( 'woocommerce_cart_contents' ); ?>

                <!-- Actions Row: Coupon & Update -->
                <div class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-[32px] shadow-[0_4px_24px_rgba(15,23,42,0.04)] dark:shadow-[0_4px_24px_rgba(0,0,0,0.2)] border border-slate-50 dark:border-slate-700/50 flex flex-col lg:flex-row items-center justify-between gap-5 mt-2 transition-all">
                    <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon flex items-center w-full lg:w-auto relative flex-1 max-w-lg group">
                            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
                            
                            <!-- Coupon Icon -->
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#FFB7C5] transition-colors pointer-events-none z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 15h20"/><path d="M2 9h20"/><path d="M5.5 15v6"/><path d="M5.5 3v6"/><path d="M18.5 15v6"/><path d="M18.5 3v6"/></svg>
                            </div>
                            
                            <input type="text" name="coupon_code" class="input-text w-full pl-12 pr-[110px] py-4 rounded-full border-2 border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 text-sm font-bold text-slate-800 dark:text-white outline-none focus:border-[#FFB7C5] focus:bg-white dark:focus:bg-slate-800 transition-all placeholder:text-slate-400 placeholder:font-semibold" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Have a coupon code?', 'woocommerce' ); ?>" />
                            
                            <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> absolute right-1.5 top-1/2 -translate-y-1/2 bg-slate-800 dark:bg-slate-700 text-white px-6 py-3 rounded-full text-sm font-bold hover:bg-[#FFB7C5] hover:shadow-[0_4px_15px_rgba(255,183,197,0.4)] hover:-translate-y-[1px] transition-all" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
                            
                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                    <?php } ?>

                    <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> w-full lg:w-auto px-8 py-4 bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 rounded-full font-bold text-[0.95rem] hover:bg-slate-800 hover:text-white dark:hover:bg-slate-600 transition-all lg:ml-auto" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                    <?php do_action( 'woocommerce_cart_actions' ); ?>

                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            </div>

            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>

    </div><!-- end left col -->

    <!-- RIGHT COLUMN: Order Summary -->
    <div class="lg:col-span-4">

        <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

        <div class="cart-collaterals">
            <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            do_action( 'woocommerce_cart_collaterals' );
            ?>
        </div>

    </div><!-- end right col -->

</div><!-- end grid -->

<?php do_action( 'woocommerce_after_cart' ); ?>
