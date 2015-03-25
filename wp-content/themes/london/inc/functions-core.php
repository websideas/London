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
	 * Disable Woo styles (will use customized compiled copy)
	 */ 
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    
    /**
	 * Enable support for woocommerce
	 */
    //add_theme_support( 'woocommerce' );
    
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



/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function london_scripts() {

    wp_enqueue_style( 'london-style', get_stylesheet_uri() );
    wp_enqueue_style( 'london-bootstrap', THEME_COMPONENTS . 'bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style( 'london-font-awesome', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'london-mCustomScrollbar', THEME_CSS . 'jquery.mCustomScrollbar.min.css', array());
    
    
	// Load our main stylesheet.
    wp_enqueue_style( 'london-main', THEME_CSS . 'style.css', array( 'london-style' ), '20141010' );
    wp_enqueue_style( 'london-woocommerce', THEME_CSS . 'woocommerce.css', array('london-main'));
    
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'london-ie', THEME_CSS . 'ie.css', array( 'london-style' ), '20141010' );
	wp_style_add_data( 'london-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    
    wp_enqueue_script( 'mousewheel-script', THEME_JS . 'jquery.mousewheel.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'ktSticky-script', THEME_JS . 'jquery.kt.sticky.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'mousewheel-script', THEME_JS . 'jquery.mousewheel.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'london-script', THEME_JS . 'functions.js', array( 'jquery' ), null, true );
	
}
add_action( 'wp_enqueue_scripts', 'london_scripts' );
