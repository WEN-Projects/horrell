<?php
/*
Template Name: Dynamic PDF
*/
if ( file_exists( get_template_directory() . "/vendor/autoload.php" ) ) { // load all the composer packages
	require_once get_template_directory() . "/vendor/autoload.php";
}


use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
	ob_start();
	$property_type = isset( $_GET['ptype'] ) && ! empty( $_GET['ptype'] ) ? $_GET['ptype'] : "";
	?>

    <!-- End stylesheet -->
	<?php
	if ( ! $property_type ) {
		render_pdf( 'industrial' );
		render_pdf( 'office' );
		render_pdf( 'retail' );
		render_pdf( 'land' );
	} else {
		render_pdf( $property_type );
	}
	?>
	<?php
	$content = ob_get_clean();

	$html2pdf = new Html2Pdf( 'l', 'A4', 'en', FALSE, 'UTF-8', [ 0, 0, 0, 0 ] );
	//	$html2pdf = new Html2Pdf();
	//	$html2pdf->setDefaultFont( 'Arial' );
	$html2pdf->writeHTML( $content );
	$html2pdf->output( 'example00.pdf' );
} catch ( Html2PdfException $e ) {
	$html2pdf->clean();

	$formatter = new ExceptionFormatter( $e );
	echo $formatter->getHtmlMessage();
}

