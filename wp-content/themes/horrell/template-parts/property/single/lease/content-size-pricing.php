<div class="desc-title">
	<?php
	$property_id = get_the_ID();
	if ( has_term( 'land', 'property_categories' ) ) {
		$lease_lot_size = get_field( 'lease_lot_size' );
		if ( $lease_lot_size ) {
			echo "<span class=\"property-att\">" . horrell_fortmatted_area_lot( $lease_lot_size, 'lot' ) . " Available</span>";
		}
	} else {
		$lease_available_space_range = get_field( 'lease_available_space_range' );
		if ( isset( $lease_available_space_range['min'], $lease_available_space_range['max'] ) ) {
			if ( ! empty( $lease_available_space_range['min'] ) && ! empty( $lease_available_space_range['max'] ) ) {
				echo "<div class=\"property-att\"><span>" . number_format( $lease_available_space_range['min'] ) . "  - " . number_format( $lease_available_space_range['max'] ) . " Sq Ft Available</span></div>";
			} elseif ( ! empty( $lease_available_space_range['min'] ) && empty( $lease_available_space_range['max'] ) ) {
				echo "<div class=\"property-att\"><span>" . number_format( $lease_available_space_range['min'] ) . " Sq Ft Available</span></div>";
			}
		}
	}
	$rental_rate = horrell_lease_amount_html( $property_id );
	if ( $rental_rate ) {
		echo "<div class=\"property-att\"><span>" . $rental_rate . "</span></div>";
	}
	if ( horrell_is_property_for_sale_and_lease( $property_id ) ) { //if property avaliable for both sale and lease
		$sale_price = get_field( 'sale_price', $property_id );
		if ( $sale_price ) {
			echo "<span class=\"property-att\">Sale Price " . horrell_formatted_price( $sale_price ) . "</span>";
		}
	}
	?>
</div>