<?php
$available_space_area         = get_field( 'available_space_area' );
$lease_minimum_divisible      = get_field( 'lease_minimum_divisible' );
$lease_maximum_contiguous     = get_field( 'lease_maximum_contiguous' );
$is_rental_rate_negotiable    = get_field( 'is_rental_rate_negotiable' );
$rental_unit                  = get_field( 'rental_unit' );
$lease_space_type             = get_field( 'lease_space_type' );
$lease_type                   = get_field( 'lease_type' );
$lease_date_available         = get_field( 'lease_date_available' );
$lease_sublease               = get_field( 'lease_sublease' );
$lease_sublease_conditions    = get_field( 'lease_sublease_conditions' );
$lease_office_sq_ft           = get_field( 'lease_office_sq_ft' );
$dock_high_loading_doors      = get_field( 'dock_high_loading_doors' );
$drive_in_grade_level_doors   = get_field( 'drive_in_grade_level_doors' );
$clear_ceiling_height         = get_field( 'clear_ceiling_height' );
$clear_ceiling_height_maximum = get_field( 'clear_ceiling_height_maximum' );
$column_spacing               = get_field( 'column_spacing' );
$property_highlights          = get_field( 'property_highlights' );
?>
<section class="overview-section">
    <div class="container">
        <div class="border-wrapper">
            <h2><?php the_title(); ?></h2>
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="overview-table">
						<?php
						if ( $available_space_area ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Available</div><div class=\"value\">" . number_format( $available_space_area ) . " Sq Ft</div></div>";
						}
						if ( $lease_minimum_divisible ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Min Divisible</div><div class=\"value\">" . number_format( $lease_minimum_divisible ) . " Sq Ft</div></div>";
						}
						if ( $lease_maximum_contiguous ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Max Contiguous</div><div class=\"value\">" . number_format( $lease_maximum_contiguous ) . " Sq Ft</div></div>";
						}
						if ( ! $is_rental_rate_negotiable ) {
							$rental_rate = get_field( 'rental_rate' );
							if ( $rental_rate ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Rental Rate</div><div class=\"value\">$" . number_format( $rental_rate, 2 ) . " " . $rental_unit . "</div></div>";
							}
						} else {
							$minimum_rental_rate = get_field( 'minimum_rental_rate' );
							$maximum_rental_rate = get_field( 'maximum_rental_rate' );
							if ( ! empty( $minimum_rental_rate ) && ! empty( $maximum_rental_rate ) ) {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Rental Rate</div><div class=\"value\">Negotiable ($" . number_format( $minimum_rental_rate, 2 ) . " - $" . number_format( $maximum_rental_rate, 2 ) . " " . $rental_unit . ")</div></div>";
							} else {
								echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Rental Rate</div><div class=\"value\">Negotiable</div></div>";
							}
						}
						if ( ! empty( $lease_space_type ) ) {
							?>
                            <div class="item d-flex align-items-center">
                                <div class="title">Space Type</div>
                                <div class="value">
									<?php
									foreach ( $lease_space_type as $key => $space_type ) {
										if ( $key > 0 ) {
											echo ", ";
										}
										if ( "Other" == $space_type ) {
											$lease_space_type_other = get_field( 'lease_space_type_other' );
											echo $space_type . ": " . $lease_space_type_other;
										} else {
											echo $space_type;
										}
									}
									?>
                                </div>
                            </div>
							<?php
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
						if ( $lease_office_sq_ft ) {
							echo "<div class=\"item d-flex align-items-center\"><div class=\"title\">Office</div><div class=\"value\">" . number_format( $lease_office_sq_ft ) . " Sq Ft</div></div>";
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
						?>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
					<?php
					if ( $property_highlights ) {
						echo $property_highlights;
					}
					?>
                </div>
            </div>
			<?php
			if ( isset( $args['parent_property'] ) && ! empty( $args['parent_property'] ) ) {
				?>
                <h2><a href="<?php echo get_the_permalink( $args['parent_property'] ) ?>#available-space-section">VIEW
                        ALL SPACES></a></h2>
				<?php
			}
			?>
        </div>
    </div>
</section>