<?php

/**
 * All helpers for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 * Add search to header
 * 
 * 
 */
function kt_search_form(){
    if(kt_is_wc()){
        get_product_search_form();
    }else{
        get_search_form();
    }
}
/**
 * Function check if WC Plugin installed
 */
function kt_is_wc(){
    return function_exists('is_woocommerce');
}

/**
 *  @true  if WPML installed.
 */
function  kt_is_wpml(){
    return function_exists('icl_get_languages');
}

/**
 * Get Page id - Supported WPML Plguin
 * @return page id
 */
function kt_get_page_id(  $ID , $post_type= 'page'){
    if(kt_is_wpml()){
        $ID =   icl_object_id($ID, $post_type , true) ;
    }
    return $ID;
}


/**
 * Custom wpml
 *
 */

function kt_custom_wpml(){
    if(kt_is_wpml()){
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){

            foreach( $languages as $lang_k=>$lang ){
                if( $lang['active'] ){
                    $active_lang = $lang;
                }
            }

            echo '<div class="kt-wpml-languages">';

            if($active_lang['country_flag_url']){
                printf(
                    '<div class="current-language"><img src="%s" height="12" width="18" alt="%s" /><span>%s</span></div>',
                    esc_url($active_lang['country_flag_url']),
                    esc_attr($active_lang['language_code']),
                    icl_disp_language($active_lang['native_name'], false)
                );
            }

            echo '<ul>';
            foreach($languages as $l){
                echo '<li>';
                if(!$l['active']) {
                    echo '<a href="'.$l['url'].'">';
                }else{
                    echo '<span>';
                }
                    if($l['country_flag_url']){
                        echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                    }
                    echo "<span>".icl_disp_language($l['native_name'], false)."</span>";
                if(!$l['active']){
                    echo '</a>';
                }else{
                    echo '<span>';
                }
                echo '</li>';
            }
            echo '</ul></div>';
        }
    }
}

/**
 * Get class for wrapper mobile content
 *
 */
function kt_class_mobile(){
    $count = 1;
    if(kt_is_wc()){
        $count++;
    }
    if(kt_is_wpml()){
        $count++;
    }
    echo 'tool-mobile-'.$count;
}

/**
 *
 * Detect plugin.
 *
 * @param $plugin example: 'plugin-directory/plugin-file.php'
 */

function kt_is_active_plugin(   $plugin ){
    if(  !function_exists( 'is_plugin_active' ) ){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    // check for plugin using plugin name
    return is_plugin_active( $plugin ) ;
}

/**
 * Flag boolean.
 * 
 * @param $input string
 * @return boolean
 */
function sanitize_boolean( $input = '' ) {
	return in_array($input, array('1', 'true', 'y', 'on'));
}
add_filter( 'sanitize_boolean', 'sanitize_boolean', 15 );

/**
 * Convert hexdec color string to rgb(a) string
 * 
 * @param $color string
 * @param $opacity boolean
 * @return void
 */
 
function kt_hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

/**
 * Convert hexdec color string to darken or lighten
 * 
 * http://lab.clearpixel.com.au/2008/06/darken-or-lighten-colours-dynamically-using-php/
 * 
 * $brightness = 0.5; // 50% brighter
 * $brightness = -0.5; // 50% darker
 * 
 */

function kt_colour_brightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

/**
* Function to get sidebars
* 
* @return array
*/

if (!function_exists('kt_sidebars')){
    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
    }
}

/**
* Function to get image sizes
* 
* @return array
*/

if (!function_exists('kt_get_image_sizes')){
    function kt_get_image_sizes( $size = '' ) {

            global $_wp_additional_image_sizes;
    
            $sizes = array();
            $get_intermediate_image_sizes = get_intermediate_image_sizes();
    
            // Create the full array with sizes and crop info
            foreach( $get_intermediate_image_sizes as $_size ) {
    
                    if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
    
                            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
    
                    } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
    
                            $sizes[ $_size ] = array( 
                                    'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                                    'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                                    'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                            );
    
                    }
    
            }
    
            // Get only 1 size if found
            if ( $size ) {
    
                    if( isset( $sizes[ $size ] ) ) {
                            return $sizes[ $size ];
                    } else {
                            return false;
                    }
    
            }
    
            return $sizes;
    }
}


