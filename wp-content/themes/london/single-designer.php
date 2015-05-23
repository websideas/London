<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

$sidebar = kt_sidebar();

get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' );

        the_post();

        $designer_id = get_the_ID();

        ?>
        <div class="row">
            <div id="main" class="<?php echo apply_filters('kt_main_class', 'main-class', $sidebar['sidebar']); ?>">
                <?php
                if( rwmb_meta('_kt_show_title') || rwmb_meta('_kt_show_title') == '' ){
                    ?>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php
                    if( rwmb_meta('_kt_show_taglitle') ){
                        $tagline =  rwmb_meta('_kt_tagline');
                        if( $tagline !='' ){ ?>
                            <div class="term-description"><p><?php echo esc_html( $tagline ); ?></p></div>
                        <?php }
                    }
                } ?>
                <div class="clear"></div>
                <?php

                if(has_post_thumbnail()){
                    echo '<div class="desinger-content-wrapper row">';
                    echo '<div class="desinger-content-left col-xs-12 col-sm-3 col-md-3">';
                    echo get_the_post_thumbnail( get_the_ID(), 'full', array('class'=>"img-responsive"));
                    echo "</div>";
                    echo '<div class="desinger-content-right col-xs-12 col-sm-9 col-md-9">';
                }

                // Include the page content template.
                get_template_part( 'content', 'page' );

                if(has_post_thumbnail()){
                    echo "</div></div>";
                }

                ?>

                <?php

                $args = array(
                    'post_type' => 'collection',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key'     => '_kt_colection',
                            'value'   => $designer_id,
                            'compare' => ''
                        ),
                    ),
                );

                $query = new WP_Query( $args );

                if ( $query->have_posts() ) {
                    echo '<div class="designer-colection-wrapper">';
                    while ( $query->have_posts() ) : $query->the_post();
                        $collection_id = get_the_ID();
                        echo '<div class="designer-colection-item carousel-wrapper-top">';


                            $heading_class = "block-heading block-heading-underline";
                            echo '<div class="'.$heading_class.'"><h3>'.get_the_title().'</h3></div>';

                            $atts = array();
                            if($desktop = rwmb_meta('_kt_desktop', array(), $designer_id)){
                                $atts['desktop'] = intval($desktop);
                            }
                            if($tablet = rwmb_meta('_kt_tablet', array(), $designer_id)){
                                $atts['tablet'] = intval($tablet);
                            }
                            if($mobile = rwmb_meta('_kt_mobile', array(), $designer_id)){
                                $atts['mobile'] = intval($mobile);
                            }

                            echo get_carousel_products_collection($collection_id, $atts);

                        echo "</div>";
                    endwhile;
                    echo "</div>";
                }
                wp_reset_postdata();

                ?>



            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('kt_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>