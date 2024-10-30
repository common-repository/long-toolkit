<?php
/**
 * Upload
 * 
 * @package   Long_Toolkit/Corefields
 * @category  Functions
 * @author    HQL
 * @license   GPLv3
 * @version   1.0.4
 */

/**
 * Field upload
 *
 * @param $settings
 * @param string $value
 *
 * @since 1.0.4
 * @return string - html string.
 */
function long_toolkit_form_upload( $settings, $value ) {
	ob_start();
	/**
	 * Css Class
	 */
	$css_class = 'long-toolkit-field long-toolkit-upload';

	if ( !empty( $settings['el_class'] ) ) {
		$css_class .= ' ' . $settings['el_class'];
	}

	/**
	 * Attributes
	 */
	$attrs = array();

	if ( !empty( $settings['name'] ) ) {
		$attrs[] = 'name="' . $settings['name'] . '"';
	}

	if ( !empty( $settings['id'] ) ) {
		$attrs[] = 'id="' . $settings['id'] . '"';
	}

	/**
	 * Display media by mime types
	 * Example: image/jpeg,audio/mpeg
	 * Leave empty string to show all media
	 * 
	 * @var string $mime_types
	 * @see //codex.wordpress.org/Function_Reference/get_allowed_mime_types
	 */
	$mime_types = isset( $settings['mime_types'] ) ? $settings['mime_types'] : '';
	$attrs[] = 'data-type="' . $settings['type'] . '"';
	
	$items = long_toolkit_parse_upload( $value );
	
	if ( empty( $items ) ) {
		$items = array(
			array(
				'url' => '',
				'name' => '',
				'hash' => ''
			)
		);
	}
	?>
	<div data-mime_types="<?php echo esc_attr( $mime_types ) ?>" class="<?php echo esc_attr( $css_class ) ?>" id="<?php echo esc_attr( uniqid( 'long-toolkit-upload-' ) ) ?>">

		<?php printf( '<input type="hidden" class="long_toolkit_value" value="%1$s" %2$s/>', esc_attr( $value ), implode( ' ', $attrs ) ); ?>

		<table class="widefat">
			<thead>
				<tr>
					<th class="sort">&nbsp;</th>
					<th><?php echo esc_html__( 'Name', 'long-toolkit' ) ?> <span class="woocommerce-help-tip"></span></th>
					<th colspan="2"><?php echo esc_html__( 'File URL', 'long-toolkit' ) ?> <span class="woocommerce-help-tip"></span></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody class="ui-sortable">
				<?php foreach ( $items as $item ): ?>
					<tr>
						<td class="sort"></td>
						<td class="file_name">
							<input type="text" class="input_text" placeholder="<?php echo esc_attr__( 'File name', 'long-toolkit' ) ?>" data-name="name" value="<?php echo esc_attr( $item['name'] ) ?>">
							<input type="hidden" data-name="hash" value="<?php echo esc_attr( $item['hash'] ) ?>">
						</td>
						<td class="file_url"><input type="text" class="input_text" placeholder="http://" data-name="url" value="<?php echo esc_url( $item['url'] ) ?>"></td>
						<td class="file_url_choose" width="1%"><a href="#" class="button upload_file" data-choose="<?php echo esc_attr__( 'Choose file', 'long-toolkit' ) ?>" data-update="<?php echo esc_attr__( 'Insert file URL', 'long-toolkit' ) ?>"><?php echo esc_html__( 'Choose&nbsp;file', 'long-toolkit' ) ?></a></td>
						<td width="1%"><a href="#" class="delete"><?php echo esc_html__( 'Delete', 'long-toolkit' ) ?></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<?php if ( !empty( $settings['multiple'] ) ): ?>
				<tfoot>
					<tr>
						<th colspan="5">
							<a href="#" class="button insert"><?php echo esc_html__( 'Add File', 'long-toolkit' ) ?></a>
						</th>
					</tr>
				</tfoot>
			<?php endif; ?>
		</table>

	</div>
	<?php
	return ob_get_clean();
}

/**
 * Sanitize field upload
 * @since 1.0.4
 * @param string $value Value of field upload
 * @return string
 */
function long_toolkit_sanitize_upload( $value ) {

	$value = long_toolkit_parse_upload( $value );
	if ( !empty( $value ) && is_array( $value ) ) {
		$value = json_encode( $value );
	}

	return $value;
}

/**
 * Parse files form string
 * @since 1.0.4
 * @param string $value Value of field upload
 * @return array
 */
function long_toolkit_parse_upload( $value = '' ) {
	if ( !empty( $value ) && is_string( $value ) ) {
		$value = stripslashes( $value );
		$value = json_decode( $value, true );
	}

	$arr = '';
	if ( is_array( $value ) ) {
		$arr = array();
		foreach ( $value as $item ) {
			$item = wp_parse_args( $item, array(
				'url' => '',
				'name' => '',
				'hash' => ''
					) );
			$item['url'] = esc_url( $item['url'] );
			$item['name'] = sanitize_text_field( $item['name'] );
			if ( empty( $item['hash'] ) ) {
				$item['hash'] = md5( $item['url'] );
			}
			$item['hash'] = sanitize_text_field( $item['hash'] );
			$arr[] = $item;
		}
	}

	return $arr;
}
