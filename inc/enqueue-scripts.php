<?php
/**
 * Asset Enqueueing System
 * 
 * This system implements a robust Vite manifest-based asset loader for cache busting.
 * It reads the manifest once per request and provides graceful fallbacks for dev environments.
 *
 * @package JuliasCartoonery
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Julias_Asset_Loader {
    /**
     * Store manifest content locally to prevent repeated file reads.
     *
     * @var array|null
     */
    private static $manifest = null;

    /**
     * Loads and decodes the Vite manifest.json file.
     *
     * @return array
     */
    private static function get_manifest() {
        if ( self::$manifest !== null ) {
            return self::$manifest;
        }

        // Vite 5+ default path is .vite/manifest.json, but fallback to root assets for safety
        $paths = [
            get_theme_file_path( 'assets/.vite/manifest.json' ),
            get_theme_file_path( 'assets/manifest.json' ),
        ];

        foreach ( $paths as $path ) {
            if ( file_exists( $path ) ) {
                $content = file_get_contents( $path );
                self::$manifest = json_decode( $content, true );
                
                if ( is_array( self::$manifest ) ) {
                    return self::$manifest;
                }
            }
        }

        // If no manifest found, log error for admins and return empty array
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && current_user_can( 'manage_options' ) ) {
            error_log( 'Julia\'s Cartoonery: Vite manifest.json not found. Run "npm run build".' );
        }

        self::$manifest = [];
        return self::$manifest;
    }

    /**
     * Resolves a hashed asset path from the manifest.
     *
     * @param string $entry The source file path (e.g., 'src/js/app.js').
     * @return array|null Asset data or null if not found.
     */
    public static function get_asset( $entry ) {
        $manifest = self::get_manifest();
        return isset( $manifest[ $entry ] ) ? $manifest[ $entry ] : null;
    }

    /**
     * Enqueues theme assets.
     */
    public static function enqueue_assets() {
        $entry = 'src/js/app.js';
        $asset = self::get_asset( $entry );

        if ( $asset ) {
            // 1. Enqueue Hashed CSS
            if ( ! empty( $asset['css'] ) ) {
                foreach ( $asset['css'] as $index => $css_rel_path ) {
                    wp_enqueue_style(
                        $index === 0 ? 'main-style' : 'main-style-' . $index,
                        get_theme_file_uri( 'assets/' . $css_rel_path ),
                        [],
                        null
                    );
                }
            }

            // 2. Enqueue Hashed JS
            wp_enqueue_script(
                'app-js',
                get_theme_file_uri( 'assets/' . $asset['file'] ),
                [ 'jquery' ],
                null,
                true
            );
        } else {
            /**
             * Graceful Fallback
             * Useful for development mode or if the build is missing.
             */
            $version = wp_get_theme()->get( 'Version' );
            
            if ( file_exists( get_theme_file_path( 'assets/css/app.css' ) ) ) {
                wp_enqueue_style( 'main-style', get_theme_file_uri( 'assets/css/app.css' ), [], $version );
            }
            
            if ( file_exists( get_theme_file_path( 'assets/js/app.js' ) ) ) {
                wp_enqueue_script( 'app-js', get_theme_file_uri( 'assets/js/app.js' ), [ 'jquery' ], $version, true );
            }
        }
    }
}

// Initialize Asset Loader
add_action( 'wp_enqueue_scripts', [ 'Julias_Asset_Loader', 'enqueue_assets' ] );