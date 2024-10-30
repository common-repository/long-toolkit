<?php

/**
 * Include Sample List
 *
 * @package     Long_Toolkit
 * @category    Sample
 * @author      HQL
 * @license     GPLv3
 */
include LONG_TOOLKIT_DIR . 'sample/post-meta.php';
include LONG_TOOLKIT_DIR . 'sample/taxonomy.php';
include LONG_TOOLKIT_DIR . 'sample/widget.php';
include LONG_TOOLKIT_DIR . 'sample/customizer.php';
include LONG_TOOLKIT_DIR . 'sample/menu.php';

function long_toolkit_example_gmap_key( $key ) {
	return 'AIzaSyBS5224HISbnpAiKW7mx6eyTrHxfGeCftk';
	//'AIzaSyDbHSt4ney__Avh8FBFmU7j3BJ7TEjsyR4';
}

add_filter( 'long_toolkit_gmap_key', 'long_toolkit_example_gmap_key' );
