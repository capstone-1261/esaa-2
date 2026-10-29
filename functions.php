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

/**
 * Loads the theme's CSS. Each component gets its own file; the version is the file's last-modified
 * time so browsers pick up changes straight away. Tokens come from theme.json.
 */
function esaa_enqueue_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'esaa-base', $uri . '/assets/css/base.css', array(), (string) filemtime( $dir . '/assets/css/base.css' ) );
}
add_action( 'wp_enqueue_scripts', 'esaa_enqueue_assets' );

/**
 * Adds a "js" class to <html> before anything renders, so CSS can hide things (like the mobile menu panel)
 * only when the script that shows them can run.
 */
function esaa_js_class() {
	wp_print_inline_script_tag( "document.documentElement.classList.add('js');" );
}
add_action( 'wp_head', 'esaa_js_class', 0 );

/**
 * Preloads Anton, the heading and navigation font, so headings don't swap fonts late.
 */
function esaa_preload_fonts() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_template_directory_uri() . '/assets/fonts/anton-regular/Anton-Regular.woff2' )
	);
}
add_action( 'wp_head', 'esaa_preload_fonts', 1 );

require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/navigation.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/queries.php';
