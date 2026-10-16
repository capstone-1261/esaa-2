<?php
/**
 * Menu tweaks that should not depend on settings typed into Appearance > Menus.
 *
 * @package esaa
 */

/**
 * Marks the Contact Us menu item as the call-to-action button, wherever it sits in the menu.
 * Matching the page slug means the button survives the menu being rebuilt on any site.
 *
 * @param string[] $classes Menu item classes.
 * @param WP_Post  $item    Menu item.
 * @return string[]
 */
function esaa_menu_cta_class( $classes, $item ) {
	if ( 'page' === $item->object && 'contact-us' === get_post_field( 'post_name', $item->object_id ) && ! in_array( 'menu-cta', $classes, true ) ) {
		$classes[] = 'menu-cta';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'esaa_menu_cta_class', 10, 2 );
