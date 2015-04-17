<?php

/**
 * All helpers for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


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
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/

if (!function_exists('kt_sidebars')){
    function kt_sidebars( $option=false, $default=false ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
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
        $kt_options = get_option(THEME_OPTIONS);
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

    $logo = array('default' => THEME_IMG.'logo.png', 'retina' => false);
    $logo_default = kt_option( 'logo' );
    $logo_retina = kt_option( 'logo_retina' );
    
    if(is_array($logo_default)){
        $logo['default'] = $logo_default['url'];
    }
    
    if(is_array($logo_retina)){
        $logo['retina'] = $logo_retina['url'];
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

    $layout = rwmb_meta('kt_layout');
    
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
        $header_position = rwmb_meta('kt_header_position');
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
    
    if($sidebar == 'left'){
        $sidebar_area = $sidebar_left;
    }elseif($sidebar == 'right'){
        $sidebar_area = $sidebar_right;
    }else{
        $sidebar_area = null;
    }
    
    $layout_sidebar = array('sidebar' => $sidebar, 'sidebar_area' => $sidebar_area);
    if(is_cart()){
        $layout_sidebar = array('sidebar' => 'full', 'sidebar_area' => null);
    }elseif(is_page() || is_singular('post')){
        $sidebar_post = rwmb_meta('kt_sidebar');
        if($sidebar_post != 'default' && $sidebar_post){
            $layout_sidebar['sidebar'] = $sidebar_post;
            if($sidebar_post == 'left'){
                $sidebar_left_post = rwmb_meta('kt_left_sidebar');
                if($sidebar_left_post  == 'default'){
                    $sidebar_left_post = $sidebar_left;
                }
                $layout_sidebar['sidebar_area'] = $sidebar_left_post;
            }elseif($sidebar_post == 'right'){
                $sidebar_right_post = rwmb_meta('kt_right_sidebar');
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
            $output .= ' data-'.$key.'="'.$val.'"';
        }
    }
    return $output;
}