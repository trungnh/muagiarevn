<?php
/**
 * Theme functions file
 *
 * DO NOT MODIFY THIS FILE. Make a child theme instead: http://codex.wordpress.org/Child_Themes
 *
 * @package Clipper
 * @author  AppThemes
 * @since   Clipper 1.0
 */

// Constants
define( 'CLPR_VERSION', '1.6.4' );
define( 'CLPR_DB_VERSION', '1351' );

define( 'APP_POST_TYPE', 'coupon' );
define( 'APP_TAX_CAT', 'coupon_category' );
define( 'APP_TAX_TAG', 'coupon_tag' );
define( 'APP_TAX_TYPE', 'coupon_type' );
define( 'APP_TAX_STORE', 'stores' );
define( 'APP_TAX_IMAGE', 'coupon_image' );

define( 'CLPR_COUPON_LISTING_TYPE', 'coupon-listing' );

define( 'APP_TD', 'clipper' );

global $clpr_options;

// Legacy variables - some plugins rely on them
$app_theme = 'Clipper';
$app_abbr = 'clpr';
$app_version = '1.6.4';
$app_db_version = 1351;
$app_edition = '';

// Framework
require_once( dirname( __FILE__ ) . '/framework/load.php' );
require_once( dirname( __FILE__ ) . '/theme-framework/load.php' );
require_once( APP_FRAMEWORK_DIR . '/admin/class-meta-box.php' );

APP_Mail_From::init();

// define the custom fields used for custom search
$app_custom_fields = array( 'clpr_coupon_code', 'clpr_expire_date', 'clpr_featured', 'clpr_id', 'clpr_print_url' );

// define the db tables we use
$app_db_tables = array( 'clpr_pop_daily', 'clpr_pop_total', 'clpr_report', 'clpr_report_comments', 'clpr_search_recent', 'clpr_search_total', 'clpr_storesmeta', 'clpr_votes', 'clpr_votes_total' );
foreach ( $app_db_tables as $app_db_table ) {
	scb_register_table( $app_db_table );
}
scb_register_table( 'app_pop_daily', 'clpr_pop_daily' );
scb_register_table( 'app_pop_total', 'clpr_pop_total' );
scb_register_table( 'storesmeta', 'clpr_storesmeta' );


$load_files = array(
	'checkout/load.php',
	'payments/load.php',
	'reports/load.php',
	'widgets/load.php',
	'stats/load.php',
	'open-graph/open-graph.php',
	'search-index/load.php',
	'options.php',
	'appthemes-functions.php',
	'actions.php',
	'categories.php',
	'core.php',
	'comments.php',
	'custom-header.php',
	'dashboard.php',
	'deprecated.php',
	'enqueue.php',
	'emails.php',
	'functions.php',
	'hooks.php',
	'links.php',
	'payments.php',
	'printable-coupon.php',
	'profile.php',
	'search.php',
	'security.php',
	'stats.php',
	'stores.php',
	'views.php',
	'views-checkout.php',
	'voting.php',
	'widgets.php',
);
appthemes_load_files( dirname( __FILE__ ) . '/includes/', $load_files );

