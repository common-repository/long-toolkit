<?php
/**
 * Image Picker
 * 
 * @package   Long_Toolkit/Corefields
 * @category  Functions
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Field Image Picker.
 *
 * @param $settings
 * @param string $value
 *
 * @since 1.0.0
 * @return string - html string.
 */

function long_toolkit_form_image_picker( $settings, $value ) {

	ob_start();

	$attrs = array();

	if ( !empty( $settings['name'] ) ) {
		$attrs[] = 'name="' . $settings['name'] . '"';
	}

	if ( !empty( $settings['id'] ) ) {
		$attrs[] = 'id="' . $settings['id'] . '"';
	}

	$attrs[] = 'data-type="' . $settings['type'] . '"';

	$multiple = isset( $settings['multiple'] ) ? absint( $settings['multiple'] ) : 0;
	
	$uniqid  = uniqid();
	
	?>
	<div class="long-toolkit-field long-toolkit-image_picker" data-multiple="<?php echo esc_attr( $multiple ) ?>" id="long-toolkit-image-<?php echo esc_attr( $uniqid ) ?>">
		<?php
		printf( '<input type="hidden" class="attach_images long_toolkit_value" value="%s" %s/>', $value, implode( ' ', $attrs ) );

		$value = explode( ',', trim( $value ) );
		?>
		<div class="attached_images">
			
			<ul class="image_list">
				<?php
				if ( !empty( $value[0] ) && sizeof( $value ) > 0 ) {
					foreach ( $value as $str ) {
						$arr = explode( '|', $str );
						if ( !empty( $arr[0] ) && sizeof( $arr ) > 0 ) {
							$id = $arr[0];
							?>
							<li class="added" data-id="<?php echo esc_attr( $id ) ?>">
								<div class="inner">
									<?php echo wp_get_attachment_image( $id, 'thumbnail' ) ?>
								</div>
								<a href="#" class="remove" title="<?php echo esc_attr__( 'Remove', 'long-toolkit' ) ?>"></a>
							</li>
							<?php
						}
					}
				}
				?>

			</ul>

			<a class="add_images" href="#" title="<?php echo esc_attr__( 'Add images', 'long-toolkit' ) ?>"><?php echo esc_attr__( 'Add images', 'long-toolkit' ) ?></a>

		</div>
	</div>
	<?php
	return ob_get_clean();
}


