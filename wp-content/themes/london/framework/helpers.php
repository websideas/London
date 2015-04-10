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
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/

if (!function_exists('themedev_sidebars')){
    function themedev_sidebars( $option=false, $default=false ){
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

if (!function_exists('themedev_option')){
    function themedev_option( $option=false, $default=false ){
        if($option === FALSE){
            return FALSE;
        }
        $themedev_options = get_option(THEME_OPTIONS);
        if(isset($themedev_options[$option]) && $themedev_options[$option] !== ''){
            return $themedev_options[$option];
        }else{
            return $default;
        }
    }
}

/**
 * Get Layout of post
 * 
 * @param number $post_id Optional. ID of article or page.
 * @return string
 * 
 */
function themedev_getlayout($post_id = null){
    global $post;
	if(!$post_id) $post_id = $post->ID;

    $layout = rwmb_meta('kt_layout');
    
    if($layout == 'default' || !$layout){
        $layout = themedev_option('layout', 'full');
    }
    
    return $layout;
}

/**
 * Get Header
 * 
 * @return string
 * 
 */

function themedev_getHeader(){
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
function themedev_getHeaderLayout(){
    $layout = themedev_option('header', 'layout1');
    if(is_page() || is_singular('post')){
        $header_layout = rwmb_meta('kt_header');
        if($header_layout != '' && $header_layout != 'default'){
            $layout = $header_layout;
        }
    }
    return $layout;
}

/**
 * Get Layout sidebar of post
 * 
 * @return array
 * 
 */
function themedev_sidebar(){
    global $post;
    
    $sidebar = themedev_option('sidebar', 'full');
    $sidebar_left = themedev_option('sidebar_left', 'primary-widget-area');
    $sidebar_right = themedev_option('sidebar_right', 'primary-widget-area');
    
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