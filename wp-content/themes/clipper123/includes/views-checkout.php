<?php
/**
 * Checkout Steps Views.
 *
 * @package Clipper\Views\Checkout
 * @author  AppThemes
 * @since   Clipper 1.6
 */


/**
 * Listing Checkout Steps Helper Class
 * @since 1.6
 */
class CLPR_Coupon_Checkout_Step extends APP_Checkout_Step {

	/**
	 * Returns listing object for editing.
	 *
	 * @return object
	 */
	public function get_listing_obj() {
		$listing_id = is_object( $this->checkout ) ? $this->checkout->get_data( 'listing_id' ) : false;

		if ( $listing_id ) {
			$listing = get_post( $listing_id );
		} else if ( isset( $_GET['listing_renew'] ) ) {
			$listing = get_post( $_GET['listing_renew'] );
		} else if ( isset( $_GET['listing_edit'] ) ) {
			$listing = get_post( $_GET['listing_edit'] );
		} else {
			$listing = appthemes_get_draft_post( APP_POST_TYPE );
		}

		return ( $listing ) ? clpr_get_listing_obj( $listing->ID ) : false;
	}

	/**
	 * Checks if field is valid and have no errors assigned.
	 *
	 * @param string $field_name
	 *
	 * @return bool
	 */
	public function is_field_valid( $field_name ) {

		if ( $this->errors->get_error_message( 'missed-' . $field_name ) ) {
			return false;
		}

		if ( $this->errors->get_error_message( 'invalid-' . $field_name ) ) {
			return false;
		}

		return true;
	}

}


/**
 * Form Step: Edit Listing Details
 * @since 1.6
 */
class CLPR_Coupon_Form_Edit extends CLPR_Coupon_Checkout_Step {

