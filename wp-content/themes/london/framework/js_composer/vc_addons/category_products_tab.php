<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Category_Products_Tab extends WPBakeryShortCode {

    /**
     * woocommerce_order_by_rating_post_clauses function.
     *
     * @param array $args
     * @return array
     */
    public static function order_by_rating_post_clauses( $args ) {
        global $wpdb;

        $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

        $args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

        $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }

    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'category' => '',
            'per_page' => 12,
            'columns' => 4,
            'border_heading' => '',
            'css_animation' => '',
            'el_class' => '',
            'css' => '',   
        ), $atts );
        extract($atts);

        global $woocommerce_loop;
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'category-products-tab-wrapper ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        
        $tabs = array(
            'new-arrivals' => __( 'New Arrivals',THEME_LANG ),
            'best-sellers' => __( 'Best Sellers',THEME_LANG ),
            'top-rated' => __( 'Most Reviews',THEME_LANG ),
        );
        
        $output = '';
        
        $uniqeID    = uniqid();
        if($category){
            
            $term = get_term( $category, 'product_cat' );

            $output .= '<div class="'.esc_attr( $elementClass ).'">';
                
                $heading_class = "block-heading";
                if($border_heading){
                    $heading_class .= " block-heading-underline";
                }
                $output .= '<div class="'.esc_attr($heading_class).' block-heading-tabs-wapper clearfix">';
                    $output .= sprintf(
                        '<h3>%s %s</h3>',
                        '<a class="heading-nav-bar" href="#"><span class="heading-nav-handle"><span></span></span></a>',
                        $term->name
                    );

                    $output .= "<div class='block-heading-tabs-content'><ul class='block-heading-tabs'>";
                        foreach( $tabs as $k=>$v ){
                            $output .= "<li><a href='#tab-".$k.'-'.$uniqeID."'>".$v."</a></li>";
                        }
                    $output .= "</ul></div>";
                $output .= "</div>";
                
                $meta_query = WC()->query->get_meta_query();
                $args = array(
        			'post_type'				=> 'product',
        			'post_status'			=> 'publish',
        			'ignore_sticky_posts'	=> 1,
        			'posts_per_page' 		=> $atts['per_page'],
        			'meta_query' 			=> $meta_query,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'id',
                            'terms'    => $category,
                        ),
                    ),
        		);




                
                $output .= "<div class='category-products-tabs'>";
                foreach($tabs as $key => $tab){
                    $newargs = $args;
                    if( $key == 'new-arrivals' ){
                        $newargs['orderby'] = 'date';
                        $newargs['order'] 	 = 'DESC';
                    }elseif( $key == 'best-sellers' ){
                        $newargs['meta_key']   = 'total_sales';
                        $newargs['orderby'] 	= 'meta_value_num';
                    }
                    
                    $output .= "<div id='tab-".$key.'-'.$uniqeID."' class='category-products-tab'>";
                        ob_start();

                        if($key == 'top-rated'){
                            add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
                        }

                        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $newargs, $atts ) );

                        if($key == 'top-rated'){
                            remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
                        }

                        $woocommerce_loop['columns'] = $atts['columns'];
                        if ( $products->have_posts() ) :
                            woocommerce_product_loop_start();
                            while ( $products->have_posts() ) : $products->the_post();
                                wc_get_template_part( 'content', 'product' );
                            endwhile; // end of the loop.
                            woocommerce_product_loop_end();
                        endif;
                        wp_reset_postdata();
                        $output .= '<div class="woocommerce  columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
                    $output .= "</div><!-- .category-products-tab -->";
                    
                    
                }
                $output .= "</div><!-- .category-products-tabs -->";
                
            
            $output .= "</div><!-- .category-products-tab-wrapper -->";

        }
        
        return $output;
    }
}



vc_map( array(
    "name" => __( "Category Products Tab", THEME_LANG),
    "base" => "category_products_tab",
    "category" => __('by Theme', THEME_LANG ),
    "params" => array(
        array(
			"type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
			'heading' => __( 'Category', 'js_composer' ),
			'param_name' => 'category'
		),
        array(
			'type' => 'checkbox',
			'heading' => __( 'Border in heading', THEME_LANG ),
			'param_name' => 'border_heading',
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'true' ),
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Per page', 'js_composer' ),
			'value' => 12,
			'param_name' => 'per_page',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Columns', 'js_composer' ),
			'value' => 4,
			'param_name' => 'columns',
			'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
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
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
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
