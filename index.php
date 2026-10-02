<?php
/**
 * Fallback template. Shows any page or post's editor content,
 * including ACF blocks.
 *
 * @package esaa
 */

get_header(); ?>

<main>
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>

<?php get_footer(); ?>