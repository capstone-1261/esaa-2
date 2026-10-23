<?php
/**
 * Custom post types: events, zines, interviews, past events and execs.
 * Their fields come from ACF (acf-json/). Main text goes in the editor so WordPress search finds it.
 *
 * @package esaa
 */

// Bump this whenever a post type is added or a slug changes. Each site then rebuilds its permalinks once on its own.
define( 'ESAA_REWRITE_VERSION', '2' );

/**
 * Builds the admin labels for a post type from its singular and plural names.
 *
 * @param string $singular Singular name, for example "Event".
 * @param string $plural   Plural name, for example "Events".
 * @param string $image    Name for the featured image box, for example "Event image".
 * @return array
 */
function esaa_post_type_labels( $singular, $plural, $image ) {
	return array(
		'name'                  => $plural,
		'singular_name'         => $singular,
		'featured_image'        => $image,
		/* translators: %s: featured image name, for example "Event image". */
		'set_featured_image'    => sprintf( __( 'Set %s', 'esaa' ), strtolower( $image ) ),
		/* translators: %s: featured image name, for example "Event image". */
		'remove_featured_image' => sprintf( __( 'Remove %s', 'esaa' ), strtolower( $image ) ),
		/* translators: %s: featured image name, for example "Event image". */
		'use_featured_image'    => sprintf( __( 'Use as %s', 'esaa' ), strtolower( $image ) ),
		/* translators: %s: singular post type name. */
		'add_new_item'          => sprintf( __( 'Add New %s', 'esaa' ), $singular ),
		/* translators: %s: singular post type name. */
		'edit_item'             => sprintf( __( 'Edit %s', 'esaa' ), $singular ),
		/* translators: %s: singular post type name. */
		'view_item'             => sprintf( __( 'View %s', 'esaa' ), $singular ),
		/* translators: %s: plural post type name. */
		'all_items'             => sprintf( __( 'All %s', 'esaa' ), $plural ),
		/* translators: %s: plural post type name. */
		'search_items'          => sprintf( __( 'Search %s', 'esaa' ), $plural ),
		/* translators: %s: plural post type name. */
		'not_found'             => sprintf( __( 'No %s found.', 'esaa' ), strtolower( $plural ) ),
		/* translators: %s: plural post type name. */
		'not_found_in_trash'    => sprintf( __( 'No %s found in Trash.', 'esaa' ), strtolower( $plural ) ),
	);
}

/**
 * Registers the custom post types.
 */
function esaa_register_post_types() {
	// Public types share these settings. Each gets an archive page at /{slug}/ and singles at /{slug}/{post}/.
	// Zines, Interviews and Past Events live under /articles/ to match the sitemap (the Articles page is their hub).
	$public = array(
		'public'       => true,
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
	);

	register_post_type(
		'event',
		$public + array(
			'labels'      => esaa_post_type_labels( __( 'Event', 'esaa' ), __( 'Events', 'esaa' ), __( 'Event image', 'esaa' ) ),
			'menu_icon'   => 'dashicons-calendar-alt',
			'has_archive' => 'events',
			'rewrite'     => array(
				'slug'       => 'events',
				'with_front' => false,
			),
		)
	);

	register_post_type(
		'zine',
		$public + array(
			'labels'      => esaa_post_type_labels( __( 'Zine', 'esaa' ), __( 'Zines', 'esaa' ), __( 'Zine cover', 'esaa' ) ),
			'menu_icon'   => 'dashicons-media-document',
			'has_archive' => 'articles/zines',
			'rewrite'     => array(
				'slug'       => 'articles/zines',
				'with_front' => false,
			),
		)
	);

	register_post_type(
		'interview',
		$public + array(
			'labels'      => esaa_post_type_labels( __( 'Interview', 'esaa' ), __( 'Interviews', 'esaa' ), __( 'Video thumbnail', 'esaa' ) ),
			'menu_icon'   => 'dashicons-video-alt3',
			'has_archive' => 'articles/interviews',
			'rewrite'     => array(
				'slug'       => 'articles/interviews',
				'with_front' => false,
			),
		)
	);

	// Past events are write-ups about events that already happened, listed under Articles.
	register_post_type(
		'past_event',
		$public + array(
			'labels'      => esaa_post_type_labels( __( 'Past Event', 'esaa' ), __( 'Past Events', 'esaa' ), __( 'Write-up image', 'esaa' ) ),
			'menu_icon'   => 'dashicons-format-aside',
			'has_archive' => 'articles/past-events',
			'rewrite'     => array(
				'slug'       => 'articles/past-events',
				'with_front' => false,
			),
		)
	);

	// Execs only appear on the About Us and Contact Us pages, so they get no public URLs.
	// They use the classic edit screen so the Order box (listing order) is visible next to the photo.
	register_post_type(
		'exec',
		array(
			'labels'              => esaa_post_type_labels( __( 'Exec', 'esaa' ), __( 'Execs', 'esaa' ), __( 'Exec photo', 'esaa' ) ),
			'menu_icon'           => 'dashicons-groups',
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
		)
	);
}
add_action( 'init', 'esaa_register_post_types' );

/**
 * Rebuilds permalinks once per site after ESAA_REWRITE_VERSION changes, so new archive URLs work
 * after a deploy without anyone re-saving Settings > Permalinks.
 */
function esaa_maybe_flush_rewrite_rules() {
	if ( get_option( 'esaa_rewrite_version' ) !== ESAA_REWRITE_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'esaa_rewrite_version', ESAA_REWRITE_VERSION );
	}
}
add_action( 'init', 'esaa_maybe_flush_rewrite_rules', 20 );

/**
 * Replaces the "Add title" placeholder with what the title means for each post type.
 *
 * @param string  $text Default placeholder.
 * @param WP_Post $post Post being edited.
 * @return string
 */
function esaa_title_placeholder( $text, $post ) {
	$placeholders = array(
		'event'      => __( 'Event name', 'esaa' ),
		'zine'       => __( 'Zine title', 'esaa' ),
		'interview'  => __( 'Video title', 'esaa' ),
		'past_event' => __( 'Write-up title', 'esaa' ),
		'exec'       => __( 'Exec name', 'esaa' ),
	);
	return $placeholders[ $post->post_type ] ?? $text;
}
add_filter( 'enter_title_here', 'esaa_title_placeholder', 10, 2 );
