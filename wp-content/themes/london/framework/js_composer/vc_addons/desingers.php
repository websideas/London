<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Designers extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'title' => '',
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'max_items' => 10,
            'element_width_desktop' => 4,
            'element_width_tablet' => 6,
            'element_width_mobile' => 12,
            'el_class' => '',
            'css_animation' => '',
            'css' => ''
        ), $atts ) );

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'designers-masonry-wrapper ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        $output = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'">';
        $output .= ($title) ? '<h3 class="title_block">'.$title.'</h3>' : '';

        $args = array(
            'order' => $order,
            'orderby' => $orderby,
            'posts_per_page' => $max_items,
            'post_type' => 'designer',
        );

        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }

        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
            $output .= '<div class="designers-masonry-content row">';
            $i =0;
            $column_desktop = intval(12 / $element_width_desktop);
            $column_tablet = intval(12 / $element_width_tablet);


            while ( $query->have_posts() ) : $query->the_post();
                $clearfix_desktop = ($i % $column_desktop == 0) ? 'col-clearfix-md' : '';
                $clearfix_tablet = ($i % $column_tablet == 0) ? 'col-clearfix-sm' : '';

                $output .= '<div class="designer-post-item-wrapper col-md-'.$element_width_desktop.' col-sm-'.$element_width_tablet.' col-xs-12 '.$clearfix_desktop.' '.$clearfix_tablet.'">';
                $output .= '<div class="designer-post-item">';

                if(has_post_thumbnail()){
                    $output .= '<a href="'.get_permalink().'">';
                    $output .= get_the_post_thumbnail(get_the_ID(), 'full', array('class'=>"img-responsive"));
                    $output .= '</a>';
                }
                $output .= sprintf(
                    '<p class="info"><a href="%1$s" title="%2$s"><span class="name">%3$s</span></a>&nbsp;<span class="company">%4$s</span></p>',
                    get_permalink(  ),
                    get_the_title(  ),
                    get_the_title(  ),
                    rwmb_meta( '_kt_description', false )
                );
                $output .= rwmb_meta( '_kt_info', false );
                $output .= '</div>';
                $output .= '</div>';
                $i++;
            endwhile; wp_reset_postdata();
            $output .= '</div>';
        endif;


        $output .= '</div>';

        return $output;
    }
}

vc_map( array(
    "name" => __( "Designers masonry", THEME_LANG),
    "base" => "designers",
    "category" => __('by Theme', THEME_LANG ),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Total items', 'js_composer' ),
            'param_name' => 'max_items',
            'value' => 10, // default value
            'param_holder_class' => 'vc_not-for-custom',
            'description' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'js_composer' )
        ),

        array(
            "type" => "kt_heading",
            "heading" => __("Grid elements per row", THEME_LANG),
            "param_name" => "element_width_heading",
        ),


        array(
            'type' => 'dropdown',
            'heading' => __( 'Desktop', 'js_composer' ),
            'param_name' => 'element_width_desktop',
            'value' => array(
                "- 6 -" => '2',
                "- 4 -" => '3' ,
                "- 3 -" => '4' ,
                "- 2 -" => '6' ,
                "- 1 -" => '12'
            ),
            'std' => '4',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'description' => __( 'Select number of single grid elements per row in desktop.', 'js_composer' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Tablet', 'js_composer' ),
            'param_name' => 'element_width_tablet',
            'value' => array(
                "- 6 -" => '2',
                "- 4 -" => '3' ,
                "- 3 -" => '4' ,
                "- 2 -" => '6' ,
                "- 1 -" => '12'
            ),
            'std' => '6',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'description' => __( 'Select number of single grid elements per row in tablet.', 'js_composer' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Mobile', 'js_composer' ),
            'param_name' => 'element_width_mobile',
            'value' => array(
                "- 6 -" => '2',
                "- 4 -" => '3' ,
                "- 3 -" => '4' ,
                "- 2 -" => '6' ,
                "- 1 -" => '12'
            ),
            'std' => '12',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'description' => __( 'Select number of single grid elements per row in mobile.', 'js_composer' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'admin_label' => true,
            'value' => array(
                __( 'No', 'js_composer' ) => '',
                __( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
                __( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
                __( 'Left to right', 'js_composer' ) => 'left-to-right',
                __( 'Right to left', 'js_composer' ) => 'right-to-left',
                __( 'Appear from center', 'js_composer' ) => "appear"
            ),
            'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),

        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        // Data settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Order by post ID', 'js_composer' ) => 'ID',
                __( 'Author', 'js_composer' ) => 'author',
                __( 'Title', 'js_composer' ) => 'title',
                __( 'Last modified date', 'js_composer' ) => 'modified',
                __( 'Meta value', 'js_composer' ) => 'meta_value',
                __( 'Random order', 'js_composer' ) => 'rand',
            ),
            'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'dependency' => array(
                'element' => 'orderby',
                'value' => array( 'meta_value', 'meta_value_num' ),
            ),
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'group' => __( 'Data settings', 'js_composer' ),
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'description' => __( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
        ),

        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        ),
    ),
));