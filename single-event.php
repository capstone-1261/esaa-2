<?php
/**
 * Single event page template: image, date, time, location, description, then other upcoming events.
 *
 * @package esaa
 */

get_header(); ?>

<main id="main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php
		get_template_part(
			'template-parts/breadcrumbs',
			null,
			array( 'trail' => array( __( 'Events', 'esaa' ) => get_post_type_archive_link( 'event' ) ) )
		);
		?>

		<article <?php post_class(); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large' ); ?>
			<?php endif; ?>

			<h1><?php the_title(); ?></h1>

			<ul class="event-details">
				<li>
					<strong><?php esc_html_e( 'Date', 'esaa' ); ?>:</strong>
					<time datetime="<?php echo esc_attr( esaa_event_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( esaa_event_date( 'F jS, Y' ) ); ?></time>
				</li>
				<li><strong><?php esc_html_e( 'Time', 'esaa' ); ?>:</strong> <?php echo esc_html( esaa_field( 'start_time' ) ); ?></li>
				<li>
					<strong><?php esc_html_e( 'Location', 'esaa' ); ?>:</strong>
					<?php echo esc_html( implode( ', ', array_filter( array( esaa_field( 'location_name' ), esaa_field( 'address' ) ) ) ) ); ?>
				</li>
			</ul>

			<?php the_content(); ?>
		</article>

		<?php
		$esaa_others = new WP_Query(
			esaa_upcoming_events_args(
				array(
					'posts_per_page' => 4,
					'post__not_in'   => array( get_the_ID() ),
				)
			)
		);
		?>
		<?php if ( $esaa_others->have_posts() ) : ?>
			<section aria-labelledby="other-events-title">
				<h2 id="other-events-title"><?php esc_html_e( 'Other Upcoming Events', 'esaa' ); ?></h2>
				<ul class="card-grid">
					<?php while ( $esaa_others->have_posts() ) : ?>
						<?php $esaa_others->the_post(); ?>
						<li><?php get_template_part( 'template-parts/card', 'event' ); ?></li>
					<?php endwhile; ?>
				</ul>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<p><a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Back to Events Page', 'esaa' ); ?></a></p>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
