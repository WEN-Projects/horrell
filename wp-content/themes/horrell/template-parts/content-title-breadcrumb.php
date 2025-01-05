<?php //phpcs:ignore
/**
 * Title Breadcrumbs
 *
 * @package horrell
 *
 * cSpell: ignore phpcs, horrell
 */

?>

<section class="page-title">
	<div class="container d-flex justify-content-between align-items-end">
		<?php
		if ( isset( $args['title'] ) ) { // if static title is set while calling get_template_part.
			echo '<h2>' . esc_html( $args['title'] ) . '</h2>';
		} elseif ( get_field( 'show_different_page_title' ) ) { // if show different page title is used.
			echo '<h2>' . esc_html( get_field( 'page_title' ) ) . '</h2>';
		} else {
			the_title( '<h2>', '</h2>' ); // else use default title.
		}
		//phpcs:ignore
		echo horrell_breadcrumb_html();
		?>
	</div>
</section><!-- .page-title -->
