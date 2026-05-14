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

function julias_cartoonery_get_faq_defaults() {
    return array(
        'Delivery & Tracking' => array(
            array(
                'question_key' => 'julia_faq_delivery_1_question',
                'answer_key'   => 'julia_faq_delivery_1_answer',
                'question_en'  => 'How fast do you deliver inside Dhaka?',
                'question_bn'  => 'ঢাকার ভেতরে কত দ্রুত ডেলিভারি দেন?',
                'answer_en'    => 'Orders inside Dhaka are usually delivered within 24-48 hours after confirmation, depending on the delivery location and order volume. We keep you updated if there is any unexpected delay.',
                'answer_bn'    => 'অর্ডার কনফার্ম হওয়ার পর সাধারণত ২৪-৪৮ ঘণ্টার মধ্যে ঢাকার ভেতরে ডেলিভারি করা হয়। লোকেশন ও অর্ডারের পরিমাণ অনুযায়ী সময় কিছুটা পরিবর্তন হতে পারে।',
            ),
            array(
                'question_key' => 'julia_faq_delivery_2_question',
                'answer_key'   => 'julia_faq_delivery_2_answer',
                'question_en'  => 'How long does delivery take outside Dhaka?',
                'question_bn'  => 'ঢাকার বাইরে ডেলিভারি কত দিনে হয়?',
                'answer_en'    => 'Outside Dhaka delivery typically takes 3-5 business days. We partner with trusted courier services so your order reaches you safely and on time.',
                'answer_bn'    => 'ঢাকার বাইরে সাধারণত ৩-৫ কার্যদিবসের মধ্যে ডেলিভারি পৌঁছে যায়। নির্ভরযোগ্য কুরিয়ার পার্টনার দিয়ে আমরা প্যাকেজ নিরাপদে পাঠাই।',
            ),
            array(
                'question_key' => 'julia_faq_delivery_3_question',
                'answer_key'   => 'julia_faq_delivery_3_answer',
                'question_en'  => 'Will I get tracking information for my order?',
                'question_bn'  => 'অর্ডারের ট্র্যাকিং কি পাব?',
                'answer_en'    => 'Yes. Once your order is dispatched, we share tracking details by SMS or email so you can follow the parcel status easily.',
                'answer_bn'    => 'হ্যাঁ। অর্ডার পাঠানো হলে SMS বা ইমেইলের মাধ্যমে ট্র্যাকিং তথ্য পাঠানো হয়, যাতে আপনি সহজে পার্সেলের অবস্থা জানতে পারেন।',
            ),
            array(
                'question_key' => 'julia_faq_delivery_4_question',
                'answer_key'   => 'julia_faq_delivery_4_answer',
                'question_en'  => 'Can I change my shipping address after placing an order?',
                'question_bn'  => 'অর্ডার দেওয়ার পর ঠিকানা পরিবর্তন করা যাবে?',
                'answer_en'    => 'If the parcel has not been handed to the courier yet, contact us as soon as possible. We will try to update the address before dispatch.',
                'answer_bn'    => 'পার্সেল কুরিয়ারের কাছে হস্তান্তর না হলে দ্রুত যোগাযোগ করুন। সম্ভব হলে আমরা ঠিকানা আপডেট করার চেষ্টা করব।',
            ),
        ),
        'Returns & Refunds' => array(
            array(
                'question_key' => 'julia_faq_returns_1_question',
                'answer_key'   => 'julia_faq_returns_1_answer',
                'question_en'  => 'What is your return policy?',
                'question_bn'  => 'রিটার্ন পলিসি কী?',
                'answer_en'    => 'We offer an easy return process for damaged, missing, or incorrect items. Contact us quickly with your order number and clear photos so we can help fast.',
                'answer_bn'    => 'ক্ষতিগ্রস্ত, ভুল, বা অনুপস্থিত আইটেমের ক্ষেত্রে সহজ রিটার্ন প্রসেস রয়েছে। অর্ডার নম্বর ও পরিষ্কার ছবি দিয়ে দ্রুত যোগাযোগ করলে আমরা সাহায্য করি।',
            ),
            array(
                'question_key' => 'julia_faq_returns_2_question',
                'answer_key'   => 'julia_faq_returns_2_answer',
                'question_en'  => 'What if my item arrives damaged?',
                'question_bn'  => 'পণ্য ক্ষতিগ্রস্ত হয়ে এলে কী করব?',
                'answer_en'    => 'Please refuse delivery if the damage is visible, or message us immediately with photos. We will arrange a replacement or refund based on the issue.',
                'answer_bn'    => 'ডেলিভারির সময় দৃশ্যমান ক্ষতি হলে গ্রহণ না করাই ভালো, অথবা দ্রুত ছবি পাঠিয়ে যোগাযোগ করুন। আমরা প্রতিস্থাপন বা রিফান্ডের ব্যবস্থা করব।',
            ),
            array(
                'question_key' => 'julia_faq_returns_3_question',
                'answer_key'   => 'julia_faq_returns_3_answer',
                'question_en'  => 'How long do refunds take?',
                'question_bn'  => 'রিফান্ড পেতে কত সময় লাগে?',
                'answer_en'    => 'Refund timing depends on the payment method and the issue type. Once approved, we process it as quickly as possible and keep you informed.',
                'answer_bn'    => 'পেমেন্ট মেথড ও সমস্যার ধরন অনুযায়ী সময় পরিবর্তিত হয়। অনুমোদনের পর যত দ্রুত সম্ভব রিফান্ড প্রসেস করা হয়।',
            ),
            array(
                'question_key' => 'julia_faq_returns_4_question',
                'answer_key'   => 'julia_faq_returns_4_answer',
                'question_en'  => 'Can I exchange a product instead of returning it?',
                'question_bn'  => 'রিটার্নের বদলে এক্সচেঞ্জ করা যাবে?',
                'answer_en'    => 'Yes, if the item is eligible for exchange and stock is available. Reach out with your order details and we will guide you through the next step.',
                'answer_bn'    => 'হ্যাঁ, স্টক থাকলে এবং প্রোডাক্টটি যোগ্য হলে এক্সচেঞ্জ করা যায়। অর্ডারের তথ্য দিয়ে যোগাযোগ করুন, আমরা পরবর্তী ধাপ জানিয়ে দেব।',
            ),
        ),
        'Payments & COD' => array(
            array(
                'question_key' => 'julia_faq_payments_1_question',
                'answer_key'   => 'julia_faq_payments_1_answer',
                'question_en'  => 'Do you offer Cash on Delivery?',
                'question_bn'  => 'Cash on Delivery কি আছে?',
                'answer_en'    => 'Yes. Cash on Delivery is available across Bangladesh for most orders, making checkout simple and trusted for parents and gift buyers.',
                'answer_bn'    => 'হ্যাঁ। বাংলাদেশজুড়ে বেশিরভাগ অর্ডারের জন্য Cash on Delivery সুবিধা আছে, যাতে কেনাকাটা সহজ ও নির্ভরযোগ্য হয়।',
            ),
            array(
                'question_key' => 'julia_faq_payments_2_question',
                'answer_key'   => 'julia_faq_payments_2_answer',
                'question_en'  => 'What payment methods do you accept?',
                'question_bn'  => 'কোন কোন পেমেন্ট মেথড গ্রহণ করেন?',
                'answer_en'    => 'We support Cash on Delivery and other payment methods offered during checkout. The available options may vary by location and order type.',
                'answer_bn'    => 'Cash on Delivery এবং চেকআউটে দেখানো অন্যান্য পেমেন্ট অপশন গ্রহণ করা হয়। অর্ডার ও লোকেশন অনুযায়ী অপশন পরিবর্তিত হতে পারে।',
            ),
            array(
                'question_key' => 'julia_faq_payments_3_question',
                'answer_key'   => 'julia_faq_payments_3_answer',
                'question_en'  => 'Is COD available outside Dhaka?',
                'question_bn'  => 'ঢাকার বাইরে COD পাওয়া যাবে?',
                'answer_en'    => 'Yes, COD is available in many areas outside Dhaka as well. If your address is eligible, the option appears at checkout.',
                'answer_bn'    => 'হ্যাঁ, অনেক ঢাকার বাইরের এলাকায়ও COD পাওয়া যায়। আপনার ঠিকানা eligible হলে চেকআউটে অপশন দেখাবে।',
            ),
            array(
                'question_key' => 'julia_faq_payments_4_question',
                'answer_key'   => 'julia_faq_payments_4_answer',
                'question_en'  => 'Is checkout secure?',
                'question_bn'  => 'চেকআউট কি নিরাপদ?',
                'answer_en'    => 'Absolutely. We only ask for the information needed to process your order and keep the checkout flow clear, quick, and secure.',
                'answer_bn'    => 'অবশ্যই। অর্ডার প্রসেস করার জন্য প্রয়োজনীয় তথ্যই শুধু নেওয়া হয়, আর চেকআউট ফ্লো সহজ ও পরিষ্কার রাখা হয়।',
            ),
        ),
        'General' => array(
            array(
                'question_key' => 'julia_faq_general_1_question',
                'answer_key'   => 'julia_faq_general_1_answer',
                'question_en'  => 'How do I contact support if I need help?',
                'question_bn'  => 'সাপোর্ট লাগলে কীভাবে যোগাযোগ করব?',
                'answer_en'    => 'Use our contact page or WhatsApp support for quick help. We are happy to answer product questions, delivery concerns, or order updates.',
                'answer_bn'    => 'কন্টাক্ট পেজ বা WhatsApp দিয়ে দ্রুত যোগাযোগ করতে পারেন। প্রোডাক্ট, ডেলিভারি, বা অর্ডার-সংক্রান্ত যেকোনো বিষয়ে আমরা সাহায্য করি।',
            ),
            array(
                'question_key' => 'julia_faq_general_2_question',
                'answer_key'   => 'julia_faq_general_2_answer',
                'question_en'  => 'Do you package items safely for gifting?',
                'question_bn'  => 'উপহার দেওয়ার জন্য প্যাকেজিং কি নিরাপদ?',
                'answer_en'    => 'Yes. We pack products carefully so they arrive clean, secure, and ready for gifting. We also try to use neat, eco-friendly packaging where possible.',
                'answer_bn'    => 'হ্যাঁ। প্রোডাক্টগুলো যত্ন করে প্যাক করা হয় যাতে সেগুলো পরিষ্কার, সুরক্ষিত, এবং গিফট করার জন্য প্রস্তুত থাকে।',
            ),
            array(
                'question_key' => 'julia_faq_general_3_question',
                'answer_key'   => 'julia_faq_general_3_answer',
                'question_en'  => 'Do you restock popular items?',
                'question_bn'  => 'জনপ্রিয় পণ্য কি আবার স্টক হয়?',
                'answer_en'    => 'Popular products are restocked whenever possible. If you love something that is out of stock, check back soon or contact us for an update.',
                'answer_bn'    => 'সুযোগ থাকলে জনপ্রিয় পণ্য আবার স্টক করা হয়। কোনো পণ্য আউট অব স্টক হলে কিছুদিন পর আবার দেখে নিতে পারেন বা আমাদের জানাতে পারেন।',
            ),
            array(
                'question_key' => 'julia_faq_general_4_question',
                'answer_key'   => 'julia_faq_general_4_answer',
                'question_en'  => 'Can I order gifts for birthdays or special occasions?',
                'question_bn'  => 'জন্মদিন বা স্পেশাল ইভেন্টের জন্য অর্ডার করা যাবে?',
                'answer_en'    => 'Yes. Julia\'s Cartoonery is built for memorable gifting. You can shop toys and character-inspired goodies for birthdays, celebrations, and surprise deliveries.',
                'answer_bn'    => 'অবশ্যই। Julia\'s Cartoonery জন্মদিন, উদযাপন, আর সারপ্রাইজ ডেলিভারির জন্য উপযুক্ত গিফট আইটেম দেয়।',
            ),
        ),
    );
}

