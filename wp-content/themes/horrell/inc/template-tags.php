<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core
 * features.
 *
 * @package horrell
 */

if ( ! function_exists( 'horrell_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function horrell_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
		/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'horrell' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'horrell_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function horrell_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'horrell' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'horrell_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function horrell_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'horrell' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'horrell' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'horrell' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'horrell' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'horrell' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'horrell' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'horrell_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function horrell_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

            <div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

		<?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>"
               aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					[
						'alt' => the_title_attribute(
							[
								'echo' => FALSE,
							]
						),
					]
				);
				?>
            </a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Horrell Custom functions starts here
 */
if ( ! function_exists( 'horrell_breadcrumb_html' ) ) {
	function horrell_breadcrumb_html() {
		$html             = '<div class="breadcrumb"><a href="' . get_home_url() . '">' . __( "Home", "horrell" ) . '</a> <span class="divider">></span>';
		$property_archive = get_post_type_archive_link( 'property' );
		if ( is_page() ) {
			$html .= esc_html( get_the_title() );
		}
		if ( is_archive() ) {
			if ( is_post_type_archive( "property" ) ) {
				$html .= '<a href="' . $property_archive . '">' . esc_html( get_queried_object()->label ) . '</a>';
				if ( isset( $_GET['ptype'] ) && ! empty( $_GET['ptype'] ) ) {
					$html .= ' <span class="divider">></span>' . esc_html( ucfirst( $_GET['ptype'] ) );
				}
			} else {
				if ( is_month() ) {
					$html .= "<a href='" . esc_url( get_year_link( get_the_date( 'Y' ) ) ) . "'>" . get_the_date( 'Y ' ) . "</a><span class=\"divider\">></span>";
					$html .= get_the_date( 'F' );
				}
				if ( is_year() ) {
					$html .= get_the_date( 'Y' );
				}
				if ( is_category() ) {
					$html .= single_cat_title( '', FALSE );
				}
			}
		}
		if ( is_singular( "property" ) ) {
			$terms = get_the_terms( get_the_ID(), "property_categories" );
			if ( isset( $terms[0]->term_id ) && isset( $terms[0]->name ) && isset( $terms[0]->slug ) ) {
				$html .= '<a href="' . home_url() . '/property?ptype=' . $terms[0]->slug . '">' . $terms[0]->name . '</a> <span class="divider">></span>';
			}
			$html .= get_the_title();
		}
		if ( ! is_singular( "property" ) && is_singular() && ! is_page() ) {
			$terms = get_the_terms( get_the_ID(), "category" );
			if ( isset( $terms[0]->term_id ) && isset( $terms[0]->name ) && isset( $terms[0]->slug ) ) {
				$html .= '<a href="' . get_term_link( $terms[0]->term_id ) . '">' . $terms[0]->name . '</a> <span class="divider">></span>';
			}
			$html .= get_the_title();
		}
		if ( is_home() ) { //check if posts listing page
			$html .= esc_html( "Blog" );
		}
		if ( is_search() ) {
			$html .= esc_html__( 'Search Results for: ' . get_search_query(), 'horrell' );
		}
		if ( is_404() ) {
			$html .= esc_html__( 'page not found' );
		}
		$html .= '</div>';

		return $html;
	}
}
if ( ! function_exists( "generate_random_string" ) ) {
	function generate_random_string( $length ) {
		$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$randomString .= $characters[ rand( 0, strlen( $characters ) - 1 ) ];
		}

		return $randomString;
	}
}
if ( ! function_exists( 'horrell_formatted_price' ) ) {
	function horrell_formatted_price( $price, $unit = "" ) {
		if ( ! empty( $price ) ) {
			if ( "PSF /Month" == $unit || "PSF /Year" == $unit || 2 == $unit ) {
				return "$" . number_format( $price, 2 );
			} else {
				return "$" . number_format( $price );
			}

		}
	}
}
if ( ! function_exists( 'horrell_fortmatted_area_lot' ) ) {
	function horrell_fortmatted_area_lot( $area_lot, $unit = 'sqft' ) {
		$unit = 'lot' == $unit ? " Acres" : " Sq Ft";
		if ( ! empty( $area_lot ) ) {
			if ( fmod( $area_lot, 1 ) !== 0.00 ) {
				// your code if its decimals has a value
				return number_format( $area_lot, 2 ) . $unit;
			} else {
				// your code if the decimals are .00, or is an integer
				return number_format( $area_lot ) . $unit;
			}
		}
	}
}
if ( ! function_exists( 'horrell_lease_amount_html' ) ) {
	function horrell_lease_amount_html( $property ) {
		$lease_amt_html = "";
		$post_type      = get_post_type( $property );
		if ( 'space' == $post_type ) {
			$market_rental_is_negotiable = get_field( 'market_rental_is_negotiable', $property );
			if ( TRUE == $market_rental_is_negotiable ) {
				return "Negotiable";
			}
			$market_rental_rate      = get_field( 'market_rental_rate', $property );
			$market_rental_rate_unit = get_field( 'market_rental_rate_unit', $property );
			$lease_amt_html          .= horrell_formatted_price( $market_rental_rate, $market_rental_rate_unit ) . " " . $market_rental_rate_unit;
		} else {
			$lease_is_negotiable = get_field( 'lease_is_negotiable', $property );
			if ( TRUE == $lease_is_negotiable ) {
				return "Negotiable";
			}

			if ( has_term( 'land', 'property_categories', $property ) ) {
				$lease_market_rental_rate      = get_field( 'lease_market_rental_rate', $property );
				$lease_market_rental_rate_unit = get_field( 'lease_market_rental_rate_unit', $property );
				if ( $lease_market_rental_rate && $lease_market_rental_rate_unit ) {
					$lease_amt_html .= horrell_formatted_price( $lease_market_rental_rate, $lease_market_rental_rate_unit ) . " " . $lease_market_rental_rate_unit;
				}
			} else {
				$lease_rental_rate_range = get_field( 'lease_rental_rate_range', $property );
				if ( isset( $lease_rental_rate_range['min'] ) && isset( $lease_rental_rate_range['max'] ) && isset( $lease_rental_rate_range['rental_unit'] ) ) {
					if ( isset( $lease_rental_rate_range['min'], $lease_rental_rate_range['max'], $lease_rental_rate_range['rental_unit'] ) && ! empty( $lease_rental_rate_range['min'] ) && ! empty( $lease_rental_rate_range['max'] ) && ! empty( $lease_rental_rate_range['rental_unit'] ) ) {
						$lease_amt_html .= horrell_formatted_price( $lease_rental_rate_range['min'], $lease_rental_rate_range['rental_unit'] ) . " - " . horrell_formatted_price( $lease_rental_rate_range['max'], $lease_rental_rate_range['rental_unit'] ) . " " . $lease_rental_rate_range['rental_unit'];
					} elseif ( isset( $lease_rental_rate_range['min'], $lease_rental_rate_range['max'], $lease_rental_rate_range['rental_unit'] ) && ! empty( $lease_rental_rate_range['min'] ) && ! empty( $lease_rental_rate_range['rental_unit'] ) ) {
						$lease_amt_html .= horrell_formatted_price( $lease_rental_rate_range['min'], $lease_rental_rate_range['rental_unit'] ) . " " . $lease_rental_rate_range['rental_unit'];
					}
				}
			}
		}

		return $lease_amt_html;
	}
}
if ( ! function_exists( 'horrell_property_title' ) ) {
	function horrell_property_title( $post_id ) {
		$id             = get_post_type( $post_id ) == 'space' ? get_field( 'parent_property', $post_id ) : $post_id;
		$street_number  = get_field( 'street_number', $id );
		$street_name    = get_field( 'street_name', $id );
		$property_city  = get_field( 'property_city', $id );
		$property_state = get_field( 'property_state', $id );
		$property_zip   = get_field( 'property_zip', $id );

		if ( is_singular() ) {
			return $street_number . " " . $street_name . " " . $property_city . ", " . $property_state . " " . $property_zip;
		} else {
			return $street_number . " " . $street_name . "<br> " . $property_city . ", " . $property_state . " " . $property_zip;
		}
	}
}
if ( ! function_exists( 'horrell_property_address' ) ) {
	function horrell_property_address( $post_id ) {
		$id            = get_post_type( $post_id ) == 'space' ? get_field( 'parent_property', $post_id ) : $post_id;
		$street_number = get_field( 'street_number', $id );
		$street_name   = get_field( 'street_name', $id );
		$property_city = get_field( 'property_city', $id );
		//		$property_state = get_field( 'property_state', $id );
		//		$property_zip   = get_field( 'property_zip', $id );

		if ( is_singular() ) {
			return $street_number . " " . $street_name;
		} else {
			return $street_number . " " . $street_name;
		}
	}


}
if ( ! function_exists( 'horrell_property_space_details' ) ) {
	function horrell_property_space_details( $post_id = 0 ) {
		$prop_details = [];
		if ( ! $post_id ) {
			return $prop_details;
		}
		if ( 'space' == get_post_type( $post_id ) ) {
			$prop_details['property_type_index']      = "space";
			$prop_details['office_sq_ft']             = get_field( 'lease_office_sq_ft', $post_id );
			$prop_details['warehouse_sq_ft']          = get_field( 'space_warehouse_sq_ft', $post_id );
			$prop_details['available_space']          = get_field( 'available_space', $post_id );
			$prop_details['lease_suite_floor_number'] = get_field( 'lease_suite_floor_number', $post_id );
			$prop_details['lease_amount_html']        = horrell_lease_amount_html( $post_id );
			$prop_details['lease_type']               = get_field( 'lease_type', $post_id );
			$prop_details['parent_property']          = get_field( 'parent_property', $post_id );
			$prop_details['property_highlights']      = get_field( 'property_highlights', $post_id );
			$prop_details['specs']                    = get_field( 'space_specification', $post_id );
			if ( $prop_details['parent_property'] ) {
				$prop_details['property_brochure'] = get_field( 'property_brochure', $prop_details['parent_property'] );
			}
			if ( horrell_is_property_for_sale_and_lease( $prop_details['parent_property'] ) ) {
				$sale_price = get_field( 'sale_price', $prop_details['parent_property'] ); // show the sale price of property
				if ( $sale_price ) {
					$prop_details['sale_amount_html'] = horrell_formatted_price( $sale_price );
				}
			}
		} else {
			if ( has_term( 'sale', 'property_sale_type', $post_id ) ) { // for all properties, which are for sale
				$prop_details['office_sq_ft']        = get_field( 'sale_office_sf', $post_id );
				$prop_details['warehouse_sq_ft']     = get_field( 'sale_warehouse_sf', $post_id );
				$prop_details['property_type_index'] = "sale";

				if ( has_term( 'land', 'property_categories', $post_id ) ) { // if the property category is land, show the lot size.
					$prop_details['land_lot'] = get_field( 'sale_lot_size', $post_id );
				} else { // if the property category is not land, show the building.
					$prop_details['available_space'] = get_field( 'sale_building_size', $post_id );
				}
				$sale_price = get_field( 'sale_price', $post_id ); // show the sale price of property
				if ( $sale_price ) {
					$prop_details['sale_amount_html'] = horrell_formatted_price( $sale_price );
				}
				$prop_details['property_highlights'] = get_field( 'sale_highlights', $post_id );
				$prop_details['specs']               = get_field( 'sale_specification', $post_id );
			}
			if ( has_term( 'lease', 'property_sale_type', $post_id ) ) { // for properties, which are for lease
				$prop_details['property_type_index'] = "lease";
				$prop_details['office_sq_ft']        = get_field( 'lease_office_sq_ft', $post_id );
				$prop_details['warehouse_sq_ft']     = get_field( 'lease_warehouse_sq_ft', $post_id );
				if ( has_term( 'land', 'property_categories', $post_id ) ) { // (No need to display lease properties which are "industrial","office","retail")
					$prop_details['land_lot']          = get_field( 'lease_lot_size', $post_id );
					$prop_details['lease_amount_html'] = horrell_lease_amount_html( $post_id );
				}
				$prop_details['lease_type']          = get_field( 'lease_type', $post_id );
				$prop_details['property_highlights'] = get_field( 'lease_highlights', $post_id );
				$prop_details['specs']               = get_field( 'lease_specification', $post_id );
			}
			// for land properties, which are for available for both lease and sale
			if ( has_term( 'lease', 'property_sale_type', $post_id ) && has_term( 'lease', 'property_sale_type', $post_id ) && has_term( 'land', 'property_categories', $post_id ) ) {
				$prop_details['property_type_index'] = "land-lease-sale";
			}
			$prop_details['property_brochure'] = get_field( 'property_brochure', $post_id );
			if ( has_term( 'land', 'property_categories', $post_id ) ) { // if the property category is land, show the lot size.
				$prop_details['is_land'] = TRUE;
			}
		}

		return $prop_details;
	}
}

