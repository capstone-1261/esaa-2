<?php
/**
 * Default page template. Used by any page without its own page-{slug}.php,
 * for example the privacy policy.
 *
 * @package esaa
 */

get_header(); ?>

<main id="main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
