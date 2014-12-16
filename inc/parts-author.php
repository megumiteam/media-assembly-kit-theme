<?php
/**
 * Name: Media Assembly Kit Author Parts
 * Description: Author Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/

function mak_writer_widgets() {
	register_widget( 'Mak_Widget_Writer_List' );
}
add_action( 'widgets_init', 'mak_writer_widgets' );

class Mak_Widget_Writer_List extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'writer-list', 'description' => __( 'Writer Widget', 'mak' ) );
		parent::__construct( 'mak-writer-list', __( 'Writer', 'mak' ), $widget_ops );
		$this->alt_option_name = 'mak-writer-list';
	}

	function widget( $args, $instance ) {
		extract($args);

		$args = wp_parse_args( $args, $instance );
		mak_writer_list_widget( $args, $instance );
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = isset( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 3;
		$instance['rand']  = isset( $new_instance['rand'] ) ? true : false;

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'Writer', 'mak' );
		$limit = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 3;
		$rand  = isset( $instance['rand'] ) ? absint( $instance['rand'] ) : true;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number to show:', 'mak' ); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'rand' ); ?>"><?php _e( 'Random?', 'lar' ); ?></label>
			<input class="checkbox" type="checkbox" <?php checked( $rand ); ?> id="<?php echo $this->get_field_id( 'rand' ); ?>" name="<?php echo $this->get_field_name( 'rand' ); ?>" />
		</p>
<?php
	}
}

function mak_writer_list_widget( $args = array(), $instance  = array()) {
	echo mak_get_writer_list_widget( $args, $instance );
}
function mak_get_writer_list_widget( $args = array(), $instance  = array()) {
	$output  = '';
	if ( is_child_theme() ) {
		$width = 95;
	} else {
		$width = 70;
	}
	$default = array(
		'before_widget' => '<aside class="widget-writer-list">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title"><span>',
		'after_title'   => '</span></h1>',
		'title'         => __( 'Writer', 'mak' ),
		'limit'         => 3,
		'rand'          => true,
		'width'         => $width,
	);
	$default = apply_filters( 'mak_writer_list_widget_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$authors = mak_author_list_array( array( 'num' => $limit, 'rand' => $rand ) );

	if ( empty( $authors ) )
		return;

	$title   = apply_filters( 'widget_title', $title, $instance );
	$output .= $before_widget;
	$output .= $before_title . $title . $after_title;
	$output .= '<ul>' . "\n";
	foreach ( $authors as $author ) {
		$author_id     = $author['ID'];
		$author_link   = mak_get_author_link( $author_id );
		$author_name   = mak_get_author_name( $author_id );
		$author_avatar = mak_get_author_avatar( array( 'author_id' => $author_id, 'width' => $width ) );
		$author_desc   = mak_get_author_desc( array( 'author_id' => $author_id, 'excerpt' => true, ) );

		$output .= '<li>' . "\n";
		$output .= '<a href="' . $author_link . '" rel="author">' . "\n";
		$output .= '<p class="avatar thumbnail">' . $author_avatar . '</p>' . "\n";
		$output .= '<div class="author-data">' . "\n";
		$output .= '<p class="author-name">' . $author_name . '</p>' . "\n";
		if ( $author_desc )
			$output .= '<p class="author-desc">' . $author_desc . '</p>' . "\n";
		$output .= '</div>' . "\n";
		$output .= '</a>' . "\n";
		$output .= '</li>' . "\n";
	}
	$output .= '</ul>' . "\n";
	$output .= $after_widget;
	return $output;
}

function mak_author( $args = array() ) {
	echo mak_get_author( $args );
}
function mak_get_author( $args = array() ) {
	$default = array(
		'author_id' => get_the_author_meta( 'ID' ),
		'width'     => 70,
		'link'      => true,
	);
	$default = apply_filters( 'mak_author_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$author_link = mak_get_author_link( $author_id );
	$avatar      = mak_get_author_avatar( array( 'author_id' => $author_id, 'width' => $width ) );
	$name        = mak_get_author_name( $author_id );
	if ( $link ) {
		$output      = '<p class="author"><a href="' . $author_link . '" rel="author">' . $avatar . $name . '</a></p>' . "\n";
	} else {
		$output      = '<p class="author">' . $avatar . $name . '</p>' . "\n";
	}
	return $output;
}

function mak_author_link( $author_id = '' ) {
	echo mak_get_author_link( $author_id );
}
function mak_get_author_link( $author_id = '' ) {
	if ( empty( $author_id ) )
		$author_id = get_the_author_meta( 'ID' );

	$value = esc_url( get_author_posts_url( $author_id ) );
	return $value;
}

function mak_author_name( $author_id = '' ) {
	echo mak_get_author_name( $author_id );
}
function mak_get_author_name( $author_id = '' ) {
	if ( empty( $author_id ) )
		$author_id = get_the_author_meta( 'ID' );

	$value = get_the_author_meta( 'display_name', $author_id );
	return $value;
}

function mak_author_avatar( $args = array() ) {
	echo mak_get_author_avatar( $args );
}
function mak_get_author_avatar( $args = array() ) {
	$default = array(
		'author_id' => get_the_author_meta( 'ID' ),
		'width'     => 20,
	);
	$default = apply_filters( 'mak_author_avatar_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$value = get_avatar( $author_id, $width );
	return $value;
}

function mak_author_desc( $args = array() ) {
	echo mak_get_author_desc( $args );
}
function mak_get_author_desc( $args = array() ) {
	$default = array(
		'author_id' => get_the_author_meta( 'ID' ),
		'excerpt'   => false,
		'length'    => 100,
	);
	$default = apply_filters( 'mak_author_desc_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$value = get_the_author_meta( 'description', $author_id );

	if ( !$value )
		return;

	if ( $excerpt ) {
		$value = wp_trim_words( $value, $length );
	}

	return $value;
}

function mak_author_list_array( $args = array() ) {
	global $options_authors_defaults;
	$default = array(
		'num'  => 3,
		'rand' => true,
	);
	$default = apply_filters( 'mak_author_list_array_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	$users     = array();
	$users_obj = array();
	$roles     = get_option( 'writer_role', array( 'author' ) );
	if ( empty( $roles) )
		return;

	$roles_count = count( $roles );
	foreach ( $roles as $role ) {
		$args = array(
			'role'    => $role,
			'fields'  => array( 'ID', 'display_name' ),
			'orderby' => 'ID'
		);
		$results = get_users( $args );
		if ( $results )
			$users_obj = array_merge( $users_obj, $results );
	}
	foreach( $users_obj as $user ) {
		$user_id    = $user->ID;
		$post_count = count_user_posts( $user_id );
		$users[]    = array( 'ID' => $user_id, 'post_count' => $post_count );
	}
	if ( $roles_count > 1 ) {
		foreach ( $users as $key => $value ) {
			$users_id[$key] = $users[$key]['post_count'];
		}
		array_multisort( $users_id, SORT_DESC , $users );
	}
	if ( $rand )  {
		shuffle( $users );
	}
	if ( $num ) {
		$users = array_slice( $users, 0, $num );
	}
	return $users;
}
