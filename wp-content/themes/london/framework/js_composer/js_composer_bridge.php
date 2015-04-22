<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


$composer_addons = array(
    'categories_products.php',
    'contact_info.php',
    'clients_carousel.php',
    'mailchimp.php',
    'recent_posts_carousel.php',
    'sales_countdown.php',
    'designer_collection_carousel.php',
    'category_products_tab.php',
    'categories_top_sellers.php',
    'blog_posts.php',
    'button.php',
    'widget_products_carousel.php',
    'widget_testimonials.php',
    'vc_gitem_post_metadata.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}