<?php
/**
 * Admin Users list.
 *
 * @package Clipper\Admin\Users
 * @author  AppThemes
 * @since   Clipper 1.6
 */


// Users list
add_filter( 'manage_users_columns', 'clpr_manage_users_columns' );
add_filter( 'manage_users_custom_column', 'clpr_manage_users_custom_column', 10, 3 );


/**
 * Adds extra columns to the users overview.
 *
 * @param array $columns
 *
 * @return array
 */
function clpr_manage_users_columns( $columns ) {
	$columns['coupons'] = __( 'Coupons', APP_TD );

	return $columns;
}


/**
 * Returns content for the custom users columns.
 *
 * @param string $r
 * @param string $column_name
 * @param int $user_id
 *
 * @return string
 */
function clpr_manage_users_custom_column( $r, $column_name, $user_id ) {
	global $wp_list_table, $coupons_counts;

	if ( $column_name == 'coupons' ) {
		if ( ! isset( $coupons_counts ) ) {
			$coupons_counts = count_many_users_posts( array_keys( $wp_list_table->items ), APP_POST_TYPE );
		}

		if ( ! isset( $coupons_counts[ $user_id ] ) ) {
			$coupons_counts[ $user_id ] = 0;
		}

		if ( $coupons_counts[ $user_id ] > 0 ) {
			$url = add_query_arg( array( 'post_type' => APP_POST_TYPE, 'author' => $user_id ), admin_url( 'edit.php' ) );
			$r .= html( 'a', array( 'href' => esc_url( $url ), 'class' => 'edit', 'title' => esc_attr__( 'View coupons by this author', APP_TD ) ), $coupons_counts[ $user_id ] );
		} else {
			$r .= 0;
		}
	}

	return $r;
}


