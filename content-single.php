<?php
/**
 * @package Media Assembly Kit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
	<?php do_action( 'mak_before_single_entry' ); ?>
	<header class="entry-header">
		<?php do_action( 'mak_before_single_entry_header' ); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
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
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php do_action( 'mak_after_single_entry_content' ); ?>
	</section><!-- .entry-content -->
	<footer class="entry-footer">
		<?php mak_social_share(); ?>
		<?php do_action( 'mak_single_entry_footer' ); ?>
	</footer><!-- .entry-footer -->
	<?php do_action( 'mak_after_single_entry' ); ?>
</article><!-- #post-## -->

<?php mak_content_nav(); ?>
