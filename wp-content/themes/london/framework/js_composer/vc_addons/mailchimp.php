<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if(class_exists('KT_Mailchimp')){


    vc_map( array(
        "name" => __( "Mailchimp", THEME_LANG),
        "base" => "mailchimp",
        "category" => __('by Theme', THEME_LANG ),
        "description" => __( "Mailchimp", THEME_LANG),
        "wrapper_class" => "clearfix",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", THEME_LANG ),
                "param_name" => "title",
                "description" => __( "Mailchimp title", THEME_LANG ),
                "admin_label" => true,
            ),
            array(
            	'type' => 'dropdown',
            	'heading' => __( 'Newsletter layout', THEME_LANG ),
            	'param_name' => 'layout',
            	'admin_label' => true,
            	'value' => array(
            		__( 'One line', THEME_LANG ) => 'one',
            		__( 'Two line', THEME_LANG ) => "two"
            	),
            	'description' => __( 'Select your layout', THEME_LANG )
            ),
            array(
                "type" => "kt_mailchimp",
                "heading" => __("Select List", THEME_LANG),
                "param_name" => "mailchimp_list",
                "description" => __("", THEME_LANG)
            ),
            array(
                "type" => 'checkbox',
                "heading" => __( 'Double opt-in', THEME_LANG ),
                "param_name" => 'opt_in',
                "description" => __("", THEME_LANG),
                "value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
              "type" => "textarea",
              "heading" => __("Text before form", THEME_LANG),
              "param_name" => "text_before",
              "description" => __("", THEME_LANG)
            ),
            array(
              "type" => "textarea",
              "heading" => __("Text after form", THEME_LANG),
              "param_name" => "text_after",
              "description" => __("", THEME_LANG)
            ),
            array(
              "type" => "textarea_html",
              "heading" => __("Success Message", THEME_LANG),
              "param_name" => "content",
              'value' => __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', THEME_LANG), 
              "description" => __("", THEME_LANG)
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
              "heading" => __("Min height for item", THEME_LANG),
              "param_name" => "items_show",
              "description" => __("Please include unit it. (Ex. 300px). ", THEME_LANG)
            ),
            array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Desktop", THEME_LANG),
    			"param_name" => "desktop",
    	  	),
    		array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Tablet", THEME_LANG),
    			"param_name" => "tablet",
    			"step" => "5",
    	  	),
    		array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Mobile", THEME_LANG),
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

}