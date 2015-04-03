<?php

/**
 * All post type for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


function register_post_type_init() {
    $labels = array( 
        'name' => __( 'Designer', 'theme-dev-language'),
        'singular_name' => __( 'Designer', 'theme-dev-language'),
        'add_new' => __( 'Add New', 'theme-dev-language'),
        'all_items' => __( 'Designers', 'theme-dev-language'),
        'add_new_item' => __( 'Add New designer', 'theme-dev-language'),
        'edit_item' => __( 'Edit designer', 'theme-dev-language'),
        'new_item' => __( 'New designer', 'theme-dev-language'),
        'view_item' => __( 'View designer', 'theme-dev-language'),
        'search_items' => __( 'Search designer', 'theme-dev-language'),
        'not_found' => __( 'No designer found', 'theme-dev-language'),
        'not_found_in_trash' => __( 'No designer found in Trash', 'theme-dev-language'),
        'parent_item_colon' => __( 'Parent designer', 'theme-dev-language'),
        'menu_name' => __( 'Designers', 'theme-dev-language')
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array( 'title', 'thumbnail', 'page-attributes'),
        'rewrite'            => false,
        'query_var'          => false,
        'publicly_queryable' => false,
        'public'             => true
        
    );
    register_post_type( 'kt_designer', $args );
}
add_action( 'init', 'register_post_type_init' );