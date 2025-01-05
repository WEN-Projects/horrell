<?php
$available_spaces = get_field( 'available_spaces' );
if ( ! empty( $available_spaces ) ) {
	?>
    <section id="available-space-section" class="available-space-section">
        <div class="container">
            <div class="border-wrapper">
                <h2>Available Space</h2>
				<?php
				$property_categories        = get_the_terms( get_the_ID(), 'property_categories' );
				$featured_property_category = isset( $property_categories[0]->name ) ? $property_categories[0]->name : "";
				foreach ( $available_spaces as $space ) {
				    var_dump($space);
					$lot_size                  = get_field( 'lot_size', $space->ID );
					$available_space_area      = get_field( 'available_space_area', $space->ID );
					$rental_unit               = get_field( 'rental_unit', $space->ID );
					$is_rental_rate_negotiable = get_field( 'is_rental_rate_negotiable', $space->ID );
					?>
                    <div class="space d-flex align-items-center">
                        <a href="<?php echo get_permalink( $space->ID ); ?>"
                           class="title"><?php echo $space->post_title; ?></a>
                        <div class="available">
							<?php
							if ( $available_space_area || $lot_size ) {
								echo $available_space_area ? number_format( $available_space_area ) . " SF" : $lot_size . " Acres";
							}
							?>
                        </div>
                        <div class="rate">
							<?php
							if ( ! $is_rental_rate_negotiable ) {
								$rental_rate = get_field( 'rental_rate', $space->ID );
								if ( $rental_rate ) {
									echo "$" . number_format( $rental_rate, 2 ) . " " . $rental_unit;
								}
							} else {
								$minimum_rental_rate = get_field( 'minimum_rental_rate', $space->ID );
								$maximum_rental_rate = get_field( 'maximum_rental_rate', $space->ID );
								if ( ! empty( $minimum_rental_rate ) && ! empty( $maximum_rental_rate ) ) {
									echo "Negotiable ($" . number_format( $minimum_rental_rate, 2 ) . " - $" . number_format( $maximum_rental_rate, 2 ) . " " . $rental_unit . ")";
								} else {
									echo "Negotiable";
								}
							}
							?>
                        </div>
                        <div class="space-type">
							<?php
							if ( $featured_property_category ) {
								echo $featured_property_category . " Space";
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

    <!-- For Property-unit Page -->
    <!-- Property info-list -->
    <!--                <section class="property-info-list-section">-->
    <!--                    <div class="container">-->
    <!--                        <div class="border-wrapper">-->
    <!--                            <h2>--><?php //echo _e('Suite/Floor Garden South, 1st Floor, #101', 'horrell'); ?><!--</h2>-->
    <!--                            <div class="row">-->
    <!--                                <div class="col-lg-4 col-md-5 col-sm-6">-->
    <!--                                    <div class="left-list">-->
    <!--                                        <div class="item d-flex align-items-center">-->
    <!--                                            <div class="title">Available</div>-->
    <!--                                            <div class="value">2,165 Sq ft</div>-->
    <!--                                        </div>-->
    <!--                                        <div class="item d-flex align-items-center">-->
    <!--                                            <div class="title">Min Divisible</div>-->
    <!--                                            <div class="value">2,165 Sq ft</div>-->
    <!--                                        </div>-->
    <!--                                    </div>-->
    <!--                                </div>-->
    <!--                                <div class="col-lg-8 col-md-7 col-sm-6">-->
    <!--                                    <ul class="right-list">-->
    <!--                                        <li>The Data Tower & Garden Complex 677SF</li>-->
    <!--                                        <li>up to 6400 SF Available</li>-->
    <!--                                    </ul>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </section>-->
    <!-- Property info-list end -->
	<?php
}