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
                <div class="pagenotfound">
                    <div class="img-404">
                        <img alt="Page not found" src="<?php echo get_template_directory_uri() ?>/assets/images/img-404.jpg">
                    </div>
                    <h1>This page is not available</h1>

                    <p>
                        We're sorry, but the Web address you've entered is no longer available.
                    </p>

                    <h3>To find a product, please type its name in the field below.</h3>
                    <form class="std" method="post" action="http://kutethemes.com/demo/fashion/london-stars6/en/search">
                        <fieldset>
                            <div>
                                <label for="search_query">Search our product catalog:</label>
                                <input type="text" class="form-control grey" name="search_query" id="search_query">
                                <button class="btn btn-default button button-small" value="OK" name="Submit" type="submit"><span>Ok</span></button>
                            </div>
                        </fieldset>
                    </form>

                    <div class="buttons"><a title="Home" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default button button-medium"><span><i class="icon-chevron-left left"></i>Home page</span></a></div>
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