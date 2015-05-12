<?php

if ( !defined('ABSPATH')) exit;

function register_post_type_init() {
    $labels = array(
        'name' => __( 'Designer', THEME_LANG ),
        'singular_name' => __( 'Designer', THEME_LANG ),
        'add_new' => __( 'Add New', THEME_LANG ),
        'all_items' => __( 'Designers', THEME_LANG ),
        'add_new_item' => __( 'Add New designer', THEME_LANG ),
        'edit_item' => __( 'Edit designer', THEME_LANG ),
        'new_item' => __( 'New designer', THEME_LANG ),
        'view_item' => __( 'View designer', THEME_LANG ),
        'search_items' => __( 'Search designer', THEME_LANG ),
        'not_found' => __( 'No designer found', THEME_LANG),
        'not_found_in_trash' => __( 'No designer found in Trash', THEME_LANG ),
        'parent_item_colon' => __( 'Parent designer', THEME_LANG ),
        'menu_name' => __( 'Designers', THEME_LANG )
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

    register_post_type( 'designer', $args );

    $labels = array(
        'name' => __( 'Collection', THEME_LANG ),
        'singular_name' => __( 'Collection', THEME_LANG ),
        'add_new' => __( 'Add New', THEME_LANG ),
        'all_items' => __( 'Collections', THEME_LANG ),
        'add_new_item' => __( 'Add New Collection', THEME_LANG ),
        'edit_item' => __( 'Edit Collection', THEME_LANG ),
        'new_item' => __( 'New Collection', THEME_LANG ),
        'view_item' => __( 'View Collection', THEME_LANG ),
        'search_items' => __( 'Search Collection', THEME_LANG ),
        'not_found' => __( 'No Collections found', THEME_LANG ),
        'not_found_in_trash' => __( 'No Collection found in Trash', THEME_LANG ),
        'parent_item_colon' => __( 'Parent Collection', THEME_LANG ),
        'menu_name' => __( 'Collections', THEME_LANG )
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array( 'title', 'page-attributes'),
        'rewrite'            => false,
        'query_var'          => false,
        'publicly_queryable' => false,
        'public'             => true

    );
    register_post_type( 'collection', $args );

    /* Testimonials */
    $labels = array(
        'name' => __( 'Testimonial', THEME_LANG ),
        'singular_name' => __( 'Testimonial', THEME_LANG),
        'add_new' => __( 'Add New', THEME_LANG ),
        'all_items' => __( 'Testimonials', THEME_LANG ),
        'add_new_item' => __( 'Add New Testimonial', THEME_LANG ),
        'edit_item' => __( 'Edit Testimonial', THEME_LANG ),
        'new_item' => __( 'New Testimonial', THEME_LANG ),
        'view_item' => __( 'View Testimonial', THEME_LANG ),
        'search_items' => __( 'Search Testimonial', THEME_LANG ),
        'not_found' => __( 'No Testimonial found', THEME_LANG ),
        'not_found_in_trash' => __( 'No Testimonial found in Trash', THEME_LANG ),
        'parent_item_colon' => __( 'Parent Testimonial', THEME_LANG ),
        'menu_name' => __( 'Testimonials', THEME_LANG )
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array( 'title', 'thumbnail', 'editor' ),
        'rewrite'            => false,
        'query_var'          => false,
        'publicly_queryable' => false,
        'public'             => true

    );
    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'register_post_type_init' );