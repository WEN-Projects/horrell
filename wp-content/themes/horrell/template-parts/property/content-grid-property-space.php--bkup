<?php
$wrapper_class = "col-lg-4 col-sm-6";
if ( isset( $args["is_related_properties"] ) && $args["is_related_properties"] == true ) {
	$wrapper_class = "col-lg-3 col-md-4 col-sm-6";
}
?>
<div class="<?php echo $wrapper_class; ?>">
    <div class="item">
        <div class="property-image">
            <!-- YT Video Here -->
			<?php
			the_post_thumbnail( 'medium' );
			?>
        </div>
        <div class="property-detail">
            <div class="top">
				<?php
				$post_id = get_the_ID();
				if ( 'property' == get_post_type() ) { // labels to be displayed for all 'property' post type
					$terms                      = get_the_terms( $post_id, 'property_categories' );
					$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : "Property";
					if ( has_term( 'lease', 'property_sale_type' ) && has_term( 'sale', 'property_sale_type' ) ) {
						echo "<h5><span>" . $featured_property_category . " For Sale Or Lease</span></h5>";
					} elseif ( has_term( 'lease', 'property_sale_type' ) ) {
						echo "<h5><span>" . $featured_property_category . " For Lease</span></h5>";
					} elseif ( has_term( 'sale', 'property_sale_type' ) ) {
						echo "<h5><span>" . $featured_property_category . " For Sale</span></h5>";
					}
				} else {
					echo "<h5><span>For Space</span></h5>"; // labels to be displayed for all 'space' post type
				}
				?>
                <h3>
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_title(); ?></a>
                </h3>
            </div>
            <div class="bottom">
				<?php

				$size_and_price_details_for = get_field( 'size_and_price_details_for' );
				$lot_size                   = get_field( 'lot_size' );
				if ( ! empty( $size_and_price_details_for ) ) {
					if ( in_array( "sale", $size_and_price_details_for ) ) {
						$building_size = get_field( 'building_size' );
						$sale_price    = get_field( 'sale_price' );
						echo $building_size ? "<div class=\"property-att\">Building Size <span>" . $building_size . " SF</span></div>" : "<div class=\"property-att\">Total Lot Size <span>" . $lot_size . " Acres</span></div>";
						echo "<div class=\"property-att\">Sale Price <span>$" . number_format( $sale_price ) . "</span></div>";
					} else {
						$available_space_area      = get_field( 'available_space_area' );
						$rental_unit               = get_field( 'rental_unit' );
						$is_rental_rate_negotiable = get_field( 'is_rental_rate_negotiable' );
						echo $available_space_area ? "<div class=\"property-att\">Available <span>" . $available_space_area . " SF</span></div>" : "<div class=\"property-att\">Total Lot Size <span>" . $lot_size . " Acres</span></div>";
						if ( ! $is_rental_rate_negotiable ) {
							$rental_rate = get_field( 'rental_rate' );
							if ( $rental_rate ) {
								echo "<div class=\"property-att\">Rental Rate <span>$" . number_format( $rental_rate, 2 ) . " " . $rental_unit . "</span></div>";
							}
						} else {
							$minimum_rental_rate = get_field( 'minimum_rental_rate' );
							$maximum_rental_rate = get_field( 'maximum_rental_rate' );
							if ( ! empty( $minimum_rental_rate ) && ! empty( $maximum_rental_rate ) ) {
								echo "<div class=\"property-att\">Rental Rate <span>Negotiable ($" . number_format( $minimum_rental_rate, 2 ) . " - $" . number_format( $maximum_rental_rate, 2 ) . " " . $rental_unit . ")</span></div>";
							} else {
								echo "<div class=\"property-att\">Rental Rate <span>Negotiable</span></div>";
							}
						}
					}
				}
				global $Horrell_Saved_Listings;
				$is_listing_already_saved = $Horrell_Saved_Listings->check_property_in_saved_listing( get_the_ID() );
				?>
                <a href="#" id="property-<?php echo $post_id; ?>"
                   class="save-listing-btn no-reload <?php
				   echo $is_listing_already_saved ? 'saved' : ''; ?>">
                    <span><?php echo ( ! $is_listing_already_saved ) ? " Save Listing" : "Listing Saved"; ?></span>
					<?php
					get_template_part( "template-parts/property/content", "savelisting-icon" );
					?>
                </a>
            </div>
        </div>
    </div>
</div>