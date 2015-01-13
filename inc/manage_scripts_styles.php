<?php
/**
 * Name: Media Assembly Kit Management Scripts Styles
 * Description: Management Scripts Styles
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

/**
 * Register Lobster Google font
 */
function mak_font_url() {
	$font_url = add_query_arg( 'family', 'Asap:400,700,400italic,700italic', "//fonts.googleapis.com/css" );
	return $font_url;
}
function mak_scripts_styles() {

	// Loads our normalize css
	if ( file_exists( ABSPATH . '/assets/lib/normalize.css' ) )
		wp_enqueue_style( 'normalize', get_site_url() . '/assets/lib/normalize.css', array(), 'v3.0.2' );

	wp_enqueue_style( 'open-sans' );
	wp_enqueue_style( 'asap', mak_font_url(), array(), null );

	// Font-Awesome
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css' );

	// Font-webnist
	if ( file_exists( ABSPATH . '/assets/fonts/font-webnist.css' ) )
		wp_enqueue_style( 'font-webnist', get_site_url() . '/assets/fonts/font-webnist.css', array(), mak_file_time_stamp( '/fonts/font-webnist.css' ) );

	// magnific-popup
	// http://dimsemenov.com/plugins/magnific-popup/
	if ( file_exists( ABSPATH . '/assets/lib/magnific-popup.css' ) && is_single() )
		wp_enqueue_style( 'magnific-popup-style', get_site_url() . '/assets/lib/magnific-popup.css', array(), 'v1.0.0' );
	if ( file_exists( ABSPATH . '/assets/lib/jquery.magnific-popup.min.js' ) && is_single() )
		wp_enqueue_script( 'jquery-magnific-popup', get_site_url() . '/assets/lib/jquery.magnific-popup.min.js', array('jquery'), 'v1.0.0', true );

	// headroom
	// https://github.com/WickyNilliams/headroom.js
	wp_enqueue_script( 'headroom', '//cdn.jsdelivr.net/headroomjs/0.5.0/headroom.min.js', array('jquery'), 'v0.5.0', true );		
	wp_enqueue_script( 'jQuery-headroom', '//cdn.jsdelivr.net/headroomjs/0.5.0/jQuery.headroom.min.js', array('jquery'), 'v0.5.0', true );		

	// imagesLoaded
	// http://imagesloaded.desandro.com/
	if ( file_exists( ABSPATH . '/assets/lib/imagesloaded.pkgd.min.js' ) )
		wp_enqueue_script( 'imagesloaded', get_site_url() . '/assets/lib/imagesloaded.pkgd.min.js', array('jquery'), 'v3.1.8', true );

	// bxslider
	// http://bxslider.com/
	if ( file_exists( ABSPATH . '/assets/lib/jquery.bxslider.min.js' ) )
		wp_enqueue_script( 'bxslider', get_site_url() . '/assets/lib/jquery.bxslider.min.js', array('jquery'), 'v4.1.2', true );

	// trunk8
	// http://jrvis.com/trunk8/
	if ( file_exists( ABSPATH . '/assets/lib/trunk8.js' ) )
		wp_enqueue_script( 'trunk8', get_site_url() . '/assets/lib/trunk8.js', array('jquery'), 'v1.3.3', true );

	// fitvids
	// http://fitvidsjs.com/
	if ( file_exists( ABSPATH . '/assets/lib/jquery.fitvids.js' ) && is_single() )
		wp_enqueue_script( 'fitvids-script', get_site_url() . '/assets/lib/jquery.fitvids.js', array('jquery'), '1.1', true );

	// slide-pan-pan mobile only
	if ( is_child_theme() ) {
		if ( file_exists( ABSPATH . '/assets/lib/slide-pan-pan.js' ) )
			wp_enqueue_script( 'slide-pan-pan', get_site_url() . '/assets/lib/slide-pan-pan.js', array(), mak_file_time_stamp( '/lib/slide-pan-pan.js' ), true );
	}

	// Loads main stylesheet.
	// Loads JavaScript file with functionality specific to mak.
	$makstylesheet_mo = get_site_url() . '/assets/css/mobile.css';
	$makstylesheet_pc = get_site_url() . '/assets/css/pc.css';
	$makjavascript_mo = get_site_url() . '/assets/js/mobile.min.js';
	$makjavascript_pc = get_site_url() . '/assets/js/pc.min.js';

	if ( defined( 'WP_DEBUG' ) && ( WP_DEBUG == true ) ) { // WP_DEBUG = ture
		$makstylesheet_mo = get_template_directory_uri() . '/css/mobile.css';
		$makstylesheet_pc = get_template_directory_uri() . '/css/pc.css';
		$makjavascript_mo = get_template_directory_uri() . '/js/mobile.js';
		$makjavascript_pc = get_template_directory_uri() . '/js/pc.js';
	}

	if ( is_child_theme() ) {
		wp_enqueue_style( 'mak', $makstylesheet_mo, array(), '1.0.0' );
		wp_enqueue_script( 'mak', $makjavascript_mo, array('jquery'), mak_file_time_stamp( '/js/mobile.js' ), true );
	} else {
		wp_enqueue_style( 'mak', $makstylesheet_pc, array(), '1.0.0' );
		wp_enqueue_script( 'mak', $makjavascript_pc, array('jquery'), mak_file_time_stamp( '/js/pc.js' ), true );
	}

}
add_action( 'wp_enqueue_scripts', 'mak_scripts_styles' );
