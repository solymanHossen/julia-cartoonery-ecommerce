<?php

function julias_cartoonery_register_post_types() {
    register_post_type(
        'stories',
        array(
            'labels'       => array(
                'name'          => __( 'Stories', 'julias-cartoonery' ),
                'singular_name' => __( 'Story', 'julias-cartoonery' ),
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-book-alt',
            'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'show_in_rest' => true,
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