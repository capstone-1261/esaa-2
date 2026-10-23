<?php
/**
 * Small helpers templates use to print dates and other values.
 *
 * @package esaa
 */

/**
 * Returns today's date as Ymd in the site's timezone (Settings > General), the format ACF stores dates in.
 *
 * @return string
 */
function esaa_today() {
	return current_datetime()->format( 'Ymd' );
}

/**
 * Formats an event's date, for example "Oct 27, 2026". Reads the stored value directly,
 * so it works the same whatever return format the ACF field uses.
 *
 * @param string   $format  PHP date format.
 * @param int|null $post_id Event ID. Defaults to the current post.
 * @return string Empty string when the event has no date.
 */
function esaa_event_date( $format = 'M j, Y', $post_id = null ) {
	$raw  = get_post_meta( $post_id ? $post_id : get_the_ID(), 'event_date', true );
	$date = $raw ? DateTimeImmutable::createFromFormat( '!Ymd', $raw, wp_timezone() ) : false;

	return $date ? wp_date( $format, $date->getTimestamp() ) : '';
}

/**
 * Prints an event's date and start time as one line, for example "Oct 27, 2026 · 10:30 AM".
 *
 * @param int|null $post_id Event ID. Defaults to the current post.
 */
function esaa_the_event_when( $post_id = null ) {
	$parts = array_filter( array( esaa_event_date( 'M j, Y', $post_id ), esaa_field( 'start_time', $post_id ? $post_id : false ) ) );

	printf(
		'<time datetime="%s">%s</time>',
		esc_attr( esaa_event_date( 'Y-m-d', $post_id ) ),
		esc_html( implode( ' · ', $parts ) )
	);
}
