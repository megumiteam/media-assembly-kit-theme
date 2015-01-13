<?php
/**
 * Name: Media Assembly Kit Management Post Type
 * Description: Management Post Type
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_custom_post_type_set() {

	$contact_capabilities = array(
		'read_post'              => 'edit_users',
		'edit_post'              => 'edit_users',
		'delete_post'            => 'edit_users',
		'edit_posts'             => 'edit_users',
		'edit_others_posts'      => 'edit_users',
		'publish_posts'          => 'edit_users',
		'read_private_posts'     => 'edit_users',
		'delete_posts'           => 'edit_users',
		'delete_private_posts'   => 'edit_users',
		'delete_published_posts' => 'edit_users',
		'delete_others_posts'    => 'edit_users',
		'edit_private_posts'     => 'edit_users',
		'edit_published_posts'   => 'edit_users',
	);

	// Slide
	$label_name = __( 'Slide', 'mak' );
	$slug       = 'slide';
	$args       = array(
		'public'          => false,
		'show_ui'         => true,
		'hierarchical'    => true,
		'capability_type' => 'post',
		'capabilities'    => $contact_capabilities,
		'supports'        => array( 'title', 'custom-fields' ),
		'roles'           => array( 'administrator' ),
		'menu_icon'       => 'dashicons-images-alt2',
	);
	mak_custom_post_type( $label_name, $slug, $args );

	// Pickup
	$label_name = __( 'Pickups', 'mak' );
	$slug       = 'pickup';
	$args       = array(
		'public'          => false,
		'show_ui'         => true,
		'hierarchical'    => true,
		'capability_type' => 'post',
		'capabilities'    => $contact_capabilities,
		'supports'        => array( 'title' ),
		'roles'           => array( 'administrator' ),
		'menu_icon'       => 'dashicons-pressthis',
	);
	mak_custom_post_type( $label_name, $slug, $args );

}
add_action( 'init', 'mak_custom_post_type_set' );
