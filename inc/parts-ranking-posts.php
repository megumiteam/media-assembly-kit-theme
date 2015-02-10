<?php
/**
 * Name: Media Assembly Kit Ranking Posts Parts
 * Description: Ranking Posts Parts
 * Author: DigitalCube Co., Ltd
 * Version: 0.1.0
 * @package Media Assembly Kit
**/
function mak_get_ranking_posts( $args = array() ) {
	if ( ! function_exists( 'sga_ranking_get_date' ) )
		return;

	$options = get_option( 'sga_ranking_options' );
	$period  = $options['period'];
	$ids     = array();
	$default = array(
		'display_count' => 10,
		'filter'        => 'pagePath=~^/summary/',
		'period'        => $period,
	);
	$default = apply_filters( 'mak_get_ranking_posts_default', $default );
	$args    = wp_parse_args( $args, $default );
	$ids     = sga_ranking_get_date( $args );
	return $ids;
}

function mak_ranking_widgets() {
	unregister_widget( 'WP_Widget_Simple_GA_Ranking' );
	register_widget( 'MAK_Widget_Ranking' );
}
add_action( 'widgets_init', 'mak_ranking_widgets' );

class MAK_Widget_Ranking extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget-ranking', 'description' => __( 'Ranking Widget', 'mak' ) );
		parent::__construct( 'mak-ranking', __( 'Ranking', 'mak' ), $widget_ops );
		$this->alt_option_name = 'mak-ranking';
	}

	function widget( $args, $instance ) {
		extract($args);

		$args = wp_parse_args( $args, $instance );
		mak_ranking_post_widget( $args, $instance );
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = isset( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 10;

		return $instance;
	}

	function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : __( 'Ranking', 'mak' );
		$limit      = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 10; ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Number to show:', 'mak' ); ?></label>
			<input id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" size="3" />
		</p>
<?php
	}
}

function mak_ranking_post_widget( $args = array(), $instance = array() ) {
	echo mak_get_ranking_post_widget( $args, $instance );
}
function mak_get_ranking_post_widget( $args = array(), $instance = array() ) {
	$output  = '';
	$default = array(
		'before_widget' => '<aside class="widget widget-ranking">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		'limit'         => 10,
		'title'         => __( 'Ranking', 'mak' ),
	);
	$default = apply_filters( 'mak_ranking_post_widget_default', $default );
	$args    = wp_parse_args( $args, $default );
	extract($args);

	if( is_category() ) {
		$cat = get_query_var( 'category_name' );
		$args = array(
			'display_count' => $limit,
			'category__in'  => $cat,
		);
	} elseif( is_single() ) {
		$cat = get_the_category();
		if ( is_array( $cat ) ) {
			$cat = reset( $cat );
			$cat = $cat->slug;
		}
		$args = array(
			'display_count' => $limit,
			'category__in'  => $cat,
		);
	} else {
		$args = array(
			'display_count' => $limit,
		);
	}
	$ids  = mak_get_ranking_posts( $args );
	$args = array(
		'display_count' => $limit,
		'period'        => 30,
	);
	$total_ids  = mak_get_ranking_posts( $args );

	if ( empty( $ids ) && empty( $total_ids ) )
		return;

	$title = apply_filters( 'widget_title', $title, $instance );
	if ( is_child_theme() ) {
		$lines = 2;
	} else {
		$lines = 2;
	}
	$count   = 1;
	$output .= $before_widget;
	$output .= $before_title . $title . $after_title;
/*
	$output .= '<nav id="ranking-nav">' . "\n";
	$output .= '<p class="current" data-target="for-you">' . __( 'For You', 'mak' ) . '</p>' . "\n";
	$output .= '<p data-target="total">' . __( 'Total', 'mak' ) . '</p>' . "\n";
	$output .= '</nav>' . "\n";
*/
/*
	$output .= '<ol id="for-you" class="current">' . "\n";
	foreach ( $ids as $id ) {
		$title = apply_filters( 'the_title', get_the_title( $id ) );
		$link  = esc_url( apply_filters( 'the_permalink', mak_get_summary_permalink( $id ) ) );
		$output .= '<li class="ranking-' . $count . '">' . "\n";
		$output .= '<a href="' . $link . '" class="trunk8" data-lines="' . $lines . '">' . $title . '</a>' . "\n";
		$output .= '</li>' . "\n";
		$count++;
	}
	$output .= '</ol>' . "\n";
*/
	$count   = 1;
	$output .= '<ol id="total">' . "\n";
	foreach ( $total_ids as $id ) {
		$title = apply_filters( 'the_title', get_the_title( $id ) );
		//$link  = esc_url( apply_filters( 'the_permalink', mak_get_summary_permalink( $id ) ) );
		$link    = esc_url( home_url( '/post/#!/' .  $id ) );
		$output .= '<li class="ranking-' . $count . '">' . "\n";
		$output .= '<a href="' . $link . '" class="trunk8" data-lines="' . $lines . '">' . $title . '</a>' . "\n";
		$output .= '</li>' . "\n";
		$count++;
	}
	$output .= '</ol>' . "\n";
	$output .= $after_widget;
	return $output;
}
