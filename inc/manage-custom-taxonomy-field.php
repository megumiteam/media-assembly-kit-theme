<?php
/**
 * Name: Media Assembly Kit Management Custom Taxonomy Field
 * Description: Management Custom Taxonomy Field
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_admin_taxonomy_scripts() {
	wp_enqueue_style( 'wp-color-picker' );

	wp_enqueue_media();
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), mak_file_time_stamp( '/js/admin.js' ), true );
}
add_action( 'admin_print_scripts-edit-tags.php', 'mak_admin_taxonomy_scripts', 999 );

function mak_add_taxonomy_form( $taxonomy ) {
	do_settings_sections( 'mak_' . $taxonomy . '_fields' );
}
add_action( 'category_add_form_fields', 'mak_add_taxonomy_form' );
add_action( 'media_add_form_fields', 'mak_add_taxonomy_form' );
function mak_edit_taxonomy_form( $taxonomy ) {
	do_settings_sections( 'mak_' . $taxonomy->taxonomy . '_fields' );
}
add_action( 'category_edit_form', 'mak_edit_taxonomy_form' );
add_action( 'media_edit_form', 'mak_edit_taxonomy_form' );


function mak_add_category_fields() {

	add_settings_section(
		'options',
		__( 'Options', 'mak' ),
		'',
		'mak_category_fields'
	);
	add_settings_field(
		'mak_cat_color',
		__( 'Category Color', 'mak' ),
		'mak_text_field',
		'mak_category_fields',
		'options',
		array(
			'id'    => 'cat-colors',
			'class' => 'small-text color-picker',
			'name'  => 'cat_color',
			'value' => '',
		)
	);

}
add_action( 'admin_init', 'mak_add_category_fields' );

function mak_add_media_fields() {
	$categories    = mak_options_categories( array(), array( 'child' => false ) );
	$categories_op = array();
	foreach ( $categories as $value ) {
		$categories_op[$value['term_id']] = $value['name'];
	}

	add_settings_section(
		'options',
		__( 'Options', 'mak' ),
		'',
		'mak_media_fields'
	);
	add_settings_field(
		'media_logo',
		__( 'Media Logo', 'mak' ),
		'mak_image_field',
		'mak_media_fields',
		'options',
		array(
			'id'   => 'media-logo',
			'name' => 'media_logo',
		)
	);
	add_settings_field(
		'wpsynd_id',
		__( 'Initial category', 'mak' ),
		'mak_select_field',
		'mak_media_fields',
		'options',
		array(
			'id'     => 'wpsynd-id',
			'name'   => 'wpsynd_id',
			'option' => $categories_op,
		)
	);

}
add_action( 'admin_init', 'mak_add_media_fields' );

function mak_save_taxonomy_fields( $term_id ) {
	if ( isset( $_POST['cat_color'] ) ) {
		$value = esc_attr( $_POST['cat_color'] );
		update_option( 'cat_' . $term_id . '_color', $value );
	}
	if ( isset( $_POST['media_logo'] ) ) {
		$value = esc_attr( $_POST['media_logo'] );
		update_option( 'media_' . $term_id . '_logo', $value );
	}
	if ( isset( $_POST['wpsynd_id'] ) ) {
		$value = esc_attr( $_POST['wpsynd_id'] );
		update_option( 'wpsynd_' . $term_id, $value );
	}
}
add_action( 'edited_category', 'mak_save_taxonomy_fields' );
add_action( 'create_category', 'mak_save_taxonomy_fields' );
add_action( 'edited_media', 'mak_save_taxonomy_fields' );
add_action( 'create_media', 'mak_save_taxonomy_fields' );