function render_pdf( $property_type = "" ) {
	if ( 'industrial' == $property_type ) {
		$col_width_th  = "13%";
		$col_width_td  = "13%";
		$colspan       = 5;
		$colspan_width = "53%";
	} else {
		$col_width_th  = "15%";
		$col_width_td  = "15%";
		$colspan       = 4;
		$colspan_width = "48%";
	}
	global $Horrell_Property;
	$args = [
		"post_type"      => [ 'property', 'space' ],
		"posts_per_page" => - 1,
		"post_status"    => "publish",
		'post__not_in'   => $Horrell_Property->lease_properties_to_exclude(),
		'meta_key'       => 'actual_size_in_sf',
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'meta-query'     => [
			'relation' => 'OR',
			[
				'key'     => 'actual_size_in_sf',
				'compare' => 'EXISTS',
			],
			[
				'key'     => 'actual_size_in_sf',
				'compare' => 'NOT EXISTS',
			],
		],
	];
	if ( isset( $property_type ) ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'property_categories',
				'field'    => 'slug',
				'terms'    => $property_type,
			],
		];
	}
	?>
    <page backtop="40mm" backbottom="10mm" backleft="0mm" backright="0mm">
        <!-- Start stylesheet -->
        <style type="text/css">
            a,
            a[href],
            a:hover,
            a:link,
            a:visited {
                /* This is the link colour */
                text-decoration: none !important;
                color: #b99c64;
            }

            .link {
                text-decoration: underline !important;
            }

            p,
            p:visited {
                /* Fallback paragraph style */
                font-size: 15px;
                line-height: 24px;

                font-weight: 300;
                text-decoration: none;
                color: #000000;
            }

            h1 {
                /* Fallback heading style */
                font-size: 22px;
                line-height: 24px;

                font-weight: normal;
                text-decoration: none;
                color: #000000;
            }

            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td {
                line-height: 100%;
            }

            .ExternalClass {
                width: 100%;
            }
        </style>
        <page_header>
            <table style="width: 100%; background: #000; border-collapse: collapse; margin-bottom: 10px; padding: 15px 10px;">
                <tbody>
                <tr>
                    <td style="vertical-align: bottom; text-align: left; width: 33.33%;">
						<?php
						$header_img = get_field( 'dds_header_logo', 'option' );
						if ( $header_img ) {
							?>
                            <img src="<?php echo $header_img; ?>"
                                 alt="" style="max-width: 100%;">
							<?php
						}
						?>
                    </td>
                    <td style="vertical-align: bottom; width: 33.33%;">
                        <h2 style="margin: 0; padding: 0; text-align: center; font-size: 32px; font-family: 'Arial', sans-serif; font-weight: 700; text-transform: capitalize; color: #b99c64;">
							<?php
							echo ucfirst( $property_type ) . " Listings";
							?></h2>
                    </td>
                    <td style="vertical-align: bottom; text-align: right; width: 33.33%;">
						<?php
						$dds_header_contact_details = get_field( 'dds_header_contact_details', 'option' );
						if ( $dds_header_contact_details ) {
							echo $dds_header_contact_details;
						}
						?>
                    </td>
                </tr>
                </tbody>
            </table>
            <!-- Property listing -->
			<?php
			if ( 'industrial' == $property_type ) {
				?>
                <table align="center"
                       style="width: 100%; background: #000;border-collapse: collapse; padding: 5px 10px; margin-bottom: 15px;">
                    <tbody>
                    <!-- menu row -->
                    <tr>
                        <td style="width: 12%;"></td>
						<?php
						table_header_td_html( "Available Sq Ft", $col_width_th );
						table_header_td_html( "Office Sq Ft", $col_width_th );
						table_header_td_html( "Min Divisible<br>Max Contiguous", $col_width_th );
						table_header_td_html( "Price/Rate", $col_width_th );
						table_header_td_html( "Dock/Drive In<br>Clear Height", $col_width_th );
						table_header_td_html( "Links", $col_width_th );
						table_header_td_html( "Brokers", $col_width_th );
						?>
                    </tr>
                    </tbody>
                </table>
				<?php
			} elseif ( 'office' == $property_type || 'retail' == $property_type ) {
				?>
                <table align="center"
                       style="width: 100%; background: #000;border-collapse: collapse; padding: 5px 10px; margin-bottom: 15px;">
                    <tbody>
                    <!-- menu row -->
                    <tr>
                        <td style="width: 12%;"></td>
						<?php
						table_header_td_html( "Available Sq Ft", $col_width_th );
						table_header_td_html( "Min Divisible<br>Max Contiguous", $col_width_th );
						table_header_td_html( "Price/Rate", $col_width_th );
						table_header_td_html( "Lease Type", $col_width_th );
						table_header_td_html( "Links", $col_width_th );
						table_header_td_html( "Brokers", $col_width_th );
						?>
                    </tr>
                    </tbody>
                </table>
				<?php
			} elseif ( 'land' == $property_type ) {
				?>
                <table align="center"
                       style="width: 100%; background: #000;border-collapse: collapse; padding: 5px 10px; margin-bottom: 15px;">
                    <tbody>
                    <!-- menu row -->
                    <tr>
                        <td style="width: 12%;"></td>
						<?php
						table_header_td_html( "Lot Size<br>Building Size", $col_width_th );
						table_header_td_html( "Price/Rate", $col_width_th );
						table_header_td_html( "Lease Type", $col_width_th );
						table_header_td_html( "Zoning", $col_width_th );
						table_header_td_html( "Links", $col_width_th );
						table_header_td_html( "Brokers", $col_width_th );
						?>
                    </tr>
                    </tbody>
                </table>
				<?php
			}
			?>

        </page_header>
        <!-- header -->
		<?php
		if ( get_field( "dds_footer_info", "option" ) ) {
			?>
            <page_footer>
                <!-- footer note -->
                <table align="center"
                       style="width: 100%; background: #fff; border-collapse: collapse;margin-bottom: 10px">
                    <tbody>
                    <tr>
                        <td align="left"
                            style="text-align: left; vertical-align: bottom; width: 100%">
                            <p style="color: #000; font-size: 11px; font-family: 'Arial', sans-serif; line-height: 1.2; padding-top: 80px;padding-left: 10px; margin-bottom: 0;"><?php echo esc_html( get_field( "dds_footer_info", "option" ) ); ?></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </page_footer>
			<?php
		}
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			?>

			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id   = get_the_ID();
				$post_type = get_post_type();
				?>
                <table style="background: #efefef; margin-bottom: 8px; width: 100%; padding: 5px 8px; border-collapse: collapse; box-shadow: 0 0 2px #000;">
                    <tr>
                        <td rowspan="2" align="left"
                            style="text-align: left; width: 12%;  vertical-align: top;">
							<?php
							$image_url = get_the_post_thumbnail_url( get_the_ID(), "full" );
							if ( 'space' == $post_type ) {
								$parent_property                = get_field( 'parent_property' );
								$brokers                        = get_field( 'listing_brokers', $parent_property );
								$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $parent_property );
							} else {
								$brokers                        = get_field( 'listing_brokers' );
								$is_property_for_sale_and_lease = horrell_is_property_for_sale_and_lease( $post_id );
							}
							if ( ! empty( $image_url ) ) {
								?>
                                <img src="<?php echo esc_url( $image_url ); ?>"
                                     alt=""
                                     style="width: 120px; height: 80px; object-fit: cover;">
								<?php
							}
							?>
                        </td>
                        <td colspan="<?php echo $colspan; ?>" align="left"
                            style="text-align: left; vertical-align: top; width: <?php echo $colspan_width; ?>;">
                            <h3 style="padding: 0; margin: 0; color: #b99c64; font-size: 14px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.2;">
                                <a style="font: inherit; color: #b99c64;"
                                   href="#"><?php the_title(); ?></a></h3>
                            <p style="padding: 0; margin: 0; color: #000; font-size: 12px; font-family: 'Arial', sans-serif; line-height: 1.6;"><?php
								$terms                      = get_the_terms( $post_id, 'property_categories' );
								$featured_property_category = isset( $terms[0]->name ) ? $terms[0]->name : "Property";
								if ( 'property' == $post_type ) { // labels to be displayed for all 'property' post type
									if ( $is_property_for_sale_and_lease && has_term( 'land', 'property_categories', $post_id ) ) { // if property is available for both sale and lease
										echo $featured_property_category . " For Sale Or Lease";
									} else if ( has_term( 'lease', 'property_sale_type', $post_id ) ) { //for all the lease properties (as only land lease properties are listed, this will automatically become "Land For Lease")
										echo $featured_property_category . " For Lease";
									} elseif ( has_term( 'sale', 'property_sale_type', $post_id ) ) { //for all sale properties
										echo $featured_property_category . " For Sale";
									}
								} else {
									$lease_suite_floor_number = get_field( 'lease_suite_floor_number' );
									if ( $is_property_for_sale_and_lease ) {
										echo $featured_property_category . " For Sale Or Lease";
									} else {
										echo $featured_property_category . " For Lease"; // labels to be displayed for all 'space' post type
									}
								}
								?></p>
                        </td>
                        <td align="left"
                            style="text-align: left; vertical-align: top; width: <?php echo $col_width_td; ?>">
							<?php
							$video_link = get_field( 'property_video' );
							if ( $video_link != '' ) {
								?>
                                <p style=" font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1; margin:0 0 5px 0;">
                                    <a style="color: #b99c64; text-decoration: none; font: inherit; "
                                       href="<?php echo esc_url( $video_link ); ?>">Virtual
                                        tour</a>
                                </p>
								<?php
							}
							?>

							<?php
							$brochure = get_field( 'property_brochure' );
							if ( isset( $brochure['url'] ) ) {
								?>
                                <p style=" font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1; margin:0 0 5px 0;">
                                    <a style="color: #b99c64; text-decoration: none; font: inherit; "
                                       href="<?php echo $brochure['url']; ?>">Brochure</a>
                                </p>
								<?php
							}
							?>
                        </td>
                        <td align="left"
                            style="text-align: left; vertical-align: top; width: <?php echo $col_width_td; ?>">
                            <p style=" font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1; margin:0 0 5px 0;">
								<?php if ( $brokers ) {
									foreach ( $brokers as $key => $broker ) {
										if ( $key > 0 ) {
											echo "<br><br>";
										}
										?>
                                        <a style="color: #b99c64; text-decoration: none; font: inherit"
                                           href="<?php echo get_page_link( get_page_by_path( 'the-team' ) ); ?>"><?php echo get_the_title( $broker ); ?></a>
										<?php
									}
								} ?>
                            </p>
                        </td>
                    </tr>
                    <tr>

                        <td align="left"
                            style="text-align: left; vertical-align: top; width: <?php echo $col_width_td; ?>">
                            <p style="padding: 0; margin: 0; color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.6;">
								<?php
								if ( 'space' == $post_type ) {
									$available_space = get_field( 'available_space' );
									if ( $available_space ) {
										echo horrell_fortmatted_area_lot( $available_space );
									}
								} else {
									if ( has_term( 'sale', 'property_sale_type', $post_id ) ) { // for all properties, which are for sale
										if ( has_term( 'land', 'property_categories', $post_id ) ) { // if the property category is land, show the lot size.
											$sale_lot_size = get_field( 'sale_lot_size', $post_id );
											if ( $sale_lot_size ) {
												echo horrell_fortmatted_area_lot( $sale_lot_size, 'lot' );
											}
										} else { // if the property category is not land, show the building.
											$sale_building_size = get_field( 'sale_building_size', $post_id );
											if ( $sale_building_size ) {
												echo horrell_fortmatted_area_lot( $sale_building_size );
											}
										}
									} else if ( has_term( 'lease', 'property_sale_type', $post_id ) ) { // for properties, which are for lease
										if ( has_term( 'land', 'property_categories', $post_id ) ) { // (No need to display lease properties which are "industrial","office","retail")
											$lease_lot_size = get_field( 'lease_lot_size', $post_id );
											if ( $lease_lot_size ) { // only to be shown lot size, since only land properties are to be displayed
												echo horrell_fortmatted_area_lot( $lease_lot_size, 'lot' );
											}
										}
									}

								}
								?>
                            </p>
                        </td>
						<?php
						$price_html     = '';
						$min_divisible  = '';
						$max_contiguous = '';
						$lease_type     = '';

						if ( 'space' == $post_type ) {
							$space_lease_amount = horrell_lease_amount_html( $post_id );
							if ( $space_lease_amount ) {
								$price_html = $space_lease_amount;
							}
							if ( $is_property_for_sale_and_lease ) { // if property available for both sale and lease
								$parent_property                = get_field( 'parent_property' );
								$sale_price = get_field( 'sale_price', $parent_property ); // show the sale price of property
								if ( $sale_price ) {
									$price_html .= "<br>" . horrell_formatted_price( $sale_price );
								}
							}
							$lease_minimum_divisible  = get_field( 'lease_minimum_divisible' );
							$min_divisible            = $lease_minimum_divisible ? horrell_fortmatted_area_lot( $lease_minimum_divisible ) : '';
							$lease_maximum_contiguous = get_field( 'lease_maximum_contiguous' );
							$max_contiguous           = $lease_maximum_contiguous ? horrell_fortmatted_area_lot( $lease_maximum_contiguous ) : '';
							$lease_type               = get_field( 'lease_type' );
						} else {
							if ( $is_property_for_sale_and_lease && has_term( 'land', 'property_categories', $post_id ) ) {
								$sale_price = get_field( 'sale_price', $post_id ); // show the sale price of property
								$price_html = "";
								if ( $sale_price ) {
									$price_html .= horrell_formatted_price( $sale_price );
								}
								$rental_rate = horrell_lease_amount_html( $post_id );
								if ( $rental_rate ) {
									$price_html .= "<br>" . $rental_rate;
								}
								$lease_type = get_field( 'lease_type' );
							} else if ( has_term( 'sale', 'property_sale_type', $post_id ) ) {
								$sale_price = get_field( 'sale_price', $post_id ); // show the sale price of property
								if ( $sale_price ) {
									$price_html = horrell_formatted_price( $sale_price );
								}
							} else if ( has_term( 'lease', 'property_sale_type', $post_id ) ) {
								if ( has_term( 'land', 'property_categories', $post_id ) ) { // (No need to display lease properties which are "industrial","office","retail")
									$rental_rate = horrell_lease_amount_html( $post_id );
									if ( $rental_rate ) {
										$price_html = $rental_rate;
									}
								}
								$lease_type = get_field( 'lease_type' );
							}
						}

						$dock_drive_clear_html = '';
						if ( 'space' == $post_type ) {
							$dock         = get_field( 'dock_high_loading_doors' );
							$drive_in     = get_field( 'drive_in_grade_level_doors' );
							$clear_height = get_field( 'clear_ceiling_height' );
						} else {
							if ( has_term( 'sale', 'property_sale_type', $post_id ) ) {
								$dock         = get_field( 'sale_dock_high_loading_doors' );
								$drive_in     = get_field( 'sale_drive_in_grade_level_doors' );
								$clear_height = get_field( 'sale_clear_celling_height' );
							}
						}
						$dock_drive_clear_html .= isset( $dock['unit'] ) && ! empty( $dock['unit'] ) ? $dock['unit'] : "0";
						$dock_drive_clear_html .= " / ";
						$dock_drive_clear_html .= isset( $drive_in['unit'] ) && ! empty( $drive_in['unit'] ) ? $drive_in['unit'] : "0";
						$dock_drive_clear_html .= "<br>";
						$dock_drive_clear_html .= isset( $clear_height['min'] ) && ! empty( $clear_height['min'] ) ? $clear_height['min'] . "' " : "";
						$dock_drive_clear_html .= isset( $clear_height['max'] ) && ! empty( $clear_height['max'] ) ? "- " . $clear_height['max'] . "' " : "";

						if ( 'industrial' == $property_type ) {
							$lease_office_sq_ft = get_field( 'lease_office_sq_ft' ) ? horrell_fortmatted_area_lot( get_field( 'lease_office_sq_ft' ) ) : '';
							table_data_html( $lease_office_sq_ft, $col_width_td );
							table_data_html( $min_divisible . "<br>" . $max_contiguous, $col_width_td );
							if ( 'space' == $post_type ) { //show lease type under price only for only lease, property type "industrial"
								$lease_type = get_field( 'lease_type' );
								if ( $lease_type ) {
									$price_html .= "<br>" . $lease_type;
								}
							}
							table_data_html( $price_html, $col_width_td );
							table_data_html( $dock_drive_clear_html, $col_width_td );
						} elseif ( 'office' == $property_type || 'retail' == $property_type ) {
							table_data_html( $min_divisible . "<br>" . $max_contiguous, $col_width_td );
							table_data_html( $price_html, $col_width_td );
							table_data_html( $lease_type, $col_width_td );
						} elseif ( 'land' == $property_type ) {
							table_data_html( $price_html, $col_width_td );
							table_data_html( $lease_type, $col_width_td );
							if ( has_term( 'sale', 'property_sale_type', $post_id ) ) {
								$zoning = get_field( 'sale_zoning' );
							} else if ( has_term( 'lease', 'property_sale_type', $post_id ) ) {
								$zoning = get_field( 'lease_zoning' );
							}
							table_data_html( $zoning, $col_width_td );
						}
						?>
                        <!--                        <td colspan="3" align="left" style="text-align: left; vertical-align: top;">-->
                        <!--                            <p style="padding: 0; margin: 0; color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.6;">-->
                        <!--                            </p>-->
                        <!--                        </td>-->
                    </tr>
                </table>
				<?php
			}
		}
		wp_reset_postdata();
		?>
        <!-- Broker info -->


		<?php
		$dds_footer_selected_team_members = get_field( "dds_footer_selected_team_members", "option" );
		if ( ! empty( $dds_footer_selected_team_members ) ) {
			$broker_count = count( $dds_footer_selected_team_members );
			?>
            <table align="left" style="width: 100%; background: #fff; border-collapse: collapse;
			<?php
			if ( 4 == $broker_count ) {
				echo "padding-left: 100px;padding 20px;";
			} else {
				echo "padding: 20px 100px;";
			}
			?>"
            >
                <tbody>
                <tr>
					<?php
					foreach ( $dds_footer_selected_team_members as $broker_id ) {
						?>
                        <td align="left"
                            style="text-align: left; vertical-align: top; width: 25%;">
                            <h4 style="color: #b99c64; font-size: 14px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.2; margin-bottom: 0; padding: 0;">
                                <a style="font: inherit; color: inherit; text-decoration: none;"
                                   href="#"><?php echo get_the_title( $broker_id ); ?></a>
                            </h4>
							<?php
							$company_posts   = get_field( "company_posts", $broker_id );
							$direct_number   = get_field( "direct_number", $broker_id );
							$cellular_number = get_field( "cellular_number", $broker_id );
							$email_address   = get_field( "email_address", $broker_id );
							echo $company_posts ? "<p style=\"color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 400; line-height: 1.6; margin: 0; padding: 0;\">" . $company_posts . "</p>" : '';
							echo $direct_number ? "<p style=\"color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 400; line-height: 1.2; margin: 0; padding: 0;\">" . $direct_number . "</p>" : '';
							echo $cellular_number ? "<p style=\"color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 400; line-height: 1.2; margin: 0; padding: 0;\">" . $cellular_number . "</p>" : '';
							echo $email_address ? "<p style=\"color: #b99c64; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 400; line-height: 1.2; margin: 0; padding: 0;\">
                                <a style=\"font: inherit; color: #b99c64; \"
                                   href=\"mailto:" . $email_address . "\">" . $email_address . "</a></p>" : '';
							?>
                        </td>
						<?php
					}
					?>
                </tr>
                </tbody>
            </table>
			<?php
		}
		?>
    </page>

	<?php
}

function table_header_td_html( $label, $col_width_th ) {
	echo "<td align=\"left\" style=\"text-align: left; vertical-align: bottom; width: " . $col_width_th . "\"><a style=\"color: #fff; text-decoration: none; text-transform: capitalize; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.6;\" href=\"#\">" . $label . "</a></td>";
}

function table_data_html( $value, $col_width_td ) {
	echo "<td align=\"left\"
                            style=\"text-align: left; vertical-align: top; width: " . $col_width_td . "\">
                            <p style=\"padding: 0; margin: 0; color: #000; font-size: 12px; font-family: 'Arial', sans-serif; font-weight: 700; line-height: 1.6;\">" . $value . "</p></td>";
}

?>