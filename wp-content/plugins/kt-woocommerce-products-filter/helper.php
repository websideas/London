<?php

final class WOOF_HELPER
{

    public static function get_terms($taxonomy, $hide_empty = true, $get_childs = true, $selected = 0, $category_parent = 0)
    {
        $args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'style' => 'list',
            'show_count' => 0,
            'hide_empty' => $hide_empty,
            'use_desc_for_title' => 1,
            'child_of' => 0,
            'hierarchical' => true,
            'title_li' => '',
            'show_option_none' => '',
            'number' => '',
            'echo' => 0,
            'depth' => 0,
            'current_category' => $selected,
            'pad_counts' => 0,
            'taxonomy' => $taxonomy,
            'walker' => 'Walker_Category');


        //WPML compatibility
        if (class_exists('SitePress'))
        {
            $args['lang'] = ICL_LANGUAGE_CODE;
        }

        $cats_objects = get_categories($args);

        $cats = array();
        if (!empty($cats_objects))
        {
            foreach ($cats_objects as $value)
            {
                if (is_object($value) AND $value->category_parent == $category_parent)
                {
                    $cats[$value->term_id] = array();
                    $cats[$value->term_id]['term_id'] = $value->term_id;
                    $cats[$value->term_id]['slug'] = $value->slug;
                    $cats[$value->term_id]['taxonomy'] = $value->taxonomy;
                    $cats[$value->term_id]['name'] = $value->name;
                    $cats[$value->term_id]['count'] = $value->count;
                    if ($get_childs)
                    {
                        $cats[$value->term_id]['childs'] = self::assemble_terms_childs($cats_objects, $value->term_id);
                    }
                }
            }
        }
        return $cats;
    }

    //just for get_terms
    private static function assemble_terms_childs($cats_objects, $parent_id)
    {
        $res = array();
        foreach ($cats_objects as $value)
        {
            if ($value->category_parent == $parent_id)
            {
                $res[$value->term_id]['term_id'] = $value->term_id;
                $res[$value->term_id]['name'] = $value->name;
                $res[$value->term_id]['slug'] = $value->slug;
                $res[$value->term_id]['count'] = $value->count;
                $res[$value->term_id]['taxonomy'] = $value->taxonomy;
                $res[$value->term_id]['childs'] = self::assemble_terms_childs($cats_objects, $value->term_id);
            }
        }

        return $res;
    }

    //https://wordpress.org/support/topic/translated-label-with-wpml
    //for taxonomies labels translations
    public static function wpml_translate($string)
    {
        if (class_exists('SitePress'))
        {
            $lang = ICL_LANGUAGE_CODE;
            $woof_settings = get_option('woof_settings');
            if (isset($woof_settings['wpml_tax_labels']) AND ! empty($woof_settings['wpml_tax_labels']))
            {
                $translations = $woof_settings['wpml_tax_labels'];
                //$translations = unserialize($translations);
                /*
                  $translations = array(
                  'es' => array(
                  'Locations' => 'Ubicaciones',
                  'Size' => 'Tamaño'
                  ),
                  'de' => array(
                  'Locations' => 'Lage',
                  'Size' => 'Größe'
                  ),
                  );
                 */

                if (isset($translations[$lang]))
                {
                    if (isset($translations[$lang][$string]))
                    {
                        $string = $translations[$lang][$string];
                    }
                }
            }
        }

        return $string;
    }

}


function woof_get_tax_thumb( $term_id = '', $taxonomy_slug  = '', $size = 'thumbnail' ){

    if( in_array( $taxonomy_slug, apply_filters('woof_taxs_no_thumb', array( 'product_cat', 'product_tag', 'product_shipping_class' )) ) ){
        return false;
    }

    if( !function_exists( 'is_plugin_active') ){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    if ( ! is_plugin_active( 'woocommerce-variation-swatches-and-photos/woocommerce-swatches.php' ) ) {
        return false;
    }

    $meta_key= $taxonomy_slug . '_swatches_id' ;
    $type = get_woocommerce_term_meta($term_id, $meta_key . '_type', true);
    $color = get_woocommerce_term_meta($term_id, $meta_key. '_color', true);
    $thumbnail_id = get_woocommerce_term_meta($term_id, $meta_key. '_photo', true);
    $thumb_src = '';
    $thumb_src = WC()->plugin_url()  . '/assets/images/placeholder.png';

    if ($type == 'photo') {
        if ( $thumbnail_id ) {
            $imgsrc = wp_get_attachment_image_src( $thumbnail_id, $size );
            if ($imgsrc && is_array($imgsrc)) {
                $thumb_src = current($imgsrc);
            } else {
                $thumb_src = WC()->plugin_url()  . '/assets/images/placeholder.png';
            }
        } else {
            $thumb_src = WC()->plugin_url()  . '/assets/images/placeholder.png';
        }

        return '<span class="woof-tax-thumb  woof-tax-img"><img src="'.$thumb_src.'" alt=""></span>';

    } elseif ( $type == 'color') {
        if(  $color  != ''  ){
            return '<span class="woof-tax-thumb woof-tax-color" style="background-color: '.esc_attr( $color ).';"></span>';
        }
       // $color = $color;

    }

    return false;
}


function woof_product_list_classes( $class='' ){
    return $class.' woof-products';
}

add_filter('woocommerce_product_loop_start','woof_product_list_classes');