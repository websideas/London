<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Add stylesheet and script for admin
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'admin_enqueue_scripts', 'admin_custom_style' );
if ( !function_exists( 'admin_custom_style' ) ) {
    function admin_custom_style(){
        
        wp_register_style( 'font-awesome', THEME_FONTS.'font-awesome/css/font-awesome.min.css');
        wp_register_style( 'elegant_font', THEME_FONTS.'elegant_font/style.css');
        wp_register_style( 'framework-core', FW_CSS.'framework-core.css');
        wp_register_style( 'chosen-style', FW_LIBS.'chosen/chosen.min.css');
        
        
        wp_register_style( 'admin-style', FW_CSS.'theme-admin.css',array( 'elegant_font', 'font-awesome', 'framework-core'));
        wp_enqueue_style('admin-style');
        
        wp_register_script( 'framework-core', FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), FW_VER, true);
        wp_enqueue_script('framework-core');

    } // End admin_custom_style.
}


/**
 * Add stylesheet and script for frontend
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_frontend' );
if ( !function_exists( 'wp_enqueue_scripts_frontend' ) ) {
    function wp_enqueue_scripts_frontend(){
        
        

    } // End admin_custom_style.
}