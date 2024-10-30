<?php

/**
 * Sample Widget
 *
 * @package     Long_Toolkit
 * @category    Sample
 * @author      HQL
 * @license     GPLv3
 */

/**
 * Widget
 * Display in wp-admin/widgets.php
 */
class Long_Toolkit_Example_Widget extends Long_Toolkit_Widget {

	public function __construct() {

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

		$this->widget_cssclass = 'long_toolkit_example_widget';
		$this->widget_description = __( "Display the sample fields in the sidebar.", 'long-toolkit' );
		$this->widget_id = 'long_toolkit_example_widget';
		$this->widget_name = __( 'Long_Toolkit Example Fields', 'long-toolkit' );
		$this->fields = $all;
		parent::__construct();
	}
	
	/**
	 * Widget output
	 */
	public function widget( $args, $instance ) {
		$this->widget_start( $args, $instance );
		//Your Content widget
		$this->widget_end( $args );
	}

}

/**
 * Init widget
 */
function long_toolkit_example_widget_init() {
	register_widget( 'Long_Toolkit_Example_Widget' );
}

/**
 * Hook to widgets_init
 */
add_action( 'widgets_init', 'long_toolkit_example_widget_init' );
