<?php
/*
Template Name: Saved Listings
*/
get_header();
?>
    <main class="saved-listing-page">
        <section class="img-banner">
			<?php
			$top_background_image = get_field( 'top_background_image' );
			echo wp_get_attachment_image( $top_background_image, 'full' );
			?>
        </section><!-- .img-banner -->
        <section class="page-title">
            <div class="container d-flex justify-content-between align-items-end">
				<?php
				the_title( '<h2>', '</h2>' );
				echo horrell_breadcrumb_html();
				?>
            </div>
        </section><!-- .page-title -->
        <section class="saved-listings-wrapper">
            <div class="container">
				<?php
				global $Horrell_Saved_Listings;
				$saved_listings = $Horrell_Saved_Listings->horrell_get_saved_listings();
				if ( ! empty( $saved_listings ) ) {
					?>
                    <!-- if listings available -->
                    <div class="listings">
                        <div class="top-bar d-flex  justify-content-md-between align-items-md-center flex-column flex-md-row">
                            <div class="left-content order-2 order-md-1 d-flex">
                                <p><?php echo _e( 'Property', 'horrell' ); ?></p>
                                <p><?php echo _e( 'Details', 'horrell' ); ?></p>
                            </div>

                            <div class="right-content order-1 order-md-2">
                                <a href="javascript:void(0)"
                                   class="download-btn pdf-download">
								<span class="icon">
									<?php
									get_template_part( 'template-parts/svg-icons/icon', 'download' );
									?>
								</span>
									<?php echo _e( 'Download', 'horrell' ); ?>
                                </a>

                                <a href="#" class="mail-btn" data-toggle="modal"
                                   data-target="#emailModal"
                                   data-id="email-sl">
								<span class="icon">
									<?php
									get_template_part( 'template-parts/svg-icons/icon', 'email' );
									?>
								</span>
                                    Email
                                </a>
                                <div class="modal fade" tabindex="-1"
                                     id="messageModal"
                                     aria-labelledby="teamModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-top">
                                                    <h2 id="sent_email_message"></h2>
                                                </div>
                                                <button type="button"
                                                        class="close"
                                                        data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <button type="button"
                                                        data-dismiss="modal">OK
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" tabindex="-1"
                                     id="emailModal"
                                     aria-labelledby="teamModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-top">
                                                    <h2>Email Saved
                                                        Listings</h2>
                                                    <h4>* Required</h4>
                                                </div>
                                                <button type="button"
                                                        class="close"
                                                        data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="saved-listing-email-form">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Recipient's
                                                                Name*</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text"
                                                                   name="recipient_name"
                                                                   id="recipient_name"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Recipient's
                                                                Email*</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="email"
                                                                   name="recipient_email"
                                                                   id="recipient_email"
                                                                   required>
                                                            <span>(Separate multiple email addresses with a comma.)</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Your
                                                                Name*</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text"
                                                                   name="your_name"
                                                                   id="your_name"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label>Your
                                                                Email*</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="email"
                                                                   name="your_email"
                                                                   id="your_email"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row textarea">
                                                        <div class="col-sm-3">
                                                            <label>Message</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <span>(160 characters max)</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <textarea
                                                                    name="message"
                                                                    id="message">Horrell Company has property listings that might interest you.</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>Please enter the
                                                                text from the
                                                                field
                                                                below.</h4>
                                                            <input name="generated_captcha"
                                                                   id="generated_captcha"
                                                                   value="<?php echo generate_random_string( 5 ); ?>"
                                                                   disabled>
                                                            <input type="text"
                                                                   name="verify_captcha"
                                                                   id="verify_captcha"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="checkbox"
                                                                   name="send_me_copy"
                                                                   value="1">
                                                            Send me a copy of
                                                            this email.
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center form-bottom">
                                                        <input type="submit"
                                                               value="Send Now >">
                                                        <a id="clear_form"
                                                           ref="">Clear</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:window.print();"
                                   class="print-btn">
								<span class="icon">
									<?php get_template_part( 'template-parts/svg-icons/icon', 'print' ); ?>
								</span>
                                    Print
                                </a>
                            </div>
                        </div>

						<?php
						$files = []; // array to combine the brochures of properties
						foreach ( $saved_listings as $id ) { // list out all the properties,spaces added to saved listings
							$property_brochure = get_field( 'property_brochure', $id );
							if ( isset( $property_brochure['filename'] ) ) {
								$files[] = $property_brochure['filename'];
							}
							$post_type = get_post_type( $id );

							?>
                            <div class="item d-flex flex-wrap">
                                <div class="img-holder">
									<?php
									echo get_the_post_thumbnail( $id, 'medium' );
									?>
                                </div>
                                <div class="content d-flex justify-content-between flex-column">
                                    <div class="top">
                                        <h3>
                                            <a href="<?php echo get_the_permalink( $id ); ?>"><?php echo horrell_property_title( $id ); ?></a>
                                        </h3>
										<?php
										$terms                      = get_the_terms( $id, 'property_categories' );
										$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : 'Property';
										if ( 'space' == $post_type ) {
											$parent_property                = get_field( 'parent_property', $id );
											$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $parent_property );
											if ( $is_property_for_sale_and_lease ) {
												echo '<p>' . $featured_property_category . ' For Sale Or Lease</p>';
											} else {
												echo '<p>' . $featured_property_category . ' For Lease</p>';
											}
										} else {
											$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $id );
											if ( $is_property_for_sale_and_lease ) {
												echo '<p>' . $featured_property_category . ' For Sale Or Lease</p>'; // label to be displayed, if property is for both sale and lease
											} elseif ( has_term( 'lease', 'property_sale_type', $id ) ) {
												echo '<p>' . $featured_property_category . ' For Lease</p>'; // label to be displayed, if property is for lease
											} elseif ( has_term( 'sale', 'property_sale_type', $id ) ) {
												echo '<p>' . $featured_property_category . ' For Sale</p>'; // label to be displayed, if property is for sale
											}
										}

										?>
                                    </div>
                                    <div class="bottom">
										<?php
										if ( 'space' == $post_type ) {
											$lease_suite_floor_number = get_field( 'lease_suite_floor_number', $id );
											if ( $lease_suite_floor_number ) {
												echo '<div class="property-att">Suite/Fl ' . $lease_suite_floor_number . '</div>';
											}
											$available_space = get_field( 'available_space', $id );
											if ( $available_space ) {
												echo '<div class="property-att">Available <span>' . number_format( $available_space ) . ' SF</span></div>';
											}
											$parent_property = get_field( 'parent_property', $id );
											if ( $is_property_for_sale_and_lease ) {
												$sale_price = get_field( 'sale_price', $parent_property ); // show the sale price of property
												if ( $sale_price ) {
													echo '<div class="property-att">Sale Price <span>' . horrell_formatted_price( $sale_price ) . '</span></div>';
												}
											}
											$space_rental_amount = horrell_lease_amount_html( $id );
											if ( $space_rental_amount ) {
												echo '<div class="property-att">Rental Rate <span>' . $space_rental_amount . '</span></div>';
											}

										} else {
											if ( $is_property_for_sale_and_lease && has_term( 'land', 'property_categories', $id ) ) {
												$lease_lot_size = get_field( 'lease_lot_size', $id );
												if ( $lease_lot_size ) { // only to be shown lot size, since only land properties are to be displayed
													echo '<div class="property-att">Total Lot Size <span>' . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . '</span></div>';
												}
												$sale_price = get_field( 'sale_price', $id ); // show the sale price of property
												if ( $sale_price ) {
													echo '<div class="property-att">Sale Price <span>' . horrell_formatted_price( $sale_price ) . '</span></div>';
												}
												$rental_rate = horrell_lease_amount_html( $id );
												if ( $rental_rate ) {
													echo '<div class="property-att">Rental Rate <span>' . $rental_rate . '</span></div>';
												}
											} else if ( has_term( 'lease', 'property_sale_type', $id ) ) { // for properties, which are for lease
												if ( has_term( 'land', 'property_categories', $id ) ) { // (No need to display lease properties which are "industrial","office","retail")
													$lease_lot_size = get_field( 'lease_lot_size', $id );
													if ( $lease_lot_size ) { // only to be shown lot size, since only land properties are to be displayed
														echo '<div class="property-att">Total Lot Size <span>' . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . '</span></div>';
													}
												} else {
													$lease_available_space_range = get_field( 'lease_available_space_range', $id );
													if ( isset( $lease_available_space_range['min'], $lease_available_space_range['max'] ) ) {
														if ( ! empty( $lease_available_space_range['min'] ) && ! empty( $lease_available_space_range['max'] ) ) {
															echo '<div class="property-att">Available <span>' . number_format( $lease_available_space_range['min'] ) . '  - ' . number_format( $lease_available_space_range['max'] ) . ' Sq Ft</span></div>';
														} elseif ( ! empty( $lease_available_space_range['min'] ) && empty( $lease_available_space_range['max'] ) ) {
															echo '<div class="property-att"><span>' . number_format( $lease_available_space_range['min'] ) . ' Sq Ft Available</span></div>';
														}
													}
												}
												if ( $is_property_for_sale_and_lease ) {
													$sale_price = get_field( 'sale_price', $id ); // show the sale price of property
													if ( $sale_price ) {
														echo '<div class="property-att">Sale Price <span>' . horrell_formatted_price( $sale_price ) . '</span></div>';
													}
												}
												$rental_rate = horrell_lease_amount_html( $id );
												if ( $rental_rate ) {
													echo '<div class="property-att">Rental Rate <span>' . $rental_rate . '</span></div>';
												}
											} else {
												if ( has_term( 'land', 'property_categories', $id ) ) { // if the property category is land, show the lot size.
													$sale_lot_size = get_field( 'sale_lot_size', $id );
													if ( $sale_lot_size ) {
														echo '<div class="property-att">Lot Size <span>' . horrell_fortmatted_area_lot( $sale_lot_size, 'lot' ) . '</span></div>';
													}
												} else { // if the property category is not land, show the building.
													$sale_building_size = get_field( 'sale_building_size', $id );
													if ( $sale_building_size ) {
														echo '<div class="property-att">Building Size <span>' . number_format( $sale_building_size ) . ' SF</span></div>';
													}
												}
												$sale_price = get_field( 'sale_price', $id ); // show the sale price of property
												if ( $sale_price ) {
													echo '<div class="property-att">Sale Price <span>' . horrell_formatted_price( $sale_price ) . '</span></div>';
												}
												if ( $is_property_for_sale_and_lease ) {
													$rental_rate = horrell_lease_amount_html( $id );
													if ( $rental_rate ) {
														echo '<div class="property-att">Rental Rate <span>' . $rental_rate . '</span></div>';
													}
												}

											}
										}
										?>
                                    </div>
                                </div>
                                <div class="rmv-listing">
                                    <a href="#" id="property-<?php echo $id; ?>"
                                       class="link underlined save-listing-btn">Remove
                                        Listing ></a>
                                </div>
                            </div>
							<?php
						}
						?>
                    </div>
                    <form id="download-pdf-form" style="display: none" action=""
                          method="post">
						<?php
						foreach ( $files as $file ) { // combine all files to download (all brochures pdfs)
							$path_info = pathinfo( $file );
							if ( 'pdf' == $path_info['extension'] ) {
								?>
                                <input type="hidden" name="pdfs[]"
                                       value="<?php echo $file; ?>">
								<?php
							}
						}
						?>
                    </form>
					<?php
				} else {
					?>
                    <!-- if no listings available -->
                    <div class="no-listings">
                        <p>You have not saved any listings.</p>
                        <p>To save a listing, click the
                            <span>
							<?php get_template_part( 'template-parts/svg-icons/icon', 'heart' ); ?>
						</span>
                            button associated with the property listing.
                        </p>
                    </div>
					<?php
				}
				?>
            </div>
        </section>
    </main>

<?php
get_footer();
