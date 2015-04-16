<div class="header-content-top">
    <div class="container">
        <div id="header-wrap">
            <div class="row">
                <div class="col-md-4 text-left header-content-left">
                    <?php
                        if ( has_nav_menu( 'top' ) ) { 
                            wp_nav_menu( array( 'theme_location' => 'top', 'container' => 'nav', 'container_id' => 'top-nav' ) );
                        } 
                    ?>
                    <div class="header-contact">
                        
                        <i class="fa fa-phone"></i> <?php echo kt_option('header_phone'); ?>
                        <i class="fa fa-email"></i> <?php echo kt_option('header_email'); ?>
                    </div>
                </div>
                
                <div class="col-md-4 text-center">
                    <div class="site-branding">
                        <?php get_template_part( 'layouts/headers/header',  'branding'); ?>
                    </div><!-- .site-branding -->
                </div>
                <div class="col-md-4 text-right header-content-right">
                    <?php woocommerce_get_tool(); ?>
                    <?php echo woocommerce_get_cart(); ?>
                </div>
            </div><!-- .row -->
        </div>
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
            <?php get_template_part( 'layouts/headers/header', 'mobile'); ?>
        </div><!-- .header-inner -->
    </div>
</div><!-- .header-content-bottom -->