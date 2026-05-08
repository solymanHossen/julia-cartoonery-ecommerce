<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_account_dashboard' );

$account_url = wc_get_page_permalink( 'myaccount' );
$orders_url = wc_get_account_endpoint_url( 'orders' );
$downloads_url = wc_get_account_endpoint_url( 'downloads' );
$addresses_url = wc_get_account_endpoint_url( 'edit-address' );
$account_details_url = wc_get_account_endpoint_url( 'edit-account' );
$logout_url = wc_logout_url( $account_url );
$current_user = wp_get_current_user();
$display_name = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
$user_id = (int) $current_user->ID;

$orders_count = function_exists( 'wc_get_customer_order_count' ) ? (int) wc_get_customer_order_count( $user_id ) : 0;
$downloads_count = function_exists( 'wc_get_customer_available_downloads' ) ? count( wc_get_customer_available_downloads( $user_id ) ) : 0;

$billing_ready = ! empty( get_user_meta( $user_id, 'billing_address_1', true ) ) && ! empty( get_user_meta( $user_id, 'billing_postcode', true ) );
$shipping_ready = ! empty( get_user_meta( $user_id, 'shipping_address_1', true ) ) && ! empty( get_user_meta( $user_id, 'shipping_postcode', true ) );

$profile_score = 34;
$profile_score += ! empty( $current_user->user_email ) ? 33 : 0;
$profile_score += ( $billing_ready || $shipping_ready ) ? 33 : 0;
$profile_score = min( 100, $profile_score );

$recent_orders = function_exists( 'wc_get_orders' ) ? wc_get_orders(
    array(
        'customer_id' => $user_id,
        'limit' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
    )
) : array();

$last_order = ! empty( $recent_orders ) ? $recent_orders[0] : null;
?>

<div class="julias-account-shell">
    <section class="julias-account-hero">
        <div class="julias-account-hero-copy">
            <span class="julias-account-kicker">My Account</span>
            <h1 class="julias-account-title">Welcome back, <?php echo esc_html( $display_name ); ?></h1>
            <p class="julias-account-intro">
                This is your personal control room. Track order progress, keep delivery info up to date, and keep your profile checkout-ready.
            </p>
            <div class="julias-account-hero-actions">
                <a class="julias-account-primary-btn" href="<?php echo esc_url( $orders_url ); ?>">View orders</a>
                <a class="julias-account-secondary-btn" href="<?php echo esc_url( $account_details_url ); ?>">Edit profile</a>
            </div>
        </div>
    </section>

    <section class="julias-account-metrics" aria-label="Account metrics">
        <article class="julias-account-metric-card">
            <p class="julias-account-metric-label">Orders placed</p>
            <p class="julias-account-metric-value"><?php echo esc_html( number_format_i18n( $orders_count ) ); ?></p>
            <p class="julias-account-metric-copy">Total purchases in your account history.</p>
        </article>
        <article class="julias-account-metric-card">
            <p class="julias-account-metric-label">Downloads ready</p>
            <p class="julias-account-metric-value"><?php echo esc_html( number_format_i18n( $downloads_count ) ); ?></p>
            <p class="julias-account-metric-copy">Items currently available to download.</p>
        </article>
        <article class="julias-account-metric-card">
            <p class="julias-account-metric-label">Profile completion</p>
            <p class="julias-account-metric-value"><?php echo esc_html( $profile_score ); ?>%</p>
            <p class="julias-account-metric-copy">Higher completion means faster future checkout.</p>
        </article>
    </section>

    <section class="julias-account-panels" aria-label="Account overview">
        <article class="julias-account-panel">
            <p class="julias-account-note-label">Recent activity</p>
            <?php if ( $last_order instanceof WC_Order ) : ?>
                <h2 class="julias-account-panel-title">Last order #<?php echo esc_html( $last_order->get_order_number() ); ?></h2>
                <p class="julias-account-panel-copy">
                    Status: <strong><?php echo esc_html( wc_get_order_status_name( $last_order->get_status() ) ); ?></strong>
                    and total <strong><?php echo wp_kses_post( $last_order->get_formatted_order_total() ); ?></strong>.
                </p>
                <a class="julias-account-inline-link" href="<?php echo esc_url( $last_order->get_view_order_url() ); ?>">Review this order</a>
            <?php else : ?>
                <h2 class="julias-account-panel-title">No orders yet</h2>
                <p class="julias-account-panel-copy">Once you place an order, you will see the latest update here.</p>
            <?php endif; ?>
        </article>

        <article class="julias-account-panel">
            <p class="julias-account-note-label">Next best steps</p>
            <h2 class="julias-account-panel-title">Keep your account ready</h2>
            <ul class="julias-account-checklist">
                <li>
                    <span>Address setup</span>
                    <strong><?php echo ( $billing_ready || $shipping_ready ) ? 'Ready' : 'Missing'; ?></strong>
                </li>
                <li>
                    <span>Account details</span>
                    <a href="<?php echo esc_url( $account_details_url ); ?>">Update</a>
                </li>
                <li>
                    <span>Security</span>
                    <a href="<?php echo esc_url( $logout_url ); ?>">Log out this device</a>
                </li>
            </ul>
            <a class="julias-account-inline-link" href="<?php echo esc_url( $addresses_url ); ?>">Manage addresses</a>
        </article>
    </section>

    <section class="julias-account-notes">
        <div>
            <p class="julias-account-note-label">Need help?</p>
            <p class="julias-account-note-copy">If something looks wrong with an order or address, the support team can help from the contact page.</p>
        </div>
        <a class="julias-account-note-link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact support</a>
    </section>
</div>

<?php do_action( 'woocommerce_account_dashboard_end' ); ?>