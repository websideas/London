<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
    
$attachment_ids = $product->get_gallery_attachment_ids();

// Bootstrap Column
$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );
$classes[] = 'col-xs-12 col-sm-'. $bootstrapColumn .' col-md-' . $bootstrapColumn;


?>
<li <?php post_class( $classes ); ?>>
    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="product-image-container">
        <a href="<?php the_permalink(); ?>" class="product-thumbnail">
            <?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog', array('class'=>"first-img product-img")) ?>
            <?php 
                if($attachment_ids){	
                	foreach ( $attachment_ids as $attachment_id ) {
                	    $image_link = wp_get_attachment_url( $attachment_id );
                        if ( $image_link ){
                            echo wp_get_attachment_image( $attachment_id, 'shop_catalog', false, array('class'=>"second-img product-img"));
                            break;    
                        }
                	}
                }
        
            ?>
            
            <?php do_action( 'woocommerce_shop_loop_item_after_image' ); ?>
            
            <div class="functional-buttons">
                <a href="<?php the_permalink(); ?>" class="product-quick-view" data-id="<?php the_ID() ?>"></a>
                <?php do_action( 'woocommerce_shop_loop_item_action' ); ?>
            </div>
        </a>
    </div>
    
    
    
    
	

	<a href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		<h3><?php the_title(); ?></h3>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' ); 

	?>

</li>
