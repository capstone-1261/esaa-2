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

/**
 * Adds a toggle button after primary menu links that have a submenu (Articles).
 * The link still goes to its own page; the button opens the submenu (assets/js/navigation.js).
 *
 * @param string   $item_output Menu item HTML.
 * @param WP_Post  $item        Menu item.
 * @param int      $depth       Depth of the item.
 * @param stdClass $args        wp_nav_menu() arguments.
 * @return string
 */
function esaa_submenu_toggle( $item_output, $item, $depth, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location || ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
		return $item_output;
	}

	/* translators: %s: menu item title, for example "Articles". */
	$label = sprintf( __( '%s submenu', 'esaa' ), wp_strip_all_tags( $item->title ) );

	return $item_output . sprintf(
		'<button type="button" class="submenu-toggle" aria-expanded="false"><span class="screen-reader-text">%s</span>%s</button>',
		esc_html( $label ),
		esaa_get_icon( 'chevron-down' )
	);
}
add_filter( 'walker_nav_menu_start_el', 'esaa_submenu_toggle', 10, 4 );

/**
 * Shows which section you are in on single events, zines, interviews and past events.
 * WordPress only marks a post type archive menu item on the archive itself, so a single zine would
 * highlight nothing. This marks the archive item (Zines) and its parents (Articles) as the current section.
 *
 * @param WP_Post[] $items Menu items, with WordPress's current classes already applied.
 * @return WP_Post[]
 */
function esaa_menu_current_section( $items ) {
	if ( ! is_singular( array( 'event', 'zine', 'interview', 'past_event' ) ) ) {
		return $items;
	}

	$by_id = array();
	foreach ( $items as $item ) {
		$by_id[ (int) $item->ID ] = $item;
	}

	foreach ( $items as $item ) {
		if ( 'post_type_archive' !== $item->type || get_post_type() !== $item->object ) {
			continue;
		}
		$item->classes[] = 'is-current-section';

		$parent = (int) $item->menu_item_parent;
		while ( $parent && isset( $by_id[ $parent ] ) ) {
			$by_id[ $parent ]->classes[] = 'current-menu-ancestor';
			$parent                      = (int) $by_id[ $parent ]->menu_item_parent;
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'esaa_menu_current_section' );
