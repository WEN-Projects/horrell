<?php
$terms                         = get_the_terms( get_the_ID(), 'property_categories' );
$is_land                       = false;
$sale_building_size            = get_field( 'sale_building_size' );
$sale_property_use_type        = get_field( 'sale_property_use_type' );
$sale_lot_size                 = get_field( 'sale_lot_size' );
$sale_apn_parcell_id           = get_field( 'sale_apn_parcell_id' );
$sale_county                   = get_field( 'sale_county' );
$sale_zoning                   = get_field( 'sale_zoning' );
$sale_building_class           = get_field( 'sale_building_class' );
$sale_property_on_ground_lease = get_field( 'sale_property_on_ground_lease' );
$sale_year_built               = get_field( 'sale_year_built' );
$sale_operating_expenses       = get_field( 'sale_operating_expenses' );
$sale_office_sf                = get_field( 'sale_office_sf' );
$traffic_count                 = get_field( 'traffic_count' );
$dock_high_loading_doors       = get_field( 'sale_dock_high_loading_doors' );
$drive_in_grade_level_doors    = get_field( 'sale_drive_in_grade_level_doors' );
$clear_ceiling_height          = get_field( 'sale_clear_celling_height' );
$column_spacing                = get_field( 'sale_column_spacing' );
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
									$sub_type = get_field( 'sale_' . $term->slug . '_property_sub_type' );
									if ( ! $sub_type ) {
										continue;
									}
									if ( strtolower( $sub_type ) == "other" ) {
										$sub_type_other = get_field( 'sale_' . $term->slug . '_property_sub_other' );
										echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Sub-type</div><div class=\"value\">" . $sub_type_other . "</div></div>";
									} else {
										echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Sub-type</div><div class=\"value\">" . $sub_type . "</div></div>";
									}
								}
							}
						}
						if ( $sale_property_use_type ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property Use Type</div><div class=\"value\">" . $sale_property_use_type . "</div></div>";
						}
						if ( $sale_building_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Building Size</div><div class=\"value\">" . horrell_fortmatted_area_lot( $sale_building_size ) . "</div></div>";
						}
						if ( $is_land && $sale_lot_size ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lot Size</div><div class=\"value\">" . horrell_fortmatted_area_lot( $sale_lot_size, 'lot' ) . " </div ></div > ";
						}
						if ( $sale_apn_parcell_id ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">APN Parcel ID</div><div class=\"value\">" . $sale_apn_parcell_id . "</div></div>";
						}
						if ( $sale_county ) {
							if ( 'other' == $sale_county ) {
								$sale_county = get_field( 'sale_county_other' );
							}
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">County</div><div class=\"value\">" . $sale_county . "</div></div>";
						}
						if ( $sale_zoning ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Zoning</div><div class=\"value\">" . $sale_zoning . "</div></div>";
						}
						if ( $sale_building_class ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Building Class</div><div class=\"value\">" . $sale_building_class . "</div></div>";
						}
						if ( $sale_property_on_ground_lease ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Property on Ground Lease</div><div class=\"value\">" . $sale_property_on_ground_lease . "</div></div>";
						}
						if ( $sale_year_built ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Year Built</div><div class=\"value\">" . $sale_year_built . "</div></div>";
						}
						if ( $sale_operating_expenses ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Operating Expenses</div><div class=\"value\">" . horrell_formatted_price( $sale_operating_expenses, 2 ) . " PSF</div></div>";
						}
						if ( $sale_office_sf ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Office SF</div><div class=\"value\">" . horrell_fortmatted_area_lot( $sale_office_sf ) . "</div></div>";
						}
						if ( $traffic_count ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Traffic Count</div><div class=\"value\">" . $traffic_count . "</div></div>";
						}
						if ( isset( $dock_high_loading_doors['unit'], $dock_high_loading_doors['width'], $dock_high_loading_doors['height'] ) ) {
							if ( ! empty( $dock_high_loading_doors['unit'] ) || ( ! empty( $dock_high_loading_doors['width'] ) && ! empty( $dock_high_loading_doors['height'] ) ) ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Dock-High Doors</div>
									<?php
									if ( ! empty( $dock_high_loading_doors['unit'] ) ) {
										echo "(" . $dock_high_loading_doors['unit'] . ")";
									}
									if ( ! empty( $dock_high_loading_doors['width'] ) && ! empty( $dock_high_loading_doors['height'] ) ) {
										echo " " . $dock_high_loading_doors['width'] . "' x " . $dock_high_loading_doors['height'] . "'";
									}
									?>
                                </div>
								<?php
							}
						}
						if ( isset( $drive_in_grade_level_doors['unit'], $drive_in_grade_level_doors['width'], $drive_in_grade_level_doors['height'] ) ) {
							if ( ! empty( $drive_in_grade_level_doors['unit'] ) || ( ! empty( $drive_in_grade_level_doors['width'] ) && ! empty( $drive_in_grade_level_doors['height'] ) ) ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Drive In Grade-Level Doors</div>
									<?php
									if ( ! empty( $drive_in_grade_level_doors['unit'] ) ) {
										echo "(" . $drive_in_grade_level_doors['unit'] . ")";
									}
									if ( ! empty( $drive_in_grade_level_doors['width'] ) && ! empty( $drive_in_grade_level_doors['height'] ) ) {
										echo " " . $drive_in_grade_level_doors['width'] . "' x " . $drive_in_grade_level_doors['height'] . "'";
									}
									?>
                                </div>
								<?php
							}
						}
						if ( isset( $clear_ceiling_height['min'], $clear_ceiling_height['max'] ) ) {
							if ( ! empty( $clear_ceiling_height['min'] ) && ! empty( $clear_ceiling_height['max'] ) ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Clear Ceiling Height</div><div class=\"value\">" . $clear_ceiling_height['min'] . "' - " . $clear_ceiling_height['max'] . "' " . "</div></div>";

							} else if ( ! empty( $clear_ceiling_height['min'] ) ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Clear Ceiling Height</div><div class=\"value\">" . $clear_ceiling_height['min'] . "'</div></div>";

							}
						}
						if ( isset( $column_spacing['width'], $column_spacing['height'] ) ) {
							if ( ! empty( $column_spacing['width'] ) && ! empty( $column_spacing['height'] ) ) {
								?>
                                <div class="item d-flex align-items-center">
                                    <div class="title">Column Spacing</div>
									<?php
									if ( ! empty( $column_spacing['width'] ) && ! empty( $column_spacing['height'] ) ) {
										echo " " . $column_spacing['width'] . "' x " . $column_spacing['height'] . "'";
									}
									?>
                                </div>
								<?php
							}
						}
						$sale_lighting        = get_field( 'sale_lighting' );
						$sale_electrical      = get_field( 'sale_electrical' );
						$sale_floor_structure = get_field( 'sale_floor_structure' );
						$sale_sprinkler       = get_field( 'sale_sprinkler' );
						$lease_highlights     = get_field( 'lease_highlights' );
						$sale_roof_structure  = get_field( 'sale_roof_structure' );
						$sale_frame           = get_field( 'sale_frame' );
						if ( $sale_lighting ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Lighting</div><div class=\"value\">" . esc_html( $sale_lighting ) . "</div></div>";
						}
						if ( $sale_electrical ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Electrical</div><div class=\"value\">" . esc_html( $sale_electrical ) . "</div></div>";
						}
						if ( $sale_floor_structure ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Floor Structure</div><div class=\"value\">" . esc_html( $sale_floor_structure ) . "</div></div>";
						}
						if ( $sale_sprinkler ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Sprinkler</div><div class=\"value\">" . esc_html( $sale_sprinkler ) . "</div></div>";
						}
						if ( $sale_roof_structure ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Roof Structure</div><div class=\"value\">" . esc_html( $sale_roof_structure ) . "</div></div>";
						}
						if ( $sale_frame ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Frame</div><div class=\"value\">" . esc_html( $sale_frame ) . "</div></div>";
						}
						?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="overview-table">
						<?php
						$sale_highlights = get_field( 'sale_highlights' );
						if ( $sale_highlights ) {
							echo $sale_highlights;
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>