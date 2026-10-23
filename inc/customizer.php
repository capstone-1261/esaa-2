<?php
/**
 * Site-wide settings in Appearance > Customize > ESAA settings: footer text, contact links,
 * banner slogans and the intro line under each listing page. Free ACF has no options page, so these use the Customizer.
 *
 * @package esaa
 */

/**
 * Registers the ESAA settings section and its fields.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function esaa_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'esaa_settings',
		array(
			'title'    => __( 'ESAA settings', 'esaa' ),
			'priority' => 30,
		)
	);

	// Setting name => label, control type, sanitize function, help text.
	$settings = array(
		'footer_blurb'      => array( __( 'Footer blurb', 'esaa' ), 'textarea', 'sanitize_textarea_field', '' ),
		'contact_email'     => array( __( 'Contact email', 'esaa' ), 'email', 'sanitize_email', __( 'Shown in the footer.', 'esaa' ) ),
		'instagram_url'     => array( __( 'Instagram link', 'esaa' ), 'url', 'esc_url_raw', __( 'For example https://www.instagram.com/esaa.ab/', 'esaa' ) ),
		'banner_slogans'    => array( __( 'Banner slogans', 'esaa' ), 'textarea', 'sanitize_textarea_field', __( 'One slogan per line. Shown in the scrolling banner on the home page.', 'esaa' ) ),
		'events_intro'      => array( __( 'Events page intro', 'esaa' ), 'textarea', 'sanitize_textarea_field', __( 'Shown under the heading on the Events page.', 'esaa' ) ),
		'zines_intro'       => array( __( 'Zines page intro', 'esaa' ), 'textarea', 'sanitize_textarea_field', __( 'Shown under the heading on the Zines page.', 'esaa' ) ),
		'interviews_intro'  => array( __( 'Interviews page intro', 'esaa' ), 'textarea', 'sanitize_textarea_field', __( 'Shown under the heading on the Interviews page.', 'esaa' ) ),
		'past_events_intro' => array( __( 'Past Events page intro', 'esaa' ), 'textarea', 'sanitize_textarea_field', __( 'Shown under the heading on the Past Events page.', 'esaa' ) ),
	);

	foreach ( $settings as $name => list( $label, $type, $sanitize, $help ) ) {
		$wp_customize->add_setting( 'esaa_' . $name, array( 'sanitize_callback' => $sanitize ) );
		$wp_customize->add_control(
			'esaa_' . $name,
			array(
				'label'       => $label,
				'description' => $help,
				'section'     => 'esaa_settings',
				'type'        => $type,
			)
		);
	}
}
add_action( 'customize_register', 'esaa_customize_register' );

/**
 * Returns one ESAA setting, or an empty string when it has not been filled in.
 *
 * @param string $name Setting name without the esaa_ prefix, for example "footer_blurb".
 * @return string
 */
function esaa_setting( $name ) {
	return (string) get_theme_mod( 'esaa_' . $name, '' );
}

/**
 * Returns a one-per-line setting (such as banner slogans) as a list, skipping empty lines.
 *
 * @param string $name Setting name without the esaa_ prefix.
 * @return string[]
 */
function esaa_setting_lines( $name ) {
	return array_values( array_filter( array_map( 'trim', explode( "\n", esaa_setting( $name ) ) ) ) );
}

/**
 * Prints the intro line under a listing page heading (Events, Zines, Interviews, Past Events).
 * Prints nothing when the intro is empty in ESAA settings.
 *
 * @param string $post_type Post type of the listing. Defaults to the archive being viewed.
 */
function esaa_the_archive_intro( $post_type = '' ) {
	$settings  = array(
		'event'      => 'events_intro',
		'zine'       => 'zines_intro',
		'interview'  => 'interviews_intro',
		'past_event' => 'past_events_intro',
	);
	$post_type = $post_type ? $post_type : get_query_var( 'post_type' );
	$post_type = is_array( $post_type ) ? reset( $post_type ) : $post_type;

	if ( ! isset( $settings[ $post_type ] ) ) {
		return;
	}

	$intro = esaa_setting( $settings[ $post_type ] );
	if ( $intro ) {
		printf( '<p class="archive-intro">%s</p>', nl2br( esc_html( $intro ) ) );
	}
}
