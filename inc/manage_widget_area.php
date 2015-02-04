<?php
/**
 * Name: Media Assembly Kit Management Widget Area
 * Description: Management Widget Area
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'PC Sideber', 'mak' ),
		'id'            => 'sidebar-pc',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title"><span>',
		'after_title'   => '</span></h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Mobile', 'mak' ),
		'id'            => 'sidebar-mobile',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title"><span>',
		'after_title'   => '</span></h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Mobile Single', 'mak' ),
		'id'            => 'sidebar-mobile-single',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1 class="widget-title"><span>',
		'after_title'   => '</span></h1>',
	) );

}
add_action( 'widgets_init', 'mak_widgets_init' );
