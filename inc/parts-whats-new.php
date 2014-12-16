<?php
/**
 * Name: Media Assembly Kit What's New Parts
 * Description: What's New Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_whats_new_posts( $args = array() ) {
	$posts = array();
	$limit = 10;
	$default = array(
		'posts_per_page' => $limit,
	);
	$default = apply_filters( 'mak_whats_new_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_whats_new( $args = array() ) {
	echo mak_get_whats_new( $args );
}
function mak_get_whats_new( $args = array() ) {
	$output  = '';
	$default = array(
		'before_widget' => '<aside id="whats-new-box">',
		'after_widget'  => '</aside>',
		'limit'         => 10,
	);
	$default = apply_filters( 'mak_whats_new_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_whats_new_posts( $args );
	if ( empty( $posts ) )
		return;

	if ( is_child_theme() ) {
		$size     = 'mobile-thumbnail';
		$width    = 190;
		$height   = 200;
		$lines    = 3;
		$children = false;
	} else {
		$size     = 'post-thumbnail';
		$width    = 125;
		$height   = 140;
		$lines    = 2;
		$children = false;
	}
	$output .= $before_widget;
	$output .= '<h1 class="parts-title"><span>' . __( 'What\'s New', 'mak' ) . '</span></h1>' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$title          = esc_html( apply_filters( 'the_title', get_the_title( $post_id ) ) );
		$link           = esc_url( apply_filters( 'the_permalink', mak_get_summary_permalink( $post_id ) ) );
		$date           = mak_get_entry_data( array( 'post_id' => $post_id ) );
		if( has_excerpt( $post_id ) ) {
			$pickup  = get_post( $post_id );
			$content = $pickup->post_excerpt;
			$content = wp_trim_words( $content, 110, '&hellip;' );
		} else {
			$pickup  = get_post( $post_id );
			$content = $pickup->post_content;
			$content = wp_trim_words( $content, 110 );
		}
		$content       = apply_filters( 'get_the_excerpt', $content );
		$content       = apply_filters( 'the_excerpt', $content );
		$attachment_id = get_post_thumbnail_id( $post_id );
		$args = array(
			'id'     => $post_id,
			'size'   => $size,
			'width'  => $width,
			'height' => $height,
			'src'    => 'http://placehold.it/' . $width . 'x' . $height
		);
		$image   = mak_get_entry_thumbnail( $args );
		$class   = ! empty( $image ) ? 'thumbnail-true' : 'thumbnail-false';
		$output .= '<article class="archive-article ' . $class . '">' . "\n";
		$output .= $image . "\n";
		$output .= '<header class="entry-header">' . "\n";
		if ( ! is_child_theme() )
			$output .= mak_get_entry_terms( array( 'id' => $post_id, 'separator' => '', 'showcolor' => true, 'class' => ' color-cat' ) );
		$output .= '<h1 class="entry-title"><a href="' . $link . '">' . $title . '</a></h1>' . "\n";
		$output .= mak_get_entry_terms( array( 'id' => $post_id, 'term_name' => 'media', 'separator' => '' ) );
		$output .= $date;
		$output .= '</header>' . "\n";
		if ( ! is_child_theme() ) {
			$output .= '<section class="entry-summary trunk8" data-lines="' . $lines . '">' . "\n";
			$output .= $content;
			$output .= '</section>' . "\n";
		}
		$output .= '</article>' . "\n";
	}
	wp_reset_postdata();
	$output .= $after_widget;
	return $output;
}