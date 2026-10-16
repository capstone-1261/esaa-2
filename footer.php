<?php
/**
 * Footer. Loaded pages with get_footer().
 *
 * @package esaa
 */

?>
<footer class="site-footer">
	<p class="site-footer__name"><?php bloginfo( 'name' ); ?></p>

	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<nav class="footer-nav" aria-labelledby="footer-nav-title">
			<h2 id="footer-nav-title"><?php esc_html_e( 'Quick links', 'esaa' ); ?></h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<p class="site-footer__copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Edmonton Students Advocacy Association</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
