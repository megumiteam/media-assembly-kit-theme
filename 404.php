<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Media Assembly Kit
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php do_action( 'mak_before_main' ); ?>
			<article id="post-0" class="error404 not-found">
				<?php do_action( 'mak_before_404_entry' ); ?>
				<header class="entry-header">
					<?php do_action( 'mak_before_404_entry_header' ); ?>
					<h1 class="entry-title"><?php _e( 'Not Found', 'mak' ); ?></h1>
					<?php do_action( 'mak_after_404_entry_header' ); ?>
				</header><!-- .entry-header -->
				<section class="entry-content">
					<?php do_action( 'mak_before_404_entry_content' ); ?>
					<?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'mak' ); ?>
					<?php get_search_form(); ?>
					<?php do_action( 'mak_after_404_entry_content' ); ?>
				</section><!-- .entry-content -->
				<?php if ( has_action( 'mak_404_entry_footer' ) ) : ?>
					<footer class="entry-footer">
						<?php do_action( 'mak_404_entry_footer' ); ?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
				<?php do_action( 'mak_after_404_entry' ); ?>
			</article><!-- .error-404 -->
			<?php do_action( 'mak_after_main' ); ?>
		</main><!-- #main -->
		<?php mak_pickup(); ?>
		<?php mak_whats_new(); ?>
	</div>
<?php get_footer(); ?>
