<?php
/**
 * Name: Media Assembly Kit External Site Parts
 * Description: External Site Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_external_site( $args = array() ) {
	echo mak_get_external_site( $args );
}
function mak_get_external_site( $args = array() ) {
	$output = '';
	$default = array(
		'id'     => get_the_ID(),
		'before' => '',
		'after'  => '',
		'num'    => 3,
	);
	$default = apply_filters( 'mak_entry_thumbnail_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$sites = '';
	if ( function_exists( 'get_field' ) ) {
		$sites = get_field( 'external_site', $id );
	}

	if ( empty( $sites ) )
		return;

	$count = 1;
	$output .= '<aside id="external-site">' . "\n";
	$output .= '<h1 class="external-site-title"><i class="fa fa-external-link"></i><span>' . __( 'This article provides original articles', 'mak' ) . '</span></h1>' . "\n";
	$output .= '<ul>' . "\n";
	foreach ( $sites as $site ) {
		if ( 3 >= $count ) {
			$name = esc_html( $site['site_neme'] );
			$link = esc_url( $site['site_url'] );
			$output .= '<li>' . $before . '<a href="' . $link . '" target="_blank">' . $name . '</a>' . $after . '</li>' . "\n";
		}
		$count++;
	}
	$output .= '</ul>' . "\n";
	$output .= '</aside>' . "\n";
	return $output;
}
