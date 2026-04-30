<?php

function julias_cartoonery_register_post_types() {
    register_post_type(
        'stories',
        array(
            'labels'       => array(
                'name'          => 'Stories',
            'singular_name' => 'Story',
            'add_new'       => 'Add New Story',
            'add_new_item'  => 'Add New Story',
            'edit_item'     => 'Edit Story',
            'all_items'     => 'All Stories'
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-book-alt',
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest' => true,
            'rewrite'     => array('slug' => 'stories'),
        )
    );

    register_post_type(
        'characters',
        array(
            'labels'       => array(
                'name'          => __( 'Characters', 'julias-cartoonery' ),
                'singular_name' => __( 'Character', 'julias-cartoonery' ),
            ),
            'public'       => true,
            'menu_icon'    => 'dashicons-admin-users',
            'supports'     => array( 'title', 'thumbnail' ),
            'show_in_rest' => true,
        )
    );
}
add_action( 'init', 'julias_cartoonery_register_post_types' );