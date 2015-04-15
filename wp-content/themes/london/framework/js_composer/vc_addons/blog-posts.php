<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_List_Blog_Posts extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title' => '',
            'category' => '',
            'per_page' => 10,
            'orderby' => '',
            'heading' => 'h2',
            'order' => '',
            'css' => '',
            'el_class' => '',
        ), $atts );
        extract($atts);
        
        $output = '';

        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'list-blog-posts ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );


        $output .= '<div class="'.esc_attr( $elementClass ).'">';
        
            if($title){
                if( $heading == '' ){
                    $heading = 'h2';
                }
                $heading_class = "block-heading";
                $output .= '<'.$heading.' class="'.$heading_class.'">'.$title.'</'.$heading.'>';

            }


            $category = ($category) ? explode(',', $category ) : false;

            $output .= "<div class='blog-posts'>";

        		$args = array(
        			'posts_per_page'	=> $atts['per_page'],
        			'orderby' 			=> $atts['orderby'],
        			'order' 			=> $atts['order'],
        			'no_found_rows' 	=> 1,
        			'post_status' 		=> 'publish',
        			'post_type' 		=> 'post',
        		);
                if( !empty( $category ) ){
                    $args['tax_query'] = array( array( 'taxonomy' => 'product_cat', 'field' => 'id', 'terms' => $category, 'operator' => 'IN' ) );
                }
                
                ob_start();
                global $wp_query, $post;
                $wp_query = new WP_Query( $args  );

                $posts = $wp_query->get_posts();

                $n  =  count( $posts );


                if ( $n ) :
                    foreach ( $posts as $i => $post ) :
                        setup_postdata(  $post );
                        $classes =  array();
                        $classes[] = 'post-item';
                        if( $i ==0 ){
                            $classes[] = 'post-item-first';
                        }

                        if( $i == $n-1 ){
                            $classes[] = 'post-item-last';
                        }

                        ?>
                        <div <?php post_class('post-item'); ?>>
                            <div class="entry-date-time">
                                <div class="m"> <?php the_time( 'M' ); ?></div>
                                <div class="d"> <?php the_time( 'd' ); ?></div>
                                <div class="y"> <?php the_time( 'Y' ); ?></div>
                            </div>
                            <div class="post-info">
                                <?php if( has_post_thumbnail() ){
                                    ?>
                                    <div class="entry-thumb">
                                        <?php
                                        the_post_thumbnail('blog-post');
                                        ?>
                                    </div>
                                    <?php
                                } ?>
                                <div class="entry-ci">
                                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="entry-meta-data">
                                        <?php
                                        printf( '<span class="author vcard">'.__('Posed by:', THEME_LANG ).' <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                                            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                                            esc_attr( sprintf( __( 'View all posts by %s', 'THEME_LANG' ), get_the_author() ) ),
                                            get_the_author()
                                        );
                                        ?>
                                        <span class="cat"><?php the_category(', '); ?></span>
                                    <span class="comment-count"><?php comments_number(
                                            __('Comments: 0', THEME_LANG),
                                            __('Comment: 1', THEME_LANG),
                                            __('Comments: %', THEME_LANG)
                                        ); ?></span>
                                    </div>
                                    <div class="entry-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <div class="entry-more">
                                        <a href="<?php the_permalink() ?>"><?php _e('Read more', THEME_LANG ); ?></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php

                    endforeach; // end of the loop.
        		endif;
        		$wp_query->reset_postdata();

        		$output .= ob_get_clean();

            $output .= "</div><!-- .blog-posts -->";
        $output .= "</div>";   
        
        return $output;
    }
}

// Add your Visual Composer logic here
vc_map( array(
    "name" => __( "Blog Posts", THEME_LANGUAGE),
    "base" => "list_blog_posts",
    "category" => __('by Cuongdv'),
    "description" => __( "Display blog posts", THEME_LANGUAGE),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANGUAGE ),
            "param_name" => "title",
            "admin_label" => true,
            'description' => __( 'Leave empty to hide.', 'js_composer' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => __( 'Heading tag', 'js_composer' ),
            'param_name' => 'heading',
            'value' => array(
                __( 'Default', 'js_composer' ) => '',
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h5' => 'h6',

            ),
            'description' => 'Select element tag.'
        ),

        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'category',
			'heading' => __( 'Category', 'js_composer' ),
			'param_name' => 'category',
            'multiple' => true,
            "placeholder" => 'Please select your category',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", LANGUAGE_ZONE)
        ),
        array(
			'type' => 'textfield',
			'heading' => __( 'Per page', 'js_composer' ),
			'value' => 12,
			'param_name' => 'per_page',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
		),
        array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'js_composer' ),
			'param_name' => 'orderby',
			'value' => array(
                '',
                __( 'Date', 'js_composer' ) => 'date',
    			__( 'ID', 'js_composer' ) => 'ID',
    			__( 'Author', 'js_composer' ) => 'author',
    			__( 'Title', 'js_composer' ) => 'title',
    			__( 'Modified', 'js_composer' ) => 'modified',
    			__( 'Random', 'js_composer' ) => 'rand',
    			__( 'Comment count', 'js_composer' ) => 'comment_count',
    			__( 'Menu order', 'js_composer' ) => 'menu_order',
            ),
			'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'js_composer' ),
			'param_name' => 'order',
			'value' => array(
                    '',
    			__( 'Descending', 'js_composer' ) => 'DESC',
    			__( 'Ascending', 'js_composer' ) => 'ASC',
            ),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),

        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
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


