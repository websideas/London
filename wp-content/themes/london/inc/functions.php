<?php


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/*
 * Set up the content width value based on the theme's design.
 *
 * @see themedev_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 1170;




add_action( 'after_setup_theme', 'theme_setup' );
if ( ! function_exists( 'theme_setup' ) ):

function theme_setup() {
    /**
     * Editor style.
     */
    add_editor_style();
    
    /**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
    
    /**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
    add_theme_support( 'post-formats', array('gallery', 'link', 'image', 'video') );
    
    /**
	 * Enable support for woocommerce
	 */
    add_theme_support( 'woocommerce' );
    
    /**
	 * Let WordPress manage the document title.
	 */
    add_theme_support( 'title-tag' );
    
    /**
	 * Allow shortcodes in widgets.
	 *
	 */
	add_filter( 'widget_text', 'do_shortcode' );
    
    
    /**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    
    
    if (function_exists( 'add_image_size' ) ) {
        add_image_size( 'screen', 1170);
        add_image_size( 'screen_square', 1170, 1170, true);
        add_image_size( 'haft', 570);
        add_image_size( 'haft_square', 570, 570, true);
        add_image_size( 'small', 105, 105, true );
        
    }
    
    load_theme_textdomain( THEME_LANG, THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => __('Main menu', THEME_LANGUAGE),
        'top'	  => __( 'Top Menu', THEME_LANGUAGE ),
        'bottom'	  => __( 'Bottom Menu', THEME_LANGUAGE ),
    ));

}
endif;

/** 
 * Widget Custom
 * 
 * @since 1.0
 */

add_filter('get_archives_link', 'add_span_cat_count');
add_filter('wp_list_categories', 'add_span_cat_count');
function add_span_cat_count($variable) {
    $variable = str_replace('(', '<span>(', $variable);
    $variable = str_replace(')', ')</span>', $variable);
    return $variable;
}


/**
 * Outputs the header meta title tag
 *
 * @since 1.0
 * @return void
 */
if ( ! function_exists( 'themdev_meta_title' ) ) {
	function themdev_meta_title() { ?>
		<title><?php if ( function_exists( 'wpseo_auto_load' ) ) { ?> 
            <?php wp_title(); ?>
            <?php }else{ ?>
		     <?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?>
		<?php }  ?></title>
	<?php }
}