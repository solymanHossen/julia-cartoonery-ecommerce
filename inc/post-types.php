<?php

function julias_cartoonery_register_post_types() {

    // ==========================================
    // 1. Stories Post Type (SEO Optimized)
    // ==========================================
    $story_labels = array(
        'name'                  => __( 'Stories', 'julia-cartoonery' ),
        'singular_name'         => __( 'Story', 'julia-cartoonery' ),
        'menu_name'             => __( 'Stories', 'julia-cartoonery' ),
        'add_new'               => __( 'Add New Story', 'julia-cartoonery' ),
        'add_new_item'          => __( 'Add New Story', 'julia-cartoonery' ),
        'edit_item'             => __( 'Edit Story', 'julia-cartoonery' ),
        'new_item'              => __( 'New Story', 'julia-cartoonery' ),
        'view_item'             => __( 'View Story', 'julia-cartoonery' ),
        'all_items'             => __( 'All Stories', 'julia-cartoonery' ),
        'search_items'          => __( 'Search Stories', 'julia-cartoonery' ),
        'not_found'             => __( 'No stories found.', 'julia-cartoonery' ),
        'not_found_in_trash'    => __( 'No stories found in Trash.', 'julia-cartoonery' )
    );

    $story_args = array(
        'labels'              => $story_labels,
        'public'              => true,
        'publicly_queryable'  => true, // ফ্রন্টএন্ডে শো করার জন্য
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'has_archive'         => true,
        'hierarchical'        => false, // ট্রু দিলে পেইজের মতো কাজ করবে, ফলস দিলে পোস্টের মতো
        'menu_position'       => 5, // ড্যাশবোর্ডে পোস্টের ঠিক নিচেই দেখাবে
        'menu_icon'           => 'dashicons-book-alt',
        'exclude_from_search' => false, // SEO এর জন্য ট্রু করা যাবে না, ফলস রাখতে হবে যাতে সার্চে আসে
        'show_in_rest'        => true, // Gutenberg/REST API সাপোর্ট
        // URL ক্লিন রাখার জন্য with_front => false দেওয়া হলো
        'rewrite'             => array( 'slug' => 'stories', 'with_front' => false ), 
        // এসইও এর জন্য author, comments এবং revisions যুক্ত করা হলো
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions' ),
        // ক্যাটাগরি এবং ট্যাগ সাপোর্ট (SEO Silo স্ট্রাকচারের জন্য খুবই জরুরি)
        'taxonomies'          => array( 'category', 'post_tag' ), 
    );
    register_post_type( 'stories', $story_args );


    // ==========================================
    // 2. Characters Post Type (SEO Optimized)
    // ==========================================
    $character_labels = array(
        'name'                  => __( 'Characters', 'julia-cartoonery' ),
        'singular_name'         => __( 'Character', 'julia-cartoonery' ),
        'menu_name'             => __( 'Characters', 'julia-cartoonery' ),
        'add_new'               => __( 'Add Character', 'julia-cartoonery' ),
        'add_new_item'          => __( 'Add New Character', 'julia-cartoonery' ),
        'edit_item'             => __( 'Edit Character', 'julia-cartoonery' ),
        'new_item'              => __( 'New Character', 'julia-cartoonery' ),
        'view_item'             => __( 'View Character', 'julia-cartoonery' ),
        'all_items'             => __( 'All Characters', 'julia-cartoonery' ),
        'search_items'          => __( 'Search Characters', 'julia-cartoonery' ),
        'not_found'             => __( 'No characters found.', 'julia-cartoonery' ),
    );

    $character_args = array(
        'labels'              => $character_labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 6, 
        'menu_icon'           => 'dashicons-admin-users',
        'exclude_from_search' => false,
        'show_in_rest'        => true,
        'rewrite'             => array( 'slug' => 'characters', 'with_front' => false ),
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
        // ক্যারেক্টারগুলোকে গ্রুপ করার জন্য ক্যাটাগরি যুক্ত করা হলো
        'taxonomies'          => array( 'category' ), 
    );
    register_post_type( 'characters', $character_args );

    $blog_post_labels = array(
        'name'                  => __( 'Blog Posts', 'julia-cartoonery' ),
        'singular_name'         => __( 'Blog Post', 'julia-cartoonery' ),
        'menu_name'             => __( 'Blog Posts', 'julia-cartoonery' ),
        'add_new'               => __( 'Add New Blog Post', 'julia-cartoonery' ),
        'add_new_item'          => __( 'Add New Blog Post', 'julia-cartoonery' ),
        'edit_item'             => __( 'Edit Blog Post', 'julia-cartoonery' ),
        'new_item'              => __( 'New Blog Post', 'julia-cartoonery' ),
        'view_item'             => __( 'View Blog Post', 'julia-cartoonery' ),
        'all_items'             => __( 'All Blog Posts', 'julia-cartoonery' ),
        'search_items'          => __( 'Search Blog Posts', 'julia-cartoonery' ),
        'not_found'             => __( 'No blog posts found.', 'julia-cartoonery' ),
    );
    $blog_post_args = array(
        'labels'              => $blog_post_labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 7, 
        'menu_icon'           => 'dashicons-welcome-write-blog',
        'exclude_from_search' => false,
        'show_in_rest'        => true,
        'rewrite'             => array( 'slug' => 'blog', 'with_front' => false ),
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions' ),
        // ব্লগ পোস্টগুলোকে ক্যাটাগরি এবং ট্যাগ দিয়ে গ্রুপ করার জন্য
        'taxonomies'          => array( 'category', 'post_tag' ), 
    );
    register_post_type( 'blog_posts', $blog_post_args );

    // ==========================================
    // 4. Contact Messages (Admin Inbox)
    // ==========================================
    $contact_labels = array(
        'name'               => __( 'Contact Messages', 'julia-cartoonery' ),
        'singular_name'      => __( 'Contact Message', 'julia-cartoonery' ),
        'menu_name'          => __( 'Messages', 'julia-cartoonery' ),
        'add_new'            => __( 'Add New', 'julia-cartoonery' ),
        'add_new_item'       => __( 'Add New Message', 'julia-cartoonery' ),
        'edit_item'          => __( 'View Message', 'julia-cartoonery' ),
        'new_item'           => __( 'New Message', 'julia-cartoonery' ),
        'view_item'          => __( 'View Message', 'julia-cartoonery' ),
        'all_items'          => __( 'All Messages', 'julia-cartoonery' ),
        'search_items'       => __( 'Search Messages', 'julia-cartoonery' ),
        'not_found'          => __( 'No messages found.', 'julia-cartoonery' ),
        'not_found_in_trash'  => __( 'No messages found in Trash.', 'julia-cartoonery' ),
    );

    $contact_args = array(
        'labels'              => $contact_labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => false,
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-email-alt2',
        'exclude_from_search' => true,
        'show_in_rest'        => false,
        'supports'            => array( 'title', 'editor', 'custom-fields' ),
    );
    register_post_type( 'contact_message', $contact_args );

}
add_action( 'init', 'julias_cartoonery_register_post_types' );

