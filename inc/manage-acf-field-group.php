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

	// Carousel Panel
	register_field_group(array (
		'id' => 'acf_carousel',
		'title' => 'カルーセルパネルコンテンツ',
		'fields' => array (
			array (
				'key' => 'field_carousel_post',
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
				'key' => 'field_carousel_image',
				'label' => 'カルーセルパネルイメージ',
				'name' => 'carousel_image',
				'type' => 'image',
				'instructions' => '100x70 の大きさで上げて下さい。',
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
					'value' => 'carousel-panel',
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

	// Induction frame
	register_field_group(array (
		'id' => 'acf_induction',
		'title' => '誘導枠コンテンツ追加',
		'fields' => array (
			array (
				'key' => 'field_induction_post',
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
				)
			),
			array (
				'key' => 'field_induction_thumbnail',
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
					'value' => 'induction',
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

	// Category Induction frame
	$categories = mak_options_categories( array(), array( 'child' => false ) );
	foreach ( $categories as $category ) {
		$term_id = $category['term_id'];
		$name    = $category['name'];
		$slug    = $category['slug'];
		$title   = sprintf( __( 'Add %s Contents', 'mak' ), $name );
		$view    = get_option( 'cat_' . $term_id . '_view_induction', true );
		if ( ! empty( $view ) ) {
			register_field_group(array (
				'id'     => 'acf_' . $slug,
				'title'  => $title,
				'fields' => array (
					array (
						'key'             => 'field_select_post_' . $term_id,
						'label'           => '投稿を選択',
						'name'            => 'select_post',
						'type'            => 'relationship',
						'return_format'   => 'id',
						'post_type'       => array (
							0 => 'post',
						),
						'taxonomy'        => array (
							0 => 'category:' . $term_id,
						),
						'filters'         => array (
							0 => 'search',
						),
						'result_elements' => array (
							0 => 'featured_image',
							1 => 'post_title',
						),
						'max'             => 1,
					),
					array (
						'key'          => 'field_thumbnail_' . $term_id,
						'label'        => '画像',
						'name'         => '_thumbnail_id',
						'type'         => 'image',
						'save_format'  => 'id',
						'preview_size' => 'thumbnail',
						'library'      => 'uploadedTo',
					),
				),
				'location' => array (
					array (
						array (
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'cat-' . $term_id . '-induction',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position'       => 'normal',
					'layout'         => 'default',
					'hide_on_screen' => array (
					),
				),
				'menu_order' => 0,
			));
		}
	}

	// External site
	register_field_group(array (
		'id' => 'acf_external_site',
		'title' => '外部サイト',
		'fields' => array (
			array (
				'key' => 'field_external_repeater',
				'label' => 'サイト',
				'name' => 'external_site',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_external_title',
						'label' => 'サイト名',
						'name' => 'site_neme',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_external_url',
						'label' => 'サイト URL',
						'name' => 'site_url',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'サイトを追加',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
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

	// Related lin
	register_field_group(array (
		'id' => 'acf_related_link',
		'title' => '自社媒体リンク',
		'fields' => array (
			array (
				'key' => 'field_related_url',
				'label' => 'サイト URL',
				'name' => 'site_url',
				'type' => 'text',
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_related_target',
				'label' => '投稿を選択',
				'name' => 'site_target',
				'type' => 'true_false',
				'message' => 'リンクを新ウィンドウまたはタブで開く',
				'default_value' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'related-menu',
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
