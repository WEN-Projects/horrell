<?php // phpcs:ignore
if ( ! class_exists( 'Horrell_Property' ) ) {
	class Horrell_Property {

		private $_post_type, $_posts_per_page, $_post_status; // parameters to be used for customizing WP Query

		public function __construct() {
			add_action(
				'wp_ajax_load_properties_by_ajax', // load rest of properties by ajax request in properties listing page(for logged in users)
				array( $this, 'horrell_load_properties_by_ajax_callback' )
			);
			add_action(
				'wp_ajax_nopriv_load_properties_by_ajax', // load rest of properties by ajax request in properties listing page(for non-logged in users)
				array( $this, 'horrell_load_properties_by_ajax_callback' )
			);
			add_action(
				'pre_get_posts',
				array(
					$this,
					'horrell_property_custom_query_vars',
				),
				9999
			); // customize the query for post type property (property archive page)
			add_filter(
				'template_include',
				array(
					$this,
					'horrell_custom_archive_template',
				)
			); // define the custom template to render the properties(posts)
			add_action(
				'save_post',
				array(
					$this,
					'horrell_save_post_actions',
				),
				11,
				2
			); // perform various actions while saving the posts (create bidirectional relationship between 'property' and 'space')
			add_action(
				'save_post',
				array(
					$this,
					'horrell_save_meta_function',
				),
				99,
				3
			); // when the post(property) is saved, save meta values based on (selected taxonomy terms for "property" post type)
			add_action( 'add_meta_boxes', array( $this, 'horrell_add_custom_meta_boxes' ) ); // adding post metaboxes
			add_action(
				'admin_enqueue_scripts',
				array(
					$this,
					'horrell_enqueue_admin_js_css',
				)
			); // enqueue admin scrips and css
			add_filter(
				'acf/load_field/name=size_and_price_details_for',
				array(
					$this,
					'acf_customize_property_offer_type_options',
				)
			);
			$this->_posts_per_page = 10;
			$this->_post_type      = array( 'property', 'space' ); // post types to be listed in "property" archive
			$this->_post_status    = array( 'publish' ); // only published properties to be listed
		}

		public function horrell_enqueue_admin_js_css() {
			wp_enqueue_script( 'horrell-admin-script', get_template_directory_uri() . '/inc/admin/assets/js/custom.js', array(), '1.0.0', true );
			wp_enqueue_style( 'horrell-custom-style', get_template_directory_uri() . '/inc/admin/assets/css/cstm-style.css', array(), '1.0.0' );
		}

		public function horrell_add_custom_meta_boxes( $post ) {
			add_meta_box( // meta-box to display the parent property in the space(editor-backend)
				'space-parent-property',
				__( 'Parent Property' ),
				function ( $post ) {
					$parent_property = get_field( 'parent_property', $post->ID );
					if ( $parent_property ) {
						echo "Property ID: <a href='" . get_edit_post_link( $parent_property ) . "'>" . $parent_property . '</a>';
					}
				},
				'space',
				'normal',
				'default'
			);
		}

		public function horrell_save_post_actions( $post_id, $post ) {
			if ( 'property' != $post->post_type && 'space' != $post->post_type ) {
				return;
			}
			$actual_size_in_sf = 0; // actual size (in square feet) for properties and spaces, will be used while sorting is done by higher to lower(SF)
			if ( 'property' == $post->post_type ) {
				$street_number            = get_field( 'street_number', $post_id );
				$street_name              = get_field( 'street_name', $post_id );
				$property_zip             = get_field( 'property_zip', $post_id );
				$available_spaces         = get_field( 'lease_spaces', $post_id ); // when property posts are saved (save the ID of properties to all associated spaces(posts))
				$property_sale_type       = get_the_terms( $post_id, 'property_sale_type' );
				$property_sale_type_array = array();
				// start //replicate the (taxonomy)terms i.e property type, property offer type saved to parent property to all associated spaces.
				if ( ! empty( $property_sale_type ) ) {
					foreach ( $property_sale_type as $sale_type ) {
						$property_sale_type_array[] = $sale_type->term_id;
					}
				}
				$property_type       = get_the_terms( $post_id, 'property_categories' );
				$property_type_array = array();
				if ( ! empty( $property_type ) ) {
					foreach ( $property_type as $type ) {
						$property_type_array[] = $type->term_id;
					}
				}
				if ( ! empty( $available_spaces ) ) {
					foreach ( $available_spaces as $space ) {
						if ( ! empty( $post_id ) ) {
							update_field( 'parent_property', $post_id, $space->ID ); // to create bidirectional relationship between 'property' and 'space'
						}
						$property_type = get_field( 'property_type' );
						if ( ! empty( $property_type ) ) {
							update_field( 'property_type', $property_type, $space->ID );
						}
						if ( ! empty( $street_number ) ) {
							update_field( 'street_number', $street_number, $space->ID );
						}
						if ( ! empty( $street_name ) ) {
							update_field( 'street_name', $street_name, $space->ID );
						}
						if ( ! empty( $property_zip ) ) {
							update_field( 'property_zip', $property_zip, $space->ID );
						}
						if ( ! empty( $property_sale_type_array ) ) {
							wp_set_post_terms( $space->ID, $property_sale_type_array, 'property_sale_type' );
						}
						if ( ! empty( $property_type_array ) ) {
							wp_set_post_terms( $space->ID, $property_type_array, 'property_categories' );
						}
					}
				}
				// end //replicate the (taxonomy)terms saved to parent property to all associated spaces.

				if ( has_term( 'lease', 'property_sale_type' ) ) { // determine the actual_size_in_sf based on selected property type and property offer type
					if ( has_term( 'land', 'property_categories' ) ) {
						$lease_convert_lot_size_to_sf = get_field( 'lease_convert_lot_size_to_sf' );
						$actual_size_in_sf            = $lease_convert_lot_size_to_sf > 0 ? $lease_convert_lot_size_to_sf : 0;
						$lease_is_negotiable          = get_field( 'lease_is_negotiable' );
						if ( $lease_is_negotiable ) {
							update_field( 'actual_rental_rate', 0 );
						}
					} else {
						$lease_gross_leasable_area = get_field( 'lease_gross_leasable_area' );
						$actual_size_in_sf         = $lease_gross_leasable_area > 0 ? $lease_gross_leasable_area : 0;
					}
				} elseif ( has_term( 'sale', 'property_sale_type' ) ) {
					if ( has_term( 'land', 'property_categories' ) ) {
						$sale_convert_lot_size_to_sf = get_field( 'sale_convert_lot_size_to_sf' );
						$actual_size_in_sf           = $sale_convert_lot_size_to_sf > 0 ? $sale_convert_lot_size_to_sf : 0;
					} else {
						$sale_building_size = get_field( 'sale_building_size' );
						$actual_size_in_sf  = $sale_building_size > 0 ? $sale_building_size : 0;
					}
				}
			}
			if ( 'space' == $post->post_type ) {  // if the post type is space, set actual_size directly as 'available_space'
				$available_space             = get_field( 'available_space' );
				$actual_size_in_sf           = $available_space > 0 ? $available_space : 0;
				$market_rental_is_negotiable = get_field( 'market_rental_is_negotiable' );
				if ( $market_rental_is_negotiable ) {
					update_field( 'actual_rental_rate', 0 );
				}
			}
			if ( get_post_status( $post_id ) != 'draft' ) {
				update_post_meta( $post_id, 'actual_size_in_sf', $actual_size_in_sf ); // field that will be used for sorting the properties based on size.
			}

			return;
		}

		// Add the template redirect
		public function horrell_custom_archive_template( $template ) {
			$cpts = array( 'property' );
			if ( is_post_type_archive( $cpts ) ) {
				$new_template = locate_template( array( 'property-listing.php' ) ); // template to render both property and space post types
				if ( ! empty( $new_template ) ) {
					return $new_template;
				}
			}

			return $template;
		}

		public function horrell_load_properties_by_ajax_callback() {
			// ajax response handler to get more properties in properties archive page
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'horrell-ajax-nonce' ) ) {
				die( 'Nonce value cannot be verified.' ); // die if invalid nonce ajax request
			}
			$args = array(
				'post_type'      => $this->_post_type,
				'post_status'    => $this->_post_status,
				'posts_per_page' => $this->_posts_per_page,
				'post__not_in'   => $this->lease_properties_to_exclude(),
				'offset'         => isset( $_POST['offset'] ) ? $_POST['offset'] : 0,
			);

			$query       = new WP_Query( $args );
			$post_params = isset( $_POST['get_params'] ) ? $_POST['get_params'] : array();
			$query       = $this->horrell_customize_query_using_get_params( $query, $post_params ); // customize the wp query using the $_GET parameters(GET REQUESTS)

			$query->get_posts(); // must run after creating object WP_Query (in order to make effective of the customize query vars)
			$result = '';
			if ( $query->have_posts() ) {
				ob_start();
				while ( $query->have_posts() ) {
					$query->the_post();
					get_template_part( 'template-parts/property/content', 'grid-property' );
					get_template_part( 'template-parts/property/content', 'tbl-row-property' );
				} //loop through the posts and get all the property (grid-template)
				$result = ob_get_contents();
				ob_end_clean();
			}
			$is_last = false;
			if ( isset( $_POST['offset'] ) ) { // if the offset for the pagination is set
				$current_page = (int) ( ( $_POST['offset'] ) / $this->_posts_per_page + 1 ); // calculate the current page number
				if ( $current_page >= $query->max_num_pages ) { // check if the current page is last page of the pagination
					$is_last = true;
				}
			}
			$return = array(
				'is_last' => $is_last,
				'content' => $result,
			);
			wp_reset_query();
			wp_send_json( $return );
		}

		private function horrell_customize_query_using_get_params( $query, $params = array() ) {
			// function inorder to maintain common customized query (that runs both for ajax request and page reload filter,sorting)
			$meta_query = array();

			// customize query to search the properties by different meta keys.
			if ( isset( $params['zipcode'] ) && ! empty( $params['zipcode'] ) ) {
				$meta_query[] = array(
					'key'     => 'property_zip',
					'value'   => $params['zipcode'],
					'compare' => '=',
				);
			}
			if ( $this->get_param_value( 'min_rental_price', $params ) ) {
				$meta_query[] = array(
					'key'     => 'actual_rental_rate',
					'value'   => $this->get_param_value( 'min_rental_price', $params ),
					'compare' => '>=',
					'type'    => 'numeric',
				);
			}
			if ( $this->get_param_value( 'max_rental_price', $params ) ) {
				$meta_query[] = array(
					'key'     => 'actual_rental_rate',
					'value'   => $this->get_param_value( 'max_rental_price', $params ),
					'compare' => '<=',
					'type'    => 'numeric',
				);
			}
			if ( $this->get_param_value( 'min_sale_price', $params ) ) {
				$meta_query[] = array(
					'key'     => 'sale_price',
					'value'   => $this->get_param_value( 'min_sale_price', $params ),
					'compare' => '>=',
					'type'    => 'numeric',
				);
			}
			if ( $this->get_param_value( 'max_sale_price', $params ) ) {
				$meta_query[] = array(
					'key'     => 'sale_price',
					'value'   => $this->get_param_value( 'max_sale_price', $params ),
					'compare' => '<=',
					'type'    => 'numeric',
				);
			}
			$sqf_meta_key = $this->get_param_value( 'p_offer_type', $params ) == 'sale' ? 'sale_building_size' : 'available_space';
			if ( $this->get_param_value( 'min_sq_ft', $params ) ) {
				$meta_query[] = array(
					'key'     => $sqf_meta_key,
					'value'   => $this->get_param_value( 'min_sq_ft', $params ),
					'compare' => '>=',
					'type'    => 'numeric',
				);
			}
			if ( $this->get_param_value( 'max_sq_ft', $params ) ) {
				$meta_query[] = array(
					'key'     => $sqf_meta_key,
					'value'   => $this->get_param_value( 'max_sq_ft', $params ),
					'compare' => '<=',
					'type'    => 'numeric',
				);
			}
			$acreage_meta_key = $this->get_param_value( 'p_offer_type', $params ) == 'sale' ? 'sale_lot_size' : 'lease_lot_size';
			if ( $this->get_param_value( 'min_acreage', $params ) ) {
				$meta_query[] = array(
					'key'     => $acreage_meta_key,
					'value'   => $this->get_param_value( 'min_acreage', $params ),
					'compare' => '>=',
					'type'    => 'decimal(3, 1)',
				);
			}
			if ( $this->get_param_value( 'max_acreage', $params ) ) {
				$meta_query[] = array(
					'key'     => $acreage_meta_key,
					'value'   => $this->get_param_value( 'max_acreage', $params ),
					'compare' => '<=',
					'type'    => 'decimal(3, 1)',
				);
			}
			$tax_query = array();
			if ( isset( $params['p_offer_type'] ) ) {
				$tax_query[] = array( // for tax query
					'taxonomy' => 'property_sale_type',
					'field'    => 'slug',
					'terms'    => $params['p_offer_type'],
				);
			}
			if ( isset( $params['ptype'] ) && ! empty( $params['ptype'] ) ) {
				$tax_query[] = array( // for tax query
					'taxonomy' => 'property_categories',
					'field'    => 'slug',
					'terms'    => $params['ptype'],
				);
			}
			if ( ! empty( $tax_query ) ) {
				$query->set(
					'tax_query',
					array(
						'relation' => 'AND',
						$tax_query,
					)
				);
			}
			if ( isset( $params['keyword'] ) && ! empty( $params['keyword'] ) ) {
				$query->set( 's', $params['keyword'] );
			}

			if ( isset( $params['sort_by'] ) ) { // sorting properties based on custom parameter
				$sort_param = explode( ' ', $params['sort_by'] );
				if ( count( $sort_param ) == 2 ) {
					$query->set( 'meta_key', $sort_param[0] );
					$query->query_vars['order'] = $sort_param[1];
					if ( $sort_param[0] == 'property_type' || $sort_param[0] == 'street_name' ) { // To be sorted alphabetically, if selected sort parameter is property_type or street_name
						$query->set( 'orderby', array( 'meta_value' => $sort_param[1] ) );
					} else { // To be sorted in numerically, if selected sort parameter is except (property_type or street_name)
						$query->set( 'orderby', array( 'meta_value_num' => $sort_param[1] ) );
					}
					$meta_query[] = array(
						'key'     => $sort_param[0],
						'compare' => 'EXISTS',
					);
					$meta_query[] = array(
						'key'     => $sort_param[0],
						'value'   => '',
						'compare' => '!=',
					);
				}
			} else { // for sorting by default, higher sf to lower sf
				$query->set( 'meta_key', 'actual_size_in_sf' );
				$query->set( 'orderby', array( 'meta_value_num' => 'DESC' ) );
				$meta_query[] = array(
					'relation' => 'OR',
					array(
						'key'     => 'actual_size_in_sf',
						'compare' => 'EXISTS',
					),
					array(
						'key'     => 'actual_size_in_sf',
						'compare' => 'NOT EXISTS',
					),
				);
			}
			if ( ! empty( $meta_query ) ) {
				$query->set( 'meta_query', $meta_query );
			}

			return $query;
		}

		public function horrell_property_custom_query_vars( $query ) {
			// query to be effective and will be used for listing the properties and render the properties(using ajax load more)
			if ( is_admin() || ! $query->is_main_query() || $query->get( 'post_type' ) != 'property' || ! is_archive() ) { // customize query for only "property" post type
				return;
			}
			$query->set( 'post_status', $this->_post_status );
			set_query_var( 'post__not_in', $this->lease_properties_to_exclude() );
			// $query->set( 'post__not_in ', $this->lease_properties_to_exclude() );
			$query->set( 'post_type', $this->_post_type );
			$query->set( 'posts_per_page', $this->_posts_per_page ); // set posts per page
			if ( isset( $_GET['offset'] ) && $_GET['offset'] > $this->_posts_per_page ) { // on reload of page if offset parameter is already set, then show all the post upto that (offset)
				$query->set( 'posts_per_page', $_GET['offset'] ); // set posts per page
			}
			$query = $this->horrell_customize_query_using_get_params( $query, $_GET );
		}

		public function lease_properties_to_exclude() {
			// exclude all the lease properties which has property type (industrial or office or retail)
			$query = new WP_Query(
				array(
					'post_type'      => 'property',
					'post_status'    => 'publish',
					'fields'         => 'ids',
					'posts_per_page' => -1,
					'tax_query'      => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'property_sale_type',
							'field'    => 'slug',
							'terms'    => array( 'lease' ),
						),
						array(
							'taxonomy' => 'property_categories',
							'field'    => 'slug',
							'terms'    => array( 'industrial', 'office', 'retail' ),
						),
					),
				)
			);

			// print_r($query->posts);
			return ! empty( $query->posts ) ? $query->posts : array();
			wp_reset_query();
		}

		public function get_param_value( $name, $parms = array() ) {
			// function to fetch value from the $params array or the GET request parameters
			if ( ! empty( $parms ) ) {
				if ( isset( $parms[ $name ] ) && ! empty( $parms[ $name ] ) ) {
					return esc_attr( $parms[ $name ] );
				}

				return '';
			}
			if ( isset( $_GET[ $name ] ) && ! empty( $_GET[ $name ] ) ) {
				return esc_attr( $_GET[ $name ] );
			}

			return '';
		}

		public function horrell_save_meta_function( $post_id, $post, $update ) {
			// function to save the post's selected taxonomy terms into a meta field(acf field). The purpose is to show hide specific ACF fields based on selected terms, because the conditional logics cannot be set directly based on selected taxonomy terms.
			if ( get_post_type( $post_id ) !== 'property' && get_post_type( $post_id ) !== 'space' ) { // continue only if the post type is "property" or "space"
				return;
			}
			$property_types_selected_terms = array();
			$property_types                = get_the_terms( $post_id, 'property_categories' );
			if ( ! empty( $property_types ) ) { // set the selected term slugs based on the term ID.
				foreach ( $property_types as $pt ) {
					switch ( $pt->term_id ) {
						case '163':
							$property_types_selected_terms[] = 'industrial';
							break;
						case '3':
							$property_types_selected_terms[] = 'land';
							break;
						case '5':
							$property_types_selected_terms[] = 'retail';
							break;
						case '4':
							$property_types_selected_terms[] = 'office';
							break;
						default:
							break;
					}
				}
				if ( ! empty( $property_types_selected_terms ) ) {
					update_field( 'property_type', $property_types_selected_terms, $post_id ); // update the field(property_type) again in order to keep the acf field(property_type) and taxonomy (Property Type)) synced
				}
			}
			$property_offer_types_selected_terms = array();
			$property_sale_types                 = get_the_terms( $post_id, 'property_sale_type' );
			if ( ! empty( $property_sale_types ) ) {
				foreach ( $property_sale_types as $pt ) { // set the selected term slugs based on the term ID.
					switch ( $pt->term_id ) {
						case '9':
							$property_offer_types_selected_terms[] = 'lease';
							break;
						case '8':
							$property_offer_types_selected_terms[] = 'sale';
							break;
						default:
							break;
					}
				}
				if ( ! empty( $property_offer_types_selected_terms ) ) {
					update_field( 'size_and_price_details_for', $property_offer_types_selected_terms, $post_id ); // update the field(size_and_price_details_for) again in order to keep the acf field(size_and_price_details_for) and taxonomy (Property Offer Type)) synced
				}
			}
		}

		public function acf_customize_property_offer_type_options( $field ) {
			if ( get_post_type() == 'space' ) { // change acf field options (hidden fields in backend : property type and property offer type), those fields are only used to control other fields using ACF conditional logics
				$field['default_value'] = array( 'space' );
				if ( isset( $field['choices']['sale'] ) ) {
					unset( $field['choices']['sale'] );
				}
				if ( isset( $field['choices']['lease'] ) ) {
					unset( $field['choices']['lease'] );
				}
			} elseif ( get_post_type() == 'property' ) {
				$field['default_value'] = array( 'sale' );
				if ( isset( $field['choices']['space'] ) ) {
					unset( $field['choices']['space'] );
				}
			}

			// return the field
			return $field;
		}
	}

	global $Horrell_Property;
	$Horrell_Property = new Horrell_Property();
}
