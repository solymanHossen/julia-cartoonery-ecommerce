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

function julias_cartoonery_get_flash_sale_deadline() {
    $deadline = get_theme_mod( 'flash_sale_end_date', '' );

    if ( empty( $deadline ) ) {
        return '';
    }

    $timezone = wp_timezone();
    $local_deadline = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i:s', $deadline, $timezone );

    if ( ! $local_deadline ) {
        $local_deadline = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i', $deadline, $timezone );
    }

    if ( ! $local_deadline ) {
        return '';
    }

    return $local_deadline->setTimezone( new DateTimeZone( 'UTC' ) )->format( 'c' );
}

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
 * Automatically create the Playground Games, Create Character, and Shipping Policy pages if they don't exist
 * to ensure the URLs work immediately. These pages are always published.
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
        ],
        [
            'title' => 'Shipping & Delivery Policy',
            'slug' => 'shipping-policy',
            'template' => 'page-shipping-policy.php'
        ],
        [
            'title' => 'Return, Refund & Exchange Policy',
            'slug' => 'return-refund-exchange-policy',
            'template' => 'page-return-refund-exchange-policy.php'
        ],
        [
            'title' => 'About Us',
            'slug' => 'about-us',
            'template' => 'page-about-us.php'
        ],
        [
            'title' => 'Contact Us',
            'slug' => 'contact',
            'template' => 'page-contact.php'
        ]
    ];

    foreach ($pages as $page) {
        if ( ! get_page_by_path( $page['slug'] ) ) {
            $page_post = wp_insert_post( array(
                'post_title'     => $page['title'],
                'post_name'      => $page['slug'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'page_template'  => $page['template']
            ) );
        } else {
            // Ensure it's always published
            $page_post = get_page_by_path( $page['slug'] );
            if ( $page_post && get_post_status( $page_post->ID ) !== 'publish' ) {
                wp_update_post( array(
                    'ID'          => $page_post->ID,
                    'post_status' => 'publish'
                ) );
            }
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
/**
 * Register customizer settings for dynamic home page sections
 */
function julias_cartoonery_customizer_settings( $wp_customize ) {
    // Create "Home Page" panel
    $wp_customize->add_panel(
        'julia_home_page',
        array(
            'title'           => __( 'Home Page Settings', 'julias-cartoonery' ),
            'description'     => __( 'Customize home page sections', 'julias-cartoonery' ),
            'priority'        => 25,
        )
    );

    // New Arrivals Header Section
    $wp_customize->add_section(
        'julia_latest_products_header',
        array(
            'title'       => __( 'Latest Products - Header', 'julias-cartoonery' ),
            'description' => __( 'Configure the header texts in the New Arrivals section', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 10,
        )
    );

    $wp_customize->add_setting( 'julia_latest_products_subtitle', array(
        'default'           => __( 'NEW ARRIVALS', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_latest_products_subtitle', array(
        'label'   => __( 'Subtitle', 'julias-cartoonery' ),
        'section' => 'julia_latest_products_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_latest_products_title', array(
        'default'           => __( 'Fresh toys in stock', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_latest_products_title', array(
        'label'   => __( 'Main Title', 'julias-cartoonery' ),
        'section' => 'julia_latest_products_header',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_latest_products_description', array(
        'default'           => __( 'Scroll through the latest additions to our collection. Each toy is carefully selected for quality and fun.', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_latest_products_description', array(
        'label'   => __( 'Description', 'julias-cartoonery' ),
        'section' => 'julia_latest_products_header',
        'type'    => 'textarea',
    ) );

    // New Arrivals Video Section
    $wp_customize->add_section(
        'julia_latest_products_video',
        array(
            'title'       => __( 'Latest Products - Video / Left Card', 'julias-cartoonery' ),
            'description' => __( 'Configure the featured video card in New Arrivals section', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 20,
        )
    );

    // Video URL Setting
    $wp_customize->add_setting(
        'julia_latest_products_video_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'julia_latest_products_video_url',
        array(
            'label'       => __( 'Video URL (YouTube or MP4)', 'julias-cartoonery' ),
            'description' => __( 'Enter YouTube URL (youtube.com/watch?v=...) or MP4 file URL', 'julias-cartoonery' ),
            'section'     => 'julia_latest_products_video',
            'type'        => 'url',
        )
    );

    // Video Title
    $wp_customize->add_setting(
        'julia_latest_products_video_title',
        array(
            'default'           => __( 'See toys in action', 'julias-cartoonery' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'julia_latest_products_video_title',
        array(
            'label'   => __( 'Video Title', 'julias-cartoonery' ),
            'section' => 'julia_latest_products_video',
            'type'    => 'text',
        )
    );

    // Video Description
    $wp_customize->add_setting(
        'julia_latest_products_video_description',
        array(
            'default'           => __( 'Watch kids play with their favorite toys and discover what makes them special.', 'julias-cartoonery' ),
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'julia_latest_products_video_description',
        array(
            'label'   => __( 'Video Description', 'julias-cartoonery' ),
            'section' => 'julia_latest_products_video',
            'type'    => 'textarea',
        )
    );

    // Button Text
    $wp_customize->add_setting(
        'julia_latest_products_video_button_text',
        array(
            'default'           => __( 'Watch Now', 'julias-cartoonery' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'julia_latest_products_video_button_text',
        array(
            'label'   => __( 'Button Text', 'julias-cartoonery' ),
            'section' => 'julia_latest_products_video',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'flash_sale_end_date',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'flash_sale_end_date_control',
        array(
            'label'       => __( 'Set Timer End Date & Time', 'julias-cartoonery' ),
            'description' => __( 'Use your site timezone. Format: YYYY-MM-DDTHH:MM or YYYY-MM-DDTHH:MM:SS. Leave blank to fall back to next Sunday at 11:59 PM.', 'julias-cartoonery' ),
            'section'     => 'static_front_page',
            'settings'    => 'flash_sale_end_date',
            'type'        => 'datetime-local',
            'input_attrs' => array(
                'step' => 1,
            ),
        )
    );

    // ===== Shipping & Delivery Policy Settings =====
    $wp_customize->add_section(
        'julia_shipping_policy',
        array(
            'title'       => __( 'Shipping & Delivery Policy', 'julias-cartoonery' ),
            'description' => __( 'Manage shipping policy content and delivery information', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 50,
        )
    );

    // Hero Section
    $wp_customize->add_setting( 'julia_shipping_hero_title', array(
        'default'           => __( 'Shipping & Delivery', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_hero_title', array(
        'label'   => __( 'Hero Title', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_hero_description', array(
        'default'           => __( 'We ensure your toys reach safely and on time! Fast, reliable delivery across Bangladesh.', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_hero_description', array(
        'label'   => __( 'Hero Description', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'textarea',
    ) );

    // Inside Dhaka
    $wp_customize->add_setting( 'julia_shipping_dhaka_title', array(
        'default'           => __( 'Inside Dhaka', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_dhaka_title', array(
        'label'   => __( 'Inside Dhaka - Title', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_dhaka_time', array(
        'default'           => __( '24-48 hours', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_dhaka_time', array(
        'label'   => __( 'Inside Dhaka - Delivery Time', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_dhaka_cost', array(
        'default'           => '60',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_dhaka_cost', array(
        'label'   => __( 'Inside Dhaka - Cost (BDT)', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'number',
    ) );

    $wp_customize->add_setting( 'julia_shipping_dhaka_coverage', array(
        'default'           => __( 'All areas within Dhaka city', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_dhaka_coverage', array(
        'label'   => __( 'Inside Dhaka - Coverage', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    // Outside Dhaka
    $wp_customize->add_setting( 'julia_shipping_outside_title', array(
        'default'           => __( 'Outside Dhaka', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_outside_title', array(
        'label'   => __( 'Outside Dhaka - Title', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_outside_time', array(
        'default'           => __( '3-5 business days', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_outside_time', array(
        'label'   => __( 'Outside Dhaka - Delivery Time', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_outside_cost', array(
        'default'           => '120',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_outside_cost', array(
        'label'   => __( 'Outside Dhaka - Cost (BDT)', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'number',
    ) );

    $wp_customize->add_setting( 'julia_shipping_outside_partners', array(
        'default'           => __( 'Pathao & Steadfast', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_outside_partners', array(
        'label'   => __( 'Outside Dhaka - Partners', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    // COD Section
    $wp_customize->add_setting( 'julia_shipping_cod_title', array(
        'default'           => __( '💳 Cash on Delivery (COD)', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_cod_title', array(
        'label'   => __( 'COD - Title', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_shipping_cod_description', array(
        'default'           => __( 'Pay when you receive your order! Cash on Delivery is available for all areas across Bangladesh. Order with confidence—pay only when you see your package!', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_shipping_cod_description', array(
        'label'   => __( 'COD - Description', 'julias-cartoonery' ),
        'section' => 'julia_shipping_policy',
        'type'    => 'textarea',
    ) );

    // ===== Contact Page Settings =====
    $wp_customize->add_section(
        'julia_contact_page',
        array(
            'title'       => __( 'Contact Page', 'julias-cartoonery' ),
            'description' => __( 'Manage the contact page trust details and WhatsApp button', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 60,
        )
    );

    $wp_customize->add_setting( 'julia_contact_address', array(
        'default'           => __( 'Dhaka, Bangladesh', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_contact_address', array(
        'label'   => __( 'Physical Address', 'julias-cartoonery' ),
        'section' => 'julia_contact_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_contact_email', array(
        'default'           => get_option( 'admin_email' ),
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_contact_email', array(
        'label'   => __( 'Email Address', 'julias-cartoonery' ),
        'section' => 'julia_contact_page',
        'type'    => 'email',
    ) );

    $wp_customize->add_setting( 'julia_contact_whatsapp', array(
        'default'           => __( '+8801XXXXXXXXX', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_contact_whatsapp', array(
        'label'   => __( 'WhatsApp Number', 'julias-cartoonery' ),
        'description' => __( 'Include country code, for example +8801XXXXXXXXX', 'julias-cartoonery' ),
        'section' => 'julia_contact_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_contact_intro', array(
        'default'           => __( 'We usually reply quickly during business hours.', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_contact_intro', array(
        'label'   => __( 'Support Note', 'julias-cartoonery' ),
        'section' => 'julia_contact_page',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'julias_cartoonery_customizer_settings' );

function julias_cartoonery_handle_contact_form() {
    if ( ! isset( $_POST['julias_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['julias_contact_nonce'] ) ), 'julias_contact_submit' ) ) {
        wp_safe_redirect( add_query_arg( 'contact', 'invalid', wp_get_referer() ? wp_get_referer() : home_url( '/contact/' ) ) );
        exit;
    }

    $name = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
    $phone = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
    $message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

    if ( empty( $name ) || empty( $phone ) || empty( $message ) ) {
        wp_safe_redirect( add_query_arg( 'contact', 'missing', wp_get_referer() ? wp_get_referer() : home_url( '/contact/' ) ) );
        exit;
    }

    $to = get_theme_mod( 'julia_contact_email', get_option( 'admin_email' ) );
    $subject = sprintf( __( 'New contact message from %s', 'julias-cartoonery' ), $name );
    $body = "Name: {$name}\nPhone: {$phone}\n\nMessage:\n{$message}\n";
    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    wp_mail( $to, $subject, $body, $headers );

    wp_safe_redirect( add_query_arg( 'contact', 'sent', home_url( '/contact/' ) ) );
    exit;
}
add_action( 'admin_post_nopriv_julias_contact_submit', 'julias_cartoonery_handle_contact_form' );
add_action( 'admin_post_julias_contact_submit', 'julias_cartoonery_handle_contact_form' );