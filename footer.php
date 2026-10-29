<?php
/**
 * Footer: logo and blurb, quick links menu, contact details and copyright.
 * Blurb, email and Instagram come from Appearance > Customize > ESAA settings (inc/customizer.php).
 *
 * @package esaa
 */

$esaa_blurb     = esaa_setting( 'footer_blurb' );
$esaa_email     = esaa_setting( 'contact_email' );
$esaa_instagram = esaa_setting( 'instagram_url' );
$esaa_handle    = trim( (string) wp_parse_url( $esaa_instagram, PHP_URL_PATH ), '/' );
$esaa_logo_id   = (int) get_theme_mod( 'custom_logo' );
?>
<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__about">
			<?php if ( $esaa_logo_id ) : ?>
				<?php
				// Decorative here: the blurb right below names the organisation, and the header logo is the home link.
				echo wp_get_attachment_image(
					$esaa_logo_id,
					'full',
					false,
					array(
						'class'   => 'site-footer__logo',
						'alt'     => '',
						'loading' => 'lazy',
					)
				);
				?>
			<?php else : ?>
				<img class="site-footer__logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" width="44" height="44" alt="" loading="lazy">
			<?php endif; ?>
			<?php if ( $esaa_blurb ) : ?>
				<p class="site-footer__blurb"><?php echo esc_html( $esaa_blurb ); ?></p>
			<?php endif; ?>
		</div>

		<div class="site-footer__columns">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="footer-nav" aria-labelledby="footer-nav-title">
					<h2 class="site-footer__heading" id="footer-nav-title"><?php esc_html_e( 'Quick links', 'esaa' ); ?></h2>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<?php if ( $esaa_email || $esaa_instagram ) : ?>
				<div class="footer-contact">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Contact ESAA', 'esaa' ); ?></h2>
					<ul>
						<?php if ( $esaa_email ) : ?>
							<li>
								<a href="<?php echo esc_url( 'mailto:' . $esaa_email ); ?>">
									<?php esaa_icon( 'email' ); ?>
									<?php echo esc_html( $esaa_email ); ?>
								</a>
							</li>
						<?php endif; ?>
						<?php if ( $esaa_instagram ) : ?>
							<li>
								<a href="<?php echo esc_url( $esaa_instagram ); ?>">
									<?php esaa_icon( 'instagram' ); ?>
									<span><?php echo esc_html( $esaa_handle ? '@' . $esaa_handle : __( 'Instagram', 'esaa' ) ); ?><?php if ( $esaa_handle ) : ?><span class="screen-reader-text"> <?php esc_html_e( 'on Instagram', 'esaa' ); ?></span><?php endif; ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>

		<p class="site-footer__copyright">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> Edmonton Students Advocacy Association</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
