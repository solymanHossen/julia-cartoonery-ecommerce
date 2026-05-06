<?php
function julias_cartoonery_setup() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'julias-cartoonery' ),
        'footer_quick_links' => __( 'Footer Quick Links', 'julias-cartoonery' ),
        'footer_support'     => __( 'Footer Support', 'julias-cartoonery' ),
    ) );

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'julias_cartoonery_setup' );

function julias_cartoonery_theme_bootstrap() {
    ?>
    <script>
        (function () {
            try {
                var storedTheme = localStorage.getItem('theme');
                var systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = storedTheme === 'dark' || storedTheme === 'light' ? storedTheme : (systemPrefersDark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', theme === 'dark');
                document.documentElement.style.colorScheme = theme;
            } catch (error) {}
        })();
    </script>
    <?php
}
add_action( 'wp_head', 'julias_cartoonery_theme_bootstrap', 1 );

function julias_cartoonery_nav_classes( $atts, $item, $args ) {
    if ( $args->theme_location == 'primary' ) {
        $classes = 'hover:text-[#FFB7C5] dark:hover:text-pink-400 transition-colors relative pb-1';
        if ( in_array( 'current-menu-item', $item->classes ) ) {
            $classes .= ' text-[#FFB7C5] dark:text-pink-400';
            $classes .= ' after:content-[""] after:absolute after:-bottom-2 after:left-1/2 after:-translate-x-1/2 after:w-1/2 after:h-1 after:bg-[#FFB7C5] dark:after:bg-pink-400 after:rounded-full';
        }
        
        $atts['class'] = $classes;
    }
    if ( $args->theme_location == 'footer_quick_links' || $args->theme_location == 'footer_support' ) {
        $atts['class'] = 'hover:text-[#A8D8EA] dark:hover:text-sky-400 cursor-pointer transition-colors block';
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'julias_cartoonery_nav_classes', 10, 3 );

/**
 * Automatically create the Playground Games & Create Character pages if they don't exist
 * to ensure the /games/ and /create/ URLs work immediately.
 */
function julias_cartoonery_auto_create_pages() {
    $pages = [
        [
            'title' => 'Playground Games',
            'slug' => 'games',
            'template' => 'page-games.php'
        ],
        [
            'title' => 'Create Character',
            'slug' => 'create',
            'template' => 'page-create.php'
        ]
    ];

    foreach ($pages as $page) {
        if ( ! get_page_by_path( $page['slug'] ) ) {
            wp_insert_post( array(
                'post_title'     => $page['title'],
                'post_name'      => $page['slug'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'page_template'  => $page['template']
            ) );
        }
    }
}
add_action( 'init', 'julias_cartoonery_auto_create_pages' );

function jc_force_create_cart_page() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $cart_page_id = get_option( 'woocommerce_cart_page_id' );

    // যদি কার্ট পেজ না থাকে বা পাবলিশড না থাকে
    if ( ! $cart_page_id || ! get_post( $cart_page_id ) || get_post_status( $cart_page_id ) !== 'publish' ) {
        
        $cart_page_data = array(
            'post_title'    => 'Cart',
            'post_content'  => '[woocommerce_cart]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'cart',
            'page_template' => 'page-cart.php' // আপনার তৈরি করা টেমপ্লেট
        );

        $new_cart_page_id = wp_insert_post( $cart_page_data );

        if ( ! is_wp_error( $new_cart_page_id ) ) {
            update_option( 'woocommerce_cart_page_id', $new_cart_page_id );
        }
    }
}
// থিম সেটআপের সময় এটি রান করবে
add_action( 'after_setup_theme', 'jc_force_create_cart_page' );