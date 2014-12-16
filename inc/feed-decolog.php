<?php
function decolog_posts_per_rss_for_feed($value) {
	if ( is_feed() && isset( $_GET['type'] ) && $_GET['type'] == 'decolog' )
		return 10;

	return $value;
}
add_filter( 'option_posts_per_rss', 'decolog_posts_per_rss_for_feed' );