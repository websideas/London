<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Add stylesheet and script for admin
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'admin_enqueue_scripts', 'kt_admin_enqueue_scripts' );
if ( !function_exists( 'kt_admin_enqueue_scripts' ) ) {
    function kt_admin_enqueue_scripts(){
        
        wp_register_style( 'font-awesome', THEME_FONTS.'font-awesome/css/font-awesome.min.css');
        wp_register_style( 'elegant_font', THEME_FONTS.'elegant_font/style.css');
        wp_register_style( 'framework-core', FW_CSS.'framework-core.css');
        wp_register_style( 'chosen-style', FW_LIBS.'chosen/chosen.min.css');
        
        
        wp_register_style( 'admin-style', FW_CSS.'theme-admin.css',array( 'elegant_font', 'font-awesome', 'framework-core'));
        wp_enqueue_style('admin-style');
        
        wp_register_script( 'framework-core', FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), FW_VER, true);
        wp_enqueue_script('framework-core');

    } // End kt_admin_enqueue_scripts.
}


/**
 * Add stylesheet and script for frontend
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */


add_action( 'wp_enqueue_scripts', 'wp_enqueue_scripts_frontend' );
if ( !function_exists( 'wp_enqueue_scripts_frontend' ) ) {
    function wp_enqueue_scripts_frontend(){
        
        

    } // End wp_enqueue_scripts_frontend.
}

/**
 * Custom admin logo
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_custom_login_logo() {
    /*
    $options = get_option('theme_options');
    if($options['admin_login']){
	   echo '<style type="text/css">h1 a { background-image:url('.$options['admin_login']['url'].') !important;background-size: auto auto !important;margin-bottom: 10px !important;width: auto!important;}</style>';
    }
    */
}
add_action('login_head', 'kt_custom_login_logo');


/**
 * Custom admin logo
 * 
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_setting_css() {
    $accent = kt_option('styling_accent', '');
    $header_opacity = kt_option('header_layout_opacity', '0.8');
    $header_sticky_opacity = kt_option('header_sticky_opacity', '0.8');
    
    
    ?>
    <style type="text/css">
        <?php if( $accent !='' ){ ?>
        ::-moz-selection{ background:<?php echo $accent; ?>; }
        ::-webkit-selection{ background:<?php echo $accent; ?>; }
        ::selection{ background:<?php echo $accent; ?>; }
        .button, 
        .btn-default,
        .highlight.highlight1,
        .header-layout1 .shopping_cart > a:hover,
        .site-branding .site-logo.logo-circle,
        .tp-bullets.simplebullets.round .bullet.selected,
        .widget_tag_cloud a,
        .widget_product_tag_cloud a, 
        .widget_tag_cloud a,
        #calendar_wrap caption,
        .sidebar .widget-container .widget-title,
        .woocommerce span.onsale,
        .kt-owl-carousel .owl-buttons div:hover,
        .carousel-heading-top .owl-buttons div:hover,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover,
        .mCSB_scrollTools,
        /*
        .woocommerce ul.products .button:hover,
        .woocommerce .functional-buttons .yith-wcwl-wishlistaddedbrowse a:hover, 
        .woocommerce .functional-buttons .yith-wcwl-wishlistexistsbrowse a:hover, 
        .woocommerce .functional-buttons .yith-wcwl-add-button a.add_to_wishlist:hover, 
        .woocommerce .functional-buttons .product.compare-button a:hover, 
        .woocommerce .functional-buttons .product-quick-view:hover,

        .woocommerce .functional-buttons .yith-wcwl-wishlistaddedbrowse a:focus, 
        .woocommerce .functional-buttons .yith-wcwl-wishlistexistsbrowse a:focus, 
        .woocommerce .functional-buttons .yith-wcwl-add-button a.add_to_wishlist:focus, 
        .woocommerce .functional-buttons .product.compare-button a:focus, 
        .woocommerce .functional-buttons .product-quick-view:focus,
        */
        #calendar_wrap tbody td#today,
        .woocommerce .summary .single_add_to_cart_button:hover,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus{
            background-color: <?php echo $accent; ?>;
        }
        .button, 
        .btn-default,
        blockquote, 
        .blockquote-reverse, 
        blockquote.pull-right,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover{
            border-color: <?php echo $accent; ?>;
        }
        ul.navigation-mobile > li:hover > a, 
        ul.navigation-mobile > li > a:hover,
        ul.navigation-mobile > li.current-menu-item > a{
            border-left-color: <?php echo $accent; ?>;
        }
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a:after,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover:after{
            border-top-color: <?php echo $accent; ?>;
        }

        #backtotop,
        #calendar_wrap tbody td,
        .blog-posts .post-item .entry-date-time,
        .woocommerce ul.products .product-image-container .button,
        .woocommerce ul.products .product-image-container .functional-buttons,
        .shopping_cart > a span.cart-content-total{
            background-color: <?php echo $accent; ?>;
        }
        .shopping_cart > a span.cart-content-total::before{
            border-right-color: <?php echo $accent; ?>;
        }

        .header-layout1.header-container{
            background-color: <?php echo kt_hex2rgba($accent, $header_opacity) ?>;
        }
        #header.is-sticky{
            background-color: <?php echo kt_hex2rgba($accent, $header_sticky_opacity) ?>;
        }
        <?php } ?>

    </style>
    <?php

}
add_action('wp_head', 'kt_setting_css');

