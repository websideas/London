<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Category_Products_Tab extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'taxonomy' => '',
            'number' => 10,
            'columns' => 4,
            'el_class' => '',
        ), $atts ) );

        global $woocommerce_loop;
        
        $tabs = array( 
            'new-arrivals' => __( 'New Arrivals',THEME_LANGUAGE ),
            'best-sellers' => __( 'Best Sellers',THEME_LANGUAGE ) 
        );
        
        $rand = rand();
        $term = get_term( $taxonomy, 'product_cat' );
        
        $output = '';
        if($term->name){
            $name_tax = $term->name;
        }else{
            $name_tax = 'All';
        }
        $output .= "<div class='module-products-tab woocommerce'>";
            $output .= "<div class='products-tabs'>";
                $output .= "<h3 class='cat-title'>".$name_tax;
                    $output .= "<ul class='clearfix'>";
                        foreach( $tabs as $k=>$v ){
                            $output .= "<li><a href='#tabs-".$k.$rand."'>".$v."</a></li>";
                        }
                    $output .= "</ul>";
                $output .= "</h3>";
                
                $args_tax = array(
                    'parent' => '0'
                );
                $terms = get_terms( 'product_cat',$args_tax);
                if($terms){
                    $term_id = array();
                    foreach( $terms as $item ){
                        $term_id[] = $item->term_id;
                    }
                }
                if($taxonomy == ''){
                    $taxonomy = $term_id;
                }
                
                $args = array(
        			'posts_per_page'	=> $number,
                    'post_type'         => 'product',
                    'tax_query'         => array(
                                    		array(
                                    			'taxonomy' => 'product_cat',
                                    			'field' => 'id',
                                    			'terms' => $taxonomy
                                    		)
                                    	)
        		);
                
                foreach( $tabs as $k=>$v ){
                    if( $k == 'new-arrivals' ){
                        $args['orderby'] = 'date';
                        $args['order'] 	 = 'DESC';
                    }elseif( $k == 'best-sellers' ){
                        $args['meta_key']   = 'total_sales';
                        $args['orderby'] 	= 'meta_value_num';
                    }
                    $output .= "<div id='tabs-".$k.$rand."'>";
                        ob_start();
                        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
                        $woocommerce_loop['columns'] = $atts['columns']; ?>
                        <div class='woocommerce columns-<?php echo $atts['columns']; ?>'><?php
                            
                    		if ( $products->have_posts() ) : ?>
                        			<?php woocommerce_product_loop_start(); ?>
                        
                        				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
                        
                        					<?php wc_get_template_part( 'content', 'product' ); ?>
                        
                        				<?php endwhile; // end of the loop. ?>
                        
                        			<?php woocommerce_product_loop_end(); ?>
                    		<?php endif; wp_reset_postdata(); ?>
                            
                        </div><?php
                        $output .= ob_get_clean();
                    $output .= "</div>";
                }
            $output .= "</div>";
        $output .= "</div>";    
        
        return $output;
    }
}



vc_map( array(
    "name" => __( "Category Product Tab", THEME_LANGUAGE),
    "base" => "category_products_tab",
    "category" => __('by Cuongdv'),
    "params" => array(
        array(
            "type" => "taxonomy",
            "taxonomy" => "product_cat",
            "class" => "",
            "heading" => __("Category", THEME_LANGUAGE),
            "param_name" => "taxonomy",
            "value" => '',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", LANGUAGE_ZONE)
        ),
        array(
          "type" => "textfield",
          "heading" => __("Number Post", THEME_LANGUAGE),
          "param_name" => "number",
          "description" => __("Enter number of Post", THEME_LANGUAGE)
        ),
        array(
          "type" => "textfield",
          "heading" => __("Columns", THEME_LANGUAGE),
          "param_name" => "columns",
          "description" => __("Enter columns of Post", THEME_LANGUAGE)
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
    ),
));
