<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package horrell
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function horrell_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'horrell_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function horrell_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'horrell_pingback_header' );


//enqueue all custom styles and js scripts
function horrell_enqueue_scripts_and_styles() {
	$min = ( 'SCRIPT_DEBUG' == true ) ? '' : '.min';
	wp_enqueue_style( 'horrell-main-style', get_template_directory_uri() . '/assets/css/main' . $min . '.css', array(), _S_VERSION );
	wp_enqueue_script( 'horrell-main', get_template_directory_uri() . '/assets/js/main' . $min . '.js', array( 'jquery' ), _S_VERSION, true );
	$map_details         = array();
	$map_details["icon"] = get_template_directory_uri() . '/assets/images/house.png';
	$map_details["html"] = 'Horrell Company ';
	if ( get_field( 'gs_company_location_id', 'option' ) ) {
		$map_details['gs_company_location_id'] = get_field( 'gs_company_location_id', 'option' );
	} // localizing script with php values to js
	wp_localize_script(
		'horrell-main',
		'horrell_obj',
		array(
			'ajax_url'    => admin_url( 'admin-ajax.php' ), // ajax url
			'nonce_ajax'  => wp_create_nonce( 'horrell-ajax-nonce' ), // nonce for valid ajax request
			'get_params'  => isset( $_GET ) ? $_GET : array(), // all get parameters
			'map_details' => $map_details
		)
	); // localizing script with php values to js

	wp_enqueue_script( 'horrell-vendor', get_template_directory_uri() . '/assets/js/vendor' . $min . '.js', array( 'jquery' ), _S_VERSION, true );
	wp_enqueue_script( 'google-map-api', "https://maps.googleapis.com/maps/api/js?key=" . esc_html( get_field( "gs_google_api_key", "option" ) ) . "&callback=Function.prototype", _S_VERSION, true ); // enqueue google map js
}

add_action( 'wp_enqueue_scripts', 'horrell_enqueue_scripts_and_styles' );

// Setup Backend Horrell Settings Page
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Horrell Settings',
		'menu_title' => 'Horrell Settings',
		'menu_slug'  => 'horrell-settings',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );

}
// Method 2: Setting.
function horrell_acf_init() {
	acf_update_setting( 'google_api_key', get_field( "gs_google_api_key", "option" ) ); // setup acf google map API using the ke stored in ACF field
}

add_action( 'acf/init', 'horrell_acf_init' );

add_action( 'pre_get_posts', function ( $query ) {
	if ( ! $query->get( 'post_type' ) ) { // only for original posts and not for custom post types
		$query->set( 'post_status', array( 'publish' ) );
	}
//	$query->set( 'post_status', array( 'publish' ) );
}, 9999 ); // by default only list published posts.

add_filter( "navigation_markup_template", function ( $template, $class ) { // remove the wp pagination wrapper using the hook
	$template = '%3$s';

	return $template;
}, 999, 2 );