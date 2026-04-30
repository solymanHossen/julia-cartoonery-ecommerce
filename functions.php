<?php

function jc_setup_theme() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'julias-cartoonery' ),
		)
	);
}
add_action( 'after_setup_theme', 'jc_setup_theme' );

function jc_enqueue_assets() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'jc-theme-style', get_stylesheet_uri(), array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'jc-app', get_theme_file_uri( 'assets/css/app.css' ), array( 'jc-theme-style' ), $theme->get( 'Version' ) );
	wp_enqueue_script( 'jc-app', get_theme_file_uri( 'assets/js/app.js' ), array(), $theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'jc_enqueue_assets' );

function jc_theme_bootstrap_script() {
	?>
	<script>
		(function () {
			try {
				var storedTheme = localStorage.getItem('jc-theme');
				var systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				var theme = storedTheme === 'light' || storedTheme === 'dark' ? storedTheme : (systemDark ? 'dark' : 'light');
				document.documentElement.classList.toggle('dark', theme === 'dark');
				document.documentElement.style.colorScheme = theme;
			} catch (error) {}
		})();
	</script>
	<?php
}
add_action( 'wp_head', 'jc_theme_bootstrap_script', 1 );
