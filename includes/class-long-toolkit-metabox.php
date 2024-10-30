<?php

/**
 * Metabox Framework
 *
 * @class     Long_Toolkit_Metaboxes
 * @package   Long_Toolkit/Classes
 * @category  Class
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.0
 */
if ( !class_exists( 'Long_Toolkit_Metabox' ) ) {

	/*
	 * Long_Toolkit_Metaboxes Class
	 */

	class Long_Toolkit_Metabox {

		/**
		 * @access private
		 * @var array meta boxes settings
		 */
		private $settings = array();

		/**
		 * @access private
		 * @var string Container of the field in markup HTML
		 */
		private $field_wrapper;

		/**
		 * @access private
		 * @var string Html of all output field
		 */
		private $output;

		/**
		 * @access private
		 * @var array Group fields
		 */
		private $group_fields = array();

		/**
		 * Init
		 */
		public function __construct( $args = array() ) {

			if ( !empty( $args ) ) {

				$defaults = array(
					'id' => 'long_toolkit_metabox',
					'screens' => array( 'page' ),
					'title' => __( 'Long_Toolkit Metabox', 'long-toolkit' ),
					'context' => 'advanced',
					'priority' => 'low',
					'fields' => array(
					)
				);

				$this->settings = wp_parse_args( $args, $defaults );

				add_action( 'add_meta_boxes', array( $this, 'register' ) );
				add_action( 'save_post', array( $this, 'save' ), 1, 2 );
			}
		}

		/**
		 * Register hook
		 * @return void
		 */
		public function register() {

			global $post;

			if ( empty( $post ) ) {
				return;
			}

			if ( $screen = $this->getScreen( $post ) ) {

				$this->field_wrapper = '<div class="long_toolkit_form_row" %3$s><div class="col-label">%1$s</div><div class="col-field">%2$s</div></div>';

				$this->output = $this->pre_output( $post->ID );

				add_meta_box( $this->settings['id'], $this->settings['heading'], array( $this, 'output' ), $screen, $this->settings['context'], $this->settings['priority'], $this->settings['fields'] );
			}
		}

		/**
		 * Get screen to display in metabox
		 * @since 1.0.11
		 * 
		 * @param object|WP_Post $post
		 * @return string Or false
		 */
		protected function getScreen( $post ) {

			$screen = false;

			if ( in_array( $post->post_type, $this->settings['screens'] ) || in_array( $post->ID, $this->settings['screens'] ) ) {
				$screen = $post->post_type;
			} else {

				$blogPage = in_array( 'posts_page', $this->settings['screens'] ) && $post->ID == get_option( 'page_for_posts' );
				$frontPage = in_array( 'front_page', $this->settings['screens'] ) && $post->ID == get_option( 'page_on_front' );

				if ( $blogPage || $frontPage ) {
					$screen = 'page';
				}
			}
			
			if ( !empty( $post->page_template ) && $post->page_template != 'default' ) {
				
				$templates = wp_get_theme()->get_page_templates( $post, $post->post_type );

				if ( isset( $templates[$post->page_template] ) ) {
					$_screen = $templates[$post->page_template];
					if ( in_array( $_screen, $this->settings['screens'] ) ) {
						$screen = $post->post_type;
					}
				}
			}

			return $screen;
		}

		/**
		 * Output callback
		 * @return void
		 */
		public function output( $post, $args ) {
			echo $this->output;
		}

		/**
		 * Process field output
		 * 
		 * @global array $long_toolkit_registered_fields
		 * @param int $post_id
		 * @return string Html
		 */
		public function pre_output( $post_id ) {

			global $long_toolkit_registered_fields;

			if ( empty( $long_toolkit_registered_fields ) ) {
				$long_toolkit_registered_fields = array();
			}

			$output = '';

			$metabox = $this->settings;

			$output .= sprintf( '<div class="long-toolkit-metabox long-toolkit-metabox_%s">', $metabox['id'] );

			$output .= sprintf( '<input type="hidden" name="%s_nonce" value="%s" />', $metabox['id'], wp_create_nonce( $metabox['id'] ) );

			if ( !empty( $metabox['manage_box'] ) ) {
				$value = get_post_meta( $post_id, $metabox['id'], true );
				$output .= sprintf( '<input class="long-toolkit-manage_box" type="hidden" name="%s" value="%s" data-label="%s"/>', $metabox['id'], $value, esc_attr__( 'Enable', 'long-toolkit' ) );
			}

			foreach ( $metabox['fields'] as $field ) {
				/**
				 * Field value
				 */
				$value = get_post_meta( $post_id, $field['name'], false );

				if ( isset( $value[0] ) ) {
					$value = $value[0];
				} elseif ( empty( $value[0] ) ) {
					$value = isset( $field['value'] ) ? $field['value'] : '';
				} else {
					$value = '';
				}

				$field['value'] = $value;

				/**
				 * Add field type to global array
				 */
				$long_toolkit_registered_fields[] = $field['type'];

				/**
				 * Before render field type
				 */
				do_action( 'long_toolkit_before_render_field_' . $field['type'], $field );

				/**
				 * Render field
				 */
				$field_output = $this->field_render( $field );

				/**
				 * Add field to group
				 */
				if ( $field_output != '' ) {
					$group = !empty( $field['group'] ) ? $field['group'] : '';
					if ( empty( $this->group_fields[$group] ) ) {
						$this->group_fields[$group] = array();
					}
					$this->group_fields[$group][] = $field_output;
				}
			}

			if ( count( $this->group_fields ) == 1 && !key( $this->group_fields ) ) {
				$output .= implode( '', $this->group_fields[''] );
			} else {
				$nav = '';
				$content = '';
				$index = 0;
				foreach ( $this->group_fields as $name => $fields ) {

					$name = empty( $name ) ? __( 'General', 'long-toolkit' ) : $name;
					$index++;
					$active = $index == 1 ? 'active' : '';
					$id = $this->settings['id'] . '-group_' . $index;
					$nav .= sprintf( '<li><a href="#%s" class="%s">%s</a></li>', $id, $active, $name );
					$content .= sprintf( '<div id="%s" class="group_item %s">%s</div>', $id, $active, implode( '', $fields ) );
				}

				$output .= '<div class="long_toolkit_group">';
				$output .= '<ul class="group_nav">' . $nav . '</ul>';
				$output .= '<div class="group_panel">' . $content . '</div>';
				$output .= '</div>';
			}

			$output .= '</div>';

			$long_toolkit_registered_fields = array_unique( $long_toolkit_registered_fields );

			return $output;
		}

		/**
		 * Process field
		 * @access private
		 * @return string Field Html
		 */
		private function field_render( $field ) {

			$field_output = '';
			if ( $field['type'] == 'textarea' ) {
				$field['id'] = 'rich-editor-'.rand(1,100);
			} else {
				$field['id'] = $field['name'];
			}

			$required = isset( $field['required'] ) && absint( $field['required'] ) ? '<span>*</span>' : '';

			$lable = !empty( $field['heading'] ) ? sprintf( '<label for="%1$s">%2$s %3$s</label>', $field['name'], $field['heading'], $required ) : '';

			$desc = !empty( $field['desc'] ) ? sprintf( '<p class="description">%s</p>', $field['desc'] ) : '';

			$attrs = sprintf( 'data-param_name="%s" ', $field['name'] );

			$attrs .= !empty( $field['dependency'] ) && is_array( $field['dependency'] ) ? 'data-dependency="' . esc_attr( json_encode( $field['dependency'] ) ) . '"' : '';

			if ( function_exists( "long_toolkit_form_{$field['type']}" ) ) {

				if ( isset( $field['sanitize_callback'] ) && function_exists( $field['sanitize_callback'] ) ) {
					$field['value'] = call_user_func( $field['sanitize_callback'], $field['value'] );
				}

				$callback = call_user_func( "long_toolkit_form_{$field['type']}", $field, $field['value'] ) . $desc;
				$field_output = sprintf( $this->field_wrapper, $lable, $callback, $attrs );
			} else if ( has_filter( "long_toolkit_form_{$field['type']}" ) ) {

				$field_output = apply_filters( "long_toolkit_form_{$field['type']}", '', $field ) . $desc;
				$field_output = sprintf( $this->field_wrapper, $lable, $field_output, $attrs );
			}

			return $field_output;
		}

		/**
		 * Save post meta
		 * 
		 * @param int $post_id
		 * @param object|WP_Post $post
		 */
		public function save( $post_id, $post ) {

			/* Don't save if $_POST is empty */
			if ( empty( $_POST ) ) {
				return $post_id;
			}

			/* Don't save during autosave */
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			$metabox = $this->settings;

			/* Verify nonce */
			if ( !isset( $_POST[$metabox['id'] . '_nonce'] ) || !wp_verify_nonce( $_POST[$metabox['id'] . '_nonce'], $metabox['id'] ) )
				return $post_id;

			/* Check permissions */
			$screen = $this->getScreen( $post );

			if ( 'page' == $screen && !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			} else if ( !current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}

			/**
			 * Do save
			 */
			$allow_save = true;

			if ( !empty( $metabox['manage_box'] ) ) {

				$value = sanitize_text_field( $_POST[$metabox['id']] );

				if ( !$value ) {
					$allow_save = false;
				}

				update_post_meta( $post_id, $metabox['id'], $value );
			}

			if ( $allow_save ) {

				foreach ( $metabox['fields'] as $field ) {

					if ( !isset( $field['name'] ) ) {
						continue;
					}

					$value = '';

					if ( isset( $_POST[$field['name']] ) || $field['type'] == 'checkbox' ) {

						$input_value = isset( $_POST[$field['name']] ) ? $_POST[$field['name']] : '';

						if ( isset( $field['sanitize_callback'] ) && function_exists( $field['sanitize_callback'] ) ) {
							$value = call_user_func( $field['sanitize_callback'], $input_value );
						} else {

							if ( $field['type'] == 'upload' ) {
								$value = long_toolkit_sanitize_upload( $input_value );
							} elseif ( isset( $field['multiple'] ) && $field['multiple'] ) {
								$value = maybe_unserialize( $input_value );
							} elseif ( $field['type'] == 'checkbox' ) {
								$value = !empty( $input_value ) ? 1 : 0;
							} elseif ( $field['type'] == 'link' ) {
								$value = strip_tags( $input_value );
							} elseif ( $field['type'] == 'textarea' ) {
								$value = wp_kses_post($input_value);
							} elseif ( $field['type'] == 'repeater' && !empty( $input_value ) ) {
								$value = str_replace( '\r\n', '', json_encode( $input_value, JSON_UNESCAPED_UNICODE ) );
							} else {
								$value = sanitize_text_field( $input_value );
							}
						}

						/**
						 * Allow third party filter value
						 */
						$value = apply_filters( "long_toolkit_sanitize_field_{$field['type']}", $value, $input_value );
						update_post_meta( $post_id, $field['name'], $value );
					} else {
						delete_post_meta( $post_id, $field['name'] );
					}
				}
			}

			do_action( sprintf( 'long_toolkit_%s_updated', $metabox['id'] ), $post_id, $post, $allow_save );
		}

	}

}