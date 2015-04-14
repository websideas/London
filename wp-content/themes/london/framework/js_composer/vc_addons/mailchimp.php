<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Mailchimp extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'border_heading' => '',
    		'mailchimp_list' => '',
    		'opt_in' => 'yes',
            'text_before' => '',
            'text_after' => '',
            'layout' => 'one',
            'desktop' => '',
            'tablet' => '',
            'mobile' => '',
            'el_class' => '',
            'css_animation' => '',
            'css' => '',
        ), $atts ) );
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'mailchimp-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output = '';
        
        $api_key = themedev_option('mailchimp_api');

        if ( isset ( $api_key ) && !empty ( $api_key ) ) {
            
            if(!$content) 
                $content = __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', THEME_LANGUAGE);
            
            $uniqeID    = uniqid();
            $output .= '<div class="'.esc_attr( $elementClass ).'" id="mailchimp-wrapper-'.$uniqeID.'">';
            
            if($title){
                $heading_class = "block-heading";
                if($border_heading){
                    $heading_class .= " block-heading-underline";
                }
                $output .= '<div class="'.$heading_class.'">';
                    $output .= '<h3>'.$title.'</h3>';
                $output .= '</div>';
            }
            
            $output .= ($text_before) ? '<div class="mailchimp-before">'.$text_before.'</div>' : '';
            
            $output .= '<form class="mailchimp-form clearfix mailchimp-layout-'.$layout.'" action="#" method="post">';
                $email = '<input name="email" class="form-control" required="" type="email" placeholder="'.__('E-mail address', THEME_LANGUAGE).'"/>';
                $button = '<button class="btn btn-default mailchimp-submit" data-loading="'.__('Loading ...', THEME_LANG).'" data-text="'.__('Subscribe', THEME_LANG).'"  type="submit">'.__('Subscribe', THEME_LANGUAGE).'</button>';
                if($layout == 'one'){
                    $text_repate = '<div class="input-group">%s<div class="input-group-btn">%s</div></div>'; 
                }else{
                    $text_repate = '<div class="mailchimp-input-email">%s</div><div class="mailchimp-input-button">%s</div>';
                }
                $output .= sprintf( $text_repate, $email, $button );
    			$output .= '<input type="hidden" name="action" value="signup"/>';
    			$output .= '<input type="hidden" name="list_id" value="'.$mailchimp_list.'"/>';
                $output .= '<input type="hidden" name="opt_in" value="'.$opt_in.'"/>';
                $output .= '<div class="mailchimp-success">'.$content.'</div>';
                $output .= '<div class="mailchimp-error"></div>';
            $output .= '</form>';
            $output .= ($text_after) ? '<div class="mailchimp-after">'.$text_after.'</div>' : '';
            $output .= '</div>';
        }
        
        $desktop = $desktop ? "@media (min-width: 992px) {#mailchimp-wrapper-{$uniqeID}{min-height: $desktop}}" : '';
        $tablet = $tablet ? "@media (max-width: 768px) {#mailchimp-wrapper-{$uniqeID}{min-height: $tablet}}" : '';
        $mobile = $mobile ? "@media (max-width: 480px) {#mailchimp-wrapper-{$uniqeID}{min-height: $mobile}}" : '';  
        
        $style = '<style>'.$desktop.$tablet.$mobile.'</style>';
        
    	return $output.$style;
    }
}

vc_map( array(
    "name" => __( "Mailchimp", THEME_LANGUAGE),
    "base" => "mailchimp",
    "category" => __('by Cuongdv'),
    "description" => __( "Mailchimp", THEME_LANGUAGE),
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
			'type' => 'checkbox',
			'heading' => __( 'Border in heading', THEME_LANGUAGE ),
			'param_name' => 'border_heading',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
		),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'Newsletter layout', THEME_LANGUAGE ),
        	'param_name' => 'layout',
        	'admin_label' => true,
        	'value' => array(
        		__( 'One line', THEME_LANGUAGE ) => 'one',
        		__( 'Two line', THEME_LANGUAGE ) => "two"
        	),
        	'description' => __( 'Select your layout', THEME_LANGUAGE )
        ),
        array(
            "type" => "kt_mailchimp",
            "heading" => __("Select List", THEME_LANGUAGE),
            "param_name" => "mailchimp_list",
            "description" => __("", THEME_LANGUAGE)
        ),
        array(
            "type" => 'checkbox',
            "heading" => __( 'Double opt-in', THEME_LANGUAGE ),
            "param_name" => 'opt_in',
            "description" => __("", THEME_LANGUAGE),
            "value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
        ),
        array(
          "type" => "textarea",
          "heading" => __("Text before form", THEME_LANGUAGE),
          "param_name" => "text_before",
          "description" => __("", THEME_LANGUAGE)
        ),
        array(
          "type" => "textarea",
          "heading" => __("Text after form", THEME_LANGUAGE),
          "param_name" => "text_after",
          "description" => __("", THEME_LANGUAGE)
        ),
        array(
          "type" => "textarea_html",
          "heading" => __("Success Message", THEME_LANGUAGE),
          "param_name" => "content",
          'value' => __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', THEME_LANGUAGE), 
          "description" => __("", THEME_LANGUAGE)
        ),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
        	'admin_label' => true,
        	'value' => array(
        		__( 'No', 'js_composer' ) => '',
        		__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        		__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        		__( 'Left to right', 'js_composer' ) => 'left-to-right',
        		__( 'Right to left', 'js_composer' ) => 'right-to-left',
        		__( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
          "type" => "kt_heading",
          "heading" => __("Min height for item", THEME_LANGUAGE),
          "param_name" => "items_show",
          "description" => __("Please include unit it. (Ex. 300px). ", THEME_LANGUAGE)
        ),
        array(
			"type" => "textfield",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANGUAGE),
			"param_name" => "desktop",
	  	),
		array(
			"type" => "textfield",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANGUAGE),
			"param_name" => "tablet",
			"step" => "5",
	  	),
		array(
			"type" => "textfield",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANGUAGE),
			"param_name" => "mobile",
	  	),
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
    ),
));

