<div class="container">
    <div id="header-inner">
        <div id="header-wrap" class="display-table">
            <div class="site-branding display-td">
                <?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'p'; ?>
    			<<?php echo $tag ?> class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php echo THEME_IMG; ?>nella-fashion.jpg" alt="<?php bloginfo( 'name' ); ?>" />
                    </a>
                </<?php echo $tag ?>><!-- .site-logo -->
                <div id="site-title"><?php bloginfo( 'name' ); ?></div>
                <div id="site-description"><?php bloginfo( 'description' ); ?></div>
            </div><!-- .site-branding -->
            <div class="display-td">
                <div class="header-content-top clearfix">
                    <?php echo woocommerce_get_cart(); ?>
                    <?php woocommerce_get_tool();?>
                </div><!-- .header-content-top -->
                <div class="header-content-bottom clearfix">
                    <?php
                        if ( has_nav_menu( 'primary' ) ) {  
                            wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav', 'walker' => new KTMegaWalker() ) );
                        }
                    ?>
                    <?php get_search_form(); ?>
                </div><!-- .header-content-bottom -->
            </div><!-- .header-content -->
        </div><!-- #header-wrap -->
    </div>
</div><!-- .container -->