<?php // phpcs:ignore
/**
 * Top Banner
 *
 * @package horrell
 *
 * cSpell: ignore phpcs, horrell
 */

$image         = '';
$default_image = get_field( 'default_top_banner_image', 'option' );
$bg_image      = get_field( 'top_background_image' );

if ( $default_image ) {
	$image = wp_get_attachment_image( $default_image, 'full' );
}

if ( $bg_image ) {
	$image = wp_get_attachment_image( $bg_image, 'full' );
}

if ( $image ) :
	?>
	<section class="img-banner">
		<?php echo $image; //phpcs:ignore ?>
	</section><!-- .img-banner -->
	<?php
endif;
