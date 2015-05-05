<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="woof">

    <?php
    global $_chosen_attributes, $wpdb, $wp;

    $woof_hide_price_filter = (int) get_option('woof_hide_price_filter');
    if( $woof_hide_price_filter != 1 ){

    $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
    $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';
    // Remember current filters/search
    $fields = '';

    if ( 0 === sizeof( WC()->query->layered_nav_product_ids ) ) {
        $min = floor( $wpdb->get_var(
            $wpdb->prepare('
					SELECT min(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) . '")
					AND meta_value != ""
				', $wpdb->posts, $wpdb->postmeta )
        ) );
        $max = ceil( $wpdb->get_var(
            $wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) . '")
				', $wpdb->posts, $wpdb->postmeta, '_price' )
        ) );
    } else {
        $min = floor( $wpdb->get_var(
            $wpdb->prepare('
					SELECT min(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) . '")
					AND meta_value != ""
					AND (
						%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
						OR (
							%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
							AND %1$s.post_parent != 0
						)
					)
				', $wpdb->posts, $wpdb->postmeta
            ) ) );
        $max = ceil( $wpdb->get_var(
            $wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) . '")
					AND (
						%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
						OR (
							%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
							AND %1$s.post_parent != 0
						)
					)
				', $wpdb->posts, $wpdb->postmeta
            ) ) );
    }

    if ( $min == $max ) {
        //return;
    }

    echo '
        <div class="woof_container price_slider_wrapper">
            <h3>'.WOOF_HELPER::wpml_translate('Price').'</h3>
            <div class="woof_ci">
                <div class="price_slider" style="display:none;"></div>
                <div class="price_slider_amount">
                    <input type="hidden" class="min_price" name="min_price" value="' . esc_attr( $min_price ) . '" data-min="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_amount', $min ) ) . '"/>
                    <input type="hidden" class="max_price" name="max_price" value="' . esc_attr( $max_price ) . '" data-max="' . esc_attr( apply_filters( 'woocommerce_price_filter_widget_amount', $max ) ) . '"/>
                    <div class="price_label" style="display:none;">
                        ' . __( 'Price:', 'woocommerce' ) . ' <span class="from"></span> &mdash; <span class="to"></span>
                    </div>
                    ' . $fields . '
                    <div class="clear"></div>
                </div>
            </div>
        </div>
		';

    wp_reset_postdata();

    } // end if $woof_hide_price_filter
    ?>

    <?php
    global $wp_query;
    //print_r($wp_query);
    //+++
    if (!empty($taxonomies))
    {
        $exclude_tax_key = '';


        /*
          if (is_product_taxonomy()) {
          $exclude_tax_key = $wp_query->queried_object->taxonomy;
          }
         */

        //if we are on product taxonimies page
        /*
          if (isset($wp_query->query_vars['taxonomy'])) {
          print_r($wp_query);
          if (in_array($wp_query->query_vars['taxonomy'], get_object_taxonomies('product'))) {
          $exclude_tax_key = $wp_query->query_vars['taxonomy'];
          if (isset($_GET[$exclude_tax_key])) {
          $exclude_tax_key = '';
          }
          }
          }
         */

        if (!empty($wp_query->query))
        {
            if (isset($wp_query->query_vars['taxonomy']) AND in_array($wp_query->query_vars['taxonomy'], get_object_taxonomies('product')))
            {
                $taxes = $wp_query->query;
                if (isset($taxes['paged']))
                {
                    unset($taxes['paged']);
                }

                foreach ($taxes as $key => $value)
                {
                    if (in_array($key, array_keys($_GET)))
                    {
                        unset($taxes[$key]);
                    }
                }
                //***
                if (!empty($taxes))
                {
                    $t = array_keys($taxes);
                    $v = array_values($taxes);
                    //***
                    $exclude_tax_key = $t[0];
                    $_REQUEST['WOOF_IS_TAX_PAGE'] = 1;
                }
            }
        }

        //***
        $taxonomies_tmp = $taxonomies;
        $taxonomies = array();
        //sort them as in options
        foreach ($this->settings['tax'] as $key => $value)
        {
            $taxonomies[$key] = $taxonomies_tmp[$key];
        }
        //check for absent
        foreach ($taxonomies_tmp as $key => $value)
        {
            if (!in_array(@$taxonomies[$key], $taxonomies_tmp))
            {
                $taxonomies[$key] = $taxonomies_tmp[$key];
            }
        }
        //+++
        $counter = 0;
        foreach ($taxonomies as $tax_slug => $terms)
        {
            if ($exclude_tax_key == $tax_slug)
            {
                continue;
            }
            //+++
            $args = array();
            $args['taxonomy_info'] = $taxonomies_info[$tax_slug];
            $args['tax_slug'] = $tax_slug;
            $args['terms'] = $terms;
            $args['show_count'] = get_option('woof_show_count');
            $args['show_count_dynamic'] = get_option('woof_show_count_dynamic');
            $args['hide_dynamic_empty_pos'] = get_option('woof_hide_dynamic_empty_pos');
            $args['woof_autosubmit'] = get_option('woof_autosubmit');
            //***
            $woof_container_styles = "";
            $max_h = 0 ;
            if ($woof_settings['tax_type'][$tax_slug] == 'radio' OR $woof_settings['tax_type'][$tax_slug] == 'checkbox')
            {
                $max_h = $this->settings['tax_block_height'][$tax_slug];
                if ($this->settings['tax_block_height'][$tax_slug] > 0)
                {
                    $woof_container_styles = "max-height:{$this->settings['tax_block_height'][$tax_slug]}px; overflow-y: hidden;";

                }

            }


            //***
            //https://wordpress.org/support/topic/adding-classes-woof_container-div
            $primax_class = sanitize_key(WOOF_HELPER::wpml_translate($taxonomies_info[$tax_slug]->label));
            ?>
            <div class="woof_container <?php echo $max_h >0 ? 'is-max-h': ''; ?> woof_container_<?php echo $counter++ ?> woof_container_<?php echo $primax_class ?>" >
                <div class="woof_container_inner woof_container_inner_<?php echo $primax_class ?>">
                    <?php
                    ?>
                    <h3 class="<?php echo $max_h < 0  ? 'closed' : ''; ?>"><?php echo WOOF_HELPER::wpml_translate($taxonomies_info[$tax_slug]->label) ?></h3>
                    <div class="wmhw"   <?php if (!empty($woof_container_styles)): ?>style="<?php echo $woof_container_styles ?>"<?php endif; ?>>
                        <div class="woof_ci" <?php echo  $max_h < 0 ? 'style=" display: none;"' : ''; ?>>
                        <?php
                        switch ($woof_settings['tax_type'][$tax_slug])
                        {
                            case 'checkbox':
                                echo $this->render_html(WOOF_PATH . 'views/html_types/checkbox.php', $args);
                                break;
                            case 'select':
                                echo $this->render_html(WOOF_PATH . 'views/html_types/select.php', $args);
                                break;
                            case 'mselect':
                                echo $this->render_html(WOOF_PATH . 'views/html_types/mselect.php', $args);
                                break;
                            default:
                                echo $this->render_html(WOOF_PATH . 'views/html_types/radio.php', $args);
                                break;
                        }
                        ?>
                        </div>
                    </div>
                    <a href="#" class="view-full-h closed" data-max-height="<?php echo $max_h; ?>"><span></span></a>
                </div>
            </div>
            <?php
        }
    }

