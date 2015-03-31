<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Mailchimp extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
    		'mailchimp_list' => '',
    		'opt_in' => 'yes',
            'text_before' => '',
            'text_after' => '',
            'el_class' => '',
            'css' => '',
        ), $atts ) );
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'mailchimp-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        
        $output = '';
        
        $api_key = "acf783f889d685580748b6c543235ef9-us5";
        if ( isset ( $api_key ) && !empty ( $api_key ) ) {
            
            if(!$content) 
                $content = __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', THEME_LANGUAGE);
            
            $rand = rand();
            
            $output .= '<div class="'.esc_attr( $css_class ).'">';
            
            $heading_class = apply_filters('js_composer_heading', 'block-heading mailchimp-heading');
            $heading_class = apply_filters('mailchimp_heading', $heading_class);
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
            $output .= ($text_before) ? '<p class="mailchimp-before">'.$text_before.'</p>' : '';
            
            $output .= '<form class="mailchimp-form" id="mailchimp'.$rand.'" action="#" method="post">';
            
                $output .= '<input name="email" class="form-control" required="" id="email'.$rand.'" type="email" placeholder="'.__('E-mail address', THEME_LANGUAGE).'"/>';
    			$output .= '<input type="hidden" name="action" value="signup"/>';
    			$output .= '<input type="hidden" name="list_id" value="'.$mailchimp_list.'"/>';
                $output .= '<input type="hidden" name="opt_in" value="'.$opt_in.'"/>';
                
    			$output .= '<input type="submit" value="'.__('Subscribe', THEME_LANGUAGE).'" class="submit"/>';
                $output .= '<span class="mailchimp-loading"><i class="fa fa-spinner fa-spin fa-lg"></i></span>';
                
                $output .= '<div class="mailchimp-success">'.$content.'</div>';    
                $output .= '<div class="mailchimp-error"></div>';
            $output .= '</form>';
            $output .= ($text_after) ? '<p class="mailchimp-after">'.$text_after.'</p>' : '';
            $output .= '</div>';
        }
    	return $output;
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

