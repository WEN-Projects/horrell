<!-- Map here -->
<?php
if ( isset( $args['parent_property'] ) && ! empty( $args['parent_property'] ) ) { // map for space (space's parent property)
	$property_map_location = get_field( 'property_map', $args['parent_property'] );
} else { // brokers listing for properties.
	$property_map_location = get_field( 'property_map' );
}
if ( $property_map_location ) : ?>
	<section class="map-section">
		<div class="container">
			<div class="map-wrapper">
				<div class="acf-map" data-zoom="16">
					<div class="marker" data-lat="<?php echo esc_attr( $property_map_location['lat'] ); ?>" data-lng="<?php echo esc_attr( $property_map_location['lng'] ); ?>"></div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
