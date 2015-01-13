<?php
/**
 * Name: Media Assembly Kit Social Parts
 * Description: Social Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_social_language_attributes( $attributes ) {
	$attributes = explode( ' ', $attributes );
	$attributes[] = 'xmlns:og="http://ogp.me/ns#"';
	$attributes[] = 'xmlns:fb="http://www.facebook.com/2008/fbml"';
	$attributes[] = 'xmlns:mixi="http://mixi-platform.com/ns#"';
	$attributes = implode(' ', $attributes);
	return $attributes;
}
add_filter( 'language_attributes', 'mak_social_language_attributes' );

function mak_fb_root() {
	$app_id = esc_attr( get_option( 'ogp_appid' ) );
	$app_id = '&appId=' . $app_id;
echo <<<EOD
	<div id="fb-root"></div>
	<script src="//connect.facebook.net/ja_JP/all.js"></script>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1{$app_id}&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
EOD;
}
add_action( 'mak_before_body', 'mak_fb_root' );

function mak_social_button_conf( $post_id = '' ) {
	if ( !$post_id && !is_404() )
		$post_id = get_the_ID();

	$twitter_url   = esc_attr( get_option( 'twitter_url' ) );
	$facebook_url  = esc_attr( get_option( 'facebook_url' ) );
	$youtube_url   = esc_attr( get_option( 'youtube_url' ) );
	$pinterest_url = esc_attr( get_option( 'pinterest_url' ) );
	$twitter_via   = esc_attr( get_option( 'twitter_via' ) );
	$appid         = esc_attr( get_option( 'ogp_appid' ) );
	$title         = get_the_title( $post_id ) . ' | ' . get_bloginfo( 'name' );
	$value         = array(
		'title'        => $title,
		'counturl'   => esc_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ),
		//'counturl'     => mak_get_summary_permalink( $post_id ),
		'url'        => esc_url( wp_get_shortlink( $post_id ) ),
		//'url'          => mak_get_summary_permalink( $post_id ),
		'twitter_url'  => esc_url( $twitter_url ),
		'facebook_url' => esc_url( $facebook_url ),
		'via'          => esc_attr( $twitter_via ),
		'appid'        => $appid,
	);
	return $value;
}

function mak_global_social_button() {
	echo mak_get_global_social_button();
}
function mak_get_global_social_button() {
	$twitter_url   = esc_attr( get_option( 'twitter_url' ) );
	$facebook_url  = esc_attr( get_option( 'facebook_url' ) );
	$youtube_url   = esc_attr( get_option( 'youtube_url' ) );
	$pinterest_url = esc_attr( get_option( 'pinterest_url' ) );

	$output = '<div class="global-social-button-box">' . "\n";
	if ( $twitter_url )
		$output .= '<p class="twitter-page"><a href="' . $twitter_url . '" target="_blank"><i class="fa fa-twitter"></i></a></p>' . "\n";

	if ( $facebook_url )
		$output .= '<p class="facebook-page"><a href="' . $facebook_url . '" target="_blank"><i class="fa fa-facebook"></i></p>' . "\n";

	if ( $youtube_url )
		$output .= '<p class="youtube-page"><a href="' . $youtube_url . '" target="_blank"><i class="fa fa-youtube"></i></a></p>' . "\n";

	if ( $pinterest_url )
		$output .= '<p class="pinterest-page"><a href="' . $pinterest_url . '" target="_blank"><i class="fa fa-pinterest"></i></a></p>' . "\n";

	$output .= '</div>' . "\n";
	return $output;
}

function mak_social_button( $post_id = '' ) {
	echo mak_get_social_button( $post_id );
}
function mak_get_social_button( $post_id = '' ) {
	$output = '';
	if ( !$post_id && !is_404() )
		$post_id = get_the_ID();

	$conf = mak_social_button_conf( $post_id );
	extract($conf);

	$counturlencode = urlencode($counturl);
	$urlencode      = urlencode($url);
	$txtencode      = urlencode($title);
	$output .= <<<EOD
	<div class="social-entry-box">
		<p class="twitter-button">
			<a href="http://twitter.com/share?url={$urlencode}&counturl={$counturlencode}&text={$txtencode}&via={$via}&related={$via}" target="_blank"><i class="fa fa-twitter"></i></a>
			<span class="count twitter-count" data-url="{$url}">0</span>
		</p>
		<p class="facebook-button">
			<a href="http://www.facebook.com/share.php?u={$url}&t={$title}" target="_blank"><i class="fa fa-facebook-square"></i></a>
			<span class="count facebook-count" data-url="{$url}">0</span>
		</p>
		<p class="line">
			<a href="http://line.me/R/msg/text/?{$title}%0D%0A{$url}" target="_blank"><i class="webnist webnist-line"></i></a>
		</p>
	</div>
EOD;
	return $output;
}

function mak_social_share( $post_id = '' ) {
	echo mak_get_social_share( $post_id );
}
function mak_get_social_share( $post_id = '' ) {
	$output = '';
	if ( !$post_id && !is_404() )
		$post_id = get_the_ID();

	$conf = mak_social_button_conf( $post_id );
	extract($conf);

	$counturlencode = urlencode($counturl);
	$urlencode      = urlencode($url);
	$txtencode      = urlencode($title);
	$output .= <<<EOD
	<div class="social-share-box">
		<p class="twitter-button">
			<a href="http://twitter.com/share?url={$urlencode}&counturl={$counturlencode}&text={$txtencode}&via={$via}&related={$via}" target="_blank"><i class="fa fa-twitter"></i>Twitterでつぶやく</a>
		</p>
		<p class="facebook-button">
			<a href="http://www.facebook.com/share.php?u={$url}&t={$title}" target="_blank"><i class="fa fa-facebook"></i>Facebookでシェア</a>
		</p>
	</div>
EOD;
	return $output;
}

function mak_mobile_header_social_button() {
	echo mak_get_mobile_header_social_button();
}
function mak_get_mobile_header_social_button() {

	$counturl       = esc_url( home_url() );
	$url            = esc_url( home_url() );
	$title          = esc_html( get_bloginfo( 'name' ) );
	$via    = esc_attr( get_option( 'twitter_via' ) );

	$counturlencode = urlencode($counturl);
	$urlencode      = urlencode($url);
	$txtencode      = urlencode($title);
	$output = <<<EOD
	<div class="social-box">
		<p class="tweet-button">
			<a href="http://twitter.com/share?url={$urlencode}&counturl={$counturlencode}&text={$txtencode}&via={$via}&related={$via}" target="_blank"><i class="fa fa-twitter"></i>Tweet</a>
		</p>
		<p class="share-button">
			<a href="http://www.facebook.com/share.php?u={$url}&t={$title}" target="_blank"><i class="fa fa-facebook"></i>Share</a>
		</p>
	</div>
EOD;
	return $output;
}
