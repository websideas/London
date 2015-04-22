<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * @see wp-content/plugins/js_composer/include/params/vc_grid_item/shortcodes.php
*/




// $this->shortcodes = apply_filters( 'vc_grid_item_shortcodes', $this->shortcodes );

function kt_gird_items(  $shortcodes ){


    $post_data_params = array(
        array(
            'type' => 'dropdown',
            'heading' => __( 'Add link', 'js_composer' ),
            'param_name' => 'link',
            'value' => array(
                __( 'None', 'js_composer' ) => 'none',
                __( 'Post link', 'js_composer' ) => 'post_link',
                __( 'Large image', 'js_composer' ) => 'image',
                __( 'Large image (prettyPhoto)', 'js_composer' ) => 'image_lightbox',
                __( 'Custom', 'js_composer' ) => 'custom',
            ),
            'description' => __( 'Select link option.', 'js_composer' ),
        ),
        array(
            'type' => 'vc_link',
            'heading' => __( 'URL (Link)', 'js_composer' ),
            'param_name' => 'url',
            'dependency' => array(
                'element' => 'link',
                'value' => array( 'custom' )
            ),
            'description' => __( 'Add custom link.', 'js_composer' ),
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),
    );


    $shortcodes['vc_gitem_post_metadata'] =  array(
        'name' => __( 'Post Meta Data', 'js_composer' ),
        'base' => 'vc_gitem_post_metadata',
        'icon' => '',
        'category' => __( 'Post', 'js_composer' ),
        'description' => __( ' Meta data for post', 'js_composer' ),
        'params' => array_merge( $post_data_params, array(
            array(
                'type' => 'textfield',
                'heading' => __( 'Extra class name', 'js_composer' ),
                'param_name' => 'el_class',
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            ),
        ) ),
    );

    return $shortcodes;
}

add_filter('vc_grid_item_shortcodes', 'kt_gird_items');