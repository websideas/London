<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


$composer_addons = array(
    //'list.php',
    'contact-info.php',
    'clients_carousel.php',
    'mailchimp.php',
    'recent_posts_carousel.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}