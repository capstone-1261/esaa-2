<?php
/**
 * Home page. Built from the Home page's fields (ACF group "Home page"); empty fields show the default text, so the
 * page reads well before its content is entered. Slogans come from Appearance > Customize > ESAA settings.
 * Styles: assets/css/pages/front-page.css.
 *
 * @package esaa
 */

$esaa_slogans    = esaa_setting_lines( 'banner_slogans' );
$esaa_hero_image = esaa_field( 'hero_image' );

get_header(); ?>

<main id="main">
	<section class="hero has-dots" aria-labelledby="hero-title">
		<div class="container hero__inner">
			<div class="hero__content">
				<h1 id="hero-title" class="hero__title">
					<?php echo esc_html( esaa_field_or( 'hero_heading', __( 'Student voices,', 'esaa' ) ) ); ?>
					<span class="hero__highlight"><?php echo esc_html( esaa_field_or( 'hero_highlight', __( 'real changes', 'esaa' ) ) ); ?></span>
				</h1>
				<p class="hero__text"><?php echo esc_html( esaa_field_or( 'hero_text', __( 'The Edmonton Students Advocacy Association is a youth-led group, putting students in the rooms where decisions get made and fighting for a better future in education.', 'esaa' ) ) ); ?></p>
				<div class="hero__actions">
					<?php
					esaa_the_button(
						esaa_field( 'hero_primary_link' ),
						array(
							'url'   => get_post_type_archive_link( 'event' ),
							'title' => __( 'View upcoming events', 'esaa' ),
						)
					);
					esaa_the_button(
						esaa_field( 'hero_secondary_link' ),
						array(
							'url'   => esaa_page_url( 'about-us' ),
							'title' => __( 'Learn more', 'esaa' ),
						),
						'button--gold'
					);
					?>
				</div>
			</div>

			<?php if ( $esaa_hero_image ) : ?>
				<figure class="hero__media">
					<?php
					// The hero photo is the largest thing on screen at first, so it loads straight away instead of lazily.
					echo wp_get_attachment_image(
						$esaa_hero_image,
						'large',
						false,
						array(
							'class'         => 'hero__image',
							'sizes'         => '(min-width: 90em) 690px, (min-width: 60em) 48vw, 100vw',
							'loading'       => 'eager',
							'fetchpriority' => 'high',
						)
					);
					?>
				</figure>
			<?php endif; ?>
		</div>
	</section>

	<div class="container">
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

		<h3>What we do</h3>
		<p>We represented the voice of students across Edmonton through demonstrations, advocacy, community events and student art showcases.</p>
		<p>By fighting and pushing for what we need in schools, anyone can have the chance to live and learn in an inclusive and productive environment.</p>
	
		<h3>Why it matters</h3>
		<p>We believe that despite being a contention point, students' voices and opinions are often left out of discussions, and we strive to change that.</p>
	</div>
</main>

<?php get_footer(); ?>
