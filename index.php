<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Media Assembly Kit
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php mak_category_induction_post_list(); ?>
		<main id="main" class="site-main" role="main">
			<?php do_action( 'mak_before_main' ); ?>
			<?php mak_archive_title(); ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php do_action( 'mak_before_loop' ); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php do_action( 'mak_after_loop' ); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			<?php if ( $wp_query->found_posts === 0 ) : mak_whats_new(); endif; ?>
			<?php do_action( 'mak_after_main' ); ?>
		</main><!-- #main -->
		<?php mak_content_nav(); ?>
	</div>
<?php get_footer(); ?>
