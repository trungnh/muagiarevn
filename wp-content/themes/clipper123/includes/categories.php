<?php
/**
 * Categories, Types, Tags.
 *
 * @package Clipper\Categories
 * @author  AppThemes
 * @since   Clipper 1.6
 */


/**
 * Display or retrieve the HTML dropdown list of coupon categories.
 *
 * @param int|string|array $args (optional) Override default arguments.
 *
 * @return void|string HTML content only if 'echo' argument is 0.
 */
function clpr_dropdown_coupon_categories( $args = '' ) {
	global $wp_version;

	$defaults = array(
		'taxonomy' => APP_TAX_CAT,
		'name' => APP_TAX_CAT,
		'id' => APP_TAX_CAT . '_select',
		'class' => 'text required',
		'show_option_all' => '',
		'show_option_none' => __( '-- Select One --', APP_TD ),
		'option_none_value' => '',
		'show_count' => 0,
		'hide_empty' => 0,
		'hide_if_empty' => false,
		'hierarchical' => 1,
		'selected' => 0,
		'orderby' => 'name',
		'order' => 'ASC',
		'echo' => 1,
	);
	$defaults['selected'] = ( is_tax( APP_TAX_CAT ) ) ? get_queried_object_id() : 0;

	// allow passing selected category ID
	if ( is_numeric( $args ) ) {
		$args = array( 'selected' => (int) $args );
	}

	$args = wp_parse_args( $args, $defaults );

	// always return from WP function
	$echo = false;
	if ( $args['echo'] ) {
		$args['echo'] = 0;
		$echo = true;
	}

	$select = wp_dropdown_categories( $args );

	// 'option_none_value' arg introduced in WP 4.0
	if ( version_compare( $wp_version, '4.0', '<' ) ) {
		$none_value = '"' . $args['option_none_value'] . '"';
		$select = preg_replace( '"-1"', $none_value, $select );
	}

	if ( $echo ) {
		echo $select;
	} else {
		return $select;
	}
}


/**
 * Display or retrieve the HTML dropdown list of coupon stores.
 *
 * @param int|string|array $args (optional) Override default arguments.
 *
 * @return void|string HTML content only if 'echo' argument is 0.
 */
function clpr_dropdown_coupon_stores( $args = '' ) {
	global $wp_version;

	$defaults = array(
		'taxonomy' => APP_TAX_STORE,
		'name' => APP_TAX_STORE,
		'id' => 'store_name_select',
		'class' => 'text required',
		'show_option_all' => '',
		'show_option_none' => __( '-- Select One --', APP_TD ),
		'option_none_value' => '',
		'show_count' => 0,
		'hide_empty' => 0,
		'hide_if_empty' => false,
		'hierarchical' => 1,
		'selected' => 0,
		'orderby' => 'name',
		'order' => 'ASC',
		'echo' => 1,
	);
	$defaults['selected'] = ( is_tax( APP_TAX_STORE ) ) ? get_queried_object_id() : 0;

	// allow passing selected store ID
	if ( is_numeric( $args ) ) {
		$args = array( 'selected' => (int) $args );
	}

	$args = wp_parse_args( $args, $defaults );

	// build the list of stores to exclude
	$hidden_stores = clpr_hidden_stores();
	if ( $args['selected'] && in_array( $args['selected'], $hidden_stores ) ) {
		// we cant exclude current store
		$hidden_stores = array_diff( $hidden_stores, array( $args['selected'] ) );
	}
	$args['exclude'] = implode( ',', $hidden_stores );

	// always return from WP function
	$echo = false;
	if ( $args['echo'] ) {
		$args['echo'] = 0;
		$echo = true;
	}

	// prepare 'add new store' option, and add unique ID after option 'none'
	$add_store_option = '</option><option value="add-new">' . __( 'Add New Store', APP_TD );
	$id_to_replace = uniqid( rand( 10, 1000 ), false );
	$args['show_option_none'] .= $id_to_replace;

	$select = wp_dropdown_categories( $args );

	// replace unique ID with 'add new store' option
	$select = str_replace( $id_to_replace, $add_store_option, $select );

	// 'option_none_value' arg introduced in WP 4.0
	if ( version_compare( $wp_version, '4.0', '<' ) ) {
		$none_value = '"' . $args['option_none_value'] . '"';
		$select = preg_replace( '"-1"', $none_value, $select );
	}

	if ( $echo ) {
		echo $select;
	} else {
		return $select;
	}
}


