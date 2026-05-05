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

// 3. AJAX Wishlist Drawer Content
add_action('wp_ajax_get_wishlist_content', 'julias_get_wishlist_content_ajax');
add_action('wp_ajax_nopriv_get_wishlist_content', 'julias_get_wishlist_content_ajax');
function julias_get_wishlist_content_ajax() {
    check_ajax_referer('julias_wishlist_nonce', 'security');
    
    $wishlist = julias_get_wishlist();
    
    ob_start();
    
    if (empty($wishlist)) {
        echo '<div class="flex flex-col items-center justify-center h-full text-center p-6">';
        echo '<svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z" /></svg>';
        echo '<h3 class="text-lg font-bold text-slate-700 dark:text-slate-200 mb-2 font-[\'Bubblegum_Sans\']">Your wishlist is empty</h3>';
        echo '<p class="text-sm text-slate-500 dark:text-slate-400">Looks like you haven\'t added anything to your wishlist yet.</p>';
        echo '</div>';
    } else {
        echo '<ul class="flex flex-col gap-4 p-4">';
        foreach ($wishlist as $product_id) {
            $product = wc_get_product($product_id);
            if (!$product || !$product->is_visible()) continue;
            
            $image = wp_get_attachment_image($product->get_image_id(), 'thumbnail', false, ['class' => 'w-full h-full object-cover rounded-lg']);
            $title = $product->get_name();
            $price = $product->get_price_html();
            $url = $product->get_permalink();
            
            echo '<li class="flex items-center gap-4 bg-white dark:bg-slate-800 p-3 rounded-[16px] shadow-sm border border-slate-100 dark:border-slate-700 relative group">';
            echo '<a href="' . esc_url($url) . '" class="w-16 h-16 shrink-0 bg-slate-50 dark:bg-slate-700 rounded-lg overflow-hidden">' . $image . '</a>';
            echo '<div class="flex-1 min-w-0">';
            echo '<a href="' . esc_url($url) . '" class="block text-sm font-bold text-slate-800 dark:text-slate-100 truncate hover:text-[#FFB7C5] transition-colors">' . esc_html($title) . '</a>';
            echo '<div class="text-xs font-bold text-[#FFB7C5] mt-1">' . wp_kses_post($price) . '</div>';
            echo '</div>';
            
            // Remove button
            echo '<button type="button" class="julias-wishlist-btn absolute -top-2 -right-2 w-7 h-7 bg-white dark:bg-slate-700 rounded-full shadow-md text-red-400 hover:text-red-600 flex items-center justify-center transition-transform hover:scale-110 opacity-0 group-hover:opacity-100" data-product-id="' . esc_attr($product_id) . '" aria-label="Remove from wishlist">';
            echo '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            echo '</button>';
            echo '</li>';
        }
        echo '</ul>';
    }
    
    wp_send_json_success(['html' => ob_get_clean()]);
}

// 4. Pass AJAX URL to Frontend
add_action('wp_enqueue_scripts', 'julias_wishlist_scripts');
function julias_wishlist_scripts() {
    wp_localize_script('app-js', 'juliasSettings', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('julias_wishlist_nonce'),
    ]);
}
