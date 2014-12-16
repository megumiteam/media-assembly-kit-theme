<?php
/**
 * Name: Media Assembly Kit Admin Parts
 * Description: Admin Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_text_field( $args ) {
	global $tag;
	extract( $args );
	$id      = ! empty( $id ) ? $id : $name;
	$class   = ! empty( $class ) ? $class : 'small-text';
	$default = ! empty( $default ) ? $default : '';
	if ( ! empty( $tag ) && 'cat_color' == $name ) {
		$value   = get_option( 'cat_' . $tag->term_id . '_color', $default );
	} else {
		$value   = get_option( $name, $default );
	}
	$value   = ! empty( $value ) ? $value : $default;
	$desc    = ! empty( $desc ) ? $desc : '';
	$output  = '<input type="text" name="' . $name .'" id="' . $id .'" class="' . $class . '" value="' . $value .'" />' . "\n";
	if ( $desc )
		$output .= '<p class="description">' . $desc . '</p>' . "\n";

	echo $output;
}

function mak_textarea_field( $args ) {
	extract( $args );
	$default = ! empty( $default ) ? $default : '';
	$value   = get_option( $name, $default );
	$value   = ! empty( $value ) ? $value : $default;
	$desc    = ! empty( $desc ) ? $desc : '';
	$output  = '<textarea name="' . $name .'" rows="10" cols="50" id="' . $name .'" class="large-text code">' . $value . '</textarea>' . "\n";
	if ( $desc )
		$output .= '<p class="description">' . $desc . '</p>' . "\n";
	echo $output;
}

function mak_check_field( $args ) {
	extract( $args );
	$default = ! empty( $default ) ? $default : '';
	$value   = get_option( $name, $default );
	$value   = ! empty( $value ) ? $value : $default;
	$desc    = ! empty( $desc ) ? $desc : '';
	$output  = '<label for="' . $name . '">' . "\n";
	$output  .= '<input name="' . $name . '" type="checkbox" id="' . $name . '" value="1"' . checked( $value, 1, false ) . '>' . "\n";
	if ( $desc )
		$output .= $desc . "\n";
	$output  .= '</label>' . "\n";

	echo $output;
}

function mak_select_field( $args ) {
	global $tag;
	extract( $args );

	$id             = ! empty( $id ) ? $id : $name;
	$desc           = ! empty( $desc ) ? $desc : '';
	if ( ! empty( $tag ) && 'wpsynd_id' == $name ) {
		$value = get_option( 'wpsynd_' . $tag->term_id );
	} else {
		$value = get_option( $name );
		$value = ! empty( $value ) ? $value : '';
	}
	$multi          = ! empty( $multi ) ? ' multiple' : '';
	$multi_selected = ! empty( $multi ) ? true : false;
	if ( $multi )
		$name = $name . '[]';

	$output = '<select name="' . $name . '" id="' . $id . '"' . $multi . '>' . "\n";
		foreach ( $option as $key => $val ) {
			$output .= '<option value="' . $key . '"' . mak_selected( $value, $key, $multi_selected ) . '>' . $val . '</option>' . "\n";
		}
	$output .= '</select>' . "\n";
		if ( $desc )
		$output .= $desc . "\n";

	echo $output;
}

function mak_image_field( $args ) {
	global $tag;
	extract( $args );
	$id      = ! empty( $id ) ? $id : $name;
	$class   = ! empty( $class ) ? $class : 'add-button';
	$default = ! empty( $default ) ? $default : '';
	if ( ! empty( $tag ) && 'media_logo' == $name ) {
		$value   = get_option( 'media_' . $tag->term_id . '_logo', $default );
	} else {
		$value   = get_option( $name, $default );
	}
	$value   = ! empty( $value ) ? $value : $default;
	$thumb   = ! empty( $value ) ? mak_get_entry_thumbnail( array( 'attachment_id' => $value, 'size' => 'thumbnail', 'html' => false ) ) : '';
	$desc    = ! empty( $desc ) ? $desc : '';
	$output  = '<input type="hidden" id="' . $id . '" name="' . $name . '" value="' . $value . '">' . "\n";
	$output  .= '<button type="button" id="' . $id . '-add" class="' . $class . '" data-target="' . $id . '">' . __( 'Images' ) . '</button>' . "\n";
	$output  .= '<button type="button" id="' . $id . '-delete" class="delete-button" data-target="' . $id . '" style="display:none;">' . __( 'Delete' ) . '</button>' . "\n";
	if ( $thumb )
		$output .= '<div id="' . $id . '-image-view">' . $thumb . '</div>' . "\n";
	if ( $desc )
		$output .= '<p class="description">' . $desc . '</p>' . "\n";
	echo $output;
}

function mak_selected( $value = '', $val = '', $multi = false ) {
	$select = '';

	if ( !$value )
		return false;

	if ( $multi ) {
		$select = selected( true, in_array( $val, $value ), false );
	} else {
		$select = selected( $value, $val, false );
	}
	return $select;
}