<?php
/**
 * Name: Media Assembly Kit Related Posts Parts
 * Description: Related Posts Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_related_posts( $args = '' ) {
	if ( !class_exists('Simple_Related_Posts') )
		return;
	if ( is_child_theme() ) {
		$num  = get_option( 'mobile_related_posts_per_page', 3 );
	} else {
		$num  = get_option( 'related_posts_per_page', 8 );
	}
	$default = array(
		'display_num' => $num,
	);
	$default = apply_filters( 'mak_get_related_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);
	$posts   = sirp_get_related_posts_id( $display_num );
	return $posts;
}

function mak_related_post_list( $args = array() ) {
	echo mak_get_related_post_list( $args );
}
function mak_get_related_post_list( $args = array() ) {
	if ( !class_exists( 'Simple_Related_Posts' ) )
		return;

	$output  = '';
	$id      = '';
	$default = array(
		'device'        => 'pc',
		'before_widget' => '<aside id="related-post" class="widget widget-related-post">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="parts-title widget-title"><span>',
		'after_title'   => '</span></h1>',
		'title'         => __( 'Related posts', 'mak' ),
	);
	$default = apply_filters( 'mak_related_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	if ( is_child_theme() || $device == "mobile" ) {
		$num  = get_option( 'mobile_related_posts_per_page', 3 );
	} else {
		$num  = get_option( 'related_posts_per_page', 8 );
	}
	$ids = mak_get_related_posts( array( 'display_num' => $num ) );
	if ( empty( $ids ) )
		return;

	$title = apply_filters( 'related_post_title', $title );
	if ( is_child_theme() || $device == "mobile" ) {
		$size   = 'mobile-thumbnail';
		$width  = 190;
		$height = 200;
		$lines  = 3;
	} else {
		$size   = 'square-90-image';
		$width  = 90;
		$height = 60;
		$lines  = 2;
	}

	$output .= $before_widget;
	$output .= $before_title . $title . $after_title . "\n";
	$output .= '<ul class="post-list">' . "\n";
	foreach ( $ids as $id ) {
		$post_id = $id['ID'];
		$title   = apply_filters( 'the_title', get_the_title( $post_id ) );
		//$link    = esc_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) );
		$link    = esc_url( home_url( '/post/#!/' .  $post_id ) );
		$args    = array(
			'id'      => $post_id,
			'size'    => $size,
			'width'   => $width,
			'height'  => $height,
			'src'     => 'http://placehold.it/' . $width . 'x' . $height,
			'noimage' => true,
			'link'    => false
		);
		$image   = mak_get_entry_thumbnail( $args );
		$class   = $image ? ' class="post hentry thumbnail-true"' : ' class="post hentry"';
		$output .= '<li' . $class . '><a href="' . $link . '">'
		. $image . "\n"
		. '<h2 class="title trunk8 entry-title" data-lines="' . $lines . '">' . "\n"
		. $title . "\n"
		. '</h2>' . "\n"
		. '</a></li>' . "\n";
	}
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}

