<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$logo = themedev_getLogo();
$logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : ''; 
?>

<?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'p'; ?>
<<?php echo $tag ?> class="site-logo <?php echo $logo_class; ?>">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo $logo['default']; ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
        <?php if($logo['retina']){ ?>
            <img src="<?php echo $logo['retina']; ?>" class="retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
        <?php } ?>
    </a>
</<?php echo $tag ?>><!-- .site-logo -->
<div id="site-title"><?php bloginfo( 'name' ); ?></div>
<div id="site-description"><?php bloginfo( 'description' ); ?></div>