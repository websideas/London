<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Sales_Countdown_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'number' => 10,
            'the_excerpt_length' => '',
            'desktop' => 2,
            'tablet' => 1,
            'mobile' => 1,
            'el_class' => '',
        ), $atts ) );
        $output = '';
        
        global $woocommerce_loop;
        $woocommerce_loop['columns'] = 1;
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'sales-countdown-carousel-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        // Get products on sale
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        
        $args = array(
			'posts_per_page'	=> $number,
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product',
			'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
		);
        
        
        
        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
        
		if ( $products->have_posts() ) :
        
            $output .= '<div class="'.esc_attr( $css_class ).'">';
                $heading_class = apply_filters('js_composer_heading', 'block-heading sales-countdown-carousel-heading');
                $heading_class = apply_filters('woocommerce_sales_countdown_carousel_heading', $heading_class);
                $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
            $itemscustom = '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]';
            $output .= '<div class="woocommerce-carousel-wrapper" data-itemscustom="'.$itemscustom.'">';
            
            ob_start();
                
            woocommerce_product_loop_start();
            while ( $products->have_posts() ) : $products->the_post();
                wc_get_template_part( 'content', 'product-sale' );
            endwhile; // end of the loop.
            woocommerce_product_loop_end();
            
            $output .= '<div class="woocommerce  columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
            $output .= '</div><!-- .woocommerce-carousel-wrapper -->';
            $output .= '</div>'; 
            
        endif;

		wp_reset_postdata();

    	return $output;
    }
}

vc_map( array(
    "name" => __( "Sales Countdown Carousel", THEME_LANGUAGE),
    "base" => "sales_countdown_carousel",
    "category" => __('by Cuongdv'),
    "description" => __( "", THEME_LANGUAGE),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "description" => __( "Title", THEME_LANGUAGE ),
            "admin_label" => true,
        ),
        array(
          "type" => "kt_number",
          "heading" => __("Number Post", THEME_LANGUAGE),
          "param_name" => "number",
          "value" => 10,
          "description" => __("Enter number of Post", THEME_LANGUAGE)
        ),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANGUAGE),
          "param_name" => "items_show",
        ),
        array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Desktop", THEME_LANGUAGE),
			"param_name" => "desktop",
			"value" => "5",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Tablet", THEME_LANGUAGE),
			"param_name" => "tablet",
			"value" => "3",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
		array(
			"type" => "kt_number",
			"class" => "",
			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
			"heading" => __("On Mobile", THEME_LANGUAGE),
			"param_name" => "mobile",
			"value" => "2",
			"min" => "1",
			"max" => "25",
			"step" => "1",
	  	),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        )
    ),
));

