<?php
/**
 * Name: Media Assembly Kit Editor's Choice Parts
 * Description: Editor's Choice Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_editor_choice_posts( $args = array() ) {
	$posts   = array();
	if ( ! is_child_theme() ) {
		$limit = get_option( 'editor_posts_per_page', 6 );
	} else {
		$limit = get_option( 'mobile_editor_posts_per_page', 4 );
	}
	$categories  = mak_options_categories( array(), array( 'child' => false ) );
	$include_cat = array();
	foreach ( $categories as $category ) {
		$term_id  = $category['term_id'];
		$view     = get_option( 'cat_' . $term_id . '_view_choice' );
		if ( 1 == $view ) {
			array_push( $include_cat, $term_id );
		}
	}
	$default = array(
		'posts_per_page' => $limit,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $include_cat,
				'operator' => 'IN',
			)
		)
	);
	$default = apply_filters( 'mak_slide_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_editor_widgets() {
	register_widget( 'Mak_Widget_Editor_List' );
}
add_action( 'widgets_init', 'mak_editor_widgets' );

class Mak_Widget_Editor_List extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'editor-choice-widget', 'description' => __( 'Editor\'s Choice Widget', 'mak' ) );
		parent::__construct( 'mak-editor-choice', __( 'Editor\'s Choice', 'mak' ), $widget_ops );
		$this->alt_option_name = 'mak-editor-choice';
	}

	function widget( $args, $instance ) {
		extract($args);

		$args = wp_parse_args( $args, $instance );
		mak_editor_choice( $args, $instance );
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = isset( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 5;

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'Editor\'s Choice', 'mak' );
		$limit = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number to show:', 'mak' ); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" />
		</p>
<?php
	}
}

function mak_editor_choice( $args = array(), $instance = array() ) {
	echo mak_get_editor_choice( $args, $instance );
}
function mak_get_editor_choice( $args = array(), $instance = array(), $device = 'pc' ) {
	$output  = '';
	if ( is_child_theme() || $device == 'mobile' ) {
		$limit = get_option( 'mobile_editor_posts_per_page', 5 );
	} else {
		$limit = get_option( 'editor_posts_per_page', 6 );
	}
	$default = array(
		'before_widget' => '<aside id="editor-choice-box">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title"><span>',
		'after_title'   => '</span></h1>',
		'title'         => __( 'Editor\'s Choice', 'mak' ),
		'limit'         => $limit,
		'speed'         => get_option( 'editor_choice_speed', 1500 ),
		'pause'         => get_option( 'editor_choice_pause', 6000 ),
	);
	$default = apply_filters( 'mak_editor_choice_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$args = array(
		'posts_per_page' => $limit,
	);
	$posts = mak_get_editor_choice_posts( $args );
	if ( empty( $posts ) )
		return;

	if ( is_child_theme() || $device == 'mobile' ) {
		$size   = 'mobile-thumbnail';
		$width  = 190;
		$height = 200;
		$lines  = 3;
	} else {
		$size   = 'square-100-image';
		$width  = 100;
		$height = 70;
		$lines  = 3;
	}
	$output .= $before_widget;
	$output .= $before_title . $title . $after_title;

	$output .= '<ul id="editor-choice" data-speed="' . $speed . '" data-pause="' . $pause . '">' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$title          = apply_filters( 'the_title', get_the_title( $post_id ) );
		$link           = esc_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) );
		$attachment_id = get_post_thumbnail_id( $post_id );
		$args = array(
			'id'     => $post_id,
			'size'   => $size,
			'width'  => $width,
			'height' => $height,
			'src'    => 'http://placehold.it/' . $width . 'x' . $height,
			'link'   => false,
		);
		$image   = mak_get_entry_thumbnail( $args );
		$class   = ! empty( $image ) ? 'thumbnail-true' : 'thumbnail-false';
		$output .= '<li class="' . $class . '"><a href="' . $link . '">'
		. $image . "\n"
		. '<h2 class="title trunk8" data-lines="' . $lines . '">' . "\n"
		. $title . "\n"
		. '</h2>' . "\n"
		. '</a></li>' . "\n";
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}
