<?php

/**
 * CMB2 Functions
 */

/**
 * Pulsair Corporate Template
 */
function jspdx_register_pacorp_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$pa_prefix = '_pacorp_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'pacorp',
		'title' => __( 'Page Options', 'cmb2' ),
		'object_types' => array( 'page' ), // post type
		'show_on'      => array( 'key' => 'page-template', 'value' => 'page-templates/pulsair-corporate.php' ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$meta_boxes->add_field( array(
		'name'       => __( 'Title Display', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $pa_prefix . 'title',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats',
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Subtitle / Descriptive Content', 'cmb2' ),
		'id'      => $pa_prefix . 'subtitle',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 10, ),
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Display custom grid (from admin fields).', 'cmb2' ),
		'id'      => $pa_prefix . 'grid',
		'type'    => 'checkbox'
	) );


}
add_filter( 'cmb2_init', 'jspdx_register_pacorp_metabox' );



/**
 * Grid Items
 */
function jspdx_register_grid_item_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$gi_prefix = '_gitm_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'grid_item',
		'title' => __( 'Grid Item Options', 'cmb2' ),
		'object_types'  => array( 'pt_grid', ), // Post type
//		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'default', ''), ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));

	$meta_boxes->add_field( array(
		'name'    => 'Subtext',
		'desc'    => 'Appears on hover (not seen on all devices).',
		'id'      => $gi_prefix . 'subtitle',
		'type'    => 'text'
	) );

	$meta_boxes->add_field( array(
		'name'       => __( 'Link', 'cmb2' ),
//		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $gi_prefix . 'link',
		'type'       => 'text',
		'show_on_cb' => 'cmb2_hide_if_no_cats',
	) );

	$meta_boxes->add_field( array(
		'name'    => __( 'Background Image', 'cmb2' ),
		'id'      => $gi_prefix . 'bg',
		'type'    => 'file',
	) );


}
add_filter( 'cmb2_init', 'jspdx_register_grid_item_metabox' );

/**
 * Grid Items
 */
function jspdx_register_client_item_metabox( ) {

	// Start with an underscore to hide fields from custom fields list
	$gi_prefix = '_cltm_';

	$meta_boxes = new_cmb2_box( array(
		'id' => 'client_item',
		'title' => __( 'Client Item Options', 'cmb2' ),
		'object_types'  => array( 'pt_client', ), // Post type
//		'show_on'      => array( 'key' => 'page-template', 'value' => array( 'default', ''), ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	));


	$meta_boxes->add_field( array(
		'name'    => __( 'Background Image', 'cmb2' ),
		'id'      => $gi_prefix . 'bg',
		'desc'    => 'Recommend 362px x 140px .png file.',
		'type'    => 'file',
	) );


}
add_filter( 'cmb2_init', 'jspdx_register_client_item_metabox' );

/**
 * Metabox for Page Template
 * @author Kenneth White
 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $meta_box
 * @return bool display metabox
 */
//function be_metabox_show_on_template( $display, $meta_box ) {
//	if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
//		return $display;
//	}
//
//	if ( 'template' !== $meta_box['show_on']['key'] ) {
//		return $display;
//	}
//
//	$post_id = 0;
//
//	// If we're showing it based on ID, get the current ID
//	if ( isset( $_GET['post'] ) ) {
//		$post_id = $_GET['post'];
//	} elseif ( isset( $_POST['post_ID'] ) ) {
//		$post_id = $_POST['post_ID'];
//	}
//
//	if ( ! $post_id ) {
//		return false;
//	}
//
//	$template_name = get_page_template_slug( $post_id );
//	$template_name = ! empty( $template_name ) ? substr( $template_name, 0, -4 ) : '';
//
//	// See if there's a match
//	return in_array( $template_name, (array) $meta_box['show_on']['value'] );
//}
//add_filter( 'cmb2_show_on', 'be_metabox_show_on_template', 10, 2 );