function julias_cartoonery_contact_message_columns( $columns ) {
    $new_columns = array();

    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __( 'Name', 'julia-cartoonery' );
    $new_columns['contact_phone'] = __( 'Phone', 'julia-cartoonery' );
    $new_columns['contact_status'] = __( 'Status', 'julia-cartoonery' );
    $new_columns['date'] = __( 'Received', 'julia-cartoonery' );

    return $new_columns;
}
add_filter( 'manage_contact_message_posts_columns', 'julias_cartoonery_contact_message_columns' );

function julias_cartoonery_contact_message_column_content( $column, $post_id ) {
    if ( 'contact_phone' === $column ) {
        echo esc_html( get_post_meta( $post_id, 'contact_phone', true ) );
        return;
    }

    if ( 'contact_status' === $column ) {
        $status = get_post_meta( $post_id, 'contact_status', true );
        $label = 'new' === $status ? __( 'New', 'julia-cartoonery' ) : __( 'Read', 'julia-cartoonery' );
        echo esc_html( $label );
        return;
    }
}
add_action( 'manage_contact_message_posts_custom_column', 'julias_cartoonery_contact_message_column_content', 10, 2 );

function julias_cartoonery_contact_message_sortable_columns( $columns ) {
    $columns['contact_status'] = 'contact_status';
    return $columns;
}
add_filter( 'manage_edit-contact_message_sortable_columns', 'julias_cartoonery_contact_message_sortable_columns' );