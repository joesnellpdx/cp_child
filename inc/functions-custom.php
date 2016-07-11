<?php

/**
 * CUSTOM FUNCTIONS
 */

/**
 * Hide page stuff
 */
function hide_page_stuff() {
	remove_post_type_support( 'page', 'comments' );
}
add_action('init', 'hide_page_stuff');

/**
 * Add custom iage sizes
 */
function twenty_eleven_child_add_image_size() {
	add_image_size( 'rwd-small', 400, 240 );
	add_image_size( 'rwd-medium', 800, 480 );
	add_image_size( 'rwd-large', 1200, 720 );
	add_image_size( 'rwd-mediumx2', 1600, 960 );
	add_image_size( 'rwd-xl', 2000, 1200 );
	add_image_size( 'rwd-largex2', 2400, 1440 );
	add_image_size( 'rwd-xlx2', 4000, 2400 );
}
add_action( 'after_setup_theme', 'twenty_eleven_child_add_image_size', 11 );

/**
 * GET IMAGE ID FROM SRC
 */
function get_attachment_id_from_src($url) {
	global $wpdb;
	$prefix = $wpdb->prefix;

	if (strpos($url, 'http') === 0) {
		$img_source = $url;
	} else {
		$img_source = site_url() . $url;
	}

	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $img_source ));
	return $attachment[0];
}

//function register_multiple_menus() {
//
//	register_nav_menus( array(
//		'sites' => 'Sites Menu',
//	) );
//}
//add_action( 'init', 'register_multiple_menus' );

/**
 * Add custom li class to site navigation

 *
 * @return custom class
 */
function site_menu_li_classes( $classes , $item, $args, $depth ) {
	if( $args->theme_location === 'sites' ) {
		$classes[] = 'navigation__item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'site_menu_li_classes', 10, 4 );

/**
 * Add custom link class to navigation

 *
 * @return custom class
 */
function site_menu_link_classes( $atts, $item, $args ) {
	if( $args->theme_location === 'sites' ) {
		$atts['class'] = 'navigation__link';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'site_menu_link_classes', 10, 3 );