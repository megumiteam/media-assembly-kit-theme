<?php
/**
 * Name: Media Assembly Kit Background Parts
 * Description: Background Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_background() {
	global $background_defaults;
	$output     = '';
	$attachment_id = get_option( 'background_image');
	$image         = wp_get_attachment_image_src( $attachment_id, 'full' );
	if ( !empty( $image ) )
		$image         = reset( $image );
	$color         = get_option( 'background_color' );
	$repeat        = get_option( 'background_repeat' );
	$position      = get_option( 'background_position' );
	$attachment    = get_option( 'background_attachment' );
	$background_size = '-webkit-background-size: cover;' . "\n"
	. '-moz-background-size: cover;' . "\n"
	. '-o-background-size: cover;' . "\n"
	. '-ms-background-size: cover;' . "\n"
	. 'background-size: cover;' . "\n";

	if ( $image ) {
		$output = <<< EOT
<style id="style-background-image">
	body {
		background: {$color} url({$image}) {$repeat} {$position} {$attachment};
		{$background_size}
	}
</style>
EOT;
	} else {
		$output = <<< EOT
<style id="style-background-color">
	body {
		background: {$color};
	}
</style>
EOT;
	}
	echo $output;
}
add_action( 'wp_head', 'mak_background' );

function mak_background_link() {
	if ( is_child_theme() )
		return;

	$link   = get_option( 'background_link' );
	$target = get_option( 'background_target' );

	if ( !$link )
		return;

	$target = ( $target == 1 ) ? ' target="_blank"' : '';
	$output = '<div id="background-link"><a href="' . $link . '"' . $target . '></a></div>' . "\n";
	echo $output;
}
add_action( 'wp_footer', 'mak_background_link' );
