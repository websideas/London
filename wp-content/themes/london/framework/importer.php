<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( !function_exists( 'wbc_change_demo_directory_path' ) ) {
	/**
	 * Change the path to the directory that contains demo data folders.
	 *
	 * @param [string] $demo_directory_path
	 *
	 * @return [string]
	 */

	function wbc_change_demo_directory_path( $demo_directory_path ) {
		$demo_directory_path = FW_DIR.'dummy-data/';
		return $demo_directory_path;

	}
    add_filter('wbc_importer_dir_path', 'wbc_change_demo_directory_path' );
}


/************************************************************************
* Extended Example:
* Way to set menu, import revolution slider, and set home page.
*************************************************************************/

if ( !function_exists( 'kt_wbc_extended_imported' ) ) {
	function kt_wbc_extended_imported( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		* Import slider(s) for the current demo being imported
		*************************************************************************/

		if ( class_exists( 'RevSlider' ) ) {

			//If it's demo3 or demo5
			$wbc_sliders_array = array(
				'demo1' => 'slide1.zip'
			);

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

				if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
				}
			}
		}

		/************************************************************************
		* Setting Menus
		*************************************************************************/

		// If it's demo1 - demo6
		$wbc_menu_array = array( 'demo1', 'demo2', 'demo3', 'demo4', 'demo5', 'demo6' );

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$main_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );
            $top_menu = get_term_by( 'name', 'Top menu', 'nav_menu' );
            $footer_menu = get_term_by( 'name', 'Footer menu', 'nav_menu' );
            
			set_theme_mod( 'nav_menu_locations', array(
					'primary' => $main_menu->term_id,
					'top'  => $top_menu->term_id,
                    'bottom'  => $footer_menu->term_id
				)
			);

		}

		/************************************************************************
		* Set HomePage
		*************************************************************************/

		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'demo1' => 'Home',
			'demo2' => 'Gift',
			'demo3' => 'Home',
			'demo4' => 'Home',
			'demo5' => 'Home',
			'demo6' => 'Home',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
    add_action( 'wbc_importer_after_content_import', 'kt_wbc_extended_imported', 10, 2 );
}