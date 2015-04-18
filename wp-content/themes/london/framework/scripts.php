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
    $accent = kt_option('styling_accent', '#000000');
    
    $accent_brighter = kt_colour_brightness($accent, 0.8);
    $accent_brighter_b = kt_colour_brightness($accent, 0.6);
    
    $accent_darker = kt_colour_brightness($accent, -0.8);
    
    $header_opacity = kt_option('header_layout_opacity', '0.8');
    $header_sticky_opacity = kt_option('header_sticky_opacity', '0.8');
    
    //echo "$accent $accent_brighter $accent_brighter_b";
    
    /**
     * 000000 => $accent
     * 333333 => $accent_brighter
     * 666666 => $accent_brighter_b
     */
     
    ?>
    <style type="text/css">
        ::-moz-selection{ background:<?php echo $accent; ?>; }
        ::-webkit-selection{ background:<?php echo $accent; ?>; }
        ::selection{ background:<?php echo $accent; ?>; }
        .button, 
        .btn-default,
        .site-branding .site-logo.logo-circle,
        .tp-bullets.simplebullets.round .bullet.selected,
        .highlight.highlight1,
        .kt-owl-carousel .owl-buttons div:hover,
        .carousel-heading-top .owl-buttons div:hover,
        .mCSB_scrollTools,
        #calendar_wrap tbody td#today
        
        
        {
            background-color: <?php echo $accent; ?>;
        }
        
        .button, 
        .btn-default{
            border-color: <?php echo $accent; ?>;
        }
        #calendar_wrap thead th{
            color: <?php echo $accent; ?>;
        }
        
        ul.navigation-mobile > li:hover > a, 
        ul.navigation-mobile > li > a:hover,
        ul.navigation-mobile > li.current-menu-item > a, 
        ul.navigation-mobile > li.active-menu-item > a{
            border-left-color: <?php echo $accent; ?>;
        }
        
        
        
        .button:hover,
        .button:focus, 
        .btn-default.active, 
        .btn-default.focus, 
        .btn-default:active, 
        .btn-default:focus, 
        .btn-default:hover, 
        .open > .dropdown-toggle.btn-default,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus,
        #backtotop:hover,
        .sidebar .widget-container .widget-title,
        .widget_product_tag_cloud a, 
        .widget_tag_cloud a,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        #calendar_wrap caption,
        #calendar_wrap tbody td,
        .shopping_cart > a span.cart-content-total,
        .header-layout2 .header-content-bottom, 
        .header-layout3 .header-content-bottom,
        .blog-posts .post-item .entry-date-time,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover{
            background-color: <?php echo $accent_brighter; ?>;
        }
        
        .button:hover,
        .button:focus, 
        .btn-default.active, 
        .btn-default.focus, 
        .btn-default:active, 
        .btn-default:focus, 
        .btn-default:hover, 
        .open > .dropdown-toggle.btn-default,
        ul.kt_social_icons.large li a:hover, 
        ul.kt_social_icons.large li a:focus,
        body .wpb_content_element .wpb_tabs_nav li.ui-tabs-active, 
        body .wpb_content_element .wpb_tabs_nav li:hover,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a, 
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover{
            border-color: <?php echo $accent_brighter; ?>;
        }
        
        .shopping_cart > a span.cart-content-total:before{
            border-right-color: <?php echo $accent_brighter; ?>;
        }
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li.ui-tabs-active a:after,
        .categories-top-sellers-wrapper .block-heading-tabs-wapper .block-heading-tabs li a:hover:after{
            border-top-color: <?php echo $accent_brighter; ?>;
        }
        
        .woocommerce span.onsale,
        #backtotop{
            background-color: <?php echo $accent_brighter_b; ?>;
        }
        
        
        
        
        
        
        
        
        
        
        
        
        .header-layout1.header-container{
            background-color: <?php echo kt_hex2rgba($accent, $header_opacity) ?>;
        }
        
        #header.is-sticky{
            background-color: <?php echo kt_hex2rgba($accent, $header_sticky_opacity) ?>;
        }
        
    </style>
    <?php 
}
add_action('wp_head', 'kt_setting_css');

