<?php
/**
 * Name: Media Assembly Kit Management Theme Options
 * Description: Management Theme Options
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

// Admin
function mak_admin_theme_options_scripts() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'theme-options-style', get_template_directory_uri() . '/css/theme-options.css', array(), mak_file_time_stamp( '/css/theme-options.css' ) );

	wp_enqueue_media();
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'admin', get_template_directory_uri() . '/admin_js/admin.js', array('jquery'), mak_file_time_stamp( '/admin_js/admin.js' ), true );
	wp_enqueue_script( 'theme-options-scrip', get_template_directory_uri() . '/admin_js/theme-options.js', array( 'jquery' ), mak_file_time_stamp( '/admin_js/theme-options.js' ), false );
}

function mak_theme_options_admin_menu() {
	$hook = add_theme_page( __( 'Theme Options', 'mak' ), __( 'Theme Options', 'mak' ), 'edit_users', 'theme-options', 'mak_options_page' );
	add_action( 'admin_print_scripts-' . $hook, 'mak_admin_theme_options_scripts', 999 );
}
add_action( 'admin_menu', 'mak_theme_options_admin_menu' );

function mak_theme_options_admin_bar_menu( $wp_admin_bar ){
	$title = __( 'Theme Options', 'mak' );
	$wp_admin_bar->add_menu( array(
		'id'    => 'theme-options',
		'meta'  => array(),
		'title' => $title,
		'href'  => admin_url( 'themes.php?page=theme-options' ),
	) );
}
add_action( 'admin_bar_menu', 'mak_theme_options_admin_bar_menu', 9999 );

function mak_options_page() {
	global $wp_settings_fields;
	$title = __( 'Theme Options', 'mak' );
	echo '<div class="wrap" id="theme-options">' . "\n";
	screen_icon();
	echo '<h2>' . esc_html( $title ) . '</h2>' . "\n";
	echo '<form method="post" action="options.php">' . "\n";
	settings_fields( 'mak_theme_options' );
	do_settings_sections( 'mak_theme_options' );
	submit_button();
	echo '</form>' . "\n";
	echo '</div>' . "\n";
}

function mak_theme_options_fields() {
	if( ! function_exists( 'get_editable_roles' ) ) {
		require_once( ABSPATH . '/wp-admin/includes/user.php' );
	}

	// General
	add_settings_section(
		'general',
		__( 'General', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'home_posts_per_page',
		__( 'HOME pages show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'home_posts_per_page',
			'default' => 10,
		)
	);
	add_settings_field(
		'posts_per_page',
		__( 'Blog pages show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'posts_per_page',
			'default' => 20,
		)
	);
	add_settings_field(
		'mobile_posts_per_page',
		__( 'Mobile Blog pages show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'mobile_posts_per_page',
			'default' => 12,
		)
	);
	add_settings_field(
		'slide_posts_per_page',
		__( 'Slide show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'slide_posts_per_page',
			'default' => 5,
		)
	);
	add_settings_field(
		'slide_speed',
		__( 'Slide Speed', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'slide_speed',
			'default' => 1500,
		)
	);
	add_settings_field(
		'slide_pause',
		__( 'Slide Pause', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'slide_pause',
			'default' => 6000,
		)
	);
	add_settings_field(
		'related_posts_per_page',
		__( 'Related Posts show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'related_posts_per_page',
			'default' => 8,
		)
	);
	add_settings_field(
		'mobile_related_posts_per_page',
		__( 'Mobile Related Posts show at most', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'mobile_related_posts_per_page',
			'default' => 3,
		)
	);
	add_settings_field(
		'ad_posts_number',
		__( 'PC Halfway Number', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'ad_posts_number',
			'default' => 10,
		)
	);
	add_settings_field(
		'ad_mobile_posts_number',
		__( 'Mobile Halfway Number', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'general',
		array(
			'name'    => 'ad_mobile_posts_number',
			'default' => 7,
		)
	);

	// Site Settings
	add_settings_section(
		'siteoption',
		__( 'Site Settings', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'favicon_image',
		__( 'Favicon Image', 'mak' ),
		'mak_image_field',
		'mak_theme_options',
		'siteoption',
		array(
			'id'   => 'favicon-image',
			'name' => 'favicon_image',
		)
	);
	add_settings_field(
		'apple_touch_icon_image',
		__( 'apple-touch-icon Image', 'mak' ),
		'mak_image_field',
		'mak_theme_options',
		'siteoption',
		array(
			'id'   => 'apple-touch-icon-image',
			'name' => 'apple_touch_icon_image',
		)
	);
	add_settings_field(
		'google_analytics_code',
		__( 'Google Analytics Code', 'mak' ),
		'mak_textarea_field',
		'mak_theme_options',
		'siteoption',
		array(
			'id'   => 'google-analytics-code',
			'name' => 'google_analytics_code',
		)
	);

	// Background
	add_settings_section(
		'background',
		__( 'PC Background', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'background_image',
		__( 'Background Image', 'mak' ),
		'mak_image_field',
		'mak_theme_options',
		'background',
		array(
			'id'   => 'background-image',
			'name' => 'background_image',
		)
	);
	add_settings_field(
		'background_color',
		__( 'Background Color', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'background',
		array(
			'class' => 'small-text color-picker',
			'name'  => 'background_color',
		)
	);
	add_settings_field(
		'background_repeat',
		__( 'Background Repeat', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background',
		array(
			'name'   => 'background_repeat',
			'option' => array(
				'no-repeat' => __( 'No Repeat', 'mak' ),
				'repeat-x'  => __( 'Repeat Horizontally', 'mak' ),
				'repeat-y'  => __( 'Repeat Vertically', 'mak' ),
				'repeat'    => __( 'Repeat All', 'mak' ),
			)
		)
	);
	add_settings_field(
		'background_position',
		__( 'Background Position', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background',
		array(
			'name'   => 'background_position',
			'option' => array(
				'top left'      => __( 'Top Left', 'mak' ),
				'top center'    => __( 'Top Center', 'mak' ),
				'top right'     => __( 'Top Right', 'mak' ),
				'middle left'   => __( 'Middle Left', 'mak' ),
				'middle center' => __( 'Middle Center', 'mak' ),
				'middle right'  => __( 'Middle Right', 'mak' ),
				'bottom left'   => __( 'Bottom Left', 'mak' ),
				'bottom center' => __( 'Bottom Center', 'mak' ),
				'bottom right'  => __( 'Bottom Right', 'mak' ),
			)
		)
	);
	add_settings_field(
		'background_attachment',
		__( 'Background Attachment', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background',
		array(
			'name'   => 'background_attachment',
			'option' => array(
				'scroll' => __( 'Scroll Normally', 'mak' ),
				'fixed'  => __( 'Fixed in Place', 'mak' ),
			)
		)
	);
	add_settings_field(
		'background_link',
		__( 'Background Link URL', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'background',
		array(
			'class' => 'regular-text',
			'name'   => 'background_link',
		)
	);
	add_settings_field(
		'background_target',
		__( 'Background Link Target', 'mak' ),
		'mak_check_field',
		'mak_theme_options',
		'background',
		array(
			'class' => 'regular-text',
			'name'  => 'background_target',
			'desc'  => 'Open link in a new window/tab',
		)
	);

	// Background mobile
	add_settings_section(
		'background_mobile',
		__( 'Mobile Background', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'background_image_mobile',
		__( 'Background Image', 'mak' ),
		'mak_image_field',
		'mak_theme_options',
		'background_mobile',
		array(
			'id'   => 'background-image-mobile',
			'name' => 'background_image_mobile',
		)
	);
	add_settings_field(
		'background_color_mobile',
		__( 'Background Color', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'background_mobile',
		array(
			'class' => 'small-text color-picker',
			'name'  => 'background_color',
		)
	);
	add_settings_field(
		'background_repeat_mobile',
		__( 'Background Repeat', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background_mobile',
		array(
			'name'   => 'background_repeat_mobile',
			'option' => array(
				'no-repeat' => __( 'No Repeat', 'mak' ),
				'repeat-x'  => __( 'Repeat Horizontally', 'mak' ),
				'repeat-y'  => __( 'Repeat Vertically', 'mak' ),
				'repeat'    => __( 'Repeat All', 'mak' ),
			)
		)
	);
	add_settings_field(
		'background_position_mobile',
		__( 'Background Position', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background_mobile',
		array(
			'name'   => 'background_position_mobile',
			'option' => array(
				'top left'      => __( 'Top Left', 'mak' ),
				'top center'    => __( 'Top Center', 'mak' ),
				'top right'     => __( 'Top Right', 'mak' ),
				'middle left'   => __( 'Middle Left', 'mak' ),
				'middle center' => __( 'Middle Center', 'mak' ),
				'middle right'  => __( 'Middle Right', 'mak' ),
				'bottom left'   => __( 'Bottom Left', 'mak' ),
				'bottom center' => __( 'Bottom Center', 'mak' ),
				'bottom right'  => __( 'Bottom Right', 'mak' ),
			)
		)
	);
	add_settings_field(
		'background_attachment_mobile',
		__( 'Background Attachment', 'mak' ),
		'mak_select_field',
		'mak_theme_options',
		'background_mobile',
		array(
			'name'   => 'background_attachment_mobile',
			'option' => array(
				'scroll' => __( 'Scroll Normally', 'mak' ),
				'fixed'  => __( 'Fixed in Place', 'mak' ),
			)
		)
	);

	// Social
	add_settings_section(
		'social',
		__( 'Social', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'twitter_url',
		__( 'Twitter URL', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'twitter_url',
		)
	);
	add_settings_field(
		'twitter_via',
		__( 'Twitter via', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'twitter_via',
		)
	);
	add_settings_field(
		'facebook_url',
		__( 'Facebook URL', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'facebook_url',
		)
	);
	add_settings_field(
		'youtube_url',
		__( 'YouTube URL', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'youtube_url',
		)
	);
	add_settings_field(
		'pinterest_url',
		__( 'Pinterest URL', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'pinterest_url',
		)
	);
	add_settings_field(
		'ogp_appid',
		__( 'appId', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'ogp_appid',
		)
	);
	add_settings_field(
		'ogp_title',
		__( 'OGP Title', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name'    => 'ogp_title',
			'default' => get_bloginfo( 'name' ),
		)
	);
	add_settings_field(
		'ogp_description',
		__( 'OGP Description', 'mak' ),
		'mak_textarea_field',
		'mak_theme_options',
		'social',
		array(
			'name'    => 'ogp_description',
			'default' => get_bloginfo( 'description' ),
		)
	);
	add_settings_field(
		'ogp_keyword',
		__( 'OGP Keyword', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'social',
		array(
			'class' => 'regular-text',
			'name' => 'ogp_keyword',
		)
	);
	add_settings_field(
		'ogp_image',
		__( 'OGP Image', 'mak' ),
		'mak_image_field',
		'mak_theme_options',
		'social',
		array(
			'name' => 'ogp_image',
			'id'   => 'ogp-image',
		)
	);

	// Category
	add_settings_section(
		'category',
		__( 'Category', 'mak' ),
		'',
		'mak_theme_options'
	);
	$categories = mak_options_categories( array(), array( 'child' => false ) );
	foreach ( $categories as $category ) {
		$term_id  = $category['term_id'];
		$name     = $category['name'];
		$slug     = $category['slug'];

		add_settings_field(
			'cat_' . $term_id . '_color',
			sprintf( __( '%s Category Color', 'mak' ), $name ),
			'mak_text_field',
			'mak_theme_options',
			'category',
			array(
				'class' => 'small-text color-picker',
				'name' => 'cat_' . $term_id . '_color',
			)
		);
	}

	// Other
	add_settings_section(
		'other',
		__( 'Other', 'mak' ),
		'',
		'mak_theme_options'
	);
	add_settings_field(
		'copyright',
		__( 'Copyright', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'other',
		array(
			'class' => 'regular-text',
			'name'    => 'copyright',
			'default' => '&copy; Your Corp. [year] All rights reserved. No reproduction or republication without written permission.',
		)
	);
	add_settings_field(
		'mobile_copyright',
		__( 'Mobile Copyright', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'other',
		array(
			'class' => 'regular-text',
			'name'    => 'mobile_copyright',
			'default' => '&copy; Your Corp. [year] All rights reserved.',
		)
	);
	add_settings_field(
		'copyright_year',
		__( 'Copyright Year', 'mak' ),
		'mak_text_field',
		'mak_theme_options',
		'other',
		array(
			'name'    => 'copyright_year',
			'default' => '2014',
		)
	);
}
add_action( 'admin_init', 'mak_theme_options_fields' );

function mak_register_setting() {
	// General
	register_setting( 'mak_theme_options', 'home_posts_per_page', 'intval' );
	register_setting( 'mak_theme_options', 'posts_per_page', 'intval' );
	register_setting( 'mak_theme_options', 'mobile_posts_per_page', 'intval' );
	register_setting( 'mak_theme_options', 'slide_posts_per_page', 'intval' );
	register_setting( 'mak_theme_options', 'slide_speed', 'intval' );
	register_setting( 'mak_theme_options', 'slide_pause', 'intval' );
	register_setting( 'mak_theme_options', 'related_posts_per_page', 'mak_related_per' );
	register_setting( 'mak_theme_options', 'mobile_related_posts_per_page', 'mak_related_per' );
	register_setting( 'mak_theme_options', 'ad_posts_number', 'intval' );
	register_setting( 'mak_theme_options', 'ad_mobile_posts_number', 'intval' );

	// Site Settings
	register_setting( 'mak_theme_options', 'favicon_image', 'intval' );
	register_setting( 'mak_theme_options', 'apple_touch_icon_image', 'intval' );
	register_setting( 'mak_theme_options', 'google_analytics_code' );

	// Background
	register_setting( 'mak_theme_options', 'background_image', 'intval' );
	register_setting( 'mak_theme_options', 'background_color', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_repeat', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_position', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_attachment', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_link', 'esc_url' );
	register_setting( 'mak_theme_options', 'background_target', 'intval' );

	// Background mobile
	register_setting( 'mak_theme_options', 'background_image_mobile', 'intval' );
	register_setting( 'mak_theme_options', 'background_color_mobile', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_repeat_mobile', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_position_mobile', 'esc_attr' );
	register_setting( 'mak_theme_options', 'background_attachment_mobile', 'esc_attr' );

	// Social
	register_setting( 'mak_theme_options', 'twitter_url', 'esc_url' );
	register_setting( 'mak_theme_options', 'twitter_via', 'esc_attr' );
	register_setting( 'mak_theme_options', 'facebook_url', 'esc_url' );
	register_setting( 'mak_theme_options', 'youtube_url', 'esc_url' );
	register_setting( 'mak_theme_options', 'pinterest_url', 'esc_url' );
	register_setting( 'mak_theme_options', 'ogp_appid', 'esc_attr' );
	register_setting( 'mak_theme_options', 'ogp_title', 'esc_html' );
	register_setting( 'mak_theme_options', 'ogp_description', 'esc_textarea' );
	register_setting( 'mak_theme_options', 'ogp_keyword', 'esc_attr' );
	register_setting( 'mak_theme_options', 'ogp_image', 'intval' );

	// Category
	$categories = mak_options_categories( array(), array( 'child' => false ) );
	foreach ( $categories as $category ) {
		$term_id  = $category['term_id'];
		$name     = $category['name'];
		$slug     = $category['slug'];
		register_setting( 'mak_theme_options', 'cat_' . $term_id . '_color', 'esc_attr' );
	}

	// Other
	register_setting( 'mak_theme_options', 'copyright', 'esc_html' );
	register_setting( 'mak_theme_options', 'mobile_copyright', 'esc_html' );
	register_setting( 'mak_theme_options', 'copyright_year', 'intval' );
}
add_filter( 'admin_init', 'mak_register_setting' );

function mak_related_per( $value ) {
	$sirp_options                = get_option( 'sirp_options' );
	$sirp_options['display_num'] = (int) $value;
	update_option('sirp_options', $sirp_options);
	return $value;
}
