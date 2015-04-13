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
        add_image_size( 'recent_posts', 570, 380, true);
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
 * @since London 1.0
 */
function london_scripts() {

    wp_enqueue_style( 'london-style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', THEME_LIBS . 'bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style( 'font-awesome-css', THEME_FONTS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'mCustomScrollbar-css', THEME_CSS . 'jquery.mCustomScrollbar.min.css', array());
    wp_enqueue_style( 'magnific-popup-css', THEME_CSS . 'magnific-popup.css', array());
    wp_enqueue_style( 'owl-carousel-css', THEME_LIBS . 'owl-carousel/owl.carousel.css', array());
    wp_enqueue_style( 'owl-carousel-theme', THEME_LIBS . 'owl-carousel/owl.theme.css', array());
    wp_enqueue_style( 'easyzoom', THEME_CSS . 'easyzoom.css', array());
    
	// Load our main stylesheet.
    wp_enqueue_style( 'london-main', THEME_CSS . 'style.css', array( 'london-style' ), '20141010' );
    wp_enqueue_style( 'woocommerce-css', THEME_CSS . 'woocommerce.css', array('london-main'));
    wp_enqueue_style( 'queries-css', THEME_CSS . 'queries.css', array('london-main'));
    
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'london-ie', THEME_CSS . 'ie.css', array( 'london-style' ), '20141010' );
	wp_style_add_data( 'london-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    wp_enqueue_script( 'jquery-ui-tabs' );
    
    wp_enqueue_script( 'easing-script', THEME_JS . 'jquery.easing.1.3.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'bootstrap-script', THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'mCustomScrollbar-script', THEME_JS . 'jquery.mCustomScrollbar.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'mousewheel-script', THEME_JS . 'jquery.mousewheel.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'customSelect-script', THEME_JS . 'jquery.customSelect.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'ktSticky-script', THEME_JS . 'jquery.kt.sticky.js', array( 'jquery' ), null, true );    
    wp_enqueue_script( 'owl-carousel', THEME_LIBS . 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'superfish-script', THEME_JS . 'jquery.superfish.custom.js', array( 'jquery', 'hoverIntent' ), null, false );
    wp_enqueue_script( 'magnific-popup-script', THEME_JS . 'jquery.magnific-popup.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'countdown-script', THEME_JS . 'jquery.countdown.min.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'variations-plugin-script', THEME_JS . 'woo-variations-plugin.js', array( 'jquery' ), null, false );
    wp_enqueue_script( 'easyzoom', THEME_JS . 'easyzoom.js', array( 'jquery' ), null, false );
    
    
    wp_enqueue_script( 'london-script', THEME_JS . 'functions.js', array( 'jquery', 'wp-mediaelement' ), null, true );
	
    wp_localize_script( 'london-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' )
    ));
    
}
add_action( 'wp_enqueue_scripts', 'london_scripts' );

/**
 * Add scroll to top
 *
 * @since London 1.0
 */
add_action( 'theme_before_footer_top', 'theme_after_footer_top_addscroll' );
function theme_after_footer_top_addscroll(){
    echo "<a href='#top' id='backtotop'></a>";
}



