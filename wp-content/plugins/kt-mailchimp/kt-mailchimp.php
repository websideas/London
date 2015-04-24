<?php
/*
Plugin Name: KT Mailchimp
Plugin URI: http://kutethemes.com
Description: Mailchimp form
Author: Cuongdv
Version: 1.0
Author URI: http://kutethemes.com
*/


// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
define( 'MAILCHIMP_VER', '1.0' );
define( 'MAILCHIMP_PATH', plugin_dir_path(__FILE__));
define( 'MAILCHIMP_URL', plugin_dir_url( __FILE__ ) );
define( 'MAILCHIMP_ASSETS', trailingslashit( MAILCHIMP_URL . 'assets' ) );

/**
 * Get Mailchimp API
 *
 */
require_once ( MAILCHIMP_PATH.'MCAPI.class.php' );

class KT_Mailchimp{
 
    public function __construct()
    {   
        // Add shortcode mailchimp
        add_shortcode('mailchimp', array($this, 'mailchimp_handler'));
        // Enqueue common styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
         
    }
 
    public function mailchimp_handler( $atts, $content )
    {   
        
        extract( shortcode_atts( array(
            'title' => '',
    		'list' => '',
    		'opt_in' => 'yes',
            'text_before' => '',
            'text_after' => '',
            'layout' => 'one',
            'desktop' => '',
            'tablet' => '',
            'mobile' => '',
            'css' => '',
        ), $atts ) );
        
        $elementClass = '';
        if(function_exists('vc_shortcode_custom_css_class')){
            $elementClass = vc_shortcode_custom_css_class( $css, ' ' );
        }
        
        $output = '';
        
        $options = get_option( 'kt_mailchimp_option' );
        
        if ( isset ( $options['api_key'] ) && !empty ( $options['api_key'] ) ) {
            
            if(!$content) 
                $content = __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', 'kt_mailchimp');
            
            $uniqeID    = uniqid();
            $output .= '<div class="mailchimp-wrapper '.esc_attr($elementClass).'" id="mailchimp-wrapper-'.$uniqeID.'">';
            
            if($title){
                $output .= '<div class="block-heading"><h3>'.$title.'</h3></div>';
            }
            
            $output .= ($text_before) ? '<div class="mailchimp-before">'.$text_before.'</div>' : '';
            
            $output .= '<form class="mailchimp-form clearfix mailchimp-layout-'.$layout.'" action="#" method="post">';
                $email = '<input name="email" class="form-control" required="" type="email" placeholder="'.__('E-mail address', THEME_LANG).'"/>';
                $button = '<button class="btn btn-default mailchimp-submit" data-loading="'.__('Loading ...', THEME_LANG).'" data-text="'.__('Subscribe', THEME_LANG).'"  type="submit">'.__('Subscribe', THEME_LANG).'</button>';
                if($layout == 'one'){
                    $text_repate = '<div class="input-group">%s<div class="input-group-btn">%s</div></div>'; 
                }else{
                    $text_repate = '<div class="mailchimp-input-email">%s</div><div class="mailchimp-input-button">%s</div>';
                }
                $output .= sprintf( $text_repate, $email, $button );
    			$output .= '<input type="hidden" name="action" value="signup"/>';
    			$output .= '<input type="hidden" name="list_id" value="'.$list.'"/>';
                $output .= '<input type="hidden" name="opt_in" value="'.$opt_in.'"/>';
                $output .= '<div class="mailchimp-success">'.$content.'</div>';
                $output .= '<div class="mailchimp-error"></div>';
            $output .= '</form>';
            $output .= ($text_after) ? '<div class="mailchimp-after">'.$text_after.'</div>' : '';
            $output .= '</div>';
        }
        
        $desktop = $desktop ? "@media (min-width: 992px) {#mailchimp-wrapper-{$uniqeID}{min-height: $desktop}}" : '';
        $tablet = $tablet ? "@media (max-width: 768px) {#mailchimp-wrapper-{$uniqeID}{min-height: $tablet}}" : '';
        $mobile = $mobile ? "@media (max-width: 480px) {#mailchimp-wrapper-{$uniqeID}{min-height: $mobile}}" : '';  
        
        $style = '<style>'.$desktop.$tablet.$mobile.'</style>';
        
    	return $output.$style;
        
    }
 
    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'kt-mailchimp', MAILCHIMP_ASSETS .'style.css', array('font-awesome', 'bootstrap-css'), MAILCHIMP_VER);
        wp_enqueue_script( 'kt-mailchimp', MAILCHIMP_ASSETS . 'script.js', array('jquery'), MAILCHIMP_VER, true );
        
        wp_localize_script( 'kt-mailchimp', 'ajax_mailchimp', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'security' => wp_create_nonce( 'ajax_mailchimp' )
        ));
        
                
    }
}
 
$kt_mailchimp = new KT_Mailchimp();