$load_classes = array(
	'CLPR_Blog_Archive',
	'CLPR_Coupons_Home',
	'CLPR_Coupon_Categories',
	'CLPR_Coupon_Stores',
	'CLPR_Coupon_Submit',
	'CLPR_Coupon_Renew',
	'CLPR_Coupon_Single',
	'CLPR_Edit_Item',
	'CLPR_Open_Graph',
	'CLPR_User_Dashboard',
	'CLPR_User_Orders',
	'CLPR_User_Profile',
	// Checkout
	'CLPR_Coupon_Form_Edit',
	'CLPR_Coupon_Form_Details',
	'CLPR_Coupon_Form_Submit_Free',
	'CLPR_Gateway_Select',
	'CLPR_Gateway_Process',
	'CLPR_Order_Summary',
	// Widgets
	'CLPR_Widget_Facebook',
	'CLPR_Widget_Subscribe',
	'CLPR_Widget_Share_Coupon',
	'CLPR_Widget_Popular_Coupons',
	'CLPR_Widget_Expiring_Coupons',
	'CLPR_Widget_Related_Coupons',
	'CLPR_Widget_Top_Coupons_Today',
	'CLPR_Widget_Top_Coupons_Overall',
	'CLPR_Widget_Sub_Stores',
	'CLPR_Widget_Popular_Stores',
	'CLPR_Widget_Featured_Stores',
	'CLPR_Widget_Coupon_Categories',
	'CLPR_Widget_Coupon_Sub_Categories',
	'CLPR_Widget_Coupons_Tag_Cloud',
	'CLPR_Widget_Popular_Searches',
	'CLPR_Widget_Tabbed_Blog',
	//'CLPR_Widget_Contact_Footer',
);
appthemes_add_instance( $load_classes );


// Admin only
if ( is_admin() ) {
	require_once( APP_FRAMEWORK_DIR . '/admin/importer.php' );

	$load_files = array(
		'class-term-description.php',
		'admin.php',
		'dashboard.php',
		'enqueue.php',
		'install.php',
		'importer.php',
		'listing-single.php',
		'listing-list.php',
		'post-status.php',
		'settings.php',
		'stores-single.php',
		'stores-list.php',
		'system-info.php',
		'updates.php',
		'users.php',
		'addons-mp/load.php',
	);
	appthemes_load_files( dirname( __FILE__ ) . '/includes/admin/', $load_files );

	$load_classes = array(
		'CLPR_Theme_Dashboard',
		'CLPR_Theme_Settings_General' => $clpr_options,
		'CLPR_Theme_Settings_Emails' => $clpr_options,
		'CLPR_Theme_System_Info',
		// Metaboxes
		'CLPR_Listing_Info_Metabox',
		'CLPR_Listing_Custom_Forms_Metabox',
		'CLPR_Listing_Author_Metabox',
		'CLPR_Listing_Publish_Moderation',
		// Stores
		'CLPR_Store_Term_Description',
	);
	appthemes_add_instance( $load_classes );
}


// Frontend only
if ( ! is_admin() ) {
	clpr_load_all_page_templates();
}

// Constants
define( 'CLPR_COUPON_REDIRECT_BASE_URL', trailingslashit( $clpr_options->coupon_redirect_base_url ) );
define( 'CLPR_STORE_REDIRECT_BASE_URL', trailingslashit( $clpr_options->store_redirect_base_url ) );

define( 'CLPR_DASHBOARD_URL', get_permalink( CLPR_User_Dashboard::get_id() ) );
define( 'CLPR_ORDERS_URL', get_permalink( CLPR_User_Orders::get_id() ) );
define( 'CLPR_PROFILE_URL', get_permalink( CLPR_User_Profile::get_id() ) );
define( 'CLPR_EDIT_URL', get_permalink( CLPR_Edit_Item::get_id() ) );
define( 'CLPR_SUBMIT_URL', get_permalink( CLPR_Coupon_Submit::get_id() ) );


// Theme supports
add_theme_support( 'app-versions', array(
	'update_page' => 'admin.php?page=app-settings&firstrun=1',
	'current_version' => CLPR_VERSION,
	'option_key' => 'clpr_version',
) );

add_theme_support( 'app-wrapping' );

add_theme_support( 'app-search-index', array(
	'admin_page' => true,
	'admin_top_level_page' => 'app-dashboard',
	'admin_sub_level_page' => 'app-system-info',
) );

add_theme_support( 'app-login', array(
	'login' => 'tpl-login.php',
	'register' => 'tpl-registration.php',
	'recover' => 'tpl-password-recovery.php',
	'reset' => 'tpl-password-reset.php',
	'redirect' => $clpr_options->disable_wp_login,
	'settings_page' => 'admin.php?page=app-settings&tab=advanced',
) );

