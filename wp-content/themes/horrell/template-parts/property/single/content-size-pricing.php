<div class="desc-title">
	<?php
	$current_property_sale_type = isset( $_GET["ps_type"] ) ? $_GET["ps_type"] : "";
	$size_and_price_details_for = get_field( 'size_and_price_details_for' ) ? get_field( 'size_and_price_details_for' ) : array();
	$property_type              = get_field( 'property_type' ) ? get_field( 'property_type' ) : array();
	$data_to_show               = "lease";
	$lot_size                   = get_field( 'lot_size' );
	if ( in_array( "sale", $size_and_price_details_for ) && in_array( "lease", $size_and_price_details_for ) && "sale" == $current_property_sale_type ) {
		$data_to_show = "sale";
	} elseif ( in_array( "sale", $size_and_price_details_for ) && ! in_array( "lease", $size_and_price_details_for ) ) {
		$data_to_show = "sale";
	}
	if ( is_array( $property_type ) && in_array( "land", $property_type ) ) { // if property type is land, only show the lot size (regardless of : sale or lease)
		$lot_size = get_field( 'lot_size' );
		if ( $lot_size ) {
			echo "<span class=\"property-att\">" . number_format( $lot_size ) . " Acres</span>";
		}
	} else { // if property type is not land
		$building_size        = get_field( 'building_size' );
		$available_space_area = get_field( 'available_space_area' );
		if ( "sale" == $data_to_show && $building_size ) { // show the building size if it is for sale.
			echo "<span class=\"property-att\">" . number_format( $building_size ) . " Sq Ft</span>";
		}
		if ( "lease" == $data_to_show && $available_space_area ) { // show the building size if it is for lease.
			echo "<span class=\"property-att\">" . number_format( $available_space_area ) . " SF Available</span>";
		}
	}

	if ( "sale" == $data_to_show ) {
		$sale_price = get_field( 'sale_price' );
		echo "<span class=\"property-att\">Sale Price " . horrell_formatted_price( $sale_price ) . "</span>";
		if ( in_array( "sale", $size_and_price_details_for ) && in_array( "lease", $size_and_price_details_for ) ) {
			$lease_property_url = get_permalink();
			echo "<p>This property is also for Lease. <a href='" . $lease_property_url . "'>View Details</a></p>";
		}
	} else {
		$rental_unit               = get_field( 'rental_unit' );
		$is_rental_rate_negotiable = get_field( 'is_rental_rate_negotiable' );
		if ( ! $is_rental_rate_negotiable ) {
			$rental_rate = get_field( 'rental_rate' );
			if ( $rental_rate ) {
				echo "<div class=\"property-att\"><span>" . horrell_formatted_price( $rental_rate, 2 ) . " " . $rental_unit . "</span></div>";
			}
		} else {
			$minimum_rental_rate = get_field( 'minimum_rental_rate' );
			$maximum_rental_rate = get_field( 'maximum_rental_rate' );
			if ( ! empty( $minimum_rental_rate ) && ! empty( $maximum_rental_rate ) ) {
				echo "<div class=\"property-att\"><span>Negotiable (" . horrell_formatted_price( $minimum_rental_rate, 2 ) . " - " . horrell_formatted_price( $maximum_rental_rate, 2 ) . " " . $rental_unit . ")</span></div>";
			} else {
				echo "<div class=\"property-att\"><span>Negotiable</span></div>";
			}
		}
		if ( in_array( "sale", $size_and_price_details_for ) && in_array( "lease", $size_and_price_details_for ) ) {
			$sale_property_url = get_permalink() . "?ps_type=sale";
			echo "<p>This property is also for Sale. <a href='" . $sale_property_url . "'>View Details</a></p>";
		}
	}

	?>
</div>
