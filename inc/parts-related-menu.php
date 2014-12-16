<?php
/**
 * Name: Media Assembly Kit Related Menu Parts
 * Description: Related Menu Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_related_menu_query( $args = array() ) {
	$posts = array();
	$default = array(
		'posts_per_page' => -1,
		'post_type'      => 'related-menu',
	);
	$default = apply_filters( 'mak_related_menu_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_related_menu( $args = array() ) {
	echo mak_get_related_menu( $args );
}
function mak_get_related_menu( $args = array() ) {
	$output  = '';
	$default = array(
		'before_widget' => '<nav id="related-menu">',
		'after_widget'  => '</nav>',
		'limit'         => -1,
	);
	$default = apply_filters( 'mak_pickup_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_related_menu_query( $args );
	if ( empty( $posts ) )
		return;

	$output .= $before_widget;
	$output .= '<ul>' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id       = $post->ID;
		$title         = esc_html( ( apply_filters( 'the_title', get_the_title( $post_id ) ) ) );
		$link          = esc_url( apply_filters( 'the_permalink', get_post_meta( $post_id, 'site_url', true ) ) );
		$target        = get_post_meta( $post_id, 'site_target', true ) ? ' target="_blank"' : '';
		$attachment_id = get_post_thumbnail_id( $post_id );
		$args          = array(
			'attachment_id' => $attachment_id,
			'size'          => 'full',
			'link'          => false,
			'optional'      => array(
				'title' => $title,
				'alt'   => $title,
			),
		);
		$image = mak_get_entry_thumbnail( $args );
		$output .= '<li><a href="' . $link . '"' . $target . '>'
		. $image . "\n"
		. '</a></li>' . "\n";
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}
