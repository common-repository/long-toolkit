<?php
/*
  Plugin Name: Long Toolkit
  Plugin URI: https://wordpress.org/plugins/long-toolkit/
  Description: Create Admin fields, metabox, widget, taxonomy, menu meta, customizer fields quickly and friendly.
  Author: longbsvnu
  Version: 2.5
  Author URI: https://hoangquoclong.com
  Text Domain: long-toolkit
  License: GPLv3
  License URI: URI: https://www.gnu.org/licenses/gpl-3.0.html
  Requires at least: 4.5
  Tested up to: 5.4
 */

final class Long_Toolkit {

	/**
	 * Long Toolkit version.
	 *
	 * @var string
	 */
	public $version = '2.5';

	/**
	 * The single instance of the class.
	 *
	 * @var Long Toolkit
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Long Toolkit Instance.
	 *
	 * Ensures only one instance of Long Toolkit is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see ltfw()
	 * @return Long Toolkit - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Init plugin
	 * @since 1.0
	 */
	public function __construct() {
		$this->defined();
		$this->includes();
		$this->hooks();

		do_action( 'long_toolkit_loaded' );
	}

	/**
	 * Main hook in plugin
	 * @since 1.0
	 */
	public function hooks() {

		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'customize_register', array( $this, 'customize_fields' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_scripts' ) );

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'admin_init', array( $this, 'admin_fields' ) );

			add_action( 'current_screen', array( $this, 'termbox_init' ) );
			add_action( 'wp_ajax_add-tag', array( $this, 'termbox_ajax_init' ), 1 );

			add_action( 'load-post.php', array( $this, 'metabox_init' ) );
			add_action( 'load-post-new.php', array( $this, 'metabox_init' ) );

			add_action( 'load-nav-menus.php', array( $this, 'menu_init' ) );
		}
	}

	/**
	 * Create environment to init taxonomy meta
	 * @since 1.0.0
	 */
	public function termbox_init( $screen ) {
		if ( $screen->base == 'edit-tags' || $screen->base == 'term' ) {
			do_action( 'long_toolkit_termbox_init', $screen );
		}
	}

	/**
	 * Create Ajax environment to add taxonomy
	 * @since 1.0.0
	 */
	public function termbox_ajax_init() {

		if ( isset( $_POST['screen'], $_POST['taxonomy'], $_POST['post_type'], $_POST['action'] ) ) {

			$screen = array(
				'id' => sanitize_text_field( $_POST['screen'] ),
				'taxonomy' => sanitize_text_field( $_POST['taxonomy'] ),
				'post_type' => sanitize_text_field( $_POST['post_type'] ),
				'action' => sanitize_text_field( $_POST['action'] ),
				'base' => 'add-tags'
			);

			do_action( 'long_toolkit_termbox_init', (object) $screen );
		}
	}

	/**
	 * Create environment to init post metabox
	 * @since 1.0.0
	 */
	public function metabox_init() {
		do_action( 'long_toolkit_metabox_init' );
	}

	public function menu_init() {
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-menu.php';
	}

	public function customize_fields() {
		$this->register_customize_field( 'Long_Toolkit_Customize_Select_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Multicheck_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Icon_Picker_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Repeater_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Map_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Link_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Datetime_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Typography_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Image_Select_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Autocomplete_Control' );
		$this->register_customize_field( 'Long_Toolkit_Customize_Heading_Control' );
		$this->set_control_types();
	}

	private function set_control_types() {

		global $long_toolkit_control_types;

		$long_toolkit_control_types = apply_filters( 'long_toolkit_control_types', array(
			'image' => 'WP_Customize_Image_Control',
			'cropped_image' => 'WP_Customize_Cropped_Image_Control',
			'upload' => 'WP_Customize_Upload_Control',
			'color' => 'WP_Customize_Color_Control',
			'long_toolkit_select' => 'Long_Toolkit_Customize_Select_Control',
			'long_toolkit_multicheck' => 'Long_Toolkit_Customize_Multicheck_Control',
			'long_toolkit_icon_picker' => 'Long_Toolkit_Customize_Icon_Picker_Control',
			'long_toolkit_repeater' => 'Long_Toolkit_Customize_Repeater_Control',
			'long_toolkit_map' => 'Long_Toolkit_Customize_Map_Control',
			'long_toolkit_link' => 'Long_Toolkit_Customize_Link_Control',
			'long_toolkit_datetime' => 'Long_Toolkit_Customize_Datetime_Control',
			'long_toolkit_typography' => 'Long_Toolkit_Customize_Typography_Control',
			'long_toolkit_image_select' => 'Long_Toolkit_Customize_Image_Select_Control',
			'long_toolkit_autocomplete' => 'Long_Toolkit_Customize_Autocomplete_Control',
			'long_toolkit_heading' => 'Long_Toolkit_Customize_Heading_Control'
				) );

		// Make sure the defined classes actually exist.
		foreach ( $long_toolkit_control_types as $key => $classname ) {

			if ( !class_exists( $classname ) ) {
				unset( $long_toolkit_control_types[$key] );
			}
		}
	}

	/**
	 * Load field in admin
	 * @since 1.0
	 */
	public function admin_fields() {
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_default.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_color_picker.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_datetime.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_icon_picker.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_image_picker.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_image_select.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_link.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_map.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_repeater.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_typography.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_autocomplete.php';
		include LONG_TOOLKIT_DIR . 'includes/admin-fields/field_upload.php';
	}

	/**
	 * Include library
	 * @since 1.0
	 */
	public function includes() {

		include LONG_TOOLKIT_DIR . 'includes/long-toolkit-sanitize-functions.php';
		include LONG_TOOLKIT_DIR . 'includes/long-toolkit-helpers-functions.php';
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-fonts.php';
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-widget.php';
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-customizer.php';
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-metabox.php';
		include LONG_TOOLKIT_DIR . 'includes/class-long-toolkit-taxonomy.php';

		/**
		 * Load addons
		 */
		include LONG_TOOLKIT_ADDONS_DIR . '/importer/importer.php';

		do_action( 'long_toolkit_includes' );
	}

	/**
	 * Defined
	 * @since 1.0
	 */
	public function defined() {
		define( 'LONG_TOOLKIT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		define( 'LONG_TOOLKIT_VERSION', $this->version );
		define( 'LONG_TOOLKIT_DIR', plugin_dir_path( __FILE__ ) );
		define( 'LONG_TOOLKIT_URL', plugin_dir_url( __FILE__ ) );
		define( 'LONG_TOOLKIT_ADDONS_DIR', LONG_TOOLKIT_DIR . 'addons' );
		define( 'LONG_TOOLKIT_ADDONS_URL', LONG_TOOLKIT_URL . 'addons' );

		global $long_toolkit_customizer_dependency;
		$long_toolkit_customizer_dependency = array();
	}

	/**
	 * Load Localisation files.
	 * @since 1.0
	 * @return void
	 */
	public function load_plugin_textdomain() {

		// Set filter for plugin's languages directory
		$long_toolkit_dir = LONG_TOOLKIT_DIR . 'languages/';
		$long_toolkit_dir = apply_filters( 'long_toolkit_languages_directory', $long_toolkit_dir );

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'long-toolkit' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'long-toolkit', $locale );

		// Setup paths to current locale file
		$mofile_local = $long_toolkit_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/long-toolkit/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/tp-framework folder
			load_textdomain( 'long-toolkit', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/tp-framework/languages/ folder
			load_textdomain( 'long-toolkit', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'long-toolkit', false, $long_toolkit_dir );
		}
	}

	/**
	 * Register and load customize field
	 * @return void
	 */
	private function register_customize_field( $control_class ) {

		$path = str_replace( 'Long_Toolkit_Customize_', 'field_', $control_class );
		$path = str_replace( '_Control', '.php', $path );
		$path = strtolower( $path );
		$path = LONG_TOOLKIT_DIR . 'includes/customize-fields/' . $path;

		if ( is_readable( $path ) ) {
			include $path;
			global $wp_customize;
			$wp_customize->register_control_type( $control_class );
		}
	}

	/**
	 * Enqueue admin scripts
	 * @since 1.0
	 * @return void
	 */
	public function admin_scripts( $hook_suffix ) {

		$min = WP_DEBUG ? '' : '.min';

		global $long_toolkit_registered_fields;

		/**
		 * Init register nav menu meta item
		 */
		if ( !empty( $long_toolkit_registered_fields ) ) {

			$long_toolkit_registered_fields = array_unique( $long_toolkit_registered_fields );

			wp_enqueue_style( 'font-awesome', LONG_TOOLKIT_URL . 'assets/css/font-awesome' . $min . '.css', null, '4.7.0' );
			wp_enqueue_style( 'long-toolkit-admin', LONG_TOOLKIT_URL . 'assets/css/admin' . $min . '.css', null, LONG_TOOLKIT_VERSION );

			wp_enqueue_script( 'long-toolkit-libs', LONG_TOOLKIT_URL . 'assets/js/libs' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
			wp_enqueue_script( 'long-toolkit-admin', LONG_TOOLKIT_URL . 'assets/js/admin_fields' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
			wp_enqueue_script( 'dependency', LONG_TOOLKIT_URL . 'assets/vendors/dependency/dependency' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );

			$upload_dir = wp_upload_dir();

			$localize = array(
				'upload_url' => $upload_dir['baseurl']
			);

			foreach ( $long_toolkit_registered_fields as $type ) {
				switch ( $type ) {
					case 'color_picker':
						wp_enqueue_script( 'wp-color-picker' );
						wp_enqueue_style( 'wp-color-picker' );
						break;
					case 'image_picker':
					case 'upload':
						$localize['upload_invalid_mime'] = esc_html__( 'The selected file has an invalid mimetype in this field.', 'long-toolkit' );
						wp_enqueue_media();
						wp_enqueue_script( 'jquery-ui' );
						break;
					case 'textfield':
						wp_enqueue_script( 'jquery-ui' );
						break;
					case 'icon_picker':
						wp_enqueue_script( 'font-iconpicker', LONG_TOOLKIT_URL . 'assets/vendors/fonticonpicker/js/jquery.fonticonpicker' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
						wp_enqueue_style( 'font-iconpicker', LONG_TOOLKIT_URL . 'assets/vendors/fonticonpicker/css/jquery.fonticonpicker' . $min . '.css', null, LONG_TOOLKIT_VERSION );
						break;
					case 'map':
						$gmap_key = sanitize_text_field( apply_filters( 'long_toolkit_gmap_key', '' ) );
						wp_enqueue_script( 'google-map-v-3', "//maps.googleapis.com/maps/api/js?v=3&libraries=places&key={$gmap_key}", array( 'jquery' ), null, true );
						wp_enqueue_script( 'geocomplete', LONG_TOOLKIT_URL . 'assets/vendors/geocomplete/jquery.geocomplete' . $min . '.js', null, LONG_TOOLKIT_VERSION );
						break;
					case 'icon_picker':
						wp_enqueue_script( 'font-iconpicker', LONG_TOOLKIT_URL . 'assets/vendors/fonticonpicker/js/jquery.fonticonpicker' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
						wp_enqueue_style( 'font-iconpicker', LONG_TOOLKIT_URL . 'assets/vendors/fonticonpicker/css/jquery.fonticonpicker' . $min . '.css', null, LONG_TOOLKIT_VERSION );
						break;
					case 'link':
						$screens = apply_filters( 'long_toolkit_link_on_screens', array( 'post.php', 'post-new.php' ) );
						if ( !in_array( $hook_suffix, $screens ) ) {
							wp_enqueue_style( 'editor-buttons' );
							wp_enqueue_script( 'wplink' );

							add_action( 'in_admin_header', 'long_toolkit_link_editor_hidden' );
							add_action( 'customize_controls_print_footer_scripts', 'long_toolkit_link_editor_hidden' );
						}
						break;
					case 'repeater':
						wp_enqueue_editor();
						wp_enqueue_script( 'jquery-repeater', LONG_TOOLKIT_URL . 'assets/js/repeater-libs' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
						break;
					case 'textarea':
						wp_enqueue_editor();
					case 'select':
					case 'typography':
					case 'autocomplete':

						wp_enqueue_script( 'selectize', LONG_TOOLKIT_URL . 'assets/vendors/selectize/selectize' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
						wp_enqueue_style( 'selectize', LONG_TOOLKIT_URL . 'assets/vendors/selectize/selectize' . $min . '.css', null, LONG_TOOLKIT_VERSION );
						wp_enqueue_style( 'selectize-skin', LONG_TOOLKIT_URL . 'assets/vendors/selectize/selectize.default' . $min . '.css', null, LONG_TOOLKIT_VERSION );

						if ( $type == 'typography' ) {

							$localize['subsets'] = Long_Toolkit_Fonts::get_google_font_subsets();

							$localize['variants'] = Long_Toolkit_Fonts::get_all_variants();

							$localize['fonts'] = Long_Toolkit_Fonts::get_all_fonts_reordered();
						}

						break;
					case 'datetime':
						wp_enqueue_script( 'datetimepicker', LONG_TOOLKIT_URL . 'assets/vendors/datetimepicker/jquery.datetimepicker' . $min . '.js', array( 'jquery' ), LONG_TOOLKIT_VERSION );
						wp_enqueue_style( 'datetimepicker', LONG_TOOLKIT_URL . 'assets/vendors/datetimepicker/jquery.datetimepicker' . $min . '.css', null, LONG_TOOLKIT_VERSION );
						break;
					default :
						do_action( 'long_toolkit_admin_' . $type . '_scripts' );
						break;
				}
			}

			wp_localize_script( 'long-toolkit-admin', 'long_toolkit_var', apply_filters( 'long_toolkit_localize_var', $localize ) );
		}
	}

	/**
	 * Binds the JS listener to make Customizer control
	 *
	 * @since 1.0.0
	 */
	public function customize_scripts() {

		global $long_toolkit_customizer_dependency;

		$min = WP_DEBUG ? '' : '.min';
		wp_enqueue_script( 'long-toolkit-customize-field', LONG_TOOLKIT_URL . 'assets/js/customize-fields' . $min . '.js', array( 'customize-controls' ), LONG_TOOLKIT_VERSION, true );


		if ( !empty( $long_toolkit_customizer_dependency ) ) {
			wp_localize_script( 'long-toolkit-customize-field', 'long_toolkit_customizer_dependency', $long_toolkit_customizer_dependency );
		}
	}

}

/**
 * Main instance of Long Toolkit.
 *
 * Returns the main instance of Long Toolkit to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Long Toolkit
 */
function ltfw() {
	return Long_Toolkit::instance();
}

// Global for backwards compatibility.
$GLOBALS['Long_Toolkit'] = ltfw();

// require 'sample/sample.php';
