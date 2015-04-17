<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-content-mobile">
    <?php if ( kt_is_wc() ) { ?>
        <?php global $woocommerce; ?>
        <a href="<?php echo WC()->cart->get_cart_url(); ?>" class="mobile-cart-link"><i class="fa fa-shopping-cart"></i></a>
    <?php } ?>
    <a href="#" class="mobile-nav-bar"><span class="mobile-nav-handle"><span></span></span></a>
</div>