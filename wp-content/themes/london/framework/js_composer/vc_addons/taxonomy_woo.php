<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Taxonomy Woocommerce", THEME_LANG),
    "base" => "taxonomy_woo",
    "category" => __('by Theme-WI'),
    "description" => __( "Taxonomy Woocommerce", THEME_LANG),
    "params" => array(
        array(
            "type" => "taxonomy",
            "taxonomy" => "product_cat",
            "class" => "",
            "heading" => __("Category", THEME_LANG),
            "param_name" => "taxonomy",
            "value" => '',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", LANGUAGE_ZONE)
        ),
        array(
          "type" => "textfield",
          "heading" => __("Number Product", THEME_LANG),
          "param_name" => "number",
          "description" => __("Enter number of Product", THEME_LANG)
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order by",THEME_LANG),
        	"param_name" => "orderby",
        	"value" => array(
        		__('None', THEME_LANG) => 'none',
                __('ID', THEME_LANG) => 'ID',
                __('Author', THEME_LANG) => 'author',
                __('Name', THEME_LANG) => 'name',
                __('Date', THEME_LANG) => 'date',
                __('Modified', THEME_LANG) => 'modified',
                __('Rand', THEME_LANG) => 'rand'
        	),
            'std' => 'date',
        	"description" => __("Select how to sort retrieved posts.",THEME_LANG),
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order way",THEME_LANG),
        	"param_name" => "order",
        	"value" => array(
                __('ASC', THEME_LANG) => 'ASC',
                __('DESC', THEME_LANG) => 'DESC'
        	),
            'std' => 'DESC',
        	"description" => __("Designates the ascending or descending order.",THEME_LANG),
        ),
        array(
          "type" => "textarea_html",
          "heading" => __("Content", THEME_LANG),
          "param_name" => "content",
          "description" => __("Enter content of taxonomy", THEME_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
    ),
));



class WPBakeryShortCode_Taxonomy_Woo extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'taxonomy' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'number' => 10,
            'el_class' => '',
        ), $atts ) );
        global $woocommerce, $product, $woocommerce_loop, $post;
        
        $term = get_term( $taxonomy, 'product_cat' );
        $output = '';
        
        $output .= "<div class='module-category woocommerce clearfix'>";
            $output .= "<h3 class='cat-title'>".$term->name."</h3>";
            
            $args1 = array(
            	'parent'                   => $term->term_id,
            	'taxonomy'                 => 'product_cat',
            ); 
            
            $cat_item = get_categories($args1);
            
            $output .= "<div class='row'>";
                $output .= "<div class='col-md-3 col-sm-3'>";
                if($cat_item){
                    $output .= "<div class='cat-item'>";
                        $output .= "<ul class='cat-list'>";
                            $i=1;
                            foreach($cat_item as $item){
                                if( $i == 1 ){ $class = "class='active'"; }else{ $class = ""; }
                                $output .= "<li ".$class."><a data-order='".$order."' data-orderby='".$orderby."' data-id='".$item->term_id."' href='#'>".$item->name."<i class='fa fa-spinner fa-spin'></i></a></li>";
                            $i++;}
                            $output .= "<li><a data-order='".$order."' data-orderby='".$orderby."' data-id='".$term->term_id."' href='#'>All Categories<i class='fa fa-spinner fa-spin'></i></a></li>";
                        $output .="</ul>";
                        if($content){ $output .= "<div class='content-taxonomy'>".$content."</div>"; }
                    $output .= "</div>";
                }
                $output .= "</div>";
    		$args = array(
    			'posts_per_page'	=> $number,
    			'orderby' 			=> $orderby,
    			'order' 			=> $order,
                'tax_query' => array(
                            		array(
                            			'taxonomy' => 'product_cat',
                            			'field' => 'slug',
                            			'terms' => $cat_item[0]->slug
                            		)
                            	)
    		);
            
            ob_start();
            
            $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

    		if ( $products->have_posts() ) : ?>
                <div class="col-md-9 col-sm-9">
                    <div class="module-product">
            			<?php woocommerce_product_loop_start(); ?>
            
            				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
            
            					<?php wc_get_template_part( 'content', 'product' ); ?>
            
            				<?php endwhile; // end of the loop. ?>
            
            			<?php woocommerce_product_loop_end(); ?>
                    </div>
                </div>
    		<?php endif; wp_reset_postdata();
            
            $output .= ob_get_clean();
            
            $output .= "</div>";   
        $output .= "</div>";   
        
        return $output;
    }
}