class KT_MailChimp_Settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->options = get_option( 'kt_mailchimp_option' );
        
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            __('KT MailChimp Settings', 'kt_mailchimp'), 
            __('KT MailChimp', 'kt_mailchimp'), 
            'manage_options', 
            'kt-mailchimp-settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        ?>
        <div class="wrap">  
            <h2><?php _e('Mail Chimp Settings', 'kt_mailchimp' ); ?></h2>     
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'kt_mailchimp_group' );   
                do_settings_sections( 'mailchimp-settings' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'kt_mailchimp_group', // Option group
            'kt_mailchimp_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'mailchimp-settings' // Page
        );  

        add_settings_field(
            'api_key', // ID
            __('Mail Chimp API Key', 'kt_mailchimp'), // Title 
            array( $this, 'api_key_callback' ), // Callback
            'mailchimp-settings', // Page
            'setting_section_id' // Section           
        );
        
        $api_key = $this->options['api_key'];
        if ( isset ( $api_key ) && !empty ( $api_key ) ) {
            add_settings_field(
                'email_lists', // ID
                __('Email Lists', 'kt_mailchimp'), // Title 
                array( $this, 'email_lists_callback' ), // Callback
                'mailchimp-settings', // Page
                'setting_section_id' // Section           
            );
            
            add_settings_field(
                'other_option', // ID
                __('Other option', 'kt_mailchimp'), // Title 
                array( $this, 'other_option_callback' ), // Callback
                'mailchimp-settings', // Page
                'setting_section_id' // Section           
            );
        }
        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        if( isset( $input['api_key'] ) )
            $new_input['api_key'] = sanitize_text_field( $input['api_key'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info(){}

    /** 
     * Get the settings option array and print one of its values
     */
    public function api_key_callback()
    {
        printf(
            '<input type="text" id="api_key" size="40" name="kt_mailchimp_option[api_key]" value="%s" />',
            isset( $this->options['api_key'] ) ? esc_attr( $this->options['api_key']) : ''
        );
        printf(
            '<p class="description">%s</p>',
            __('Enter your mail Chimp API key to enable a newsletter signup option with the registration form.', 'kt_mailchimp')
        );
    }
    public function email_lists_callback(){
        $api_key = $this->options['api_key'];
        if ( isset ( $api_key ) && !empty ( $api_key ) ) {
            $mcapi = new MCAPI($api_key);
        	$lists = $mcapi->lists();
            
            echo "<ul class='kt_mailchimp_lists'>";
            foreach ($lists['data'] as $key => $item) {
                printf(
                    '<li>%s<br/>%s</li>',
                    $item['name'],
                    '<input type="text" onclick="this.select()" style="font-weight:bold;text-align:left;" size="40" value="[mailchimp list='.$item['id'].']" readonly="readonly">'
                );
            }
            echo "</ul>";
            
            printf(
                '<p class="description">%s</p>',
                __('Place the short code shown below any list in a post or page to display the signup form, or use the dedicated widget.', 'kt_mailchimp')
            );
        }
    }
    
    public function other_option_callback(){
        echo "<ul class='kt_mailchimp_option'>";
        echo '<li><strong>'.__('Double Opt In', 'kt_mailchimp').'</strong> : opt_in="yes". ( EX: yes or no)</li>';
        echo '<li><strong>'.__('Layout', 'kt_mailchimp').'</strong> : opt_in="one" (EX: one, two)</li>';
        echo "</ul>";
    }
}

if( is_admin() )
    $kt_mailchimp_settings = new KT_MailChimp_Settings();






/**
 * Flag boolean.
 * 
 * @param $input string
 * @return boolean
 */
function kt_sanitize_boolean( $input = '' ) {
	return in_array($input, array('1', 'true', 'y', 'on'));
}

/**
 * Mailchimp callback AJAX request 
 *
 * @since 1.0
 * @return json
 */

function wp_ajax_frontend_mailchimp_callback() {
    check_ajax_referer( 'ajax_mailchimp', 'security' );
    
    $output = array( 'error'=> 1, 'msg' => __('Error', THEME_LANG));
    
    $options = get_option( 'kt_mailchimp_option' );
    
    $api_key = $options['api_key'];
    $email = ($_POST['email']) ? $_POST['email'] : '';
    
    if ($email) {
        if(is_email($email)){
            if ( isset ( $api_key ) && !empty ( $api_key ) ) {
                $mcapi = new MCAPI($api_key);
                $opt_in = apply_filters('kt_sanitize_boolean', $_POST['opt_in']);
                $mcapi->listSubscribe($_POST['list_id'], $email, null, 'html', $opt_in);
                 if($mcapi->errorCode) {
                    $output['msg'] = $mcapi->errorMessage;
                }else{
                    $output['error'] = 0;
                }
            }
        }else{
            $output['msg'] = __('Email address seems invalid.', THEME_LANG);
        }
    }else{
        $output['msg'] = __('Email address is required field.', THEME_LANG);
    }
    
    echo json_encode($output);
    die();
}


add_action( 'wp_ajax_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );
add_action( 'wp_ajax_nopriv_frontend_mailchimp', 'wp_ajax_frontend_mailchimp_callback' );