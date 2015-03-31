<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */
?>
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_content_bottom' ); ?>
	</div><!-- .site-content -->
    
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_before_footer' ); ?>
    
	<div class="footer-container">
        <div id="footer-top">
            <div class="container">
                <?php dynamic_sidebar('footer-top') ?>
            </div><!-- .container -->
        </div><!-- #footer-top -->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <?php dynamic_sidebar('footer-column-1') ?>
                    </div>
                    <div class="col-md-4">
                        <?php dynamic_sidebar('footer-column-2') ?>
                    </div>
                    <div class="col-md-4">
                        <?php dynamic_sidebar('footer-column-3') ?>
                    </div>
                </div>
            </div><!-- .container -->
        </footer><!-- #footer -->
        <div id="footer-bottom" class="copyright">
            <div class="container">
                <div class="display-table">
                    <div class="display-td">
                        LONDON STARS &copy; 2014. Powered by Wordpress. All Rights Reserved.
                    </div>
                    <?php if ( has_nav_menu( 'bottom' ) ) { ?>
                        <div class="display-td text-right">
                            <?php wp_nav_menu( array( 'theme_location' => 'bottom', 'container' => 'nav', 'container_id' => 'bottom-nav' ) ); ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div><!-- .container -->
        </div><!-- #footer-top -->
	</div><!-- .footer-container -->
    
    <?php
	/**
	 * @hooked theme_after_footer_addscroll 10
	 */
	do_action( 'theme_after_footer' ); ?>
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
