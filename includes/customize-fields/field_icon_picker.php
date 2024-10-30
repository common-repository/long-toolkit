<?php

/**
 * Class Icon Picker Control
 *
 * @class     Long_Toolkit_Customize_Icon_Picker_Control
 * @package   Long_Toolkit/Customize_Field
 * @category  Class
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.0
 */
if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Long_Toolkit_Customize_Icon_Picker_Control Class
	 */
	class Long_Toolkit_Customize_Icon_Picker_Control extends WP_Customize_Control {

		public $type = 'long_toolkit_icon_picker';

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'type' => $this->type,
				'customize_link' => $this->get_link(),
			);
			
			if ( !empty( $this->description ) ) {
				printf( '<span class="description customize-control-description">%s</span>', $this->description );
			}
			echo long_toolkit_form_icon_picker( $args, $this->value() );
			
			
		}

	}
endif;