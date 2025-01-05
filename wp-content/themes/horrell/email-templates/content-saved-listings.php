<?php
if ( ! isset( $args['saved_listings'] ) ) {
	return;
}
?>
<table style="width: 100%; padding: 0; margin: 0; border-spacing: 0; border-collapse: collapse;">
    <tbody>
	<?php
	if ( ! empty( $args['saved_listings'] ) ) {
		foreach ( $args['saved_listings'] as $id ) {
			?>
            <tr style="border-bottom: 1px solid #cecece;">
                <td style="vertical-align: top; width: 120px; padding-bottom: 15px; padding-top: 15px;">
					<?php
					echo get_the_post_thumbnail( $id, 'medium' );
					?>
                </td>
                <!-- property info -->
                <td style="text-align: left; padding-left: 20px; vertical-align: top; padding-bottom: 15px; padding-top: 15px;">
                    <h2 style="margin: 0; font-size: 14px; line-height: 1.4; font-family: 'myriad pro', sans-serif; font-weight: 700;">
                        <a style="font: inherit; color: #b99c64; text-decoration: underline !important;"
                           href="<?php echo get_the_permalink( $id ); ?>"><?php echo horrell_property_title( $id ); ?></a>
                    </h2>
					<?php
					$terms                      = get_the_terms( $id, 'property_categories' );
					$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : "Property";
					if ( 'space' == get_post_type( $id ) ) { // labels to be displayed for all 'space' post type
						$lease_suite_floor_number = get_field( 'lease_suite_floor_number', $id );
						echo "<p><span>Space " . $lease_suite_floor_number . " " . $featured_property_category . " Space For Lease</span></p>"; //labels to be displayed for all 'space' post type
					} else { // labels to be displayed for all 'property' post type
						if ( has_term( 'lease', 'property_sale_type', $id ) && has_term( 'sale', 'property_sale_type', $id ) ) {
							echo "<p>" . $featured_property_category . " For Sale Or Lease</p>";
						} elseif ( has_term( 'lease', 'property_sale_type', $id ) ) {
							echo "<p>" . $featured_property_category . " For Lease</p>";
						} elseif ( has_term( 'sale', 'property_sale_type', $id ) ) {
							echo "<p>" . $featured_property_category . " For Sale</p>";
						}
					}
					?>
                    <div class="bottom">
						<?php
						if ( 'space' == get_post_type( $id ) ) {
							$available_space         = get_field( 'available_space', $id );
							$market_rental_rate      = get_field( 'market_rental_rate', $id );
							$market_rental_rate_unit = get_field( 'market_rental_rate_unit', $id );
							if ( $available_space ) {
								echo "<div class=\"property-att\">Available <span>" . number_format( $available_space ) . " SF</span></div>";
							}
							if ( $market_rental_rate && $market_rental_rate_unit ) {
								echo "<div class=\"property-att\">Rental Rate <span>" . horrell_formatted_price( $market_rental_rate ) . " " . $market_rental_rate_unit . "</span></div>";
							}
						} else {
							if ( has_term( 'lease', 'property_sale_type', $id ) ) { // for properties, which are for lease
								if ( has_term( 'land', 'property_categories', $id ) ) { // (No need to display lease properties which are "industrial","office","retail")
									$lease_lot_size = get_field( 'lease_lot_size', $id );
									if ( $lease_lot_size ) { // only to be shown lot size, since only land properties are to be displayed
										echo "<div class=\"property-att\">Total Lot Size <span>" . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . "</span></div>";
									}
								} else {
									$lease_available_space_range = get_field( 'lease_available_space_range', $id );
									if ( isset( $lease_available_space_range['min'], $lease_available_space_range['max'] ) && ! empty( $lease_available_space_range['min'] ) && ! empty( $lease_available_space_range['min'] ) ) {
										echo "<div class=\"property-att\">Available <span>(" . number_format( $lease_available_space_range['min'] ) . "  - " . number_format( $lease_available_space_range['max'] ) . " ) Sq Ft</span></div>";
									}
								}
								$rental_rate = horrell_lease_amount_html( $id );
								if ( $rental_rate ) {
									echo "<div class=\"property-att\">Rental Rate <span>" . $rental_rate . "</span></div>";
								}
							} else {
								if ( has_term( 'land', 'property_categories', $id ) ) { // if the property category is land, show the lot size.
									$sale_lot_size = get_field( 'sale_lot_size', $id );
									if ( $sale_lot_size ) {
										echo "<div class=\"property-att\">Lot Size <span>" . horrell_fortmatted_area_lot( $sale_lot_size, 'lot' ) . "</span></div>";
									}
								} else { // if the property category is not land, show the building.
									$sale_building_size = get_field( 'sale_building_size', $id );
									if ( $sale_building_size ) {
										echo "<div class=\"property-att\">Building Size <span>" . number_format( $sale_building_size ) . " SF</span></div>";
									}
								}
								$sale_price = get_field( 'sale_price', $id ); // show the sale price of property
								if ( $sale_price ) {
									echo "<div class=\"property-att\">Sale Price <span>" . horrell_formatted_price( $sale_price ) . "</span></div>";
								}
							}
						}
						?>
                    </div>
                </td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
</table>