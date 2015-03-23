<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
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
	<?php wp_head(); ?>
    <?php do_action( 'theme_head_bottom' ); ?>
</head>

<body <?php body_class(); ?>>
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_body_top' ); ?>
    <div id="page">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_header' ); ?>
        
        <div class="header-container">
            <header id="header">
                <div class="container">
                    <div class=""></div>
                </div>
            </header><!-- #header -->
        </div><!-- .header-container -->
        
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_content' ); ?>
        
        <div id="content" class="site-content">
            <?php
    		/**
    		 * @hooked
    		 */
    		do_action( 'theme_content_top' ); ?>