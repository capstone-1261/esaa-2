<?php
/**
 * Numbered pagination plus "Page 1 of 4 - 48 items". Prints nothing when everything fits on one page.
 * Pass array( 'query' => $custom_query ) for a custom WP_Query; defaults to the main query.
 *
 * @package esaa
 */

$esaa_query = $args['query'] ?? $GLOBALS['wp_query'];
$esaa_page  = max( 1, (int) get_query_var( 'paged' ) );
$esaa_links = paginate_links(
	array(
		'total'              => $esaa_query->max_num_pages,
		'current'            => $esaa_page,
		'type'               => 'list',
		'prev_text'          => __( 'Previous', 'esaa' ),
		'next_text'          => __( 'Next', 'esaa' ),
		'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'esaa' ) . ' </span>',
	)
);

if ( ! $esaa_links ) {
	return;
}
?>
<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'esaa' ); ?>">
	<?php echo wp_kses_post( $esaa_links ); ?>
	<p class="pagination__status">
		<?php
		printf(
			/* translators: 1: current page, 2: total pages, 3: total items. */
			esc_html__( 'Page %1$d of %2$d - %3$d items', 'esaa' ),
			(int) $esaa_page,
			(int) $esaa_query->max_num_pages,
			(int) $esaa_query->found_posts
		);
		?>
	</p>
</nav>
