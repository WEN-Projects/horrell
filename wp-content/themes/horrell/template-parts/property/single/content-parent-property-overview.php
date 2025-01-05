<?php
if ( ! isset( $args['parent_property'] ) ) {
	return;
}

$parent_property                   = $args['parent_property'];
$terms                             = get_the_terms( $parent_property, 'property_categories' );
$property_subtype                  = get_field( 'property_subtype', $parent_property );
$building_size                     = get_field( 'building_size', $parent_property );
$lot_size                          = get_field( 'lot_size', $parent_property );
$property_apn_parcel_id            = get_field( 'property_apn_parcel_id', $parent_property );
$property_county                   = get_field( 'property_county', $parent_property );
$property_zoning_description       = get_field( 'property_zoning_description', $parent_property );
$property_building_class           = get_field( 'property_building_class', $parent_property );
$property_property_on_ground_lease = get_field( 'property_property_on_ground_lease', $parent_property );
$property_year_built               = get_field( 'property_year_built', $parent_property );
$property_occupancy                = get_field( 'property_occupancy', $parent_property );
$property_number_of_stories        = get_field( 'property_number_of_stories', $parent_property );
$property_industrial_office        = get_field( 'property_industrial_office', $parent_property );
$property_operating_expenses       = get_field( 'property_operating_expenses', $parent_property );
?>
<section class="overview-section">
    <div class="container">
        <div class="border-wrapper">
            <h2>Overview</h2>
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="overview-table">
						<?php
						if ( isset( $terms[0]->name ) ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Type</div><div class=\"value\">" . $terms[0]->name . "</div></div>";
						}
						if ( $property_subtype ) {
							?>
                            <div class="item d-flex align-items-center">
                                <div class="title">Property Sub-type</div>
								<?php
								echo "other" == $property_subtype ? "<div class=\"value\">" . get_field( 'property_subtype_other' ) . "></div>" : "<div class=\"value\">" . $property_subtype . "</div>";

								?>

                            </div>
							<?php
						}
						if ( $building_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Total Building</div><div class=\"value\">" . $building_size . " Sq Ft</div></div>";
						}
						if ( $lot_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lot Size</div><div class=\"value\">" . $lot_size . " Acres</div></div>";
						}
						if ( $property_apn_parcel_id ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">APN/Parcel ID</div><div class=\"value\">" . $property_apn_parcel_id . "</div></div>";
						}
						if ( $property_county ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Country</div><div class=\"value\">" . $property_county . "</div></div>";
						}
						if ( $property_zoning_description ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Zoning</div><div class=\"value\">" . $property_zoning_description . "</div></div>";
						}
						if ( $property_building_class ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Building Class</div><div class=\"value\">" . $property_building_class . "</div></div>";
						}
						if ( $property_property_on_ground_lease ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Ground Lease</div><div class=\"value\">" . $property_property_on_ground_lease . "</div></div>";
						}
						if ( $property_year_built ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Year Built</div><div class=\"value\">" . $property_year_built . "</div></div>";
						}
						if ( $property_occupancy ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Occupancy</div><div class=\"value\">" . $property_occupancy . "%</div></div>";
						}
						if ( $property_number_of_stories ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">No. of Stories</div><div class=\"value\">" . $property_number_of_stories . "</div></div>";
						}
						if ( $property_industrial_office ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Office</div><div class=\"value\">" . $property_industrial_office . " Sq Ft</div></div>";
						}
						if ( $property_operating_expenses ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Operating Expenses</div><div class=\"value\">$" . number_format( $property_operating_expenses ) . " PSF</div></div>";
						}
						if ( has_term( 'lease', 'property_sale_type', $parent_property ) ) {
							// all lease specific fields
							$lease_gross_leasable_area = get_field( 'lease_gross_leasable_area', $parent_property );
							$lease_type                = get_field( 'lease_type', $parent_property );
							$lease_date_available      = get_field( 'lease_date_available', $parent_property );
							$lease_sublease            = get_field( 'lease_sublease', $parent_property );
							$lease_sublease_conditions = get_field( 'lease_sublease_conditions', $parent_property );
							$lease_tenancy             = get_field( 'lease_tenancy', $parent_property );
							if ( $lease_gross_leasable_area ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Gross Leasable Area</div><div class=\"value\">" . $lease_gross_leasable_area . " Sq Ft</div></div>";
							}
							if ( $lease_type ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lease Type</div><div class=\"value\">" . $lease_type . "</div></div>";
							}
							if ( ! empty( $lease_date_available ) ) {
								$start_date = strtotime( $lease_date_available );
								$today      = strtotime( date( "Y-m-d" ) );
								$date       = ( $today >= $start_date ) ? 'Now' : $lease_date_available;
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Date Available</div><div class=\"value\">" . $date . "</div></div>";
							}
							if ( $lease_sublease ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Direct/Sublease</div><div class=\"value\">" . $lease_sublease . "</div></div>";
							}
							if ( isset( $lease_sublease_conditions['sublease_expires'] ) && ! empty( $lease_sublease_conditions['sublease_expires'] ) ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Sublease Expires</div><div class=\"value\">" . $lease_sublease_conditions['sublease_expires'] . "</div></div>";
							}
							if ( isset( $lease_sublease_conditions['lease_term'] ) && ! empty( $lease_sublease_conditions['lease_term'] ) ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lease Term</div><div class=\"value\">" . $lease_sublease_conditions['lease_term'] . "</div></div>";
							}
							if ( $lease_tenancy ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Tenancy</div><div class=\"value\">" . $lease_tenancy . "</div></div>";
							}
						}
						?>

                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <ul class="attributes">
						<?php
						$property_available_utilities = get_field( 'property_available_utilities', $parent_property );
						if ( $property_available_utilities ) {
							if ( ! empty( $property_available_utilities['utilities'] ) ) {
								foreach ( $property_available_utilities['utilities'] as $utility ) {
									?>

                                    <li><?php
										echo $utility;
										if ( $property_available_utilities[ strtolower( $utility ) . '_description' ] ) {
											echo ": " . $property_available_utilities[ strtolower( $utility ) . '_description' ];
										}
										?>
                                    </li>

									<?php
								}
							}
						}
						$property_lighting        = get_field( 'property_lighting', $parent_property );
						$property_electrical      = get_field( 'property_electrical', $parent_property );
						$property_floor_structure = get_field( 'property_floor_structure', $parent_property );
						$property_frame           = get_field( 'property_frame', $parent_property );
						$property_walls           = get_field( 'property_walls', $parent_property );
						$property_roof_structure  = get_field( 'property_roof_structure', $parent_property );
						$property_sprinkler       = get_field( 'property_sprinkler', $parent_property );
						$property_highlights      = get_field( 'property_highlights', $parent_property );

						if ( $property_lighting ) {
							echo "<li>Lighting: " . esc_html( $property_lighting ) . "</li>";
						}
						if ( $property_electrical ) {
							echo "<li>Electrical: " . esc_html( $property_electrical ) . "</li>";
						}
						if ( $property_floor_structure ) {
							echo "<li>Floor Structure: " . esc_html( $property_floor_structure ) . "</li>";
						}
						if ( $property_frame ) {
							echo "<li>Frame: " . esc_html( $property_frame ) . "</li>";
						}
						if ( $property_walls ) {
							echo "<li>Walls: " . esc_html( $property_walls ) . "</li>";
						}
						if ( $property_roof_structure ) {
							echo "<li>Roof Structure: " . esc_html( $property_roof_structure ) . "</li>";
						}
						if ( $property_sprinkler ) {
							echo "<li>Sprinkler: " . esc_html( $property_sprinkler ) . "</li>";
						}
						?>
                    </ul>
					<?php
					if ( $property_lighting ) {
						echo $property_highlights;
					}
					?>
                </div>
            </div>
        </div>
    </div>
</section>