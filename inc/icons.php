<?php
/**
 * Inline SVG icons from assets/icons/ (no icon font). Printing them inline lets CSS colour them with
 * currentColor. Icons are decorative: the control next to them carries the text.
 *
 * @package esaa
 */

/**
 * Returns an icon from assets/icons/ as inline SVG, cleaned up for use in the page: export comments, titles,
 * fixed sizes and ids are removed, black is swapped for currentColor, and it is hidden from screen readers.
 *
 * @param string $name File name without .svg, for example "search" or "chevron-down".
 * @return string SVG markup, or an empty string when the file doesn't exist.
 */
function esaa_get_icon( $name ) {
	static $cache = array();

	if ( isset( $cache[ $name ] ) ) {
		return $cache[ $name ];
	}

	$file = get_template_directory() . '/assets/icons/' . sanitize_file_name( $name ) . '.svg';
	if ( ! is_readable( $file ) ) {
		$cache[ $name ] = '';
		return '';
	}

	$svg = (string) file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.
	$svg = preg_replace( array( '/<\?xml.*?\?>/s', '/<!--.*?-->/s', '/<title\b[^>]*>.*?<\/title>|<title\s*\/>/s' ), '', $svg );
	$svg = preg_replace( '/\sid="[^"]*"/', '', $svg );
	$svg = preg_replace( '/#(000000|000|0F0F0F)\b/i', 'currentColor', $svg );
	$svg = preg_replace_callback(
		'/<svg\b([^>]*)>/',
		function ( $match ) use ( $name ) {
			$attributes = preg_replace( '/\s(width|height|class|version)="[^"]*"/', '', $match[1] );
			return '<svg class="icon icon--' . esc_attr( $name ) . '" width="24" height="24" aria-hidden="true" focusable="false"' . $attributes . '>';
		},
		$svg,
		1
	);

	$cache[ $name ] = trim( preg_replace( '/>\s+</', '><', $svg ) );
	return $cache[ $name ];
}

/**
 * Prints an inline SVG icon.
 *
 * @param string $name File name without .svg, see esaa_get_icon().
 */
function esaa_icon( $name ) {
	echo esaa_get_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- cleaned theme file, see above.
}
