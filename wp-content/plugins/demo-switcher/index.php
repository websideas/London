<?php
/**
 * Plugin Name: Demo switcher
 * Plugin URI:
 * Description: London demo switcher
 * Version: 1
 * Author: WooThemes
 * Author URI: http://woothemes.com
 * Requires at least: 4.0
 * Tested up to: 4.2
 *
 * Text Domain: woocommerce
 * Domain Path: /i18n/languages/
 *
 * @package WooCommerce
 * @category Core
 * @author WooThemes
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define('DSW_URL', untrailingslashit(  plugins_url( '/', __FILE__ ) ));
define('DSW_DIR', untrailingslashit( plugin_dir_path(__FILE__ ) )  );

function dsw_scripts(){
    wp_enqueue_script( 'london-script', DSW_URL . 'demo-switcher.js', array( 'jquery'), null, true );
}

add_action( 'wp_enqueue_scripts', 'dsw_scripts' , 99999999 );