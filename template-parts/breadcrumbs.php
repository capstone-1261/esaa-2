<?php
/**
 * Breadcrumb trail ending with the current page, for example "Events / Rally at the Legislature".
 * Pass array( 'trail' => array( 'Events' => $url ) ); the current page title is added at the end.
 *
 * @package esaa
 */

$esaa_trail = $args['trail'] ?? array();
?>
<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'esaa' ); ?>">
	<ol>
		<?php foreach ( $esaa_trail as $esaa_label => $esaa_url ) : ?>
			<li><a href="<?php echo esc_url( $esaa_url ); ?>"><?php echo esc_html( $esaa_label ); ?></a> <span aria-hidden="true">/</span></li>
		<?php endforeach; ?>
		<li><a href="<?php the_permalink(); ?>" aria-current="page"><?php the_title(); ?></a></li>
	</ol>
</nav>
