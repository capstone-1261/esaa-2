<?php
/**
 * Advanced Custom Fields (free) support. Field groups live in acf-json/ and ACF loads them automatically.
 * Edit field groups on a local site only, so ACF writes the change back to acf-json/ and it reaches Git.
 *
 * @package esaa
 */

/**
 * Reads an ACF field. Returns null when ACF is not active, so templates never crash.
 * Use this in templates instead of calling get_field() directly.
 *
 * @param string    $selector Field name, for example "event_date".
 * @param int|false $post_id  Post ID. Defaults to the current post.
 * @return mixed
 */
function esaa_field( $selector, $post_id = false ) {
	return function_exists( 'get_field' ) ? get_field( $selector, $post_id ) : null;
}

/**
 * Hides ACF's field group editor outside local sites. Changes made on staging would be
 * overwritten by the next deploy, because acf-json/ is uploaded from Git.
 *
 * @param bool $show Whether to show the ACF admin menu.
 * @return bool
 */
function esaa_acf_show_admin( $show ) {
	return 'local' === wp_get_environment_type() ? $show : false;
}
add_filter( 'acf/settings/show_admin', 'esaa_acf_show_admin' );

/**
 * Warns admins when ACF is not active, since event dates, zine PDFs and other details depend on it.
 */
function esaa_acf_missing_notice() {
	if ( function_exists( 'get_field' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		esc_html__( 'The ESAA theme needs the Advanced Custom Fields plugin. Event dates, zine PDFs and other details will not show until it is active.', 'esaa' )
	);
}
add_action( 'admin_notices', 'esaa_acf_missing_notice' );
