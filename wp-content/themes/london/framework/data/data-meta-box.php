<?php
/**
 * All helpers for theme
 *
 */
 
 
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


add_filter( 'rwmb_meta_boxes', 'kite_register_meta_boxes' );
function kite_register_meta_boxes( $meta_boxes )
{
    $prefix = 'kt_';
    
    
    /**
     * For Designer
     * 
     */
    
    $meta_boxes[] = array(
        'id' => 'designer_meta_boxes',
        'title' => 'Designer Options',
        'pages' => array( 'kt_designer' ),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __('Short description', THEME_LANG),
                'id' => $prefix . 'description',
                'type' => 'text',
                'size' => 40,
                'desc' => __('Please enter your short description', THEME_LANG)
            ),
            array(
                'name' => __('Products', THEME_LANG),
                'id' => $prefix . 'products',
                'type' => 'post',
                'post_type' => 'product',
                'multiple' => true,
                'placeholder' => ('Select your products'),
                'desc' => __('Please Select product for this Designer', THEME_LANG),
                'field_type' => 'select_advanced'
            ),
            array(
                'name' => __( 'About Designer', THEME_LANG ),
                'id' => "{$prefix}info",
                'type' => 'wysiwyg',
                'raw' => false,
                'std' => "",
                'options' => array( 'textarea_rows' => 20 ),
            ),
            
            
        )
    );
    
    
    return $meta_boxes;
} 
