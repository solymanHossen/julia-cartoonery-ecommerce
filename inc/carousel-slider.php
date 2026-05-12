<?php
/**
 * Hero Carousel Slider Management
 * Modern admin interface for managing carousel slides
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Carousel Slide Post Type
 */
function julias_register_carousel_post_type() {
    $args = [
        'label'               => __('Carousel Slides', 'julias-cartoonery'),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'show_in_rest'        => true,
        'rest_base'           => 'carousel-slides',
        'capability_type'     => 'post',
        'capabilities'        => [
            'create_posts'  => 'manage_options',
            'edit_posts'    => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'delete_posts'  => 'manage_options',
        ],
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-images-alt',
        'supports'            => ['title', 'editor', 'thumbnail'],
        'taxonomies'          => [],
    ];

    register_post_type('carousel_slide', $args);
}
add_action('init', 'julias_register_carousel_post_type');

/**
 * Register Meta Fields for Carousel Slides
 */
function julias_register_carousel_meta() {
    $meta_fields = [
        'badge',
        'description',
        'background_color',
        'blob_1_color',
        'blob_2_color',
        'slide_order',
    ];

    foreach ($meta_fields as $field) {
        register_meta('post', "carousel_{$field}", [
            'object_subtype'    => 'carousel_slide',
            'type'              => 'string',
            'description'       => ucfirst(str_replace('_', ' ', $field)),
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('manage_options');
            },
            'show_in_rest'      => true,
        ]);
    }
}
add_action('init', 'julias_register_carousel_meta');

/**
 * Add Custom Metabox for Carousel Slides
 */
