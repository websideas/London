<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */

if ( is_active_sidebar( 'shop-widget-area' )  ) : ?>
	<div class="sidebar col-md-3 col-xs-12">
		<?php if ( is_active_sidebar( 'shop-widget-area' ) ) : ?>
            <?php dynamic_sidebar( 'shop-widget-area' ); ?>
		<?php endif; ?>
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'theme_after_shop_widget' ); ?>
    </div>
<?php endif; ?>
