<?php
/**
 * Views.
 *
 * @package Clipper\Views
 * @author  AppThemes
 * @since   Clipper 1.3.1
 */


/**
 * Blog Archive page view.
 */
class CLPR_Blog_Archive extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'index.php', __( 'Blog', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'index.php' );
	}

}


/**
 * Coupons Home page view.
 */
class CLPR_Coupons_Home extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'front-page.php', __( 'Coupon Listings', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'front-page.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {
		global $wp_query;

		// if page on front, set back paged parameter
		if ( self::get_id() == get_option( 'page_on_front' ) ) {
			$paged = get_query_var( 'page' );
			$wp_query->set( 'paged', $paged );
		}

	}

}


/**
 * Coupons Categories page view.
 */
class CLPR_Coupon_Categories extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'tpl-coupon-cats.php', __( 'Categories', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-coupon-cats.php' );
	}

}


/**
 * Coupons Stores page view.
 */
class CLPR_Coupon_Stores extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'tpl-stores.php', __( 'Stores', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-stores.php' );
	}

}


/**
 * Submit Coupon Listing page view.
 */
class CLPR_Coupon_Submit extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'create-listing.php', __( 'Share Coupon', APP_TD ) );

		// adds custom css class for submit coupon menu item
		add_filter( 'wp_nav_menu_objects', array( $this, 'menu_item_css' ), 10, 2 );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'create-listing.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {
		global $clpr_options;

		if ( $clpr_options->reg_required || $clpr_options->charge_coupons ) {
			appthemes_require_login( array(
				'login_text' => __( 'You must first login to add a coupon.', APP_TD ),
				'login_register_text' => __( 'You must first login or <a href="%s">register</a> to add a coupon.', APP_TD )
			) );

			if ( ! current_user_can( 'edit_posts' ) ) {
				appthemes_add_notice( 'denied-listing-edit', __( 'You are not allowed to add a coupon.', APP_TD ), 'error' );
				wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
				exit();
			}
		}

		// redirect to renew page
		if ( isset( $_GET['listing_renew'] ) ) {
			wp_redirect( clpr_get_renew_coupon_url( $_GET['listing_renew'], 'redirect' ) );
			exit();
		}

		// load up the validate
		add_action( 'wp_enqueue_scripts', 'clpr_load_form_scripts' );
	}

	/**
	 * Determines which template to include.
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string
	 */
	function template_include( $template ) {

		appthemes_setup_checkout( 'create-listing', get_permalink( self::get_id() ) );
		$step_found = appthemes_process_checkout();
		if ( ! $step_found ) {
			return locate_template( '404.php' );
		}

		return $template;
	}

	/**
	 * Adds additional css class for this page if in menu.
	 *
	 * @param array $items
	 * @param array $args
	 *
	 * @return array
	 */
	public function menu_item_css( $items, $args ) {
		foreach ( $items as $key => $item ) {
			if ( $item->object_id == self::get_id() ) {
				$item->classes[] = 'menu-arrow';
			}
		}

		return $items;
	}

}


/**
 * Renew Coupon Listing page view.
 */
