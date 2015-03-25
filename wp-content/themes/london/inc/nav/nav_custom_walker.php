<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class wi_mega_walker extends Walker_Nav_Menu{
    /**
     * widgets_dropdown 
     */
    function widget_first( &$output, $args ) {
        ob_start();
            dynamic_sidebar( 'menu-column-1' );
            $output .= ob_get_contents();
        ob_end_clean();
    }
    function widget_second( &$output, $args ) {
        ob_start();
            dynamic_sidebar( 'menu-column-2' );
            $output .= ob_get_contents();
        ob_end_clean();
    }

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
        $submenu_type = get_post_meta( $args->menu_main_parent,  '_menu_item_submenu', true);
        if(($submenu_type =='widget_first' || $submenu_type =='widget_second') && $depth == 0 ){
            $args_submenu_type = array( 'menu_item_id' => $args->menu_item_id, 'menu_main_parent' => $args->menu_main_parent );
            call_user_func_array ( array( $this, $submenu_type ), array( &$output, $args_submenu_type ) );
        }
        $output .= "$indent </ul>\n";
	}
    
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $icon = get_post_meta( $item->ID, '_menu_item_icon', true );
        $link = get_post_meta( $item->ID, '_menu_item_link', true );
        $text = get_post_meta( $item->ID, '_menu_item_text', true );
        $number = get_post_meta( $item->ID, '_menu_item_number', true );
        $submenu = get_post_meta( $item->ID, '_menu_item_submenu', true );
        $fullwidth = get_post_meta( $item->ID, '_menu_item_fullwidth', true );
        $side = get_post_meta( $item->ID, '_menu_item_side', true );
        $widget = get_post_meta( $item->ID, '_menu_item_widget', true );
        
        
		$class_names = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
		$classes[] = 'menu-item-' . $item->ID;
        $classes[] = $submenu;
        $classes[] = 'menu-item-depth-'.$depth;
        $classes[] = $side;
        
        
        if($submenu != 'default_dropdown'){
            $classes[] = 'column-number'.$number;
            $classes[] = ($fullwidth) ? 'fullwidth' : 'halfwidth';
        }
        
        
        
		/**
		 * Filter the CSS class(es) applied to a menu item's <li>.
		 *
		 * @since 3.0.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
        
        
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's <li>.
		 *
		 * @since 3.0.1
		 *
		 * @see wp_nav_menu()
		 *
		 * @param string $menu_id The ID that is applied to the menu item's <li>.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of wp_nav_menu() arguments.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
        $atts['class']  = 'item_link';
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		
        if($text) $atts['class'] .= ' item-no-text';
        
        if(!$link){
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        }
        

		/**
		 * Filter the HTML attributes applied to a menu item's <a>.
		 *
		 * @since 3.6.0
		 *
		 * @see wp_nav_menu()
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item The current menu item.
		 * @param array  $args An array of wp_nav_menu() arguments.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        
        
        
		$item_output = $args->before;
		$item_output .= ($link) ? '<span'. $attributes .'>' : '<a'. $attributes .'>';
        $item_output .= '<span class="link_wrapper">';
        $item_output .= ($icon) ? ' <i class="fa '.$icon.'"></i>' : '';
        
        if(!$text){
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;    
        }
        $item_output .= '</span>';
        
        if(!$depth && in_array('menu-item-has-children', $classes)){
            $item_output .= '<i class="menu-item-caret fa fa-chevron-down"></i></a>';
        }
        
		$item_output .= ($link) ? '</span>' : '</a>';
		$item_output .= $args->after;
        
        if(!in_array('menu-item-has-children', $classes) && $depth == 1){
            if($widget =='widget_first' || $widget =='widget_second'){
                call_user_func_array(array($this, 'start_lvl'), array( &$item_output, $depth, $args));
                call_user_func_array( array( $this, $widget ), array( &$item_output, $args ) );
                $item_output .= '</ul>';
                
            }
        }
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( isset( $args[0] ) && is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        
        $args[0]->menu_item_id = $element->ID;
        $args[0]->menu_item_parent = $element->menu_item_parent;
        if ( $element->menu_item_parent == 0 ) {
            $args[0]->menu_main_parent = $element->ID;
        }
        
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}
}