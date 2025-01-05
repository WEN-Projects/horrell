<?php
$terms = get_the_terms( get_the_ID(), 'property_categories' );
//$property_subtype                  = get_field( 'property_subtype' );
//$lease_max_contiguous_sf       = get_field( 'lease_max_contiguous_sf' );
$is_land = false;
//$lease_market_rental_rate      = get_field( 'lease_market_rental_rate' );
//$lease_market_rental_rate_unit = get_field( 'lease_market_rental_rate_unit' );
$lease_type                = get_field( 'lease_type' );
$lease_total_building_size = get_field( 'lease_total_building_size' );
$lease_gross_leasable_area = get_field( 'lease_gross_leasable_area' );
$lease_lot_size            = get_field( 'lease_lot_size' );
$lease_apn_parcell_id      = get_field( 'lease_apn_parcell_id' );
$lease_county              = get_field( 'lease_county' );
$lease_zoning              = get_field( 'lease_zoning' );
$lease_building_class      = get_field( 'lease_building_class' );
$lease_year_built          = get_field( 'lease_year_built' );
$lease_operating_expenses  = get_field( 'lease_operating_expenses' );
$lease_traffic_count       = get_field( 'traffic_count' );
?>
<section class="overview-section">
    <div class="container">
        <div class="border-wrapper">
            <h2>Overview</h2>
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="overview-table">
						<?php
						if ( ! empty( $terms ) ) {
							$term_value = "";
							foreach ( $terms as $key => $term ) {
								if ( $term->name ) {
									$term_value .= $key > 0 ? ", " . $term->name : $term->name;
									if ( 'land' == $term->slug ) {
										$is_land = true;
									}
								}
							}
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Type</div><div class=\"value\">" . $term_value . "</div></div>";
							foreach ( $terms as $key => $term ) {
								if ( $term->name ) {
									$sub_type = get_field( 'lease_' . $term->slug . '_property_sub_type' );
									if ( ! $sub_type ) {
										continue;
									}
									if ( strtolower( $sub_type ) == "other" ) {
										$sub_type_other = get_field( 'lease_' . $term->slug . '_property_sub_other' );
										echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Sub-type</div><div class=\"value\">" . $sub_type_other . "</div></div>";
									} else {
										echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Sub-type</div><div class=\"value\">" . $sub_type . "</div></div>";
									}
								}
							}
						}
						$lease_amount = horrell_lease_amount_html( get_the_ID() );
						if ( $is_land && $lease_type ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lease Type</div><div class=\"value\">" . $lease_type . "</div></div>";
						}
						if ( $lease_total_building_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Total Building Size</div><div class=\"value\">" . horrell_fortmatted_area_lot( $lease_total_building_size ) . "</div></div>";
						}
						if ( $lease_gross_leasable_area ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Gross Leasbale Area</div><div class=\"value\">" . horrell_fortmatted_area_lot( $lease_gross_leasable_area ) . "</div></div>";
						}
						if ( $lease_lot_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Total Lot Size</div><div class=\"value\">" . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . "</div></div>";
						}
						if ( $lease_apn_parcell_id ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">APN Parcel ID</div><div class=\"value\">" . $lease_apn_parcell_id . "</div></div>";
						}
						if ( $lease_county ) {
							if ( 'other' == $lease_county ) {
								$lease_county = get_field( 'lease_county_other' );
							}
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">County</div><div class=\"value\">" . $lease_county . "</div></div>";
						}
						if ( $lease_zoning ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Zoning</div><div class=\"value\">" . $lease_zoning . "</div></div>";
						}
						if ( $lease_building_class ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Building Class</div><div class=\"value\">" . $lease_building_class . "</div></div>";
						}
						if ( $lease_year_built ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Year Built</div><div class=\"value\">" . $lease_year_built . "</div></div>";
						}
						if ( $lease_operating_expenses ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Operating Expenses</div><div class=\"value\">" . horrell_formatted_price( $lease_operating_expenses, 2 ) . " PSF</div></div>";
						}
						if ( $lease_traffic_count ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Traffic Count</div><div class=\"value\">" . $lease_traffic_count . "</div></div>";
						}
						$lease_lighting   = get_field( 'lease_lighting' );
						$lease_electrical = get_field( 'lease_electrical' );
						$lease_sprinkler  = get_field( 'lease_sprinkler' );
						$lease_highlights = get_field( 'lease_highlights' );
						if ( $lease_lighting ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lighting</div><div class=\"value\">" . esc_html( $lease_lighting ) . "</div></div>";
						}
						if ( $lease_electrical ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Electrical</div><div class=\"value\">" . esc_html( $lease_electrical ) . "</div></div>";
						}
						if ( $lease_sprinkler ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Sprinkler</div><div class=\"value\">" . esc_html( $lease_sprinkler ) . "</div></div>";
						}
						?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="overview-table">
						<?php
						if ( $lease_highlights ) {
							echo $lease_highlights;
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>