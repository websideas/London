<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Clients_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'images' => '',
            'img_size' => 'thumbnail',
            'desktop' => 5,
            'tablet' => 3,
            'mobile' => 2,
            'el_class' => '',
        ), $atts ) );
        
        if ( $images == '' ) return;
        $images = explode( ',', $images );
        
        
        $carousel = '';
        foreach ( $images as $attach_id ) {
            if ( $attach_id > 0 ) {
        		$post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ) );
        	} else {
        		$post_thumbnail = array();
        		$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        		
        	}
            $carousel .= sprintf(
                            '<div class="%s">%s</div>',
                            'clients-carousel-item',
                            $post_thumbnail['thumbnail']
                        );
        }
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'clients-carousel-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        $output = '';
        $output .= '<div class=" '.$el_class.'">';
            $heading_class = apply_filters('js_composer_heading', 'block-heading clients-carousel-heading');
            $heading_class = apply_filters('clients_carousel_heading', $heading_class);
            
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
                $output .= '<div class="owl-carousel-wrapper">';
                $output .= '<div class="owl-carousel kt-owl-carousel" data-autoplay="false" data-pagination="false" data-theme="style-navigation-center visiable-navigation" data-itemscustom="[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]">';
                    $output .= $carousel;
                $output .= '</div>';
                $output .= '</div>';
                
                
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Clients Carousel", THEME_LANGUAGE),
    "base" => "clients_carousel",
    "category" => __('by Cuongdv'),
    "description" => __( "Recent Posts Carousel", THEME_LANGUAGE),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "description" => __( "Mailchimp title", THEME_LANGUAGE ),
            "admin_label" => true,
        ),
        array(
			'type' => 'attach_images',
			'heading' => __( 'Images', 'js_composer' ),
			'param_name' => 'images',
			'value' => '',
			'description' => __( 'Select images from media library.', 'js_composer' )
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Image size', 'js_composer' ),
			'param_name' => 'img_size',
			'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
		),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANGUAGE),
          "param_name" => "items_show",
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
        )
    ),
));