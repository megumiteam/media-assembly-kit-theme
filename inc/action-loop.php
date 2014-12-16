<?php
/**
 * Name: Media Assembly Kit Action Loop
 * Description: Action Loop
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_add_post_count($post_object) {
	if ( !is_admin() && ( is_home() || is_front_page() || is_archive() || is_search() ) ) {
		foreach ( $post_object->posts as $key => $value ) {
			$post_object->posts[$key]->count = $key + 1;
		}
	}
	return $post_object;
}
add_action( 'loop_start', 'mak_add_post_count' );

function mak_add_halfway_ad() {
	if ( ! function_exists( 'mad_code' ) )
		return;

	if ( is_child_theme() ) {
		if ( is_archive() || is_search() ) {
			$post           = get_post();
			$halfway_number = get_option( 'ad_mobile_posts_number', 7 ) + 1;
			if ( $halfway_number === $post->count ) {
				mak_halfway_ad();
			}
		}
	} else {
		if ( is_archive() || is_search() ) {
			$post           = get_post();
			$halfway_number = get_option( 'ad_posts_number', 10 ) + 1;
			if ( $halfway_number === $post->count ) {
				echo '<div class="mad-halfway-box">' . "\n";
				mad_code( array( 'code' => 'mad_pc_archive_halfway_left', 'class' => 'mad mad-halfway-left' ) );
				mad_code( array( 'code' => 'mad_pc_archive_halfway_right', 'class' => 'mad mad-halfway-right' ) );
				echo '</div>' . "\n";
			}
		}
	}
}
add_action( 'get_template_part_content', 'mak_add_halfway_ad' );
