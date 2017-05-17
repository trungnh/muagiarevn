<?php
/**
 * Deprecated functions.
 *
 * @package Clipper\Deprecated
 * @author  AppThemes
 * @since   Clipper 1.4
 */


/**
 * Constants.
 *
 * @deprecated 1.5
 */
define( 'THE_POSITION', 3 );
define( 'FAVICON', get_template_directory_uri() . '/images/site_icon.png' );


/**
 * Feed url related to currently browsed page.
 *
 * @deprecated 1.4
 * @deprecated Use appthemes_get_feed_url()
 * @see appthemes_get_feed_url()
 *
 * @return string
 */
if ( ! function_exists( 'clpr_get_feed_url' ) ) {
	function clpr_get_feed_url() {
		_deprecated_function( __FUNCTION__, '1.4', 'appthemes_get_feed_url()' );

		return appthemes_get_feed_url();
	}
}


/**
 * Return store image url with specified size.
 *
 * @deprecated 1.4
 * @deprecated Use clpr_get_store_image_url()
 * @see clpr_get_store_image_url()
 *
 * @param int $post_id
 * @param string $tax_name
 * @param string $tax_arg
 * @param int $width
 * @param string $store_url
 *
 * @return string
 */
if ( ! function_exists( 'clpr_store_image' ) ) {
	function clpr_store_image( $post_id, $tax_name, $tax_arg, $width, $store_url ) {
		_deprecated_function( __FUNCTION__, '1.4', 'clpr_get_store_image_url()' );

		if ( ! $post_id && is_tax( APP_TAX_STORE ) ) {
			$term = get_queried_object();
			return clpr_get_store_image_url( $term->term_id, 'term_id', $width );
		} else {
			return clpr_get_store_image_url( $post_id, 'post_id', $width );
		}

	}
}


/**
 * Return coupon outgoing url.
 *
 * @deprecated 1.4
 * @deprecated Use clpr_get_coupon_out_url()
 * @see clpr_get_coupon_out_url()
 *
 * @param object $post
 *
 * @return string
 */
if ( ! function_exists( 'get_clpr_coupon_url' ) ) {
	function get_clpr_coupon_url( $post ) {
		_deprecated_function( __FUNCTION__, '1.4', 'clpr_get_coupon_out_url()' );

		return clpr_get_coupon_out_url( $post );
	}
}


/**
 * Was creating admin dashboard.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Dashboard
 *
 * @return void
 */
function app_dashboard() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was creating admin general settings page.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Settings_General
 *
 * @return void
 */
function app_settings() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was creating admin emails settings page.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_Settings_Emails
 *
 * @return void
 */
