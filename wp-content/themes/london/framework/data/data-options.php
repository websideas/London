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
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => __( 'Page layout', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'full' => __('Full width Layout', THEME_LANG),
                            'boxed' => __('Boxed Layout', THEME_LANG),
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'sidebar_left',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'primary-widget-area' => __('Primary Widget Area', THEME_LANG),
                            'sidebar-column-1' => __('Sidebar 1', THEME_LANG),
                            'sidebar-column-2' => __('Sidebar 2', THEME_LANG)
                        ),
                        'default'  => 'primary-widget-area',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => array(
                            'primary-widget-area' => __('Primary Widget Area', THEME_LANG),
                            'sidebar-column-1' => __('Sidebar 1', THEME_LANG),
                            'sidebar-column-2' => __('Sidebar 2', THEME_LANG)
                        ),
                        'default'  => 'primary-widget-area',
                        'clear' => false
                    ),
                )
            );
            
            
            
            
            /**
			 *	Logos
			 **/
			$this->sections[] = array(
				'id'			=> 'logos',
				'title'			=> __( 'Logos Settings', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_desktop',
				'icon'			=> '',
				'fields'		=> array(
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Logo', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Logo (Retina Version @2x)', THEME_LANG ),
                        'desc'     => __('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', THEME_LANG)
                    ),
                    array(
                        'id'             => 'logo_width',
                        'type'           => 'dimensions',
                        'units'          => array( 'em', 'px'),
                        'units_extended' => 'true',
                        'title'          => __( 'Logo width', THEME_LANG ),
                        'height'         => false,
                        'default'        => array( 'width'  => 120, 'height' => 100 ),
                        'output'   => array( '.site-branding .site-logo, .site-branding .site-logo img' ),
                    ),
                    array(
                        'id'       => 'logo_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'output'   => array( '.site-branding .site-logo' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Logo margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '0px',
                            'margin-right'  => '60px',
                            'margin-bottom' => '0px',
                            'margin-left'   => '0px'
                        )
                    ),
                    array(
                            'id'       => 'logo_circle',
                            'type'     => 'switch',
                            'title'    => __( 'Logo circle', THEME_LANG ),
                            'default'  => true,
                        ),
                    array(
                        'id'       => 'opt-color-rgba',
                        'type'     => 'color_rgba',
                        'title'    => __( 'Color RGBA', 'redux-framework-demo' ),
                        'subtitle' => __( 'Gives you the RGBA color.', 'redux-framework-demo' ),
                        'default'  => array(
                            'color' => '#000',
                            'alpha' => '1'
                        ),
                        'output'   => array( '.site-branding .site-logo.logo-circle' ),
                        'mode'     => 'background',
                        'validate' => 'colorrgba',
                    ),
                    array(
                        'id'             => 'logo_sticky_width',
                        'type'           => 'dimensions',
                        'output'   => array( '.is-sticky .site-branding .site-logo,.is-sticky .site-branding .site-logo img' ),
                        'units'          => array( 'em', 'px'), 
                        'units_extended' => 'true', 
                        'title'          => __( 'Logo sticky width', THEME_LANG ),
                        'height'         => false,
                        'default'        => array( 'width'  => 95, 'height' => 100 )
                    ),
                    array(
                        'id'       => 'logo_sticky_margin_spacing',
                        'type'     => 'spacing',
                        'mode'     => 'margin',
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Logo margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '-20px',
                            'margin-right'  => '60px',
                            'margin-bottom' => '-20px',
                            'margin-left'   => '0px'
                        ),
                        'output'   => array( '.is-sticky .site-branding .site-logo' ),
                    ),
                    
                    array(
                        'id'       => 'custom_favicon',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Custom Favicon', THEME_LANG ),
                        'subtitle' => __( 'Using this option, You can upload your own custom favicon (16px x 16px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Apple iPhone Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone (57px x 57px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone_retina',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Apple iPhone Retina Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone Retina Version (114px x 114px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Apple iPad Favicon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad (72px x 72px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad_retina',
                        'type'     => 'media',
                        'preview'  => true,
                        'title'    => __( 'Apple iPad Retina Icon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad Retina Version (144px x 144px)', THEME_LANG),
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
						'subtitle'	=> __( 'Toggle the fixed header when the user scrolls down the site on or off. Please note that for certain header (two and three) styles only the navigation will become fixed.', THEME_LANG),
						"default"	=> '1',
						'on'		=> __( 'On', THEME_LANG ),
						'off'		=> __( 'Off', THEME_LANG ),
					),
                    array(
                        'id'       => 'header',
                        'type'     => 'select',
                        'title'    => __( 'Header layout', THEME_LANG ),
                        'subtitle'     => __( "Please choose header layout", THEME_LANG ),
                        'options'  => array(
                            'layout1' => __('Layout 1', THEME_LANG),
                            'layout2' => __('Layout 2', THEME_LANG),
                            'layout3' => __('Layout 3', THEME_LANG),
                        ),
                        'default'  => 'layout1',
                        'clear' => false
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
			 *	Popup
			 **/
			$this->sections[] = array(
				'id'			=> 'popup',
				'title'			=> __( 'Popup', THEME_LANG ),
				'desc'			=> '',
				'icon_class'	=> 'icon_desktop',
				'icon'			=> '',
				'fields'		=> array(
                    array(
						'id'		=> 'enable_popup',
						'type'		=> 'switch',
						'title'		=> __( 'Enable Popup', THEME_LANG ),
						'subtitle'	=> __( '', THEME_LANG),
						"default"	=> '1',
						'on'		=> __( 'On', THEME_LANG ),
						'off'		=> __( 'Off', THEME_LANG ),
					),
                    array(
						'id'		=> 'disable_popup_mobile',
						'type'		=> 'switch',
						'title'		=> __( 'Disable Popup on Mobile', THEME_LANG ),
						'subtitle'	=> __( '', THEME_LANG),
						"default"	=> '0',
						'on'		=> __( 'On', THEME_LANG ),
						'off'		=> __( 'Off', THEME_LANG ),
					),
                    array(
                        'id'       => 'popup-background',
                        'type'     => 'background',
                        'output'   => array( '#popup-wrap' ),
                        'title'    => __( 'Popup Background', THEME_LANG ),
                        'subtitle' => __( 'Popup background with image, color, etc.', THEME_LANG ),
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'id'       => 'content-popup',
                        'type'     => 'editor',
                        'title'    => __( 'Content Popup', THEME_LANG ),
                        'subtitle' => __( '', THEME_LANG ),
                        'default'  => 'Content popup',
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
                    array(
                        'id'       => 'products-layout',
                        'type'     => 'select',
                        'title'    => __( 'Woocommerce Single Product Layout', THEME_LANG ),
                        'options'  => array(
                            'grid' => __('Grid', THEME_LANG ),
                            'lists' => __('Lists', THEME_LANG )
                        ),
                        'default'  => 'grid'
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
