<?php
/**
 * Child Theme Views.
 *
 * @package Clipper\Child-Theme\Views
 * @author  AppThemes
 * @since   Clipper 1.5
 */


/**
 * Featured Coupons Home page view.
 */
class Child_Featured_Coupons_Home extends APP_View_Page {

	/**
	 * Setups page view.
	 *
	 * @return void
	 */
	function __construct() {
		parent::__construct( 'tpl-featured-coupons-home.php', __( 'Featured Coupons', APP_TD ) );
	}

	/**
	 * Returns page ID.
	 *
	 * @return int
	 */
	static function get_id() {
		return parent::_get_page_id( 'tpl-featured-coupons-home.php' );
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

