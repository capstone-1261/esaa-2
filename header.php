<?php
/**
 * Header: logo, primary navigation (with the Articles submenu), Contact Us button and search.
 * Below 960px the menu and search move into a panel opened by the Menu button (assets/js/navigation.js).
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
	<div class="site-header__bar container">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<?php // No logo set in Appearance > Customize > Site Identity: use the theme's own logo file. ?>
			<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img class="custom-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" width="44" height="44" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>
		<?php endif; ?>

		<button type="button" class="menu-toggle" aria-expanded="false" aria-controls="site-menu" data-label-open="<?php esc_attr_e( 'Menu', 'esaa' ); ?>" data-label-close="<?php esc_attr_e( 'Close', 'esaa' ); ?>">
			<span class="menu-toggle__icon" aria-hidden="true"></span>
			<span class="menu-toggle__label"><?php esc_html_e( 'Menu', 'esaa' ); ?></span>
		</button>

		<div class="site-menu" id="site-menu">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'esaa' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'primary-nav__list',
							'depth'          => 2,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>

			<div class="site-search">
				<button type="button" class="search-toggle" aria-expanded="false" aria-controls="site-search-panel">
					<?php esaa_icon( 'search' ); ?>
					<span class="search-toggle__label"><?php esc_html_e( 'Search', 'esaa' ); ?></span>
				</button>
				<div class="site-search__panel" id="site-search-panel">
					<div class="container">
						<?php get_search_form( array( 'aria_label' => __( 'Site', 'esaa' ) ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
