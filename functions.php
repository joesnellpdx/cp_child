<?php
add_action( 'wp_enqueue_scripts', 'freesia_empire_enqueue_styles' );
function freesia_empire_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory()  . '/assets/css/sass/pulsair.min.scss');
}

/**
 * CUSTOM FILES
 */

require get_stylesheet_directory()  . '/inc/functions-custom.php';
require get_stylesheet_directory()  . '/inc/shortcodes.php';


?>