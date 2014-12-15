<?php
/**
 * @package Media Assembly Kit
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php do_action( 'mak_before_entry_header' ); ?>
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php mak_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		<?php do_action( 'mak_after_entry_header' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php do_action( 'mak_before_entry_content' ); ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mak' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'mak' ),
				'after'  => '</div>',
			) );
		?>
		<?php do_action( 'mak_after_entry_content' ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php mak_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->