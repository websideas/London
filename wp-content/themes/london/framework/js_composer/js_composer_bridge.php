<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$attributes = array(    
    'type' => 'dropdown',    
    'heading' => __("Image effect", THEME_LANG),    
    'param_name' => 'effect',
    'value' => array( 
        __("None", THEME_LANG) => "",
        __("Creative", THEME_LANG) => "creative",
        __("Simple Fade", THEME_LANG) => "simple",
        __("Zoom in", THEME_LANG) => "zoomin", 
        __('Zoom out', THEME_LANG) => "zoomout",
        __('Mask Side to center', THEME_LANG) => "sidetocenter",
        
    ),
    'description' => __( "Image effect when hover", THEME_LANG),
    'dependency' => array(
		'element' => 'style',
		'is_empty' => true
	) 
); 
//  default 0 - unsorted and appended to bottom, 1 - appended to top);
vc_add_param( 'vc_single_image', $attributes );



$composer_addons = array(
    'categories_products.php',
    'contact_info.php',
    'clients_carousel.php',
    'blog_posts_carousel.php',
    'sales_countdown.php',
    'designer_collection_carousel.php',
    'category_products_tab.php',
    'categories_top_sellers.php',
    'blog_posts.php',
    'button.php',
    'widget_products_carousel.php',
    'widget_testimonials.php',
    'vc_gitem_post_metadata.php',
    'designer_products.php'
);

foreach ( $composer_addons as $addon ) {
	require_once( FW_DIR . 'js_composer/vc_addons/' . $addon );
}