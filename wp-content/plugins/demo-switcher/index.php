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

function ds_scripts(){

}

add_action( 'wp_enqueue_scripts', 'ds_scripts' , 99999999 );