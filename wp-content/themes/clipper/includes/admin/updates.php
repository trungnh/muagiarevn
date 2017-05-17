<?php
/**
 * Updating functions.
 *
 * @package Clipper\Admin\Update
 * @author  AppThemes
 * @since   Clipper 1.2
 */


/**
 * Checks theme database version and fires proper upgrading script.
 *
 * @return void
 */
function clpr_upgrade_all() {

	$current_db_version = get_option( 'clpr_db_version' );

	if ( $current_db_version < 411 ) {
		clpr_upgrade_121();
	}

	if ( $current_db_version < 412 ) {
		clpr_upgrade_122();
	}

	if ( $current_db_version < 413 ) {
		clpr_upgrade_123();
	}

	if ( $current_db_version < 414 ) {
		clpr_upgrade_124();
	}

	if ( $current_db_version < 417 ) {
		clpr_upgrade_14();
	}

	if ( $current_db_version < 908 ) {
		clpr_upgrade_15();
	}

	if ( $current_db_version < 1006 ) {
		clpr_upgrade_150_convert_reports();
	}

	if ( $current_db_version < 1178 ) {
		clpr_upgrade_16();
	}


	update_option( 'clpr_db_version', CLPR_DB_VERSION );
}
add_action( 'appthemes_first_run', 'clpr_upgrade_all' );


/**
 * Execute changes made in Clipper 1.2.1.
 *
 * @since 1.2.1
 *
 * @return void
 */
function clpr_upgrade_121() {
	global $wpdb;

	if ( get_option( 'clpr_upgrade_121' ) != 'done' ) {
		if ( ! $postids = get_option( 'clpr_upgrade_121' ) ) {
			$qryToString = "SELECT $wpdb->posts.ID FROM $wpdb->posts WHERE $wpdb->posts.post_type = '" . APP_POST_TYPE . "'";
			$postids = $wpdb->get_col( $qryToString );
		}
	} else {
		$postids = false;
	}

	if ( $postids ) {
		$i = 0;
		$left_posts = $postids;

		foreach ( $postids as $key => $id ) {
			$i++;
			unset( $left_posts[ $key ] );

			if ( get_post_meta( $id, 'clpr_votes_up' ) == false ) {
				update_post_meta( $id, 'clpr_votes_up', 0 );
			}

			if ( get_post_meta( $id, 'clpr_votes_down' ) == false ) {
				update_post_meta( $id, 'clpr_votes_down', 0 );
			}

			if ( get_post_meta( $id, 'clpr_expire_date' ) == false ) {
				update_post_meta( $id, 'clpr_expire_date', '' );
			}

			if ( ( $i > 100 ) || ( count( $left_posts ) < 1 ) ) {
				update_option( 'clpr_upgrade_121', $left_posts );

				if ( count( $left_posts ) < 1 ) {
					update_option( 'clpr_upgrade_121', 'done' );
				}

				clpr_js_redirect( admin_url( 'admin.php?page=app-settings&firstrun=1' ), __( 'Continue Upgrading', APP_TD ) );
				exit;
			}
		}
	} else {
		update_option( 'clpr_db_version', '411' );
	}
}


/**
 * Execute changes made in Clipper 1.2.2.
 *
 * @since 1.2.2
 *
 * @return void
 */
function clpr_upgrade_122() {
	global $wpdb;

	// create term for printable coupon images
	$image_tax = ( array( 'slug' => 'printable-coupon' ) );
	if ( ! get_term_by( 'slug', 'printable-coupon', APP_TAX_IMAGE ) ) {
		wp_insert_term( 'Printable Coupon', APP_TAX_IMAGE, $image_tax );
	}

	// update old printable coupon images
	$term = get_term_by( 'slug', 'printable-coupon', APP_TAX_IMAGE );

	$qryToString = "SELECT $wpdb->posts.ID FROM $wpdb->posts
		INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
		WHERE 1=1 AND ( $wpdb->term_relationships.term_taxonomy_id IN ($term->term_id) )
		AND $wpdb->posts.post_type = '" . APP_POST_TYPE . "'";

	$postids = $wpdb->get_col( $qryToString );

	if ( $postids ) {
		foreach ( $postids as $id ) {

			$images = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'ID' ) );
			if ( $images ) {
				// move over bacon
				$image = array_shift( $images );
				wp_set_object_terms( $image->ID, 'printable-coupon', APP_TAX_IMAGE, false );
			}

		}
	}
	update_option( 'clpr_db_version', '412' );
}


