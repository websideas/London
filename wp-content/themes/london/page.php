<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$sidebar = themedev_sidebar();

get_header(); ?>
    <div class="container">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_main' ); ?>
        <div class="row">    
            <div id="main" class="<?php echo apply_filters('themedev_main_class', 'main-class', $sidebar['sidebar']); ?>">
                <?php
                	// Start the loop.
                	while ( have_posts() ) : the_post();
                		// Include the page content template.
                		get_template_part( 'content', 'page' );
                	// End the loop.
                	endwhile;
            	?>
            </div>
            <?php if($sidebar['sidebar'] != 'full'){ ?>
                <div class="<?php echo apply_filters('themedev_sidebar_class', 'sidebar', $sidebar['sidebar']); ?>">
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