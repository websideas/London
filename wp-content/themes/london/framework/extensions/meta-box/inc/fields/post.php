<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Make sure "select" field is loaded
require_once RWMB_FIELDS_DIR . 'select-advanced.php';

if ( ! class_exists( 'RWMB_Post_Field' ) )
{
	class RWMB_Post_Field extends RWMB_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			RWMB_Select_Advanced_Field::admin_enqueue_scripts();
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$field['options'] = self::get_options( $field );
			switch ( $field['field_type'] )
			{
				case 'select':
					return RWMB_Select_Field::html( $meta, $field );
				case 'select_advanced':
				default:
					return RWMB_Select_Advanced_Field::html( $meta, $field );
			}
		}
        
        /**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = parent::normalize_field( $field );

			$field = wp_parse_args( $field, array(
				'js_options' => array(),
			) );

			$field['js_options'] = wp_parse_args( $field['js_options'], array(
				'allowClear'  => true,
				'width'       => 'resolve',
				'placeholder' => $field['placeholder'],
			) );
            
            
			return $field;
		}
        
		/**
		 * Save meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		static function save( $new, $old, $post_id, $field )
		{
			return RWMB_Select_Field::save( $new, $old, $post_id, $field );
		}

		/**
		 * Get posts
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function get_options( $field )
		{
			$options = array();
			$query   = new WP_Query( $field['query_args'] );
			if ( $query->have_posts() )
			{
				while ( $query->have_posts() )
				{
					$post               = $query->next_post();
					$options[$post->ID] = $post->post_title;
				}
			}

			return $options;
		}
	}
}
