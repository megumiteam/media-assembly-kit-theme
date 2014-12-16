<?php
/**
 * Name: Media Assembly Kit Themes Register Post Type
 * Description: Register Post Type
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
 *
 **/
function mak_custom_post_type( $label_name, $slug, $args = array() ) {

	$labels = array(
		'name'               => sprintf( _x('%s', 'post type general name', 'mak'), $label_name ),
		'singular_name'      => sprintf( _x('%s', 'post type singular name', 'mak'), $label_name ),
		'add_new'            => sprintf( _x('Add New', '%s', 'mak'), $label_name ),
		'add_new_item'       => sprintf( __('Add New %s', 'mak'), $label_name ),
		'edit_item'          => sprintf( __('Edit %s', 'mak'), $label_name ),
		'new_item'           => sprintf( __('New %s', 'mak'), $label_name ),
		'view_item'          => sprintf( __('View %s', 'mak'), $label_name ),
		'search_items'       => sprintf( __('Search %s', 'mak'), $label_name ),
		'not_found'          => sprintf( __('No %s found.', 'mak'), $label_name ),
		'not_found_in_trash' => sprintf( __('No %s found in Trash.', 'mak'), $label_name ),
		'parent_item_colon'  => sprintf( __('Parent %s:', 'mak'), $label_name ),
		'all_items'          => sprintf( __( 'All %s', 'mak' ), $label_name ),
		'name_admin_bar'     => sprintf( _x( '%s', 'add new on admin bar', 'mak' ), $label_name ),
	);

	$defaults = array(
		'labels'   => $labels,
		'public'   => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'page-attributes', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
	);
	$r = wp_parse_args( $args, $defaults );
	extract($args);
	register_post_type( $slug, $r );
}
