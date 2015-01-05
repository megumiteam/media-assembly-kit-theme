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
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php do_action( 'mak_after_single_entry_header' ); ?>
		<?php mak_social_button(); ?>
		<div class="entry-meta">
			<?php mak_entry_data( array( 'before' => '<i class="fa fa-clock-o"></i>' ) ); ?>
			<?php mak_entry_terms( array( 'before' => '<i class="fa fa-folder-open-o"></i>' ) ); ?>
			<?php mak_entry_terms( array( 'term_name' => 'post_tag', 'before' => '<i class="fa fa-tags"></i>' ) ); ?>
			<?php mak_entry_author( array( 'size' => 20 ) ); ?>
			<?php mak_entry_pr(); ?>
		</div>
	</header><!-- .entry-header -->
	<section class="entry-content">
		<?php do_action( 'mak_before_single_entry_content' ); ?>
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php do_action( 'mak_after_single_entry_content' ); ?>
	</section><!-- .entry-content -->
	<footer class="entry-footer">
		<?php mak_content_nav(); ?>
		<?php mak_external_site(); ?>
		<?php mak_pickup(); ?>
		<?php mak_single_ad(); ?>
		<?php do_action( 'mak_single_entry_footer' ); ?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'mak_after_single_entry' ); ?>
</article><!-- #post-## -->
