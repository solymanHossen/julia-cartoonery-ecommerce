<?php
/**
 * WooCommerce Custom Functions (Cart Fragments & Custom Wishlist)
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. AJAX Cart Fragments (Header Cart Count)
add_filter('woocommerce_add_to_cart_fragments', 'julias_cart_count_fragments', 10, 1);
function julias_cart_count_fragments($fragments) {
    ob_start();
    $cart_count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="julias-cart-count absolute -top-1 -right-1 bg-red-400 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full transition-transform duration-300 transform scale-100 <?php echo $cart_count == 0 ? 'hidden' : ''; ?>">
        <?php echo esc_html($cart_count); ?>
    </span>
    <?php
    $fragments['span.julias-cart-count'] = ob_get_clean();
    return $fragments;
}

// 2. Custom Wishlist Logic
function julias_get_wishlist() {
    $wishlist = [];
    if (is_user_logged_in()) {
        $wishlist = get_user_meta(get_current_user_id(), '_julias_wishlist', true);
    } else {
        $wishlist = isset($_COOKIE['julias_wishlist']) ? json_decode(wp_unslash($_COOKIE['julias_wishlist']), true) : [];
    }
    return is_array($wishlist) ? $wishlist : [];
}

function julias_save_wishlist($wishlist) {
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), '_julias_wishlist', $wishlist);
    } else {
        setcookie('julias_wishlist', wp_json_encode($wishlist), time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
    }
}

add_action('wp_ajax_toggle_wishlist', 'julias_toggle_wishlist_ajax');
add_action('wp_ajax_nopriv_toggle_wishlist', 'julias_toggle_wishlist_ajax');
function julias_toggle_wishlist_ajax() {
    check_ajax_referer('julias_wishlist_nonce', 'security');

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if (!$product_id) {
        wp_send_json_error(['message' => 'Invalid product.']);
    }

    $wishlist = julias_get_wishlist();
    $is_added = false;

    if (in_array($product_id, $wishlist)) {
        $wishlist = array_diff($wishlist, [$product_id]); // Remove
    } else {
        $wishlist[] = $product_id; // Add
        $is_added = true;
    }

    julias_save_wishlist($wishlist);

    // Prepare fragment for header wishlist count
    ob_start();
    $wishlist_count = count($wishlist);
    ?>
    <span class="julias-wishlist-count absolute -top-1 -right-1 bg-[#FFB7C5] text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full transition-transform duration-300 transform scale-100 <?php echo $wishlist_count == 0 ? 'hidden' : ''; ?>">
        <?php echo esc_html($wishlist_count); ?>
    </span>
    <?php
    $fragment = ob_get_clean();

    wp_send_json_success([
        'is_added' => $is_added,
        'count' => $wishlist_count,
        'fragment' => $fragment
    ]);
}

// 3. Pass AJAX URL to Frontend
add_action('wp_enqueue_scripts', 'julias_wishlist_scripts');
function julias_wishlist_scripts() {
    wp_localize_script('app-js', 'juliasSettings', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('julias_wishlist_nonce'),
    ]);
}
