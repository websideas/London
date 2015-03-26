<?php


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


function woocommerce_get_cart(){
    $output = '';
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        // Put your plugin code here
        global $woocommerce;
        $cart_total = $woocommerce->cart->get_cart_total();
		$cart_count = $woocommerce->cart->cart_contents_count;
        
        $output .= '<div class="shopping_cart">';
            $output .= '<a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="'.__("View my shopping cart", THEME_LANG).'">'.$cart_total.'</a>';
            
            $output .= '<div class="shopping-bag">';
            $output .= '<div class="shopping-bag-wrapper mCustomScrollbar">';
            $output .= '<div class="shopping-bag-content">';
                if ( sizeof($woocommerce->cart->cart_contents)>0 ) {
                    $output .= '<div class="bag-products">';
                    foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {
                        $bag_product = $cart_item['data']; 
                        
                        if ($bag_product->exists() && $cart_item['quantity']>0) {
                            $output .= '<div class="bag-product clearfix">';
        					$output .= '<figure><a class="bag-product-img" href="'.get_permalink($cart_item['product_id']).'">'.$bag_product->get_image().'</a></figure>';                      
        					$output .= '<div class="bag-product-details">';
            					$output .= '<div class="bag-product-title"><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $bag_product->get_title(), $bag_product) . '</a></div>';
            					$output .= '<div class="bag-product-price">'.woocommerce_price($bag_product->get_price()).'</div>';
                                $output .= '<div class="bag-product-qty">'.__('Qty: ', THEME_LANG).$cart_item['quantity'].'</div>';
                                
        					$output .= '</div>';
        					$output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"></a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key );
        					
        					$output .= '</div>';
                        }
                    }
                    $output .= '</div>';
                }else{
                   $output .=  "<p class='cart_block_no_products'>".__('No products', THEME_LANG)."</p>"; 
                }
                
                $output .= '<div class="bag-total">'.__('Cart subtotal: ', THEME_LANG).$cart_total.'</div><!-- .bag-total -->';
                
                $output .= '<div class="bag-buttons clearfix">';
                    $output .= '<a href="'.esc_url( $woocommerce->cart->get_cart_url() ).'" class="btn btn-default btn-round pull-left">'.__('View cart', THEME_LANG).'</a>';
                    $output .= '<a href="'.esc_url( $woocommerce->cart->get_checkout_url() ).'" class="btn btn-default btn-round pull-left">'.__('Checkout', THEME_LANG).'</a>';
                $output .= '</div><!-- .bag-buttons -->';
            
            $output .= '</div><!-- .shopping-bag-content -->';
            $output .= '</div><!-- .shopping-bag-wrapper -->';
            $output .= '</div><!-- .shopping-bag -->';
            $output .= "<script type='text/javascript'>jQuery('.mCustomScrollbar').mCustomScrollbar();</script>";
        $output .= '</div><!-- .shopping_cart -->';
        
        
        
    }
    return $output;
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment'); 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
    $fragments['.shopping_cart'] = woocommerce_get_cart();
	return $fragments;
}







/**
 * Woocommerce replace before main content and after main content
 * 
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'london_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'london_wrapper_end', 10);

function london_wrapper_start() {
  echo '<div class="content-wrapper"><div class="container">';
}

function london_wrapper_end() {
  echo '</div><!-- .container --></div>';
}





/**
 * Woocommerce breadcrumb change order and navigation pipe
 * 
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 5, 0);

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
        'delimiter' => '<span class="navigation-pipe">&#47;</span>',
        'wrap_before' => '<div class="woocommerce-breadcrumb-wrapper"><div class="container"><nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after' => '</nav></div></div>',
        'before' => '',
        'after' => '',
        'home' => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
        
} 


/**
 * Change number or products per row to 3
 * 
 */

add_filter( 'loop_shop_columns', 'london_woo_shop_columns' );
function london_woo_shop_columns( $columns ) {
    if(is_shop()){
        return 4;
    }elseif(is_product_category()){
        return 3;
    }elseif(is_product_tag()){
        return 3;
    }
    return $columns;
}

/**
 * Change layout of archive product
 * 
 */
add_filter( 'archive_product_layout', 'london_archive_product_layout' );
function london_archive_product_layout( $columns ) {
    //fullwidth, sidebar-left, sidebar-right
    if(is_shop()){
        return 'fullwidth';
    }elseif(is_product_category()){
        return 'sidebar-left';
    }elseif(is_product_tag()){
        return 'sidebar-right';
    }
}


/**
 * Change layout of single product
 * 
 */
add_filter( 'single_product_layout', 'london_single_product_layout' );
function london_single_product_layout( $columns ) {
    //fullwidth, sidebar-left, sidebar-right
    return 'fullwidth';
}


/**
 * Change hook of archive-product.php
 * 
 */

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0);
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20, 0);

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0);
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 12, 0);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5, 0);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10, 0);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 0);

add_action( 'woocommerce_shop_loop_item_image', 'woocommerce_template_loop_product_thumbnail', 5, 0);
add_action( 'woocommerce_shop_loop_item_after_image', 'woocommerce_template_loop_add_to_cart', 5, 0);
add_action( 'woocommerce_shop_loop_item_action', 'theme_action_add', 10, 0);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10, 0);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 20, 0);

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10, 0);
add_action( 'woocommerce_shop_loop_item_after_image', 'woocommerce_show_product_loop_sale_flash', 10, 0);


function theme_action_add(){
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    echo do_shortcode('[yith_compare_button]');
}
/**
 * Change hook of single-product.php
 * 
 */

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10, 0);
add_action( 'woocommerce_after_single_product_content', 'woocommerce_output_product_data_tabs', 10, 0);

add_filter('woocommerce_product_description_heading', 'london_woocommerce_product_description_heading');
function london_woocommerce_product_description_heading(){
    return "";
}

