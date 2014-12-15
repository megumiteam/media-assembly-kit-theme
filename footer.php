<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Media Assembly Kit
 */
?>

		<?php do_action( 'mak_after_content' ); ?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action( 'mak_before_footer' ); ?>
		<div class="site-info">
			<?php do_action( 'mak_footer' ); ?>
		</div><!-- .site-info -->
		<?php do_action( 'mak_after_footer' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php do_action( 'mak_after_body' ); ?>

<?php wp_footer(); ?>

</body>
</html>
