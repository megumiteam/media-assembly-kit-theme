<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Media Assembly Kit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
	<?php do_action( 'mak_before_page_entry' ); ?>
	<header class="entry-header">
		<?php do_action( 'mak_before_page_entry_header' ); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php do_action( 'mak_after_page_entry_header' ); ?>
	</header><!-- .entry-header -->
	<section class="entry-content">
		<?php do_action( 'mak_before_page_entry_content' ); ?>
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
		<?php do_action( 'mak_after_page_entry_content' ); ?>
	</section><!-- .entry-content -->
	<?php if ( has_action( 'mak_page_entry_footer' ) ) : ?>
		<footer class="entry-footer">
			<?php do_action( 'mak_page_entry_footer' ); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
	<?php do_action( 'mak_after_page_entry' ); ?>
</article><!-- #post-## -->
