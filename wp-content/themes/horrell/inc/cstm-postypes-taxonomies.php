<?php
add_action( 'init', function () { //register all custom post types and taxonomies
	register_post_type( 'team', array(
		'labels'       => array(
			'name'               => 'Team Members',
			'singular_name'      => 'Team Member',
			'add_new'            => 'Add new Team Member',
			'edit_item'          => 'Edit Team Member',
			'new_item'           => 'New Team Member',
			'view_item'          => 'View Team Members',
			'search_items'       => 'Search Team Members',
			'not_found'          => 'No Team Member found',
			'not_found_in_trash' => 'No Team Member found in Trash',
			'menu_position'      => 5
		),
		'public'       => false,
		'has_archive'  => false,
		'supports'     => array( 'title', 'thumbnail', 'excerpt', 'editor' ),
		'show_ui'      => true,
		'show_in_menu' => true
	) );
	register_post_type( 'property', array(
		'labels'       => array(
			'name'               => 'Properties',
			'singular_name'      => 'Properties',
			'add_new'            => 'Add new Properties',
			'edit_item'          => 'Edit Properties',
			'new_item'           => 'New Properties',
			'view_item'          => 'View Properties',
			'search_items'       => 'Search Properties',
			'not_found'          => 'No Properties found',
			'not_found_in_trash' => 'No Properties found in Trash',
			'menu_position'      => 5
		),
		'public'       => true,
		'has_archive'  => true,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_ui'      => true,
		'show_in_menu' => true
	) );
	register_taxonomy( 'property_categories', array( 'property', 'space' ), array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels'       => array(
			'name'              => _x( 'Property Type', 'taxonomy general name' ),
			'singular_name'     => _x( 'Property-Type', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Property-Type' ),
			'all_items'         => __( 'All Property-Type' ),
			'parent_item'       => __( 'Parent Property-Type' ),
			'parent_item_colon' => __( 'Parent Property-Type:' ),
			'edit_item'         => __( 'Edit Property-Type' ),
			'update_item'       => __( 'Update Property-Type' ),
			'add_new_item'      => __( 'Add New Property-Type' ),
			'new_item_name'     => __( 'New Property-Type Name' ),
			'menu_name'         => __( 'Properties Type' ),
		),

		// Control the slugs used for this taxonomy
		'rewrite'      => array(
			'slug'         => 'property-category', // This controls the base slug that will display before each term
			'with_front'   => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	) );
	register_taxonomy( 'property_sale_type', array( 'property', 'space' ), array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels'       => array(
			'name'              => _x( 'Property Offer Type', 'taxonomy general name' ),
			'singular_name'     => _x( 'Property-Offer-Type', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Property Offer Type' ),
			'all_items'         => __( 'All Property Offer Type' ),
			'parent_item'       => __( 'Parent Property Offer Type' ),
			'parent_item_colon' => __( 'Parent Property Offer Type:' ),
			'edit_item'         => __( 'Edit Property Offer Type' ),
			'update_item'       => __( 'Update Property Offer Type' ),
			'add_new_item'      => __( 'Add New Property Offer Type' ),
			'new_item_name'     => __( 'New Property Offer Type' ),
			'menu_name'         => __( 'Property Offer Type' ),
		),

		// Control the slugs used for this taxonomy
		'rewrite'      => array(
			'slug'         => 'property-sale-type', // This controls the base slug that will display before each term
			'with_front'   => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	) );

	register_post_type( 'space', array(
		'labels'       => array(
			'name'               => 'Spaces',
			'singular_name'      => 'Space',
			'add_new'            => 'Add new Space',
			'edit_item'          => 'Edit Space',
			'new_item'           => 'New Space',
			'view_item'          => 'View Space',
			'search_items'       => 'Search Spaces',
			'not_found'          => 'No Spaces found',
			'not_found_in_trash' => 'No Spaces found in Trash',
			'menu_position'      => 5
		),
		'public'       => true,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_ui'      => true,
		'show_in_menu' => true
	) );
} );