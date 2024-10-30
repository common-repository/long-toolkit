<?php

/**
 * Sample Customizer
 *
 * @package     HQL
 * @category    Sample
 * @author      Long_Toolkit
 * @license     GPLv3
 */

/**
 * Register customizer
 */
function long_toolkit_customize_register( $wp_customize ) {

	/**
	 * Init a Panel
	 */
	$panel = new Long_Toolkit_Customize_Panel( $wp_customize, array(
		'id' => 'long_toolkit_panel',
		'title' => __( 'Long_Toolkit PANEL', 'long-toolkit' ),
		'description' => __( 'My Description', 'long-toolkit' ),
			) );

	/**
	 * Use Panel to add single section
	 */
	$panel->add_section( array(
		'id' => 'long_toolkit_section_1',
		'heading' => esc_attr__( 'SECTION I', 'long-toolkit' ),
		'fields' => array( //Fields in section
			array(
				'name' => 'long_toolkit_text_11',
				'type' => 'text',
				'heading' => 'Text Field',
			),
			array(
				'name' => 'long_toolkit_textarea_11',
				'type' => 'textarea',
				'heading' => __( 'Text Area', 'long-toolkit' ),
			)
		)
	) );

	/**
	 * Use Panel to add a list of sections
	 */
	$panel->add_sections( array(
		//Section 2
		array(
			'id' => 'long_toolkit_section_2',
			'heading' => esc_attr__( 'SECTION II', 'long-toolkit' ),
			'fields' => array(
				array(
					'name' => 'long_toolkit_text_21',
					'type' => 'text',
					'heading' => 'Text Field',
				),
				array(
					'name' => 'long_toolkit_textarea_22',
					'type' => 'textarea',
					'heading' => __( 'Text Area', 'long-toolkit' ),
				),
			)
		),
		//Section 3
		array(
			'id' => 'long_toolkit_section_3',
			'heading' => esc_attr__( 'SECTION III', 'long-toolkit' ),
			'fields' => array(
				array(
					'name' => 'long_toolkit_text_31',
					'type' => 'text',
					'heading' => 'Text Field',
				),
				array(
					'name' => 'long_toolkit_textarea_32',
					'type' => 'textarea',
					'heading' => __( 'Text Area', 'long-toolkit' ),
				),
			)
		)
	) );

	/**
	 * Init section and addto panel
	 */
	$section4 = new Long_Toolkit_Customize_Section( $wp_customize, array(
		'id' => 'long_toolkit_section_4',
		'panel' => $panel, //Add panel
		'heading' => esc_attr__( 'SECTION IV', 'long-toolkit' ),
		'fields' => array(
			array(
				'name' => 'long_toolkit_text_41',
				'type' => 'text',
				'heading' => 'Text Field',
			),
		) )
	);

	/**
	 * Add fields to section
	 */
	$section4->add_fields( array(
		array(
			'name' => 'long_toolkit_textarea_42',
			'type' => 'textarea',
			'heading' => __( 'Text Area', 'long-toolkit' ),
		),
		array(
			'name' => 'long_toolkit_checkbox_41',
			'type' => 'checkbox',
			'value' => 1,
			'heading' => __( 'Single Checkbox', 'long-toolkit' )
		)
	) );

	/**
	 * Add single field to section
	 */
	$section4->add_field( array(
		'name' => 'long_toolkit_checkbox_42',
		'type' => 'checkbox',
		'heading' => __( 'Check list', 'long-toolkit' ),
		'multiple' => 1,
		'value' => 'eric',
		'options' => array(
			'donna' => __( 'Donna Delgado', 'long-toolkit' ),
			'eric' => __( 'Eric Austin', 'long-toolkit' ),
			'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
			'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
		),
	) );

	/**
	 * Init field and push to section
	 */
	new Long_Toolkit_Customize_Field( $wp_customize, array(
		'name' => 'long_toolkit_radio',
		'type' => 'radio',
		'heading' => 'Radio',
		'transport' => 'refresh',
		'value' => '',
		'section' => $section4, //Push to section
		'options' => array(
			'' => 'None',
			1 => 'Hello World',
			2 => 'Hello Php',
			3 => 'Hello WordPress'
		) ) );


	/**
	 * Full Demo
	 */
	new Long_Toolkit_Customize_Section( $wp_customize, array(
		'id' => 'long_toolkit_section_demo',
		'heading' => esc_attr__( 'Long_Toolkit CONTROLS', 'long-toolkit' ),
		'fields' => array(
			array(
				'name' => 'autocomplete_3',
				'type' => 'autocomplete',
				'heading' => __( 'Autocomplete', 'long-toolkit' ),
				'value' => '',
				'desc' => __( 'Ajax select', 'long-toolkit' ),
				'data' => array( 'post_type' => array( 'post' ) ),
				'placeholder' => __( 'Enter 3 or more characters to search...', 'long-toolkit' ),
				'min_length' => 3
			),
			array(
				'name' => 'typography',
				'type' => 'typography',
				'heading' => __( 'Typography:', 'long-toolkit' ),
				'value' => array(
					'font-family' => 'Roboto',
					'variants' => array( 'regular', 'italic' ),
					'subsets' => array( 'latin-ext' ),
					'font-size' => '14px',
					'line-height' => '1.5em',
					'letter-spacing' => '0',
				),
				'desc' => __( 'A short description for Select box', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_textfield',
				'type' => 'textfield',
				'heading' => __( 'Text field:', 'long-toolkit' ),
				'value' => 'A default text',
				'desc' => __( 'A short description for textfield', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_textarea',
				'type' => 'textarea',
				'heading' => __( 'Text Area:', 'long-toolkit' ),
				'value' => 'A default textarea',
				'desc' => __( 'A short description for textarea', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_select',
				'type' => 'select',
				'heading' => __( 'Select:', 'long-toolkit' ),
				'value' => 'eric',
				'desc' => __( 'A short description for Select box', 'long-toolkit' ),
				'transport' => 'postMessage',
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				)
			),
			array(
				'name' => 'long_toolkit_select_multiple',
				'type' => 'select',
				'heading' => __( 'Select multiple:', 'long-toolkit' ),
				'desc' => __( 'A short description for Select Multiple', 'long-toolkit' ),
				'multiple' => true,
				'value' => array( 'eric', 'charles' ),
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				),
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => array( 'eric' ) ),
				)
			),
			array(
				'name' => 'long_toolkit_checkbox',
				'type' => 'checkbox',
				'heading' => __( 'Checkbox', 'long-toolkit' ),
				'value' => 0,
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => array( 'eric' ) ),
				)
			),
			array(
				'name' => 'long_toolkit_checkbox_multiple',
				'type' => 'checkbox',
				'multiple' => true,
				'heading' => __( 'Checkbox multiple:', 'long-toolkit' ),
				'value' => array(
					'donna', 'charles'
				),
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				),
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => array( 'eric' ) ),
				)
			),
			array(
				'name' => 'long_toolkit_checkbox_radio',
				'type' => 'radio',
				'heading' => __( 'Radio multiple:', 'long-toolkit' ),
				'value' => 'eric',
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				),
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => array( 'charles' ) ),
				)
			),
			array(
				'name' => 'long_toolkit_image_select',
				'type' => 'image_select',
				'inline' => 1, //Set 0 to display image vertical
				'heading' => __( 'Image Inline:', 'long-toolkit' ),
				'desc' => __( 'This is a demo for sidebar layout.', 'long-toolkit' ),
				'options' => array(
					'left' => LONG_TOOLKIT_URL . 'sample/assets/sidebar-left.jpg',
					'none' => LONG_TOOLKIT_URL . 'sample/assets/sidebar-none.jpg',
					'right' => LONG_TOOLKIT_URL . 'sample/assets/sidebar-right.jpg',
				),
				'value' => 'right'//default
			),
			array(
				'name' => 'long_toolkit_image_select_vertical',
				'type' => 'image_select',
				'inline' => 0, //Vertical
				'heading' => __( 'Image Vertical:', 'long-toolkit' ),
				'desc' => __( 'This is a demo for vertical image options.', 'long-toolkit' ),
				'options' => array(
					'opt-1' => LONG_TOOLKIT_URL . 'sample/assets/opt-1.jpg',
					'opt-2' => LONG_TOOLKIT_URL . 'sample/assets/opt-2.jpg',
					'opt-3' => LONG_TOOLKIT_URL . 'sample/assets/opt-3.jpg',
				),
				'value' => 'opt-1'//default
			),
			array(
				'name' => 'long_toolkit_color',
				'type' => 'color_picker',
				'heading' => __( 'Color Picker:', 'long-toolkit' ),
				'value' => '#cccccc',
			),
			array(
				'name' => 'long_toolkit_icon_picker',
				'type' => 'icon_picker',
				'heading' => __( 'Icon Picker', 'long-toolkit' ),
				'value' => ''
			),
			array(
				'name' => 'long_toolkit_image',
				'type' => 'image_picker',
				'heading' => __( 'Single Image:', 'long-toolkit' ),
				'desc' => __( 'A short description for Image Picker', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_cropped_image',
				'type' => 'cropped_image',
				'heading' => __( 'Cropped Image:', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_upload',
				'type' => 'upload',
				'heading' => __( 'Upload Field:', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_map',
				'type' => 'map',
				'heading' => __( 'Google map:', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_link',
				'type' => 'link',
				'heading' => __( 'Enter a link:', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_datetime',
				'type' => 'datetime',
				'heading' => __( 'Datetime:', 'long-toolkit' ),
				'options' => array(
					'min_date' => 0
				)
			),
		//Update later
		) )
	);

	$repeater_section = new Long_Toolkit_Customize_Section( $wp_customize, array(
		'id' => 'long_toolkit_repeater_section',
		'heading' => esc_attr__( 'Repeater', 'long-toolkit' ),
		'fields' => array(
			array(
				'name' => 'long_toolkit_repeater',
				'type' => 'repeater',
				'heading' => 'Demo Repeater',
				'fields' => long_toolkit_example_fields()
			)
		)
			) );
}

/**
 * Hook to Customize Register
 */
add_action( 'customize_register', 'long_toolkit_customize_register', 11 );
