<?php
if ( ! isset( $args['property_sale_type'] ) && ! isset( $args['property_categories'] ) ) { // taxonomy parameters that determines the related properties to be displayed
	return;
}
$post_type       = get_post_type();
$current_post_id = get_the_ID();
$slugs_ps_type   = [];
$slugs_p_cat     = [];
if ( ! empty( $args['property_sale_type'] ) ) {
	foreach ( $args['property_sale_type'] as $term ) {
		$slugs_ps_type[] = $term->slug;
	}
}

if ( ! empty( $args['property_categories'] ) ) {
	foreach ( $args['property_categories'] as $term ) {
		$slugs_p_cat[] = $term->slug;
	}
}

$tax_query = [
	'relation' => 'AND',
	[
		'taxonomy' => 'property_sale_type',
		'field'    => 'slug',
		'terms'    => $slugs_ps_type,
	],
	[
		'taxonomy' => 'property_categories',
		'field'    => 'slug',
		'terms'    => $slugs_p_cat,
	],
];
/**
 * for all the spaces *
 */
if ( 'space' == $post_type ) {
	$query_args          = [
		'posts_per_page' => - 1,
		'post_type'      => 'property',
		'post_status'    => 'publish',
		'tax_query'      => $tax_query,
		'fields'         => 'ids',
	];
	$query_related_props = new WP_Query( $query_args );
	$related_props       = $query_related_props->posts;
	wp_reset_query();
	$current_available_space = get_field( 'available_space', $current_post_id );
	$related_spaces          = [];
	$query_args              = [
		'posts_per_page' => 2,
		'post_type'      => 'space',
		'post_status'    => 'publish',
		'post__not_in'   => [ $current_post_id ],
		'meta_query'     => [
			'relation' => 'AND',
			[
				'key'     => 'parent_property',
				'value'   => $related_props,
				'compare' => 'IN',
			],
			[
				'key'     => 'available_space',
				'value'   => (int) $current_available_space,
				'compare' => '>=',
				'type'    => 'numeric',
			],
		],
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'meta_key'       => 'available_space',
		'fields'         => 'ids',
	];
	$query1                  = new WP_Query( $query_args );
	if ( isset( $query1->posts ) && ! empty( $query1->posts ) ) {
		$related_spaces = $query1->posts;
	}
	$query_args = [
		'posts_per_page' => 2,
		'post_type'      => 'space',
		'post_status'    => 'publish',
		'post__not_in'   => [ $current_post_id ],
		'meta_query'     => [
			'relation' => 'AND',
			[
				'key'     => 'parent_property',
				'value'   => $related_props,
				'compare' => 'IN',
			],
			[
				'key'     => 'available_space',
				'value'   => (int) $current_available_space,
				'compare' => '<=',
				'type'    => 'numeric',
			],
		],
		'orderby'        => 'meta_value_num',
		'order'          => 'DESC',
		'meta_key'       => 'available_space',
		'fields'         => 'ids',
	];
	$query2     = new WP_Query( $query_args );
	if ( isset( $query2->posts ) && ! empty( $query2->posts ) ) {
		$related_spaces = array_merge( $query2->posts, $related_spaces );
	}
	if ( ! empty( $related_spaces ) ) {
		?>
        <!-- related properties -->
        <section id="related-properties"
                 class="related-properties properties-listing">
            <div class="container">
                <div class="border-wrapper">
                    <h2>Related Properties</h2>
                    <div class="row properties-list">
						<?php
						foreach ( $related_spaces as $space_id ) {
							get_template_part( 'template-parts/property/single/related/content', 'space-grid', [ 'space_id' => $space_id ] );
						}
						?>
                    </div>
                </div>
            </div>
        </section>
        <!-- related properties ends -->
		<?php
	}
} /**
 * for all the properties *
 */
