<?php
$lease_suite_floor_number   = get_field( 'lease_suite_floor_number' );
$available_space_area       = get_field( 'available_space' );
$lease_minimum_divisible    = get_field( 'lease_minimum_divisible' );
$lease_maximum_contiguous   = get_field( 'lease_maximum_contiguous' );
$market_rental_rate         = get_field( 'market_rental_rate' );
$market_rental_rate_unit    = get_field( 'market_rental_rate_unit' );
$lease_space_type           = get_field( 'lease_space_type' );
$lease_type                 = get_field( 'lease_type' );
$lease_date_available       = get_field( 'lease_date_available' );
$lease_sublease             = get_field( 'lease_sublease' );
$lease_sublease_conditions  = get_field( 'lease_sublease_conditions' );
$lease_office_sq_ft         = get_field( 'lease_office_sq_ft' );
$dock_high_loading_doors    = get_field( 'dock_high_loading_doors' );
$drive_in_grade_level_doors = get_field( 'drive_in_grade_level_doors' );
$clear_ceiling_height       = get_field( 'clear_ceiling_height' );
$column_spacing             = get_field( 'column_spacing' );
$property_highlights        = get_field( 'property_highlights' );
?>
<section class="overview-section">
	<div class="container">
		<div class="border-wrapper">
			<h2>
			<?php
			if ( $lease_suite_floor_number ) {
					echo 'Suite/Floor ' . $lease_suite_floor_number;
			}
			?>
				</h2>
			<div class="row">
				<div class="col-lg-5 col-md-6">
					<div class="overview-table">
						<?php


						if ( $available_space_area ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Available</div><div class="value">' . horrell_fortmatted_area_lot( $available_space_area ) . '</div></div>';
						}
						if ( $lease_minimum_divisible ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Min Divisible</div><div class="value">' . number_format( $lease_minimum_divisible ) . ' Sq Ft</div></div>';
						}
						if ( $lease_maximum_contiguous ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Max Contiguous</div><div class="value">' . number_format( $lease_maximum_contiguous ) . ' Sq Ft</div></div>';
						}
						$rental_rate = horrell_lease_amount_html( get_the_ID() );
						if ( $rental_rate ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Rental Rate</div><div class="value">' . $rental_rate . '</div></div>';
						}
						if ( ! empty( $lease_space_type ) ) {
							?>
							<div class="item d-flex align-items-center">
								<div class="title">Space Type</div>
								<div class="value">
									<?php
									foreach ( $lease_space_type as $key => $space_type ) {
										if ( $key > 0 ) {
											echo ', ';
										}
										if ( 'Other' == $space_type ) {
											$lease_space_type_other = get_field( 'lease_space_type_other' );
											echo $space_type . ': ' . $lease_space_type_other;
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
							echo '<div class="item d-flex align-items-center"><div class="title">Lease Type</div><div class="value">' . $lease_type . '</div></div>';
						}
						if ( ! empty( $lease_date_available ) ) {
							$start_date = strtotime( $lease_date_available );
							$today      = strtotime( date( 'Y-m-d' ) );
							$date       = ( $today >= $start_date ) ? 'Now' : $lease_date_available;
							echo '<div class="item d-flex align-items-center"><div class="title">Date Available</div><div class="value">' . $date . '</div></div>';
						}
						if ( $lease_sublease ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Direct/Sublease</div><div class="value">' . $lease_sublease . '</div></div>';
						}
						if ( isset( $lease_sublease_conditions['sublease_expires'] ) && ! empty( $lease_sublease_conditions['sublease_expires'] ) ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Sublease Expires</div><div class="value">' . $lease_sublease_conditions['sublease_expires'] . '</div></div>';
						}
						if ( isset( $lease_sublease_conditions['lease_term'] ) && ! empty( $lease_sublease_conditions['lease_term'] ) ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Lease Term</div><div class="value">' . $lease_sublease_conditions['lease_term'] . '</div></div>';
						}
						if ( $lease_office_sq_ft ) {
							echo '<div class="item d-flex align-items-center"><div class="title">Office</div><div class="value">' . number_format( $lease_office_sq_ft ) . ' Sq Ft</div></div>';
						}
						if ( isset( $dock_high_loading_doors['unit'], $dock_high_loading_doors['width'], $dock_high_loading_doors['height'] ) ) {
							if ( ! empty( $dock_high_loading_doors['unit'] ) || ( ! empty( $dock_high_loading_doors['width'] ) && ! empty( $dock_high_loading_doors['height'] ) ) ) {
								?>
								<div class="item d-flex align-items-center">
									<div class="title">Dock-High Doors</div>
									<?php
									if ( ! empty( $dock_high_loading_doors['unit'] ) ) {
										echo '(' . $dock_high_loading_doors['unit'] . ')';
									}
									if ( ! empty( $dock_high_loading_doors['width'] ) && ! empty( $dock_high_loading_doors['height'] ) ) {
										echo ' ' . $dock_high_loading_doors['width'] . "' x " . $dock_high_loading_doors['height'] . "'";
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
										echo '(' . $drive_in_grade_level_doors['unit'] . ')';
									}
									if ( ! empty( $drive_in_grade_level_doors['width'] ) && ! empty( $drive_in_grade_level_doors['height'] ) ) {
										echo ' ' . $drive_in_grade_level_doors['width'] . "' x " . $drive_in_grade_level_doors['height'] . "'";
									}
									?>
								</div>
								<?php
							}
						}
						if ( isset( $clear_ceiling_height['min'], $clear_ceiling_height['max'] ) ) {
							if ( ! empty( $clear_ceiling_height['min'] ) && ! empty( $clear_ceiling_height['max'] ) ) {
								echo '<div class="item d-flex align-items-center"><div class="title">Clear Ceiling Height</div><div class="value">' . $clear_ceiling_height['min'] . "' - " . $clear_ceiling_height['max'] . "' " . '</div></div>';

							} elseif ( ! empty( $clear_ceiling_height['min'] ) ) {
								echo '<div class="item d-flex align-items-center"><div class="title">Clear Ceiling Height</div><div class="value">' . $clear_ceiling_height['min'] . "'</div></div>";

							}
						}
						if ( isset( $column_spacing['width'], $column_spacing['height'] ) ) {
							if ( ! empty( $column_spacing['width'] ) && ! empty( $column_spacing['height'] ) ) {
								?>
								<div class="item d-flex align-items-center">
									<div class="title">Column Spacing</div>
									<?php
									if ( ! empty( $column_spacing['width'] ) && ! empty( $column_spacing['height'] ) ) {
										echo ' ' . $column_spacing['width'] . "' x " . $column_spacing['height'] . "'";
									}
									?>
								</div>
								<?php
							}
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
				<h2><a href="<?php echo get_the_permalink( $args['parent_property'] ); ?>#available-space-section">VIEW
						ALL AVAILABLE SPACES></a></h2>
				<?php
			}
			?>
		</div>
	</div>
</section>
