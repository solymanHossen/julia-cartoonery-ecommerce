<?php
/**
 * Julia's Cartoonery Search API
 * REST endpoint for modern search functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize search REST API
 */
function julias_register_search_rest_endpoint() {
    register_rest_route('julias/v1', '/search', array(
        'methods' => 'GET',
        'callback' => 'julias_handle_search_request',
        'permission_callback' => '__return_true',
        'args' => array(
            'q' => array(
                'type' => 'string',
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field'
            )
        )
    ));
}
add_action('rest_api_init', 'julias_register_search_rest_endpoint');

/**
 * Handle search REST API request
 */
function julias_handle_search_request($request) {
    $query = $request->get_param('q');
    
    if (empty($query) || strlen($query) < 2) {
        return new WP_REST_Response(array(
            'results' => array()
        ), 200);
    }

    $results = array();
    $search_args = array(
        's' => $query,
        'posts_per_page' => 12,
        'post_status' => 'publish'
    );

    // Search in products
    if (class_exists('WooCommerce')) {
        $products = new WP_Query(array_merge($search_args, array(
            'post_type' => 'product',
        )));

        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                $product = wc_get_product(get_the_ID());
                
                $results[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => wp_strip_all_tags(get_the_excerpt()),
                    'url' => get_the_permalink(),
                    'type' => 'product',
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
                );
            }
            wp_reset_postdata();
        }
    }

    // Search in characters (custom post type)
    $characters = new WP_Query(array_merge($search_args, array(
        'post_type' => 'characters',
    )));

    if ($characters->have_posts()) {
        while ($characters->have_posts()) {
            $characters->the_post();
            
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => wp_strip_all_tags(get_the_excerpt()),
                'url' => get_the_permalink(),
                'type' => 'character',
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            );
        }
        wp_reset_postdata();
    }

    // Search in stories (custom post type)
    $stories = new WP_Query(array_merge($search_args, array(
        'post_type' => 'stories',
    )));

    if ($stories->have_posts()) {
        while ($stories->have_posts()) {
            $stories->the_post();
            
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => wp_strip_all_tags(get_the_excerpt()),
                'url' => get_the_permalink(),
                'type' => 'story',
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            );
        }
        wp_reset_postdata();
    }

    // Search in blog posts
    $posts = new WP_Query(array_merge($search_args, array(
        'post_type' => 'blog_posts',
    )));

    if ($posts->have_posts()) {
        while ($posts->have_posts()) {
            $posts->the_post();
            
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => wp_strip_all_tags(get_the_excerpt()),
                'url' => get_the_permalink(),
                'type' => 'post',
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            );
        }
        wp_reset_postdata();
    }

    // Limit results to 12 total
    $results = array_slice($results, 0, 12);

    return new WP_REST_Response(array(
        'results' => $results
    ), 200);
}
