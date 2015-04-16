<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Mailchimp callback AJAX request 
 *
 * @since 1.0
 * @return json
 */

function wp_ajax_frontend_mailchimp_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    
    $output = array( 'error'=> 1, 'msg' => __('Error', THEME_LANGUAGE));
    $api_key = kt_option('mailchimp_api');
    $email = ($_POST['email']) ? $_POST['email'] : '';
    
    if ($email) {
        if(is_email($email)){
            if ( isset ( $api_key ) && !empty ( $api_key ) ) {
                $mcapi = new MCAPI($api_key);
                $opt_in = apply_filters('sanitize_boolean', $_POST['opt_in']);
                $mcapi->listSubscribe($_POST['list_id'], $email, null, 'html', $opt_in);
                 if($mcapi->errorCode) {
                    $output['msg'] = $mcapi->errorMessage;
                }else{
                    $output['error'] = 0;
                }
            }
        }else{
            $output['msg'] = __('Email address seems invalid.', THEME_LANGUAGE);
        }
    }else{
        $output['msg'] = __('Email address is required field.', THEME_LANGUAGE);
    }
    
    echo json_encode($output);
    die();
}


add_action( 'wp_ajax_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );
add_action( 'wp_ajax_nopriv_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );

/**
 * Desinger collection callback AJAX request 
 *
 * @since 1.0
 * @return json
 */
function wp_ajax_frontend_desinger_collection_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array();
    
    global $woocommerce_loop;
    $woocommerce_loop['columns'] = 1;
    
    $product_ids = rwmb_meta('kt_products', array('type' => 'post', 'multiple' => true), $_POST['desinger_id']);
    if(count($product_ids)){
        $meta_query = WC()->query->get_meta_query();
        $args = array(
			'posts_per_page'	=> -1,
			'post_status' 		=> 'publish',
			'post_type' 		=> 'product',
			'post__in'			=> array_merge( array( 0 ), $product_ids ),
            'meta_query' 		=> $meta_query,
		);
        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
        if ( $products->have_posts() ) :
                while ( $products->have_posts() ) : $products->the_post();
                    ob_start();
                    wc_get_template_part( 'content', 'product-normal' );
                    $output[] = ob_get_clean();
                endwhile; // end of the loop.
        endif;
        wp_reset_postdata();
    }
    
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_frontend_desinger_collection', 'wp_ajax_frontend_desinger_collection_callback' );
add_action( 'wp_ajax_nopriv_frontend_desinger_collection', 'wp_ajax_frontend_desinger_collection_callback' );

/**
 * Desinger collection callback AJAX request 
 *
 * @since 1.0
 * @return json
 */
function wp_ajax_fronted_woocategories_products_callback(){
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array();
    
    $atts = array(
        "per_page" => $_POST['per_page'],
        "orderby" => $_POST['orderby'],
        "order" => $_POST['order'],
    );
    
    global $woocommerce_loop;
    $woocommerce_loop['columns'] = 1;
    
    $cat_id = ($_POST['cat_id']) ? $_POST['cat_id'] : 0;
    
    
    if(defined( 'YITH_WOOCOMPARE' )){
        $YITH_Woocompare_Frontend = new YITH_Woocompare_Frontend();
    }
    
    
    $meta_query = WC()->query->get_meta_query();
    $args = array(
		'posts_per_page'	=> $atts['per_page'],
		'orderby' 			=> $atts['orderby'],
		'order' 			=> $atts['order'],
		'no_found_rows' 	=> 1,
		'post_status' 		=> 'publish',
		'post_type' 		=> 'product',
		'meta_query' 		=> $meta_query,
	);
    
    if($cat_id){
        $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $cat_id ) );
    }
    
    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
    if ( $products->have_posts() ) :
        while ( $products->have_posts() ) : $products->the_post();
            ob_start();
            wc_get_template_part( 'content', 'product' );
            $output[] = ob_get_clean();
        endwhile; // end of the loop.
    endif;
    wp_reset_postdata();
    
    echo json_encode($output);
    die();
}
add_action( 'wp_ajax_fronted_woocategories_products', 'wp_ajax_fronted_woocategories_products_callback' );
add_action( 'wp_ajax_nopriv_fronted_woocategories_products', 'wp_ajax_fronted_woocategories_products_callback' );

/**
 * Product Quick View callback AJAX request 
 *
 * @since 1.0
 * @return json
 */

function wp_ajax_frontend_product_quick_view_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    
    global $product, $woocommerce, $post;

	$product_id = $_POST["product_id"];
	
	$post = get_post( $product_id );

	$product = wc_get_product( $product_id );
    
    // Call our template to display the product infos
    wc_get_template( 'content-single-product-quick-view.php');
    
    
    die();
    
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );



add_action( 'wp_ajax_fronted_popup', 'wp_ajax_fronted_popup_callback' );
add_action( 'wp_ajax_nopriv_fronted_popup', 'wp_ajax_fronted_popup_callback' );

function wp_ajax_fronted_popup_callback() {
    check_ajax_referer( 'ajax_frontend', 'security' );
    $output = array();
    $time_show_again = kt_option( 'time_show_again', 60 );
    setcookie('kt_popup', 1, time() + ( $time_show_again*60), '/');
    echo json_encode($output);
    
    die();
}