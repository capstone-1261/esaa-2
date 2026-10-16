<?php
/**
 * Header. Loaded pages with get_header().
 *
 * @package esaa
 */

?>
<!doctype html>
<html lang="en-CA">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'esaa' ); ?></a>

<header class="site-header">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	<?php endif; ?>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'esaa' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<?php get_search_form(); ?>
</header>
