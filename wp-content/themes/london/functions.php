<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Script version, used to add version for scripts and styles
define( 'THEME_VER', '1.0' );

define( 'THEME_DIR', trailingslashit(get_template_directory()));
define( 'THEME_URL', trailingslashit(get_template_directory_uri()));
define( 'THEME_LANG', 'london');

define( 'THEME_FONTS', trailingslashit( THEME_URL . 'assets/fonts' ) );
define( 'THEME_JS', trailingslashit( THEME_URL . 'assets/js' ) );
define( 'THEME_CSS', trailingslashit( THEME_URL . 'assets/css' ) );

define( 'ADMIN_ASSETS', THEME_URL.'/admin/assets/');




/**
 * Include core functions.
 *
 * @since 1.0
 */
require_once THEME_DIR . 'inc/functions.php';


/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require_once THEME_DIR . '/inc/template-tags.php';








/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since London 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}


/**
 * Initialising Visual Composer
 * 
 */

if ( ! class_exists( 'Vc_Manager', false ) ) {

	require_once THEME_DIR.'/wpbakery/js_composer/js_composer.php';
    
	if ( function_exists( 'vc_set_as_theme' ) ) {
		vc_set_as_theme(true);
	}

	if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
		vc_set_default_editor_post_types( array( 'page', 'post', 'portfolio' ) );
	}
}


if ( class_exists( 'Vc_Manager', false ) ) {
    
    if ( ! function_exists( 'js_composer_bridge_admin' ) ) {
		function js_composer_bridge_admin( $hook ) {
			wp_enqueue_style( 'js_composer_bridge', ADMIN_ASSETS . 'css/js_composer_bridge.css' );
		}
	}
    add_action( 'admin_enqueue_scripts', 'js_composer_bridge_admin', 15 );
    
    if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
		vc_set_shortcodes_templates_dir( THEME_DIR . '/inc/js_composer/vc_templates' );
	}
    
    add_action( 'init', 'themedev_js_composer_bridge', 20 );
    if ( !function_exists('themedev_js_composer_bridge') ) {
		function themedev_js_composer_bridge() {
			require_once(THEME_DIR . '/inc/js_composer/js_composer_bridge.php');
		}
	}
    
}



