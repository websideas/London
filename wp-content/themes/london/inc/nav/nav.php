<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class wi_mega_menu {
    /*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'mega_mega_add_custom_nav_fields' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'mega_mega_update_custom_nav_fields'), 10, 3 );

		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'mega_mega_edit_walker'), 10, 2 );
        add_action('admin_enqueue_scripts', array( $this,'megamenu_admin_scripts'));
       
    } // end constructor
    
    /**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function mega_mega_add_custom_nav_fields( $menu_item ) {
	    $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
        $menu_item->link = get_post_meta( $menu_item->ID, '_menu_item_link', true );
	    $menu_item->text = get_post_meta( $menu_item->ID, '_menu_item_text', true );
        $menu_item->number = get_post_meta( $menu_item->ID, '_menu_item_number', true );
        $menu_item->submenu = get_post_meta( $menu_item->ID, '_menu_item_submenu', true );
        $menu_item->fullwidth = get_post_meta( $menu_item->ID, '_menu_item_fullwidth', true );
        $menu_item->side = get_post_meta( $menu_item->ID, '_menu_item_side', true );
        $menu_item->widget = get_post_meta( $menu_item->ID, '_menu_item_widget', true );
        
        
        
	    return $menu_item;
	}
    
    
    /**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function mega_mega_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
	
	    // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-icon']) && is_array( $_REQUEST['menu-item-icon']) ) {
	        $icon_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
	    }
        
        // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-link']) && is_array( $_REQUEST['menu-item-link']) ) {
	        $link_value = isset($_REQUEST['menu-item-link'][$menu_item_db_id])? $_REQUEST['menu-item-link'][$menu_item_db_id] : 0;
	        update_post_meta( $menu_item_db_id, '_menu_item_link', $link_value );
	    }
        
	     // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-text']) && is_array( $_REQUEST['menu-item-text']) ) {
	        $text_value = $_REQUEST['menu-item-text'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_text', $text_value );
	    }
        
         // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-number']) && is_array( $_REQUEST['menu-item-number']) ) {
	        $submenu_number = $_REQUEST['menu-item-number'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_number', $submenu_number );
	    }
        
         // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-submenu']) && is_array( $_REQUEST['menu-item-submenu']) ) {
	        $submenu_type = $_REQUEST['menu-item-submenu'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_submenu', $submenu_type );
	    }
        // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-fullwidth']) && is_array( $_REQUEST['menu-item-fullwidth']) ) {
	        $submenu_fullwidth = $_REQUEST['menu-item-fullwidth'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_fullwidth', $submenu_fullwidth );
	    }
        // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-side']) && is_array( $_REQUEST['menu-item-side']) ) {
	        $submenu_side = $_REQUEST['menu-item-side'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_side', $submenu_side );
	    }
        
        // Check if element is properly sent
	    if ( isset( $_REQUEST['menu-item-widget']) && is_array( $_REQUEST['menu-item-widget']) ) {
	        $submenu_widget = $_REQUEST['menu-item-widget'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_widget', $submenu_widget );
	    }
        
	}
    
    /**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function mega_mega_edit_walker($walker,$menu_id) {
	    return 'Walker_Nav_Menu_Edit_Custom';
	}
    
    
    function megamenu_admin_scripts($hook){
        if ( 'nav-menus.php' != $hook ) return;
        /*
        wp_enqueue_style( 'jquery-ui.css', megamenupath. '/css/jquery-ui-aristo.css' );
        wp_enqueue_style( 'megamenu.css', megamenupath. '/css/megamenu.css' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style('thickbox');
        
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'megamenu_script', megamenupath. '/js/admin-megamenu.js', array('jquery', 'thickbox', 'media-upload', 'jquery-ui-button', 'wp-color-picker'),false, true );
        
        */
    }
}


$GLOBALS['sweet_custom_menu'] = new wi_mega_menu();

require_once ( THEME_DIR . 'inc/nav/nav_edit_custom_walker.php' );
require_once ( THEME_DIR . 'inc/nav/nav_custom_walker.php' );

