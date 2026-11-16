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
 * Reads an ACF field, or returns a fallback when the field is empty, so a page still reads well before
 * its content is filled in (used for the home page text).
 *
 * @param string    $selector Field name.
 * @param mixed     $fallback Value to use when the field is empty.
 * @param int|false $post_id  Post ID. Defaults to the current post.
 * @return mixed
 */
function esaa_field_or( $selector, $fallback, $post_id = false ) {
	$value = esaa_field( $selector, $post_id );
	return $value ? $value : $fallback;
}

/**
 * Hides the content editor on the page set as the home page. That page is built from its "Home page" fields,
 * so the editor would only be a box whose text never shows.
 */
function esaa_hide_front_page_editor() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- only reads which page is being edited.

	if ( $post_id && (int) get_option( 'page_on_front' ) === $post_id ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_init', 'esaa_hide_front_page_editor' );

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
