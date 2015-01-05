<?php
/**
 * The template for displaying all single posts.
 *
 * @package Media Assembly Kit
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php do_action( 'mak_before_main' ); ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php do_action( 'mak_before_loop' ); ?>
					<?php get_template_part( 'content', 'single' ); ?>
					<?php do_action( 'mak_after_loop' ); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			<?php mak_related_post_list(); ?>
			<?php do_action( 'mak_after_main' ); ?>
		</main><!-- #main -->
	</div>
<?php get_footer(); ?>
