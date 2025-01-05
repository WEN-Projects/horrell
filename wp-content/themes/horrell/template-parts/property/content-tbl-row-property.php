<?php
$post_id                    = get_the_ID();
$wrapper_class              = 'item-list';
$post_type                  = get_post_type();
$terms                      = get_the_terms( $post_id, 'property_categories' );
$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : 'Property';
$prop_details               = horrell_property_space_details( $post_id );
$parent_post_id             = $post_id;
if ( 'space' === get_post_type() ) {
	$parent_post_id = get_field( 'parent_property' );
}
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?>">
    <ul class="item">
        <li class="property-image">
            <!-- YT Video Here -->
            <a href="<?php the_permalink( $parent_post_id ); ?>">
				<?php
				the_post_thumbnail( 'medium' );
				?>
            </a>
        </li>
        <li class="property-address">
            <span><?php echo horrell_property_address( $post_id ); ?></span>
        </li>

        <li class="property-type">
			<span>
				<?php
				echo $featured_property_category;
				?>
			</span>
        </li>
        <li class="property-size">
			<?php
			if ( isset( $prop_details['land_lot'] ) && $prop_details['land_lot'] ) {
				echo '<span>' . horrell_fortmatted_area_lot( $prop_details['land_lot'], 'lot' ) . '</span>';
			}
			if ( isset( $prop_details['available_space'] ) && $prop_details['available_space'] ) {
				echo '<span>' . number_format( $prop_details['available_space'] ) . '+ SF</span>';
			}
			?>
        </li>
        <li class="property-wh-size">
			<?php
			$has_warehouse = false;
			if ( isset( $prop_details['warehouse_sq_ft'] ) && $prop_details['warehouse_sq_ft'] ) {
				echo '<span>' . number_format( $prop_details['warehouse_sq_ft'] ) . '+ SF WH</span>';
				$has_warehouse = true;
			}
			if ( isset( $prop_details['office_sq_ft'] ) && $prop_details['office_sq_ft'] ) {
				if ( $has_warehouse ) {
					echo "<br>";
				}
				echo '<span>' . number_format( $prop_details['office_sq_ft'] ) . '+ SF OFFICE</span>';
			}
			?>
        </li>
        <li class="property-rate">
			<?php
			if ( isset( $prop_details['lease_amount_html'] ) && $prop_details['lease_amount_html'] ) {
				echo '<span>' . $prop_details['lease_amount_html'] . '</span>';
			}
			?>
        </li>
        <li class="property-rate">
			<?php
			if ( isset( $prop_details['sale_amount_html'] ) && $prop_details['sale_amount_html'] ) {
				echo '<span>' . $prop_details['sale_amount_html'] . '</span>';
			}
			?>
        </li>
        <li class="property-brochure">
			<?php
			if ( isset( $prop_details['property_brochure'] ) && $prop_details['property_brochure'] && isset( $prop_details['property_brochure']['url'] ) ) {
				echo "<a href='" . esc_url( $prop_details['property_brochure']['url'] ) . "' target='_blank'><img src='" . esc_url( get_template_directory_uri() ) . "/assets/images/paperclip.svg' alt='brochure link'></a>";
			}
			?>
        </li>
        <li class="property-specs">
			<?php
			if ( isset( $prop_details['specs'] ) && $prop_details['specs'] ) {
				echo esc_html( $prop_details['specs'] );
			}
			?>
        </li>
    </ul>
</div>
