<?php

/**
 * Class Multicheck Control
 *
 * @class     Long_Toolkit_Customize_Multicheck_Control
 * @package   Long_Toolkit/Customize_Field
 * @category  Class
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.0
 */
if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Long_Toolkit_Customize_Multicheck_Control Class
	 */
	class Long_Toolkit_Customize_Multicheck_Control extends WP_Customize_Control {

		public $type = 'long_toolkit_multicheck';

		/**
		 * Maximum number of options the user will be able to select.
		 * Set to 1 for single-select.
		 *
		 * @access public
		 * @var int
		 */
		public $multiple = 1;

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'options' => $this->choices,
				'multiple' => $this->multiple,
				'type' => $this->type,
				'customize_link' => $this->get_link()
			);
			
			if ( !empty( $this->description ) ) {
				printf( '<span class="description customize-control-description">%s</span>', $this->description );
			}
			
			echo long_toolkit_form_checkbox( $args, $this->value() );
			
		}

	}
endif;