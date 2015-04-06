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
    
	<div class="footer-container">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_before_footer_top' ); ?>
        <div id="footer-top">
            <div class="container">
                <?php dynamic_sidebar('footer-top') ?>
            </div><!-- .container -->
        </div><!-- #footer-top -->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <?php $layouts = explode('-', themedev_option('footer-layout', '3-3-3-3')); ?>
                    <?php foreach($layouts as $i => $layout){ ?>
                        <div class="col-md-<?php echo $layout; ?> col-sm-<?php echo $layout; ?> col-xs-12">
                            <?php dynamic_sidebar('footer-column-'.($i+1)) ?>
                        </div>
                    <?php } ?>
                </div>
            </div><!-- .container -->
        </footer><!-- #footer -->
        <div id="footer-bottom" class="copyright">
            <div class="container">
                <div class="display-table">
                    <div class="display-td footer-bottom-left">
                        LONDON STARS &copy; 2014. Powered by Wordpress. All Rights Reserved.
                    </div>
                    <div class="display-td text-right footer-bottom-right">
                        <?php if ( has_nav_menu( 'bottom' ) ) { ?>
                            <?php wp_nav_menu( array( 'theme_location' => 'bottom', 'container' => 'nav', 'container_id' => 'bottom-nav' ) ); ?>
                        <?php } ?>
                    </div>
                    
                </div>
            </div><!-- .container -->
        </div><!-- #footer-bottom -->
	</div><!-- .footer-container -->
    
    <?php
	/**
	 * @hooked 
	 */
	do_action( 'theme_after_footer' ); ?>
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