if ( ! function_exists( 'horrell_is_property_for_sale_and_lease' ) ) { // function to check whether the property is land and available for both lease and sale
	function horrell_is_property_for_sale_and_lease( $property_id = 0 ) {
		if ( has_term( 'sale', 'property_sale_type', $property_id ) && has_term( 'lease', 'property_sale_type', $property_id ) ) {
			return TRUE;
		}

		return FALSE;
	}
}

//if ( ! function_exists( 'horrell_space_title' ) ) {
//	function horrell_space_title( $post_id ) {
//
//	}
//}
////if ( ! function_exists( 'horrell_lease_amount_html' ) ) {
//	function horrell_lease_amount_html( $property ) {
//		$lease_amt_html      = "";
//		$lease_is_negotiable = get_field( 'lease_is_negotiable', $property );
//		if ( true == $lease_is_negotiable ) {
//			$lease_amt_html .= "Negotiable ";
//		}
//		if ( ! has_term( 'land', 'property_categories' ) ) {
//			$lease_rental_rate_range = get_field( 'lease_rental_rate_range', $property );
//			if ( isset( $lease_rental_rate_range['min'], $lease_rental_rate_range['max'], $lease_rental_rate_range['rental_unit'] ) && ! empty( $lease_rental_rate_range['min'] ) && ! empty( $lease_rental_rate_range['min'] ) && ! empty( $lease_rental_rate_range['rental_unit'] ) ) {
//				$lease_amt_html .= "(" . horrell_formatted_price( $lease_rental_rate_range['min'] ) . " - " . horrell_formatted_price( $lease_rental_rate_range['max'] ) . ")" . " " . $lease_rental_rate_range['rental_unit'];
//			}
//		} else {
//			$lease_market_rental_rate      = get_field( 'lease_market_rental_rate', $property );
//			$lease_market_rental_rate_unit = get_field( 'lease_market_rental_rate_unit', $property );
//			if ( $lease_market_rental_rate && $lease_market_rental_rate_unit ) {
//				$lease_amt_html .= horrell_formatted_price( $lease_market_rental_rate ) . " " . $lease_market_rental_rate_unit;
//			}
//		}
//
//		return $lease_amt_html;
//	}
//}