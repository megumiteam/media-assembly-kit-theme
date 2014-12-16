<?php
/**
 * Name: Media Assembly Kit Save Post Filter
 * Description: Save Post Filter
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
 *
 **/
function mak_acf_save_post( $post_id ) {
	$fields = false;
	if( isset( $_POST['fields'] ) ) {
		$fields   = $_POST['fields'];
		if ( $fields ) {
			$select_post  = get_field( 'select_post', $post_id );
			$select_post  = reset( $select_post );
			if ( get_the_title( $post_id ) ) {
				$title = get_the_title( $post_id );
			} else {
				$title = get_the_title( $select_post );
			}
			wp_update_post( array( 'ID' => $post_id, 'post_title' => $title) );
		}
	}
}
add_action( 'acf/save_post', 'mak_acf_save_post', 20 );
