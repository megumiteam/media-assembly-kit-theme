<?php
/**
 * Name: Media Assembly Kit Site Option Parts
 * Description: Site Option Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_site_option_output() {
	$output     = '';

	// favicon
	$favicon_id   = get_option( 'favicon_image', '' );
	$favicon      = wp_get_attachment_image_src( $favicon_id, 'full' );
	if ( !empty( $favicon ) )
		$favicon = reset( $favicon );

	if ( $favicon ) {
		$output .= '<link rel="shortcut icon" href="' . $favicon . '" />' . "\n";
	}

	// apple-touch-icon
	$touchicon_id = get_option( 'apple_touch_icon_image', '' );
	$touchicon    = wp_get_attachment_image_src( $touchicon_id, 'full' );
	if ( !empty( $touchicon ) )
		$touchicon = reset( $touchicon );

	if ( $touchicon ) {
		$output .= '<link rel="apple-touch-icon" href="' . $touchicon . '" />' . "\n";
	}

	// Google Analytics
	$google_analytics_code = get_option( 'google_analytics_code', '' );
	if ( $google_analytics_code ) {
		$output .= $google_analytics_code . "\n";
	}

	// Google Webmaster Tools
	$google_webmaster_code = get_option( 'google_webmaster_code', '' );
	if ( $google_webmaster_code ) {
		$output .= '<meta name="google-site-verification" content="' . $google_webmaster_code . '" />' . "\n";
	}

	// Bing Webmaster Center
	$bing_webmaster_code = get_option( 'bing_webmaster_code', '' );
	if ( $bing_webmaster_code ) {
		$output .= '<meta name="msvalidate.01" content="' . $bing_webmaster_code . '" />' . "\n";
	}

	echo $output;
}
add_action( 'wp_head', 'mak_site_option_output' );

