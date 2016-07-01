<?php

/**
 * CUSTOM FUNCTIONS
 */

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