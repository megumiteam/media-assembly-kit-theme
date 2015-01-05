<?php
/**
 * Name: Media Assembly Kit Category Induction Posts Parts
 * Description: Category Induction Posts Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_category_induction_posts( $args = array() ) {
	$posts   = array();
	$default = array(
		'posts_per_page' => get_option( 'induction_posts_per_page', 8 ),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	);
	$default = apply_filters( 'mak_category_induction_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_category_induction_post_list( $args = array(), $instance  = array()) {
	echo mak_get_category_induction_post_list( $args, $instance );
}
function mak_get_category_induction_post_list( $args = array(), $instance  = array()) {
	//if ( ( !is_home() || !is_front_page() ) || is_paged() || !( defined( 'JSON_REQUEST' ) && JSON_REQUEST ) )
	if ( ( !is_home() || !is_front_page() ) || is_paged()  )
		return;

	$output    = '';
	$default = array(
		'before_widget' => '<aside id="category-induction">',
		'after_widget'  => '</aside>',
	);

	$default = apply_filters( 'mak_category_induction_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$cats       = mak_options_categories( array(), array( 'child' => false ) );
	$categories = array();
	foreach ( $cats as $cat ) {
		$term_id = $cat['term_id'];
		$name    = $cat['name'];
		$slug    = $cat['slug'];
		$view    = get_option( 'cat_' . $term_id . '_view_induction', 1 );
		$args    = array(
			'post_type' => 'cat-' . $term_id . '-induction',
		);
		$posts = mak_get_category_induction_posts( $args );
		if ( ! empty( $posts ) && ! empty( $view ) ) {
			$value = array( 'term_id' => $term_id, 'name' => $name, 'slug' => $slug );
			array_push( $categories, $value );
		}
	}
	if ( empty( $categories ) )
		return;

	if ( is_child_theme() ) {
		$size   = 'mobile-thumbnail';
		$width  = 190;
		$height = 200;
	} else {
		$size   = 'square-148-image';
		$width  = 148;
		$height = 148;
	}
	$output .= $before_widget;
	$output .= '<nav id="category-induction-nav">' . "\n";
	$output .= '<ul>' . "\n";
	$count   = 1;
	foreach ( $categories as $category ) {
		$term_id = $category['term_id'];
		$name    = $category['name'];
		$short   = get_option( 'cat_' . $term_id . '_short_title', $name );
		$name    = ! empty( $short ) ? $short : $name;
		$slug    = $category['slug'];
		$class   = ( 1 === $count ) ? ' class="current"' : '';
		$color   = get_option( 'cat_' . $term_id . '_color', '#999' );
		$color   = $color ? $color : '#999';
		$output .= '<li' . $class . ' data-target="' . $slug . '"><span style="background-color: ' . $color . ';">' . esc_html( $name ) . '</span></li>' . "\n";
		$count++;
	}
	$output .= '</ul>' . "\n";
	$output .= '</nav>' . "\n";
	$count   = 1;
	foreach ( $categories as $category ) {
		$term_id = $category['term_id'];
		$name    = $category['name'];
		$slug    = $category['slug'];
		$first   = 1;
		$args    = array(
			'post_type' => 'cat-' . $term_id . '-induction',
		);
		$posts = mak_get_category_induction_posts( $args );
		$class = ( 1 === $count ) ? ' current' : '';
		$output .= '<ul id="' . $slug . '" class="category-induction-content' . $class . '">' . "\n";
		$first = 1;
		foreach ( $posts as $post ) {
			setup_postdata( $post );
			$post_id   = $post->ID;
			$select_id = get_field( 'select_post', $post_id );
			$select_id = reset( $select_id );
			if ( 'publish' === get_post_status( $select_id ) ) {
				$title          = apply_filters( 'the_title', get_the_title( $post_id ) );
				$link           = esc_url( apply_filters( 'the_permalink', get_permalink( $select_id ) ) );
				if ( 1 === $first ) {
					$attachment_id  = get_post_thumbnail_id( $select_id ) ? get_post_thumbnail_id( $select_id ) : get_post_thumbnail_id( $post_id );
					$args           = array(
						'attachment_id' => $attachment_id,
						'size'          => $size,
						'width'         => $width,
						'height'        => $height,
						'src'           => 'http://placehold.it/' . $width . 'x' . $height,
						'link'          => false,
					);
					$image          = mak_get_entry_thumbnail( $args );
					$output .= '<li class="first"><a href="' . $link . '">' . "\n"
					. $image . "\n"
					. '<p class="title trunk8" data-lines="3">' . $title . '</p>' . "\n"
					. '</a></li>' . "\n";
				} else {
					$output .= '<li><i class="fa fa-caret-right"></i><a href="' . $link . '" class="trunk8" data-lines="2">' . $title . '</a></li>' . "\n";
				}
				$first++;
			}
		}
		wp_reset_postdata();
		$output .= '</ul>' . "\n";
		$count++;
	}
	$output .= $after_widget;
	return $output;
}

