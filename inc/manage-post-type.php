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

	// Carousel Panel
	$label_name = __( 'Carousel Panel', 'mak' );
	$slug       = 'carousel-panel';
	$args       = array(
		'public'          => false,
		'show_ui'         => true,
		'hierarchical'    => true,
		'capability_type' => 'post',
		'capabilities'    => $contact_capabilities,
		'supports'        => array( 'title' ),
		'roles'           => array( 'administrator' ),
		'menu_icon'       => 'dashicons-slides',
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

	// Induction frame
	$label_name = __( 'Induction frame', 'mak' );
	$slug       = 'induction';
	$args       = array(
		'public'          => false,
		'show_ui'         => true,
		'hierarchical'    => true,
		'capability_type' => 'post',
		'capabilities'    => $contact_capabilities,
		'supports'        => array( 'title', 'page-attributes' ),
		'roles'           => array( 'administrator' ),
		'menu_icon'       => 'dashicons-feedback',
	);
	mak_custom_post_type( $label_name, $slug, $args );

	$categories = mak_options_categories( array(), array( 'child' => false ) );
	foreach ( $categories as $category ) {
		$args     = array();
		$term_id  = $category['term_id'];
		$name     = $category['name'];
		$cat_slug = $category['slug'];
		$view     = get_option( 'cat_' . $term_id . '_view_induction', true );
		if ( ! empty( $view ) ) {

			// Category Induction frame
			$label_name = sprintf( __( '%s Induction', 'mak' ), $name );
			$slug       = 'cat-' . $term_id . '-induction';
			$args       = array(
				'public'          => false,
				'show_ui'         => true,
				'hierarchical'    => true,
				'capability_type' => 'post',
				'capabilities'    => $contact_capabilities,
				'supports'        => array( 'title' ),
				'roles'           => array( 'administrator' ),
			);
			mak_custom_post_type( $label_name, $slug, $args );
		}
	}

	// Media
	$label_name = __( 'Media', 'mak' );
	$slug       = 'media';
	$type       = 'post';
	$args       = array(
		'hierarchical' => true,
		'rewrite'      => array( 'hierarchical' => true, 'with_front' => false ),
	);
	mak_custom_taxonomies( $label_name, $slug, $type, $args );

	// Pickup
	$label_name = __( 'Related Menu', 'mak' );
	$slug       = 'related-menu';
	$args       = array(
		'public'            => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'hierarchical'      => true,
		'capability_type'   => 'post',
		'capabilities'      => $contact_capabilities,
		'supports'          => array( 'title', 'thumbnail' ),
		'roles'             => array( 'administrator' ),
		'menu_icon'       => 'dashicons-admin-links',
	);
	mak_custom_post_type( $label_name, $slug, $args );

}
add_action( 'init', 'mak_custom_post_type_set' );
