<?php
/**
 * Exec card for the About Us page: photo, name, grade and school, bio, quote.
 * The email is left out here; it belongs under Team Contacts on the Contact Us page.
 * Load inside the loop with get_template_part( 'template-parts/card', 'exec' ).
 *
 * @package esaa
 */

$esaa_details = array_filter( array( esaa_field( 'grade' ), esaa_field( 'school' ) ) );
$esaa_quote   = esaa_field( 'quote' );
?>
<article class="exec-card">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'medium', array( 'alt' => '' ) ); ?>
	<?php endif; ?>

	<h3 class="exec-card__name"><?php the_title(); ?></h3>

	<?php if ( $esaa_details ) : ?>
		<p class="exec-card__details"><?php echo esc_html( implode( ', ', $esaa_details ) ); ?></p>
	<?php endif; ?>

	<div class="exec-card__bio">
		<?php the_content(); ?>
	</div>

	<?php if ( $esaa_quote ) : ?>
		<p class="exec-card__quote"><strong><?php echo esc_html( $esaa_quote ); ?></strong></p>
	<?php endif; ?>
</article>
