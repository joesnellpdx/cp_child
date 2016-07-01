<?php

/**
 * SHORTCODES
 */


function section_block_shortcode($atts, $content){
	$a = shortcode_atts( array(
		'title' => '',
		'subtitle' => '',
	), $atts );

	$html = '';

	$html .= '<section class="our_feature">';
	$html .= '<div class="container clearfix">';
	$html .= '<div class="container_container">';
	if(!empty($a['title'])){
		$html .= '<h1 class="page-title--custom freesia-animation fadeInUp">' . esc_attr($a['title']) . '</h1>';
	}
	if(!empty($a['subtitle'])){
		$html .= '<p class="feature-sub-title freesia-animation fadeInUp">' . esc_attr($a['subtitle']) . '</p>';
	}
	$html .= do_shortcode($content);
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</section>';
	return $html;

}
add_shortcode( 'section_block', 'section_block_shortcode' );


function column_block_shortcode($atts, $content){
	$a = shortcode_atts( array(
		'title' => '',
		'subtitle' => '',
	), $atts );

	$html = '';

	$html .= '<div class="column clearfix">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}
add_shortcode( 'column_block', 'column_block_shortcode' );

/**
[cta_block link="http://wine.puslair.com" icon="wine-icon" title="Wine Products"]

View our amazing products for the wine industry.

[/cta_block]
 */
function cta_block_shortcode( $atts, $content ) {
	$a = shortcode_atts( array(
		'link' => '',
		'icon' => '',
		'image' => '',
		'title' => '',
	), $atts );

	$html = '';

	$html .= '<div class="three-column freesia-animation fadeInLeft" data-wow-delay="0.1s">';
	$html .= '<div class="feature-content">';
	if(!empty($a['image'])){
		$imgID = get_attachment_id_from_src($a['image']);
		$img_src      = wp_get_attachment_image_url( $imgID, 'rwd-small' );
		$img_fallback = wp_get_attachment_image_url( $imgID, 'full' );
		$srcset_value = wp_get_attachment_image_srcset( $imgID, 'large' );
		$srcset       = $srcset_value ? ' srcset="' . esc_attr( $srcset_value ) . '"' : '';
		$alt          = get_post_meta( $imgID, '_wp_attachment_image_alt', true );

		$html .= '<a class="feature-icon feature-image" href="' . esc_attr($a['link']) . '" title="' . esc_attr($a['title']) . '" >';
		$html .= '<img src="' . $img_src . '" ' . $srcset . ' sizes="(min-width: 767px) 50vw, (min-width: 1023px) 33.3vw, 100vw" alt="' . $alt . '" data-fallback-img="' . $img_fallback . '">';
		$html .= '</a>';
	}
	$html .= '<article>';
	$html .= '<h3 class="feature-title">';
	if(!empty($a['link'])){
		$html .= '<a href="' . esc_attr($a['link']) . '" title="' . esc_attr($a['title']) . '">' . esc_attr($a['title']) . '</a>';
	} else {
		$html .= esc_attr($a['title']);
	}
	$html .= '</h3>';
	$html .= wpautop(do_shortcode($content));
	$html .= '</article>';
	if(!empty($a['link'])){
		$html .= '<a title="' . esc_attr($a['title']) . '" href="' . esc_attr($a['link']) . '" class="more-link">Read More</a>';
	}
	$html .= '</div>';
	$html .= '</div>';

	return $html;
}
add_shortcode( 'cta_block', 'cta_block_shortcode' );