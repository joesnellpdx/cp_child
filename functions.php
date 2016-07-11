<?php

function freesia_empire_enqueue_styles() {
	$parent_style = 'parent-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/assets/css/pulsair.min.css',
		array( $parent_style )
	);

	wp_enqueue_script(
		'modernizr-custom',
		get_stylesheet_directory_uri() . '/assets/js/vendor/modernizr-custom.min.js',
		false, '2.7.2'
	);
}
add_action( 'wp_enqueue_scripts', 'freesia_empire_enqueue_styles' );


/**
 * CUSTOM FILES
 */

require get_stylesheet_directory()  . '/inc/functions-custom.php';
require get_stylesheet_directory()  . '/inc/cmb2/cmb2-functions.php';
require get_stylesheet_directory()  . '/inc/shortcodes.php';
require get_stylesheet_directory()  . '/inc/post-types/admin-grids.php';



?>