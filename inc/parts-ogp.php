<?php
/**
 * Name: Media Assembly Kit OGP Parts
 * Description: OGP Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

// wp_head
add_filter( 'jetpack_enable_open_graph', '__return_false' );
add_action( 'wp_head', 'mak_add_metatags' );
function mak_add_metatags() {

	$ogtitle     = wp_title( '|', false, 'right' );
	$ogtype      = is_singular() ? 'article' : 'website';
	$description = esc_attr( get_option( 'ogp_description', get_bloginfo( 'description', 'display' ) ) );
	$keyword     = esc_attr( get_option( 'ogp_keyword' ) );
	$ogurl       = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$ogimage_id  = get_option( 'ogp_image' );
	if ( $ogimage_id ) {
		$image   = wp_get_attachment_image_src( $ogimage_id, 'full' );
		$ogimage = reset( $image );
	} else {
		$ogimage = '';
	}
	$site_name   = esc_attr( get_option( 'ogp_title', get_bloginfo( 'name', 'display') ) );
	$app_id      = esc_attr( get_option( 'ogp_appid' ) );

	if ( is_singular() ) {
		$post_id = get_the_ID();
		$post    = get_post( $post_id );
		if ( has_excerpt( $post_id ) ) {
			$contents = $post->post_excerpt;
		} else {
			$contents = $post->post_content;
		}
		if ( $contents ) {
			$contents    = wp_html_excerpt( $contents, 64, '&hellip;' );
			$contents    = apply_filters( 'get_the_excerpt', $contents );
			$description = $contents;
		}
		if( $tags = get_the_tags( $post_id ) ) {
			if ( !empty( $tags ) ) {
				foreach ( $tags as $value ) {
					$tag[] = $value->name;
				}
				$keyword = implode( ',', $tag );
			}
		}
		if ( has_post_thumbnail( $post_id ) ) {
			$image_id = get_post_thumbnail_id( $post_id );
			$image    = wp_get_attachment_image_src( $image_id, 'full');
			if ( !empty( $image ) )
				$ogimage  = reset( $image );
		}
	}
?>
<!-- OGP and meta -->
<meta property="og:title" content="<?php echo $ogtitle; ?>">
<meta property="og:type" content="<?php echo $ogtype; ?>">
<?php if ( $description ) : ?>
<meta property="og:description" content="<?php echo $description; ?>">
<?php endif; ?>
<meta name="description" content="<?php echo $description; ?>">
<?php if ( $keyword ) : ?>
<meta name="keywords" content="<?php echo $keyword; ?>">
<?php endif; ?>
<meta property="og:url" content="<?php echo $ogurl; ?>">
<?php if ( $ogimage ) : ?>
<meta property="og:image" content="<?php echo $ogimage; ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?php echo $site_name; ?>">
<meta property="og:locale" content="ja_JP">
<?php if ( $app_id ) : ?>
<meta property="fb:app_id" content="<?php echo $app_id; ?>">
<?php endif; ?>
<!-- / OGP and meta -->
<?php
}