/**
 * Display or retrieve the HTML dropdown list of coupon types.
 *
 * @param int|string|array $args (optional) Override default arguments.
 *
 * @return void|string HTML content only if 'echo' argument is 0.
 */
function clpr_dropdown_coupon_types( $args = '' ) {
	global $wp_version;

	$defaults = array(
		'taxonomy' => APP_TAX_TYPE,
		'name' => APP_TAX_TYPE,
		'id' => APP_TAX_TYPE . '_select',
		'class' => 'text required',
		'show_option_all' => '',
		'show_option_none' => __( '-- Select One --', APP_TD ),
		'option_none_value' => '',
		'show_count' => 0,
		'hide_empty' => 0,
		'hide_if_empty' => false,
		'hierarchical' => 1,
		'selected' => 0,
		'orderby' => 'name',
		'order' => 'ASC',
		'echo' => 1,
		// custom args, allowed values: term_id, name, slug, taxonomy, description, parent, count.
		'use_for_option_value' => 'slug',
		'use_for_option_name' => 'name',
	);
	$defaults['selected'] = ( is_tax( APP_TAX_TYPE ) ) ? get_queried_object_id() : 0;

	$defaults['walker'] = new CLPR_Walker_Category_Dropdown_Options_Values;

	// allow passing selected type ID
	if ( is_numeric( $args ) ) {
		$args = array( 'selected' => (int) $args );
	}

	$args = wp_parse_args( $args, $defaults );

	// always return from WP function
	$echo = false;
	if ( $args['echo'] ) {
		$args['echo'] = 0;
		$echo = true;
	}

	$select = wp_dropdown_categories( $args );

	// 'option_none_value' arg introduced in WP 4.0
	if ( version_compare( $wp_version, '4.0', '<' ) ) {
		$none_value = '"' . $args['option_none_value'] . '"';
		$select = preg_replace( '"-1"', $none_value, $select );
	}

	if ( $echo ) {
		echo $select;
	} else {
		return $select;
	}
}


/**
 * Create HTML dropdown list of Categories/Terms.
 * @since 1.6
 */
class CLPR_Walker_Category_Dropdown_Options_Values extends Walker_CategoryDropdown {

	/**
	 * @see Walker::$tree_type
	 * @var string
	 */
	public $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @var array
	 */
	public $db_fields = array( 'parent' => 'parent', 'id' => 'term_id' );

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int    $depth    (optional) Depth of category. Used for padding.
	 * @param array  $args     (optional) Uses 'selected' and 'show_count' keys, if they exist.
	 * @param int    $id       (optional)
	 *
	 * @return void
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat( '&nbsp;', $depth * 3 );
		$allowed_fields = array( 'term_id', 'name', 'slug', 'taxonomy', 'description', 'parent', 'count' );

		// determine which fields to use for option name and value
		$option_value_field = ( isset( $args['use_for_option_value'] ) && in_array( $args['use_for_option_value'], $allowed_fields ) ) ? $args['use_for_option_value'] : 'term_id';
		$option_name_field = ( isset( $args['use_for_option_name'] ) && in_array( $args['use_for_option_name'], $allowed_fields ) ) ? $args['use_for_option_name'] : 'name';

		$cat_name = apply_filters( 'list_cats', $category->{$option_name_field}, $category );
		$cat_name = $pad . $cat_name;
		if ( $args['show_count'] ) {
			$cat_name .= '&nbsp;&nbsp;(' . number_format_i18n( $category->count ) . ')';
		}

		// build the option args
		$option_args = array(
			'class' => 'level-' . $depth,
			'value' => $category->{$option_value_field},
		);
		if ( $category->term_id == $args['selected'] ) {
			$option_args['selected'] = 'selected';
		}

		$output .= "\t" . html( 'option', $option_args, $cat_name ) . "\n";
	}

}

