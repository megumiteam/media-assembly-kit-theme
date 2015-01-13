<?php
/**
 * Media Assembly Kit functions and definitions
 *
 * @package Media Assembly Kit
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'mak_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mak_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on mak, use a find and replace
	 * to change 'mak' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'mak', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 125, 140, true );
	add_image_size( 'mobile-thumbnail', 190, 200, true ); // Mobile @2x
	add_image_size( 'square-218-image', 218, 248, true );
	add_image_size( 'square-193-image', 193, 100, true ); // Mobile @2x
	add_image_size( 'square-175-image', 350, 450, true ); // Mobile @2x
	add_image_size( 'square-148-image', 148, 148, true );
	add_image_size( 'square-110-image', 110, 125, true );
	add_image_size( 'square-100-image', 100, 70, true );
	add_image_size( 'square-90-image', 90, 60, true );
	add_image_size( 'square-70-image', 70, 70, true );
	add_image_size( 'slide-main-image', 700, 350, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'global-menu'         => __( 'Global Menu', 'mak' ),
		'footer-menu'         => __( 'Footer Menu', 'mak' ),
		'mobile-footer-menu'  => __( 'Mobile Footer Menu', 'mak' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

}
endif; // mak_setup
add_action( 'after_setup_theme', 'mak_setup' );

/**
 * load categories in the theme options.
 */
function mak_options_categories( $values = array(), $args = array(), $parent = 0 ) {
	$default = array(
		'orderby'    => 'term_order',
		'hide_empty' => false,
		'order'      => 'ASC',
		'parent'     => $parent,
		'child'      => true,
	);
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$categories = get_terms( 'category', $args );
	if ( empty( $categories ) )
		return $values;

	foreach ( $categories as $category ) {
		$term_id = $category->term_id;
		$name    = $category->name;
		$slug    = $category->slug;
		if ( $slug == 'pr' ) {
			continue;
		}
		$value   = array( 'term_id' => $term_id, 'name' => $name, 'slug' => $slug );
		array_push( $values, $value );
		if ( $child )
			$values = mak_options_categories( $values, $$args, $term_id );
	}
	return $values;
}

/**
 * load the file in the inc directory
 */
function mak_theme_require() {

	/* global require function */
	if ( file_exists( get_template_directory() . '/inc/') ) {
		$dir = get_template_directory() . '/inc/';
		$handle = opendir( $dir );
		while ( false !== ( $ent = readdir( $handle ) ) ) {
			if ( !is_dir( $ent ) && strtolower( substr( $ent, -4 ) ) == ".php" ) {
				require $dir . $ent;
			}
		}
		closedir( $handle );
	}

	/* Child require function */
	if( is_child_theme() && file_exists( get_stylesheet_directory() . '/child_inc/') ) {
		$dir = get_stylesheet_directory() . '/child_inc/';
		$handle = opendir( $dir );
		while ( false !== ( $ent = readdir( $handle ) ) ) {
			if ( !is_dir( $ent ) && strtolower( substr( $ent, -4 ) ) == ".php" ) {
				require $dir . $ent;
			}
		}
		closedir( $handle );
	}
}
add_action( 'after_setup_theme', 'mak_theme_require' );

if ( !function_exists( 'mak_file_time_stamp' ) ) :
	/**
	 * Gets the time stamp of the file
	 */
	function mak_file_time_stamp( $file = null, $args = array() ) {

		$default = array(
			'path'  => null,
			'child' => false,
		);
		$args    = wp_parse_args( $args, $default );
		extract($args);

		if ( !$path && $child )
			$path = get_stylesheet_directory();

		if ( !$path && !$child )
			$path = get_template_directory();

		$value = null;
		$file = $path . '/' . $file;
		if ( file_exists( $file ) ) {
			$value = filemtime( $file );
		}
		return $value;
	}
endif; // mak_file_time_stamp
