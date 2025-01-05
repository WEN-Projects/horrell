<?php
if ( ! isset( $args['space_id'] ) ) {
	return;
}
$parent_post_id                 = get_field( 'parent_property', $args['space_id'] );
$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $parent_post_id );
$offer_type_label               = "Lease";
if ( $is_property_for_sale_and_lease ) {
	$offer_type_label = "Sale Or Lease";
}
?>
<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="item">
        <div class="property-image">
            <!-- YT Video Here -->
			<?php
			if ( has_post_thumbnail( $args['space_id'] ) ) {
				echo get_the_post_thumbnail( $args['space_id'], 'medium' );
			} else {
				if ( $parent_post_id ) {
					echo get_the_post_thumbnail( $parent_post_id, 'medium' );
				}
			}
			?>
        </div>
        <div class="property-detail">
            <div class="top">
				<?php

				$lease_suite_floor_number   = get_field( 'lease_suite_floor_number', $args['space_id'] );
				$available_space            = get_field( 'available_space', $args['space_id'] );
				$terms                      = get_the_terms( $args['space_id'], 'property_categories' );
				$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : "Property";
				echo "<h5><span>" . $featured_property_category . " For " . $offer_type_label . "</span></h5>";
				?>
                <h3>
                    <a href="<?php echo esc_url( get_the_permalink( $args['space_id'] ) ); ?>"><?php echo horrell_property_title( $parent_post_id ); ?></a>
                </h3>
            </div>
            <div class="bottom">
				<?php
				$lease_suite_floor_number = get_field( 'lease_suite_floor_number', $args['space_id'] );
				if ( $lease_suite_floor_number ) {
					echo "<div class=\"property-att\">Suite/Fl " . $lease_suite_floor_number . "</div>";
				}
				if ( $available_space ) {
					echo "<div class=\"property-att\">Available <span>" . number_format( $available_space ) . " SF</span></div>";
				}
				if ( $is_property_for_sale_and_lease ) {
					$sale_price = get_field( 'sale_price', $parent_post_id ); // show the sale price of property
					if ( $sale_price ) {
						echo "<div class=\"property-att\">Sale Price <span>" . horrell_formatted_price( $sale_price ) . "</span></div>";
					}
				}
				$rental_rate = horrell_lease_amount_html( $args['space_id'] );
				if ( $rental_rate ) {
					echo "<div class=\"property-att\">Rental Rate <span>" . $rental_rate . "</span></div>";
				}
				?>
            </div>
        </div>
    </div>
</div>