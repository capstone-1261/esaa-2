<?php
/**
 * Search form, used by get_search_form() in the header and on search and 404 pages.
 * The label is visually hidden; the placeholder is only a hint.
 *
 * @package esaa
 */

$esaa_field_id = wp_unique_id( 'search-field-' );
$esaa_landmark = $args['aria_label'] ?? '';
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $esaa_landmark ? ' aria-label="' . esc_attr( $esaa_landmark ) . '"' : ''; ?>>
	<label class="screen-reader-text" for="<?php echo esc_attr( $esaa_field_id ); ?>"><?php esc_html_e( 'Search for:', 'esaa' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $esaa_field_id ); ?>" class="search-form__field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search something…', 'esaa' ); ?>">
	<button type="submit" class="search-form__submit">
		<?php esaa_icon( 'search' ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'esaa' ); ?></span>
	</button>
</form>
