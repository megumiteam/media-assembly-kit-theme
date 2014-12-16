<?php
/**
 * Name: Media Assembly Kit Induction Posts Parts
 * Description: Induction Posts Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_induction_posts( $args = array() ) {
	$posts   = array();
	$default = array(
		'posts_per_page' => -1,
		'post_parent'    => '',
		'post_type'      => 'induction',
		'orderby'        => 'menu_order',
		'ordery'         => 'ASC',
	);
	$default = apply_filters( 'mak_get_induction_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$posts   = get_posts( $args );
	return $posts;
}

function mak_induction_widgets() {
	register_widget( 'Mak_Widget_Induction' );
}
add_action( 'widgets_init', 'mak_induction_widgets' );

class Mak_Widget_Induction extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget-induction', 'description' => __( 'Induction Post Widget', 'mak' ) );
		parent::__construct( 'mak-induction', __( 'Induction post', 'mak' ), $widget_ops );
		$this->alt_option_name = 'mak_induction';
	}

	function widget( $args, $instance ) {
		extract($args);

		$args = wp_parse_args( $args, $instance );
		mak_induction_post_widget( $args, $instance );
	}

	function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['post_id'] = (int) $new_instance['post_id'];
		$instance['title']   = $new_instance['title'] ? apply_filters( 'the_title', $new_instance['title'] ) : apply_filters( 'the_title', get_the_title( $instance['post_id'] ) );

		return $instance;
	}

	function form( $instance ) {
		$title   = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_id = isset( $instance['post_id'] ) ? esc_attr( $instance['post_id'] ) : ''; ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e( 'Select a Page:', 'mak' ); ?></label>
			<?php
				$args = array(
					'orderby'          => 'ID',
					'depth'            => 1,
					'selected'         => $post_id,
					'name'             => $this->get_field_name( 'post_id' ),
					'id'               => $this->get_field_id( 'post_id' ),
					'show_option_none' => __( 'Select Page', 'mak' ),
					'post_type'        => 'induction',
				);
				wp_dropdown_pages( $args );
			?>
		</p>
<?php
	}
}

function mak_induction_post_widget( $args = array(), $instance  = array()) {
	echo mak_get_induction_post_widget( $args, $instance );
}
function mak_get_induction_post_widget( $args = array(), $instance  = array()) {
	$output    = '';
	$default = array(
		'before_widget' => '<aside class="widget-induction-posts">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
		'title'         => '',
		'post_id'       => '',
	);

	$default = apply_filters( 'mak_induction_post_list_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	if ( empty( $post_id ) )
		return;

	$args = array(
		'post_parent' => $post_id,
	);
	$posts = mak_get_induction_posts( $args );
	if ( empty( $posts ) )
		return;

	$title     = apply_filters( 'widget_title', $title, $instance );
	if ( is_child_theme() ) {
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
	$output .= '<ul>' . "\n";
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		$post_id        = $post->ID;
		$select_id      = get_field( 'select_post', $post_id );
		$select_id      = reset( $select_id );
		if ( 'publish' === get_post_status( $select_id ) ) {
			$title          = apply_filters( 'the_title', get_the_title( $post_id ) );
			$link           = esc_url( apply_filters( 'the_permalink', get_permalink( $select_id ) ) );
			$attachment_id  = get_post_thumbnail_id( $select_id ) ? get_post_thumbnail_id( $select_id ) : get_post_thumbnail_id( $post_id );
			$args           = array(
				'attachment_id' => $attachment_id,
				'size'          => $size,
				'width'         => $width,
				'height'        => $height,
				'src'           => 'http://placehold.it/' . $width . 'x' . $height,
				'link'          => false,
			);
			$image          = mak_get_entry_thumbnail( $args );
			$class          = $image ? ' class="thumbnail-true"' : '';
			$output .= '<li' . $class . '><a href="' . $link . '">' . "\n";
			$output .= $image . "\n";
			$output .= '<h2 class="title trunk8" data-lines="' . $lines . '">' . "\n";
			$output .= $title . "\n";
			$output .= '</h2>' . "\n";
			$output .= '</a></li>' . "\n";
		}
	}
	wp_reset_postdata();
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}

