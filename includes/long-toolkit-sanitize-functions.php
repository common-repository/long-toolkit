<?php

/**
 * Sanitize functions
 * @package   Long_Toolkit/Functions
 * @category  Functions
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.2
 */

/**
 * Sanitize text-transform css value
 * @since 1.0.2
 * 
 * @return string $value
 * @return string Value sanitized
 */
function long_toolkit_sanitize_text_transform( $value ) {

	$arr = array( 'none', 'capitalize', 'uppercase', 'lowercase', 'initial' );

	if ( !in_array( $value, $arr ) ) {
		return '';
	}

	return $value;
}

/**
 * Sanitize font variants value
 * @since 1.0.2
 * 
 * @return string $value
 * @return string Value sanitized
 */
function long_toolkit_sanitize_font_variants( $value ) {

	$variants = Long_Toolkit_Fonts::get_all_variants();

	if ( is_string( $value ) && !array_key_exists( $value, $variants ) ) {
		return '';
	}
	return $value;
}

/**
 * Sanitize font subsets value
 * @since 1.0.2
 * 
 * @return string $value
 * @return string Value sanitized
 */
function long_toolkit_sanitize_font_subsets( $value ) {
	$subsets = Long_Toolkit_Fonts::get_google_font_subsets();
	if ( is_string( $value ) && !array_key_exists( $value, $subsets ) ) {
		return '';
	}

	return $value;
}
