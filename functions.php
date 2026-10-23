<?php
/**
 * Theme setup. Feature code lives in inc/ and is required at the bottom of this file.
 *
 * @package esaa
 */

/**
 * Turns on the WordPress features the theme uses and registers the menu locations.
 */
function esaa_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );

	// Logo is uploaded in Appearance > Customize > Site Identity. The header falls back to the site title.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 160,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Menus are built in Appearance > Menus and assigned to these locations.
	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'esaa' ),
			'footer'  => __( 'Footer quick links', 'esaa' ),
		)
	);
}
add_action( 'after_setup_theme', 'esaa_setup' );

require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/navigation.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/queries.php';
