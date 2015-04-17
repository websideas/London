<?php
/* SOCIAL SHORTCODE
================================================= */

function kt_social_icons($atts, $content = null) {
	extract(shortcode_atts(array(
	   'type' => '',
       'size' => ''
	), $atts));	
    
    $facebook = kt_option('facebook_page_url');
	$twitter = kt_option('twitter_username');
    $pinterest = kt_option('pinterest_username');
	$dribbble = kt_option('dribbble_username');
	$vimeo = kt_option('vimeo_username');
	$tumblr = kt_option('tumblr_username');
    $skype = kt_option('skype_username');
    $linkedin = kt_option('linkedin_page_url');
    $googleplus = kt_option('googleplus_page_url');
    $email_address = kt_option('email-address');
    $youtube = kt_option('youtube_username');
    $instagram = kt_option('instagram_username');
	
	$social_icons = '';
	
	if ($type == '') {
        if ($facebook) {
			$social_icons .= '<li class="facebook"><a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a></li>'."\n";
		}
		if ($twitter) {
			$social_icons .= '<li class="twitter"><a href="http://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a></li>'."\n";
		}
		if ($dribbble) {
			$social_icons .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a></li>'."\n";
		}
		if ($vimeo) {
			$social_icons .= '<li class="vimeo"><a href="http://www.vimeo.com/'.$vimeo.'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>'."\n";
		}
		if ($tumblr) {
			$social_icons .= '<li class="tumblr"><a href="http://'.$tumblr.'.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a></li>'."\n";
		}
		if ($skype) {
			$social_icons .= '<li class="skype"><a href="skype:'.$skype.'" target="_blank"><i class="fa fa-skype"></i></a></li>'."\n";
		}
		if ($linkedin) {
			$social_icons .= '<li class="linkedin"><a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a></li>'."\n";
		}
		if ($googleplus) {
			$social_icons .= '<li class="googleplus"><a href="'.$googleplus.'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'."\n";
		}
		if ($youtube) {
			$social_icons .= '<li class="youtube"><a href="http://www.youtube.com/user/'.$youtube.'" target="_blank"><i class="fa fa-youtube"></i></a></li>'."\n";
		}
		if ($pinterest) {
			$social_icons .= '<li class="pinterest"><a href="http://www.pinterest.com/'.$pinterest.'/" target="_blank"><i class="fa fa-pinterest"></i></a></li>'."\n";
		}
		if ($instagram) {
			$social_icons .= '<li class="instagram"><a href="http://instagram.com/'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a></li>'."\n";
		}
	} else {
	
		$social_type = explode(',', $type);
		foreach ($social_type as $id) {
            if ($id == "facebook") {
				$social_icons .= '<li class="facebook"><a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a></li>'."\n";
			}
			if ($id == "twitter") {
				$social_icons .= '<li class="twitter"><a href="http://www.twitter.com/'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a></li>'."\n";
			}
			if ($id == "dribbble") {
				$social_icons .= '<li class="dribbble"><a href="http://www.dribbble.com/'.$dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a></li>'."\n";
			}
			if ($id == "vimeo") {
				$social_icons .= '<li class="vimeo"><a href="http://www.vimeo.com/'.$vimeo.'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>'."\n";
			}
			if ($id == "tumblr") {
				$social_icons .= '<li class="tumblr"><a href="http://'.$tumblr.'.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a></li>'."\n";
			}
			if ($id == "skype") {
				$social_icons .= '<li class="skype"><a href="skype:'.$skype.'" target="_blank"><i class="fa fa-skype"></i></a></li>'."\n";
			}
			if ($id == "linkedin") {
				$social_icons .= '<li class="linkedin"><a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a></li>'."\n";
			}
			if ($id == "googleplus") {
				$social_icons .= '<li class="googleplus"><a href="'.$googleplus.'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'."\n";
			}
			if ($id == "youtube") {
				$social_icons .= '<li class="youtube"><a href="http://www.youtube.com/user/'.$youtube.'" target="_blank"><i class="fa fa-youtube"></i></a></li>'."\n";
			}
			if ($id == "pinterest") {
				$social_icons .= '<li class="pinterest"><a href="http://www.pinterest.com/'.$pinterest.'/" target="_blank"><i class="fa fa-pinterest"></i></a></li>'."\n";
			}
			if ($id == "instagram") {
				$social_icons .= '<li class="instagram"><a href="http://instagram.com/'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a></li>'."\n";
			}
		}
	}
	
	$output = '<ul class="kt_social_icons '.$size.'">';
        $output .= $social_icons;
	$output .= '</ul>';
	
	return $output;
}
add_shortcode('kt_social', 'kt_social_icons');