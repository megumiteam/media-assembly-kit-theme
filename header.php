<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Media Assembly Kit
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'mak_before_body' ); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'mak_before_page' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<?php do_action( 'mak_before_header' ); ?>
		<?php mak_media_nav(); ?>
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php do_action( 'mak_after_header' ); ?>
	</header><!-- #masthead -->
	<?php mak_slide_post_list(); ?>
	<?php mak_global_nav(); ?>
	<?php mak_carousel_post_list(); ?>
	<?php mak_khm_15(); ?>
	<?php do_action( 'mak_header_content' ); ?>
	<div id="content" class="site-content">
		<?php do_action( 'mak_before_content' ); ?>