elseif ( 'property' == $post_type ) {
	if ( in_array( 'sale', $slugs_ps_type ) ) // for all the properties that must have the offer type selected as "sale"
	{
		$related_props       = [];
		$met_key_name_to_use = 'sale_building_size'; //default to be assumed as non-land and set meta query accordingly
		if ( has_term( 'land', 'property_categories', $current_post_id ) ) {
			$met_key_name_to_use = 'sale_convert_lot_size_to_sf'; // if land-property, change the meta query accordingly
		}
		// for all the non-land properties (which is available for both sale and lease), in such case adjust query to read only non-land sale properties (because lease non-land properties are associated to spaces)
		if ( ! has_term( 'land', 'property_categories', $current_post_id ) && ( in_array( 'sale', $slugs_ps_type ) && in_array( 'lease', $slugs_ps_type ) ) ) {
			$tax_query = [
				'relation' => 'AND',
				[
					'taxonomy' => 'property_sale_type',
					'field'    => 'slug',
					'terms'    => [ 'sale' ],
				],
				[
					'taxonomy' => 'property_categories',
					'field'    => 'slug',
					'terms'    => $slugs_p_cat,
				],
			];
		}
		$pty_size_value = get_field( $met_key_name_to_use, $current_post_id );
		$query_args     = [
			'posts_per_page' => 2,
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'tax_query'      => $tax_query,
			'post__not_in'   => [ $current_post_id ],
			'meta_query'     => [
				'key'     => $met_key_name_to_use,
				'value'   => (int) $pty_size_value,
				'compare' => '>=',
				'type'    => 'numeric',
			],
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_key'       => $met_key_name_to_use,
			'fields'         => 'ids',
		];
		$query1         = new WP_Query( $query_args );
		if ( isset( $query1->posts ) && ! empty( $query1->posts ) ) {
			$related_props = $query1->posts;
		}
		$query_args = [
			'posts_per_page' => 2,
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'tax_query'      => $tax_query,
			'post__not_in'   => [ $current_post_id ],
			'meta_query'     => [
				'key'     => $met_key_name_to_use,
				'value'   => (int) $pty_size_value,
				'compare' => '<=',
				'type'    => 'numeric',
			],
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'meta_key'       => $met_key_name_to_use,
			'fields'         => 'ids',
		];
		$query2     = new WP_Query( $query_args );
		if ( isset( $query2->posts ) && ! empty( $query2->posts ) ) {
			$related_props = array_merge( $query2->posts, $related_props );
		}
		if ( ! empty( $related_props ) ) {
			?>
            <!--         related properties-->
            <section id="related-properties"
                     class="related-properties properties-listing">
                <div class="container">
                    <div class="border-wrapper">
                        <h2>Related Properties</h2>
                        <div class="row properties-list">
							<?php
							foreach ( $related_props as $prop_id ) {
								get_template_part( 'template-parts/property/single/related/content', 'property-grid', [ 'property_id' => $prop_id ] );
							}
							?>
                        </div>
                    </div>
                </div>
            </section>
            <!--         related properties ends-->
			<?php
			wp_reset_query();
		} //for all the sale properties that are land
	} elseif ( in_array( 'lease', $slugs_ps_type ) && in_array( 'land', $slugs_p_cat ) ) { // for all the lease land-properties
		$related_props       = [];
		$met_key_name_to_use = 'lease_convert_lot_size_to_sf';
		$pty_size_value      = get_field( $met_key_name_to_use, $current_post_id );
		$query_args          = [
			'posts_per_page' => 2,
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'tax_query'      => $tax_query,
			'post__not_in'   => [ $current_post_id ],
			'meta_query'     => [
				'key'     => $met_key_name_to_use,
				'value'   => (int) $pty_size_value,
				'compare' => '>=',
				'type'    => 'numeric',
			],
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'meta_key'       => $met_key_name_to_use,
			'fields'         => 'ids',
		];
		$query1              = new WP_Query( $query_args );
		if ( isset( $query1->posts ) && ! empty( $query1->posts ) ) {
			$related_props = $query1->posts;
		}
		$query_args = [
			'posts_per_page' => 2,
			'post_type'      => 'property',
			'post_status'    => 'publish',
			'tax_query'      => $tax_query,
			'post__not_in'   => [ $current_post_id ],
			'meta_query'     => [
				'key'     => $met_key_name_to_use,
				'value'   => (int) $pty_size_value,
				'compare' => '<=',
				'type'    => 'numeric',
			],
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'meta_key'       => $met_key_name_to_use,
			'fields'         => 'ids',
		];
		$query2     = new WP_Query( $query_args );
		if ( isset( $query2->posts ) && ! empty( $query2->posts ) ) {
			$related_props = array_merge( $query2->posts, $related_props );
		}
		if ( ! empty( $related_props ) ) {
			?>
            <!--         related properties-->
            <section id="related-properties"
                     class="related-properties properties-listing">
                <div class="container">
                    <div class="border-wrapper">
                        <h2>Related Properties</h2>
                        <div class="row properties-list">
							<?php
							foreach ( $related_props as $prop_id ) {
								get_template_part( 'template-parts/property/single/related/content', 'property-grid', [ 'property_id' => $prop_id ] );
							}
							?>
                        </div>
                    </div>
                </div>
            </section>
            <!--         related properties ends-->
			<?php
		}
		wp_reset_query();
	}
}