function julias_cartoonery_get_faq_sections( $lang = 'en' ) {
    $sections = array();
    $lang_key = 'question_' . $lang;
    $answer_lang_key = 'answer_' . $lang;

    foreach ( julias_cartoonery_get_faq_defaults() as $section_label => $items ) {
        $section_items = array();

        foreach ( $items as $item ) {
            $question = get_theme_mod( $item['question_key'], $item[ $lang_key ] );
            $answer = get_theme_mod( $item['answer_key'], $item[ $answer_lang_key ] );

            if ( '' === trim( (string) $question ) && '' === trim( (string) $answer ) ) {
                continue;
            }

            $section_items[] = array(
                'question' => $question,
                'answer'   => $answer,
            );
        }

        if ( ! empty( $section_items ) ) {
            $sections[ $section_label ] = $section_items;
        }
    }

    return $sections;
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
            'title' => 'FAQ',
            'slug' => 'faq',
            'template' => 'page-faq.php'
        ],
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
        $page_post = get_page_by_path( $page['slug'] );

        if ( ! $page_post ) {
            $page_post = wp_insert_post( array(
                'post_title'     => $page['title'],
                'post_name'      => $page['slug'],
                'post_status'    => 'publish',
                'post_type'      => 'page',
            ) );
        } else {
            // Ensure it's always published
            if ( $page_post && get_post_status( $page_post->ID ) !== 'publish' ) {
                wp_update_post( array(
                    'ID'          => $page_post->ID,
                    'post_status' => 'publish'
                ) );
            }

            if ( $page_post && ! is_wp_error( $page_post ) ) {
                update_post_meta( $page_post->ID, '_wp_page_template', $page['template'] );
            }
        }

        if ( is_numeric( $page_post ) && ! is_wp_error( $page_post ) ) {
            update_post_meta( (int) $page_post, '_wp_page_template', $page['template'] );
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

    // ===== FAQ Page Settings =====
    $wp_customize->add_section(
        'julia_faq_page',
        array(
            'title'       => __( 'FAQ Page', 'julias-cartoonery' ),
            'description' => __( 'Manage FAQ content directly from the dashboard', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 70,
        )
    );

    $wp_customize->add_setting( 'julia_faq_eyebrow', array(
        'default'           => __( 'Cash on Delivery, fast shipping, and easy returns', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_eyebrow', array(
        'label'   => __( 'Hero Eyebrow', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_title', array(
        'default'           => __( 'Frequently Asked Questions', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_title', array(
        'label'   => __( 'Hero Title', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_description', array(
        'default'           => __( 'Find quick answers about delivery, payments, COD, and returns. Everything here is designed to reduce hesitation and help shoppers complete checkout with confidence.', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_description', array(
        'label'   => __( 'Hero Description', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'julia_faq_inside_dhaka', array(
        'default'           => __( '24-48 hours', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_inside_dhaka', array(
        'label'   => __( 'Inside Dhaka Stat', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_outside_dhaka', array(
        'default'           => __( '3-5 business days', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_outside_dhaka', array(
        'label'   => __( 'Outside Dhaka Stat', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_payment', array(
        'default'           => __( 'COD available', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_payment', array(
        'label'   => __( 'Payment Stat', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_trust_title', array(
        'default'           => __( 'Why shoppers feel safe ordering here', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_trust_title', array(
        'label'   => __( 'Trust Section Title', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_trust_description', array(
        'default'           => __( 'Clear delivery windows, simple returns, and COD support help reduce friction for Bangladeshi shoppers who want confidence before they click buy.', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_trust_description', array(
        'label'   => __( 'Trust Section Description', 'julias-cartoonery' ),
        'section' => 'julia_faq_page',
        'type'    => 'textarea',
    ) );

    foreach ( julias_cartoonery_get_faq_defaults() as $section_label => $items ) {
        foreach ( $items as $index => $item ) {
            $question_label = sprintf( '%s - Question %d', $section_label, $index + 1 );
            $answer_label = sprintf( '%s - Answer %d', $section_label, $index + 1 );

            $wp_customize->add_setting( $item['question_key'], array(
                'default'           => $item['question'],
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( $item['question_key'], array(
                'label'   => $question_label,
                'section' => 'julia_faq_page',
                'type'    => 'text',
            ) );

            $wp_customize->add_setting( $item['answer_key'], array(
                'default'           => $item['answer'],
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( $item['answer_key'], array(
                'label'   => $answer_label,
                'section' => 'julia_faq_page',
                'type'    => 'textarea',
            ) );
        }
    }

    $wp_customize->add_section(
        'julia_faq_page_bn',
        array(
            'title'       => __( 'FAQ Page - Bangla', 'julias-cartoonery' ),
            'description' => __( 'Manage the Bangla FAQ content directly from the dashboard', 'julias-cartoonery' ),
            'panel'       => 'julia_home_page',
            'priority'    => 71,
        )
    );

    $wp_customize->add_setting( 'julia_faq_bn_eyebrow', array(
        'default'           => __( 'বাংলা ভার্সন', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_bn_eyebrow', array(
        'label'   => __( 'Hero Eyebrow', 'julias-cartoonery' ),
        'section' => 'julia_faq_page_bn',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_bn_title', array(
        'default'           => __( 'প্রশ্নোত্তর', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_bn_title', array(
        'label'   => __( 'Hero Title', 'julias-cartoonery' ),
        'section' => 'julia_faq_page_bn',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'julia_faq_bn_description', array(
        'default'           => __( 'বাংলায় দ্রুত উত্তর, যাতে আপনার ক্রেতারা আরও সহজে অর্ডার করতে পারেন এবং আস্থা পান।', 'julias-cartoonery' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'julia_faq_bn_description', array(
        'label'   => __( 'Hero Description', 'julias-cartoonery' ),
        'section' => 'julia_faq_page_bn',
        'type'    => 'textarea',
    ) );

    foreach ( julias_cartoonery_get_faq_defaults_bn() as $section_label => $items ) {
        foreach ( $items as $index => $item ) {
            $question_label = sprintf( '%s - প্রশ্ন %d', $section_label, $index + 1 );
            $answer_label = sprintf( '%s - উত্তর %d', $section_label, $index + 1 );

            $wp_customize->add_setting( $item['question_key'], array(
                'default'           => $item['question'],
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( $item['question_key'], array(
                'label'   => $question_label,
                'section' => 'julia_faq_page_bn',
                'type'    => 'text',
            ) );

            $wp_customize->add_setting( $item['answer_key'], array(
                'default'           => $item['answer'],
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'refresh',
            ) );
            $wp_customize->add_control( $item['answer_key'], array(
                'label'   => $answer_label,
                'section' => 'julia_faq_page_bn',
                'type'    => 'textarea',
            ) );
        }
    }
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

    $message_post_id = wp_insert_post( array(
        'post_type'    => 'contact_message',
        'post_status'  => 'publish',
        'post_title'   => $name,
        'post_content' => $message,
        'post_excerpt' => $phone,
    ) );

    if ( ! is_wp_error( $message_post_id ) && $message_post_id ) {
        update_post_meta( $message_post_id, 'contact_phone', $phone );
        update_post_meta( $message_post_id, 'contact_status', 'new' );
        update_post_meta( $message_post_id, 'contact_source', 'website_form' );
    }

    wp_mail( $to, $subject, $body, $headers );

    wp_safe_redirect( add_query_arg( 'contact', 'sent', home_url( '/contact/' ) ) );
    exit;
}
add_action( 'admin_post_nopriv_julias_contact_submit', 'julias_cartoonery_handle_contact_form' );
add_action( 'admin_post_julias_contact_submit', 'julias_cartoonery_handle_contact_form' );