add_theme_support( 'app-feed', array(
	'post_type' => APP_POST_TYPE,
	'blog_template' => 'index.php',
	'alternate_feed_url' => $clpr_options->feedburner_url,
) );

add_theme_support( 'app-payments', array(
	'items' => array(
		array(
			'type' => CLPR_COUPON_LISTING_TYPE,
			'title' => __( 'Coupon Listing', APP_TD ),
			'meta' => array(
				'price' => $clpr_options->coupon_price,
			)
		),
	),
	'items_post_types' => array( APP_POST_TYPE ),
	'options' => $clpr_options,
) );

add_theme_support( 'app-price-format', array(
	'currency_default' => $clpr_options->currency_code,
	'currency_identifier' => $clpr_options->currency_identifier,
	'currency_position' => $clpr_options->currency_position,
	'thousands_separator' => $clpr_options->thousands_separator,
	'decimal_separator' => $clpr_options->decimal_separator,
	'hide_decimals' => false,
) );

add_theme_support( 'app-term-counts', array(
	'post_type' => array( APP_POST_TYPE ),
	'post_status' => array( 'publish', 'unreliable' ),
	'taxonomy' => array( APP_TAX_CAT, APP_TAX_TAG, APP_TAX_TYPE, APP_TAX_STORE ),
) );

add_theme_support( 'app-comment-counts' );

add_theme_support( 'app-stats', array(
	'cache' => 'today',
	'table_daily' => 'clpr_pop_daily',
	'table_total' => 'clpr_pop_total',
	'meta_daily' => 'clpr_daily_count',
	'meta_total' => 'clpr_total_count',
) );

add_theme_support( 'app-reports', array(
	'post_type' => array( APP_POST_TYPE ),
	'options' => $clpr_options,
	'admin_top_level_page' => 'app-dashboard',
	'admin_sub_level_page' => 'app-settings',
) );

add_theme_support( 'post-thumbnails' );

add_theme_support( 'automatic-feed-links' );

add_theme_support( 'app-addons-mp', array(
	'product' => array( 'clipper' ),
) );

add_theme_support( 'app-require-updater', true );

// AJAX
add_action( 'wp_ajax_nopriv_ajax-thumbsup', 'clpr_vote_update' );
add_action( 'wp_ajax_ajax-thumbsup', 'clpr_vote_update' );

add_action( 'wp_ajax_nopriv_comment-form', 'clpr_comment_form' );
add_action( 'wp_ajax_comment-form', 'clpr_comment_form' );

add_action( 'wp_ajax_nopriv_post-comment', 'clpr_post_comment_ajax' );
add_action( 'wp_ajax_post-comment', 'clpr_post_comment_ajax' );

add_action( 'wp_ajax_nopriv_email-form', 'clpr_email_form' );
add_action( 'wp_ajax_email-form', 'clpr_email_form' );

add_action( 'wp_ajax_nopriv_send-email', 'clpr_send_email_ajax' );
add_action( 'wp_ajax_send-email', 'clpr_send_email_ajax' );

add_action( 'wp_ajax_nopriv_coupon-code-popup', 'clpr_coupon_code_popup' );
add_action( 'wp_ajax_coupon-code-popup', 'clpr_coupon_code_popup' );

add_action( 'wp_ajax_ajax-resetvotes', 'clpr_reset_coupon_votes_ajax' );


// Image sizes
set_post_thumbnail_size( 110 ); // blog post thumbnails
add_image_size( 'thumb-small', 30 ); // used in the sidebar widget
add_image_size( 'thumb-med', 75 ); // used on the admin coupon list view
add_image_size( 'thumb-store', 150 ); // used on the store page
add_image_size( 'thumb-featured', 160 ); // used in featured coupons slider
add_image_size( 'thumb-large', 180 );
add_image_size( 'thumb-large-preview', 250 ); // used on the admin edit store page


// Set the content width based on the theme's design and stylesheet.
// Used to set the width of images and content. Should be equal to the width the theme
// is designed for, generally via the style.css stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}


appthemes_init();
