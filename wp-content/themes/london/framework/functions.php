<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'theme_before_content', 'theme_before_content_add_sideshow' );
function theme_before_content_add_sideshow(){
    
    if(is_front_page()){
        putRevSlider( "homepae-slider" );
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
    
}


/**
 * Add class header
 *
 * @since 1.0
 * @return string
 */
add_filter('theme_header_class', 'theme_header_class_custom');

function theme_header_class_custom($class){
    if(is_front_page()){
        return $class .' header-absolute';
    }
    return $class;
}