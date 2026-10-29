<?php
/**
 * Events page for upcoming events only, soonest first. The query is in inc/queries.php.
 *
 * @package esaa
 */

get_header(); ?>

<main id="main">
	<div class="container">
		<h1><?php post_type_archive_title(); ?></h1>
		<?php esaa_the_archive_intro( 'event' ); ?>
		
		<?php if ( have_posts() ) : ?>
			<ul class="card-grid">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<li><?php get_template_part( 'template-parts/card', 'event', array( 'heading_level' => 2 ) ); ?></li>
				<?php endwhile; ?>
			</ul>
			<?php get_template_part( 'template-parts/pagination' ); ?>
		<?php else : ?>
			<p>
				<?php esc_html_e( 'No upcoming events right now. Check back soon, or read about what we have done in', 'esaa' ); ?>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'past_event' ) ); ?>"><?php esc_html_e( 'Past Events', 'esaa' ); ?></a>.
			</p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
