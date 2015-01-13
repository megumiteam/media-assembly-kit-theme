<?php
/**
 * Name: Media Assembly Kit Category Posts Parts
 * Description: Category Posts Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_category_posts( $args = array() ) {
	$posts   = array();
	$default = array(
		'posts_per_page' => get_option( 'mobile_posts_per_page', 12 ),
		'cat'            => 0,
	);
	$default = apply_filters( 'mak_get_category_posts_tab_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_category_posts_tab( $args = array() ) {
	echo mak_get_category_posts_tab( $args );
}
function mak_get_category_posts_tab( $args = array() ) {
	$output    = '';
	$default = array(
		'before_widget' => '<aside id="category-posts-tab">',
		'after_widget'  => '</aside>',
		'limit'         => get_option( 'mobile_posts_per_page', 10 ),
	);

	$default = apply_filters( 'mak_category_posts_tab_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$cats       = mak_options_categories( array(), array( 'child' => false ) );
	$top        = array( 'term_id' => 0, 'name' => __( 'TOP', 'mak' ) );
	$categories = array();
	array_push( $categories, $top );
	foreach ( $cats as $cat ) {
		$term_id = $cat['term_id'];
		$name    = $cat['name'];
		$args    = array(
			'cat' => $term_id,
		);
		$posts = mak_get_category_posts( $args );
		if ( ! empty( $posts ) ) {
			$value = array( 'term_id' => $term_id, 'name' => $name );
			array_push( $categories, $value );
		}
	}
	if ( empty( $categories ) )
		return;

	$size    = 'mobile-thumbnail';
	$width   = 190;
	$height  = 200;
	$lines   = 3;
	$halfway = get_option( 'ad_mobile_posts_number', 7 );
	$output .= $before_widget;
	$output .= '<nav id="category-posts-tab-nav">' . "\n";
	$output .= '<ul>' . "\n";
	foreach ( $categories as $category ) {
		$term_id = $category['term_id'];
		$name    = $category['name'];
		$output .= '<li>' . esc_html( $name ) . '</li>' . "\n";
	}
	$output .= '</ul>' . "\n";
	$output .= '</nav>' . "\n";
	$output .= '<div>' . "\n";
	foreach ( $categories as $category ) {
		$term_id      = $category['term_id'];
		$name         = $category['name'];
		if ( $term_id > 0 ) {
			$get_category = get_category( $term_id );
			$post_count   = $get_category->category_count;
			$cat_link     = get_category_link( $term_id ) . '/';
		} else {
			$num_posts  = wp_count_posts();
			$post_count = (int) $num_posts->publish;
			$cat_link   = trailingslashit( home_url( '/' ) );
		}
		// $cat_link = add_query_arg( array( 'paged'=>2 ), $cat_link );
		$cat_link = $cat_link . 'page/2';
		$args     = array(
			'posts_per_page' => $limit,
			'cat'            => $term_id,
		);
		$posts = mak_get_category_posts( $args );
		$count = 1;
		$output .= '<div>' . "\n";
		foreach ( $posts as $post ) {
			setup_postdata( $post );
			$post_id       = $post->ID;
			$title         = apply_filters( 'the_title', get_the_title( $post_id ) );
			$link          = esc_url( apply_filters( 'the_permalink', mak_get_summary_permalink( $post_id ) ) );
			$media         = mak_get_entry_terms( array( 'id' => $post_id, 'term_name' => 'media', 'link' => false, 'first' => true ) );
			$date          = mak_get_entry_data( array( 'post_id' => $post_id, 'format' => 'Y.m.d' ) );
			$attachment_id = get_post_thumbnail_id( $post_id );
			$args          = array(
				'attachment_id' => $attachment_id,
				'size'          => $size,
				'width'         => $width,
				'height'        => $height,
				'src'           => 'http://placehold.it/' . $width . 'x' . $height,
				'link'          => false,
			);
			$image          = mak_get_entry_thumbnail( $args );
			$class          = $image ? 'thumbnail-true archive-article' : 'archive-article';
			$output .= '<article class="' . $class . '""><a href="' . $link . '">' . "\n";
			$output .= $image . "\n";
			$output .= '<header class="entry-header">' . "\n";
			$output .= '<h1 class="entry-title trunk8" data-lines="' . $lines . '">' . $title . '</h1>' . "\n";
			if ( $media || $date ) {
				$output .= $media . "\n";
				$output .= $date . "\n";
			}
			$output .= '</header>' . "\n";
			$output .= '</a></article>' . "\n";
			if ( $halfway == $count ) {
				$output .= mak_get_halfway_ad();
			}
			$count++;
		}
		wp_reset_postdata();

		if ( $limit < $post_count )
			$output .= '<p class="more-archive"><a href="' . $cat_link . '">' . __( 'The following articles list', 'mak' ) . '</a></p>' . "\n";

		$output .= '</div>' . "\n";
	}
	$output .= '</div>' . "\n";
	$output .= $after_widget;
	return $output;
}

