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
		'title' => __( 'Slide content', 'mak' ),
		'fields' => array (
			array (
				'key' => 'field_slide_post',
				'label' => __( 'Choise post', 'mak' ),
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
				'label' => __( 'Slide image', 'mak' ),
				'name' => 'slide_image',
				'type' => 'image',
				'instructions' => __( 'W: 700px H: 350px', 'mak' ), //。
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

	// Featured
	register_field_group(array (
		'id' => 'acf_featured',
		'title' => __( 'Featured content', 'mak' ),
		'fields' => array (
			array (
				'key' => ' field__is_posts',
				'label' => __( 'Use post', 'mak' ),
				'name' => '_is_posts',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field__select_post',
				'label' => __( 'Choise post', 'mak' ),
				'name' => '_select_post',
				'type' => 'relationship',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => ' field__is_posts',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
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
				'key' => 'field__thumbnail_id',
				'label' => __( 'Featured image', 'mak' ),
				'name' => '_thumbnail_id',
				'type' => 'image',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => ' field__is_posts',
							'operator' => '!=',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_other_link_url',
				'label' => __( 'Link URL', 'mak' ),
				'name' => '_other_link_url',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => ' field__is_posts',
							'operator' => '!=',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field__other_link_target',
				'label' => __( 'Link target', 'mak' ),
				'name' => '_other_link_target',
				'type' => 'true_false',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => ' field__is_posts',
							'operator' => '!=',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'message' => __( 'Open link in a new window/tab', 'mak' ),
				'default_value' => 0,
			),
			array (
				'key' => 'field__custom_content',
				'label' => __( 'Excerpt', 'mak' ),
				'name' => '_custom_content',
				'type' => 'textarea',
				'instructions' => __( 'Use the post if not filled out, gets more posts. It is useful if you want to explain properly.', 'mak' ),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'featured',
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
