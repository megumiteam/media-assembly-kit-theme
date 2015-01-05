<?php
/**
 * Name: Media Assembly Kit Filter hook
 * Description: Filter hook
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function mak_wp_title( $title, $sep ) {
	global $page, $paged;

	$sep = ' | ';

	if ( is_feed() )
		return $title;

	if ( is_tax() )
		$title = single_term_title( '', false ) . $sep;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'mak' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'mak_wp_title', 10, 2 );

function mak_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( $query->is_home() ) {
		$posts_per_page = get_option( 'home_posts_per_page', 10 );
		$query->set( 'posts_per_page', $posts_per_page );
		return;
	}

}
add_action( 'pre_get_posts', 'mak_pre_get_posts' );

//
function mak_excerpt_length( $length ) {
	if ( is_child_theme() ) {
		$length = 100;
	}
	return $length;
}
add_filter( 'excerpt_mblength', 'mak_excerpt_length');

function mak_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'mak_excerpt_more' );

function mak_remove_the_content_more_link( $link, $more_link_text ) {
	return;
}
add_filter( 'the_content_more_link', 'mak_remove_the_content_more_link', 10, 2 );

function mak_option_image_default_align() {
	return 'center';
}
add_filter( 'option_image_default_align', 'mak_option_image_default_align' );

function mak_option_image_default_link_type() {
	return 'none';
}
add_filter( 'option_image_default_link_type', 'mak_option_image_default_link_type' );

function mak_option_image_default_size() {
	return 'medium';
}
add_filter( 'option_image_default_size', 'mak_option_image_default_size' );

function mak_nav_menu_css_class( $classes, $item, $args ) {
	if ( $args->theme_location == 'global-menu' && is_single() ) {
		$cats = get_the_category();
		$cat  = reset($cats);
		$cid  = $cat->term_id;
		if ( $item->object_id == $cid && $item->object == 'category' ) {
			$classes[] = 'current-menu-item';
		}
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'mak_nav_menu_css_class', 10, 3 );
