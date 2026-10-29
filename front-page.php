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
	<div class="container">
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
		<h2>Student Voices, Real Changes</h2>
		<p>The Edmonton Students Advocacy Association is a youth-led group, putting students in the rooms where decisions get made and fighting for a better future in education.</p>
	
		<h3>What we do</h3>
		<p>We represented the voice of students across Edmonton through demonstrations, advocacy, community events and student art showcases.</p>
		<p>By fighting and pushing for what we need in schools, anyone can have the chance to live and learn in an inclusive and productive environment.</p>
	
		<h3>Why it matters</h3>
		<p>We believe that despite being a contention point, students' voices and opinions are often left out of discussions, and we strive to change that.</p>
	</div>
</main>

<?php get_footer(); ?>
