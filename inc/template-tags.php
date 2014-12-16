<?php
/**
 * Name: Media Assembly Kit Template tags
 * Description: Theme Template tags
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
 * 1. Head tags
 * 2. Header tags
 * 3. Common tags
 * 4. HOME tags
 * 5. Archive tags
 * 6. Single tags
 * 7. Page tags
 * 8. Side tags
 * 9. Footer tags
 * 10. Other tags
**/

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 1. Head tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 2. Header tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function mak_media_nav() {
	$search_foam = '<div class="search-foam-box">' . get_search_form( false ) . '<span class="search-toggle"><i class="fa fa-search"></i></span></div>' . "\n";
	wp_nav_menu( array(
		'theme_location'  => 'media-menu',
		'container'       => 'nav',
		'container_id'    => 'media-nav-box',
		'container_class' => 'media-menu',
		'items_wrap'      =>'<ul id="%1$s" class="%2$s">%3$s</ul>' . $search_foam,
		'depth'           => 1,
		'fallback_cb'     => ''
	) );
}
function mak_global_nav() {
	wp_nav_menu( array(
		'theme_location'  => 'global-menu',
		'container'       => 'nav',
		'container_id'    => 'global-nav-box',
		'container_class' => 'global-menu',
		'depth'           => 1,
		'fallback_cb'     => ''
	) );
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 3. Common tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function mak_khm_15() {
	echo mak_get_khm_15();
}
function mak_get_khm_15() {
	$output = '';
	if( function_exists( 'bcn_display' ) && ( !is_home() || !is_front_page() ) ) {
		$output .= '<nav id="khm-15">' . "\n";
		$output .= '<ul>' . "\n";
		$output .= bcn_display_list( true );
		$output .= '</ul>' . "\n";
		$output .= '</nav>' . "\n";
	}
	return $output;
}
// カテゴリー、シングルタイトル等を表示
function mak_archive_title() {
	echo mak_get_archive_title();
}
function mak_get_archive_title() {
	global $wp_query, $paged;
	$output      = '';
	$title       = '';
	$description = '';
	if ( is_home() && ! is_child_theme() ) {
		$title = __( 'What\'s New', 'mak' );
	} elseif ( is_author() ) {
		$author_id = get_queried_object_id();
		$title     = get_the_author_meta( 'display_name', $author_id );
	} elseif ( is_category() ) {
		$cat         = get_query_var( 'cat' );
		$title       = single_cat_title( '', false );
		$description = category_description( $cat );
		$description = apply_filters('the_content', $description);
		$description = str_replace(']]>', ']]&gt;', $description);
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_search() ) {
		if ( $wp_query->found_posts > 0 ) {
			$title = sprintf( __( 'Search Results for: %s', 'mak' ), get_search_query() );
		}
	}
	if ( $title ) {
		$output .= '<header class="archive-header">' . "\n";
		$output .= '<h1 class="archive-title"><span>' . $title . '</span></h1>' . "\n";
		if ( $description ) {
			$output .= '<div class="description">' . "\n";
			$output .= $description . "\n";
			$output .= '</div>' . "\n";
		}
		$output .= '</header>' . "\n";
	}
	return $output;
}

// 投稿日時
function mak_entry_data( $args = array() ) {
	echo mak_get_entry_data( $args );
}
function mak_get_entry_data( $args = array() ) {
	$default = array(
		'post_id' => '',
		'format'  => get_option('date_format'),
		'html'    => true,
		'before'    => '',
		'after'     => '',
	);
	$default = apply_filters( 'mak_entry_data_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	if ( $post_id ) {
		$post          = get_post( $post_id );
		$post_date     = $post->post_date;
		$post_date     = esc_attr( date_i18n( $format, strtotime( $post_date ) ) );
		$post_date_iso = esc_attr( date_i18n( 'c', strtotime( $post_date ) ) );
	} else {
		$post_date     = esc_attr( apply_filters( 'the_date', get_the_date( $format ) ) );
		$post_date_iso = esc_attr( apply_filters( 'the_date', get_the_date( 'c' ) ) );
	}
	if ( $html ) {
		$output = '<p class="entry-date">' . $before . '<time datetime="' . $post_date_iso . '">' . $post_date . '</time>' . $after . '</p>';
	} else {
		$output = $post_date;
	}
	return $output;
}

// Media Logo
function mak_media_logo( $post_id = '' ) {
	echo mak_get_media_logo( $post_id );
}
function mak_get_media_logo( $post_id = '' ) {
	if ( !$post_id && is_single() )
		$post_id = get_the_ID();

	$output = '';
	$args = array(
		'id'        => get_the_ID(),
		'term_name' => 'media',
	);
	extract($args);
	$terms = get_the_terms( $id, $term_name );
	if ( ! $terms )
		return;

	$term          = reset($terms);
	$term_id       = $term->term_id;
	$name          = $term->name;
	$link          = esc_url( get_term_link( (int) $term_id, $term_name ) );
	$attachment_id = get_option( 'media_' . $term_id . '_logo' );
	if ( ! $attachment_id )
		return;

	$image   = mak_get_entry_thumbnail( array( 'attachment_id' => $attachment_id, 'size' => 'full', 'html' => false, 'optional' => array( 'alt' => $name, 'title' => $name ) ) );
	$output .= '<p class="media-logo"><a href="' . $link . '">' . $image . '</a></p>' . "\n";
	return $output;
}

// mak_entry_terms
function mak_entry_terms( $args = array() ) {
	echo mak_get_entry_terms( $args );
}

// mak_get_entry_terms
function mak_get_entry_terms( $args = array() ) {
	$default = array(
		'id'        => get_the_ID(),
		'term_name' => 'category',
		'before'    => '',
		'after'     => '',
		'separator' => ', ',
		'link'      => true,
		'first'     => false,
		'showcolor' => false,
		'class'     => '',
		'children'  => true,
	);
	$default = apply_filters( 'mak_get_entry_terms_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);
	if ( $term_name == 'post_tag' ) {
		$terms = get_the_tags( $id );
		$term_name = 'tags';
	} else {
		$terms = get_the_terms( $id, $term_name );
	}

	$output     = '';
	$html       = '';
	if ( $terms ) {

		$output .= '<p class="posted-in-' . $term_name . $class . '">' . $before . "\n";
		foreach ( $terms as $term ) {
			$name     = $term->name;
			$taxonomy = $term->taxonomy;
			$term_id  = $term->term_id;
			$parent   = $term->parent;

			if ( $term_id ) {
				$color    = ! empty( $showcolor ) ? get_option( 'cat_' . $term_id . '_color', '#999' ) : '';
				$style    = $color ? ' style="background: ' . $color . ';"' : '';
				if ( $term->slug != 'pr' ) {
					if ( $link ) {
						$html .= '<a href="' . get_term_link( (int) $term_id, $taxonomy ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'mak_' ), $name ) ) . '"' . $style . '>' . esc_html( $name ) . '</a>' . $separator;
					} else {
						$html .= '<span' . $style . '>' . esc_html( $name ) . '</span>' . $separator;
					}
					if ( $first )
						break;
				}
			}
		}
		$output .= trim( $html, $separator );
		$output .= $after . '</p>' . "\n";
		return $output;
	}
}

