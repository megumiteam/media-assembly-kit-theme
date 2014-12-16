<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Media Assembly Kit
 */
?>

		<?php do_action( 'mak_after_content' ); ?>
	</div><!-- #content -->
	<?php do_action( 'mak_content_footer' ); ?>
	<?php mak_editor_choice(); ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action( 'mak_footer' ); ?>
		<div id="in-footer">
			<div id="footer-site-meta">
				<p class="footer-site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			</div>
			<?php mak_footer_nav(); ?>
			<div id="copyright-area">
				<?php mak_copyright(); ?>
				<p id="license"><strong>掲載の記事・写真・イラスト等のすべてのコンテンツの無断複写・転載を禁じます。</strong></p>
			</div>
			<?php do_action( 'mak_footer' ); ?>
		</div>
	</footer><!-- #colophon -->
	<?php do_action( 'mak_after_page' ); ?>
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
