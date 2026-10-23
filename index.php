<?php
/**
 * Fallback template. WordPress uses it when no more specific template matches,
 * for example a blog post, a category, or a search before search.php exists.
 *
 * @package esaa
 */

get_header(); ?>

<main id="main">
	<?php if ( is_singular() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<h1>
			<?php
			if ( is_search() ) {
				/* translators: %s: search terms. */
				printf( esc_html__( 'Search results for "%s"', 'esaa' ), esc_html( get_search_query( false ) ) );
			} elseif ( is_404() ) {
				esc_html_e( 'Page not found', 'esaa' );
			} elseif ( is_archive() ) {
				echo wp_kses_post( get_the_archive_title() );
			} else {
				esc_html_e( 'Latest posts', 'esaa' );
			}
			?>
		</h1>
		<?php
		// Zines, Interviews and Past Events use this file until they get their own templates.
		if ( is_post_type_archive() ) {
			esaa_the_archive_intro();
		}
		?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class(); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found.', 'esaa' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
