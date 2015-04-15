<div class="display-table">
    <div class="display-td footer-left">
        <?php if ( has_nav_menu( 'bottom' ) ) { ?>
            <?php wp_nav_menu( array( 'theme_location' => 'bottom', 'container' => 'nav', 'container_id' => 'bottom-nav' ) ); ?>
        <?php } ?>
    </div>
    <div class="display-td footer-right">
        LONDON STARS &copy; 2014. Powered by Wordpress. All Rights Reserved.
    </div>
</div>