/**
 * Execute changes made in Clipper 1.2.3.
 *
 * @since 1.2.3
 *
 * @return void
 */
function clpr_upgrade_123() {
	global $wpdb;

	if ( get_option( 'clpr_upgrade_123' ) != 'done' ) {
		if ( ! $postids = get_option( 'clpr_upgrade_123' ) ) {
			$qryToString = "SELECT $wpdb->posts.ID FROM $wpdb->posts
			WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = '" . APP_POST_TYPE . "'";

			$postids = $wpdb->get_col( $qryToString );
		}
	} else {
		$postids = false;
	}

	if ( $postids ) {
		$i = 0;
		$left_posts = $postids;

		foreach ( $postids as $key => $id ) {
			$i++;
			unset( $left_posts[ $key ] );

			$t = time();
			$votes_down = get_post_meta( $id, 'clpr_votes_down', true );
			$votes_percent = get_post_meta( $id, 'clpr_votes_percent', true );
			$expire_date = get_post_meta( $id, 'clpr_expire_date', true );
			if ( $expire_date != '' ) {
				$expire_date_time = strtotime( str_replace( '-', '/', $expire_date ) );
			} else {
				$expire_date_time = 0;
			}

			if ( ( $votes_percent < 50 && $votes_down != 0 ) || ( $expire_date_time < $t && $expire_date != '' ) ) {
				$wpdb->update( $wpdb->posts, array( 'post_status' => 'unreliable' ), array( 'ID' => $id ) );
			}

			if ( ( $i > 100 ) || ( count( $left_posts ) < 1 ) ) {
				update_option( 'clpr_upgrade_123', $left_posts );

				if ( count( $left_posts ) < 1 ) {
					update_option( 'clpr_upgrade_123', 'done' );
				}

				clpr_js_redirect( admin_url( 'admin.php?page=app-settings&firstrun=1' ), __( 'Continue Upgrading', APP_TD ) );
				exit;

			}
		}
	} else {
		update_option( 'clpr_db_version', '413' );
	}

}


/**
 * Execute changes made in Clipper 1.2.4.
 *
 * @since 1.2.4
 *
 * @return void
 */
function clpr_upgrade_124() {

	// create term for promotional coupons without code
	$type_tax = ( array( 'slug' => 'promotion' ) );
	if ( ! get_term_by( 'slug', 'promotion', APP_TAX_TYPE ) ) {
		wp_insert_term( 'Promotion', APP_TAX_TYPE, $type_tax );
	}

	update_option( 'clpr_db_version', '414' );
}


/**
 * Execute changes made in Clipper 1.4.
 *
 * @since 1.4
 *
 * @return void
 */
function clpr_upgrade_14() {
	global $wpdb;

	// remove old table indexes
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	drop_index( $wpdb->clpr_pop_daily, 'id' );
	drop_index( $wpdb->clpr_pop_total, 'id' );

	// clean extra indexes
	add_clean_index( $wpdb->clpr_storesmeta, 'stores_id' );
	add_clean_index( $wpdb->clpr_storesmeta, 'meta_key' );

	update_option( 'clpr_db_version', '417' );
}

