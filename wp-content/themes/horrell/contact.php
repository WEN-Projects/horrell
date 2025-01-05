<?php
/*
Template Name: Contact
*/
get_header();
?>
    <main class="contact-page">
        <section class="site-banner">
			<?php
			echo do_shortcode( '[smartslider3 slider="6"]' );
			?>
        </section>
		<?php
		get_template_part( "template-parts/content", "title-breadcrumb" );
		?>
        <section class="contact-info-wrapper">
            <div class="dark-bg-wrapper text-center">
                <div class="container">
					<?php
					the_content();
					$site_address        = get_field( 'gs_site_address', 'option' );
					$site_contact_number = get_field( 'gs_site_contact_number', 'option' );
					?>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <h3>Monthly Property Updates</h3>
                            <p><a href="http://eepurl.com/3EdTz" class="subscribe-btn" target="_blank">Subscribe
                                    Here</a></p>
							<?php if ( $site_contact_number ) {
							?>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <h3>Office</h3>
                            <p><a href="tel:<?php echo $site_contact_number; ?>"
                                  class="tel-no"><?php echo $site_contact_number; ?></a></p>
							<?php
							}
							if ( $site_address ) {
							?>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <h3>Address</h3>
                            <p><?php echo $site_address; ?></p>
							<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- .contact-info-wrapper -->

        <section class="map-section">
            <div class="container">
                <div class="map-wrapper">
                    <!-- Map here -->
					<?php
					$contact_location = get_field( "contact_location" );
					if ( $contact_location ): ?>
                        <div class="acf-map" data-zoom="16">
                            <div class="marker" data-lat="<?php echo esc_attr( $contact_location['lat'] ); ?>"
                                 data-lng="<?php echo esc_attr( $contact_location['lng'] ); ?>"></div>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </section>
    </main>
<?php
get_footer();