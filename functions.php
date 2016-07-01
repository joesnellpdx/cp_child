<?php
add_action( 'wp_enqueue_scripts', 'freesia_empire_enqueue_styles' );
function freesia_empire_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
?>