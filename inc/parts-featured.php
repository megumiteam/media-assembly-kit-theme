<?php
/**
 * Name: Media Assembly Kit Featured Parts
 * Description: Featured Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_featured_posts( $args = array() ) {
	$posts   = array();
	$default = array(
		'posts_per_page' => 4,
		'post_parent'    => '',
		'post_type'      => 'featured',
		'orderby'        => 'menu_order',
		'ordery'         => 'ASC',
	);
	$default = apply_filters( 'mak_get_featured_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}
function mak_featured_widgets() {
	register_widget( 'Mak_Widget_Featured' );
}
add_action( 'widgets_init', 'mak_featured_widgets' );
class Mak_Widget_Featured extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'widget-featured', 'description' => __( 'Featured Post Widget', 'mak') );
		parent::__construct( 'mak-featured', __( 'Featured post', 'mak'), $widget_ops );
		$this->alt_option_name = 'mak_featured';
	}
	function widget( $args, $instance ) {
		extract($args);
		$args = wp_parse_args( $args, $instance );
		mak_featured_post_widget( $args, $instance );
	}
	function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['post_id'] = (int) $new_instance['post_id'];
		$instance['title']   = apply_filters( 'the_title', get_the_title( $instance['post_id'] ) );
		$instance['limit']   = isset( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 4;
		return $instance;
	}
	function form( $instance ) {
		$title   = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_id = isset( $instance['post_id'] ) ? esc_attr( $instance['post_id'] ) : '';
		$limit   = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 4; ?>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="hidden" value="<?php echo $title; ?>" />
		<p><label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e( 'Select a Page:', 'mak'); ?></label>
			<?php
				$args = array(
					'orderby'          => 'ID',
					'depth'            => 1,
					'selected'         => $post_id,
					'name'             => $this->get_field_name( 'post_id' ),
					'id'               => $this->get_field_id( 'post_id' ),
					'show_option_none' => __( 'Select Page', 'mak'),
					'post_type'        => 'featured',
				);
				wp_dropdown_pages( $args );
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number to show:', 'mak'); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" />
		</p>
<?php
	}
}
function mak_featured_post_widget( $args = array(), $instance  = array()) {
	echo mak_get_featured_post_widget( $args, $instance );
}
function mak_get_featured_post_widget( $args = array(), $instance  = array()) {
	$output    = '';
	$default = array(
		'before_widget' => '<aside class="widget-featured">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		'title'         => '',
		'limit'         => 4,
		'post_id'       => '',
		'before'        => '<i class="fa fa-arrow-circle-right"></i>',
		'after'         => '',
	);
	$default = apply_filters( 'mak_featured_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);
	if ( empty( $post_id ) )
		return;
	$args = array(
		'posts_per_page' => $limit,
		'post_parent'    => $post_id,
	);
	$posts = mak_get_featured_posts( $args );
	if ( empty( $posts ) )
		return;
	$title  = apply_filters( 'widget_title', $title, $instance );
	$size   = 'square-90-image';
	$width  = 90;
	$height = 90;

	$output .= $before_widget;
	$output .= $before_title . $title . $after_title;
	$output .= '<ul id="featured-list">' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id = $post->ID;
		$target  = '';

		if ( get_field( '_is_posts', $post_id ) ) {
			$post_id = get_field( '_select_post', $post_id );
			$post_id = reset( $post_id );
			$link    = get_permalink( $post_id );
		} else {
			$link   = get_field( '_other_link_url', $post_id );
			$target = get_field( '_other_link_target', $post_id );
		}
		$title         = apply_filters( 'the_title', get_the_title( $post_id ) );
		$link          = esc_url( apply_filters( 'the_permalink', $link ) );
		$target        = $target ? ' target="_blank"': '';
		$attachment_id = get_post_thumbnail_id( $post_id ) ? get_post_thumbnail_id( $post_id ) : 0;
		$args = array(
			'attachment_id' => $attachment_id,
			'size'          => $size,
			'width'         => $width,
			'height'        => $height,
			'src'           => "http://placehold.it/{$width}x{$height}&text=no Image",
			'html'          => false,
		);
		$image   = mak_get_entry_thumbnail( $args );
		if ( is_child_theme() ) {
			$output .= '<li><a href="' . $link . '"' . $target . ' class="clear">' . "\n"
			. '<h3 class="mak-featured-title title">' . $before . $title . $after . '</h3>' . "\n"
			. '<p class="thumbnail">' . $image . '</p>' . "\n"
			. '</a></li>' . "\n";
		} else {
			$output .= '<li>'
			. '<h3 class="mak-featured-title title">' . $before . '<a href="' . $link . '"' . $target . '>' . $title . '</a>' . $after . '</h3>' . "\n"
			. '<p class="thumbnail"><a href="' . $link . '"' . $target . '>' . $image . '</a></p>' . "\n"
			. '</li>' . "\n";
		}
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}
