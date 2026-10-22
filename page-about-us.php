<?php
/**
 * About Us page (/about-us/): the page's own content, then the Meet Our Execs section.
 * Execs are added in wp-admin under Execs; the Order box sets the order they appear in.
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

	<?php
	$esaa_execs = new WP_Query(
		array(
			'post_type'      => 'exec',
			'posts_per_page' => 50,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);
	?>
	<?php if ( $esaa_execs->have_posts() ) : ?>
		<section class="execs" aria-labelledby="execs-title">
			<h2 id="execs-title"><?php esc_html_e( 'Meet Our Execs', 'esaa' ); ?></h2>
			<ul class="exec-list">
				<?php while ( $esaa_execs->have_posts() ) : ?>
					<?php $esaa_execs->the_post(); ?>
					<li><?php get_template_part( 'template-parts/card', 'exec' ); ?></li>
				<?php endwhile; ?>
			</ul>
		</section>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
