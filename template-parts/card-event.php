<?php
/**
 * Event card: image, title (the only link), date and time, location.
 * Load inside the loop with get_template_part( 'template-parts/card', 'event', array( 'heading_level' => 2 ) ).
 *
 * @package esaa
 */

$esaa_level = (int) ( $args['heading_level'] ?? 3 );
?>
<article class="card card--event">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'medium_large', array( 'alt' => '' ) ); ?>
	<?php endif; ?>

	<?php printf( '<h%d class="card__title">', $esaa_level ); ?>
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	<?php printf( '</h%d>', $esaa_level ); ?>

	<p class="card__meta"><?php esaa_the_event_when(); ?></p>
	<?php if ( esaa_field( 'location_name' ) ) : ?>
		<p class="card__meta"><?php echo esc_html( esaa_field( 'location_name' ) ); ?></p>
	<?php endif; ?>
</article>
