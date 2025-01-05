<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package horrell
 */

$gs_site_copyright_text         = get_field( 'gs_site_copyright_text', 'option' );
$gs_site_footer_contact_details = get_field( 'gs_site_footer_contact_details', 'option' );
$gs_site_footer_logo            = get_field( 'gs_site_footer_logo', 'option' );
?>
<footer class="site-footer">
	<div class="site-info">
		<div class="container">
			<div class="row align-items-end">
				<div class="col-md-7 left-footer">
					<div class="copyright"><?php echo $gs_site_copyright_text; ?></div>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-2',
						)
					);
					?>
					<span class="contact"><?php echo $gs_site_footer_contact_details; ?></span>
				</div>
				<div class="col-md-5 right-footer text-center text-md-right">
					<?php
					if ( $gs_site_footer_logo ) {
						echo wp_get_attachment_image( $gs_site_footer_logo, 'full' );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
