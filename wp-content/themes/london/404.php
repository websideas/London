<?php
/**
 * The template for displaying error 404
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */


get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>
        <div class="row">
            <div id="main" class="content-404">
                <div class="page-not-found">
                    <div class="img-404">
                        <img alt="Page not found" src="<?php echo get_template_directory_uri() ?>/assets/images/img-404.jpg">
                    </div>
                    <h1><?php _e('This page is not available', THEME_LANGUAGE) ?></h1>

                    <p>
                        <?php _e('We\'re sorry, but the Web address you\'ve entered is no longer available.', THEME_LANGUAGE ); ?>
                    </p>

                    <h3><?php _e('To find a product, please type its name in the field below.', THEME_LANGUAGE ); ?></h3>
                    <form class="std" method="post" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <fieldset>
                            <div>
                                <label for="search_query"><?php _e('Search this site:', THEME_LANGUAGE ) ?></label>
                                <input type="text" class="form-control grey" name="search_query" id="search_query">
                                <button class="btn btn-default button button-small" value="OK" name="Submit" type="submit"><span><?php _e('Ok', THEME_LANGUAGE ) ?></span></button>
                            </div>
                        </fieldset>
                    </form>
                    <div class="buttons"><a title="<?php _e('Home', 'THEME_LANGUAGE'); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default button button-medium"><span><i class="icon-chevron-left left"></i><?php _e('Home page', THEME_LANGUAGE ); ?></span></a></div>
                </div>
            </div>
        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>