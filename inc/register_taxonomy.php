<?php
/**
 * Name: Media Assembly Kit Themes Register Taxonomies
 * Description: Register Taxonomies
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
 *
 **/
function mak_custom_taxonomies( $label_name = '', $slug = '', $type = '', $args = array() ) {

	$labels = array(
		'name'                       => sprintf( _x('%s', 'taxonomy general name', 'mak' ), $label_name ),
		'singular_name'              => sprintf( _x('%s', 'taxonomy singular name', 'mak'), $label_name ),
		'search_items'               => sprintf( __('Search %s', 'mak'), $label_name ),
		'popular_items'              => sprintf( __('Popular %s', 'mak'), $label_name ),
		'all_items'                  => sprintf( __('All %s', 'mak'), $label_name ),
		'parent_item'                => sprintf( __('Parent %s', 'mak'), $label_name ),
		'parent_item_colon'          => sprintf( __('Parent %s:', 'mak'), $label_name ),
		'edit_item'                  => sprintf( __('Edit %s', 'mak'), $label_name ),
		'view_item'                  => sprintf( __('View %s', 'mak'), $label_name ),
		'update_item'                => sprintf( __('Update %s', 'mak'), $label_name ),
		'add_new_item'               => sprintf( __('Add New %s', 'mak'), $label_name ),
		'new_item_name'              => sprintf( __('New %s Name', 'mak'), $label_name ),
		'separate_items_with_commas' => sprintf( __('Separate %s with commas', 'mak'), $label_name ),
		'add_or_remove_items'        => sprintf( __('Add or remove %s', 'mak'), $label_name ),
		'choose_from_most_used'      => sprintf( __('Choose from the most used %s', 'mak'), $label_name ),
		'not_found'                  => sprintf( __('No %s found.', 'mak'), $label_name ),
	);

	$defaults = array(
		'labels'       => $labels,
		'hierarchical' => true,
	);
	$r = wp_parse_args( $args, $defaults );
	register_taxonomy( $slug, $type, $r );
}

