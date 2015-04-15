<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function theme_body_classes( $classes ) {
    global $post;
    
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
    
    if(is_page() || is_singular('post')){
        $classes[] = 'layout-'.themedev_getlayout($post->ID);
        $classes[] = rwmb_meta('kt_extra_page_class');
    }else{
        $classes[] = 'layout-'.themedev_option('layout');
    }

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

/**
 * Add class layout for main class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function themedev_main_class_callback($classes, $layout){
    
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-9 col-xs-12'; 
    }else{
        $classes .= ' col-md-12 col-xs-12';
    }
    
    if($layout == 'left'){
         $classes .= ' pull-right';
    }
    return $classes;
}
add_filter('themedev_main_class', 'themedev_main_class_callback', 10, 2);


/**
 * Add class layout for sidebar class
 *
 * @since 1.0
 *
 * @param string $classes current class
 * @param string $layout layout current of page 
 *  
 * @return array The filtered body class list.
 */
function themedev_sidebar_class_callback($classes, $layout){
    if($layout == 'left' || $layout == 'right'){
        $classes .= ' col-md-3 col-xs-12'; 
    }
    return $classes;
}
add_filter('themedev_sidebar_class', 'themedev_sidebar_class_callback', 10, 2);



/**
 * Add class remove top or bottom padding
 *
 * @since 1.0
 */
function themdev_content_class_callback($classes){
    global $post;
    if(is_page()){
        if(rwmb_meta('kt_remove_top')){
            $classes .= ' remove_top_padding';
        }
        if(rwmb_meta('kt_remove_bottom')){
            $classes .= ' remove_bottom_padding';
        }
    }
    return $classes;
} 
add_filter('themdev_content_class', 'themdev_content_class_callback');

/**
 * Add class sticky to header
 */
function theme_header_content_class_callback($classes){
    $sticky = themedev_option('fixed_header', 1);
    if($sticky){
        $classes .= ' sticky-header';
    }
    return $classes;
}

add_filter('theme_header_content_class', 'theme_header_content_class_callback');


/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'theme_slideshows_position', 'theme_slideshows_position_callback' );
function theme_slideshows_position_callback(){
    global $post;
    if(is_page() || is_singular('post')){
        
        $slideshow = rwmb_meta('kt_slideshow_source');
        if($slideshow == 'revslider'){
            $revslider = rwmb_meta('kt_rev_slider');
            if($revslider && class_exists( 'RevSlider' )){
                echo putRevSlider($revslider);
            }
        }elseif($slideshow == 'layerslider'){
            $layerslider = rwmb_meta('kt_layerslider');
            if($layerslider && is_plugin_active( 'LayerSlider/layerslider.php' )){
                echo do_shortcode('[layerslider id="'.$layerslider.'"]');
            }
        }
    }elseif ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if(is_product_category()){
            
            	global $wp_query;
                $cat = $wp_query->get_queried_object();
                $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
                $image = wp_get_attachment_url( $thumbnail_id );
                if ( $image ) {
                    echo sprintf(
                        '<div class="category-slide-container"><div class="container">%s</div></div>',
                        '<img src="' . $image . '" alt="" class="img-responsive" />'
                    );
                } 
        }
    }
}

/**
 * Add title 
 *
 * @since 1.0
 */
add_action( 'theme_before_content', 'theme_before_content_add_title', 20 );
function theme_before_content_add_title(){
    /*
    ?>
    <div class="page-title-container">
        <div class="container">
            <?php wp_title(); ?>
        </div>
    </div>
    <?php
    */
}


/**
 * Add class header
 *
 * @since 1.0
 * @return string
 */
add_filter('theme_header_class', 'theme_header_class_callback', 10, 2);

function theme_header_class_callback($class, $position){
    if($position == 'override'){
        $class .= ' header-absolute';
    }
    return $class;
}



/**
 * Add popup 
 *
 * @since 1.0
 */
add_action( 'theme_after_footer', 'theme_after_footer_add_popup', 20 );
function theme_after_footer_add_popup(){
    $enable_popup = themedev_option( 'enable_popup' );
    $disable_popup_mobile = themedev_option( 'disable_popup_mobile' );
    $content_popup = themedev_option( 'content-popup' );
    if( $enable_popup == 1 ){
        if(!isset($_SESSION['popup'])){ ?>
            <div id="popup-wrap" data-mobile="<?php echo $disable_popup_mobile; ?>">     
                <div class="white-popup-block">
                    <?php echo do_shortcode($content_popup); ?>
                </div>
            </div>
        <?php }else{
            $_SESSION['popup'] = 1;
        }
    }
}