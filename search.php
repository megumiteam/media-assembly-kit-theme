<?php
/**
 * The template for displaying search results pages.
 *
 * @package Media Assembly Kit
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<?php do_action( 'mak_before_primary' ); ?>
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php do_action( 'mak_before_page_header' ); ?>
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'mak' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php do_action( 'mak_after_page_header' ); ?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

			<?php mak_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
		<?php do_action( 'mak_after_primary' ); ?>
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
