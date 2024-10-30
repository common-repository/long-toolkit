<?php

/**
 * Field Typography
 *
 * @param $settings
 * @param string $value
 *
 * @since 1.0.0
 * @return string - html string.
 */
function long_toolkit_form_typography( $settings, $value = array() ) {

	$attrs = array();

	if ( ! empty( $settings['name'] ) ) {
		$attrs[] = 'name="' . $settings['name'] . '"';
	}

	if ( ! empty( $settings['id'] ) ) {
		$attrs[] = 'id="' . $settings['id'] . '"';
	}

	if ( ! empty( $settings['customize_link'] ) ) {
		$attrs[] = $settings['customize_link'];
	}

	$data = array();

	/**
	 * Using the $subfields to decided which fields are appear
	 */
	$subfields = isset( $settings['default'] ) ? $settings['default'] : array();

	$data = long_toolkit_build_typography( $value );

	$attrs[] = 'data-type="typography"';
	if ( is_array( $value ) ) {
		$value = '';
	}
	$output = '';
	$output .= sprintf( '<div class="long-toolkit-field long-toolkit-typography" data-id="%s" data-value="%s">', uniqid(), $value );
	$output .= sprintf( '<input type="hidden" class="long_toolkit_value" %s/>', implode( $attrs ) );

	$output .= '<div class="font_family">';
	$output .= sprintf( '<label>%s</label>', __( 'Font Family', 'long-toolkit' ) );
	$output .= '<select></select>';
	$output .= '</div>';

	$output .= '<div class="variants">';
	$output .= sprintf( '<label>%s</label>', __( 'Variants', 'long-toolkit' ) );
	$output .= sprintf( '<select placeholder="%s" multiple>%s</select>', __( 'Select Variants...', 'long-toolkit' ), '' );
	$output .= '</div>';

	$output .= '<div class="subsets">';
	$output .= sprintf( '<label>%s</label>', __( 'Subsets', 'long-toolkit' ) );
	$output .= sprintf( '<select placeholder="%s" multiple>%s</select>', __( 'Select Subsets...', 'long-toolkit' ), '' );
	$output .= '</div>';

	$output .= '<div class="subrow">';

	if ( isset( $subfields['line-height'] ) ) {
		$output      .= '<div class="line_height">';
		$output      .= sprintf( '<label>%s</label>', __( 'Light Height', 'long-toolkit' ) );
		$line_height = isset( $data['line-height'] ) ? $data['line-height'] : '';
		$output      .= sprintf( '<input type="text" value="%s" data-key="line-height" placeholder="%s"/>', $line_height, __( '1.4em', 'long-toolkit' ) );
		$output      .= '</div>';
	}

	if ( isset( $subfields['font-size'] ) ) {

		$output    .= '<div class="font_size">';
		$output    .= sprintf( '<label>%s</label>', __( 'Font Size', 'long-toolkit' ) );
		$font_size = isset( $data['font-size'] ) ? $data['font-size'] : '';
		$output    .= sprintf( '<input type="text" value="%s" data-key="font-size" placeholder="%s"/>', $font_size, __( '14px', 'long-toolkit' ) );
		$output    .= '</div>';
	}

	if ( isset( $subfields['letter-spacing'] ) ) {
		$output         .= '<div class="letter_spacing">';
		$output         .= sprintf( '<label>%s</label>', __( 'Letter Spacing', 'long-toolkit' ) );
		$letter_spacing = isset( $data['letter-spacing'] ) ? $data['letter-spacing'] : '';
		$output         .= sprintf( '<input type="text" value="%s" data-key="letter-spacing" placeholder="%s"/>', $letter_spacing, __( '1px', 'long-toolkit' ) );
		$output         .= '</div>';
	}

	if ( isset( $subfields['text-transform'] ) ) {
		$output         .= '<div class="text_transform">';
		$output         .= sprintf( '<label>%s</label>', __( 'Text Transform', 'long-toolkit' ) );
		$text_transform = isset( $data['text-transform'] ) ? $data['text-transform'] : '';

		$text_transform_opts = array(
			'none'       => esc_attr__( 'None', 'long-toolkit' ),
			'capitalize' => esc_attr__( 'Capitalize', 'long-toolkit' ),
			'uppercase'  => esc_attr__( 'Uppercase', 'long-toolkit' ),
			'lowercase'  => esc_attr__( 'Lowercase', 'long-toolkit' ),
			'initial'    => esc_attr__( 'Initial', 'long-toolkit' )
		);

		$output .= '<select data-key="text-transform">';
		foreach ( $text_transform_opts as $key => $value ) {
			$output .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $text_transform, $key, false ), $value );
		}

		$output .= '</select>';
	}

	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
