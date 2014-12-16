<?php
/**
 * @package Media Assembly Kit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
	<?php do_action( 'mak_before_single_entry' ); ?>
	<header class="entry-header">
		<?php do_action( 'mak_before_single_entry_header' ); ?>
		<?php mak_entry_terms( array( 'term_name' => 'media', 'before' => '<i class="fa fa-caret-right"></i>' ) ); ?>
		<?php mak_media_logo(); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php do_action( 'mak_after_single_entry_header' ); ?>
		<?php mak_social_button(); ?>
		<div class="entry-meta">
			<?php mak_entry_data( array( 'before' => '<i class="fa fa-clock-o"></i>' ) ); ?>
			<?php mak_entry_terms( array( 'before' => '<i class="fa fa-folder-open-o"></i>' ) ); ?>
			<?php mak_entry_terms( array( 'term_name' => 'post_tag', 'before' => '<i class="fa fa-tags"></i>' ) ); ?>
		</div>
	</header><!-- .entry-header -->
	<section class="entry-content">
		<?php do_action( 'mak_before_single_entry_content' ); ?>
		<?php mak_entry_thumbnail( array( 'size' => 'square-218-image', 'lightbox' => true ) ); ?>
		<?php summary_the_content( __( 'Read the full story', 'mak' ) ); ?>
		<?php mak_more_link(); ?>
		<?php do_action( 'mak_after_single_entry_content' ); ?>
	</section><!-- .entry-content -->
	<footer class="entry-footer">
		<?php mak_pickup(); ?>
		<?php mak_summary_ad(); ?>
		<?php do_action( 'mak_single_entry_footer' ); ?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'mak_after_single_entry' ); ?>
</article><!-- #post-## -->
