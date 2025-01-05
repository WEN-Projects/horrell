<?php
$lease_spaces = get_field( 'lease_spaces' );
if ( ! empty( $lease_spaces ) ) {
	?>
    <section id="available-space-section" class="available-space-section">
        <div class="container">
            <div class="border-wrapper">
                <h2>Available Space</h2>
				<?php
				$property_categories        = get_the_terms( get_the_ID(), 'property_categories' );
				$featured_property_category = isset( $property_categories[0]->name ) ? $property_categories[0]->name : "";
				foreach ( $lease_spaces as $space ) { //render all available spaces associated to parent properties.
					$lease_suite_floor_number  = get_field( 'lease_suite_floor_number', $space->ID );
					$available_space_area      = get_field( 'available_space', $space->ID );
					$market_rental_rate        = get_field( 'market_rental_rate', $space->ID );
					$market_rental_rate_unit   = get_field( 'market_rental_rate_unit', $space->ID );
					$is_rental_rate_negotiable = get_field( 'is_rental_rate_negotiable', $space->ID );
					$lease_type                = get_field( 'lease_type', $space->ID );
					$lease_space_type          = get_field( 'lease_space_type', $space->ID );
					?>
                    <div class="space">
                        <a href="<?php echo get_permalink( $space->ID ); ?>"
                           class="title">
							<?php echo $lease_suite_floor_number ? $lease_suite_floor_number : $space->post_title; ?>
                        </a>
                        <div class="available">
							<?php
							if ( $available_space_area ) {
								echo number_format( $available_space_area ) . " SF";
							}
							?>
                        </div>
                        <div class="rate">
							<?php
							$space_lease_amount = horrell_lease_amount_html( $space->ID );
							if ( $space_lease_amount ) {
								echo $space_lease_amount;
							}
							?>
                        </div>
                        <div class="lease-type">
							<?php
							if ( $lease_type ) {
								echo $lease_type;
							}
							?>
                        </div>
                        <div class="space-type">
							<?php
							if ( ! empty( $lease_space_type ) ) {
								$count = count( $lease_space_type );
								foreach ( $lease_space_type as $key => $space_type ) {
									if ( 'other' == strtolower( $space_type ) ) { // if type is other, use another field
										$space_type = get_field( 'lease_space_type_other', $space->ID );
									}
									echo $key + 1 == $count ? $space_type : $space_type . ', ';
								}
							}
							?>
                        </div>
                    </div>
					<?php
				}
				?>
            </div>
        </div>
    </section>

	<?php
}