<?php
/**
 * Homepage Template that replaces index.php for the front page of the site.
 * Still a placeholder apart from the slogan banner, which comes from Appearance > Customize > ESAA settings.
 *
 * @package esaa
 */

$esaa_slogans = esaa_setting_lines( 'banner_slogans' );

get_header(); ?>

<main id="main">
	<h1>Welcome to ESAA</h1>
	<p>This is placeholder body text for testing the homepage.</p>

	<?php if ( $esaa_slogans ) : ?>
		<?php // Each slogan is printed once; the scrolling animation and its pause button come with the styling. ?>
		<section class="slogan-banner" aria-label="<?php esc_attr_e( 'Our slogans', 'esaa' ); ?>">
			<ul>
				<?php foreach ( $esaa_slogans as $esaa_slogan ) : ?>
					<li><?php echo esc_html( $esaa_slogan ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