class CLPR_Coupon_Renew extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'renew-listing.php', __( 'Renew Coupon', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'renew-listing.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {

		appthemes_require_login( array(
			'login_text' => __( 'You must first login to renew coupon.', APP_TD ),
			'login_register_text' => __( 'You must first login or <a href="%s">register</a> to renew coupon.', APP_TD )
		) );

		if ( ! current_user_can( 'edit_posts' ) ) {
			appthemes_add_notice( 'denied-listing-edit', __( 'You are not allowed to renew coupons.', APP_TD ), 'error' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();
		}

		// redirect to dashboard if can't renew
		self::can_renew_coupon();

		// load up the validate
		add_action( 'wp_enqueue_scripts', 'clpr_load_form_scripts' );
	}

	/**
	 * Determines which template to include.
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string
	 */
	function template_include( $template ) {

		$url = esc_url( add_query_arg( 'listing_renew', $_GET['listing_renew'], get_permalink( self::get_id() ) ) );

		appthemes_setup_checkout( 'renew-listing', $url );
		$step_found = appthemes_process_checkout();
		if ( ! $step_found ) {
			return locate_template( '404.php' );
		}

		return $template;
	}

	/**
	 * Checks and redirects user to dashboard if can't renew coupon.
	 *
	 * @return void
	 */
	static function can_renew_coupon() {
		global $current_user;

		$redirect_url = clpr_get_dashboard_url( 'redirect' );

		if ( ! isset( $_GET['listing_renew'] ) || $_GET['listing_renew'] != appthemes_numbers_only( $_GET['listing_renew'] ) ) {
			appthemes_add_notice( 'renew-invalid-id', __( 'You can not relist this coupon. Invalid ID of coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		$post = get_post( $_GET['listing_renew'] );
		if ( ! $post ) {
			appthemes_add_notice( 'renew-invalid-id', __( 'You can not relist this coupon. Invalid ID of coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( $post->post_type != APP_POST_TYPE ) {
			appthemes_add_notice( 'renew-invalid-type', __( 'You can not renew this coupon. This is not a coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( $post->post_author != $current_user->ID ) {
			appthemes_add_notice( 'renew-invalid-author', __( "You can not renew this coupon. It's not your coupon.", APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		// validate expire date only on non order steps
		$step = _appthemes_get_step_from_query();
		if ( empty( $step ) || ! in_array( $step, array( 'gateway-select', 'gateway-process', 'order-summary' ) ) ) {
			$expire_time = clpr_get_expire_date( $post->ID, 'time' ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day
			if ( $expire_time > current_time( 'timestamp' ) && $post->post_status != 'pending' ) {
				appthemes_add_notice( 'renew-not-expired', __( 'You can not relist this coupon. Coupon is not expired.', APP_TD ), 'error' );
				wp_redirect( $redirect_url );
				exit();
			}
		}

	}

}


/**
 * Edit Coupon Listing page view.
 */
class CLPR_Edit_Item extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'edit-listing.php', __( 'Edit Coupon', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'edit-listing.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {
		appthemes_require_login( array(
			'login_text' => __( 'You must first login to edit coupon.', APP_TD ),
			'login_register_text' => __( 'You must first login or <a href="%s">register</a> to edit coupon.', APP_TD )
		) );

		if ( ! current_user_can( 'edit_posts' ) ) {
			appthemes_add_notice( 'denied-listing-edit', __( 'You are not allowed to edit coupons.', APP_TD ), 'error' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();
		}

		// redirect to dashboard if can't edit coupon
		self::can_edit_coupon();

		// redirect to renew page
		if ( isset( $_GET['listing_renew'] ) ) {
			wp_redirect( clpr_get_renew_coupon_url( $_GET['listing_renew'], 'redirect' ) );
			exit();
		}

		// add js files to wp_head. tiny_mce and validate
		add_action( 'wp_enqueue_scripts', 'clpr_load_form_scripts' );
	}

	/**
	 * Determines which template to include.
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string
	 */
	function template_include( $template ) {

		$url = esc_url( add_query_arg( 'listing_edit', $_GET['listing_edit'], get_permalink( self::get_id() ) ) );

		appthemes_setup_checkout( 'edit-listing', $url );
		$step_found = appthemes_process_checkout();
		if ( ! $step_found ) {
			return locate_template( '404.php' );
		}

		return $template;
	}

	/**
	 * Checks and redirects user to dashboard if can't edit coupon.
	 *
	 * @return void
	 */
	static function can_edit_coupon() {
		global $current_user, $clpr_options;

		$redirect_url = clpr_get_dashboard_url( 'redirect' );

		if ( ! isset( $_GET['listing_edit'] ) || $_GET['listing_edit'] != appthemes_numbers_only( $_GET['listing_edit'] ) ) {
			appthemes_add_notice( 'edit-invalid-id', __( 'You can not edit this coupon. Invalid ID of a coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( ! $clpr_options->coupon_edit ) {
			appthemes_add_notice( 'edit-disabled', __( 'You can not edit this coupon. Editing is currently disabled.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		$post = get_post( $_GET['listing_edit'] );
		if ( ! $post ) {
			appthemes_add_notice( 'edit-invalid-id', __( 'You can not edit this coupon. Invalid ID of a coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( $post->post_status == 'pending' ) {
			appthemes_add_notice( 'edit-pending', __( 'You can not edit this coupon. Coupon is not yet approved.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( $post->post_type != APP_POST_TYPE ) {
			appthemes_add_notice( 'edit-invalid-type', __( 'You can not edit this coupon. This is not a coupon.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		if ( $post->post_author != $current_user->ID ) {
			appthemes_add_notice( 'edit-invalid-author', __( "You can not edit this coupon. It's not your coupon.", APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

		$expire_time = clpr_get_expire_date( $post->ID, 'time' ) + ( 24 * 3600 ); // + 24h, coupons expire in the end of day
		if ( current_time( 'timestamp' ) > $expire_time && $post->post_status == 'draft' ) {
			appthemes_add_notice( 'edit-expired', __( 'You can not edit this coupon. Coupon is expired.', APP_TD ), 'error' );
			wp_redirect( $redirect_url );
			exit();
		}

	}

}


/**
 * User Dashboard page view.
 */
class CLPR_User_Dashboard extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'tpl-dashboard.php', __( 'Dashboard', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-dashboard.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {
		global $wpdb, $current_user;
		appthemes_auth_redirect_login(); // if not logged in, redirect to login page
		nocache_headers();

		$allowed_actions = array( 'pause', 'restart', 'delete' );

		if ( ! isset( $_GET['action'] ) || ! in_array( $_GET['action'], $allowed_actions ) ) {
			return;
		}

		if ( ! isset( $_GET['aid'] ) || ! is_numeric( $_GET['aid'] ) ) {
			return;
		}

		$d = trim( $_GET['action'] );
		$aid = appthemes_numbers_only( $_GET['aid'] );

		// make sure author matches coupon, and coupon exist
		$sql = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID = %d AND post_author = %d AND post_type = %s", $aid, $current_user->ID, APP_POST_TYPE );
		$post = $wpdb->get_row( $sql );
		if ( $post == null ) {
			return;
		}

		if ( $d == 'pause' ) {
			wp_update_post( array( 'ID' => $aid, 'post_status' => 'draft' ) );
			appthemes_add_notice( 'paused', __( 'Your coupon has been paused.', APP_TD ), 'success' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();

		} elseif ( $d == 'restart' ) {
			wp_update_post( array( 'ID' => $aid, 'post_status' => 'publish' ) );
			appthemes_add_notice( 'restarted', __( 'Your coupon has been restarted.', APP_TD ), 'success' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();

		} elseif ( $d == 'delete' ) {
			clpr_delete_coupon( $aid );
			appthemes_add_notice( 'deleted', __( 'Your coupon has been deleted.', APP_TD ), 'success' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();

		}

	}

}


/**
 * User Orders page view.
 */
class CLPR_User_Orders extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'tpl-user-orders.php', __( 'My Orders', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-user-orders.php' );
	}

	/**
	 * Fires before determining which template to load.
	 *
	 * @return void
	 */
	function template_redirect() {
		// if not logged in, redirect to login page
		appthemes_auth_redirect_login();

		// if payments disabled, redirect to dashboard
		if ( ! clpr_payments_is_enabled() ) {
			appthemes_add_notice( 'payments-disabled', __( 'Payments are currently disabled. You cannot purchase anything.', APP_TD ), 'error' );
			wp_redirect( clpr_get_dashboard_url( 'redirect' ) );
			exit();
		}
	}

}


/**
 * Edit Profile page view.
 */
class CLPR_User_Profile extends APP_User_Profile {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		APP_View_Page::__construct( 'tpl-profile.php', __( 'Edit Profile', APP_TD ) );
		add_action( 'init', array( $this, 'update' ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-profile.php' );
	}

}


/**
 * Single Coupon Listing view.
 */
class CLPR_Coupon_Single extends APP_View {

	/**
	 * Checks if class should handle current view.
	 *
	 * @return bool
	 */
	function condition() {
		return is_singular( APP_POST_TYPE );
	}

	/**
	 * Displays notices.
	 *
	 * @return void
	 */
	function notices() {
		$status = get_post_status( get_queried_object() );

		if ( $status == 'pending' ) {
			appthemes_display_notice( 'success', __( 'This coupon listing is currently pending and must be approved by an administrator.', APP_TD ) );
		}
	}

}