//***
    $woof_hide_in_stock = (int) get_option('woof_hide_in_stock');
    if( $woof_hide_in_stock != 1 ){
    ?>

    <div class="woof_container woof_checkbox_instock_container">
        <div class="iw">
            <label for="woof_checkbox_instock">
                <input type="checkbox" class="woof_checkbox_instock" id="woof_checkbox_instock" name="stock" value="0" <?php checked('instock', isset($_REQUEST['stock']) ? 'instock' : '', true) ?> />
                &nbsp;&nbsp;<?php _e('In stock only', 'woocommerce-products-filter') ?></label>
        </div>
    </div>
    <?php } ?>

    <?php /* ?>
    <div class="woo_submit_search_form_container">

        <?php if (isset($_GET['swoof'])): global $woof_link; ?>
            <input style="float: right;" type="button" class="button woo_reset_search_form" onclick="window.location = '<?php echo $woof_link ?>'" value="<?php _e('Reset', 'woocommerce-products-filter') ?>" />
        <?php endif; ?>

        <?php if (!$woof_autosubmit): ?>
            <input style="float: left;" type="button" class="button woo_submit_search_form" onclick="" value="<?php _e('Filter', 'woocommerce-products-filter') ?>" />
        <?php endif; ?>

    </div>
    */ ?>


</div>

