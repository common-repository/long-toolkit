<?php

/**
 * Sample Taxonomy
 *
 * @package     Long_Toolkit
 * @category    Sample
 * @author      HQL
 * @license     GPLv3
 */

/**
 * Term Meta
 * Display in wp-admin/edit-tags.php?taxonomy=category
 */
function long_toolkit_example_category() {

	$fields = long_toolkit_example_fields();

	$repeater = array(
		'name' => 'long_toolkit_repeater',
		'type' => 'repeater',
		'heading' => __( 'Repeater', 'long-toolkit' ),
		'value' => '',
		'desc' => '',
		'fields' => $fields
	);

	$all = $fields;
	$all[] = $repeater;

	$term_args = array(
		'id' => 'long_toolkit_example_category',
		'pages' => array( 'post_tag','category' ), //Display in category screen
		'heading' => __( 'Group label', 'long-toolkit' ),
		'manage_box' => true,
		'fields' => array(
			//Group Default
			array(
				'name' => 'autocomplete',
				'type' => 'autocomplete',
				'heading' => __( 'Autocomplete', 'long-toolkit' ),
				'value' => '',
				'desc' => __( 'Ajax select', 'long-toolkit' ),
				'data' => array( 'post_type' => array( 'post' ) ),
				'placeholder' => __( 'Enter 3 or more characters to search...', 'long-toolkit' ),
				'min_length' => 3
			),
			array(
				'name' => 'long_toolkit_select',
				'type' => 'select',
				'heading' => __( 'Select:', 'long-toolkit' ),
				'value' => 'eric',
				'desc' => __( 'A short description for Select box', 'long-toolkit' ),
				'options' => array(
					'' => __( 'Select ...', 'long-toolkit' ),
					1 => __( 'Show Text field', 'long-toolkit' ),
					2 => __( 'Show Text area', 'long-toolkit' ),
					3 => __( 'Charles Wheeler', 'long-toolkit' ),
					4 => __( 'Anthony Perkins', 'long-toolkit' )
				)
			),
			array(
				'name' => 'long_toolkit_textfield',
				'type' => 'textfield',
				'heading' => __( 'Text field:', 'long-toolkit' ),
				'value' => 'A default text',
				'desc' => __( 'A short description for Text Field', 'long-toolkit' ),
				'show_label' => true, //Work on repeater field
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => 1)
				)
			),
			array(
				'name' => 'long_toolkit_textarea',
				'type' => 'textarea',
				'heading' => __( 'Text Area:', 'long-toolkit' ),
				'value' => 'A default text',
				'desc' => __( 'A short description for Text Area', 'long-toolkit' ),
				'dependency' => array(
					'long_toolkit_select' => array( 'values' => 2)
				)
			),
			
			array(
				'name' => 'long_toolkit_textfield_multi',
				'type' => 'textfield',
				'multiple' => true,
				'heading' => __( 'Mutilple Text field:', 'long-toolkit' ),
				'value' => 'A default text',
				'desc' => __( 'A short description for Mutilple Text Field', 'long-toolkit' ),
				'show_label' => true, //Work on repeater field
			),
			array(
				'name' => 'long_toolkit_textfield_multi2',
				'type' => 'textfield',
				'multiple' => true,
				'heading' => __( 'Mutilple Text field 2:', 'long-toolkit' ),
				'value' => array( 'Default value 1', 'Default value 2' ),
				'desc' => __( 'Multi textfield with default values', 'long-toolkit' ),
				'show_label' => true, //Work on repeater field
			),
			array(
				'name' => 'long_toolkit_select_multiple_g',
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
				'show_label' => true//Work on repeater field
			),
			array(
				'name' => 'long_toolkit_checkbox_g',
				'type' => 'checkbox',
				'heading' => __( 'Checkbox:', 'long-toolkit' ),
				'value' => 0,
				'desc' => __( 'A short description for single Checkbox', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_checkbox_multiple_g',
				'type' => 'checkbox',
				'multiple' => true,
				'heading' => __( 'Checkbox multiple:', 'long-toolkit' ),
				'value' => array(
					'donna', 'charles'
				),
				'inline' => 0,
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				),
				'desc' => __( 'A short description for Checkbox multiple', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_checkbox_radio_g',
				'type' => 'radio',
				'heading' => __( 'Radio multiple:', 'long-toolkit' ),
				'inline' => 1,
				'value' => 'eric',
				'options' => array(
					'donna' => __( 'Donna Delgado', 'long-toolkit' ),
					'eric' => __( 'Eric Austin', 'long-toolkit' ),
					'charles' => __( 'Charles Wheeler', 'long-toolkit' ),
					'anthony' => __( 'Anthony Perkins', 'long-toolkit' )
				),
				'description' => __( 'Checkbox multiple description', 'long-toolkit' ),
				'show_label' => true//Work on repeater field
			),
			array(
				'name' => 'long_toolkit_color_g',
				'type' => 'color_picker',
				'heading' => __( 'Color:', 'long-toolkit' ),
				'value' => '#cccccc',
				'desc' => __( 'A short description for Color Picker', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_image_g',
				'type' => 'image_picker',
				'multiple' => false,
				'heading' => __( 'Single Image:', 'long-toolkit' ),
				'desc' => __( 'A short description for Image Picker', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_multiple_image_g',
				'type' => 'image_picker',
				'multiple' => true,
				'heading' => __( 'Multi Image:', 'long-toolkit' ),
				'desc' => __( 'A short description for Image Picker with multiple is true', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_image_select_g',
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
				'name' => 'long_toolkit_image_select_vertical_g',
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
				'name' => 'long_toolkit_icon_picker_g',
				'type' => 'icon_picker',
				'heading' => __( 'Icon Picker', 'long-toolkit' ),
				'desc' => __( 'A short description', 'long-toolkit' ),
			),
			array(
				'name' => 'long_toolkit_link_g',
				'type' => 'link',
				'heading' => __( 'Custom Link', 'long-toolkit' ),
				'desc' => __( 'We have a custom Link very friendly and easy to use.', 'long-toolkit' ),
				'value' => ''//default
			),
			array(
				'name' => 'long_toolkit_datetime_g',
				'type' => 'datetime',
				'heading' => __( 'Datetime', 'long-toolkit' ),
				'desc' => __( 'A cool datetime.', 'long-toolkit' ),
				'value' => ''//default
			),
			array(
				'name' => 'long_toolkit_file_multiple',
				'type' => 'upload',
				'heading' => __( 'File upload multiple JPEG, PNG', 'long-toolkit' ),
				'multiple' => true,
				'mime_types' => 'image/jpeg,audio/mpeg',
				'desc' => esc_html__( 'Show image jpeg and audio, note: leave empty in field settings to show all mime types.', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_file',
				'type' => 'upload',
				'heading' => __( 'File upload Audio', 'long-toolkit' ),
				'multiple' => false,
				'mime_types' => 'audio/mpeg',
				'desc' => esc_html__( 'Just show audio', 'long-toolkit' )
			),
			array(
				'name' => 'long_toolkit_map_g',
				'type' => 'map',
				'heading' => __( 'Search map location', 'long-toolkit' ),
				'desc' => __( 'Drag the pin to manually set listing coordinates. Now very easy to save a latlng and zoom settings from user. ', 'long-toolkit' ),
				'value' => ''//default
			),
			//Group
			array(
				'type' => 'repeater',
				'name' => 'repeater_group',
				'heading' => __( 'Repeater', 'long-toolkit' ),
				'group' => 'Repeater',
				'fields' => $fields
			)
		)//Array fields
	);
	
	new Long_Toolkit_Taxonomy( $term_args );
}

add_action( 'long_toolkit_termbox_init', 'long_toolkit_example_category' );

