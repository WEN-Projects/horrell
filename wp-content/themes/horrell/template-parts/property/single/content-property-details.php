<section class="property-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-6 img-col">
                <div class="property-tab-wrapper">
                    <ul class="nav nav-tabs" id="propertyTab" role="tablist">
						<?php
						$video_link                   = get_field( 'property_video' );
						$property_virtual_tour_option = get_field( 'property_virtual_tour_option' );
						$has_video                    = $video_link != '' && filter_var( $video_link, FILTER_VALIDATE_URL ) !== false;
						$mattermore                   = get_field( 'mattermore_view_id' );
						if ( $property_virtual_tour_option != 'none' && ( $has_video || $mattermore ) ) {
							?>
                            <li class="nav-item active" role="presentation">
                                <button class="nav-link active" id="virtual-tour-tab" data-toggle="tab"
                                        data-target="#virtual-tour" type="button" role="tab"
                                        aria-controls="virtual-tour" aria-selected="false">
									<?php echo _e( 'Virtual Tour', 'horrell' ); ?>
                                </button>
                            </li>
							<?php
						}
						?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="property-image-tab" data-toggle="tab"
                                    data-target="#property-image" type="button" role="tab"
                                    aria-controls="property-image" aria-selected="true">
								<?php echo _e( 'Photos', 'horrell' ); ?>
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="propertyTabContent">
						<?php
						$single_thumbnails = get_field( 'property_photo' );
						if ( empty( $single_thumbnails ) && 'space' == get_post_type() ) { // if photos are empty and post type is space, render from parent space
							$parent_property = get_field( 'parent_property' );
							if ( $parent_property ) {
								$single_thumbnails = get_field( 'property_photo', $parent_property );
							}
						}
						if ( $has_video && 'video' == $property_virtual_tour_option ) {
							?>
                            <div class="tab-pane fade show active" id="virtual-tour" role="tabpanel"
                                 aria-labelledby="virtual-tour-tab">
								<?php
								$embed_code = wp_oembed_get(
									$video_link,
									array(
										'rel'    => '0',
										'width'  => '545',
										'height' => '',
									)
								);
								echo $embed_code;
								?>
                            </div>
							<?php
						} elseif ( $mattermore && 'matterport' == $property_virtual_tour_option ) {
							?>
                            <div class="tab-pane fade show active" id="virtual-tour" role="tabpanel"
                                 aria-labelledby="virtual-tour-tab">
                                <iframe width="853" height="480"
                                        src="https://my.matterport.com/show/?m=<?php echo $mattermore; ?>"
                                        frameborder="0" allowfullscreen allow="xr-spatial-tracking"></iframe>
                            </div>
							<?php
						}
						if ( ! empty( $single_thumbnails ) ) {
							?>
                            <div class="tab-pane fade active <?php
							if ( $property_virtual_tour_option == 'none' ) {
								echo 'show';
							}
							?>" id="property-image" role="tabpanel"
                                 aria-labelledby="property-image-tab">
                                <div class="property-image-slider">
									<?php
									foreach ( $single_thumbnails as $thumb ) {
										if ( isset( $thumb['property_photos']['ID'] ) ) {
											echo '<div class="img-holder">' . wp_get_attachment_image( $thumb['property_photos']['ID'], 'full' ) . '</div>';
										}
										?>
										<?php
									}
									?>
                                </div>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-6 content-col">
                <div class="property-desc-wrapper">
					<?php
					if ( isset( $args['is_land_lease_sale'] ) && $args['is_land_lease_sale'] ) { // for all land properties available for both sale and lease
						get_template_part( 'template-parts/property/single/land-lease-sale/content', 'size-pricing' );
						get_template_part( 'template-parts/property/single/content', 'associated-brokers' );
					} else if ( 'space' != get_post_type() ) { // for all rest of properties.
						$sale_or_lease = isset( $args['current_property_property_page_type'] ) ? $args['current_property_property_page_type'] : 'lease';
						get_template_part( 'template-parts/property/single/' . $sale_or_lease . '/content', 'size-pricing' );
						get_template_part( 'template-parts/property/single/content', 'associated-brokers' );
					} else { // for all spaces
						get_template_part( 'template-parts/property/single/space/content', 'size-pricing' );
						$parent_property = get_field( 'parent_property' );
						if ( ! empty( $parent_property ) ) {
							get_template_part( 'template-parts/property/single/content', 'associated-brokers', array( 'parent_property' => $parent_property ) );
						}
					}
					?>
                    <div class="links-wrapper">
						<?php
						$brochure = get_field( 'property_brochure' );
						$siteplan = get_field( 'property_site_plans' );
						echo isset( $brochure['url'] ) ? '<a href="' . $brochure['url'] . '" target="_blank">Brochure</a>' : '';
						echo isset( $siteplan['url'] ) ? '<a href="' . $siteplan['url'] . '" target="_blank">Site Plan</a>' : '';
						global $Horrell_Saved_Listings;
						$is_listing_already_saved = $Horrell_Saved_Listings->check_property_in_saved_listing( get_the_ID() );
						?>
                        <a href="#related-properties" class="related-property-btn related-properties-link">Related
                            Properties</a>
                        <div class="saved-listing-wrapper">
                            <a href="#" id="property-<?php echo get_the_ID(); ?>" class="save-listing-btn no-reload
																<?php
							if ( $is_listing_already_saved ) {
								echo 'saved';
							}
							?>
																													">
                                <span><?php echo ( ! $is_listing_already_saved ) ? ' Save Listing' : 'Listing Saved'; ?></span>
								<?php
								get_template_part( 'template-parts/property/content', 'savelisting-icon' );
								?>
                            </a>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section><!-- .dark-section -->
