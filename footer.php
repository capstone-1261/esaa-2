<?php
/**
 * Footer. Loaded pages with get_footer().
 *
 * @package esaa
 */

$esaa_blurb     = esaa_setting( 'footer_blurb' );
$esaa_email     = esaa_setting( 'contact_email' );
$esaa_instagram = esaa_setting( 'instagram_url' );
$esaa_handle    = trim( (string) wp_parse_url( $esaa_instagram, PHP_URL_PATH ), '/' );
?>
<footer class="site-footer">
	<div class="site-footer__about">
		<p class="site-footer__name"><?php bloginfo( 'name' ); ?></p>
		<?php if ( $esaa_blurb ) : ?>
			<p><?php echo esc_html( $esaa_blurb ); ?></p>
		<?php endif; ?>
	</div>

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

	<?php if ( $esaa_email || $esaa_instagram ) : ?>
		<div class="footer-contact">
			<h2><?php esc_html_e( 'Contact ESAA', 'esaa' ); ?></h2>
			<ul>
				<?php if ( $esaa_email ) : ?>
					<li><a href="<?php echo esc_url( 'mailto:' . $esaa_email ); ?>"><?php echo esc_html( $esaa_email ); ?></a></li>
				<?php endif; ?>
				<?php if ( $esaa_instagram ) : ?>
					<li>
						<a href="<?php echo esc_url( $esaa_instagram ); ?>">
							<?php echo esc_html( $esaa_handle ? '@' . $esaa_handle : __( 'Instagram', 'esaa' ) ); ?>
							<?php if ( $esaa_handle ) : ?>
								<span class="screen-reader-text"><?php esc_html_e( 'on Instagram', 'esaa' ); ?></span>
							<?php endif; ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>

	<p class="site-footer__copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Edmonton Students Advocacy Association</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
