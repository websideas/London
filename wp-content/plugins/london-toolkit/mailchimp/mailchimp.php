<?php

// Prevent loading this file directly
if ( !defined('ABSPATH')) exit;

define( 'MAILCHIMP_VER', '1.0' );
define( 'MAILCHIMP_PATH', trailingslashit( plugin_dir_path(__FILE__)) );
define( 'MAILCHIMP_URL', trailingslashit( plugin_dir_url( __FILE__ )) );
define( 'MAILCHIMP_ASSETS', trailingslashit( MAILCHIMP_URL . 'assets' ) );


/**
 * Get Mailchimp API
 *
 */
require_once ( MAILCHIMP_PATH.'MCAPI.class.php' );

class KT_Mailchimp{
    
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    
    private $uniqeID;
    
    private $atts;
    
    public function __construct()
    {   
        
        $this->options = get_option( 'kt_mailchimp_option' );
        $this->uniqeID  = uniqid();
        
        // Add shortcode mailchimp
        add_shortcode('mailchimp', array($this, 'mailchimp_handler'));
        // Enqueue common styles and scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
        // Add custom style to footer
        add_action( 'wp_footer', array( $this, 'wp_footer' ) );
        // Add ajax for frontend
        add_action( 'wp_ajax_frontend_mailchimp', array( $this, 'frontend_mailchimp_callback') );
        add_action( 'wp_ajax_nopriv_frontend_mailchimp', array( $this, 'frontend_mailchimp_callback') );
        
        if ( !$this->options['api_key'] ) {
            add_action( 'admin_notices', array( $this, 'admin_notice' ));
        }
        
    }
    function wp_footer(){
        $style = '';
        
        $desktop = $this->atts['desktop'] ? "@media (min-width: 992px) {#mailchimp-wrapper-{$this->uniqeID}{min-height: {$this->atts['desktop']}}}" : '';
        $tablet = $this->atts['tablet'] ? "@media (max-width: 768px) {#mailchimp-wrapper-{$this->uniqeID}{min-height: {$this->atts['tablet']}}}" : '';
        $mobile = $this->atts['mobile'] ? "@media (max-width: 480px) {#mailchimp-wrapper-{$this->uniqeID}{min-height: {$this->atts['mobile']}}}" : '';  
        $style = $desktop.$tablet.$mobile;
        if($style){
            $style = "<div><style type='text/css'>{$style}</style></div>";    
        }
        echo $style;
    }
    function admin_notice() {
        
        ?>
        <div class="updated">
            <p><?php 
                printf( 
                    __('Please enter Mail Chimp API Key in <a href="%s">here</a>', 'kt_mailchimp' ),
                    admin_url( 'options-general.php?page=kt-mailchimp-settings')
                ); 
            ?></p>
        </div>
        <?php
    }

