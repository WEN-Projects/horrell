<?php
/**
 * Property Grid Template
 *
 * @package horrell
 *
 * cspell: ignore horrell salelease fortmatted
 */

$wrapper_class = 'col-lg-4 col-sm-6 item-grid';
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?>">
    <div class="item">
        <div class="property-image">
            <!-- YT Video Here -->
			<?php
			the_post_thumbnail( 'medium' );
			?>
        </div>
        <div class="property-detail">
            <div class="top">
				<?php
				$post_id                    = get_the_ID();
				$current_post_type          = get_post_type();
				$prop_categories            = get_the_terms( $post_id, 'property_categories' );
				$featured_property_category = isset( $prop_categories[0]->name ) ? $prop_categories[0]->name : 'Property';
				$prop_offer_type            = get_the_terms( $post_id, 'property_sale_type' );
				$featured_prop_offer_type   = isset( $prop_offer_type[0]->name ) ? $prop_offer_type[0]->name : 'Lease';
				//				$parent_post_id                  = $post_id; // in case of space post type we need the details of parent property.
				$prop_details                   = horrell_property_space_details( $post_id );
				$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $post_id );

				$property_id = ( 'property' === get_post_type() ) ? $post_id : get_field( 'parent_property' ); // if type is space, set the post id as parent_property
				if ( $is_property_for_sale_and_lease ) {
					echo '<h5><span>' . esc_html( $featured_property_category ) . ' For Sale Or Lease</span></h5>';
				} else {
					echo '<h5><span>' . esc_html( $featured_property_category ) . ' For ' . ucfirst( $featured_prop_offer_type ) . '</span></h5>';
				}
				?>
                <h3>
                    <a href="<?php echo esc_url( get_the_permalink( $property_id ) ); ?>">
						<?php
						echo horrell_property_title( $post_id );
						?>
                    </a>
                </h3>
            </div>
            <div class="bottom space-prop-<?php echo $post_id; ?>">
				<?php
				if ( isset( $prop_details['property_type_index'] ) && 'space' === $prop_details['property_type_index'] ) { // for all space which are for lease.
					if ( isset( $prop_details['lease_suite_floor_number'] ) && $prop_details['lease_suite_floor_number'] ) {
						echo '<div class="property-att">Suite/Fl ' . esc_html( $prop_details['lease_suite_floor_number'] ) . '</div>';
					}
					if ( isset( $prop_details['available_space'] ) && $prop_details['available_space'] ) {
						echo '<div class="property-att">Available <span>' . number_format( $prop_details['available_space'] ) . ' SF</span></div>';
					}
					if ( isset( $prop_details['lease_amount_html'] ) && $prop_details['lease_amount_html'] ) {
						echo '<div class="property-att">Rental Rate <span>' . esc_html( $prop_details['lease_amount_html'] ) . '</span></div>';
					}
					if ( $is_property_for_sale_and_lease && ! has_term( 'land', 'property_categories', $property_id ) ) { //for all the non lad properties which is available for both sale and lease
						$parent_post_id = get_field( 'parent_property' ); // get parent property of space
						$sale_price     = get_field( 'sale_price', $parent_post_id ); // get the sale price of parent property
						if ( $sale_price ) {
							$prop_details['sale_amount_html'] = horrell_formatted_price( $sale_price );
							echo '<div class="property-att">Sale Price <span>' . horrell_formatted_price( $sale_price ) . '</span></div>';
						}
					}
				} else { // for all sale and lease properties.
					if ( $is_property_for_sale_and_lease && has_term( 'land', 'property_categories', $property_id ) ) { // for all land properties, which are available for both sale and lease.
						if ( isset( $prop_details['land_lot'] ) && $prop_details['land_lot'] ) { // if the property category is land, show the lot size.
							echo '<div class="property-att">Lot Size <span>' . esc_html( horrell_fortmatted_area_lot( $prop_details['land_lot'], 'lot' ) ) . '</span></div>';
						}
						if ( isset( $prop_details['lease_amount_html'] ) && $prop_details['lease_amount_html'] ) {
							echo '<div class="property-att">Rental Rate <span>' . esc_html( $prop_details['lease_amount_html'] ) . '</span></div>';
						}
						if ( isset( $prop_details['sale_amount_html'] ) && $prop_details['sale_amount_html'] ) {
							echo '<div class="property-att">Sale Price <span>' . esc_html( $prop_details['sale_amount_html'] ) . '</span></div>';
						}
					} elseif ( isset( $prop_details['property_type_index'] ) && 'sale' === $prop_details['property_type_index'] ) { // for all properties, which are for only for sale.
						if ( isset( $prop_details['is_land'] ) && TRUE === $prop_details['is_land'] ) { // if the property category is land, show the lot size.
							if ( isset( $prop_details['land_lot'] ) && $prop_details['land_lot'] ) {
								echo '<div class="property-att">Lot Size <span>' . esc_html( horrell_fortmatted_area_lot( $prop_details['land_lot'], 'lot' ) ) . '</span></div>';
							}
						} else {
							if ( isset( $prop_details['available_space'] ) && $prop_details['available_space'] ) { // for not land properties show available area in SF.
								echo '<div class="property-att">Building Size <span>' . number_format( $prop_details['available_space'] ) . ' SF</span></div>';
							}
						}
						if ( isset( $prop_details['sale_amount_html'] ) && $prop_details['sale_amount_html'] ) {
							echo '<div class="property-att">Sale Price <span>' . esc_html( $prop_details['sale_amount_html'] ) . '</span></div>';
						}
					} else { // for all properties, which are only for lease.
						if ( isset( $prop_details['is_land'] ) && TRUE === $prop_details['is_land'] ) { // if the property category is land, show the lot size.
							if ( isset( $prop_details['land_lot'] ) && $prop_details['land_lot'] ) {
								echo '<div class="property-att">Total Lot Size <span>' . esc_html( horrell_fortmatted_area_lot( $prop_details['land_lot'], 'lot' ) ) . '</span></div>';
							}
						}
						if ( isset( $prop_details['lease_amount_html'] ) && $prop_details['lease_amount_html'] ) {
							echo '<div class="property-att">Rental Rate <span>' . esc_html( $prop_details['lease_amount_html'] ) . '</span></div>';
						}
					}
				}
				?>
            </div>
        </div>
    </div>
</div>
