<div class="desc-title">
	<?php
	$lot_size = get_field( 'sale_lot_size' );
	if ( $lot_size ) {
		echo "<span class=\"property-att\">" . horrell_fortmatted_area_lot( $lot_size, 'lot' ) . " Available</span>";
	}
	$rental_rate = horrell_lease_amount_html( get_the_ID() );
	if ( $rental_rate ) {
		echo "<div class=\"property-att\"><span>" . $rental_rate . "</span></div>";
	}
	$sale_price = get_field( 'sale_price' );
	if ( $sale_price ) {
		echo "<span class=\"property-att\">Sale Price " . horrell_formatted_price( $sale_price ) . "</span>";
	}
	?>
</div>