/**
 * Convert expire date format.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_upgrade_150_convert_expire_date() {
	global $wpdb;

	$results = $wpdb->get_results( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'clpr_expire_date' AND meta_value != '' GROUP BY post_id" );
	if ( ! $results ) {
		return;
	}

	foreach ( $results as $meta ) {
		// month, day, year
		if ( ! preg_match( "/^(\d{2})-(\d{2})-(\d{4})$/", $meta->meta_value, $date_parts ) ) {
			continue;
		}

		$time = strtotime( str_replace( '-', '/', $meta->meta_value ) );
		$date = date( 'Y-m-d', $time );
		update_post_meta( $meta->post_id, 'clpr_expire_date', $date );
	}
}


/**
 * Convert old settings to scbOptions format.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_upgrade_150_convert_settings() {
	global $wpdb, $clpr_options;

	$new_options = array();
	$options_to_delete = array();
	$report_options = array();

	// fields to convert from select 'yes/no' to checkbox
	$select_fields = array(
		'use_logo',
		'search_stats',
		'search_ex_pages',
		'search_ex_blog',
		'coupons_require_moderation',
		'stores_require_moderation',
		'prune_coupons',
		'reg_required',
		'coupon_edit',
		'coupon_code_hide',
		'allow_html',
		'stats_all',
		'charge_coupons',
		'captcha_enable',
		'adcode_336x280_enable',
		'disable_stylesheet',
		'debug_mode',
		'disable_wp_login',
		'remove_wp_generator',
		'remove_admin_bar',
		'new_ad_email',
		'prune_coupons_email',
		'nu_custom_email',
		'nc_custom_email',
	);

	// legacy settings
	$legacy_options = $wpdb->get_results( "SELECT * FROM $wpdb->options WHERE option_name LIKE 'clpr_%'" );

	if ( ! $legacy_options ) {
		return;
	}

	foreach ( $legacy_options as $option ) {
		$new_option_name = substr( $option->option_name, 5 );

		// skip not used options and membership entries
		if ( is_null( $clpr_options->$new_option_name ) || $new_option_name == 'options' ) {
			continue;
		}

		// convert select 'yes/no' to checkbox
		if ( in_array( $new_option_name, $select_fields ) ) {
			$option->option_value = ( $option->option_value == 'yes' ) ? 1 : 0;
		}

		// convert report options field
		if ( $new_option_name == 'rp_options' ) {
			$option->option_value = str_replace( "|", "\n", $option->option_value );
		}

		// collect report options
		if ( in_array( $new_option_name, array( 'rp_options', 'rp_registeronly', 'rp_send_email' ) ) ) {
			$report_option_name = substr( $new_option_name, 3 );
			$report_option_name = ( $report_option_name == 'options' ) ? 'post_options' : $report_option_name;
			$report_options[ $report_option_name ] = maybe_unserialize( $option->option_value );
		}

		$new_options[ $new_option_name ] = maybe_unserialize( $option->option_value );
		$options_to_delete[] = $option->option_name;
	}

	// migrate payments settings
	$new_options = array_merge( $new_options, get_option( 'payments', array() ) );
	$options_to_delete[] = 'payments';

	// migrate reports settings
	$new_options = array_merge( $new_options, array( 'reports' => $report_options ) );

	// save new options
	$new_options = array_merge( get_option( 'clpr_options', array() ), $new_options );
	update_option( 'clpr_options', $new_options );

	// delete old options
	foreach ( $options_to_delete as $option_name ) {
		delete_option( $option_name );
	}
}


/**
 * Execute changes made in Clipper 1.5.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_upgrade_15() {

	// convert old settings to scbOptions format
	clpr_upgrade_150_convert_settings();

	// convert expire date format
	clpr_upgrade_150_convert_expire_date();

	// set blog and ads pages
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', CLPR_Coupons_Home::get_id() );
	update_option( 'page_for_posts', CLPR_Blog_Archive::get_id() );

	// remove old blog page
	$args = array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'meta_value' => 'tpl-blog.php',
		'posts_per_page' => 1,
		'suppress_filters' => true,
	);
	$blog_page = new WP_Query( $args );

	if ( ! empty( $blog_page->posts ) ) {
		wp_delete_post( $blog_page->posts[0]->ID, true );
	}

	update_option( 'clpr_db_version', '908' );
}


/**
 * Convert old reports to custom comment type.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_upgrade_150_convert_reports() {
	global $wpdb;

	if ( get_option( 'clpr_upgrade_150_convert_reports' ) == 'done' ) {
		return;
	}

	if ( ! $post_ids = get_option( 'clpr_upgrade_150_convert_reports' ) ) {
		$query = "SELECT postID FROM $wpdb->clpr_report";
		$post_ids = $wpdb->get_col( $query );
	}

	if ( ! $post_ids ) {
		update_option( 'clpr_db_version', '1006' );
		update_option( 'clpr_upgrade_150_convert_reports' , 'done' );
		return;
	}

	$i = 0;
	$left_posts = $post_ids;

	foreach ( $post_ids as $key => $post_id ) {
		$i++;
		unset( $left_posts[ $key ] );

		$query = $wpdb->prepare( "SELECT id FROM $wpdb->clpr_report WHERE postID = %d", $post_id );
		$report_id = $wpdb->get_var( $query );
		if ( ! $report_id ) {
			continue;
		}

		$query = $wpdb->prepare( "SELECT * FROM $wpdb->clpr_report_comments WHERE reportID = %d", $report_id );
		$reports = $wpdb->get_results( $query );
		if ( ! $reports ) {
			continue;
		}

		foreach ( $reports as $report ) {
			$comment = array(
				'comment_post_ID' => $post_id,
				'comment_content' => $report->type,
				'comment_date' => date( 'Y-m-d H:i:s', $report->stamp ),
				'comment_author_IP' => $report->ip,
				'comment_author' => '',
				'comment_author_email' => '',
				'comment_author_url' => '',
				'user_id' => 0,
			);
			appthemes_create_report( $comment );
		}

		// remove records from old table
		$wpdb->delete( $wpdb->clpr_report, array( 'postID' => $post_id ), array( '%d' ) );
		$wpdb->delete( $wpdb->clpr_report_comments, array( 'reportID' => $report_id ), array( '%d' ) );

		if ( ( $i > 500 ) || empty( $left_posts ) ) {
			update_option( 'clpr_upgrade_150_convert_reports' , $left_posts );

			if ( empty( $left_posts ) ) {
				update_option( 'clpr_db_version', '1006' );
				update_option( 'clpr_upgrade_150_convert_reports' , 'done' );
				return;
			}

			clpr_js_redirect( admin_url( 'admin.php?page=app-settings&firstrun=1' ), __( 'Continue Upgrading', APP_TD ) );
			exit;
		}
	}

}


/**
 * Execute changes made in Clipper 1.6.
 *
 * @since 1.6
 *
 * @return void
 */
