<?php
/**
 * Wishlist Admin Analytics Dashboard
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'julias_wishlist_admin_menu');
function julias_wishlist_admin_menu() {
    add_submenu_page(
        'woocommerce',
        'Wishlist Insights',
        'Wishlists',
        'manage_woocommerce',
        'julias-wishlists',
        'julias_wishlist_admin_page'
    );
}

function julias_wishlist_admin_page() {
    if (!current_user_can('manage_woocommerce')) {
        return;
    }

    global $wpdb;
    
    // Aggregate product IDs from all users
    $results = $wpdb->get_results("SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = '_julias_wishlist'");
    
    $product_counts = [];
    $total_wishlists = count($results);
    $total_items_wished = 0;

    foreach ($results as $row) {
        $wishlist = maybe_unserialize($row->meta_value);
        if (is_array($wishlist)) {
            foreach ($wishlist as $pid) {
                if (!isset($product_counts[$pid])) {
                    $product_counts[$pid] = 0;
                }
                $product_counts[$pid]++;
                $total_items_wished++;
            }
        }
    }
    
    arsort($product_counts); // Sort by count descending
    ?>
    <div class="wrap julias-admin-wrap">
        <style>
            /* Modern Admin UI Overrides */
            .julias-admin-wrap {
                margin-top: 20px;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            }
            .julias-admin-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 30px;
                background: #fff;
                padding: 24px 32px;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.03);
                border: 1px solid #e2e8f0;
            }
            .julias-admin-header h1 {
                margin: 0;
                font-size: 24px;
                font-weight: 700;
                color: #1e293b;
            }
            .julias-admin-stats {
                display: flex;
                gap: 20px;
            }
            .julias-stat-card {
                background: #f8fafc;
                padding: 16px 24px;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                text-align: center;
                min-width: 120px;
            }
            .julias-stat-card .stat-val {
                font-size: 28px;
                font-weight: 800;
                color: #ffb7c5;
                margin-bottom: 4px;
            }
            .julias-stat-card .stat-label {
                font-size: 13px;
                font-weight: 600;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .julias-table-container {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.03);
                border: 1px solid #e2e8f0;
                overflow: hidden;
            }
            .julias-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
            }
            .julias-table th {
                background: #f8fafc;
                padding: 16px 24px;
                font-size: 13px;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-bottom: 1px solid #e2e8f0;
            }
            .julias-table td {
                padding: 16px 24px;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
            }
            .julias-table tbody tr:hover {
                background-color: #f8fafc;
            }
            .product-cell {
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .product-cell img {
                width: 48px;
                height: 48px;
                border-radius: 8px;
                object-fit: cover;
                border: 1px solid #e2e8f0;
            }
            .product-cell .title {
                font-size: 15px;
                font-weight: 600;
                color: #1e293b;
                text-decoration: none;
            }
            .product-cell .title:hover {
                color: #ffb7c5;
            }
            .product-cell .sku {
                font-size: 13px;
                color: #94a3b8;
                margin-top: 2px;
            }
            .wishlist-count-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #fff1f3;
                color: #fb7185;
                font-weight: 700;
                font-size: 14px;
                padding: 6px 16px;
                border-radius: 9999px;
            }
            .empty-state {
                padding: 60px 20px;
                text-align: center;
                color: #64748b;
            }
        </style>

        <div class="julias-admin-header">
            <div>
                <h1>Wishlist Insights</h1>
                <p style="margin: 6px 0 0; color: #64748b;">Discover which products your users love the most.</p>
            </div>
            <div class="julias-admin-stats">
                <div class="julias-stat-card">
                    <div class="stat-val"><?php echo esc_html($total_wishlists); ?></div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="julias-stat-card">
                    <div class="stat-val"><?php echo esc_html($total_items_wished); ?></div>
                    <div class="stat-label">Total Saves</div>
                </div>
            </div>
        </div>

        <div class="julias-table-container">
            <?php if (empty($product_counts)): ?>
                <div class="empty-state">
                    <svg style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <h2>No wishlist data available yet.</h2>
                    <p>Once users start adding items to their wishlist, they will appear here.</p>
                </div>
            <?php else: ?>
                <table class="julias-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Times Wishlisted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        foreach ($product_counts as $pid => $count): 
                            $product = wc_get_product($pid);
                            if (!$product) continue;
                        ?>
                            <tr>
                                <td style="font-weight: 700; color: #94a3b8;">#<?php echo $rank++; ?></td>
                                <td>
                                    <div class="product-cell">
                                        <?php echo $product->get_image('thumbnail'); ?>
                                        <div>
                                            <a href="<?php echo esc_url(get_edit_post_link($pid)); ?>" class="title" target="_blank">
                                                <?php echo esc_html($product->get_name()); ?>
                                            </a>
                                            <?php if ($product->get_sku()): ?>
                                                <div class="sku">SKU: <?php echo esc_html($product->get_sku()); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 600; color: #475569;">
                                    <?php echo $product->get_price_html(); ?>
                                </td>
                                <td>
                                    <span class="wishlist-count-badge">❤️ <?php echo esc_html($count); ?></span>
                                </td>
                                <td>
                                    <a href="<?php echo esc_url(get_permalink($pid)); ?>" target="_blank" style="color: #3b82f6; text-decoration: none; font-weight: 600;">View Product &rarr;</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