// mak_entry_thumbnail
function mak_entry_thumbnail( $args = array() ) {
	echo mak_get_entry_thumbnail( $args );
}

// mak_get_entry_thumbnail
function mak_get_entry_thumbnail( $args = array() ) {
	$output        = '';
	$thumbnail_src = '';
	$default = array(
		'id'            => '',
		'attachment_id' => '',
		'size'          => 'post-thumbnail',
		'width'         => 125,
		'height'        => 140,
		'src'           => 'http://placehold.it/125x140',
		'link'          => true,
		'html'          => true,
		'noimage'       => false,
		'lightbox'      => false,
		'optional'      => array(),
	);
	$default = apply_filters( 'mak_entry_thumbnail_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	if ( !$id && in_the_loop() )
		$id = get_the_ID();

	if ( $attachment_id ) {
		$image = wp_get_attachment_image( $attachment_id, $size, false, $optional );
	} elseif ( $id && has_post_thumbnail( $id ) ) {
		$image = get_the_post_thumbnail( $id, $size, $optional );
	} elseif ( $noimage ) {
		$image = '<img src="' . $src . '" alt="' . the_title_attribute( 'echo=0' ) . '" width="' . $width . '" height="' . $height . '">' . "\n";
	} else {
		return;
	}
	if ( $lightbox ) {
		$attachment_id         = ! empty( $attachment_id ) ? $attachment_id : get_post_thumbnail_id( $id );
		$thumbnail_src         = wp_get_attachment_image_src( $attachment_id, 'full' );
		list( $thumbnail_src ) = $thumbnail_src;
	}
	if ( $lightbox ) {
		$output .= '<div class="thumbnail">' . "\n";
		$output .= '<a href="' . $thumbnail_src . '" class="image-popup" rel="bookmark">' . "\n";
		$output .= $image;
		$output .= '<p>' . __( 'Photo enlargement', 'mak' ) . '</p>' . "\n";
		$output .= '</a>' . "\n";
		$output .= '</div>' . "\n";
	} elseif ( !$link ) {
		$output .= '<p class="thumbnail">' . "\n";
		$output .= $image;
		$output .= '</p>' . "\n";
	} elseif( !$html ) {
		$output .= $image;
	} else {
		$output .= '<p class="thumbnail">' . "\n";
		$output .= '<a href="' . get_permalink( $id ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'mak' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">' . "\n";
		$output .= $image;
		$output .= '</a>' . "\n";
		$output .= '</p>' . "\n";
	}
	return $output;
}

function mak_thumbnail_class() {
	echo mak_get_thumbnail_class();
}
function mak_get_thumbnail_class() {
	$image = mak_get_entry_thumbnail();
	$class = ! empty( $image ) ? 'thumbnail-true' : 'thumbnail-false';
	return $class;
}

## アーカイブのページネーション表示
function mak_content_nav() {
	echo get_mak_content_nav();
}
function get_mak_content_nav() {
	global $wp_query, $paged;
	$output = '';
	if ( is_child_theme() && $wp_query->max_num_pages > 1 ) {
		if ( 1 > $paged && ! is_home() ) {
			$output .= mak_get_nav_top_ad();
			$output .= '<nav id="archive-nav">' . "\n";

			if ( get_next_posts_link() )
				$output .= '<p class="first-next">' . get_next_posts_link( __( 'The following articles list', 'mak' ) ) . '</p>' . "\n";

			$output .= '</nav>' . "\n";
		} elseif ( 1 < $paged ) {
			$max_num_pages  = $wp_query->max_num_pages;

			$output .= '<nav id="archive-nav">' . "\n";
			if ( get_previous_posts_link() )
				$output .= '<p class="previous">' . get_previous_posts_link( __( '<i class="fa fa-chevron-left"></i>Previous Page', 'mak' ) ) . '</p>' . "\n";

			$output .= '<p class="go-home"><a href="' . home_url() . '"><span>' . __( 'To the top of the page', 'mak' ) . '</span></a></p>' . "\n";

			if ( get_next_posts_link() )
				$output .= '<p class="next">' . get_next_posts_link( __( 'Next Page<i class="fa fa-chevron-right"></i>', 'mak' ) ) . '</p>' . "\n";

			$output .= '</nav>' . "\n";
		}
	} elseif ( ! is_child_theme() && $wp_query->max_num_pages > 1 ) {
		$p_base = get_pagenum_link(1);
		$p_format = 'page/%#%';

		if($word = strpos($p_base, '?')){
			$p_base = trailingslashit( home_url() ) . ( substr( trailingslashit( home_url() ), -1, 1 ) === '/' ? '' : '/' ) . '%_%' . substr( $p_base, $word );
		} else{
			$p_base .= (substr($p_base, -1 ,1) === '/' ? '' : '/') .'%_%';
		}

		$output .= '<nav id="archive-nav">' . "\n";

		$output .= paginate_links(array(
			'base'      => $p_base,
			'format'    => $p_format,
			'total'     => $wp_query->max_num_pages,
			'current'   => ($paged ? $paged : 1),
			'prev_next' => false,
			'type'      => 'list',
			'mid_size'  => 4,
			'end_size'  => 2,
			'prev_text' => __( '&lt;', 'mak' ),
			'next_text' => __( '&gt;', 'mak' ),
		));
		$output .= '</nav>' . "\n";
		//$output = str_replace( '&hellip;', '･･･', $output );

	} elseif ( is_single() && !is_attachment() ) {
		$next     = get_next_post();
		$previous = get_previous_post();
		$output  .= '<nav id="single-nav">' . "\n";
		if ( $previous )
			$output .= '<p class="nav-previous"><a href="' . esc_url( get_permalink( $previous->ID ) ) . '"><i class="fa fa-chevron-left"></i>' . esc_html( __( 'Previous article', 'mak' ) ) . '</a></p>' . "\n";

		$output .= '<p class="go-home"><a href="' . home_url() . '"><span>' . __( 'To the top of the page', 'mak' ) . '</span></a></p>' . "\n";

		if ( $next )
			$output .= '<p class="nav-next"><a href="' . esc_url( get_permalink( $next->ID ) ) . '">' . esc_html( __( 'Next article', 'mak' ) ) . '<i class="fa fa-chevron-right"></i></a></p>' . "\n";

		$output .= '</nav>' . "\n";
	}
	return $output;
}

function mak_more_link( $post_id = '' ) {
	echo mak_get_more_link( $post_id );
}
function mak_get_more_link( $post_id = '' ) {
	if ( !$post_id && is_single() )
		$post_id = get_the_ID();

	$output = '';
	$link   = esc_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) );
	if ( !$link )
		return;

	$output .= '<p class="more-link-box"><a href="' . $link . '" class="more-link">' . __( 'Read the full story', 'mak' ) . '</a></p>' . "\n";
	return $output;
}

