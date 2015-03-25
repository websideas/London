<?php

/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 * 
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
	
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	    global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		?>
		<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <?php //print_r($item); ?>
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<?php _e( 'Navigation Label' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
	            <p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
					</label>
				</p>
                <!--
                <?php if(!isset($item->icon)) $item->icon = 'fa-angle-right'; ?>
                <p class="field-custom description description-wide">
                    <label for="menu-item-icon-<?php echo $item_id; ?>">
                        <?php _e( 'Icon of This Item (set empty to hide)' ); ?><br />
                        <input type="text" size="15" readonly="readonly" placeholder="<?php _e( 'No icon chosen' ); ?>" value="<?php echo $item->icon; ?>" name="menu-item-icon[<?php echo $item_id; ?>]" id="menu-item-icon-<?php echo $item_id; ?>" />
                        <a class="clear-icon button" id="menu-item-clear-<?php echo $item_id; ?>" href="#menu-item-iconshow-<?php echo $item_id; ?>"><?php _e( 'Clear' ); ?></a>
                        <a class="show-icons button prettyPhoto" id="menu-item-choose-<?php echo $item_id; ?>" href="#menu-item-iconshow-<?php echo $item_id; ?>" id="choose-menu-item-<?php echo $item_id; ?>"><?php _e( 'Show Icons' ); ?></a>
                        <span id="preview-item-icon-<?php echo $item_id; ?>" class="upload-preview"><i class="fa <?php echo $item->icon; ?>"></i></span>
                    </label>
                </p>
                <div id="menu-item-iconshow-<?php echo $item_id; ?>" style="display: none;"><?php //echo showIcons(); ?></div>
                -->
                <script type="text/javascript">
                    jQuery(function($) {
						/*$( "a#menu-item-choose-<?php echo $item_id; ?>").prettyPhoto({
                            social_tools:'', deeplinking : false,
                            changepicturecallback: function(){
                                $('.icons-wrapper li').click(function(){
                                    val = $(this).attr('title');
                                    $('#menu-item-icon-<?php echo $item_id; ?>').val(val);
                                    $('#preview-item-icon-<?php echo $item_id; ?>').html('<i class="fa '+val+'"></i>')
                                    $.prettyPhoto.close();
                                });
                            }
                        });
                        $('#menu-item-clear-<?php echo $item_id; ?>').click(function(){
                            $('#menu-item-icon-<?php echo $item_id; ?>').val('');
                            $('#preview-item-icon-<?php echo $item_id; ?>').html('<i class="fa"></i>');
                            return false;
                        });
                        */
                        $('#submenu-type-<?php echo $item_id; ?>').change(function(){
                            if($(this).val() == 'default_dropdown'){
                                $('#field-custom-number-<?php echo $item_id; ?>').hide();
                                $('#field-custom-fullwidth-<?php echo $item_id; ?>').hide();
                            }else{
                                $('#field-custom-number-<?php echo $item_id; ?>').show();
                                $('#field-custom-fullwidth-<?php echo $item_id; ?>').show();
                            }
                        });
					});
                </script>
                <p class="field-custom description description-wide">
                    <label for="menu-item-link-<?php echo $item_id; ?>">
                        <input type="checkbox" <?php if($item->link) echo " checked='true' " ?> id="menu-item-link-<?php echo $item_id; ?>" name="menu-item-link[<?php echo $item_id; ?>]"/>
                        <?php _e( 'Disable Link' ); ?>
                    </label>
                </p>
                <p class="field-custom description description-wide">
                    <label for="menu-item-text-<?php echo $item_id; ?>">
                        <input type="checkbox" <?php if($item->text) echo " checked='true' " ?> id="menu-item-text-<?php echo $item_id; ?>" name="menu-item-text[<?php echo $item_id; ?>]"/>
                        <?php _e( 'Hide Text of This Item' ); ?>
                    </label>
                </p>
                <p class="field-custom description description-wide">
	                <label for="submenu-side-<?php echo $item_id; ?>">
                        <?php _e( 'Side of Dropdown Elements' ); ?> 
                        <select name="menu-item-side[<?php echo $item_id; ?>]" class="widefat" id="submenu-side-<?php echo $item_id; ?>">
    						<option <?php echo (($item->side == 'drop_to_left') || !isset($item->side))? 'selected="selected"': ''; ?> value="drop_to_left"><?php _e('Drop To Left Side'); ?></option>
                            <option <?php echo ($item->side == 'drop_to_right') ? 'selected="selected"': ''; ?> value="drop_to_right"><?php _e('Drop To Right Side'); ?></option>
    					</select>
                    </label>
                </p>
                <p class="field-custom field-item-widget description description-wide" <?php echo $number; ?> id="field-custom-widgets-<?php echo $item_id; ?>">
                    <label for="menu-item-widget-<?php echo $item_id; ?>">
                        <?php _e( 'Replace by widget' ); ?>
                        <select id="menu-item-widget-<?php echo $item_id; ?>" name="menu-item-widget[<?php echo $item_id; ?>]" class="widefat">
                            <option value="">Disable</option>
                            <option value="widget_first" <?php echo ($item->widget == 'widget_first') ? 'selected="selected"': ''; ?>>
                                <?php _e('Widgets area 1'); ?>
                            </option>
                            <option value="widget_second" <?php echo ($item->widget == 'widget_second') ? 'selected="selected"': ''; ?>>
                                <?php _e('Widgets area 2'); ?>
                            </option>
                        </select>
                        <span class="description">Only in multicolumn dropdown</span>
                    </label>
                </p>
                <div class="megamenu-layout">
                    <p class="field-custom description description-wide description-center">--------------------- <?php _e( 'Begin Options of Dropdown' ); ?> ---------------------</p>
    	            <p class="field-custom description description-wide">
    	                <label for="submenu-type-<?php echo $item_id; ?>">
    	                    <?php _e( 'Submenu Type' ); ?>
                            <select id="submenu-type-<?php echo $item_id; ?>" name="menu-item-submenu[<?php echo $item_id; ?>]" class="widefat">
                            	<option value="default_dropdown" <?php echo (($item->submenu == 'default_dropdown') || !isset($item->submenu))? 'selected="selected"': ''; ?>>
                                    <?php _e('Standard Dropdown'); ?>
                                </option>
                            	<option value="multicolumn_dropdown" <?php echo ($item->submenu == 'multicolumn_dropdown') ? 'selected="selected"': ''; ?>>
                                    <?php _e('Multicolumn Dropdown'); ?>
                                </option>
                            </select>
    	                </label>
    	            </p>
                    <?php $number = (($item->submenu == 'default_dropdown') || !isset($item->submenu)) ? ' style="display: none;"': ''; ?>
                    <p class="field-custom description description-wide" <?php echo $number; ?> id="field-custom-number-<?php echo $item_id; ?>">
                        <label for="menu-item-number-<?php echo $item_id; ?>">
                            <?php _e( 'Number of columns (Not For Standard Drops)' ); ?>
                            <select id="menu-item-number-<?php echo $item_id; ?>" name="menu-item-number[<?php echo $item_id; ?>]" class="widefat">
                                <?php for($i=1; $i<=4; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($item->number == $i) ? 'selected="selected"': ''; ?>><?php echo $i ?></option>
                                <?php } ?>
                            </select>
                        </label>
                    </p>
                    <p class="field-custom description description-wide" <?php echo $number; ?> id="field-custom-fullwidth-<?php echo $item_id; ?>">
                        <label for="menu-item-fullwidth-<?php echo $item_id; ?>">
                            <input type="checkbox" <?php if($item->fullwidth) echo " checked='true' " ?> id="menu-item-fullwidth-<?php echo $item_id; ?>" name="menu-item-fullwidth[<?php echo $item_id; ?>]"/>
                            <?php _e( 'Enable Full Width Dropdown' ); ?>
                        </label>
                    </p>
                    <p class="field-custom description description-wide description-center">-------------------------------------------------------</p>
                </div>
				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php _e( 'Move' ); ?></span>
						<a href="#" class="menus-move-up"><?php _e( 'Up one' ); ?></a>
						<a href="#" class="menus-move-down"><?php _e( 'Down one' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php _e( 'To the top' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e( 'Remove' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}


	function wp_get_nav_menu_items( $menu, $args = array() ) {
	$menu = wp_get_nav_menu_object( $menu );

	if ( ! $menu )
		return false;

	static $fetched = array();

	$items = get_objects_in_term( $menu->term_id, 'nav_menu' );

	if ( empty( $items ) )
		return $items;

	$defaults = array( 'order' => 'ASC', 'orderby' => 'menu_order', 'post_type' => 'nav_menu_item',
		'post_status' => 'publish', 'output' => ARRAY_A, 'output_key' => 'menu_order', 'nopaging' => true );
	$args = wp_parse_args( $args, $defaults );
	if ( count( $items ) > 1 )
		$args['include'] = implode( ',', $items );
	else
		$args['include'] = $items[0];

	$items = get_posts( $args );

	if ( is_wp_error( $items ) || ! is_array( $items ) )
		return false;

	// Get all posts and terms at once to prime the caches
	if ( empty( $fetched[$menu->term_id] ) || wp_using_ext_object_cache() ) {
		$fetched[$menu->term_id] = true;
		$posts = array();
		$terms = array();
		foreach ( $items as $item ) {
			$object_id = get_post_meta( $item->ID, '_menu_item_object_id', true );
			$object    = get_post_meta( $item->ID, '_menu_item_object',    true );
			$type      = get_post_meta( $item->ID, '_menu_item_type',      true );

			if ( 'post_type' == $type )
				$posts[$object][] = $object_id;
			elseif ( 'taxonomy' == $type)
				$terms[$object][] = $object_id;
		}

		if ( ! empty( $posts ) ) {
			foreach ( array_keys($posts) as $post_type ) {
				get_posts( array('post__in' => $posts[$post_type], 'post_type' => $post_type, 'nopaging' => true, 'update_post_term_cache' => false) );
			}
		}
		unset($posts);

		if ( ! empty( $terms ) ) {
			foreach ( array_keys($terms) as $taxonomy ) {
				get_terms($taxonomy, array('include' => $terms[$taxonomy]) );
			}
		}
		unset($terms);
	}

	$items = array_map( 'wp_setup_nav_menu_item', $items );

	if ( ! is_admin() ) // Remove invalid items only in frontend
		$items = array_filter( $items, '_is_valid_nav_menu_item' );

	if ( ARRAY_A == $args['output'] ) {
		$GLOBALS['_menu_item_sort_prop'] = $args['output_key'];
		usort($items, '_sort_nav_menu_items');
		$i = 1;
		foreach( $items as $k => $item ) {
			$items[$k]->$args['output_key'] = $i++;
		}
	}

	return apply_filters( 'wp_get_nav_menu_items',  $items, $menu, $args );
}

} // Walker_Nav_Menu_Edit