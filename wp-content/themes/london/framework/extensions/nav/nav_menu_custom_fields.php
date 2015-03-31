<?php
/**
 * Define all custom fields in menu
 *
 * @version: 1.0.0
 * @package  Kite/Template
 * @author   KiteThemes
 * @link	 http://kitethemes.com
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

add_action( 'walker_nav_menu_custom_fields', 'themedev_add_custom_fields', 10, 4 );
function themedev_add_custom_fields( $item_id, $item, $depth, $args ) { ?>
    <div class="clearfix"></div>
    <div class="container-megamenu">
        <p class="field-icon description description-wide clearfix">
            <label for="menu-item-icon-<?php echo $item_id; ?>">
                <?php _e( 'Select icon of this item (set empty to hide). Ex: fa fa-home', THEME_LANGUAGE); ?><br />
                <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat edit-menu-item-icon" name="menu-item-megamenu-icon[<?php echo $item_id; ?>]" value="<?php esc_attr_e( $item->icon ); ?>" />
            </label>
        </p>
        <div class="wrapper-megamenu">
            <p class="field-enable description description-wide">
                <label for="menu-item-enable-<?php echo $item_id; ?>">
                    <input type="checkbox" <?php checked($item->enable, 'enabled'); ?> data-id="<?php echo $item_id; ?>" id="menu-item-enable-<?php echo $item_id; ?>" name="menu-item-megamenu-enable[<?php echo $item_id; ?>]" value="enabled" class="edit-menu-item-enable"/>
                    <b><?php _e( 'Enable Mega Menu (only for main menu)', THEME_LANGUAGE); ?></b>
                </label>
            </p>
            <div id="content-megamenu-<?php echo $item_id; ?>" class="megamenu-layout clearfix">
                <div class="megamenu-layout-depth-0">
                    <p class="field-columns description description-wide">
                        <label for="menu-item-columns-<?php echo $item_id; ?>">
                            <?php _e( 'Mega Menu Number of Columns', THEME_LANGUAGE); ?><br />
                            <select id="menu-item-columns-<?php echo $item_id; ?>" name="menu-item-megamenu-columns[<?php echo $item_id; ?>]" class="widefat edit-menu-item-columns">
                                <option <?php selected($item->columns, 'auto'); ?> value="auto"><?php _e('Auto', THEME_LANGUAGE); ?></option>
                                <?php for($i=1; $i<5; $i++){ ?>
                                    <option <?php selected($item->columns, $i); ?> value="<?php echo $i ?>"><?php echo $i; ?></option>    
                                <?php } ?>
                            </select>
                        </label>
                    </p>
                    <p class="field-fullwidth description description-wide">
                        <label for="menu-item-fullwidth-<?php echo $item_id; ?>">
                            <input type="checkbox" <?php checked($item->fullwidth, 'enabled'); ?> id="menu-item-fullwidth-<?php echo $item_id; ?>" class="widefat edit-menu-item-fullwidth" name="menu-item-megamenu-fullwidth[<?php echo $item_id; ?>]" value="enabled"/>
                            <?php _e( 'Full Width Mega Menu', THEME_LANGUAGE); ?>
                        </label>
                    </p>
                    <p class="description description-position description-wide">
                        <label>
                            <?php _e( 'Mega menu position', THEME_LANGUAGE); ?><br />
                            <select id="menu-item-position-<?php echo $item_id; ?>" name="menu-item-megamenu-position[<?php echo $item_id; ?>]" class="widefat edit-menu-item-position">
                                <option <?php selected($item->position, 'center'); ?> value="center">Center</option>
                                <option <?php selected($item->position, 'left-menubar'); ?> value=""><?php _e( 'Left edge of menu bar', THEME_LANGUAGE); ?></option>
                                <option <?php selected($item->position, 'right-menubar'); ?> value="right-menubar"><?php _e( 'Right edge of menu bar', THEME_LANGUAGE); ?></option>
                                <option <?php selected($item->position, 'left-parent'); ?> value="left-parent"><?php _e( 'Left Edge of Parent item', THEME_LANGUAGE); ?></option>
                                <option <?php selected($item->position, 'right-parent'); ?> value="right-parent"><?php _e( 'Right Edge of Parent item', THEME_LANGUAGE); ?></option>
                            </select>
                        </label>
                    </p>
                </div>
                <div class="megamenu-layout-depth-1">
                    <p class="field-clwidth description description-wide">
                        <label for="menu-item-clwidth-<?php echo $item_id; ?>">
                            <?php _e( 'Mega Menu Column Width - Overrides parent colum (in percentage, ex: 30%)', THEME_LANGUAGE); ?><br />
                            <input type="text" value="<?php echo $item->clwidth; ?>" id="menu-item-clwidth-<?php echo $item_id; ?>" name="menu-item-megamenu-clwidth[<?php echo $item_id; ?>]" class="widefat edit-menu-item-clwidth"/>
                        </label>
                    </p>
                    <p class="field-columntitle description description-wide">
                        <label for="menu-item-columntitle-<?php echo $item_id; ?>">
                            <input type="checkbox" <?php checked($item->columntitle, 'enabled'); ?> id="menu-item-columntitle-<?php echo $item_id; ?>" name="menu-item-megamenu-columntitle[<?php echo $item_id; ?>]" value="enabled"/>
                            <?php _e('Disable Mega Menu Column Title', THEME_LANGUAGE); ?>
                        </label>
                    </p>
                    <p class="field-columnlink description description-wide">
                        <label for="menu-item-columnlink-<?php echo $item_id; ?>">
                            <input type="checkbox" <?php checked($item->columnlink, 'enabled'); ?> id="menu-item-columnlink-<?php echo $item_id; ?>" name="menu-item-megamenu-columnlink[<?php echo $item_id; ?>]" value="enabled"/>
                            <?php _e('Disable Mega Menu Column Link', THEME_LANGUAGE); ?>
                        </label>
                    </p>
                    <p class="field-newrow description description-wide">
                        <label for="menu-item-newrow-<?php echo $item_id; ?>">
                            <input type="checkbox" <?php checked($item->newrow, 'enabled'); ?> id="menu-item-newrow-<?php echo $item_id; ?>" name="menu-item-megamenu-newrow[<?php echo $item_id; ?>]" value="enabled" class="edit-menu-item-newrow"/>
                            <?php _e( 'New Row (Clear the previous row and start a new one with this item)', THEME_LANGUAGE); ?>
                        </label>
                    </p>
                    <p class="field-widget description description-wide">
                        <label for="menu-item-widget-<?php echo $item_id; ?>">
                            <?php _e('Mega Menu Widget Area', THEME_LANGUAGE); ?><br />
                            <?php $sidebars = themedev_sidebars();?>
                            <select id="menu-item-widget-<?php echo $item_id; ?>" name="menu-item-megamenu-widget[<?php echo $item_id; ?>]" class="widefat edit-menu-item-widget">
                                <option value="0"><?php _e( 'Select Widget Area', THEME_LANGUAGE); ?></option>
                                <?php foreach($sidebars as $k=>$v){ ?>
                                    <option <?php selected($item->widget, $k); ?> value="<?php echo $k; ?>"><?php echo $v ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </p>
                </div>
            </div><!-- #content-megamenu-<?php echo $item_id; ?> -->
        </div><!-- .wrapper-megamenu -->
    </div><!-- .container-megamenu -->
<?php }
