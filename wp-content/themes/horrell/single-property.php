<?php
/**
 * Single Property Template
 */
get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		$post_id                             = get_the_ID();
		$property_categories                 = get_the_terms( $post_id, 'property_categories' ); // all selected Property Types for the current property.
		$property_sale_type                  = get_the_terms( $post_id, "property_sale_type" ); // all selected Property Sale Types for the current property.
		$current_property_property_page_type = 'lease'; //by default set it to show the lease data.
		$is_land_lease_sale                  = FALSE;
		$prop_offer_type_label               = "";
		if ( horrell_is_property_for_sale_and_lease( $post_id ) ) { // property available for both sale and lease
			$prop_offer_type_label = "Sale Or Lease";
			if ( has_term( 'land', 'property_categories' ) ) {
				$is_land_lease_sale = TRUE;
			}
			//			$current_property_property_page_type = isset( $_GET["ps_type"] ) ? $_GET["ps_type"] : "lease"; // current property sale type (based on parameter passed in url)
		} else { //when only single term is set as either sale or lease
			if ( isset( $property_sale_type[0]->slug ) ) {
				$current_property_property_page_type = $property_sale_type[0]->slug; // property available for either sale or lease but not both.
				$prop_offer_type_label               = $property_sale_type[0]->slug;
			}
		}
		?>
        <main class="single-property-page">
            <section class="page-title">
                <div class="container d-flex justify-content-end">
					<?php
					echo horrell_breadcrumb_html(); //render the breadcrumb
					?>
                </div>
            </section><!-- .page-title -->
            <section class="dark-section property-single-dark-section">
                <div class="container-fluid">
                    <div class="section-wrapper text-center">
                        <h3>
							<?php
							$property_name = get_field( 'property_name' );
							if ( $property_name ) {
								echo $property_name . "<br>";
							}
							echo horrell_property_title( get_the_ID() );
							echo "<br><span>For " . ucfirst( $prop_offer_type_label ) . "</span>";
							?>
                        </h3>
                    </div>
                </div>
            </section>
			<?php
			get_template_part( "template-parts/property/single/content", "property-details", [
				'is_land_lease_sale'                  => $is_land_lease_sale,
				'current_property_property_page_type' => $current_property_property_page_type,
			] );  //render the template to display all property details - (price and size details), brokers list etc
			get_template_part( "template-parts/property/single/" . $current_property_property_page_type . '/content', "property-overview" ); // render all remaining details of current property
			if ( ! has_term( 'land', 'property_categories' ) ) { //list out all the available spaces associated to property if not land
				get_template_part( "template-parts/property/single/lease/content", "available-spaces" );
			}
			get_template_part( 'template-parts/property/single/content', 'map' ); // render the map location of current property.
			get_template_part( 'template-parts/property/single/content', 'related-properties', [
				'property_sale_type'  => $property_sale_type,
				'property_categories' => $property_categories,
			] ); //list out all the related properties (based on the current property taxonomies (sale type and category) )
			?>
        </main>
		<?php
	}
}
get_footer();