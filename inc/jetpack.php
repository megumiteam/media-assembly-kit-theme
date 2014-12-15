<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Media Assembly Kit
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function mak_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'mak_jetpack_setup' );
