<div class="desc-title">
	<?php
	$property_type = get_field( 'property_type' ) ? get_field( 'property_type' ) : [];
	$data_to_show  = "lease";
	if ( is_array( $property_type ) && in_array( "land", $property_type ) ) { // if property type is land, only show the lot size (regardless of : sale or lease)
		$lot_size = get_field( 'sale_lot_size' );
		if ( $lot_size ) {
			echo "<span class=\"property-att\">" . horrell_fortmatted_area_lot( $lot_size, 'lot' ) . " Available</span>";
		}
	} else { // if property type is not land
		$building_size = get_field( 'sale_building_size' );
		if ( $building_size ) { // show the building size if it is for sale.
			echo "<span class=\"property-att\">" . number_format( $building_size ) . " Sq Ft</span>";
		}
	}

	$sale_price = get_field( 'sale_price' );
	if ( $sale_price ) {
		echo "<span class=\"property-att\">Sale Price " . horrell_formatted_price( $sale_price ) . "</span>";
	}
	?>
</div>
