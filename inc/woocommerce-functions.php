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
        echo '<div class="flex flex-col items-center justify-center h-full text-center p-8">';
        echo '<div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-[28px] flex items-center justify-center mb-6">';
        echo '<svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>';
        echo '</div>';
        echo '<h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2 font-[\'Bubblegum_Sans\']">Empty Wishlist</h3>';
        echo '<p class="text-sm font-medium text-slate-400 dark:text-slate-500">Your minimal wishlist is waiting for items.</p>';
        echo '</div>';
    } else {
        echo '<ul class="flex flex-col gap-3 p-4">';
        global $product;
        foreach ($wishlist as $product_id) {
            $product = wc_get_product($product_id);
            if (!$product || !$product->is_visible()) continue;
            
            $title = $product->get_name();
            $price = $product->get_price_html();
            $url = $product->get_permalink();
            $categories = strip_tags(wc_get_product_category_list($product->get_id(), ', '));
            
            echo '<li class="flex bg-white dark:bg-slate-800 p-3 rounded-[28px] shadow-[0_4px_20px_rgba(15,23,42,0.03)] dark:shadow-[0_4px_20px_rgba(0,0,0,0.3)] border border-slate-50 dark:border-slate-700/50 transition-all duration-300 relative group">';
            
            // Image Area
            echo '<div class="w-[84px] h-[84px] shrink-0 rounded-[20px] overflow-hidden bg-slate-50 dark:bg-slate-700 mr-4 relative">';
            echo '<a href="' . esc_url($url) . '" class="block w-full h-full">';
            echo wp_get_attachment_image($product->get_image_id(), 'woocommerce_thumbnail', false, ['class' => 'w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105 mix-blend-multiply dark:mix-blend-normal']);
            echo '</a>';
            echo '</div>';
            
            // Details Area
            echo '<div class="flex flex-1 flex-col justify-center min-w-0 py-0.5">';
            
            // Category
            if ($categories) {
                echo '<div class="text-[0.6rem] font-bold uppercase tracking-[0.15em] text-slate-400 dark:text-slate-500 mb-0.5 truncate">' . esc_html($categories) . '</div>';
            }
            // Title
            echo '<a href="' . esc_url($url) . '" class="block text-[0.9rem] font-extrabold text-slate-800 dark:text-slate-100 leading-snug mb-2 hover:text-[#FFB7C5] transition-colors truncate">' . esc_html($title) . '</a>';
            
            // Bottom Row: Price + Actions
            echo '<div class="flex items-end justify-between w-full">';
            
            // Price (Stacked with minimal-price-stack class handled in CSS, or inline)
            // Using a wrapper that we will style in CSS for the stacked look
            echo '<div class="minimal-price-stack text-[#FFB7C5] leading-none">';
            echo wp_kses_post($price);
            echo '</div>';
            
            // Actions
            echo '<div class="flex items-center gap-2">';
            
            // Remove Button
            echo '<button type="button" class="julias-wishlist-btn flex items-center justify-center w-[34px] h-[34px] rounded-full bg-red-50/80 dark:bg-red-500/10 text-red-400 hover:bg-red-100 hover:text-red-500 transition-colors" data-product-id="' . esc_attr($product_id) . '" aria-label="Remove from wishlist" title="Remove">';
            echo '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
            echo '</button>';
            
            // Native Add to Cart wrapper with minimal styles override
            echo '<div class="minimal-cart-btn shrink-0 flex items-center justify-center">';
            ob_start();
            woocommerce_template_loop_add_to_cart();
            echo ob_get_clean();
            echo '</div>';
            
            echo '</div>'; // End Actions
            echo '</div>'; // End Bottom Row
            
            echo '</div>'; // End Details Area
            echo '</li>';
        }
        wp_reset_postdata();
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