    public function mailchimp_handler( $atts, $content )
    {   
        
        $atts = shortcode_atts( array(
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
        ), $atts );
        
        extract( $atts );
        
        $elementClass = '';
        if(function_exists('vc_shortcode_custom_css_class')){
            $elementClass = vc_shortcode_custom_css_class( $css, ' ' );
        }
        
        
        $this->atts = $atts;
        
        
        
        
        $output = '';
        
        $output .= '<div class="mailchimp-wrapper '.esc_attr($elementClass).'" id="mailchimp-wrapper-'.$this->uniqeID.'">';
        
        if($title){
            $output .= '<div class="block-heading"><h3>'.$title.'</h3></div>';
        }
        $output .= ($text_before) ? '<div class="mailchimp-before">'.$text_before.'</div>' : '';
        
        
        if ( isset ( $this->options['api_key'] ) && !empty ( $this->options['api_key'] ) ) {
            
            if(!$content) 
                $content = __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', 'kt_mailchimp');
            
            $output .= '<form class="mailchimp-form clearfix mailchimp-layout-'.$layout.'" action="#" method="post">';
                $email = '<input name="email" class="form-control" required="" type="email" placeholder="'.__('E-mail address', 'kt_mailchimp').'"/>';
                $button = '<button class="btn btn-default mailchimp-submit" data-loading="'.__('Loading ...', 'kt_mailchimp').'" data-text="'.__('Subscribe', 'kt_mailchimp').'"  type="submit">'.__('Subscribe', 'kt_mailchimp').'</button>';
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
            
        }else{
            $output .= sprintf(
                            "Please enter your mailchimp API key in <a href='%s'>here</a>",
                            admin_url( 'options-general.php?page=kt-mailchimp-settings')
                        );
        }
        
        $output .= ($text_after) ? '<div class="mailchimp-after">'.$text_after.'</div>' : '';
        $output .= '</div><!-- .mailchimp-wrapper -->';
        
    	return $output;
        
    }
 
    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'kt-mailchimp', MAILCHIMP_ASSETS .'style.css', array('font-awesome', 'bootstrap-css'), MAILCHIMP_VER);
        wp_enqueue_script( 'kt-mailchimp', MAILCHIMP_ASSETS . 'script.js', array('jquery'), MAILCHIMP_VER, true );
        
        wp_localize_script( 'kt-mailchimp', 'ajax_mailchimp', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'security' => wp_create_nonce( 'ajax_mailchimp' )
        ));
    }
    
    
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
    
    function frontend_mailchimp_callback() {
        check_ajax_referer( 'ajax_mailchimp', 'security' );
        
        $output = array( 'error'=> 1, 'msg' => __('Error', 'kt_mailchimp'));
        
        $api_key = $this->options['api_key'];
        $email = ($_POST['email']) ? $_POST['email'] : '';
        
        if ($email) {
            if(is_email($email)){
                if ( isset ( $api_key ) && !empty ( $api_key ) ) {
                    $mcapi = new MCAPI($api_key);
                    $opt_in = apply_filters(array($this, 'kt_sanitize_boolean'), $_POST['opt_in']);
                    $mcapi->listSubscribe($_POST['list_id'], $email, null, 'html', $opt_in);
                     if($mcapi->errorCode) {
                        $output['msg'] = $mcapi->errorMessage;
                    }else{
                        $output['error'] = 0;
                    }
                }
            }else{
                $output['msg'] = __('Email address seems invalid.', 'kt_mailchimp');
            }
        }else{
            $output['msg'] = __('Email address is required field.', 'kt_mailchimp');
        }
        
        echo json_encode($output);
        die();
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
            __('Settings', 'kt_mailchimp'), // Title
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



if ( class_exists( 'Vc_Manager', false ) ) {
    
    $options = get_option( 'kt_mailchimp_option' );
    $api_key = $options['api_key'];
    $lists_arr = array();
     
    if ( isset ( $api_key ) && !empty ( $api_key ) ) {
        $mcapi = new MCAPI($api_key);
    	$lists = $mcapi->lists();
        if($lists['data']){
            foreach ($lists['data'] as $item) {
                $lists_arr[$item['name']] = $item['id'];
            }
        }
    }
    
    vc_map( array(
        "name" => __( "Mailchimp", 'kt_mailchimp'),
        "base" => "mailchimp",
        "category" => __('by Theme', 'kt_mailchimp' ),
        "description" => __( "Mailchimp", 'kt_mailchimp'),
        "wrapper_class" => "clearfix",
        "params" => array(
			array(
                "type" => "textfield",
                "heading" => __( "Title", 'kt_mailchimp' ),
                "param_name" => "title",
                "description" => __( "Mailchimp title", 'kt_mailchimp' ),
                "admin_label" => true,
            ),
            array(
            	'type' => 'dropdown',
            	'heading' => __( 'Newsletter layout', 'kt_mailchimp' ),
            	'param_name' => 'layout',
            	'admin_label' => true,
            	'value' => array(
            		__( 'One line', 'kt_mailchimp' ) => 'one',
            		__( 'Two line', 'kt_mailchimp' ) => "two"
            	),
            	'description' => __( 'Select your layout', 'kt_mailchimp' )
            ),
            array(
            	'type' => 'dropdown',
            	'heading' => __( 'Newsletter layout', 'kt_mailchimp' ),
            	'param_name' => 'list',
            	'admin_label' => true,
            	'value' => $lists_arr,
            	'description' => __( 'Select your layout', 'kt_mailchimp' )
            ),
            array(
                "type" => 'checkbox',
                "heading" => __( 'Double opt-in', 'kt_mailchimp' ),
                "param_name" => 'opt_in',
                "description" => __("", 'kt_mailchimp'),
                "value" => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            ),
            array(
              "type" => "textarea",
              "heading" => __("Text before form", 'kt_mailchimp'),
              "param_name" => "text_before",
              "description" => __("", 'kt_mailchimp')
            ),
            array(
              "type" => "textarea",
              "heading" => __("Text after form", 'kt_mailchimp'),
              "param_name" => "text_after",
              "description" => __("", 'kt_mailchimp')
            ),
            array(
              "type" => "textarea_html",
              "heading" => __("Success Message", 'kt_mailchimp'),
              "param_name" => "content",
              'value' => __('Success!  Check your inbox or spam folder for a message containing a confirmation link.', 'kt_mailchimp'), 
              "description" => __("", 'kt_mailchimp')
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
              "type" => "kt_heading",
              "heading" => __("Min height for item", 'kt_mailchimp'),
              "param_name" => "items_show",
              "description" => __("Please include unit it. (Ex. 300px). ", 'kt_mailchimp')
            ),
            array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Desktop", 'kt_mailchimp'),
    			"param_name" => "desktop",
    	  	),
    		array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Tablet", 'kt_mailchimp'),
    			"param_name" => "tablet",
    			"step" => "5",
    	  	),
    		array(
    			"type" => "textfield",
    			"class" => "",
    			"edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
    			"heading" => __("On Mobile", 'kt_mailchimp'),
    			"param_name" => "mobile",
    	  	),
            array(
    			'type' => 'css_editor',
    			'heading' => __( 'Css', 'js_composer' ),
    			'param_name' => 'css',
    			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    			'group' => __( 'Design options', 'js_composer' )
    		),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", "js_composer"),
                "param_name" => "el_class",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            ),
		)
	) );
}
