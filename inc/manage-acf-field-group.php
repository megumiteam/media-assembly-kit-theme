<?php
/**
 * Name: Media Assembly Kit Management Field Group
 * Description: Management Field Group
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
if ( function_exists( 'register_field_group' ) && function_exists('mak_options_categories') ) {

	// Slide
	register_field_group(array (
		'id' => 'acf_slide',
		'title' => 'スライドコンテンツ',
		'fields' => array (
			array (
				'key' => 'field_slide_post',
				'label' => '投稿を選択',
				'name' => 'select_post',
				'type' => 'relationship',
				'return_format' => 'id',
				'post_type' => array (
					0 => 'post',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_title',
				),
				'max' => 1,
			),
			array (
				'key' => 'field_slide_image',
				'label' => 'スライドイメージ',
				'name' => 'slide_image',
				'type' => 'image',
				'instructions' => '700x350 の大きさで上げて下さい。',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slide',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	// Pickup
	register_field_group(array (
		'id' => 'acf_pickup',
		'title' => 'ピックアップコンテンツ追加',
		'fields' => array (
			array (
				'key' => 'field_pickup_post',
				'label' => '投稿を選択',
				'name' => 'select_post',
				'type' => 'relationship',
				'return_format' => 'id',
				'post_type' => array (
					0 => 'post',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_title',
				),
				'max' => 1,
			),
			array (
				'key' => 'field_pickup_thumbnail',
				'label' => '画像',
				'name' => '_thumbnail_id',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'pickup',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));


}
