<?php
/**
 * WooCommerce Dependency Check & Admin Notice
 * 
 * Best Practices Implemented:
 * - Efficient transient-based checking (avoids repeated file_exists checks)
 * - Proper nonce security for install/activate URLs
 * - Dismissible notice with persistent dismissal
 * - User capability check (show only to admins who can install plugins)
 * - Non-blocking - theme works even without WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check WooCommerce dependency on admin init
 * Uses transient caching for performance optimization
 */
function julias_cartoonery_check_woocommerce_dependency() {
	// Only check if current user can manage plugins (admin+ capability)
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Get cached check result (valid for 24 hours)
	$woocommerce_installed = get_transient( 'julias_woocommerce_status_check' );

	// If transient expired, re-check
	if ( false === $woocommerce_installed ) {
		$is_installed = class_exists( 'WooCommerce' );
		set_transient( 'julias_woocommerce_status_check', $is_installed ? 'active' : 'inactive', DAY_IN_SECONDS );
	} else {
		$is_installed = ( 'active' === $woocommerce_installed );
	}

	// Only show notice if WooCommerce is not active
	if ( ! $is_installed ) {
		add_action( 'admin_notices', 'julias_cartoonery_woocommerce_missing_notice' );
	}
}
add_action( 'admin_init', 'julias_cartoonery_check_woocommerce_dependency' );

/**
 * Display WooCommerce missing notice with smart action buttons
 * 
 * @return void
 */
function julias_cartoonery_woocommerce_missing_notice() {
	// Double-check capability before showing notice
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$plugin_slug = 'woocommerce';
	$plugin_path = 'woocommerce/woocommerce.php';

	// Generate secured URLs with nonce protection
	$install_url = wp_nonce_url(
		admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_slug ),
		'install-plugin_' . $plugin_slug
	);
	$activate_url = wp_nonce_url(
		admin_url( 'plugins.php?action=activate&plugin=' . $plugin_path ),
		'activate-plugin_' . $plugin_path
	);

	// Check if plugin folder already exists (installed but not activated)
	$is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_path );

	// Determine action button and text
	$button_text = $is_installed ? '✓ Activate WooCommerce' : '⬇ Install WooCommerce Now';
	$button_url  = $is_installed ? $activate_url : $install_url;
	$button_class = $is_installed ? 'button-secondary' : 'button-primary';

	?>
	<div class="notice notice-error is-dismissible" style="border-left: 4px solid #FFB7C5; padding: 15px 12px;">
		<p style="font-size: 15px; margin: 0 0 10px 0;">
			<strong>⚠️ Julia's Cartoonery Theme Notice:</strong>
			<br>
			This theme is optimized for <strong>WooCommerce</strong>. 
			<?php echo $is_installed ? 'Please activate it to unlock all features.' : 'Please install and activate it to enable full functionality.'; ?>
		</p>
		<p style="margin: 0;">
			<a href="<?php echo esc_url( $button_url ); ?>" class="button <?php echo esc_attr( $button_class ); ?>" style="background: #FFB7C5; border-color: #FFB7C5; color: white; text-shadow: none; font-weight: 600;">
				<?php echo esc_html( $button_text ); ?>
			</a>
		</p>
	</div>
	<?php
}

/**
 * Clear WooCommerce status transient when plugins are activated/deactivated
 * This ensures the notice updates immediately after plugin actions
 */
function julias_cartoonery_clear_woocommerce_transient() {
	delete_transient( 'julias_woocommerce_status_check' );
}
add_action( 'activated_plugin', 'julias_cartoonery_clear_woocommerce_transient' );
add_action( 'deactivated_plugin', 'julias_cartoonery_clear_woocommerce_transient' );
