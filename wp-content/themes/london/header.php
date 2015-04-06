<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Dosis:400,200,300,500,600,700' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
    <?php do_action( 'theme_head_bottom' ); ?>
</head>

<body <?php body_class(); ?>>
    <?php $position = themedev_getHeader(); ?>
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_body_top' ); ?>
    <div id="page">
        <?php 
            if($position == 'below'){
                /**
            	 * @hooked theme_slideshows_position_callback 10
            	 */
            	do_action( 'theme_slideshows_position' );
            } 
        ?>
        
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_header' ); ?>
        <?php $header_layout = themedev_getHeaderLayout(); ?>
        <div class="header-<?php echo $header_layout ?> <?php echo apply_filters('theme_header_class', 'header-container', $position) ?>">
            <header id="header" class="<?php echo apply_filters('theme_header_content_class', 'header-content') ?>">
                <?php get_template_part( 'layouts/headers/header',  $header_layout); ?>
            </header><!-- #header -->
        </div><!-- .header-container -->
        
        <?php 
            if($position != 'below'){
                /**
            	 * @hooked theme_slideshows_position_callback 10
            	 */
            	do_action( 'theme_slideshows_position' );
            } 
         ?>
        
        <?php
    	/**
    	 * @hooked theme_before_content_add_title 10
         * 
    	 */
    	do_action( 'theme_before_content' , $position); ?>
        
        <div id="content" class="<?php echo apply_filters('themdev_content_class', 'site-content') ?>">
            <?php
    		/**
    		 * @hooked
    		 */
    		do_action( 'theme_content_top' ); ?>