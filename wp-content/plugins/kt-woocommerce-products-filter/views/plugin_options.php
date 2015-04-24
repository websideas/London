<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="subsubsub_section">
    <br class="clear" />
    <div class="section">
        <h3><?php printf(__('Products Filter Options v.%s', 'woocommerce-currency-switcher'), $this->version) ?></h3>
        <input type="hidden" name="woof_settings" value="" />
        <input type="hidden" name="woof_show_count_dynamic" value="0">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php _e("Taxonomies", 'woocommerce-currency-switcher') ?></a></li>
                <li><a href="#tabs-2"><?php _e("Options", 'woocommerce-currency-switcher') ?></a></li>
            </ul>

            <div id="tabs-1">
                <ul id="woof_options">
                    <?php
                    $taxonomies_tmp = $this->get_taxonomies();
                    $taxonomies = array();
                    //sort them as in options
                    if (!empty($this->settings['tax']))
                    {
                        foreach ($this->settings['tax'] as $key => $value)
                        {
                            $taxonomies[$key] = $taxonomies_tmp[$key];
                        }
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
                    foreach ($taxonomies as $key => $tax):
                        ?>
                        <li data-key="<?php echo $key ?>">
                            <a href="#" class="help_tip" data-tip="<?php _e("drag and drope", 'woocommerce-products-filter'); ?>"><img style="width: 22px; vertical-align: middle;" src="<?php echo WOOF_LINK ?>img/move.png" alt="<?php _e("move", 'woocommerce-products-filter'); ?>" /></a>&nbsp;
                            <select name="woof_settings[tax_type][<?php echo $key ?>]">
                                <?php foreach ($this->html_types as $type => $type_text) : ?>
                                    <option value="<?php echo $type ?>" <?php if (isset($woof_settings['tax_type'][$key])) echo selected($woof_settings['tax_type'][$key], $type) ?>><?php echo $type_text ?></option>
                                <?php endforeach; ?>
                            </select><img class="help_tip" data-tip="<?php _e('View of the taxonomies terms on the front', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />&nbsp;
                            <?php
                            $max_height = 0;
                            if (isset($woof_settings['tax_block_height'][$key]))
                            {
                                $max_height = $woof_settings['tax_block_height'][$key];
                            }
                            ?>
                            <input type="text" name="woof_settings[tax_block_height][<?php echo $key ?>]" placeholder="<?php _e('Max height of  the block', 'woocommerce-products-filter') ?>" value="<?php echo $max_height ?>" />&nbsp;<img class="help_tip" data-tip="<?php _e('Max-height (px). Works if the taxonomy view is radio or checkbox. 0 means no max-height, -1 to hide option by default.', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />&nbsp;
                            <input <?php echo(@in_array($key, @array_keys($this->settings['tax'])) ? 'checked="checked"' : '') ?> type="checkbox" name="woof_settings[tax][<?php echo $key ?>]" value="1" />&nbsp;
                            <?php echo $tax->labels->name ?>&nbsp;
                        </li>
                    <?php endforeach; ?>
                </ul><br />
            </div>

            <div id="tabs-2">
                <?php woocommerce_admin_fields( $this->get_options()); ?>
            </div>

        </div>




        <script charset="utf-8" type="text/javascript">
            jQuery(function () {
                jQuery("#tabs").tabs();
            });

        </script>


    </div>



</div>