/**
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/

if (!function_exists('kt_option')){
    function kt_option( $option=false, $default=false ){
        if($option === FALSE){
            return FALSE;
        }
        $option_name =  apply_filters('theme_option_name', THEME_OPTIONS );
        $kt_options = wp_cache_get( $option_name );
        if(  !$kt_options ){

            $kt_options = get_option( $option_name );
            if( empty($kt_options)  ){
                // get default theme option
                if( defined('ICL_LANGUAGE_CODE') ){
                    $kt_options = get_option( THEME_OPTIONS );
                }
            }
            wp_cache_delete( $option_name );
            wp_cache_add( $option_name, $kt_options );
        }

        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}

/**
 * Get logo of current page
 * 
 * @return string
 * 
 */
function kt_get_logo(){
    $logo = array('default' => '', 'retina' => '','sticky' => '', 'sticky_retina' => '');
    
    $logo_default = kt_option( 'logo' );
    $logo_retina = kt_option( 'logo_retina' );
    $logo_sticky = kt_option( 'logo_sticky' );
    $logo_retina_sticky = kt_option( 'logo_retina_sticky' );
    
    
    if(is_array($logo_default) && $logo_default['url'] != '' ){
        $logo['default'] = $logo_default['url'];
    }
    
    if(is_array($logo_retina ) && $logo_retina['url'] != '' ){
        $logo['retina'] = $logo_retina['url'];
    }
    
    if(is_array($logo_sticky ) && $logo_sticky['url'] != '' ){
        $logo['sticky'] = $logo_sticky['url'];
    }else{
        $logo['sticky'] = $logo['default'];
    }
    
    if(is_array($logo_retina_sticky ) && $logo_retina_sticky['url'] != '' ){
        $logo['sticky_retina'] = $logo_retina_sticky['url'];
    }
    
    $layout = kt_option('header', 'layout1');
    
    if($layout == 'layout1'){
        if(!$logo['retina'] && !$logo['default']){
            $logo['retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['default']){
            $logo['default'] = THEME_IMG.'logo.png';
        }
        if(!$logo['sticky_retina'] && !$logo['sticky']){
            $logo['sticky_retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['sticky']){
            $logo['sticky'] = THEME_IMG.'logo.png';
        }
    }elseif($layout == 'layout2' || $layout == 'layout3'){
        if(!$logo['retina'] && !$logo['default']){
            $logo['retina'] = THEME_IMG.'logo-black-retina.png';
        }
        if(!$logo['default']){
            $logo['default'] = THEME_IMG.'logo-black.png';
        }
        if(!$logo['sticky_retina'] && !$logo['sticky']){
            $logo['sticky_retina'] = THEME_IMG.'logo-retina.png';
        }
        if(!$logo['sticky']){
            $logo['sticky'] = THEME_IMG.'logo.png';
        }
    }
    
    
    
    
    return $logo;
}

/**
 * Get Layout of post
 * 
 * @param number $post_id Optional. ID of article or page.
 * @return string
 * 
 */
function kt_getlayout($post_id = null){
    global $post;
	if(!$post_id) $post_id = $post->ID;

    $layout = rwmb_meta('_kt_layout');
    
    if($layout == 'default' || !$layout){
        $layout = kt_option('layout', 'full');
    }
    
    return $layout;
}

/**
 * Get Header
 * 
 * @return string
 * 
 */

function kt_get_header(){
    $header = 'default';
    if(is_page() || is_singular('post')){
        $header_position = rwmb_meta('_kt_header_position');
        if($header_position){
            $header = $header_position;
        }
    }
    return $header;
}

/**
 * Get Header Layout
 * 
 * @return string
 * 
 */
function kt_get_header_layout(){
    $layout = kt_option('header', 'layout1');
    return $layout;
}

/**
 * Get Layout sidebar of post
 * 
 * @return array
 * 
 */
function kt_sidebar(){
    global $post;
    
    $sidebar = kt_option('sidebar', 'full');
    $sidebar_left = kt_option('sidebar_left', 'primary-widget-area');
    $sidebar_right = kt_option('sidebar_right', 'primary-widget-area');

    if( kt_is_wc() ){
        if( is_shop() || is_product_category() || is_product_tag() ){
            $sidebar = kt_option('shop_sidebar', 'full');
            $sidebar_left = kt_option('shop_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('shop_sidebar_right', 'shop-widget-area');
        }elseif( is_product() ){
            $sidebar = kt_option('product_sidebar', 'full');
            $sidebar_left = kt_option('product_sidebar_left', 'shop-widget-area');
            $sidebar_right = kt_option('product_sidebar_right', 'shop-widget-area');
        }elseif(is_cart()){
            return array('sidebar' => 'full', 'sidebar_area' => null);
        }
    }
    
    if($sidebar == 'left'){
        $sidebar_area = $sidebar_left;
    }elseif($sidebar == 'right'){
        $sidebar_area = $sidebar_right;
    }else{
        $sidebar_area = null;
    }
    
    $layout_sidebar = array(
        'sidebar' => $sidebar,
        'sidebar_area' => $sidebar_area        
    );
    
    if(is_page() || is_singular('post') || is_singular('designer')){
        $sidebar_post = rwmb_meta('_kt_sidebar');
        if($sidebar_post != 'default' && $sidebar_post){
            $layout_sidebar['sidebar'] = $sidebar_post;
            if($sidebar_post == 'left'){
                $sidebar_left_post = rwmb_meta('_kt_left_sidebar');
                if($sidebar_left_post  == 'default'){
                    $sidebar_left_post = $sidebar_left;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_left_post;
            }elseif($sidebar_post == 'right'){
                $sidebar_right_post = rwmb_meta('_kt_right_sidebar');
                if($sidebar_right_post  == 'default'){
                    $sidebar_right_post = $sidebar_right;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_right_post;
            }
        }
        
    }

    return $layout_sidebar;
}

/**
 * Get link attach from thumbnail_id.
 *
 * @param number $thumbnail_id ID of thumbnail.
 * @param string|array $size Optional. Image size. Defaults to 'post-thumbnail'
 * @return array
 */
if (!function_exists('get_thumbnail_attachment')){
    function get_thumbnail_attachment($thumbnail_id ,$size = 'post-thumbnail'){
        if(!$thumbnail_id) return ;
        
        $attachment = get_post( $thumbnail_id );
        if(!$attachment) return;
        
        $image = wp_get_attachment_image_src($thumbnail_id, $size);
    	return array(
    		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    		'caption' => $attachment->post_excerpt,
    		'description' => $attachment->post_content,
            'src' => $attachment->guid,
    		'url' => $image[0],
    		'title' => $attachment->post_title
    	);
    }
}

/**
 * Get image form meta.
 * 
 * @param string $meta. meta id of article.
 * @param string|array $size Optional. Image size. Defaults to 'screen'.
 * @param number $post_id Optional. ID of article.
 * @return array
 */

function get_link_image_post($meta, $post_id = null, $size = 'screen') {
	global $post;
	if(!$post_id) $post_id = $post->ID;
    
	$media_image = rwmb_meta($meta, 'type=image&size='.$size, $post_id);
    
	if(!$media_image) return;
    
	foreach ($media_image as $item) {
		return $item;
		break;
	}
}

/**
 * Get all image form meta box.
 *
 * @param string $meta. meta id of article.
 * @param string|array $size Optional. Image size. Defaults to 'screen'.
 * @param array $post_id Optional. ID of article.
 * @return array
 */
function get_gallerys_post($meta, $size = 'screen', $post_id = null) {
	global $post;
	if(!$post_id) $post_id = $post->ID;
	
	$media_image = rwmb_meta($meta, 'type=image&size='.$size, $post_id);
	return (count($media_image)) ? $media_image : false;
}


/**
 * Render data option for carousel
 * 
 * @param $data array. All data for carousel
 * 
 */
function render_data_carousel($data){
    $output = "";
    foreach($data as $key => $val){
        if($val){
            $output .= ' data-'.$key.'="'.esc_attr($val).'"';
        }
    }
    return $output;
}


/**
 * Get carousel products for collection.
 *
 *
 */
function get_carousel_products_collection($collection_id, $atts = array()){

    extract( shortcode_atts( array(
        'theme' => 'style-navigation-top',
        'desktop' => 4,
        'tablet' => 2,
        'mobile' => 1,
    ), $atts ) );

    $args = array(
        'posts_per_page'	=> -1,
        'post_status' 		=> 'publish',
        'post_type' 		=> 'product',
        'meta_query' => array(
            array(
                'key'     => '_kt_collection',
                'value'   => $collection_id,
                'compare' => '=',
            ),
        ),
    );
    $output = '';

    $args =  apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) ;
    $products = new WP_Query( $args );

    global $woocommerce_loop;
    $woocommerce_loop['columns'] =  $desktop;


    if ( $products->have_posts() ) :
        $itemscustom = '[[992,'.$desktop.'], [768, '.$tablet.'], [480, '.$mobile.']]';
        $output .= '<div class="woocommerce-carousel-wrapper" data-theme="'.$theme.'" data-itemscustom="'.$itemscustom.'">';
        ob_start();
        woocommerce_product_loop_start();
        while ( $products->have_posts() ) : $products->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile; // end of the loop.
        woocommerce_product_loop_end();
        $output .= '<div class="woocommerce  columns-' . $desktop . '">' . ob_get_clean() . '</div>';
        $output .= '</div><!-- .woocommerce-carousel-wrapper -->';
    endif;
    wp_reset_postdata();

    echo $output;
}