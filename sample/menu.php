<?php

function long_toolkit_example_menu_meta($fields) {
	return long_toolkit_example_fields();
}

add_filter( 'long_toolkit_menu_fields', 'long_toolkit_example_menu_meta' );
