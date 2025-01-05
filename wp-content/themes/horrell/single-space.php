<?php
/**
 * Single Property Template
 */
get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
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
							$parent_property          = get_field( 'parent_property' );
							$lease_suite_floor_number = get_field( 'lease_suite_floor_number' );
							$offer_type_label         = "For Lease";
							if ( $parent_property ) {
								if ( horrell_is_property_for_sale_and_lease( $parent_property ) ) {
									$offer_type_label = "For Sale Or Lease";
								}
								$property_name = get_field( 'property_name', $parent_property );
								if ( $property_name ) {
									echo $property_name . "<br>";
								}
							}
							echo horrell_property_title( get_the_ID() );
							?>
                            <br>
                            <span>
                            Suite/Floor <?php echo $lease_suite_floor_number; ?><br>
                                <?php
                                echo $offer_type_label;
                                ?>
                            </span>
                        </h3>
                    </div>
                </div>
            </section>
			<?php
			get_template_part( "template-parts/property/single/content", "property-details" ); //render the template to display all space details - (price and size details), brokers list etc
			$parent_property = get_field( 'parent_property' ); // get id of parent property of space (saved in each space as meta field 'parent_property')
			$template_args   = [ 'parent_property' => $parent_property ];
			if ( ! empty( $parent_property ) ) {
				get_template_part( 'template-parts/property/single/space/content', 'parent-property-overview', $template_args ); //If the space has parent property,Render overview details of parent property
			}
			get_template_part( 'template-parts/property/single/space/content', 'space-overview', $template_args ); //render the space overview, all space details.
			if ( ! empty( $parent_property ) ) { // load all the contents(templates) associated to parent property of space
				get_template_part( 'template-parts/property/single/content', 'map', $template_args );
				$property_categories = get_the_terms( $parent_property, 'property_categories' );
				$property_sale_type  = get_the_terms( $parent_property, "property_sale_type" );
				get_template_part( 'template-parts/property/single/content', 'related-properties', [
					'property_sale_type'  => $property_sale_type,
					'property_categories' => $property_categories,
				] );
			}
			?>
        </main>
		<?php
	}
}
get_footer();