<?php
/**
 * Cart Page
 */
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="container mx-auto px-4 lg:px-8 py-10 animate-in fade-in">
    <h1 class="font-['Bubblegum_Sans'] text-4xl text-gray-800 dark:text-gray-100 mb-8">Shopping Cart</h1>

    <!-- 2-Column Layout based on your React Design -->
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Left Side: Cart Items -->
        <div class="flex-[2]">
            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php do_action( 'woocommerce_before_cart_table' ); ?>
                
                <!-- The Cart Table -->
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full" cellspacing="0">
                    <tbody>
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <!-- Each Cart Item (We will style this TR like your React Card via CSS) -->
                                <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                    <td class="product-thumbnail w-24 h-24 shrink-0">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full rounded-2xl object-cover bg-gray-50 dark:bg-slate-700 mix-blend-multiply dark:mix-blend-normal' ) ), $cart_item, $cart_item_key );
                                        if ( ! $product_permalink ) {
                                            echo $thumbnail; // PHPCS: XSS ok.
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                        }
                                        ?>
                                    </td>

                                    <td class="product-name flex-grow px-4" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="font-bold text-gray-800 dark:text-gray-200">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }
                                        
                                        // Product Price below Title (Like your design)
                                        echo '<div class="text-[#FFB7C5] dark:text-pink-400 font-bold mt-1">';
                                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                        echo '</div>';
                                        ?>
                                    </td>

                                    <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                                    'min_value'    => '0',
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );
                                        }
                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                        ?>
                                    </td>

                                    <td class="product-remove ml-auto">
                                        <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="p-3 text-red-300 dark:text-red-400 hover:text-red-500 transition-colors bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-full inline-flex items-center justify-center" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2M10 11v6M14 11v6"/></svg></a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_html__( 'Remove this item', 'woocommerce' ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <!-- Cart Actions (Update Button & Coupons) -->
                        <tr>
                            <td colspan="6" class="actions pt-6 flex flex-col sm:flex-row gap-4">
                                <?php if ( wc_coupons_enabled() ) { ?>
                                    <div class="coupon flex flex-1 gap-2">
                                        <input type="text" name="coupon_code" class="input-text w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm outline-none focus:border-[#A8D8EA] dark:text-white" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                                        <button type="submit" class="button bg-gray-800 dark:bg-slate-700 text-white px-6 rounded-xl font-bold hover:bg-black dark:hover:bg-slate-600" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
                                    </div>
                                <?php } ?>
                                <button type="submit" class="button bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 ml-auto" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </form>
        </div>

        <!-- Right Side: Cart Totals Sidebar -->
        <div class="flex-1">
            <div class="cart-collaterals bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-50 dark:border-slate-700 sticky top-28">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-6 border-b pb-4 dark:border-slate-700">Order Summary</h3>
                <?php
                /**
                 * Cart collaterals hook. Calculates subtotal, shipping, and total.
                 */
                do_action( 'woocommerce_cart_collaterals' );
                ?>
            </div>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>