<?php
/**
 * Name: Media Assembly Kit Pickup Parts
 * Description: Pickup Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_pickup_posts( $args = array() ) {
	$posts = array();
	$limit = 3;
	$default = array(
		'posts_per_page' => $limit,
		'post_type'      => 'pickup',
	);
	$default = apply_filters( 'mak_pickup_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_pickup( $args = array(), $instance = array() ) {
	echo mak_get_pickup( $args, $instance );
}
function mak_get_pickup( $args = array(), $instance = array() ) {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$output  = '';
	$default = array(
		'before_widget' => '<aside id="pickup-post">',
		'after_widget'  => '</aside>',
		'limit'         => 3,
		'title'         => __( 'Pickup', 'mak' ),
		'ua'            => 'pc',
	);
	$default = apply_filters( 'mak_pickup_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_pickup_posts( $limit );
	if ( empty( $posts ) )
		return;

	if ( is_child_theme() || $ua == 'mobile' ) {
		$size   = 'mobile-thumbnail';
		$width  = 190;
		$height = 200;
		$lines  = 3;
	} else {
		$size   = 'square-193-image';
		$width  = 193;
		$height = 100;
		$lines  = 3;
	}
	$output .= $before_widget;
	$output .= '<h1 class="parts-title"><span>' . $title . '</span></h1>' . "\n";
	$output .= '<ul id="pickup">' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$select_post_id = get_field( 'select_post', $post_id );
		$select_post_id = reset( $select_post_id );
		if ( 'publish' === get_post_status( $select_post_id ) ) {
			$title          = apply_filters( 'the_title', get_the_title( $select_post_id ) );
			$link           = esc_url( apply_filters( 'the_permalink', get_permalink( $select_post_id ) ) );
			$attachment_id  = get_field( 'carousel_image', $post_id ) ? get_field( 'carousel_image', $post_id ) : get_post_thumbnail_id( $select_post_id );
			$args = array(
				'attachment_id' => $attachment_id,
				'size'          => $size,
				'width'         => $width,
				'height'        => $height,
				'src'           => 'http://placehold.it/' . $width . 'x' . $height,
				'link'          => false,
			);
			$image   = mak_get_entry_thumbnail( $args );
			$class   = ! empty( $image ) ? 'thumbnail-true' : 'thumbnail-false';
			$output .= '<li class="' . $class . '"><a href="' . $link . '">'
			. $image . "\n"
			. '<h2 class="title trunk8" data-lines="' . $lines . '">' . "\n"
			. $title . "\n"
			. '</h2>' . "\n"
			. '</a></li>' . "\n";
		}
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}

