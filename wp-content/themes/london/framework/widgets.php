<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/** 
 * Widget content
 * 
 */

if ( function_exists('register_sidebar')) {

	register_sidebar( array(
		'name' => __( 'Primary Widget Area', THEME_LANG),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', THEME_LANG),
		'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
    
    register_sidebar( array(
		'name' => __( 'Shop Widget Area', THEME_LANG),
		'id' => 'shop-widget-area',
		'description' => __( 'The shop widget area', THEME_LANG),
		'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
    
    
    $count = 4;
    
    for($i=1; $i<=$count;$i++){
        register_sidebar( array(
    		'name' => __( 'Sidebar '.$i, THEME_LANG),
    		'id' => 'sidebar-column-'.$i,
    		'description' => __( 'The sidebar column '.$i.' widget area', THEME_LANG),
    		'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
    		'after_widget' => '</section>',
    		'before_title' => '<h3 class="widget-title">',
    		'after_title' => '</h3>',
    	) );
    }
    
    register_sidebar( array(
		'name' => __( 'Footer top', THEME_LANG),
		'id' => 'footer-top',
		'description' => __( 'The footer top widget area', THEME_LANG),
		'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
    
    $count = 4;
    
    for($i=1; $i<=$count;$i++){
        register_sidebar( array(
    		'name' => __( 'Footer column '.$i, THEME_LANG),
    		'id' => 'footer-column-'.$i,
    		'description' => __( 'The footer column '.$i.' widget area', THEME_LANG),
    		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
    		'after_widget' => '</div>',
    		'before_title' => '<h3 class="widget-title">',
    		'after_title' => '</h3>',
    	) );
    }

}




