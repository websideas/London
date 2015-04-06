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
     * For Layout option
     * 
     */
    $meta_boxes[] = array(
        'id' => 'page_meta_boxes',
        'title' => 'Page Options',
        'pages' => array( 'page', 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name'    => __( 'Header position', THEME_LANG ),
                'type'     => 'select',
                'id'       => $prefix.'header_position',
                'desc'     => __( "Please choose header position", THEME_LANG ),
                'options'  => array(
                    'default' => __('Default', THEME_LANG),
                    'override' => __('Override Slideshow', THEME_LANG),
                    'below' => __('Below Slideshow', THEME_LANG)
                ),
                'std'  => 'default'
            ),
            array(
                'name' => __('Header layout', THEME_LANG),
                'id' => $prefix . 'header',
                'desc' => __("Please choose this page's layout.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default option', THEME_LANG),
                    'layout1' => __('Layout 1', THEME_LANG),
                    'layout2' => __('Layout 2', THEME_LANG),
                    'layout3' => __('Layout 3', THEME_LANG),
                ),
                'std' => 'default'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
                'name' => __('Select Your Slideshow Type', THEME_LANG),
                'id' => $prefix . 'slideshow_source',
                'desc' => __("You can select the slideshow type using this option.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    '' => __('Select Option', THEME_LANG),
                    'revslider' => __('Revolution Slider', THEME_LANG),
                    'layerslider' => __('Layer Slider', THEME_LANG),
                ),
            ),
            array(
                'name' => __('Select Revolution Slider', THEME_LANG),
                'id' => $prefix . 'rev_slider',
                'default' => true,
                'type' => 'revSlider'
            ),
            array(
                'name' => __('Select Layer Slider', THEME_LANG),
                'id' => $prefix . 'layerslider',
                'default' => true,
                'type' => 'layerslider'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            
            array(
                'name' => __('Page layout', THEME_LANG),
                'id' => $prefix . 'layout',
                'desc' => __("Please choose this page's layout.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default option', THEME_LANG),
                    'full' => __('Full width Layout', THEME_LANG),
                    'boxed' => __('Boxed Layout', THEME_LANG),
                ),
                'std' => 'default'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
                'name' => __('Sidebar configuration', THEME_LANG),
                'id' => $prefix . 'sidebar',
                'desc' => __("Choose the sidebar configuration for the detail page.", THEME_LANG),
                'type' => 'select',
                'options' => array(
                    'default' => __('Default option', THEME_LANG),
                    'full' => __('No sidebars', THEME_LANG),
                    'left' => __('Left Sidebar', THEME_LANG),
                    'right' => __('Right Layout', THEME_LANG)
                ),
                'std' => 'default'
            ),
            array(
                'name' => __('Left sidebar', THEME_LANG),
                'id' => $prefix . 'left_sidebar',
                'default' => true,
                'type' => 'sidebars'
            ),
            array(
                'name' => __('Right sidebar', THEME_LANG),
                'id' => $prefix . 'right_sidebar',
                'default' => true,
                'type' => 'sidebars'
            ),
            array(
                'type' => 'divider',
                'id' => 'fake_divider_id',
            ),
            array(
				'name' => __('Remove top spacing', THEME_LANG),
				'id' => $prefix . 'remove_top',
				'desc' => __("Remove the spacing at the top of the page", THEME_LANG ),
				'type'  => 'checkbox',
			),
            array(
				'name' => __('Remove bottom spacing', THEME_LANG ),
				'id' => $prefix . 'remove_bottom',
				'desc' => __("Remove the spacing at the bottom of the page", THEME_LANG ),
				'type'  => 'checkbox',
			),
            array(
				'name' => 'Extra page class',
				'id' => $prefix . 'extra_page_class',
				'desc' => "If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.",
				'type'  => 'text',
			),
        )
    );
     
    
    
    
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
