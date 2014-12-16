<?php
/**
 * Name: Media Assembly Kit Slide Parts
 * Description: Slide Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_slide_posts( $args = array() ) {
	$posts   = array();
	$limit   = get_option( 'slide_posts_per_page', 5 );
	$default = array(
		'posts_per_page' => $limit,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_type'      => 'slide',
	);
	$default = apply_filters( 'mak_slide_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_slide_post_list( $args = array() ) {
	echo mak_get_slide_post_list( $args );
}
function mak_get_slide_post_list( $args = array() ) {
	if ( ( !is_home() || !is_front_page() ) || is_paged() || !( defined( 'JSON_REQUEST' ) && JSON_REQUEST ) )
		return;

	$output  = '';
	$default = array(
		'device'        => 'pc',
		'before_widget' => '',
		'after_widget'  => '',
		'limit'         => get_option( 'slide_posts_per_page', 5 ),
		'speed'         => get_option( 'slide_speed', 1500 ),
		'pause'         => get_option( 'slide_pause', 6000 ),
	);
	$default = apply_filters( 'mak_slide_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_slide_posts( $args );
	if ( empty( $posts ) )
		return;

	$size   = 'slide-main-image';
	$width  = 700;
	$height = 350;

	$output .= $before_widget;
	$output .= '<ul id="slide" data-speed="' . $speed . '" data-pause="' . $pause . '">' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$select_post_id = get_field( 'select_post', $post_id );
		$select_post_id = reset( $select_post_id );
		$title          = apply_filters( 'the_title', get_the_title( $post_id ) );
		$link           = esc_url( apply_filters( 'the_permalink', get_permalink( $select_post_id ) ) );
		if ( ! is_child_theme() ) {
			$date           = mak_get_entry_data( array( 'post_id' => $select_post_id ) );
			if( has_excerpt( $select_post_id ) ) {
				$pickup  = get_post( $select_post_id );
				$content = $pickup->post_excerpt;
				$content = wp_trim_words( $content, 120, '&hellip;' );
			} else {
				$pickup  = get_post( $select_post_id );
				$content = $pickup->post_content;
				$content = wp_trim_words( $content, 120 );
			}
			$content = apply_filters( 'get_the_excerpt', $content );
			$content = apply_filters( 'the_excerpt', $content );
		}
		$attachment_id  = get_field( 'slide_image', $post_id ) ? get_field( 'slide_image', $post_id ) : get_post_thumbnail_id( $select_post_id );
		$args = array(
			'attachment_id' => $attachment_id,
			'size'          => $size,
			'width'         => $width,
			'height'        => $height,
			'src'           => 'http://placehold.it/' . $width . 'x' . $height,
			'html'          => false,
		);
		$image   = mak_get_entry_thumbnail( $args );
		if ( is_child_theme() || $device == 'mobile' ) {
			$output .= '<li><a href="' . $link . '">'
			. '<h2 class="title"><span class="trunk8" data-lines="1">' . $title . '</span></h2>' . "\n"
			. '<p class="thumbnail">' . $image . '</p>' . "\n"
			. '</a></li>' . "\n";
		} else {
			$output .= '<li>'
			. '<div class="slide-content">' . "\n"
			. $date . "\n"
			. '<h2 class="title"><a href="' . $link . '" class="trunk8" data-lines="3">' . $title . '</a></h2>' . "\n"
			. '<div class="trunk8" data-lines="4">' . "\n"
			. $content . "\n"
			. '</div>' . "\n"
			. '<p class="view-more"><a href="' . $link . '">' . __( '&#187; View more', 'mak' ) . '</a></p>' . "\n"
			. '</div>' . "\n"
			. '<p class="thumbnail"><a href="' . $link . '">' . $image . '</a></p>' . "\n"
			. '</li>' . "\n";
		}
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}
