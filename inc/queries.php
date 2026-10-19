<?php
/**
 * Which posts each listing page shows, and in what order.
 *
 * @package esaa
 */

/**
 * Query arguments for upcoming events (today or later), soonest first, then by start time.
 * Used by the Events page and any "upcoming events" section.
 *
 * @param array $args Extra WP_Query arguments, for example posts_per_page.
 * @return array
 */
function esaa_upcoming_events_args( $args = array() ) {
	return array_merge(
		array(
			'post_type'  => 'event',
			'meta_query' => array(
				'event_day'  => array(
					'key'     => 'event_date',
					'value'   => esaa_today(),
					'compare' => '>=',
					'type'    => 'NUMERIC',
				),
				'event_time' => array(
					'key'     => 'start_time',
					'compare' => 'EXISTS',
				),
			),
			'orderby'    => array(
				'event_day'  => 'ASC',
				'event_time' => 'ASC',
			),
		),
		$args
	);
}

/**
 * Adjusts the main query on listing pages: 12 items per page, and only upcoming events on /events/.
 *
 * @param WP_Query $query The query WordPress is about to run.
 */
function esaa_listing_queries( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_post_type_archive( array( 'event', 'zine', 'interview', 'past_event' ) ) ) {
		$query->set( 'posts_per_page', 12 );
	}

	if ( $query->is_post_type_archive( 'event' ) ) {
		$upcoming = esaa_upcoming_events_args();
		$query->set( 'meta_query', $upcoming['meta_query'] );
		$query->set( 'orderby', $upcoming['orderby'] );
	}
}
add_action( 'pre_get_posts', 'esaa_listing_queries' );
