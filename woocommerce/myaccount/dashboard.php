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
?>

<div class="julias-account-shell">
    <section class="julias-account-hero">
        <div class="julias-account-hero-copy">
            <span class="julias-account-kicker">My Account</span>
            <h1 class="julias-account-title">Welcome back, <?php echo esc_html( $display_name ); ?></h1>
            <p class="julias-account-intro">
                Manage your orders, update your details, and jump back into your favorite parts of Julia's Cartoonery.
            </p>
        </div>

        <div class="julias-account-hero-panel">
            <div class="julias-account-hero-badge">Quick access</div>
            <div class="julias-account-hero-links">
                <a class="julias-account-hero-link" href="<?php echo esc_url( $orders_url ); ?>">Orders</a>
                <a class="julias-account-hero-link" href="<?php echo esc_url( $downloads_url ); ?>">Downloads</a>
                <a class="julias-account-hero-link" href="<?php echo esc_url( $addresses_url ); ?>">Addresses</a>
                <a class="julias-account-hero-link" href="<?php echo esc_url( $account_details_url ); ?>">Account details</a>
            </div>
        </div>
    </section>

    <section class="julias-account-grid" aria-label="Account shortcuts">
        <a class="julias-account-card" href="<?php echo esc_url( $orders_url ); ?>">
            <span class="julias-account-card-label">Orders</span>
            <strong class="julias-account-card-title">Track purchases</strong>
            <span class="julias-account-card-copy">Review recent orders, payment status, and fulfillment updates.</span>
        </a>

        <a class="julias-account-card" href="<?php echo esc_url( $addresses_url ); ?>">
            <span class="julias-account-card-label">Addresses</span>
            <strong class="julias-account-card-title">Keep delivery ready</strong>
            <span class="julias-account-card-copy">Update billing and shipping information in one place.</span>
        </a>

        <a class="julias-account-card" href="<?php echo esc_url( $account_details_url ); ?>">
            <span class="julias-account-card-label">Profile</span>
            <strong class="julias-account-card-title">Edit your details</strong>
            <span class="julias-account-card-copy">Change your password, email, and public account name.</span>
        </a>

        <a class="julias-account-card" href="<?php echo esc_url( $logout_url ); ?>">
            <span class="julias-account-card-label">Session</span>
            <strong class="julias-account-card-title">Sign out safely</strong>
            <span class="julias-account-card-copy">Log out from this device when you are finished.</span>
        </a>
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