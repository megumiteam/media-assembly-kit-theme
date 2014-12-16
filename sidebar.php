<?php
/**
 * The sidebar containing the main widget areas.
 *
 * @package Media Assembly Kit
 */
?>
<?php if ( has_action( 'mak_secondary' ) ) : ?>
	<aside id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'mak_secondary' ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>
