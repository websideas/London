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
    $api_key = themedev_option('mailchimp_api');
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
    die(); // this is required to return a proper result
}


add_action( 'wp_ajax_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );
add_action( 'wp_ajax_nopriv_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );




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

	$product = get_product( $product_id );
    
    
    // Call our template to display the product infos
	woocommerce_get_template( 'content-single-product-quick-view.php'); 
    
    
    die();
    
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );




