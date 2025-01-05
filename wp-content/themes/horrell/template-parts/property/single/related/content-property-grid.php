<?php
if ( ! isset( $args['property_id'] ) ) {
	return;
}
$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $args['property_id'] );

//echo get_field('sale_building_size',$args['property_id']);
?>
<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="item">
        <div class="property-image">
            <!-- YT Video Here -->
			<?php
			echo get_the_post_thumbnail( $args['property_id'], 'medium' );
			?>
        </div>
        <div class="property-detail">
            <div class="top">
				<?php
				if ( 'property' == get_post_type() ) { // labels to be displayed for all 'property' post type
					$terms                      = get_the_terms( $args['property_id'], 'property_categories' );
					$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : "Property";

					if ( $is_property_for_sale_and_lease ) { // if property is available for both sale and lease
						echo "<h5><span>" . $featured_property_category . " For Sale Or Lease</span></h5>";
					} else if ( has_term( 'lease', 'property_sale_type', $args['property_id'] ) ) { //for all the lease properties (as only land lease properties are listed, this will automatically become "Land For Lease")
						echo "<h5><span>" . $featured_property_category . " For Lease</span></h5>";
					} elseif ( has_term( 'sale', 'property_sale_type', $args['property_id'] ) ) { //for all sale properties
						echo "<h5><span>" . $featured_property_category . " For Sale</span></h5>";
					}
				}
				?>
                <h3>
                    <a href="<?php echo esc_url( get_the_permalink( $args['property_id'] ) ); ?>">
						<?php echo horrell_property_title( $args['property_id'] ); ?>

                    </a>
                </h3>
            </div>
            <div class="bottom">
				<?php
				if ( $is_property_for_sale_and_lease && has_term( 'land', 'property_categories', $args['property_id'] ) ) {
					$sale_lot_size = get_field( 'sale_lot_size', $args['property_id'] );
					if ( $sale_lot_size ) {
						echo "<div class=\"property-att\">Lot Size <span>" . horrell_fortmatted_area_lot( $sale_lot_size, 'lot' ) . "</span></div>";
					}
					$sale_price = get_field( 'sale_price', $args['property_id'] ); // show the sale price of property
					if ( $sale_price ) {
						echo "<div class=\"property-att\">Sale Price <span>" . horrell_formatted_price( $sale_price ) . "</span></div>";
					}
					$rental_rate = horrell_lease_amount_html( $args['property_id'] );
					if ( $rental_rate ) {
						echo "<div class=\"property-att\">Rental Rate <span>" . $rental_rate . "</span></div>";
					}
				} else if ( has_term( 'sale', 'property_sale_type', $args['property_id'] ) ) { // for all properties, which are for sale
					if ( has_term( 'land', 'property_categories', $args['property_id'] ) ) { // if the property category is land, show the lot size.
						$sale_lot_size = get_field( 'sale_lot_size', $args['property_id'] );
						if ( $sale_lot_size ) {
							echo "<div class=\"property-att\">Lot Size <span>" . horrell_fortmatted_area_lot( $sale_lot_size, 'lot' ) . "</span></div>";
						}
					} else { // if the property category is not land, show the building.
						$sale_building_size = get_field( 'sale_building_size', $args['property_id'] );
						if ( $sale_building_size ) {
							echo "<div class=\"property-att\">Building Size <span>" . number_format( $sale_building_size ) . " SF</span></div>";
						}
					}
					$sale_price = get_field( 'sale_price', $args['property_id'] ); // show the sale price of property
					if ( $is_property_for_sale_and_lease ) {
						$rental_rate = horrell_lease_amount_html( $args['property_id'] );
						if ( $rental_rate ) {
							echo "<div class=\"property-att\">Rental Rate <span>" . $rental_rate . "</span></div>";
						}
					}
					if ( $sale_price ) {
						echo "<div class=\"property-att\">Sale Price <span>" . horrell_formatted_price( $sale_price ) . "</span></div>";
					}
				} else if ( has_term( 'lease', 'property_sale_type', $args['property_id'] ) ) { // for properties, which are for lease
					if ( has_term( 'land', 'property_categories', $args['property_id'] ) ) { // (No need to display lease properties which are "industrial","office","retail")
						$lease_lot_size = get_field( 'lease_lot_size', $args['property_id'] );
						if ( $lease_lot_size ) { // only to be shown lot size, since only land properties are to be displayed
							echo "<div class=\"property-att\">Total Lot Size <span>" . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . "</span></div>";
						}
						$rental_rate = horrell_lease_amount_html( $args['property_id'] );
						if ( $rental_rate ) {
							echo "<div class=\"property-att\">Rental Rate <span>" . $rental_rate . "</span></div>";
						}
						if ( $is_property_for_sale_and_lease ) {
							$sale_price = get_field( 'sale_price', $args['property_id'] ); // show the sale price of property
							if ( $sale_price ) {
								echo "<div class=\"property-att\">Sale Price <span>" . horrell_formatted_price( $sale_price ) . "</span></div>";
							}
						}
					}
				}
				?>
            </div>
        </div>
    </div>
</div>