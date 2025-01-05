<div class="desc-title">
	<?php
	$available_space_area    = get_field( 'available_space' );
	$market_rental_rate      = get_field( 'market_rental_rate' );
	$market_rental_rate_unit = get_field( 'market_rental_rate_unit' );
	global $post;
	if ( $available_space_area ) {
		echo '<span class="property-att">' . horrell_fortmatted_area_lot( $available_space_area ) . ' Available</span>';
	}
	$rental_rate = horrell_lease_amount_html( $post->ID );
	if ( $rental_rate ) {
		echo '<span class="property-att">' . $rental_rate . '</span>';
	}
	$parent_property = get_field( 'parent_property' );
	if ( horrell_is_property_for_sale_and_lease( $parent_property ) ) {
		$sale_price = get_field( 'sale_price', $parent_property );
		if ( $sale_price ) {
			echo "<span class=\"property-att\">Sale Price " . horrell_formatted_price( $sale_price ) . "</span>";
		}
	}
	?>
</div>
