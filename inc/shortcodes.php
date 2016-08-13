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

/**
 * Get started button shortcode
 * [get_started]
 */
function get_started_shortcode($atts, $content){
	$a = shortcode_atts( array(
		'link' => '',
	), $atts );

	if(empty($a['link'])){
		$contact_url = network_site_url() . 'contact/';
	} else {
		$contact_url = $a['link'];
	}

	$html = '';

	$html .= '<p class="btn-contain"><a title="Get Started Now" href="' . $contact_url . '" class="btn-default btn-contact vivid">Get Started Now<span>❭</span></a></p>';

	return $html;
}
add_shortcode( 'get_started', 'get_started_shortcode' );

/**
 * Blockquote shortcode
 *
 * [quote]
 */
function quote_shortcode($atts, $content){

	$html = '';

	$newer_content = pulsair_remove_empty_p($content);
	$newest_content = preg_replace('#^<\/p>|<p>$#', '', $newer_content);

	$html .= '<blockquote class="puls-quote">' . do_shortcode($newest_content) . '</blockquote>';

	return $html;
}
add_shortcode( 'quote', 'quote_shortcode' );

/**
 * Cite shortcode
 *
 * [cite]
 */
function cite_shortcode($atts, $content){


	$html = '';

	$newest_content = pulsair_remove_empty_p($content);

	$html .= '<cite>— ' . do_shortcode($newest_content) . '</cite>';

	return $html;
}
add_shortcode( 'cite', 'cite_shortcode' );

/**
 * Grid left
 *
 * [grid_left]
 */
function grid_left_shortcode($atts, $content){

	$html = '';

	$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	$new_content =  preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);

	$newest_content = pulsair_remove_empty_p($new_content);

	$html .= '<div class="grid-left">' . do_shortcode($newest_content) . '</div>';

	return $html;
}
add_shortcode( 'grid_left', 'grid_left_shortcode' );

/**
 * Grid right
 *
 * [grid_right]
 */
function grid_right_shortcode($atts, $content){

	$html = '';

	$newest_content = pulsair_remove_empty_p($content);

	$html .= '<div class="grid-right">' . do_shortcode($newest_content) . '</div>';

	return $html;
}
add_shortcode( 'grid_right', 'grid_right_shortcode' );

$tabs_divs = '';

function tabs_group($atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));

	global $tabs_divs;

	$tabs_divs = '';

	$output = '<div id="" class="puls-tabs">';
	$output .= '<div class="puls-tabs__inner">';
	$output.= '<span class="puls-tabs__title">' . $title . '</span>';
	$output.= '<ul class="puls-tabs__ul">'.do_shortcode($content).'</ul>';
	$output .= '<div class="puls-tabs__items">'.$tabs_divs.'</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}


function tab($atts, $content = null) {
	global $tabs_divs;

	extract(shortcode_atts(array(
		'id' => '',
		'title' => '',
		'icon' => ''
	), $atts));

	if(empty($id))
		$id = 'side-tab'.rand(100,999);

	$output = '
		        <li class="puls-tabs__tab">
		            <a href="#'.$id.'" class="puls-tabs__tab-link">'.$title.'</a>
		        </li>
		    ';

	$tabs_divs .= '<div id="'.$id.'" class="puls-tab-item">';
	$tabs_divs .= '<div class="puls-tab-item__inner">';
	$tabs_divs .= '<div class="puls-tab-item__title-contain">';
	$tabs_divs .= '<h2 class="puls-tab-item__title">' . $title . '</h2>';
	$tabs_divs .= '</div>';
	$tabs_divs .= '<div class="puls-tab-item__content-contain">';
	$tabs_divs .= do_shortcode($content);
	//	$tabs_divs .= '<a href="#tab-side-container" class="puls-tab-item__close btn-primary btn-small" data-tab-id="' . $id . '">X Close</a>';
	$tabs_divs .= '</div>';

	$tabs_divs .= '</div>';
	$tabs_divs .= '</div>';

	return $output;
}

add_shortcode('tabs', 'tabs_group');
add_shortcode('tab', 'tab');