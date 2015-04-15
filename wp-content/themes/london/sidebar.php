<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<?php
	$description = get_bloginfo( 'description', 'display' );
	if ( ! empty ( $description ) ) :
?>
    <h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
<?php endif; ?>