<?php
if ( ! class_exists( 'Horrell_Saved_Listings' ) ) {
	class Horrell_Saved_Listings {
		public function __construct() {
			add_action(
				'init',
				array(
					$this,
					'saved_listing_form_handler_download',
				)
			); // form handler to download the merged pdf
			add_action( 'init', array( $this, 'start_session' ), 1 ); // start the session if not started

			add_action(
				'wp_ajax_save_listing',
				array(
					$this,
					'horrell_save_listing_callback_logged_in',
				)
			); // ajax to handle the save properties to save listing (for logged in users)
			add_action(
				'wp_ajax_nopriv_save_listing',
				array(
					$this,
					'horrell_save_listing_callback_non_loggedin',
				)
			);// ajax to handle the save properties to save listing (for non logged in users)
			add_action(
				'wp_ajax_save_listing_send_mail',
				array( $this, 'horrell_sl_send_email_callback' )
			); // ajax to handle send email (for logged in users)
			add_action(
				'wp_ajax_nopriv_save_listing_send_mail',
				array(
					$this,
					'horrell_sl_send_email_callback',
				)
			); // ajax to handle send email (for non logged in users)
			add_filter(
				'wp_mail_content_type',
				function () {
					// change the email type to html
					return 'text/html';
				}
			);
			add_action(
				'wp_login',
				function ( $user_login ) {
					// if user logins, fetch the saved listing from session and merge it into user database's saved listing.
					$saved_listings_session = isset( $_SESSION['saved_listings'] ) ? $_SESSION['saved_listings'] : array(); // check if the session has saved listings
					$saved_listings_user    = $this->horrell_get_saved_listings(); // get the saved listings from the user database
					$merged_saved_listing   = array_unique( array_merge( $saved_listings_session, $saved_listings_user ), SORT_REGULAR ); // merge listings from both session and user database
					$user                   = get_user_by( 'login', 'loginname' ); // get user details using username
					if ( $user ) {
						update_user_meta( $user->ID, 'saved_listing', $merged_saved_listing ); // update the user database with merged listings.
					}
				}
			);
		}

		public function start_session() {
			if ( ! session_id() ) {
				session_start();
			}
		}

		public function horrell_sl_send_email_callback() {
			// function to handle : send email regarding the save listings.
			$post_data = array();
			parse_str( $_POST['form_data'], $post_data );
			if ( ! isset( $post_data['recipient_name'] ) || ! isset( $post_data['recipient_email'] ) || ! isset( $post_data['your_name'] ) || ! isset( $post_data['your_email'] ) ) {
				die(
					array(
						'status'  => 0,
						'message' => 'Invalid form data',
					)
				);
			}
			$listings = $this->horrell_get_saved_listings();
			ob_start();
			get_template_part(
				'email-templates/tmpl-saved-listing',
				null,
				array(
					'form_data' => $post_data,
					'listings'  => $listings,
				)
			);
			$message = ob_get_contents();
			ob_end_clean();
			$to = $post_data['recipient_email'];
			if ( isset( $post_data['send_me_copy'] ) ) {
				$to .= ', ' . $post_data['your_email'];
			}
			$subject = 'Horrell Company Listings shared by ' . $post_data['your_name'];
			wp_mail( $to, $subject, $message );

			wp_send_json(
				array(
					'status'  => 1,
					'message' => 'Thank you. Your message has been sent!',
				)
			);
		}

		public function saved_listing_form_handler_download() {
			// form handler when the download pdf form on saved listing page is triggered,
			if ( ! isset( $_POST['pdfs'] ) ) {
				return;
			}
			ob_start();
			if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) { // load all the composer packages
				require_once get_template_directory() . '/vendor/autoload.php';
			}
			require_once get_template_directory() . '/vendor/autoload.php';
			$pdf = new \Clegginabox\PDFMerger\PDFMerger(); // library to handle the pdf merger
			foreach ( $_POST['pdfs'] as $file ) {
				if ( file_exists( wp_upload_dir()['path'] . '/' . $file ) ) {
					$pdf->addPDF( wp_upload_dir()['path'] . '/' . $file, 'all' ); // combine all the pdf files to merge
				}
			}
			$pdf->merge( 'download', 'saved-listings.pdf' ); // download merged pdf file
			ob_end_flush();
		}

		public function check_property_in_saved_listing( $id = null ) {
			// function to check if the property is in saved listing
			if ( is_null( $id ) ) {
				return false;
			}
			$saved_listings = $this->horrell_get_saved_listings();
			if ( in_array( $id, $saved_listings ) ) {
				return true;
			}

			return false;
		}

		public function horrell_get_saved_listings() {
			// get all properties currently in  the saved listings
			$saved_listing = array();
			if ( get_current_user_id() ) { // if user is logged in, saved listings are stored in user meta
				$user_saved_listing = get_user_meta( get_current_user_id(), 'saved_listing', true );
				if ( ! empty( $user_saved_listing ) ) {
					$saved_listing = $user_saved_listing;
				}
			} else { // if user is not logged in, saved listings are stored in user session
				if ( isset( $_SESSION['saved_listings'] ) ) {
					$saved_listing = $_SESSION['saved_listings'];
				}
			}

			return $saved_listing;
		}

		public function horrell_save_listing_callback_non_loggedin() {
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'horrell-ajax-nonce' ) ) {
				die( 'Nonce value cannot be verified.' ); // die if invalid nonce ajax request
			}
			if ( ! isset( $_POST['property_id'] ) ) { // property to be added to saved listing
				die( 'invalid submit' );
			}
			$property_id   = (int) substr( $_POST['property_id'], 9 ); // extract the property_id passed in parameter
			$saved_listing = isset( $_SESSION['saved_listings'] ) ? $_SESSION['saved_listings'] : array();
			if ( is_array( $saved_listing ) && in_array( $property_id, $saved_listing ) ) { // if property is already in the saved listing, remove from the list
				$save_status   = 0; // save status is set 0 if removed and 1 if added
				$saved_listing = array_diff( $saved_listing, array( $property_id ) );
			} else { // if property do not exists in saved listing, then save it to list
				$save_status = 1; // save status is set 0 if removed and 1 if added
				if ( ! empty( $saved_listing ) ) {
					$saved_listing[] = $property_id;
				} else {
					$saved_listing = array( $property_id );
				}
			}
			$_SESSION['saved_listings'] = $saved_listing;
			$return                     = array(
				'saved_listing' => true,
				'saved_status'  => $save_status,
				'list_count'    => count( $saved_listing ),
			);
			wp_send_json( $return );
		}

		public function horrell_save_listing_callback_logged_in() {
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'horrell-ajax-nonce' ) ) {
				die( 'Nonce value cannot be verified.' ); // die if invalid nonce ajax request
			}
			if ( ! isset( $_POST['property_id'] ) ) { // property to be added to saved listing
				die( 'invalid submit' );
			}
			$property_id   = (int) substr( $_POST['property_id'], 9 ); // extract the property_id passed in parameter
			$current_user  = wp_get_current_user();
			$saved_listing = get_user_meta( $current_user->ID, 'saved_listing', true );
			if ( is_array( $saved_listing ) && in_array( $property_id, $saved_listing ) ) { // if property is already in the saved listing, remove from the list
				$save_status   = 0; // save status is set 0 if removed and 1 if added
				$saved_listing = array_diff( $saved_listing, array( $property_id ) );
			} else { // if property do not exists in saved listing, then save it to list
				$save_status = 1; // save status is set 0 if removed and 1 if added
				if ( ! empty( $saved_listing ) ) {
					$saved_listing[] = $property_id;
				} else {
					$saved_listing = array( $property_id );
				}
			}
			update_user_meta( $current_user->ID, 'saved_listing', $saved_listing );
			$return = array(
				'saved_listing' => true,
				'saved_status'  => $save_status,
				'list_count'    => count( $saved_listing ),
			);
			wp_send_json( $return );
		}

	}

	global $Horrell_Saved_Listings;
	$Horrell_Saved_Listings = new Horrell_Saved_Listings();
}
