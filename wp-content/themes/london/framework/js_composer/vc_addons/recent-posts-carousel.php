<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Recent_Posts_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'source' => 'all',
            'categories' => '',
            'posts' => '',
            'authors' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'max_items' => 10,
            'desktop' => 4,
            'tablet' => 2,
            'mobile' => 1,
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
        ), $atts ) );
        
        
        $args = array(
                    'order' => $order,
                    'orderby' => $orderby,
                    'posts_per_page' => $max_items,
                    'ignore_sticky_posts' => true
                );
        
        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }
        if($source == 'categories'){
            if($categories){
                $categories_arr = array_filter(explode( ',', $categories));
                if(count($categories_arr)){
                    $args['category__in'] = $authors_arr;
                }
            }
        }elseif($source == 'posts'){
            if($posts){
                $posts_arr = array_filter(explode( ',', $posts));
                if(count($posts_arr)){
                    $args['post__in'] = $posts_arr;
                }
            }
        }elseif($source == 'authors'){
            if($authors){
                $authors_arr = array_filter(explode( ',', $authors));
                if(count($authors_arr)){
                    $args['author__in'] = $authors_arr;
                }
            }
        }
        
        // The Query
        $the_query = new WP_Query( $args );
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'recent-posts-carousel-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            $heading_class = apply_filters('js_composer_heading', 'block-heading recent-posts-heading');
            $heading_class = apply_filters('recent_posts_heading', $heading_class);
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
                $output .= '<div class="owl-carousel-wrapper">';
                $output .= '<div class="owl-carousel kt-owl-carousel" data-autoheight="false" data-pagination="false" data-theme="style-navigation-top" data-itemscustom="[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]">';
                while ( $query->have_posts() ) : $query->the_post();
                    $output .= '<div class="recent-posts-item">';
                        $output .= '<a href="'.get_permalink().'" class="entry-thumbnail">';
                            $output .= get_the_post_thumbnail( $post->ID, 'recent_posts', array('class'=>"first-img product-img"));
                        $output .= '</a>';
                        
                        $output .= '<h5 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
                        $output .= '<p class="post-content-blog">'.get_the_excerpt().'</p>';
                        $output .= sprintf(
                                        "<p><a href='%s' class='%s'>%s</a></p>",
                                        get_permalink(),
                                        'btn btn-default',
                                        __('Read More', THEME_LANG)
                                    );
                        
                    $output .= '</div><!-- .recent-posts-item -->';
                endwhile; wp_reset_postdata();
                $output .= '</div>';
                $output .= '</div>';
                
                
            endif;
        $output .= '</div>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => __( "Recent Posts Carousel", THEME_LANGUAGE),
    "base" => "recent_posts_carousel",
    "category" => __('by Cuongdv'),
    "description" => __( "Recent Posts Carousel", THEME_LANGUAGE),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Data source", THEME_LANGUAGE),
        	"param_name" => "source",
        	"value" => array(
                __('All', THEME_LANGUAGE) => '',
                __('Specific Categories', THEME_LANGUAGE) => 'categories',
                __('Specific Posts', THEME_LANGUAGE) => 'posts',
                __('Specific Authors', THEME_LANGUAGE) => 'authors'
        	),
            "admin_label" => true,
            'std' => 'all',
        	"description" => __("Select content type for your testimonials.", THEME_LANGUAGE)
        ),
        array(
			"type" => "kt_taxonomy",
            'taxonomy' => 'category',
			'heading' => __( 'Categories', 'js_composer' ),
			'param_name' => 'categories',
            'placeholder' => __( 'Select your categories', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
		),
        array(
			"type" => "kt_posts",
            'post_type' => 'post',
			'heading' => __( 'Specific Posts', 'js_composer' ),
			'param_name' => 'posts',
            'size' => '5',
            'placeholder' => __( 'Select your posts', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('posts')),
            'multiple' => true,
		),
        array(
			"type" => "kt_authors",
            'post_type' => 'post',
			'heading' => __( 'Specific Authors', 'js_composer' ),
			'param_name' => 'authors',
            'size' => '5',
            'placeholder' => __( 'Select your authors', 'js_composer' ),
            "dependency" => array("element" => "source","value" => array('authors')),
            'multiple' => true,
		),
        array(
    		'type' => 'textfield',
    		'heading' => __( 'Total items', 'js_composer' ),
    		'param_name' => 'max_items',
    		'value' => 10, // default value
    		'param_holder_class' => 'vc_not-for-custom',
    		'description' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'js_composer' )
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
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        // Data settings
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Order by', 'js_composer' ),
    		'param_name' => 'orderby',
    		'value' => array(
    			__( 'Date', 'js_composer' ) => 'date',
    			__( 'Order by post ID', 'js_composer' ) => 'ID',
    			__( 'Author', 'js_composer' ) => 'author',
    			__( 'Title', 'js_composer' ) => 'title',
    			__( 'Last modified date', 'js_composer' ) => 'modified',
    			__( 'Post/page parent ID', 'js_composer' ) => 'parent',
    			__( 'Number of comments', 'js_composer' ) => 'comment_count',
    			__( 'Menu order/Page Order', 'js_composer' ) => 'menu_order',
    			__( 'Meta value', 'js_composer' ) => 'meta_value',
    			__( 'Meta value number', 'js_composer' ) => 'meta_value_num',
    			__( 'Random order', 'js_composer' ) => 'rand',
    		),
    		'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
    		'group' => __( 'Data settings', 'js_composer' ),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
    	),
    	array(
    		'type' => 'textfield',
    		'heading' => __( 'Meta key', 'js_composer' ),
    		'param_name' => 'meta_key',
    		'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
    		'group' => __( 'Data settings', 'js_composer' ),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
    		'dependency' => array(
    			'element' => 'orderby',
    			'value' => array( 'meta_value', 'meta_value_num' ),
    		),
            "admin_label" => true,
    	),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Sorting', 'js_composer' ),
    		'param_name' => 'order',
    		'group' => __( 'Data settings', 'js_composer' ),
    		'value' => array(
    			__( 'Descending', 'js_composer' ) => 'DESC',
    			__( 'Ascending', 'js_composer' ) => 'ASC',
    		),
    		'param_holder_class' => 'vc_grid-data-type-not-ids',
    		'description' => __( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
    	),
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANGUAGE ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            'group' => __( 'Carousel', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Navigation', THEME_LANGUAGE ),
			'param_name' => 'navigation',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            'desc' => __( 'Display "next" and "prev" buttons.', THEME_LANGUAGE ),
            'group' => __( 'Carousel', THEME_LANG )
		),
        array(
    		'type' => 'dropdown',
    		'heading' => __( 'Theme', 'js_composer' ),
    		'param_name' => 'theme',
    		'group' => __( 'Data settings', 'js_composer' ),
    		'value' => array(
    			__( 'Navigation Top', 'js_composer' ) => 'style-navigation-top',
    			__( 'Navigation Center', 'js_composer' ) => 'style-navigation-center',
                __( 'Navigation Bottom', 'js_composer' ) => 'style-navigation-bottom',
    		),
    		'description' => __( 'Select sorting order.', 'js_composer' ),
            'group' => __( 'Carousel', THEME_LANG )
    	),
        array(
			"type" => "kt_number",
			"heading" => __("Slide Speed", THEME_LANGUAGE),
			"param_name" => "slidespeed",
			"value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
			"desc" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel', THEME_LANG )
	  	),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANGUAGE),
          "param_name" => "items_show",
          "value" => "6",
          'group' => __( 'Carousel', THEME_LANG )
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANGUAGE),
			"param_name" => "desktop",
			"value" => "4",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANGUAGE),
			"param_name" => "tablet",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel', THEME_LANG )
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANGUAGE),
			"param_name" => "mobile",
			"value" => "1",
			"min" => "1",
			"max" => "25",
			"step" => "1",
            'group' => __( 'Carousel', THEME_LANG )
	  	),
        
        
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
    ),
));