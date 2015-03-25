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
    <link href='http://fonts.googleapis.com/css?family=Dosis:400,200,300,500,600,700' rel='stylesheet' type='text/css'>
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
            <header id="header" class="sticky-header">
                <div class="container">
                    <div id="header-wrap" class="display-table">
                        <div class="site-branding display-td">
                            <?php if ( is_front_page() && is_home() ) : ?>
        						<h1 class="site-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo THEME_IMG; ?>nella-fashion.jpg" alt="<?php bloginfo( 'name' ); ?>" />
                                    </a>
                                </h1><!-- .site-logo -->
        					<?php else : ?>
        						<p class="site-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo THEME_IMG; ?>nella-fashion.jpg" alt="<?php bloginfo( 'name' ); ?>" />                                    
                                    </a>
                                </p><!-- .site-logo -->
        					<?php endif; ?>
                            <div id="site-title"><?php bloginfo( 'name' ); ?></div>
                            <div id="site-description"><?php bloginfo( 'description' ); ?></div>
                        </div><!-- .site-branding -->
                        <div class="header-content display-td">
                            <div class="header-content-top clearfix">
                                <?php echo woocommerce_get_cart(); ?>
                                <?php wp_nav_menu( array( 'theme_location' => 'top', 'container' => 'nav', 'container_id' => 'top-nav' ) ); ?>
                            </div><!-- .header-content-top -->
                            <div class="header-content-bottom clearfix">
                                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav' ) ); ?>
                                <?php get_search_form(); ?>
                            </div><!-- .header-content-bottom -->
                        </div><!-- .header-content -->
                    </div><!-- #header-wrap -->
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