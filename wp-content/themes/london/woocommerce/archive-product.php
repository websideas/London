<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//fullwidth, sidebar-left, sidebar-right
$layout = apply_filters( 'archive_product_layout', 'fullwidth' );

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
        <?php if($layout == 'sidebar-left' || $layout == 'sidebar-right'){  ?>
            <div class="row <?php echo $layout; ?>">
                <?php $class = ($layout == 'sidebar-left') ? 'pull-right' : '' ?>
                <div id="main" class="col-md-9 col-xs-12 <?php echo $class; ?>">
        <?php } ?>
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>
        <div class="clearfix"></div>
		<?php if ( have_posts() ) : ?>
            
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
            
            <div class="content_sortPagiBar clearfix">
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
            </div><!-- .content_sortPagiBar -->
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
        
        <?php if($layout == 'sidebar-left' || $layout == 'sidebar-right'){  ?>
                </div><!-- .col-md-9.pull-right -->
        <?php } ?>
        
        <?php
            if($layout != 'fullwidth'){
        		/**
        		 * woocommerce_sidebar hook
        		 *
        		 * @hooked woocommerce_get_sidebar - 10
        		 */
        		do_action( 'woocommerce_sidebar' );
            }
    	?>
        <?php if($layout == 'sidebar-left' || $layout == 'sidebar-right'){  ?>
            </div><!-- .col-md-9.pull-right -->
        <?php } ?>
    
    	<?php
    		/**
    		 * woocommerce_after_main_content hook
    		 *
    		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    		 */
    		do_action( 'woocommerce_after_main_content' );
    	?>

<?php get_footer( 'shop' ); ?>