function julias_add_carousel_metabox() {
    add_meta_box(
        'carousel_slide_meta',
        __('Slide Settings', 'julias-cartoonery'),
        'julias_carousel_metabox_callback',
        'carousel_slide',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'julias_add_carousel_metabox');

/**
 * Carousel Metabox HTML Callback
 */
function julias_carousel_metabox_callback($post) {
    wp_nonce_field('julias_carousel_nonce', 'julias_carousel_nonce');

    $badge = get_post_meta($post->ID, 'carousel_badge', true);
    $description = get_post_meta($post->ID, 'carousel_description', true);
    $bg_color = get_post_meta($post->ID, 'carousel_background_color', true) ?: 'from-pink-100/50';
    $blob_1 = get_post_meta($post->ID, 'carousel_blob_1_color', true) ?: 'bg-pink-300';
    $blob_2 = get_post_meta($post->ID, 'carousel_blob_2_color', true) ?: 'bg-purple-300';
    $order = get_post_meta($post->ID, 'carousel_slide_order', true) ?: 0;

    $bg_presets = [
        'from-pink-100/50'   => 'Pink',
        'from-blue-100/50'   => 'Blue',
        'from-purple-100/50' => 'Purple',
        'from-yellow-100/50' => 'Yellow',
        'from-green-100/50'  => 'Green',
    ];

    $color_presets = [
        'bg-pink-300'   => 'Pink',
        'bg-purple-300' => 'Purple',
        'bg-blue-300'   => 'Blue',
        'bg-sky-300'    => 'Sky',
        'bg-yellow-300' => 'Yellow',
        'bg-green-300'  => 'Green',
    ];
    ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Badge Field -->
        <div>
            <label for="carousel_badge" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Badge Label', 'julias-cartoonery'); ?>
            </label>
            <input
                type="text"
                id="carousel_badge"
                name="carousel_badge"
                value="<?php echo esc_attr($badge); ?>"
                placeholder="e.g., New Collection, Best Sellers"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
            />
        </div>

        <!-- Slide Order Field -->
        <div>
            <label for="carousel_slide_order" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Display Order', 'julias-cartoonery'); ?>
            </label>
            <input
                type="number"
                id="carousel_slide_order"
                name="carousel_slide_order"
                value="<?php echo esc_attr($order); ?>"
                min="0"
                step="1"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
            />
        </div>

        <!-- Description Field -->
        <div style="grid-column: 1 / -1;">
            <label for="carousel_description" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Description', 'julias-cartoonery'); ?>
            </label>
            <textarea
                id="carousel_description"
                name="carousel_description"
                rows="3"
                placeholder="Slide description text"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;"
            ><?php echo esc_textarea($description); ?></textarea>
        </div>

        <!-- Background Color -->
        <div>
            <label for="carousel_background_color" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Background Color', 'julias-cartoonery'); ?>
            </label>
            <select
                id="carousel_background_color"
                name="carousel_background_color"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
            >
                <?php foreach ($bg_presets as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($bg_color, $value); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Blob Color 1 -->
        <div>
            <label for="carousel_blob_1_color" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Accent Color 1', 'julias-cartoonery'); ?>
            </label>
            <select
                id="carousel_blob_1_color"
                name="carousel_blob_1_color"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
            >
                <?php foreach ($color_presets as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($blob_1, $value); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Blob Color 2 -->
        <div>
            <label for="carousel_blob_2_color" style="display: block; margin-bottom: 5px; font-weight: bold;">
                <?php esc_html_e('Accent Color 2', 'julias-cartoonery'); ?>
            </label>
            <select
                id="carousel_blob_2_color"
                name="carousel_blob_2_color"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
            >
                <?php foreach ($color_presets as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($blob_2, $value); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <p style="margin-top: 15px; color: #666; font-size: 13px;">
        <?php esc_html_e('Use the featured image uploader below to set the slide background image.', 'julias-cartoonery'); ?>
    </p>
    <?php
}

/**
 * Save Carousel Meta Data
 */
function julias_save_carousel_meta($post_id) {
    if (!isset($_POST['julias_carousel_nonce']) || !wp_verify_nonce($_POST['julias_carousel_nonce'], 'julias_carousel_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    $meta_fields = ['badge', 'description', 'background_color', 'blob_1_color', 'blob_2_color', 'slide_order'];

    foreach ($meta_fields as $field) {
        $meta_key = "carousel_{$field}";
        if (isset($_POST[$meta_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$meta_key]));
        }
    }
}
add_action('save_post_carousel_slide', 'julias_save_carousel_meta');

/**
 * Get Carousel Slides for Frontend
 * 
 * @return array Array of carousel slides
 */
function julias_get_carousel_slides() {
    $args = [
        'post_type'      => 'carousel_slide',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'carousel_slide_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ];

    $slides_query = new WP_Query($args);
    $slides = [];

    if ($slides_query->have_posts()) {
        while ($slides_query->have_posts()) {
            $slides_query->the_post();
            $slides[] = [
                'id'       => get_the_ID(),
                'badge'    => get_post_meta(get_the_ID(), 'carousel_badge', true),
                'title'    => get_the_title(),
                'desc'     => get_post_meta(get_the_ID(), 'carousel_description', true),
                'img'      => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : get_template_directory_uri() . '/assets/img/placeholder.jpg',
                'bgClass'  => get_post_meta(get_the_ID(), 'carousel_background_color', true) ?: 'from-pink-100/50',
                'blob1'    => get_post_meta(get_the_ID(), 'carousel_blob_1_color', true) ?: 'bg-pink-300',
                'blob2'    => get_post_meta(get_the_ID(), 'carousel_blob_2_color', true) ?: 'bg-purple-300',
            ];
        }
        wp_reset_postdata();
    }

    return apply_filters('julias_hero_slides', $slides);
}

/**
 * REST API Support - Register fields
 */
function julias_register_carousel_rest_fields() {
    register_rest_field('carousel_slide', 'carousel_meta', [
        'get_callback' => function ($post) {
            return [
                'badge'              => get_post_meta($post['id'], 'carousel_badge', true),
                'description'        => get_post_meta($post['id'], 'carousel_description', true),
                'background_color'   => get_post_meta($post['id'], 'carousel_background_color', true),
                'blob_1_color'       => get_post_meta($post['id'], 'carousel_blob_1_color', true),
                'blob_2_color'       => get_post_meta($post['id'], 'carousel_blob_2_color', true),
                'slide_order'        => get_post_meta($post['id'], 'carousel_slide_order', true),
            ];
        },
        'update_callback' => function ($value, $post, $field_name) {
            foreach ($value as $key => $val) {
                update_post_meta($post->ID, "carousel_{$key}", $val);
            }
        },
        'schema' => null,
    ]);

    register_rest_field('carousel_slide', 'featured_image_url', [
        'get_callback' => function ($post) {
            if (has_post_thumbnail($post['id'])) {
                return get_the_post_thumbnail_url($post['id'], 'full');
            }
            return get_template_directory_uri() . '/assets/img/placeholder.jpg';
        },
        'schema' => null,
    ]);
}
add_action('rest_api_init', 'julias_register_carousel_rest_fields');
