<?php
/**
 * Name: Media Assembly Kit Function
 * Description: Feed Function
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_feed_query_var( $vars ){
	array_push( $vars, 'type' );
	array_push( $vars, 'feed' );
	return $vars;
}
add_filter( 'query_vars', 'mak_feed_query_var' );

function mak_feed_rewrite() {
	global $wp_rewrite;

	$wp_rewrite->add_rewrite_tag( '%type%', '(.+?)', 'type=' );
}
add_action( 'init', 'mak_feed_rewrite' );

function mak_include_media_taxonomy_feed( $query ) {
	if ( !is_admin() && is_feed() && ( get_query_var( 'type' ) && get_query_var( 'type' ) != 'summary' || get_query_var( 'feed' )) ) {
		$args = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'media',
				'field'    => 'slug',
				'terms'    => 'appwoman',
			),
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => array( 'pr' ),
				'operator' => 'NOT IN',
			),
		);
		$query->set( 'tax_query', $args );
	}
	return $query;
}
add_action( 'pre_get_posts', 'mak_include_media_taxonomy_feed' );
