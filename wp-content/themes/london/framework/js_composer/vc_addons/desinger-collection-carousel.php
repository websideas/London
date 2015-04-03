<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Desinger_Collection_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'number' => 10,
            'desktop' => 4,
            'tablet' => 2,
            'mobile' => 1,
            'el_class' => '',
            'css' => '',
        ), $atts ) );
        
        $args = array(
            'posts_per_page'=> $number,
            'post_type' => 'kt_designer'
    	);
        
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'desinger-collection-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        $output = '';
        $output .= '<div class="'.esc_attr( $css_class ).'">';
            $heading_class = apply_filters('js_composer_heading', 'block-heading desinger-collection-carousel-heading');
            $heading_class = apply_filters('desinger_collection_carousel_heading', $heading_class);
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
            
            $output .= '<div class="row">';
                $output .= '<div class="col-md-3 col-sm-3 col-xs-12">';
                    $query = new WP_Query( $args );
                    if ( $query->have_posts() ) :
                        $output .= '<div class="owl-carousel-wrapper">';
                        $output .= '<div class="owl-carousel kt-owl-carousel" data-autoheight="false" data-pagination="false" data-theme="style-navigation-center" data-itemscustom="[[992,1], [768,1], [480,1]]">';
                        $desinger = false;
                        while ( $query->have_posts() ) : $query->the_post();
                            $output .= '<div class="desinger-collection-item">';
                                if(has_post_thumbnail()){
                                    $output .= sprintf(
                                                    '<a href="#" title="%s" class="desinger-collection-link">%s</a>',
                                                    __('Click on image to load products of the collection', THEME_LANG),
                                                    get_the_post_thumbnail(get_the_ID(), 'full', array('class'=>"img-responsive"))
                                                );
                                }
                                $output .= sprintf(
                                                '<p class="info"><span class="name">%s</span>&nbsp;<span class="company">%s</span></p>',
                                                get_the_title(),
                                                rwmb_meta( 'kt_description' )
                                            );
                                $output .= rwmb_meta( 'kt_info' );
                                
                            $output .= '</div><!-- .desinger-collection-item -->';
                            if(!$desinger){
                                $desinger = get_the_ID();
                            }
                            
                        endwhile; wp_reset_postdata();
                        $output .= '</div><!-- .owl-carousel.kt-owl-carousel -->';
                        $output .= '</div><!-- .owl-carousel-wrapper -->';
                    endif;
                $output .= '</div>';
                
                
                
                
                $output .= '<div class="col-md-9 col-sm-9 col-xs-12">';
                    $products = rwmb_meta('kt_products', array('type' => 'post', 'multiple' => true), $desinger); 
                    
                    global $woocommerce_loop;
                    $woocommerce_loop['columns'] = 1;
                    
                    if(count($products)){
                        $args = array(
                			'posts_per_page'	=> -1,
                			'post_status' 		=> 'publish',
                			'post_type' 		=> 'product',
                			'post__in'			=> array_merge( array( 0 ), $products )
                		);
                        
                        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
                        
                        if ( $products->have_posts() ) :

                            $itemscustom = '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]';
                            $output .= '<div class="woocommerce-carousel-wrapper" data-theme="style-navigation-bottom" data-itemscustom="'.$itemscustom.'">';
                            
                            ob_start();
                                
                            woocommerce_product_loop_start();
                            while ( $products->have_posts() ) : $products->the_post();
                                wc_get_template_part( 'content', 'product-normal' );
                            endwhile; // end of the loop.
                            woocommerce_product_loop_end();
                            
                            $output .= '<div class="woocommerce  columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
                            $output .= '</div><!-- .woocommerce-carousel-wrapper -->';
                            $output .= '</div>'; 
                            
                        endif;
                
                		wp_reset_postdata();
                        
                        
                    }
                    
                $output .= '</div>';
            
            $output .= '</div><!-- .row -->';
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Desinger Collection Carousel", THEME_LANGUAGE),
    "base" => "desinger_collection_carousel",
    "category" => __('by Cuongdv'),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            "type" => "kt_number",
            "heading" => __("Number Post", THEME_LANGUAGE),
            "param_name" => "number",
            "value" => 10,
            "description" => __("How many Posts you would like to show? ( -1 means unlimited )", THEME_LANGUAGE)
        ),
        array(
            "type" => "kt_heading",
            "heading" => __("Items to Show?", THEME_LANGUAGE),
            "param_name" => "items_show",
            "value" => "6",
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANGUAGE),
			"param_name" => "desktop",
			"value" => "5",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANGUAGE),
			"param_name" => "tablet",
			"value" => "3",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANGUAGE),
			"param_name" => "mobile",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		)
    ),
));