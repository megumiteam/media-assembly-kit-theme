<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Media Assembly Kit
 */
?>

<section class="no-results not-found">
	<?php do_action( 'mak_before_no_results' ); ?>
	<header class="page-header">
		<h1 class="entry-title"><?php _e( 'Not Found', 'mak' ); ?></h1>
	</header><!-- .page-header -->
	<div class="page-content">
		<?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'mak' ); ?>
		<?php get_search_form(); ?>
	</div><!-- .page-summary -->
	<?php if ( has_action( 'mak_no_results_meta' ) ) : ?>
		<footer class="page-meta">
			<?php do_action( 'mak_no_results_meta' ); ?>
		</footer><!-- .page-meta -->
	<?php endif; ?>
	<?php do_action( 'mak_after_no_results' ); ?>
</section><!-- .no-results -->