	protected $errors;
	protected $posted_fields;

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {
		global $clpr_options;

		if ( ! $clpr_options->coupon_edit ) {
			return;
		}

		$this->errors = new WP_Error();

		parent::__construct( 'listing-edit', array(
			'register_to' => array(
				'edit-listing',
			)
		) );

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		the_post();

		$listing = $this->get_listing_obj();
		$checkout->add_data( 'listing_id', $listing->ID );

		appthemes_load_template( 'form-listing-edit.php', array(
			'action' => $checkout->get_checkout_type(),
			'listing' => $listing,
		) );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {

		if ( ! isset( $_POST['action'] ) || 'edit-listing' !== $_POST['action'] ) {
			return;
		}

		check_admin_referer( $checkout->get_checkout_type() );

		$this->posted_fields = $this->clean_expected_fields();

		$this->errors = $this->validate_fields( $this->errors );
		$this->errors = apply_filters( 'clpr_coupon_validate_fields', $this->errors );

		$this->update_listing( $order, $checkout );

		if ( $this->errors->get_error_codes() ) {
			return false;
		}

		// add notice about successful update
		$link = html_link( clpr_get_dashboard_url(), __( 'Return to my dashboard', APP_TD ) );
		appthemes_add_notice( 'updated', __( 'Your coupon has been successfully updated.', APP_TD ) . ' ' . $link, 'success' );

		$checkout->add_data( 'posted_fields', $this->posted_fields );
		$this->finish_step();
	}

	/**
	 * Updating listing.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function update_listing( $order, $checkout ) {

		$this->update_attachments( $order, $checkout );

		$listing = $this->get_listing_obj();
		$listing_args = array();

		// save form fields
		foreach ( $this->expected_fields() as $field_name ) {
			// do not save this field, it has been marked as invalid during validation
			if ( ! $this->is_field_valid( $field_name ) ) {
				continue;
			}

			$field_value = $this->posted_fields[ $field_name ];

			// save meta custom fields (have 'clpr_' prefix)
			if ( appthemes_str_starts_with( $field_name, 'clpr_' ) ) {
				if ( ! is_array( $field_value ) ) {
					update_post_meta( $listing->ID, $field_name, $field_value );
				}
			}

			// look for listing title and content
			if ( in_array( $field_name, array( 'post_title', 'post_content' ) ) ) {
				$listing_args[ $field_name ] = $field_value;
			}

			// save category
			if ( $field_name == APP_TAX_CAT ) {
				wp_set_object_terms( $listing->ID, (int) $field_value, APP_TAX_CAT );
			}

			// save type
			if ( $field_name == APP_TAX_TYPE ) {
				wp_set_object_terms( $listing->ID, $field_value, APP_TAX_TYPE, false );
			}

			// save tags
			if ( $field_name == APP_TAX_TAG ) {
				$tags = ! empty( $field_value ) ? explode( ',', $field_value ) : '';
				wp_set_object_terms( $listing->ID, $tags, APP_TAX_TAG );
			}

		}

		// update listing
		if ( ! empty( $listing_args ) ) {
			$listing_args['ID'] = $listing->ID;
			$listing_id = wp_update_post( $listing_args );
		}

		do_action( 'clpr_update_listing', $listing->ID, $order, $checkout );
	}

	/**
	 * Updating attachments.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function update_attachments( $order, $checkout ) {
		global $clpr_options;

		// needed for image uploading and deleting to work
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$listing = $this->get_listing_obj();

		// upload printable coupon
		if ( $this->posted_fields[ APP_TAX_TYPE ] == 'printable-coupon' && $this->is_field_valid( 'files_image' ) && ! empty( $_FILES['coupon-upload']['name'] ) ) {
			$file = wp_handle_upload( $_FILES['coupon-upload'], array( 'test_form' => false ) );
			if ( isset( $file['error'] ) ) {
				$this->errors->add( 'invalid-files_image', sprintf( __( 'Error: %s', APP_TD ), $file['error'] ) );
			} else {
				$name_parts = pathinfo( $_FILES['coupon-upload']['name'] );

				// Remove old assigned printable coupons
				clpr_remove_printable_coupon( $listing->ID );

				$attachment = array(
					'post_mime_type' => $file['type'],
					'guid' => $file['url'],
					'post_parent' => $listing->ID,
					'post_title' => trim( $name_parts['filename'] ),
					'post_content' => '',
				);

				// use image exif/iptc data for title and caption defaults if possible
				if ( $image_meta = @wp_read_image_metadata( $file['file'] ) ) {
					if ( ! empty( $image_meta['title'] ) ) {
						$attachment['post_title'] = trim( $image_meta['title'] );
					}
					if ( ! empty( $image_meta['caption'] ) ) {
						$attachment['post_content'] = trim( $image_meta['caption'] );
					}
				}

				$attachment_id = wp_insert_attachment( $attachment, $file['file'], $listing->ID );
				if ( ! is_wp_error( $attachment_id ) ) {
					wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $file['file'] ) );
					wp_set_object_terms( $attachment_id, 'printable-coupon', APP_TAX_IMAGE, false );
				} else {
					$this->errors->add( 'invalid-files_image', __( 'There was an error while adding printable coupon.', APP_TD ) );
				}
			}

		}

	}

	/**
	 * Validates submitted fields.
	 *
	 * @param object $errors
	 *
	 * @return object
	 */
	public function validate_fields( $errors ) {
		global $clpr_options;

		$listing = $this->get_listing_obj();

		// Validate printable coupon.
		if ( $this->posted_fields[ APP_TAX_TYPE ] == 'printable-coupon' ) {
			if ( ! empty( $_FILES['coupon-upload']['name'] ) ) {
				// Make sure the file uploaded is an approved type (i.e. jpg, png, gif, etc).
				$allowed = explode( ',', $clpr_options->submit_file_types );
				$extension = strtolower( pathinfo( $_FILES['coupon-upload']['name'], PATHINFO_EXTENSION ) );
				if ( ! in_array( $extension, $allowed ) ) {
					$errors->add( 'invalid-files_image', __( 'Invalid file type.', APP_TD ) );
				}
			} else {
				if ( ! clpr_has_printable_coupon( $listing->ID ) ) {
					$errors->add( 'missed-files_image', __( 'Please upload printable coupon file.', APP_TD ) );
				}
			}
		}

		// Validate category.
		if ( empty( $this->posted_fields[ APP_TAX_CAT ] ) ) {
			$errors->add( 'missed-' . APP_TAX_CAT, sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Category', APP_TD ) ) );
		} else {
			$category = get_term_by( 'id', $this->posted_fields[ APP_TAX_CAT ], APP_TAX_CAT );
			if ( ! $category ) {
				$errors->add( 'invalid-' . APP_TAX_CAT, sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Coupon Category', APP_TD ) ) );
			}
		}

		// Validate coupon type.
		if ( empty( $this->posted_fields[ APP_TAX_TYPE ] ) ) {
			$errors->add( 'missed-' . APP_TAX_TYPE, sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Type', APP_TD ) ) );
		} else {
			$type = get_term_by( 'slug', $this->posted_fields[ APP_TAX_TYPE ], APP_TAX_TYPE );
			if ( ! $type ) {
				$errors->add( 'invalid-' . APP_TAX_TYPE, sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Coupon Type', APP_TD ) ) );
			}
		}

		// Validate expiration date.
		if ( ! empty( $this->posted_fields['clpr_expire_date'] ) && ! clpr_is_valid_expiration_date( $this->posted_fields['clpr_expire_date'] ) ) {
			$errors->add( 'invalid-clpr_expire_date', sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Expiration Date', APP_TD ) ) );
		}

		// Validate coupon code.
		if ( $this->posted_fields[ APP_TAX_TYPE ] == 'coupon-code' && empty( $this->posted_fields['clpr_coupon_code'] ) ) {
			$errors->add( 'missed-clpr_coupon_code', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Code', APP_TD ) ) );
		}

		// Validate coupon destination url.
		if ( empty( $this->posted_fields['clpr_coupon_aff_url'] ) ) {
			$errors->add( 'missed-clpr_coupon_aff_url', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Destination URL', APP_TD ) ) );
		} else if ( ! wp_http_validate_url( $this->posted_fields['clpr_coupon_aff_url'] ) ) {
			$errors->add( 'invalid-clpr_coupon_aff_url', sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Destination URL', APP_TD ) ) );
		}

		// Validate coupon title.
		if ( empty( $this->posted_fields['post_title'] ) ) {
			$errors->add( 'missed-post_title', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Title', APP_TD ) ) );
		}

		// Validate coupon description.
		if ( empty( $this->posted_fields['post_content'] ) ) {
			$errors->add( 'missed-post_content', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Description', APP_TD ) ) );
		}

		return $errors;
	}

	/**
	 * Returns fields names that we expect.
	 *
	 * @return array
	 */
	protected function expected_fields() {
		global $clpr_options;

		$fields = array(
			'post_title',
			'post_content',
			APP_TAX_CAT,
			APP_TAX_TYPE,
			APP_TAX_TAG,
			'clpr_coupon_code',
			'clpr_coupon_aff_url',
		);

		if ( ! $clpr_options->prune_coupons ) {
			$fields[] = 'clpr_expire_date';
		}

		return $fields;
	}

	/**
	 * Returns cleaned fields that we expect.
	 *
	 * @return array
	 */
	protected function clean_expected_fields() {
		global $clpr_options;

		$posted = array();

		foreach ( $this->expected_fields() as $field ) {
			$posted[ $field ] = isset( $_POST[ $field ] ) ? $_POST[ $field ] : '';

			if ( ! is_array( $posted[ $field ] ) ) {
				$posted[ $field ] = appthemes_clean( $posted[ $field ] );
			} else {
				$posted[ $field ] = array_map( 'appthemes_clean', $posted[ $field ] );
			}

			if ( $field == APP_TAX_TAG ) {
				$posted[ $field ] = appthemes_clean_tags( $posted[ $field ] );
				$posted[ $field ] = wp_kses_post( $posted[ $field ] );
			}

			if ( $field == 'post_content' ) {
				// check to see if html is allowed
				if ( ! $clpr_options->allow_html ) {
					$posted[ $field ] = appthemes_filter( $posted[ $field ] );
				} else {
					$posted[ $field ] = wp_kses_post( $posted[ $field ] );
				}
			}

			if ( $field == 'post_title' ) {
				$posted[ $field ] = appthemes_filter( $posted[ $field ] );
			}

		}

		return $posted;
	}

}


/**
 * Form Step: Edit/Fill Listing Details
 * @since 1.6
 */
class CLPR_Coupon_Form_Details extends CLPR_Coupon_Form_Edit {

	protected $errors;
	protected $posted_fields;

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {

		$register_to = array(
			'create-listing',
			'renew-listing',
		);

		$this->errors = new WP_Error();

		$this->setup( 'listing-details', array(
			'register_to' => $register_to
		) );

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		the_post();

		$listing = $this->get_listing_obj();
		$checkout->add_data( 'listing_id', $listing->ID );

		appthemes_load_template( 'form-listing-details.php', array(
			'action' => $checkout->get_checkout_type(),
			'listing' => $listing,
		) );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {
		global $clpr_options;

		if ( ! isset( $_POST['action'] ) || ! in_array( $_POST['action'], array( 'create-listing', 'renew-listing' ) ) ) {
			return;
		}

		check_admin_referer( $checkout->get_checkout_type() );

		$this->posted_fields = $this->clean_expected_fields();

		$this->errors = $this->validate_fields( $this->errors );
		$this->errors = apply_filters( 'clpr_coupon_validate_fields', $this->errors );
		if ( clpr_payments_is_enabled() ) {
			$this->errors = apply_filters( 'appthemes_validate_purchase_fields', $this->errors );
		}

		$this->update_listing( $order, $checkout );

		if ( $this->errors->get_error_codes() ) {
			return false;
		}

		$this->set_internal_data();

		$checkout->add_data( 'posted_fields', $this->posted_fields );

		$listing = $this->get_listing_obj();

		// update listing date and author
		$args = array(
			'ID' => $listing->ID,
			'post_status' => 'pending',
			'post_date' => current_time( 'mysql' ),
			'post_date_gmt' => current_time( 'mysql', 1 ),
			'post_author' => get_current_user_id(),
		);
		$listing_id = wp_update_post( $args );

		// send new notification email to admin
		if ( $clpr_options->new_ad_email ) {
			app_new_submission_email( $listing->ID );
		}

		if ( clpr_payments_is_enabled() ) {
			$price = $clpr_options->coupon_price;
			$order->add_item( CLPR_COUPON_LISTING_TYPE, $price, $listing->ID, true );
			do_action( 'appthemes_create_order', $order, APP_POST_TYPE );
		} else if ( $clpr_options->coupons_require_moderation ) {
			if ( get_current_user_id() != 1 && $clpr_options->nc_custom_email ) {
				clpr_owner_new_coupon_email( $listing->ID );
			}
		} else {
			// publish
			if ( get_current_user_id() != 1 && $clpr_options->nc_custom_email ) {
			  clpr_owner_new_published_coupon_email( $listing->ID );
			}
			wp_update_post( array(
				'ID' => $listing->ID,
				'post_status' => 'publish',
			) );
		}

		// save order complete and cancel urls
		$checkout->add_data( 'complete_url', appthemes_get_step_url( 'order-summary' ) );
		$checkout->add_data( 'cancel_url', appthemes_get_step_url( 'gateway-select' ) );

		$this->finish_step();
	}

	/**
	 * Updating listing.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function update_listing( $order, $checkout ) {
		global $clpr_options;

		parent::update_listing( $order, $checkout );

		$listing = $this->get_listing_obj();

		// create new or associate existing store to the coupon
		if ( $this->posted_fields[ APP_TAX_STORE ] == 'add-new' ) {
			// check if has been marked as invalid during validation
			if ( $this->is_field_valid( 'new_store_name' ) && $this->is_field_valid( 'new_store_url' ) ) {
				// insert the new store
				$store_name = ucwords( strtolower( $this->posted_fields['new_store_name'] ) );
				wp_set_object_terms( $listing->ID, $store_name, APP_TAX_STORE );

				// grab the new store id so we can attach the new url field to it
				$term = get_term_by( 'name', $this->posted_fields['new_store_name'], APP_TAX_STORE );
				clpr_update_store_meta( $term->term_id, 'clpr_store_url', apply_filters( 'pre_user_url', $this->posted_fields['new_store_url'] ) );

				// check if new stores require moderation before going live
				if ( $clpr_options->stores_require_moderation ) {
					clpr_update_store_meta( $term->term_id, 'clpr_store_active', 'no' );
				}
			}

		} else if ( $this->is_field_valid( APP_TAX_STORE ) ) {
			wp_set_object_terms( $listing->ID, (int) $this->posted_fields[ APP_TAX_STORE ], APP_TAX_STORE, false );
		}

	}

	/**
	 * Sets listing internal data.
	 *
	 * @return void
	 */
	protected function set_internal_data() {

		$listing = $this->get_listing_obj();

		// set listing unique id
		if ( ! $unique_id = get_post_meta( $listing->ID, 'clpr_id', true ) ) {
			$unique_id = clpr_generate_id();
			update_post_meta( $listing->ID, 'clpr_id', $unique_id, true );
		}

		// set user IP
		update_post_meta( $listing->ID, 'clpr_sys_userIP', appthemes_get_ip() );

		// set featured
		if ( ! $featured = get_post_meta( $listing->ID, 'clpr_featured', true ) ) {
			update_post_meta( $listing->ID, 'clpr_featured', '', true );
		}

		// set votes percent
		if ( ! $votes_percent = get_post_meta( $listing->ID, 'clpr_votes_percent', true ) ) {
			update_post_meta( $listing->ID, 'clpr_votes_percent', '100', true );
		}

		// set meta with zero as default (stats and votes)
		$meta_names = array(
			'clpr_daily_count',
			'clpr_total_count',
			'clpr_coupon_aff_clicks',
			'clpr_votes_up',
			'clpr_votes_down',
		);
		foreach ( $meta_names as $meta_name ) {
			if ( ! $meta_value = get_post_meta( $listing->ID, $meta_name, true ) ) {
				update_post_meta( $listing->ID, $meta_name, '0', true );
			}
		}

	}

	/**
	 * Validates submitted fields.
	 *
	 * @param object $errors
	 *
	 * @return object
	 */
	public function validate_fields( $errors ) {

		$errors = parent::validate_fields( $errors );

		// validate store
		if ( empty( $this->posted_fields[ APP_TAX_STORE ] ) ) {
			$errors->add( 'missed-' . APP_TAX_STORE, sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Store', APP_TD ) ) );
		} else if ( $this->posted_fields[ APP_TAX_STORE ] == 'add-new' ) {
			if ( empty( $this->posted_fields['new_store_name'] ) ) {
				$errors->add( 'missed-new_store_name', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'New Store Name', APP_TD ) ) );
			}
			if ( empty( $this->posted_fields['new_store_url'] ) ) {
				$errors->add( 'missed-new_store_url', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'New Store URL', APP_TD ) ) );
			} else if ( ! wp_http_validate_url( $this->posted_fields['new_store_url'] ) ) {
				$errors->add( 'invalid-new_store_url', sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'New Store URL', APP_TD ) ) );
			}
		} else {
			$store = get_term_by( 'id', $this->posted_fields[ APP_TAX_STORE ], APP_TAX_STORE );
			if ( ! $store ) {
				$errors->add( 'invalid-' . APP_TAX_STORE, sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Store', APP_TD ) ) );
			}
		}

		// validate reCaptcha
		if ( current_theme_supports( 'app-recaptcha' ) ) {
			list( $options ) = get_theme_support( 'app-recaptcha' );

			require_once( $options['file'] );

			// check and make sure the reCaptcha values match
			$resp = recaptcha_check_answer( $options['private_key'], $_SERVER['REMOTE_ADDR'], $this->posted_fields['recaptcha_challenge_field'], $this->posted_fields['recaptcha_response_field'] );

			if ( ! $resp->is_valid ) {
				$errors->add( 'invalid-recaptcha', __( 'The reCaptcha anti-spam response was incorrect.', APP_TD ) );
			}
		}

		return $errors;
	}

	/**
	 * Returns fields names that we expect.
	 *
	 * @return array
	 */
	protected function expected_fields() {
		$fields = array(
			'new_store_name',
			'new_store_url',
			APP_TAX_STORE,
			'recaptcha_challenge_field',
			'recaptcha_response_field',
			'clpr_expire_date',
		);
		$fields = array_merge( $fields, parent::expected_fields() );

		return $fields;
	}

}


/**
 * Form Step: Free Listing Submission Summary
 * @since 1.6
 */
class CLPR_Coupon_Form_Submit_Free extends CLPR_Coupon_Checkout_Step {

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {
		global $clpr_options;

		if ( $clpr_options->charge_coupons ) {
			return;
		}

		$register_to = array(
			'create-listing',
			'renew-listing',
		);

		parent::__construct( 'listing-submit-free', array(
			'register_to' => $register_to
		) );

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		the_post();

		$listing = $this->get_listing_obj();

		appthemes_load_template( 'form-listing-submit-free.php', array(
			'action' => $checkout->get_checkout_type(),
			'listing' => $listing,
		) );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {

		// do nothing?

	}

}


/**
 * Order Checkout Steps Helper Class
 * @since 1.6
 */
class CLPR_Order_Checkout_Step extends APP_Checkout_Step {

	/**
	 * Returns an array of checkouts that support payments.
	 *
	 * @return array
	 */
	public function get_checkouts() {
		global $clpr_options;

		$register_to = array();

		if ( $clpr_options->charge_coupons ) {
			$register_to = array(
				'create-listing',
				'renew-listing',
			);
		}

		return apply_filters( 'clpr_order_checkout_step_register_to', $register_to );
	}

	/**
	 * Checks if user can access checkout step, if not, cancel or finish current step.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return bool
	 */
	public function can_access_step( $order, $checkout ) {

		// if order not created move step backward
		if ( ! $order->get_id() ) {
			$checkout->cancel_step();
			return false;
		}

		return true;
	}

}


/**
 * Form Step: Select Payment Gateway
 */
class CLPR_Gateway_Select extends CLPR_Order_Checkout_Step {

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {

		if ( $register_to = $this->get_checkouts() ) {
			parent::__construct( 'gateway-select', array(
				'register_to' => $register_to
			) );
		}

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		appthemes_add_template_var( array( 'app_order' => $order ) );
		appthemes_load_template( 'order-select.php' );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {

		if ( ! $this->can_access_step( $order, $checkout ) ) {
			return;
		}

		if ( $order->get_total() == 0 ) {
			$order->complete();
			$this->finish_step();
		}

		if ( ! empty( $_POST['payment_gateway'] ) ) {
			$is_valid = $order->set_gateway( $_POST['payment_gateway'] );
			if ( ! $is_valid ) {
				return;
			}

			$this->finish_step();
		}

	}

}


/**
 * Form Step: Process Payment Gateway
 * @since 1.6
 */
class CLPR_Gateway_Process extends CLPR_Order_Checkout_Step {

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {

		if ( $register_to = $this->get_checkouts() ) {
			parent::__construct( 'gateway-process', array(
				'register_to' => $register_to
			) );
		}

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		appthemes_add_template_var( array( 'app_order' => $order ) );
		appthemes_load_template( 'order-checkout.php' );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {

		if ( ! $this->can_access_step( $order, $checkout ) ) {
			return;
		}

		// update order complete and cancel urls
		update_post_meta( $order->get_id(), 'complete_url', appthemes_get_step_url( 'order-summary' ) );
		update_post_meta( $order->get_id(), 'cancel_url', appthemes_get_step_url( 'gateway-select' ) );

		wp_redirect( $order->get_return_url() );
		exit;
	}

}


/**
 * Form Step: Order Summary
 * @since 1.6
 */
class CLPR_Order_Summary extends CLPR_Order_Checkout_Step {

	/**
	 * Setups step.
	 *
	 * @return void
	 */
	public function __construct() {

		if ( $register_to = $this->get_checkouts() ) {
			parent::__construct( 'order-summary', array(
				'register_to' => $register_to
			) );
		}

	}

	/**
	 * Displays form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function display( $order, $checkout ) {

		appthemes_add_template_var( array( 'app_order' => $order ) );
		appthemes_load_template( 'order-summary.php' );

	}

	/**
	 * Processing form.
	 *
	 * @param object $order
	 * @param object $checkout
	 *
	 * @return void
	 */
	public function process( $order, $checkout ) {

		if ( ! $this->can_access_step( $order, $checkout ) ) {
			return;
		}

	}

}

