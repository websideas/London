<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Contact_Info extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'el_class' => '',
        ), $atts ) );
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'contact-info-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        $output = '';
        $output .= '<div class="'.esc_attr( $css_class ).'">';
            $output .= ($title) ? '<h3 class="title_block">'.$title.'</h3>' : '';
            $output .= '<ul class="contact-info-ul">';
            	$output .= ($address) ? '<li><i class="icon-map-marker"></i>'.$address.'</li>' : '';
                $output .= ($phone) ? '<li><i class="icon-phone"></i>'.$phone.'</li>' : '';
                $output .= ($email) ? '<li><i class="icon-envelope-alt"></i>'.__('Email: ', THEME_LANG).$email.'</li>' : '';
            $output .= '</ul>';
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Contact info", THEME_LANGUAGE),
    "base" => "contact_info",
    "category" => __('by Cuongdv'),
    "description" => __( "Contact info", THEME_LANGUAGE),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "description" => __( "Mailchimp title", THEME_LANGUAGE ),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Address", THEME_LANGUAGE ),
            "param_name" => "address",
            "description" => "",
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Phone", THEME_LANGUAGE ),
            "param_name" => "phone",
            "description" => "",
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Email", THEME_LANGUAGE ),
            "param_name" => "email",
            "description" => "",
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        )
    ),
));