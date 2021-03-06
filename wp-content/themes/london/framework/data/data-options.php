<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( ! class_exists( 'KT_config' ) ) {
    class KT_config{
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

            // echo var_dump(ICL_LANGUAGE_CODE); die();

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => apply_filters('theme_option_name', THEME_OPTIONS ),
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => false,
                // Show the sections below the admin menu item or not
                'menu_title'           => __( 'London', THEME_LANG ),
                
                'page_title'           => __( 'London Theme Options - ', THEME_LANG ),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => false,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => false,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => 61,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => 'dashicons-art',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'theme_options',
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
            
            $this->sections[] = array(
                'id'    => 'general',
                'title'  => __( 'General', THEME_LANG ),
                'desc'   => __( '', THEME_LANG ),
                'icon_class' => 'icon_cogs'
            );


            global $wp_registered_sidebars;
            $sidebars = array();

            foreach ( $wp_registered_sidebars as $sidebar ){
                $sidebars[  $sidebar['id'] ] = $sidebar['name'];
            }
            
            $this->sections[] = array(
                'id'    => 'general_layout',
                'title'  => __( 'General', THEME_LANG ),
                'desc'   => __( '', THEME_LANG ),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => __( 'Site boxed mod(?)', THEME_LANG ),
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
                        'default'  => 'right',
                        'clear' => false,
                    ),
                    array(
                        'id'       => 'sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose default layout", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'primary-widget-area',
                        'required' => array('sidebar','equals','left')
                        //'clear' => false
                    ),
                    array(
                        'id'       => 'sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose page layout", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'primary-widget-area',
                        'required' => array('sidebar','equals','right')
                        //'clear' => false
                    ),

                    array(
                        'id'       => 'show_page_comment',
                        'type'     => 'select',
                        'title'    => __( 'Show comments on page ?', THEME_LANG ),
                        'options'  => array(
                            'no' => __('No', THEME_LANG),
                            'yes' => __('Yes', THEME_LANG),
                        ),
                        'default'  => 'no',
                        'clear' => false,
                    ),
                    array(
                        'id'        => 'page_loader',
                        'type'      => 'switch',
                        'title'     => __( 'Page loader', THEME_LANG ),
                        'subtitle'  => __( 'Enable page loader when start.', THEME_LANG),
                        "default"   => '1',
                        'on'        => __( 'On', THEME_LANG ),
                        'off'       => __( 'Off', THEME_LANG ),
                    ),
                )
            );

            /**
             *  Logos
             **/
            $this->sections[] = array(
                'id'            => 'logos_favicon',
                'title'         => __( 'Logos & Favicon', THEME_LANG ),
                'desc'          => __( '', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'logos_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Logos settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'default'  =>THEME_IMG.'logo.png',
                        'title'    => __( 'Logo', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Logo (Retina Version @2x)', THEME_LANG ),
                        'desc'     => __('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', THEME_LANG)
                    ),
                    array(
                        'id'       => 'logo_light',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'default' =>THEME_IMG.'logo2.png',
                        'title'    => __( 'Logo Light', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'logo_retina_light',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Logo Light(Retina Version @2x)', THEME_LANG ),
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
                        'output'   => array( '.site-branding .site-logo', '.site-branding .site-logo img' ),
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
                        'id'             => 'logo_sticky_width',
                        'type'           => 'dimensions',
                        'output'   => array( '#main-nav > ul > li.menu-logo img'),
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
                        'title'    => __( 'Logo sticky margin spacing Option', THEME_LANG ),
                        'default'  => array(
                            'margin-top'    => '-20px',
                            'margin-right'  => '60px',
                            'margin-bottom' => '-20px',
                            'margin-left'   => '0px'
                        ),
                        'output'   => array( '#main-nav > ul > li.menu-logo a'),
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'favicon_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Favicon settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'custom_favicon',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Custom Favicon', THEME_LANG ),
                        'subtitle' => __( 'Using this option, You can upload your own custom favicon (16px x 16px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPhone Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone (57px x 57px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_iphone_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPhone Retina Favicon', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPhone Retina Version (114px x 114px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPad Favicon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad (72px x 72px)', THEME_LANG),
                    ),
                    array(
                        'id'       => 'custom_favicon_ipad_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => __( 'Apple iPad Retina Icon Upload', THEME_LANG ),
                        'subtitle' => __( 'Favicon for Apple iPad Retina Version (144px x 144px)', THEME_LANG),
                    ),
                )
            );
            
            
            /**
             *  Header
             **/
            $this->sections[] = array(
                'id'            => 'Header',
                'title'         => __( 'Header', THEME_LANG ),
                'desc'          => __( '', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'        => 'fixed_header',
                        'type'      => 'switch',
                        'title'     => __( 'Fixed Header on Scroll', THEME_LANG ),
                        'subtitle'  => __( 'Toggle the fixed header when the user scrolls down the site on or off. Please note that for certain header (two and three) styles only the navigation will become fixed.', THEME_LANG),
                        "default"   => '1',
                        'on'        => __( 'On', THEME_LANG ),
                        'off'       => __( 'Off', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'header',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Header layout', THEME_LANG ),
                        'subtitle' => __( 'Please choose header layout', THEME_LANG ),
                        'options'  => array(
                            'layout1' => array( 'alt' => __( 'Layout 1', THEME_LANG ), 'img' => FW_IMG . 'header/header-v1.png' ),
                            'layout2' => array( 'alt' => __( 'Layout 2', THEME_LANG ), 'img' => FW_IMG . 'header/header-v2.png' ),
                            'layout3' => array( 'alt' => __( 'Layout 3', THEME_LANG ), 'img' => FW_IMG . 'header/header-v3.png' ),
                        ),
                        'default'  => 'layout1'
                    ),
                    
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'header_contact_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header contact settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'header_phone',
                        'type' => 'text',
                        'title' => __('Phone Number For Contact Info', THEME_LANG), 
                        'default' => __('Call Us: 00-123-456-789', THEME_LANG)
                    ),
                    array(
                        'id' => 'header_email',
                        'type' => 'text',
                        'title' => __('Email Address For Contact Info', THEME_LANG), 
                        'default' => __('demo@domain.com', THEME_LANG)
                    ),
                    
                )
            );
            
            /**
             *  Footer
             **/
            $this->sections[] = array(
                'id'            => 'footer',
                'title'         => __( 'Footer', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    // Footer settings
                    array(
                        'id'       => 'backtotop',
                        'type'     => 'switch',
                        'title'    => __( 'Back to top', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer',
                        'type'     => 'switch',
                        'title'    => __( 'Footer enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_fixed',
                        'type'     => 'switch',
                        'title'    => __( 'Footer Fixed', THEME_LANG ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'footer_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer  padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    // Footer Top settings
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer top settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top',
                        'type'     => 'switch',
                        'title'    => __( 'Footer top enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_top_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-top' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer top padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    // Footer widgets settings
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer widgets settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets',
                        'type'     => 'switch',
                        'title'    => __( 'Footer widgets enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_widgets_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-area' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer widgets padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_widgets_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Footer widgets layout', THEME_LANG ),
                        'subtitle' => __( 'Select your footer widgets layout', THEME_LANG ),
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
                        'default'  => '4-4-4'
                    ),
                    /* Footer bottom */
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer bottom settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom',
                        'type'     => 'switch',
                        'title'    => __( 'Footer bottom enable', THEME_LANG ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'footer_bottom_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-bottom' ),
                        'units'          => array( 'em', 'px' ), 
                        'units_extended' => 'true',
                        'title'    => __( 'Footer bottom padding', THEME_LANG ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_bottom_layout',
                        'type'     => 'select',
                        'title'    => __( 'Footer bottom layout', THEME_LANG ),
                        'subtitle'     => __( 'Select your preferred footer layout.', THEME_LANG ),
                        'options'  => array(
                            'centered' => __('Centered', THEME_LANG),
                            'sides' => __('Sides', THEME_LANG )
                        ),
                        'default'  => 'sides',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'footer_bottom_left',
                        'type'     => 'select',
                        'title'    => __( 'Footer bottom left', THEME_LANG ),
                        'options'  => array(
                            '' => __('Empty', THEME_LANG ),
                            'navigation' => __('Navigation', THEME_LANG ),
                            'socials' => __('Socials', THEME_LANG ),
                            'copyright' => __('Copyright', THEME_LANG ),
                        ),
                        'default'  => 'copyright'
                    ),
                    array(
                        'id'       => 'footer_bottom_right',
                        'type'     => 'select',
                        'title'    => __( 'Footer bottom right', THEME_LANG ),
                        'options'  => array(
                            '' => __('Empty', THEME_LANG ),
                            'navigation' => __('Navigation', THEME_LANG ),
                            'socials' => __('Socials', THEME_LANG ),
                            'copyright' => __('Copyright', THEME_LANG ),
                        ),
                        'default'  => 'navigation'
                    ),
                    array(
                         'id'   => 'footer_socials',
                         'type' => 'kt_socials',
                         'title'    => __( 'Select your socials', THEME_LANG ),
                    ),
                    array(
                        'id'       => 'footer_copyright',
                        'type'     => 'editor',
                        'title'    => __( 'Footer Copyright Text', THEME_LANG ),
                        'default'  => 'LONDON STARS &copy; 2015. Powered by Wordpress&#8482;. All Rights Reserved.'
                    ),
                    
                )
            );


            /**
             *  Sidebar
             **/
            $this->sections[] = array(
                'id'            => 'csidebar',
                'title'         => __( 'Sidebar Widgets', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(

                    array(
                        'id'          => 'custom_sidebars',
                        'type'        => 'slides',
                        'title'       => __('Slides Options', THEME_LANG ),
                        'subtitle'    => __('Unlimited sidebar with drag and drop sortings.', THEME_LANG ),
                        'desc'        => '',
                        'class'       => 'slider-no-image-preview',
                        'content_title' =>'Sidebar',
                        'show' => array(
                            'title' => true,
                            'description' => true,
                            'url' => false,
                        ),
                        'placeholder' => array(
                            'title'           => __('Sidebar title', THEME_LANG ),
                            'description'     => __('Sidebar Description', THEME_LANG ),
                        ),
                    ),

                )

            );
            

            /**
             *  Styling
             **/
            $this->sections[] = array(
                'id'            => 'styling',
                'title'         => __( 'Styling', THEME_LANG ),
                'desc'          => '',
                'icon_class'    => 'icon_camera_alt',
            );
            /**
             *  Styling General
             **/
            $this->sections[] = array(
                'id'            => 'styling_general',
                'title'         => __( 'General', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'styling_accent',
                        'type'     => 'color',
                        'title'    => __( 'Theme Accent Color', THEME_LANG ),
                        'default'  => '',
                        'transparent' => false,
                    ),
                    array(
                        'id'       => 'styling_link',
                        'type'     => 'link_color',
                        'title'    => __( 'Links Color', THEME_LANG ),
                        'output'      => array( 'a' ),
                        'default'  => array(
                            'regular' => '#666666',
                            'hover'   => '#000000',
                            'active'   => '#000000',
                        )
                    ),
                    array(
                        'id'       => 'default_cover_background',
                        'type'     => 'background',
                        'title'    => __( 'Cover Background', THEME_LANG ),
                        'background-repeat' => false,
                        'background-attachment' => false,
                        'background-position' => false,
                        'background-image' => false,
                        'background-size' => false,
                        'preview' => false,
                        'default'   => array( ),
                        'output'      => array( '.page-bg-cover' ),
                    )

                )
            );
            
            
            /**
             *  Styling Background
             **/
            $this->sections[] = array(
                'id'            => 'styling-background',
                'title'         => __( 'Background', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'styling_body_background',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => __( 'Body Background for full width mod', THEME_LANG ),
                        'subtitle' => __( 'Body background with image, color, etc.', THEME_LANG ),
                        'default'   => '#FFFFFF'
                    ),
                    array(
                        'id'       => 'styling_boxed_background',
                        'type'     => 'background',
                        'output'   => array( 'body.layout-boxed #page' ),
                        'title'    => __( 'Boxed Background for boxed mod', THEME_LANG ),
                        'subtitle' => __( 'Body background with image, color, etc.', THEME_LANG ),
                        'default'   => '#'
                    ),
                )
            );
            
            
            /**
             *  Styling Header
             **/
            $this->sections[] = array(
                'id'            => 'styling_header',
                'title'         => __( 'Header', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'header_layout1_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header layout 1 settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'            => 'header-layout-opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Background opacity', THEME_LANG ),
                        'default'       => .8,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text'
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'header_sticky_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Header sticky settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'            => 'header_sticky_opacity',
                        'type'          => 'slider',
                        'title'         => __( 'Background opacity', THEME_LANG ),
                        'default'       => .8,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 1,
                        'resolution'    => 0.1,
                        'display_value' => 'text'
                    ),
                )
            );
            
            /**
             *  Styling Footer
             **/
            $this->sections[] = array(
                'id'            => 'styling_footer',
                'title'         => __( 'Footer', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer Background', THEME_LANG ),
                        'subtitle' => __( 'Footer Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( 'background-color'=>'#f6f6f6' ),
                        'output'      => array( '#footer' ),
                    ),
                    array(
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer Border', THEME_LANG ),
                        'output'   => array( '#footer' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'bottom'      => false,
                        'default'  => array(
                            'border-color'  => '#cccccc',
                            'border-style'  => 'solid',
                            'border-top'    => '1px'
                        )
                    ),
                    // Footer top settings
                    array(
                        'id'   => 'divide-id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer top settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer top Background', THEME_LANG ),
                        'subtitle' => __( 'Footer top Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-top' ),
                    ),
                    array(
                        'id'       => 'footer_top_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer top Border', THEME_LANG ),
                        'output'   => array( '#footer-top' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array(
                            
                        )
                    ),
                    // Footer widgets settings
                    array(
                        'id'   => 'divide-id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer widgets settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer widgets Border', THEME_LANG ),
                        'output'   => array( '#footer-area' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array(
                            'border-color'  => '#cccccc',
                            'border-style'  => 'solid',
                            'border-bottom'    => '1px'
                        )
                    ),
                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer widgets Background', THEME_LANG ),
                        'subtitle' => __( 'Footer widgets Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer-area' ),
                    ),
                    array(
                        'id'       => 'footer_widgets_title_border',
                        'type'     => 'border',
                        'title'    => __( 'Footer widgets title border', THEME_LANG ),
                        'output'   => array( '#footer-area h3.widget-title' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array( )
                    ),
                    //Footer bottom settings
                    array(
                        'id'   => 'divide-id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Footer bottom settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => __( 'Footer Background', THEME_LANG ),
                        'subtitle' => __( 'Footer Background with image, color, etc.', THEME_LANG ),
                        'default'   => array( ),
                        'output'      => array( '#footer' ),
                    ),
                )
            );
            
            
            /**
             *  Typography
             **/
            $this->sections[] = array(
                'id'            => 'typography',
                'title'         => __( 'Typography', THEME_LANG ),
                'desc'          => '',
                'icon_class'    => 'icon_tool',
            );
            
            /**
             *  Typography General
             **/
            $this->sections[] = array(
                'id'            => 'typography_general',
                'title'         => __( 'General', THEME_LANG ),
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_body',
                        'type'     => 'typography',
                        'title'    => __( 'Body Font', THEME_LANG ),
                        'subtitle' => __( 'Specify the body font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'body' ),
                        'default'  => array(
                            'color'       => '#666666',
                            'font-size'   => '14px',
                            'font-family' => 'Dosis',
                            'font-weight' => 'Normal',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id'       => 'typography_pragraph',
                        'type'     => 'typography',
                        'title'    => __( 'Pragraph', THEME_LANG ),
                        'subtitle' => __( 'Specify the pragraph font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'p' ),
                        'default'  => array(
                            
                        ),
                    ),
                    //Footer bottom settings
                    array(
                        'id'   => 'divide-id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'typography_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Typography Heading settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'typography_heading1',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 1', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 1 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h1', '.h1' ),
                        'default'  => array(
                            'font-size'   => '36px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading2',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 2', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 2 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h2', '.h2' ),
                        'default'  => array(
                            'font-size'   => '30px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading3',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 3', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 3 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h3', '.h3' ),
                        'default'  => array(
                            'font-size'   => '24px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading4',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 4', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 4 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h4', '.h4' ),
                        'default'  => array(
                            'font-size'   => '18px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading5',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 5', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 5 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h5', '.h5' ),
                        'default'  => array(
                            'font-size'   => '14px',
                        ),
                    ),
                    array(
                        'id'       => 'typography_heading6',
                        'type'     => 'typography',
                        'title'    => __( 'Heading 6', THEME_LANG ),
                        'subtitle' => __( 'Specify the heading 6 font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( 'h6', '.h6' ),
                        'default'  => array(
                            'font-size'   => '12px',
                        ),
                    ),
                )
            );
            /**
             *  Typography header
             **/
            $this->sections[] = array(
                'id'            => 'typography_header',
                'title'         => __( 'Header', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_header_content',
                        'type'     => 'typography',
                        'title'    => __( 'Header', THEME_LANG ),
                        'subtitle' => __( 'Specify the header title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#header' )
                    )
                )
            );
            
            /**
             *  Typography footer
             **/
            $this->sections[] = array(
                'id'            => 'typography_footer',
                'title'         => __( 'Footer', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_footer_top',
                        'type'     => 'typography',
                        'title'    => __( 'Footer top', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer top font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#footer-top' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets',
                        'type'     => 'typography',
                        'title'    => __( 'Footer widgets', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer widgets font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#footer-area' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_widgets_title',
                        'type'     => 'typography',
                        'title'    => __( 'Footer widgets title', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer widgets title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#footer-area h3.widget-title' ),
                        'default'  => array(
                            'color'       => '#666666',
                            'font-size'   => '30px',
                            'font-weight' => 'Normal',
                            'line-height' => '30px'
                        ),
                    ),
                    array(
                        'id'       => 'typography_footer_content',
                        'type'     => 'typography',
                        'title'    => __( 'Footer', THEME_LANG ),
                        'subtitle' => __( 'Specify the footer font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '#footer' ),
                        'default'  => array(
                            'color'       => '',
                            'font-size'   => '',
                            'font-weight' => '',
                            'line-height' => ''
                        ),
                    ),
                )
            );
            /**
             *  Typography sidebar
             **/
            $this->sections[] = array(
                'id'            => 'typography_sidebar',
                'title'         => __( 'Sidebar', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography_sidebar_content',
                        'type'     => 'typography',
                        'title'    => __( 'Sidebar text', THEME_LANG ),
                        'subtitle' => __( 'Specify the sidebar title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '.sidebar' ),
                        'default'  => array(
                        
                        ),
                    ),
                    array(
                        'id'       => 'typography_sidebar',
                        'type'     => 'typography',
                        'title'    => __( 'Sidebar title', THEME_LANG ),
                        'subtitle' => __( 'Specify the sidebar title font properties.', THEME_LANG ),
                        'google'   => true,
                        'output'      => array( '.sidebar .widget-container .widget-title' ),
                        'default'  => array(
                            'color'       => '#ffffff',
                            'font-size'   => '18px',
                            'font-weight' => 'Normal',
                            'line-height' => '30px'
                        ),
                    ),
                )
            );
            /**
             *  Typography sidebar
             **/
            $this->sections[] = array(
                'id'            => 'typography_navigation',
                'title'         => __( 'Main Navigation', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'typography-navigation_top',
                        'type'     => 'typography',
                        'title'    => __( 'Top Menu Level', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array( 'body .header-container #main-nav > ul > li > a' )
                    ),
                    array(
                        'id'       => 'typography_navigation_second',
                        'type'     => 'typography',
                        'title'    => __( 'Dropdown menu item', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array( 'body .header-container #main-nav > ul > li ul.sub-menu-dropdown > li > a' )
                    ),
                    array(
                        'id'       => 'typography_navigation_heading',
                        'type'     => 'typography',
                        'title'    => __( 'Heading title', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array( 
                            'body .header-container #main-nav > ul > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > a',
                            'body .header-container #main-nav > ul > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > span',
                            'body .header-container #main-nav > ul > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li .widget-title'
                        ),
                        'default'  => array( ),
                    ),
                    array(
                        'id'       => 'typography_navigation_mega',
                        'type'     => 'typography',
                        'title'    => __( 'Mega menu item', THEME_LANG ),
                        'google'   => true,
                        'text-align'      => false,
                        'color'           => false,
                        'line-height'     => false,
                        'output'      => array(
                            'body .header-container #main-nav > ul > li .kt-megamenu-wrapper > ul.kt-megamenu-ul > li > .sub-menu-megamenu > li > a'
                        ),
                        'default'  => array( ),
                    )
                )
            );
            
            /**
             *  Popup
             **/
            $this->sections[] = array(
                'id'            => 'popup',
                'title'         => __( 'Popup', THEME_LANG ),
                'desc'          => '',
                'icon_class'    => 'icon_desktop',
                'fields'        => array(
                    array(
                        'id'        => 'enable_popup',
                        'type'      => 'switch',
                        'title'     => __( 'Enable Popup', THEME_LANG ),
                        'subtitle'  => __( '', THEME_LANG),
                        "default"   => true,
                        'on'        => __( 'On', THEME_LANG ),
                        'off'       => __( 'Off', THEME_LANG ),
                    ),
                    array(
                        'id'        => 'disable_popup_mobile',
                        'type'      => 'switch',
                        'title'     => __( 'Disable Popup on Mobile', THEME_LANG ),
                        'subtitle'  => __( '', THEME_LANG),
                        "default"   => false,
                        'on'        => __( 'On', THEME_LANG ),
                        'off'       => __( 'Off', THEME_LANG ),
                        'required' => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id' => 'time_show',
                        'type' => 'text',
                        'title' => __('Time to show', THEME_LANG), 
                        'desc' => __('Unit: s', THEME_LANG),
                        'default' => __('0', THEME_LANG),
                        'required' => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id' => 'time_show_again',
                        'type' => 'text',
                        'title' => __('Time to show again', THEME_LANG),
                        'desc' => __('Unit: minutes', THEME_LANG), 
                        'default' => __('300', THEME_LANG),
                        'required' => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id'       => 'popup_background',
                        'type'     => 'background',
                        'output'   => array( '#popup-wrap' ),
                        'title'    => __( 'Popup Background', THEME_LANG ),
                        'subtitle' => __( 'Popup background with image, color, etc.', THEME_LANG ),
                        'default'  => array(
                            'background-color' => '#FFFFFF',
                            'background-image' => THEME_IMG.'popup_bg.png',
                            'background-repeat' => 'no-repeat',
                            'background-size'   => 'cover',
                            'background-position' => 'center center',
                        ),
                        'required' => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id'       => 'content_popup',
                        'type'     => 'editor',
                        'title'    => __( 'Content Popup', THEME_LANG ),
                        'subtitle' => __( '', THEME_LANG ),
                        'required' => array('enable_popup','equals', 1),
                        'default'  => __('<h3 class="title-top">SIGN UP FOR OUR NEWSLETTER &amp; PROMOTIONS !</h3><p><img src="'.THEME_IMG.'popup_image.png" /></p>[mailchimp opt_in="yes" list="9306fec7e3" text_before="YOUR ENTIRE ORDER WHEN YOU SIGN UP TODAY !" layout="one"]Success! Check your inbox or spam folder for a message containing a confirmation link.[/mailchimp]', THEME_LANG),
                    ),
                )
            );
            /**
             *  Woocommerce
             **/
            $this->sections[] = array(
                'id'            => 'woocommerce',
                'title'         => __( 'Woocommerce', THEME_LANG ),
                'desc'          => '',
                'icon_class'    => 'icon_cart_alt',
                'fields'        => array(
                    array(
                        'id'       => 'shop_single_product',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Shop Products settings', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'shop_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Shop Products Layout', THEME_LANG ),
                        'options'  => array(
                            'left' => __('Left Sidebar', THEME_LANG ),
                            'right' => __('Right Sidebar', THEME_LANG ),
                            'full' => __('Full Layout', THEME_LANG )
                        ),
                        'default'  => 'full'
                    ),
                    array(
                        'id'       => 'shop_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('shop_sidebar','equals','left')
                        //'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('shop_sidebar','equals','right')
                        //'clear' => false
                    ),
                    array(
                        'id'       => 'shop_products_layout',
                        'type'     => 'select',
                        'title'    => __( 'Shop product Layout', THEME_LANG ),
                        'options'  => array(
                            'grid' => __('Grid', THEME_LANG ),
                            'lists' => __('Lists', THEME_LANG )
                        ),
                        'default'  => 'grid'
                    ),
                    array(
                        'id'       => 'shop_products_effect',
                        'type'     => 'select',
                        'title'    => __( 'Shop product effect', THEME_LANG ),
                        'options'  => array(
                            'center' => __('Center', THEME_LANG ),
                            'bottom' => __('Bottom', THEME_LANG )
                        ),
                        'default'  => 'center'
                    ),
                    array(
                        'id'       => 'loop_shop_per_page',
                        'type'     => 'text',
                        'title'    => __( 'Number of products displayed per page', THEME_LANG ),
                        'default'  => '18'
                    ),

                    array(
                        'id'       => 'shop_gird_cols',
                        'type'     => 'select',
                        'title'    => __( 'Number column to display width gird mod', THEME_LANG ),
                        'options'  => array(
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                        ),
                        'default'  => 3,
                    ),


                    // For Single Products
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'shop_product_layout',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.__( 'Single Product Layout', THEME_LANG ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'product_sidebar',
                        'type'     => 'select',
                        'title'    => __( 'Product: Sidebar configuration', THEME_LANG ),
                        'subtitle'     => __( "Please choose single product page ", THEME_LANG ),
                        'options'  => array(
                            'full' => __('No sidebars', THEME_LANG),
                            'left' => __('Left Sidebar', THEME_LANG),
                            'right' => __('Right Layout', THEME_LANG)
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_left',
                        'type' => 'select',
                        'title'    => __( 'Product: Sidebar left area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('product_sidebar','equals','left')
                        //'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_right',
                        'type'     => 'select',
                        'title'    => __( 'Product: Sidebar right area', THEME_LANG ),
                        'subtitle'     => __( "Please choose left sidebar ", THEME_LANG ),
                        'options'  => $sidebars,
                        'default'  => 'shop-widget-area',
                        'required' => array('product_sidebar','equals','right')
                        //'clear' => false
                    ),
                )
            );
            $this->sections[] = array(
                'id'            => 'social',
                'title'         => __( 'Socials', THEME_LANG ),
                'desc'          => __('Social and share settings', THEME_LANG),
                'icon_class'    => 'social_facebook',
                'fields'        => array(

                    array(
                        'id' => 'addthis_id',
                        'type' => 'text',
                        'title' => __('Addthis ID', THEME_LANG),
                        'subtitle' => __("Your Addthis ID", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'twitter_username',
                        'type' => 'text',
                        'title' => __('Twitter', THEME_LANG),
                        'subtitle' => __("Your Twitter username (no @).", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id' => 'facebook_page_url',
                        'type' => 'text',
                        'title' => __('Facebook', THEME_LANG),
                        'subtitle' => __("Your Facebook page/profile url", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id' => 'pinterest_username',
                        'type' => 'text',
                        'title' => __('Pinterest', THEME_LANG),
                        'subtitle' => __("Your Pinterest username", THEME_LANG),
                        'default' => ''
                    ),
                    array(
                        'id' => 'dribbble_username',
                        'type' => 'text',
                        'title' => __('Dribbble', THEME_LANG),
                        'subtitle' => __("Your Dribbble username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'vimeo_username',
                        'type' => 'text',
                        'title' => __('Vimeo', THEME_LANG),
                        'subtitle' => __("Your Vimeo username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'tumblr_username',
                        'type' => 'text',
                        'title' => __('Tumblr', THEME_LANG),
                        'subtitle' => __("Your Tumblr username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'skype_username',
                        'type' => 'text',
                        'title' => __('Skype', THEME_LANG),
                        'subtitle' => __("Your Skype username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'linkedin_page_url',
                        'type' => 'text',
                        'title' => __('LinkedIn', THEME_LANG),
                        'subtitle' => __("Your LinkedIn page/profile url", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'googleplus_page_url',
                        'type' => 'text',
                        'title' => __('Google+', THEME_LANG),
                        'subtitle' => __("Your Google+ page/profile URL", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'youtube_username',
                        'type' => 'text',
                        'title' => __('YouTube', THEME_LANG),
                        'subtitle' => __("Your YouTube username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'instagram_username',
                        'type' => 'text',
                        'title' => __('Instagram', THEME_LANG),
                        'subtitle' => __("Your Instagram username", THEME_LANG),
                        'desc' => '',
                        'default' => ''
                    )
                )
            );
            
            /**
             *  Import Demo
             **/
            $this->sections[] = array(
                 'id' => 'wbc_importer_section',
                 'title'  => esc_html__( 'Demo Content', 'framework' ),
                 'desc'   => esc_html__( 'Chose a demo to import', 'framework' ),
                 'icon'   => 'el-icon-website',
                 'fields' => array(
                     array(
                         'id'   => 'wbc_demo_importer',
                         'type' => 'wbc_importer'
                     )
                 )
            );
            

            
            $info_arr = array();
            $theme = wp_get_theme();
            
            $info_arr[] = "<li><span>".__('Theme Name:', THEME_LANG)." </span>". $theme->get('Name').'</li>';
            $info_arr[] = "<li><span>".__('Theme Version:', THEME_LANG)." </span>". $theme->get('Version').'</li>';
            $info_arr[] = "<li><span>".__('Theme URI:', THEME_LANG)." </span>". $theme->get('ThemeURI').'</li>';
            $info_arr[] = "<li><span>".__('Author:', THEME_LANG)." </span>". $theme->get('Author').'</li>';
            
            $system_info = sprintf("<div class='troubleshooting'><ul>%s</ul></div>", implode('', $info_arr));
            
            
            /**
             *  Advanced Troubleshooting
             **/
            $this->sections[] = array(
                'id'            => 'advanced_troubleshooting',
                'title'         => __( 'Troubleshooting', THEME_LANG ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'opt-raw_info_4',
                        'type'     => 'raw',
                        'content'  => $system_info,
                        'full_width' => true
                    ),
                )
            );
            
            
            
        }
        
    }
    
    global $reduxConfig;
    $reduxConfig = new KT_config();
    
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}
