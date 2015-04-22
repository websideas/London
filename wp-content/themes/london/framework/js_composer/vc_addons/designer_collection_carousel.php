<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Designer_Collection_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'source' => 'all',
            'posts' => '',
            'max_items' => 10,
            'num_products' =>  9,
            'css_animation' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'desktop' => 4,
            'tablet' => 2,
            'mobile' => 1,
            'el_class' => '',
            'css' => '',
        ), $atts ) );
        
        $args = array(
                    'post_type' => 'designer',
                    'order' => $order,
                    'orderby' => $orderby,
                    'posts_per_page' => $max_items
                );
        
        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }
        
        if($source == 'posts'){
            if($posts){
                $posts_arr = array_filter(explode( ',', $posts));
                if(count($posts_arr)){
                    $args['post__in'] = $posts_arr;
                }
            }
        }
        
        $atts['columns'] = 1;
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'designer-collection-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $id = uniqid('dc-');

        $output = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
            $heading_class = apply_filters('js_composer_heading', 'block-heading designer-collection-carousel-heading');
            $heading_class = apply_filters('designer_collection_carousel_heading', $heading_class);
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';

            $designer_ids  = array();
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {

                $output .= '<div class="row">';
                    $output .= '<div class="col-md-3 col-sm-3 col-xs-12 designer-collection-carousel">';
                        $output .= '<div class="owl-carousel-wrapper">';
                            $output .= '<div class="owl-carousel kt-owl-carousel" id="'.$id.'" data-js-callback="designer_carousel_cb" data-autoheight="false" data-pagination="false" data-theme="style-navigation-center">';

                                while ( $query->have_posts() ) : $query->the_post();

                                    $designer_ids[] =  get_the_ID();

                                    $output .= '<div class="designer-collection-item">';
                                        if(has_post_thumbnail()){
                                            $designer_image = get_the_post_thumbnail(get_the_ID(), 'full', array('class'=>"img-responsive"));
                                        }else{
                                            $designer_image = apply_filters('designer_placeholder', '<img src="'.THEME_IMG.'desingner-placeholder.png" alt="">');
                                        }
                                        $output .= sprintf(
                                                        '<a href="#" title="%s" class="designer-collection-link" data-id="%s">%s%s</a>',
                                                        __('Click on image to load products of the collection', THEME_LANG),
                                                        get_the_ID(),
                                                        $designer_image,
                                                        '<span><i class="fa fa-spinner fa-spin"></i></span>'
                                                    );                                        
                                        $output .= sprintf(
                                                        '<p class="info"><span class="name">%s</span>&nbsp;<span class="company">%s</span></p>',
                                                        get_the_title(),
                                                        rwmb_meta( '_kt_description' )
                                                    );
                                        $output .= rwmb_meta( '_kt_info' );
                                    $output .= '</div><!-- .designer-collection-item -->';

                                endwhile; wp_reset_postdata();

                            $output .= '</div><!-- .owl-carousel.kt-owl-carousel -->';
                        $output .= '</div><!-- .owl-carousel-wrapper -->';
                    $output .= '</div><!--.designer-collection-carousel -->';
                    
                    
                    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){

                        /// ------
                        $output .= '<div id="'.$id.'-products" class="col-md-9 col-sm-9 col-xs-12 designer-collection-woocommerce">';

                        foreach( $designer_ids as $designer_id ){
                            $output .= '<div class="designer-products designer-id-'.$designer_id.'">';

                                $args = array(
                        			'posts_per_page'	=> $num_products,
                        			'post_status' 		=> 'publish',
                        			'post_type' 		=> 'product',
                                    'meta_query' => array(
                                        array(
                                            'key'     => '_kt_designer',
                                            'value'   => $designer_id,
                                            'compare' => '=',
                                        ),
                                    ),
                        		);
                                $args =  apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) ;
                                $products = new WP_Query( $args );

                                global $woocommerce_loop;
                                $woocommerce_loop['columns'] =  $atts['columns'];
                                
                                if ( $products->have_posts() ) :
                                        $itemscustom = '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]';
                                        $output .= '<div class="woocommerce-carousel-wrapper" data-theme="carousel-heading-top style-navigation-bottom" data-itemscustom="'.$itemscustom.'">';
                                            ob_start();
                                            woocommerce_product_loop_start();
                                            while ( $products->have_posts() ) : $products->the_post();
                                                wc_get_template_part( 'content', 'product-normal' );
                                            endwhile; // end of the loop.
                                            woocommerce_product_loop_end();
                                            $output .= '<div class="woocommerce  columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
                                        $output .= '</div><!-- .woocommerce-carousel-wrapper -->';
                                endif;
                                wp_reset_postdata();

                            $output .= '</div><!--.designer-products -->';
                        }// end loop designers

                        $output .= '</div><!--.designer-collection-woocommerce -->';
                    }

                     // ----
                    
                $output .= '</div><!-- .row -->';
            } else{

            }
            wp_reset_postdata();

        $output .= '</div>';

    	return $output;
    }
}

vc_map( array(
    "name" => __( "Designer Collection Carousel", THEME_LANG),
    "base" => "designer_collection_carousel",
    "category" => __('by Cuongdv'),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Data source", THEME_LANG),
        	"param_name" => "source",
        	"value" => array(
                __('All', THEME_LANG) => '',
                __('Specific Designer', THEME_LANG) => 'posts',
        	),
            "admin_label" => true,
            'std' => '',
        	"description" => __("Select content type for your testimonials.", THEME_LANG)
        ),
        array(
			"type" => "kt_posts",
            'post_type' => 'designer',
			'heading' => __( 'Specific Posts', 'js_composer' ),
			'param_name' => 'posts',
            'multiple' => true,
            "dependency" => array("element" => "source","value" => array('posts')),
		),
        array(
    		'type' => 'textfield',
    		'heading' => __( 'How many designer to show ?', 'js_composer' ),
    		'param_name' => 'max_items',
    		'value' => 10, // default value
    		'param_holder_class' => 'vc_not-for-custom',
    		'description' => __( 'Set max limit for items  or enter -1 to display all (limited to 1000).', 'js_composer' )
    	),


        array(
            'type' => 'textfield',
            'heading' => __( 'How many products per designer to show ?', 'js_composer' ),
            'param_name' => 'num_products',
            'value' => 9, // default value
            'param_holder_class' => 'vc_not-for-custom',
            'description' => __( 'Set max limit for items or enter -1 to display all (limited to 1000).', 'js_composer' )
        ),

        array(
            "type" => "kt_heading",
            "heading" => __("Product Items to Show?", THEME_LANG),
            "param_name" => "items_show",
            "value" => "6",
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANG),
			"param_name" => "desktop",
			"value" => "4",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANG),
			"param_name" => "tablet",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANG),
			"param_name" => "mobile",
			"value" => "1",
			"min" => "1",
			"max" => "25",
			"step" => "1",
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
        
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
    ),
));