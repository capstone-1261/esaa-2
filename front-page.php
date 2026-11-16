<?php
/**
 * Home page. Built from the Home page's fields (ACF group "Home page"); empty fields show the default text, so the
 * page reads well before its content is entered. Slogans come from Appearance > Customize > ESAA settings.
 * Styles: assets/css/pages/front-page.css.
 *
 * @package esaa
 */

$esaa_slogans      = esaa_setting_lines( 'banner_slogans' );
$esaa_hero_image   = esaa_field( 'hero_image' );
$esaa_change_image = esaa_field( 'change_image' );

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

	<?php if ( $esaa_slogans ) : ?>
		<?php
		// The band scrolls by half its length, so it holds an even number of copies, enough to fill a wide screen.
		// Screen readers get the first copy only.
		$esaa_copies = 2 * max( 2, (int) ceil( 8 / count( $esaa_slogans ) ) );
		?>
		<section class="slogan-banner" aria-label="<?php esc_attr_e( 'Our slogans', 'esaa' ); ?>">
			<div class="slogan-banner__band">
				<div class="slogan-banner__track">
					<?php for ( $esaa_copy = 0; $esaa_copy < $esaa_copies; $esaa_copy++ ) : ?>
						<ul class="slogan-banner__list"<?php echo $esaa_copy ? ' aria-hidden="true"' : ''; ?>>
							<?php foreach ( $esaa_slogans as $esaa_slogan ) : ?>
								<li class="slogan-banner__item"><?php esaa_icon( 'star' ); ?><?php echo esc_html( $esaa_slogan ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endfor; ?>
				</div>
				<button class="slogan-banner__toggle" type="button" hidden data-label-pause="<?php esc_attr_e( 'Pause the slogans', 'esaa' ); ?>" data-label-play="<?php esc_attr_e( 'Play the slogans', 'esaa' ); ?>">
					<?php esaa_icon( 'pause' ); ?>
					<?php esaa_icon( 'play' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Pause the slogans', 'esaa' ); ?></span>
				</button>
			</div>
		</section>
	<?php endif; ?>

	<section class="change has-dots" aria-labelledby="change-title">
		<div class="container">
			<h2 id="change-title" class="change__title"><?php echo esc_html( esaa_field_or( 'change_heading', __( 'Change Starts Here', 'esaa' ) ) ); ?></h2>

			<div class="change__body">
				<?php if ( $esaa_change_image ) : ?>
					<figure class="change__media">
						<?php
						echo wp_get_attachment_image(
							$esaa_change_image,
							'large',
							false,
							array(
								'class' => 'change__image',
								'sizes' => '(min-width: 90em) 486px, (min-width: 60em) 34vw, 100vw',
							)
						);
						?>
					</figure>
				<?php endif; ?>

				<div class="change__tiles">
					<div class="tile tile--gold">
						<h3 class="tile__title"><?php esc_html_e( 'What We Do', 'esaa' ); ?></h3>
						<?php
						$esaa_what = esaa_field_or( 'what_we_do', __( 'We represented the voice of students across Edmonton through demonstrations, advocacy, community events and student art showcases.', 'esaa' ) . "\n\n" . __( 'By fighting and pushing for what we need in schools, anyone can have the chance to live and learn in an inclusive and productive environment.', 'esaa' ) );
						echo wp_kses_post( wpautop( esc_html( $esaa_what ) ) );
						?>
					</div>
					<div class="tile">
						<h3 class="tile__title"><?php esc_html_e( 'Why It Matters', 'esaa' ); ?></h3>
						<?php
						$esaa_why = esaa_field_or( 'why_it_matters', __( "We believe that despite being a contention point, students' voices and opinions are often left out of discussions, and we strive to change that.", 'esaa' ) );
						echo wp_kses_post( wpautop( esc_html( $esaa_why ) ) );
						?>
					</div>
					<?php
					esaa_the_button(
						esaa_field( 'change_link' ),
						array(
							'url'   => esaa_page_url( 'about-us' ),
							'title' => __( 'Learn more', 'esaa' ),
						)
					);
					?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
