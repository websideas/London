<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


$composer_addons = array(
    'categories_products.php',
    'contact-info.php',
    'clients-carousel.php',
    'mailchimp.php',
    'recent-posts-carousel.php',
    'sales-countdown.php',
    'designer-collection-carousel.php',
    'category_products_tab.php',
    'categories_top_sellers.php',
    'blog-posts.php',
    'button.php',
    'widget_products_carousel.php',
    'widget_testimonials.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}