<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( ! class_exists( 'KiteThemes_config' ) ) {
    class KiteThemes_config{
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }
        }
        
        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }
            
            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }
        
        
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => THEME_OPTIONS,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => true,
                // Show the sections below the admin menu item or not
                'menu_title'           => __( 'Theme Options', THEME_LANG ),
                
                'page_title'           => __( 'Theme Options - '.$theme->get( 'Name' ), THEME_LANG ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => true,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'kitethemes_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Like us on Facebook', THEME_LANG),
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Follow us on Twitter', THEME_LANG),
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => '#',
                'title' => __('Find us on LinkedIn', THEME_LANG),
                'icon'  => 'el-icon-linkedin'
            );
            
        }
        
        public function setSections() {
            
            //icon_refresh 
            
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'id' 	=> 'general',
                'title'  => __( 'General', THEME_LANG ),
                'desc'   => __( 'Welcome to the Simple Options Framework Demo', THEME_LANG ),
                'icon_class'	=> 'icon_cogs',
				'icon'			=> '',
                'fields' => array(
                    array(
                        'id'       => 'opt-web-fonts',
                        'type'     => 'media',
                        'title'    => __( 'Web Fonts', THEME_LANG ),
                        'compiler' => 'true',
                        'mode'     => false,
                        // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'     => __( 'Basic media uploader with disabled URL input field.', THEME_LANG ),
                        'subtitle' => __( 'Upload any media using the WordPress native uploader', THEME_LANG ),
                    )
                )
            );
            
            /**
				Top bar
			**/
			$this->sections[] = array(
				'id'			=> 'topbar',
				'title'			=> __( 'Top bar', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_tool',
				'icon'			=> '',
				'fields'		=> array(
                    
                    array(
                        'id'       => 'topbar',
                        'type'     => 'switch',
                        'title'    => __( 'Top Bar', 'redux-framework-demo' ),
                        'subtitle' => __( 'Look, it\'s on!', 'redux-framework-demo' ),
                        'default'  => true,
                    ),
                    
                    array(
                        'id'       => 'topbar-social-demo',
                        'type'     => 'social',
                        'title'    => __( 'Top Bar', 'redux-framework-demo' ),
                        'subtitle' => __( 'Look, it\'s on!', 'redux-framework-demo' ),
                        'options'  => array(
                            'facebook' => array( 'icon' => 'fa fa-facebook','title' => 'Facebook'),
                            'twitter' => array( 'icon' => 'fa fa-twitter','title' => 'Twitter'),
                            'google' => array( 'icon' => 'fa fa-google','title' => 'Google'),
                            'google_plus' => array( 'icon' => 'fa fa-google-plus','title' => 'Google Plus'),
                            'instagram' => array( 'icon' => 'fa fa-instagram','title' => 'Instagram'),
                            'pinterest' => array( 'icon' => 'fa pinterest-p','title' => 'Pinterest'),
                        ),
                        'default' => array(
                            'facebook' => 'http://facebook.com/',
                            'twitter' => 'http://facebook.com/',
                            'instagram' => 'http://instagram.com/',
                            'pinterest' => 'http://pinterest.com/'
                        )
                    ),
                    
                    
                    array(
                        'id'       => 'topbar-visibility',
                        'type'     => 'select_sortable',
                        'title'    => __( 'Top Bar Visibility', 'redux-framework-demo' ),
                        'subtitle'     => __( 'Select your visibility.', 'redux-framework-demo' ),
                        'options'  => array(
                            'visible' => __('Always Visible', 'redux-framework-demo' ),
                            'visible-md-block' => __('Visible Desktops', 'redux-framework-demo' ),
                            'visible-sm-block' => __('Visible Tablets', 'redux-framework-demo' ),
                            'visible-xs-block' => __('Visible Phones', 'redux-framework-demo' ),
                            'hidden-md' => __('Hidden Desktops', 'redux-framework-demo' ),
                            'hidden-sm' => __('Hidden Tablets', 'redux-framework-demo' ),
                            'hidden-xs' => __('Hidden Phones', 'redux-framework-demo' )
                        ),
                        'default'  => 'visible-md-block',
                        'clear' => false
                    ),
                    
                    array(
                        'id'       => 'topbar-style',
                        'type'     => 'select',
                        'title'    => __( 'Top Bar Style', 'redux-framework-demo' ),
                        'subtitle'     => __( 'Select your preferred top bar style.', 'redux-framework-demo' ),
                        'options'  => array(
                            'centered' => __('Centered', 'redux-framework-demo' ),
                            'sides' => __('Sides', 'redux-framework-demo' )
                        ),
                        'default'  => 'centered',
                        'clear' => false
                    ),
                    
                    array(
                        'id'       => 'topbar-left',
                        'type'     => 'select',
                        'title'    => __( 'Topbar left', 'redux-framework-demo' ),
                        'subtitle' => __( 'No validation can be done on this field type', 'redux-framework-demo' ),
                        'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                        'options'  => array(
                            'contact' => __('Contact', 'redux-framework-demo' ),
                            'navigation' => __('Navigation', 'redux-framework-demo' ),
                            'socials' => __('Socials', 'redux-framework-demo' ),
                            'user' => __('User - Woocommerce', 'redux-framework-demo' ),
                            'cart' => __('Cart - Woocommerce', 'redux-framework-demo' )
                        ),
                        'default'  => 'contact'
                    ),
                    array(
                        'id'       => 'topbar-right',
                        'type'     => 'select',
                        'title'    => __( 'Topbar right', 'redux-framework-demo' ),
                        'subtitle' => __( 'No validation can be done on this field type', 'redux-framework-demo' ),
                        'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                        'options'  => array(
                            'contact' => __('Contact', 'redux-framework-demo' ),
                            'navigation' => __('Navigation', 'redux-framework-demo' ),
                            'socials' => __('Socials', 'redux-framework-demo' ),
                            'user' => __('User - Woocommerce', 'redux-framework-demo' ),
                            'cart' => __('Cart - Woocommerce', 'redux-framework-demo' )
                        ),
                        'default'  => 'socials'
                    ),
                    /*---------------------------------------------------------------------*/
                    array(
                        'id'   => 'topbar-info-social',
                        'type' => 'info',
                        'title' => __( 'This is a title.', 'redux-framework-demo' ),
                        'desc' => __( 'This is the info field, if you want to break sections up.', 'redux-framework-demo' )
                    ),
                    
                    array(
                        'id'       => 'topbar-social-target',
                        'type'     => 'select',
                        'title'    => __( 'Top Bar Social Link Target', 'redux-framework-demo' ),
                        'subtitle'     => __( 'Select to open the social links in a new or the same window.', 'redux-framework-demo' ),
                        'options'  => array(
                            '_blank' => __('new window', 'redux-framework-demo' ),
                            '_self' => __('Same Window', 'redux-framework-demo' )
                        ),
                        'default'  => '1',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'topbar-social-target',
                        'type'     => 'select',
                        'title'    => __( 'Top Bar Social Style', 'redux-framework-demo' ),
                        'subtitle'     => __( 'Select your preferred social link style.', 'redux-framework-demo' ),
                        'options'  => array(
                            'awesome' => __('Awesome Font', 'redux-framework-demo' ),
                            'elegant' => __('Elegant Font', 'redux-framework-demo' ),
                        ),
                        'default'  => 'awesome',
                        'clear' => false
                    ),
                    
                    array(
                        'id'       => 'topbar-social',
                        'type'     => 'sortable',
                        'title'    => __( 'Sortable Text Option', 'redux-framework-demo' ),
                        'subtitle' => __( 'Define and reorder these however you want.', 'redux-framework-demo' ),
                        'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                        'options'  => array(
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'Google+' => '',
                            'Linkedin' => '',
                            'Pinterest' => '',
                            'Instagram' => '',
                            'Youtube' => '',
                            'RSS' => '',
                        )
                    ),
                    array(
                            'id'       => 'opt-sortable',
                            'type'     => 'sortable',
                            'title'    => __( 'Sortable Text Option', 'redux-framework-demo' ),
                            'subtitle' => __( 'Define and reorder these however you want.', 'redux-framework-demo' ),
                            'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                            'options'  => array(
                                'si1' => 'Item 1',
                                'si2' => 'Item 2',
                                'si3' => 'Item 3',
                            )
                        ),
                    /*---------------------------------------------------------------------*/
                    array(
                        'id'   => 'topbar-info-contact',
                        'type' => 'info',
                        'title' => __( 'This is a title.', 'redux-framework-demo' ),
                        'desc' => __( 'This is the info field, if you want to break sections up.', 'redux-framework-demo' )
                    ),
                    
                    array(
                        'id'       => 'topbar-contact',
                        'type'     => 'sortable',
                        'title'    => __( 'Sortable Text Option', 'redux-framework-demo' ),
                        'subtitle' => __( 'Define and reorder these however you want.', 'redux-framework-demo' ),
                        'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                        'options'  => array(
                            'Email' => 'demo@gmail.com',
                            'Phone' => '1.777.777.777',
                        )
                    ),
                    /*---------------------------------------------------------------------*/
                    array(
                        'id'   => 'topbar-info-styling',
                        'type' => 'info',
                        'title' => __( 'Styling', 'redux-framework-demo' ),
                        'desc' => __( 'This is the info field, if you want to break sections up.', 'redux-framework-demo' )
                    ),
                    
                    array(
                        'id'       => 'topbar-background',
                        'type'     => 'background',
                        'title'    => __( 'Top bar Background', THEME_LANG ),
                        'subtitle' => __( 'Top bar Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( 'background-color'=>'#1A1C27' ),
                        'output'      => array( '#top-bar' ),
                    ),
                    
                    array(
                        'id'       => 'topbar-typography',
                        'type'     => 'typography',
                        'text-align' => false,
                        'title'    => __( 'Top bar typography', 'redux-framework-demo' ),
                        'subtitle' => __( 'Specify the body font properties.', 'redux-framework-demo' ),
                        'google'   => true,
                        'default'  => array(
                            'color'       => '#A1B1BC',
                            'font-size'   => '14px',
                            'font-family' => 'Lato',
                            'font-weight' => 'Normal',
                            'line-height' => '40px',
                        ),
                        'output'      => array( '#top-bar' ),
                    ),
                    
                    array(
                        'id'       => 'topbar-link',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color Option', 'redux-framework-demo' ),
                        'subtitle' => __( 'Only color validation can be done on this field type', 'redux-framework-demo' ),
                        'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                        //'regular'   => false, // Disable Regular Color
                        //'hover'     => false, // Disable Hover Color
                        //'active'    => false, // Disable Active Color
                        //'visited'   => true,  // Enable Visited Color
                        'default'  => array(
                            'regular' => '#A1B1BC',
                            'hover'   => '#FFFFFF',
                            'active'  => '#FFFFFF',
                        ),
                        'output'      => array( '#top-bar a' ),
                    ),
                    
                    /*---------------------------------------------------------------------*/
                    array(
                        'id'   => 'opt-info-field',
                        'type' => 'info',
                        'title' => __( 'This is a title.', 'redux-framework-demo' ),
                        'desc' => __( 'This is the info field, if you want to break sections up.', 'redux-framework-demo' )
                    ),
                    /*
                    array(
                        'id'       => 'topbar-spacing',
                        'type'     => 'spacing',
                        // An array of CSS selectors to apply this font style to
                        'mode'     => 'padding',
                        // absolute, padding, margin, defaults to padding
                        //'all'      => true,
                        // Have one field that applies to all
                        'top'           => true,     // Disable the top
                        'right'         => false,     // Disable the right
                        'bottom'        => true,     // Disable the bottom
                        'left'          => false,     // Disable the left
                        'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
                        //'units_extended'=> 'true',    // Allow users to select any type of unit
                        'display_units' => 'true',   // Set to false to hide the units if the units are specified
                        'title'    => __( 'Padding/Margin Option', 'redux-framework-demo' ),
                        'subtitle' => __( 'Allow your users to choose the spacing or margin they want.', 'redux-framework-demo' ),
                        'desc'     => __( 'You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'redux-framework-demo' ),
                        'default'  => array(
                            'padding-top'    => '5px',
                            'padding-bottom' => '5px',
                        )
                    ),
                    */
                    array(
                            'id'       => 'topbar-border-top',
                            'type'     => 'border',
                            'title'    => __( 'Header Border Option', 'redux-framework-demo' ),
                            'all'           => false,
                            'top'           => true,     // Disable the top
                            'right'         => false,     // Disable the right
                            'bottom'        => false,     // Disable the bottom
                            'left'          => false,     // Disable the left
                            'subtitle' => __( 'Only color validation can be done on this field type', 'redux-framework-demo' ),
                            'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                            'default'  => array(
                                'border-color'  => '#222533',
                                'border-style'  => 'solid',
                                'border-top'    => '5px'
                            ),
                            'output'      => array( '#top-bar' ),
                        ),
                    array(
                            'id'       => 'topbar-border-bottom',
                            'type'     => 'border',
                            'title'    => __( 'Header Border Option', 'redux-framework-demo' ),
                            'all'           => false,
                            'top'           => false,     // Disable the top
                            'right'         => false,     // Disable the right
                            'bottom'        => true,     // Disable the bottom
                            'left'          => false,     // Disable the left
                            'subtitle' => __( 'Only color validation can be done on this field type', 'redux-framework-demo' ),
                            'desc'     => __( 'This is the description field, again good for additional info.', 'redux-framework-demo' ),
                            'default'  => array(
                                'border-bottom'    => '0px'
                            ),
                            'output'      => array( '#top-bar' ),
                        ),
                    
                    
                )
            );
            
            /**
			 *	Header
			 **/
			$this->sections[] = array(
				'id'			=> 'header',
				'title'			=> __( 'Header', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_desktop',
				'icon'			=> '',
				'fields'		=> array(
                    array(
						'id'		=> 'fixed_header',
						'type'		=> 'switch',
						'title'		=> __( 'Fixed Header on Scroll', THEME_LANG ),
						'subtitle'	=> __( 'Toggle the fixed header when the user scrolls down the site on or off. Please note that for certain header (two and three) styles only the navigation will become fixed.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', THEME_LANG ),
						'off'		=> __( 'Off', THEME_LANG ),
					),
                )
            );
            
            /**
			 *	Footer
			 **/
			$this->sections[] = array(
				'id'			=> 'footer',
				'title'			=> __( 'Footer', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_flowchart_alt',
				'icon'			=> '',
				'fields'		=> array(
                    array(
                        'id'       => 'footer-layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Footer layout', THEME_LANG ),
                        'subtitle' => __( 'Select your footer', THEME_LANG ),
                        'options'  => array(
                            '3-3-3-3' => array( 'alt' => __( 'Layout 1', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-1.png' ),
                            '6-3-3' => array( 'alt' => __( 'Layout 2', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-2.png' ),
                            '3-3-6' => array( 'alt' => __( 'Layout 3', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-3.png' ),
                            '6-6' => array( 'alt' => __( 'Layout 4', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-4.png' ),
                            '4-4-4' => array( 'alt' => __( 'Layout 5', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-5.png' ),
                            '8-4' => array( 'alt' => __( 'Layout 6', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-6.png' ),
                            '4-8' => array( 'alt' => __( 'Layout 7', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-7.png' ),
                            '3-6-3' => array( 'alt' => __( 'Layout 8', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-8.png' ),
                            '12' => array( 'alt' => __( 'Layout 9', THEME_LANG ), 'img' => FW_IMG . 'footer/footer-9.png' ),
                        ),
                        'default'  => '3-3-3-3'
                    ),
                    
                )
            );
            
            /**
			 *	Mailchimp
			 **/
			$this->sections[] = array(
				'id'			=> 'mailchimp',
				'title'			=> __( 'Mailchimp', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_mail',
				'icon'			=> '',
				'fields'		=> array(
                    array(
                        'id' => 'mailchimp_api',
                        'type' => 'text',
                        'title' => __('Mailchimp API KEY', THEME_LANG), 
                        'sub_desc' => __('To use mailchimp newsletter subscribe widget you have to enter your API KEY', THEME_LANGUAGE),
                        'std' => ''
                    ),
                )
            );
            
            /**
			 *	Woocommerce
			 **/
			$this->sections[] = array(
				'id'			=> 'woocommerce',
				'title'			=> __( 'Woocommerce', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_cart_alt',
				'icon'			=> '',
				'fields'		=> array(
                    array(
                        'id'       => 'archive-product-layout',
                        'type'     => 'select',
                        'title'    => __( 'Woocommerce Archive Product Layout', THEME_LANG ),
                        'options'  => array(
                            'left' => __('Left Sidebar', THEME_LANG ),
                            'right' => __('Right Sidebar', THEME_LANG ),
                            'full' => __('Full Layout', THEME_LANG )
                        ),
                        'default'  => 'full'
                    ),
                    array(
                        'id'       => 'single-product-layout',
                        'type'     => 'select',
                        'title'    => __( 'Woocommerce Single Product Layout', THEME_LANG ),
                        'options'  => array(
                            'left' => __('Left Sidebar', THEME_LANG ),
                            'right' => __('Right Sidebar', THEME_LANG ),
                            'full' => __('Full Layout', THEME_LANG )
                        ),
                        'default'  => 'full'
                    ),
                    
                )
            );
            
            
            
             
            
        }
        
    }
    
    global $reduxConfig;
    $reduxConfig = new KiteThemes_config();
    
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}
