<?php
/**
 * The sidebar containing the main widget areas.
 *
 * @package Media Assembly Kit
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'mak_before_secondary' ); ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php do_action( 'mak_after_secondary' ); ?>
</div><!-- #secondary -->
