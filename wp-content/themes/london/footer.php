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
         * 
    	 */
    	do_action( 'theme_content_bottom' ); ?>
	</div><!-- #content -->
    
    <?php
	/**
	 * @hooked 
     * theme_after_footer_addscroll 10
     * 
	 */
	do_action( 'theme_before_footer' ); ?>
    
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_before_footer_top' ); ?>
    <?php if(is_active_sidebar( 'footer-top' )){ ?>
        <footer id="footer-top">
            <div class="container">
                <?php dynamic_sidebar('footer-top') ?>
            </div><!-- .container -->
        </footer><!-- #footer-top -->
    <?php } ?>
    <footer id="footer-area">
        <div id="footer-area-content">
            <div class="container">
                <div class="row">
                    <?php $layouts = explode('-', kt_option('footer_widgets_layout', '4-4-4')); ?>
                    <?php foreach($layouts as $i => $layout){ ?>
                        <div class="col-md-<?php echo $layout; ?> col-sm-<?php echo $layout; ?> col-xs-12">
                            <?php dynamic_sidebar('footer-column-'.($i+1)) ?>
                        </div>
                    <?php } ?>
                </div>
            </div><!-- .container -->
        </div><!-- #footer-area-content -->
    </footer><!-- #footer-area -->
    
	<footer id="footer" class="copyright">
        <div class="container">
            <div class="display-table">
                <div class="display-td footer-left">
                    <?php if ( has_nav_menu( 'bottom' ) ) { ?>
                        <?php wp_nav_menu( array( 'theme_location' => 'bottom', 'container' => 'nav', 'container_id' => 'bottom-nav' ) ); ?>
                    <?php } ?>
                </div>
                <div class="display-td footer-right">
                    LONDON STARS &copy; 2014. Powered by Wordpress. All Rights Reserved.
                </div>
            </div>
        </div><!-- .container -->
	</footer><!-- #footer -->
    
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_after_footer' ); ?>
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
