<div class="header-content-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-left">
                <?php
                    if ( has_nav_menu( 'top' ) ) { 
                        wp_nav_menu( array( 'theme_location' => 'top', 'container' => 'nav', 'container_id' => 'top-nav' ) );
                    } 
                ?>
                <div class="header-contact"><i class="fa fa-phone"></i> Call Us: 00-123-456-789</div>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="site-branding">
                    <?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'p'; ?>
            		<<?php echo $tag ?> class="site-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo THEME_IMG; ?>logo-black.png" alt="<?php bloginfo( 'name' ); ?>" />
                        </a>
                    </<?php echo $tag ?>><!-- .site-logo -->
                    <div id="site-title"><?php bloginfo( 'name' ); ?></div>
                    <div id="site-description"><?php bloginfo( 'description' ); ?></div>
                </div><!-- .site-branding -->
            </div>
            <div class="col-md-4 text-right">
                <?php woocommerce_get_tool(); ?>
                <?php echo woocommerce_get_cart(); ?>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .header-content-top -->
<div class="header-content-bottom">
    <div class="container">
        <div id="header-inner" class="clearfix">
            <?php
                if ( has_nav_menu( 'primary' ) ) {  
                    wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav', 'walker' => new KTMegaWalker() ) );
                }
            ?>
            <?php get_search_form(); ?>
        </div><!-- .header-inner -->
    </div>
</div><!-- .header-content-bottom -->