function clpr_upgrade_16() {
	global $clpr_options;

	// remove old pages
	$args = array(
		'post_type' => 'page',
		'meta_query' => array(
			array(
				'key'     => '_wp_page_template',
				'value'   => array( 'tpl-submit-coupon.php', 'tpl-edit-item.php' ),
				'compare' => 'IN',
			),
		),
		'posts_per_page' => -1,
		'suppress_filters' => true,
	);
	$old_pages = new WP_Query( $args );

	if ( $old_pages->have_posts() ) {
		foreach ( $old_pages->posts as $old_page ) {
			wp_delete_post( $old_page->ID, true );
		}
	}

	// migrate logo options to 'custom-header' theme support
	if ( ! $clpr_options->use_logo ) {
		// logo wasn't used, use the default one
		set_theme_mod( 'header_image', 'remove-header' );
		remove_theme_mod( 'header_image_data' );
	} else if ( $clpr_options->logo_url && $importer = appthemes_get_instance( 'CLPR_Importer' ) ) {
		// create new attachment from old logo
		$attachment_id = $importer->process_attachment( $clpr_options->logo_url, 0 );
		if ( ! is_wp_error( $attachment_id ) && $attachment_attr = wp_get_attachment_image_src( $attachment_id, 'full' ) ) {
			$data = array();
			$data['url'] = esc_url_raw( $attachment_attr[0] );

			$header_image_data = (object) array(
				'attachment_id' => $attachment_id,
				'url'           => $data['url'],
				'thumbnail_url' => $data['url'],
				'height'        => $attachment_attr[2],
				'width'         => $attachment_attr[1],
			);

			update_post_meta( $attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
			set_theme_mod( 'header_image', $data['url'] );
			set_theme_mod( 'header_image_data', $header_image_data );
			set_theme_mod( 'header_textcolor', 'blank' );
		}
	}

	// collect orders ids to update data
	if ( ! $order_ids = get_option( 'clpr_upgrade_160_orders' ) ) {
		// get all orders ids
		$args = array(
			'post_type' => APPTHEMES_ORDER_PTYPE,
			'post_status' => 'any',
			'posts_per_page' => -1,
			'fields' => 'ids',
		);
		$orders = new WP_Query( $args );

		if ( isset( $orders->posts ) && is_array( $orders->posts ) ) {
			update_option( 'clpr_upgrade_160_orders', $orders->posts );
		} else {
			update_option( 'clpr_upgrade_160_orders', 'done' );
		}
	}

	update_option( 'clpr_db_version', '1178' );
}


/**
 * Update orders to include urls, checkout type, and hash.
 *
 * @since 1.6
 *
 * @return void
 */
function clpr_upgrade_160_orders() {
	$order_ids = get_option( 'clpr_upgrade_160_orders' );

	if ( ! $order_ids || $order_ids == 'done' ) {
		return;
	}

	$i = 0;
	$left_orders = $order_ids;

	foreach ( $order_ids as $key => $order_id ) {
		$i++;

		// all orders updated, quit the loop
		if ( empty( $left_orders ) ) {
			break;
		}

		// save current progress, and continue on next page load (memory and execution time have limits)
		if ( $i > 50 ) {
			echo scb_admin_notice( sprintf( __( 'Orders Update Progress: %d orders left.', APP_TD ), count( $left_orders ) ) );

			update_option( 'clpr_upgrade_160_orders', $left_orders );
			return;
		}

		unset( $left_orders[ $key ] );

		// updated order check
		if ( $checkout_hash = get_post_meta( $order_id, 'checkout_hash', true ) ) {
			continue;
		}

		// retrieve order object
		$order = appthemes_get_order( $order_id );
		if ( ! $order ) {
			continue;
		}

		// determine checkout type and url
		if ( $item = $order->get_item( CLPR_COUPON_LISTING_TYPE ) ) {
			$listing_orders_args = array(
				'connected_type' => APPTHEMES_ORDER_CONNECTION,
				'connected_query' => array( 'post_status' => 'any' ),
				'connected_to' => $item['post_id'],
				'post_status' => 'any',
				'fields' => 'ids',
				'nopaging' => true,
			);
			$listing_orders = new WP_Query( $listing_orders_args );

			if ( empty( $listing_orders->posts ) || $order_id == min( $listing_orders->posts ) ) {
				$checkout_type = 'create-listing';
				$checkout_url = clpr_get_submit_coupon_url( 'raw' );
			} else {
				$checkout_type = 'renew-listing';
				$checkout_url = clpr_get_renew_coupon_url( $item['post_id'], 'raw' );
			}
		} else {
			// unknown/invalid order
			continue;
		}

		// generate new checkout hash
		$hash = substr( sha1( time() . mt_rand( 0, 1000 ) ), 0, 20 );

		// if url set, get the hash
		if ( $complete_url = get_post_meta( $order_id, 'complete_url', true ) ) {
			$parsed_url = parse_url( $complete_url );
			parse_str( $parsed_url['query'], $url_args );
			if ( ! empty( $url_args['hash'] ) ) {
				$hash = $url_args['hash'];
			}
		}

		$complete_url = add_query_arg( array( 'step' => 'order-summary', 'hash' => $hash ), $checkout_url );
		$cancel_url = add_query_arg( array( 'step' => 'gateway-select', 'hash' => $hash ), $checkout_url );

		update_post_meta( $order_id, 'complete_url', $complete_url );
		update_post_meta( $order_id, 'cancel_url', $cancel_url );
		update_post_meta( $order_id, 'checkout_type', $checkout_type );
		update_post_meta( $order_id, 'checkout_hash', $hash );

	}

	// mark this upgrage as completed
	update_option( 'clpr_upgrade_160_orders', 'done' );
}
add_action( 'admin_notices', 'clpr_upgrade_160_orders' );
