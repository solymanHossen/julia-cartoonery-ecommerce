<?php
function julias_cartoonery_scripts() {
    $theme = wp_get_theme();

    wp_enqueue_style( 'main-style', get_theme_file_uri( 'assets/css/app.css' ), array(), $theme->get( 'Version' ) );
    wp_enqueue_script( 'app-js', get_theme_file_uri( 'assets/js/app.js' ), array(), $theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'julias_cartoonery_scripts' );