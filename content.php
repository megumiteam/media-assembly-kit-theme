<?php
/**
 * @package Media Assembly Kit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( mak_get_thumbnail_class() . ' archive-article' ); ?>>
	<?php do_action( 'mak_before_archive_entry' ); ?>
	<?php mak_entry_thumbnail(); ?>
	<header class="entry-header">
		<?php do_action( 'mak_before_archive_entry_header' ); ?>
		<?php mak_entry_terms( array( 'separator' => '', 'showcolor' => true, 'class' => ' color-cat' ) ); ?>
		<h1 class="entry-title"><a href="<?php mak_summary_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php mak_entry_terms( array( 'term_name' => 'media', 'separator' => '' ) ); ?>
		<?php mak_entry_data(); ?>
		<?php do_action( 'mak_after_archive_entry_header' ); ?>
	</header><!-- .entry-header -->
	<section class="entry-summary trunk8" data-lines="2">
		<?php do_action( 'mak_before_archive_entry_content' ); ?>
		<?php the_excerpt(); ?>
		<?php do_action( 'mak_after_archive_entry_content' ); ?>
	</section><!-- .entry-summary -->
	<?php if ( has_action( 'mak_archive_entry_footer' ) ) : ?>
		<footer class="entry-footer">
			<?php do_action( 'mak_archive_entry_footer' ); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
	<?php do_action( 'mak_after_archive_entry' ); ?>
</article><!-- #post-## -->