function mak_summary_permalink( $post_id = '' ) {
	echo mak_get_summary_permalink( $post_id );
}
function mak_get_summary_permalink( $post_id = '' ) {
	if ( function_exists( 'summary_permalink' ) ) {
		$permalink = esc_url( summary_get_permalink( $post_id ) );
	} else {
		$permalink = esc_url( get_permalink( $post_id ) );
	}
	return $permalink;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 4. HOME tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 5. Archive tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 6. Single tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function mak_summary_ad() {
	echo mak_get_summary_ad();
}
function mak_get_summary_ad() {
	if ( ! function_exists( 'mad_code' ) )
		return;
	$output = '<div class="mad-summary-box">' . "\n";
	$output .= get_mad_code( array( 'code' => 'mad_pc_summary_left', 'class' => 'mad mad-summary-left' ) );
	$output .= get_mad_code( array( 'code' => 'mad_pc_summary_right', 'class' => 'mad mad-summary-right' ) );
	$output .= '</div>' . "\n";
	return $output;
}
function mak_single_ad() {
	echo mak_get_single_ad();
}
function mak_get_single_ad() {
	if ( ! function_exists( 'mad_code' ) )
		return;
	$output = '<div class="mad-single-box">' . "\n";
	$output .= get_mad_code( array( 'code' => 'mad_pc_single_left', 'class' => 'mad mad-single-left' ) );
	$output .= get_mad_code( array( 'code' => 'mad_pc_single_right', 'class' => 'mad mad-single-right' ) );
	$output .= '</div>' . "\n";
	return $output;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 7. Page tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 8. Side tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
add_action( 'mak_secondary', function(){
	if ( !is_child_theme() && is_active_sidebar( 'sidebar-1' ) && is_home() ) {
		dynamic_sidebar( 'sidebar-1' );
	}
	if ( !is_child_theme() && is_active_sidebar( 'sidebar-2' ) && !is_home() ) {
		dynamic_sidebar( 'sidebar-2' );
	}
	if ( is_child_theme() && is_active_sidebar( 'sidebar-3' ) && !is_single() ) {
		dynamic_sidebar( 'sidebar-3' );
	}
	if ( is_child_theme() && is_active_sidebar( 'sidebar-4' ) && function_exists( 'is_summary_page') && is_summary_page() ) {
		dynamic_sidebar( 'sidebar-4' );
	}
	if ( is_child_theme() && is_active_sidebar( 'sidebar-5' ) && is_single() ) {
		dynamic_sidebar( 'sidebar-5' );
	}
});

add_action( 'mak_after_content', function(){
	get_sidebar();
} );

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 9. Footer tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function mak_footer_nav() {
	wp_nav_menu( array(
		'theme_location'  => 'footer-menu',
		'container'       => 'nav',
		'container_id'    => 'footer-nav-box',
		'container_class' => 'footer-menu',
		'depth'           => 1,
		'fallback_cb'     => ''
	) );
}
function mak_copyright() {
	echo mak_get_copyright();
}
function mak_get_copyright() {
	$now_year  = date_i18n( 'Y' );
	$copyright = get_option( 'copyright', '&copy; Your Corp. [year] All rights reserved. No reproduction or republication without written permission.' );
	$year      = get_option( 'copyright_year', $now_year );

	if ( $now_year > $year )
		$year = $year . ' - ' . date_i18n( 'Y' );

	$text = str_replace( '[year]', $year, $copyright );
	$output = '<p id="copyright"><small>' . $text . '</small></p>' . "\n";
	return $output;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 10. Other tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
