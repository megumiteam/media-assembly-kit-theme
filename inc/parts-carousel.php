<?php
/**
 * Name: Media Assembly Kit Carousel Parts
 * Description: Carousel Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_carousel_posts( $args = array() ) {
	$posts   = array();
	$limit   = get_option( 'carousel_posts_per_page', 5 );
	$default = array(
		'posts_per_page' => $limit,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_type'      => 'carousel-panel',
	);
	$default = apply_filters( 'mak_carousel_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_carousel_post_list( $args = array() ) {
	echo mak_get_carousel_post_list( $args );
}
function mak_get_carousel_post_list( $args = array() ) {
	//if ( ( !is_home() || !is_front_page() ) || is_paged() || !( defined( 'JSON_REQUEST' ) && JSON_REQUEST ) )
	if ( ( !is_home() || !is_front_page() ) || is_paged() )
		return;

	$output  = '';
	$default = array(
		'before_widget' => '<aside id="carousel-box">',
		'after_widget'  => '</aside>',
		'limit'         => get_option( 'carousel_posts_per_page', 5 ),
		'speed'         => get_option( 'carousel_speed', 1500 ),
		'pause'         => get_option( 'carousel_pause', 6000 ),
	);
	$default = apply_filters( 'mak_carousel_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_carousel_posts( $args );
	if ( empty( $posts ) )
		return;

	$size   = 'square-100-image';
	$width  = 100;
	$height = 70;
	$output .= $before_widget;
	$output .= '<ul id="carousel" data-speed="' . $speed . '" data-pause="' . $pause . '">' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$select_post_id = get_field( 'select_post', $post_id );
		$select_post_id = reset( $select_post_id );
		if ( 'publish' === get_post_status( $post_id ) ) {
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
			. '<h2 class="title trunk8" data-lines="3">' . "\n"
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
