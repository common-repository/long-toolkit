<?php
/**
 * Repeater
 * 
 * @package   Long_Toolkit/Corefields
 * @category  Functions
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.1
 */
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Field Repeater
 *
 * @param $settings
 * @param string $value
 *
 * @since 1.0.1
 * @return string - html string.
 */
function long_toolkit_form_repeater( $settings, $value ) {
	ob_start();

	$args = wp_parse_args( $settings, array(
		'id' => '',
		'name' => '',
		'fields' => array()
			) );

	$value_default = array();
	$value_defaulong_toolkit_item = array();

	if ( count( $args['fields'] ) ) {
		foreach ( $args['fields'] as $field ) {
			$_val = '';
			if ( isset( $field['value'] ) ) {
				if ( is_array( $field['value'] ) ) {
					$_val = implode( ',', $field['value'] );
				} else {
					$_val = isset( $field['value'] ) ? $field['value'] : '';
				}
			}

			$value_defaulong_toolkit_item[$field['name']] = $_val;
		}


		$value_default[] = $value_defaulong_toolkit_item;
		$value_default = json_encode( $value_default );

		if ( empty( $value ) ) {
			$value = $value_default;
		}
	}

	$field_wrapper = '<div class="repeater_form_row long_toolkit_form_row %3$s" data-type="%4$s" %5$s><div class="repeater-col-label">%1$s</div><div class="repeater-col-field">%2$s</div></div>';

	/**
	 * Hidden input to save value if support for widget and customizer
	 */
	$hidden_input = '';

	if ( !empty( $settings['customize_link'] ) ) {

		/**
		 * Support Customizer
		 */
		$hidden_input = sprintf( '<input class="long_toolkit_value" type="hidden" value="%s" %s/>', esc_attr( $value ), $args['customize_link'] );
	} else if ( !empty( $settings['widget_support'] ) ) {

		/**
		 * Support Widget
		 */
		$hidden_input = sprintf( '<input class="long_toolkit_value" type="hidden" value="%s" name="%s"/>', esc_attr( $value ), $args['name'] );

		//Use base name
		$args['name'] = $args['_name'];

		
	}
	
	global $long_toolkit_registered_fields;
	?>
	<div class="long-toolkit-field long-toolkit-repeater" id="long-toolkit-repeater-<?php echo esc_attr( $args['name'] ) ?>" data-name="<?php echo esc_attr( $args['name'] ) ?>" data-value="<?php echo esc_attr( $value ) ?>">
		<?php print $hidden_input; ?>
		<div class="long-toolkit-repeater-list" data-repeater-list="<?php echo esc_attr( $args['name'] ) ?>">
			<div data-repeater-item="" class="long_toolkit_repeater__item">

				<div class="long-toolkit-widget">	

					<div class="long-toolkit-widget-top">
						<div class="long-toolkit-widget-title-action">
							<a class="cmd" data-repeater-edit title="<?php echo esc_attr__( 'Edit', 'long-toolkit' ) ?>"><i class="fa fa-pencil"></i></a>
							<a class="cmd" data-repeater-delete title="<?php echo esc_attr__( 'Remove', 'long-toolkit' ) ?>"><i class="fa fa-trash-o"></i></a>
						</div>
						<div class="long-toolkit-widget-title ui-sortable-handle">
							<h4><i class="fa fa-ellipsis-v"></i><span class="js-heading-text"></span></h4>
						</div>
					</div>

					<div class="long-toolkit-widget-inside">
						<?php
						if ( count( $args['fields'] ) ) {

							foreach ( $args['fields'] as $field ) {

								/**
								 * Add field type to global array
								 */
								$long_toolkit_registered_fields[] = $field['type'];

								$field['el_class'] = 'child-field';

								$lable = !empty( $field['heading'] ) ? sprintf( '<label class="repeater-field-label">%s</label>', $field['heading'] ) : '';

								$desc = !empty( $field['desc'] ) ? sprintf( '<p class="repeater-field-description">%s</p>', $field['desc'] ) : '';

								$attrs = sprintf( 'data-param_name="%s" ', $field['name'] );

								$attrs .= !empty( $field['dependency'] ) && is_array( $field['dependency'] ) ? 'data-rpt_dependency="' . esc_attr( json_encode( $field['dependency'] ) ) . '"' : '';

								$show_label = !empty( $field['show_label'] ) ? 'show_label' : '';

								$row_field_class = sprintf( 'repeater_field_%s type_%s %s ', $field['name'], $field['type'], $show_label );

								if ( function_exists( "long_toolkit_form_{$field['type']}" ) ) {

									if ( $field['type'] == 'checkbox' ) {

										$multiple = isset( $field['multiple'] ) && $field['multiple'] ? 1 : 0;

										if ( !$multiple ) {

											$lable = !empty( $field['heading'] ) ? sprintf( '<label class="repeater-field-label">%s</label>', $field['heading'] ) : '';

											$checkbox_wrapper = '<div class="repeater_form_row long_toolkit_form_row %3$s"  data-type="%4$s" %6$s><div class="repeater-col-field">%2$s %1$s %5$s</div></div>';

											printf( $checkbox_wrapper, $lable, call_user_func( "long_toolkit_form_{$field['type']}", $field, '' ), $row_field_class, $field['type'], $desc, $attrs );
										}
									} else {
										printf( $field_wrapper, $lable, call_user_func( "long_toolkit_form_{$field['type']}", $field, '' ) . $desc, $row_field_class, $field['type'], $attrs );
									}
								} else if ( has_filter( "long_toolkit_form_{$field['type']}" ) ) {
									$field_output = apply_filters( "long_toolkit_form_{$field['type']}", '', $field, $desc, $row_field_class, $attrs );
									printf( $field_wrapper, $lable, $field_output . $desc, $row_field_class, $field['type'], $attrs );
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<button class="btn-add" data-repeater-create type="button">
			<i class="long-toolkit-icon-add"></i>
		</button>
	</div>
	<?php
	return ob_get_clean();
}
