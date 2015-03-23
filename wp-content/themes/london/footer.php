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
        <footer class="container" id="footer">
        
        </footer><!-- #footer -->
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