function app_emails() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was updating admin settings.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function appthemes_update_options( $options ) {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating admin settings fields.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function appthemes_admin_fields( $options ) {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating admin system info page.
 *
 * @deprecated 1.5
 * @see CLPR_Theme_System_Info
 *
 * @return void
 */
function app_system_info() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Returns default currency code.
 *
 * @deprecated 1.5
 * @see $clpr_options
 *
 * @return string
 */
function clpr_get_default_currency_code() {
	global $clpr_options;

	_deprecated_function( __FUNCTION__, '1.5' );

	return $clpr_options->currency_code;
}


/**
 * Was generating default header menu.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function clpr_primary_nav_menu() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Was generating default footer menu.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function clpr_footer_nav_menu() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * Gets the transient array holding all the post ids the visitor has voted for.
 *
 * @deprecated 1.5
 * @deprecated Use appthemes_get_visitor_transient()
 * @see appthemes_get_visitor_transient()
 *
 * @return array|bool
 */
function clpr_vote_transient() {
	_deprecated_function( __FUNCTION__, '1.5', 'appthemes_get_visitor_transient()' );

	return appthemes_get_visitor_transient( 'visitor_votes' );
}


/**
 * RSS blog feed for the dashboard page.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function appthemes_dashboard_appthemes() {
	_deprecated_function( __FUNCTION__, '1.5' );
	$rss_feed = 'http://feeds2.feedburner.com/appthemes';
	wp_widget_rss_output( $rss_feed, array( 'items' => 10, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
}


/**
 * RSS twitter feed for the dashboard page.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function appthemes_dashboard_twitter() {
	_deprecated_function( __FUNCTION__, '1.5' );
}


/**
 * RSS forum feed for the dashboard page.
 *
 * @deprecated 1.5
 *
 * @return void
 */
function appthemes_dashboard_forum() {
	_deprecated_function( __FUNCTION__, '1.5' );
	$rss_feed = 'http://forums.appthemes.com/external.php?type=RSS2';
	wp_widget_rss_output( $rss_feed, array( 'items' => 5, 'show_author' => 0, 'show_date' => 1, 'show_summary' => 1 ) );
}


/**
 * tinyMCE text editor.
 *
 * @deprecated 1.5.1
 * @deprecated Use wp_editor()
 * @see wp_editor()
 *
 * @param int $width (optional)
 * @param int $height (optional)
 *
 * @return void
 */
function clpr_tinymce( $width = 420, $height = 300 ) {
	_deprecated_function( __FUNCTION__, '1.5.1', 'wp_editor()' );

	return;
}


/**
 * Was displaying coupon submission form.
 *
 * @deprecated 1.6
 *
 * @return void
 */
function clpr_do_coupon_form( $post ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was displaying coupon submission form.
 *
 * @deprecated 1.6
 *
 * @return void
 */
function clipper_coupon_form( $post = false ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was displaying coupon submission form.
 *
 * @deprecated 1.6
 *
 * @return void
 */
function clpr_show_coupon_form( $post = false ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was updating data from edit coupon form.
 *
 * @deprecated 1.6
 *
 * @return void
 */
function clpr_update_listing() {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was called in theme-login.php to hook into custom login page head.
 *
 * @since 1.3.1
 * @deprecated 1.6
 *
 * @return void
 */
function clpr_do_login_head() {
	_deprecated_function( __FUNCTION__, '1.6' );
	do_action( 'login_head' );
}


/**
 * Was called in theme-login.php to hook into custom login page footer.
 *
 * @since 1.3.1
 * @deprecated 1.6
 *
 * @return void
 */
function clpr_do_login_footer() {
	_deprecated_function( __FUNCTION__, '1.6' );
	do_action( 'login_footer' );
}


/**
 * Checks permissions to access the WordPress backend.
 *
 * @deprecated 1.6
 * @deprecated Use clpr_security_check()
 * @see clpr_security_check()
 *
 * @return void
 */
function app_security_check() {
	_deprecated_function( __FUNCTION__, '1.6', 'clpr_security_check()' );

	clpr_security_check();
}


/**
 * Was displaying admin coupon listing custom fields metabox.
 *
 * @deprecated 1.6
 * @see CLPR_Listing_Custom_Forms_Metabox
 *
 * @return void
 */
function clpr_custom_fields_meta_box() {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was saving admin coupon listing custom fields values.
 *
 * @deprecated 1.6
 * @see CLPR_Listing_Custom_Forms_Metabox
 *
 * @param int $post_id
 *
 * @return void
 */
function clpr_save_meta_box( $post_id ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Returns a total count of all posts based on status and post type.
 *
 * @deprecated 1.6
 * @deprecated Use appthemes_count_posts()
 * @see appthemes_count_posts()
 *
 * @param string $post_type
 * @param string|array $status_type (optional)
 *
 * @return int
 */
function clpr_count_posts( $post_type, $status_type = 'publish' ) {
	_deprecated_function( __FUNCTION__, '1.6', 'appthemes_count_posts()' );

	return appthemes_count_posts( $post_type, $status_type );
}


/**
 * Was displaying list of overall popular coupons/posts.
 *
 * @deprecated 1.6
 * @see CLPR_Widget_Top_Coupons_Overall
 *
 * @param string $post_type
 * @param int $limit
 *
 * @return void
 */
function clpr_todays_overall_count_widget( $post_type, $limit ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was displaying list of today's popular coupons/posts.
 *
 * @deprecated 1.6
 * @see CLPR_Widget_Top_Coupons_Today
 *
 * @param string $post_type
 * @param int $limit
 *
 * @return void
 */
function clpr_todays_count_widget( $post_type, $limit ) {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was displaying sub categories box in sidebar on category pages.
 *
 * @deprecated 1.6
 * @see CLPR_Widget_Coupon_Sub_Categories
 *
 * @return void
 */
function clpr_sidebar_subcategories_box() {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was displaying the sub stores box in sidebar on store pages.
 *
 * @deprecated 1.6
 * @see CLPR_Widget_Sub_Stores
 *
 * @return void
 */
function clpr_sidebar_substores_box() {
	_deprecated_function( __FUNCTION__, '1.6' );
}


/**
 * Was returning the coupon upload directory path.
 *
 * @deprecated 1.6
 * @deprecated Use wp_upload_dir()
 * @see wp_upload_dir()
 *
 * @param array $pathdata
 *
 * @return array
 */
function clpr_upload_path( $pathdata ) {
	_deprecated_function( __FUNCTION__, '1.6', 'wp_upload_dir()' );

	return $pathdata;
}


/**
 * Sets the thumbnail pic on the WP admin post.
 *
 * @deprecated 1.6
 *
 * @param int $post_id
 * @param int $thumbnail_id
 *
 * @return void
 */
function clpr_set_ad_thumbnail( $post_id, $thumbnail_id ) {
	_deprecated_function( __FUNCTION__, '1.6' );

	$thumbnail_html = wp_get_attachment_image( $thumbnail_id, 'thumbnail' );
	if ( ! empty( $thumbnail_html ) ) {
		update_post_meta( $post_id, '_thumbnail_id', $thumbnail_id );
	}
}


/**
 * Updates post status.
 *
 * @deprecated 1.6.4
 * @deprecated Use wp_update_post()
 * @see wp_update_post()
 *
 * @param int $post_id
 * @param string $new_status
 *
 * @return void
 */
function clpr_update_post_status( $post_id, $new_status ) {
	_deprecated_function( __FUNCTION__, '1.6.4', 'wp_update_post()' );

	wp_update_post( array(
		'ID' => $post_id,
		'post_status' => $new_status,
	) );
}


/**
 * Was adding CSS3 support for old IE web browsers.
 *
 * @deprecated 1.6.4
 *
 * @return void
 */
function clpr_pie_styles() {
	_deprecated_function( __FUNCTION__, '1.6.4' );
}


