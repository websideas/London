<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


$composer_addons = array(
    //'list.php',
    'contact-info.php',
    'clients-carousel.php',
    'mailchimp.php',
    'recent-posts-carousel.php',
    'woocommerce-sales-countdown.php',
    'desinger-collection-carousel.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}