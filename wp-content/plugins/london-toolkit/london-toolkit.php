<?php
/*
  Plugin Name: KT London toolkit
  Plugin URI: http://kutethemes.ovicsoft.com/
  Description: A Toolkit for London theme
  Author: SaT(shrimp2t@gmail.com)
  Version: 1.2
  Author URI: http://kutethemes.ovicsoft.com/
 */


define( 'LONDON_TOOLKIT_VER', '1.0' );
define( 'LONDON_TOOLKIT_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'LONDON_TOOLKIT_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

//Mailchimp
require_once LONDON_TOOLKIT_PATH.'mailchimp/mailchimp.php';

// Woocommerce products filter
require_once LONDON_TOOLKIT_PATH.'woocommerce-products-filter/index.php';

// Post types
require_once LONDON_TOOLKIT_PATH.'post-types/post-types.php';

//Shortcodes
require_once LONDON_TOOLKIT_PATH.'shortcodes.php';