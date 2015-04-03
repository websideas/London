<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Recent_Posts_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'category' => '',
            'number' => 10,
            'desktop' => 5,
            'tablet' => 3,
            'mobile' => 2,
            'el_class' => '',
        ), $atts ) );
        
        if($taxonomy){
            $taxonomyArr = array( array(
                			'taxonomy' => 'category',
                            'field' => 'term_id',
                			'terms' => explode(",", $taxonomy)
                		));
    	}
        $args = array(
            'posts_per_page'=> $number,
            'tax_query' => $taxonomyArr,
            'ignore_sticky_posts' => true
    	);
        
        $el_class = $this->getExtraClass($el_class);
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'recent-posts-carousel-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
        
        $output = '';
        $output .= '<div class="'.esc_attr( $css_class ).'">';
            $heading_class = apply_filters('js_composer_heading', 'block-heading recent-posts-heading');
            $heading_class = apply_filters('recent_posts_heading', $heading_class);
            $output .= ($title) ? '<h3 class="'.esc_attr($heading_class).'">'.$title.'</h3>' : '';
            
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
                $output .= '<div class="owl-carousel-wrapper">';
                $output .= '<div class="owl-carousel kt-owl-carousel" data-pagination="false" data-theme="style-navigation-top" data-itemscustom="[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]">';
                while ( $query->have_posts() ) : $query->the_post();
                    $output .= '<div class="recent-posts-item">';
                        $output .= '<a href="'.get_permalink().'">';
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
            "type" => "kt_taxonomy",
            "taxonomy" => "category",
            "class" => "",
            "heading" => __("Category", THEME_LANGUAGE),
            "param_name" => "category",
            "value" => '',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", LANGUAGE_ZONE)
        ),
        array(
          "type" => "kt_number",
          "heading" => __("Number Post", THEME_LANGUAGE),
          "param_name" => "number",
          "value" => 10,
          "description" => __("How many Posts you would like to show? ( -1 means unlimited )", THEME_LANGUAGE)
        ),
        array(
          "type" => "kt_heading",
          "heading" => __("Items to Show?", THEME_LANGUAGE),
          "param_name" => "items_show",
          "value" => "6",
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