<?php
$terms                             = get_the_terms( get_the_ID(), 'property_categories' );
$property_subtype                  = get_field( 'property_subtype' );
$building_size                     = get_field( 'building_size' );
$lot_size                          = get_field( 'lot_size' );
$property_apn_parcel_id            = get_field( 'property_apn_parcel_id' );
$property_county                   = get_field( 'property_county' );
$property_zoning_description       = get_field( 'property_zoning_description' );
$property_building_class           = get_field( 'property_building_class' );
$property_property_on_ground_lease = get_field( 'property_property_on_ground_lease' );
$property_year_built               = get_field( 'property_year_built' );
$property_occupancy                = get_field( 'property_occupancy' );
$property_number_of_stories        = get_field( 'property_number_of_stories' );
$property_industrial_office        = get_field( 'property_industrial_office' );
$property_operating_expenses       = get_field( 'property_operating_expenses' );
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
						$current_property_sale_type = isset( $_GET["ps_type"] ) ? $_GET["ps_type"] : "";
						if ( has_term( 'lease', 'property_sale_type' ) && "sale" != $current_property_sale_type ) { // if the property is for lease type(only) or lease data is to be displayed(when property belong ot both lease and sale)
							// all lease specific fields
							$lease_gross_leasable_area = get_field( 'lease_gross_leasable_area' );
							$lease_type                = get_field( 'lease_type' );
							$lease_date_available      = get_field( 'lease_date_available' );
							$lease_sublease            = get_field( 'lease_sublease' );
							$lease_sublease_conditions = get_field( 'lease_sublease_conditions' );
							$lease_tenancy             = get_field( 'lease_tenancy' );
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
						} else if ( has_term( 'sale', 'property_sale_type' ) ) {
							// all sales specific fields
							$sale_submarket                        = get_field( 'sale_submarket' );
							$sale_commission_split                 = get_field( 'sale_commission_split' );
							$sale_construction_status              = get_field( 'sale_construction_status' );
							$dock_high_loading_doors      = get_field( 'dock_high_loading_doors' );
							$drive_in_grade_level_doors   = get_field( 'drive_in_grade_level_doors' );
							$clear_ceiling_height         = get_field( 'clear_ceiling_height' );
							$clear_ceiling_height_maximum = get_field( 'clear_ceiling_height_maximum' );
							$column_spacing               = get_field( 'column_spacing' );
							$property_traffic_count                = get_field( 'property_traffic_count' );
							if ( $sale_submarket ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Area</div><div class=\"value\">" . $sale_submarket . "</div></div>";
							}
							if ( $sale_commission_split ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Commission Split</div><div class=\"value\">" . $sale_commission_split . "</div></div>";
							}
							if ( $sale_construction_status ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Construction Status</div><div class=\"value\">" . $sale_construction_status . "</div></div>";
							}
							if ( $dock_high_loading_doors['unit'] || $dock_high_loading_doors['dimension'] ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Dock-High Doors</div>
                                    <div class="value">
										<?php
										if ( $dock_high_loading_doors['unit'] ) {
											echo "(" . $dock_high_loading_doors['unit'] . ")";
										}
										if ( $dock_high_loading_doors['dimension'] ) {
											echo esc_html( $dock_high_loading_doors['dimension'] );
										}
										?>
                                    </div>
                                </div>
								<?php
							}
							if ( $drive_in_grade_level_doors ['unit'] || $drive_in_grade_level_doors ['dimension'] ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Drive In Doors</div>
                                    <div class="value">
										<?php
										if ( $drive_in_grade_level_doors['unit'] ) {
											echo "(" . $drive_in_grade_level_doors['unit'] . ")";
										}
										if ( $drive_in_grade_level_doors['dimension'] ) {
											echo esc_html( $drive_in_grade_level_doors['dimension'] );
										}
										?>
                                    </div>
                                </div>
								<?php
							}
							if ( $clear_ceiling_height ) {
								if ( $clear_ceiling_height_maximum ) {
									echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Clear Ceiling Height</div><div class=\"value\">" . $clear_ceiling_height . "' - " . $clear_ceiling_height_maximum . "' " . "</div></div>";

								} else {
									echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Clear Ceiling Height</div><div class=\"value\">" . $clear_ceiling_height . "'</div></div>";

								}
							}
							if ( isset( $column_spacing['dimension'] ) && ! empty( $column_spacing['dimension'] ) ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Column Spacing</div>
                                    <div class="value">
										<?php
										echo esc_html( $column_spacing['dimension'] );
										?>
                                    </div>
                                </div>
								<?php
							}
							if ( have_rows( 'property_anchor_tenants' ) ):
								while ( have_rows( 'property_anchor_tenants' ) ): the_row();
									$tenant = get_sub_field( 'anchor_tenant' );
									if ( ! empty( $tenant ) ) {
										echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Anchor Tenant</div><div class=\"value\">" . $tenant . "</div></div>";
									}
								endwhile; endif;
							if ( $property_traffic_count ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Traffic Count</div><div class=\"value\">" . $property_traffic_count . "</div></div>";
							}

						}
						?>

                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <ul class="attributes">
						<?php
						$property_available_utilities = get_field( 'property_available_utilities' );
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
						$property_lighting        = get_field( 'property_lighting' );
						$property_electrical      = get_field( 'property_electrical' );
						$property_floor_structure = get_field( 'property_floor_structure' );
						$property_frame           = get_field( 'property_frame' );
						$property_walls           = get_field( 'property_walls' );
						$property_roof_structure  = get_field( 'property_roof_structure' );
						$property_sprinkler       = get_field( 'property_sprinkler' );
						$property_highlights      = get_field( 'property_highlights' );

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