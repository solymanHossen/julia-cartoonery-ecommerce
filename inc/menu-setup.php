<?php

function julias_cartoonery_get_default_menu_items()
{
    return array(
        array('name' => 'Home', 'url' => '/'),
        array('name' => 'Shop', 'url' => '/shop/'),
        array('name' => 'Blog', 'url' => '/blog/'),
        array('name' => 'Story Book', 'url' => '/stories/'),
        array('name' => 'Playground', 'url' => '/games/'),
        array('name' => 'Characters', 'url' => '/characters/'),
        array('name' => 'Create AI', 'url' => '/create/'),
    );
}

function julias_cartoonery_seed_primary_menu()
{
    $menu_name = 'Primary Menu';
    $menu_location = 'primary';
    $menu = wp_get_nav_menu_object($menu_name);

    if (!$menu) {
        $menu_id = wp_create_nav_menu($menu_name);
        $menu_items = julias_cartoonery_get_default_menu_items();

        foreach ($menu_items as $item) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $item['name'],
                'menu-item-url' => home_url($item['url']),
                'menu-item-status' => 'publish',
                'menu-item-type' => 'custom',
            ));
        }

        $menu = wp_get_nav_menu_object($menu_id);
    }

    if ($menu && !has_nav_menu($menu_location)) {
        $locations = get_theme_mod('nav_menu_locations', array());
        $locations[$menu_location] = $menu->term_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

function julias_cartoonery_maybe_seed_menu()
{
    if (get_option('julias_cartoonery_menu_seeded')) {
        return;
    }

    julias_cartoonery_seed_primary_menu();
    update_option('julias_cartoonery_menu_seeded', 1);
}
add_action('after_switch_theme', 'julias_cartoonery_seed_primary_menu');
add_action('init', 'julias_cartoonery_maybe_seed_menu');

function julias_cartoonery_fallback_menu()
{
    $items = julias_cartoonery_get_default_menu_items();
    echo '<ul class="flex gap-6 xl:gap-8 font-bold text-gray-600 dark:text-gray-300">';

    foreach ($items as $item) {
        printf(
            '<li><a href="%s" class="hover:text-pinkBrand dark:hover:text-pink-400 transition-colors relative">%s</a></li>',
            esc_url(home_url($item['url'])),
            esc_html($item['name'])
        );
    }

    echo '</ul>';
}

// মেনু লোকেশন রেজিস্টার করার কোড (একদম শেষে যোগ করা হলো)
function julias_cartoonery_register_menus()
{
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'julias-cartoonery-ecommerce'),
    ));
}
add_action('after_setup_theme', 'julias_cartoonery_register_menus');