<?php
/**
 * Clipper core theme functions.
 *
 * @package Clipper\Functions
 * @author  AppThemes
 * @since   Clipper 1.0
 */


/**
 * Filter short code [template-url].
 *
 * @param string $text
 *
 * @return string
 */
function filter_template_url( $text ) {
	return str_replace( '[template-url]', get_template_directory_uri(), $text );
}
add_filter( 'the_content', 'filter_template_url' );
add_filter( 'get_the_content', 'filter_template_url' );
add_filter( 'widget_text', 'filter_template_url' );


/**
 * Replace Standard WP Menu Classes for cleaner CSS classes.
 *
 * @param string $css_classes
 * @param object $item
 *
 * @return string
 */
function change_menu_classes( $css_classes, $item ) {
	$css_classes = str_replace( "current-menu-item", "active", $css_classes );
	$css_classes = str_replace( "current-menu-parent", "active", $css_classes );
	$css_classes = str_replace( "current-menu-ancestor", "active", $css_classes );

	return $css_classes;
}
add_filter( 'nav_menu_css_class', 'change_menu_classes', 10, 2 );


/**
 * Displays the register link in the header if registration is enabled.
 *
 * @param string $before (optional)
 * @param string $after (optional)
 * @param bool $echo (optional)
 *
 * @return void|string
 */
function clpr_register( $before = '<li>', $after = '</li>', $echo = true ) {

	if ( ! is_user_logged_in() ) {
		if ( get_option( 'users_can_register' ) ) {
			$link = $before . html_link( appthemes_get_registration_url(), __( 'Register', APP_TD ) ) . $after;
		} else {
			$link = '';
		}
	} else {
		$link = $before . html_link( clpr_get_dashboard_url(), __( 'My Dashboard', APP_TD ) ) . $after;
	}

	if ( $echo ) {
		echo apply_filters( 'register', $link );
	} else {
		return apply_filters( 'register', $link );
	}
}


/**
 * Displays the login message in the header.
 *
 * @return void
 */
function clpr_login_head() {

	if ( is_user_logged_in() ) {
		echo html( 'li', html_link( clpr_get_dashboard_url(), __( 'My Dashboard', APP_TD ) ) );
		echo html( 'li', html_link( clpr_logout_url( home_url() ), __( 'Log out', APP_TD ) ) );
	} else {
		if ( get_option( 'users_can_register' ) ) {
			echo html( 'li', html_link( appthemes_get_registration_url(), __( 'Register', APP_TD ) ) );
		}
		echo html( 'li', html_link( wp_login_url(), __( 'Login', APP_TD ) ) );
	}

}


/**
 * Returns user name depend of account type.
 *
 * @param object|int $user (optional)
 *
 * @return string
 */
function clpr_get_user_name( $user = false ) {

	if ( ! $user && is_user_logged_in() ) {
		$user = wp_get_current_user();
	} else if ( is_numeric( $user ) ) {
		$user = get_userdata( $user );
	}

	if ( is_object( $user ) ) {
		return $user->display_name;
	} else {
		return false;
	}
}


/**
 * Returns logout url depend of login type.
 *
 * @param string $url (optional)
 *
 * @return string
 */
function clpr_logout_url( $url = '' ) {

	if ( ! $url ) {
		$url = home_url();
	}

	if ( is_user_logged_in() ) {
		return wp_logout_url( $url );
	} else {
		return false;
	}
}


/**
 * Corrects logout url in admin bar.
 *
 * @return void
 */
function clpr_admin_bar_render() {
  global $wp_admin_bar;

  if ( is_user_logged_in() ) {
		$wp_admin_bar->remove_menu( 'logout' );
		$wp_admin_bar->add_menu( array(
			'parent' => 'user-actions',
			'id'     => 'logout',
			'title'  => __( 'Log out', APP_TD ),
			'href'   => clpr_logout_url(),
		) );
	}

}
add_action( 'wp_before_admin_bar_render', 'clpr_admin_bar_render' );


/**
 * Returns url to user dashboard page.
 *
 * @param string $context (optional)
 *
 * @return string
 */
function clpr_get_dashboard_url( $context = 'display' ) {
	if ( defined( 'CLPR_DASHBOARD_URL' ) ) {
		$url = CLPR_DASHBOARD_URL;
	} else {
		$url = get_permalink( CLPR_User_Dashboard::get_id() );
	}

	return esc_url( $url, null, $context );
}


/**
 * Returns url to edit profile page.
 *
 * @param string $context (optional)
 *
 * @return string
 */
function clpr_get_profile_url( $context = 'display' ) {
	if ( defined( 'CLPR_PROFILE_URL' ) ) {
		$url = CLPR_PROFILE_URL;
	} else {
		$url = get_permalink( CLPR_User_Profile::get_id() );
	}

	return esc_url( $url, null, $context );
}


/**
 * Returns url to submit coupon page.
 *
 * @param string $context (optional)
 *
 * @return string
 */
function clpr_get_submit_coupon_url( $context = 'display' ) {
	$url = get_permalink( CLPR_Coupon_Submit::get_id() );

	return esc_url( $url, null, $context );
}


/**
 * Returns coupon listing edit url.
 *
 * @param int $listing_id
 * @param string $context (optional)
 *
 * @return string
 */
function clpr_get_edit_coupon_url( $listing_id, $context = 'display' ) {
	$url = get_permalink( CLPR_Edit_Item::get_id() );
	$url = add_query_arg( array( 'listing_edit' => $listing_id ), $url );

	return esc_url( $url, null, $context );
}


/**
 * Returns coupon listing renew url.
 *
 * @param int $listing_id
 * @param string $context (optional)
 *
 * @return string
 */
function clpr_get_renew_coupon_url( $listing_id, $context = 'display' ) {
	$url = get_permalink( CLPR_Coupon_Renew::get_id() );
	$url = add_query_arg( array( 'listing_renew' => $listing_id ), $url );

	return esc_url( $url, null, $context );
}


/**
 * Displays edit coupon link. Use only in loop.
 *
 * @return void
 */
function clpr_edit_coupon_link() {
	global $post, $current_user, $clpr_options;

	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( current_user_can( 'manage_options' ) ) {
		edit_post_link( __( 'Edit Coupon', APP_TD ), '<p class="edit">', '</p>', $post->ID );
	} else if ( $clpr_options->coupon_edit && $post->post_author == $current_user->ID ) {
		$edit_url = clpr_get_edit_coupon_url( $post->ID );
		$edit_link = html( 'a', array( 'class' => 'post-edit-link', 'href' => $edit_url, 'title' => __( 'Edit Coupon', APP_TD ) ), __( 'Edit Coupon', APP_TD ) );
		echo html( 'p', array( 'class' => 'edit' ), $edit_link );
	}

}


/**
 * Returns expire date of coupon.
 *
 * @param int $post_id
 * @param string $format (optional)
 *
 * @return string|int
 */
function clpr_get_expire_date( $post_id, $format = 'raw' ) {
	$expire_date = get_post_meta( $post_id, 'clpr_expire_date', true );
	if ( empty( $expire_date ) ) {
		return '';
	}

	$expire_time = strtotime( $expire_date );

	switch( $format ) {
		case 'display':
			$expire_date = date_i18n( get_option( 'date_format' ), $expire_time );
			break;

		case 'time':
			$expire_date = $expire_time;
			break;

		case 'raw':
			break;

		default:
			$expire_date = date( $format, $expire_time );
			break;
	}

	return $expire_date;
}


/**
 * Checks if coupon listing is expired.
 *
 * @param int $listing_id (optional).
 *
 * @return bool
 */
function clpr_is_listing_expired( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$listing = get_post( $listing_id );

	// Listing awaiting moderation or payment.
	if ( $listing->post_status === 'pending' ) {
		return false;
	}

	// Check expiration date.
	$expire_time = clpr_get_expire_date( $listing->ID, 'time' );
	if ( ! $expire_time ) {
		// If empty, coupon does not expire.
		return false;
	}

	// Valid expiration date.
	$expire_time += ( 24 * 3600 ); // + 24h, coupons expire in the end of day.
	if ( ! $expire_time ) {
		return false;
	}

	if ( $expire_time > current_time( 'timestamp' ) ) {
		return false;
	}

	return true;
}


/**
 * Determines (Publish vs. Unreliable) and updates coupon status.
 *
 * @param int $post_id
 * @param string $post_status (optional)
 *
 * @return void
 */
function clpr_status_update( $post_id, $post_status = null ) {
	global $wpdb;

	$t = strtotime( date( 'd-m-Y' ) );
	$votes_down = get_post_meta( $post_id, 'clpr_votes_down', true );
	$votes_percent = get_post_meta( $post_id, 'clpr_votes_percent', true );
	$expire_date = get_post_meta( $post_id, 'clpr_expire_date', true );
	if ( $expire_date != '' ) {
		$expire_date_time = clpr_get_expire_date( $post_id, 'time' );
	} else {
		$expire_date_time = 0;
	}

	if ( ! $post_status ) {
		$post_status = get_post_status( $post_id );
	}

	if ( ( $votes_percent < 50 && $votes_down != 0 ) || ( $expire_date_time < $t && $expire_date != '' ) ) {
		if ( $post_status == 'publish' ) {
			$wpdb->update( $wpdb->posts, array( 'post_status' => 'unreliable' ), array( 'ID' => $post_id ) );
		}
	} else {
		if ( $post_status == 'unreliable' ) {
			$wpdb->update( $wpdb->posts, array( 'post_status' => 'publish' ), array( 'ID' => $post_id ) );
		}
	}

}


/**
 * Returns the store url taxonomy custom field.
 *
 * @param int $post_id
 * @param string $tax_name
 * @param string $tax_arg
 *
 * @return string
 */
function clpr_store_url( $post_id, $tax_name, $tax_arg ) {
	$term_id = appthemes_get_custom_taxonomy( $post_id, $tax_name, $tax_arg );
	$store_url = clpr_get_store_meta( $term_id, 'clpr_store_url', true );

	return $store_url;
}


/**
 * Returns the store image url with specified size.
 *
 * @param int $id
 * @param string $type (optional)
 * @param int $width (optional)
 *
 * @return string
 */
function clpr_get_store_image_url( $id, $type = 'post_id', $width = 110 ) {
	$store_url = false;
	$store_image_id = false;

	$sizes = array( 75 => 'thumb-med', 110 => 'post-thumbnail', 150 => 'thumb-store', 160 => 'thumb-featured', 250 => 'thumb-large-preview' );
	$sizes = apply_filters( 'clpr_store_image_sizes', $sizes );

	if ( ! array_key_exists( $width, $sizes ) ) {
		$width = 110;
	}

	if ( ! isset( $sizes[ $width ] ) ) {
		$sizes[ $width ] = 'post-thumbnail';
	}

	if ( $type == 'term_id' && $id ) {
		$store_url = clpr_get_store_meta( $id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $id, 'clpr_store_image_id', true );
	}

	if ( $type == 'post_id' && $id ) {
		$term_id = appthemes_get_custom_taxonomy( $id, APP_TAX_STORE, 'term_id' );
		$store_url = clpr_get_store_meta( $term_id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $term_id, 'clpr_store_image_id', true );
	}

	if ( is_numeric( $store_image_id ) ) {
		$store_image_src = wp_get_attachment_image_src( $store_image_id, $sizes[ $width ] );
		if ( $store_image_src ) {
			return apply_filters( 'clpr_store_image', $store_image_src[0], $width, $id, $type );
		}
	}

	if ( ! empty( $store_url ) ) {
		$store_image_url = "http://s.wordpress.com/mshots/v1/" . urlencode( $store_url ) . "?w=" . $width;
		return apply_filters( 'clpr_store_image', $store_image_url, $width, $id, $type );
	} else {
		$store_image_url = apply_filters( 'clpr_store_default_image', appthemes_locate_template_uri( 'images/clpr_default.jpg' ), $width );
		return apply_filters( 'clpr_store_image', $store_image_url, $width, $id, $type );
	}

}


/**
 * Validates coupon expiration date.
 *
 * @param string $date
 *
 * @return bool
 */
function clpr_is_valid_expiration_date( $date ) {
	global $clpr_options;

	if ( empty( $date ) ) {
		return false;
	}

	// Year, month, day.
	if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date, $date_parts ) ) {
		return false;
	}

	// Month, day, year.
	if ( ! checkdate( $date_parts[2], $date_parts[3], $date_parts[1] ) ) {
		return false;
	}

	// + 24h, coupons expire in the end of day
	$timestamp = strtotime( $date ) + ( 24 * 3600 );
	if ( $clpr_options->prune_coupons && current_time( 'timestamp' ) > $timestamp ) {
		return false;
	}

	return true;
}


/**
 * Displays the printable coupon image associated to the coupon listing. Use only in loop.
 *
 * @param string $size (optional)
 * @param string $return (optional)
 *
 * @return void
 */
function clpr_get_coupon_image( $size = 'thumb-large', $return = 'html' ) {
	global $post;

	echo clpr_get_printable_coupon( $post->ID, $size, $return );
}


/**
 * Displays "email coupon to friend" social popup form.
 *
 * @return void
 */
function clpr_email_form() {

	if ( ! isset( $_GET['id'] ) || ! $post_id = absint( $_GET['id'] ) ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	$comment_author = '';
	$comment_author_email = '';
	$comment_author_url = '';

	if ( isset( $_COOKIE['comment_author_' . COOKIEHASH ] ) ) {
		$comment_author = apply_filters( 'pre_comment_author_name', $_COOKIE['comment_author_' . COOKIEHASH ] );
		$comment_author = stripslashes( $comment_author );
		$comment_author = esc_attr( $comment_author );
		$_COOKIE['comment_author_' . COOKIEHASH ] = $comment_author;
	}

	if ( isset( $_COOKIE['comment_author_email_' . COOKIEHASH ] ) ) {
		$comment_author_email = apply_filters( 'pre_comment_author_email', $_COOKIE['comment_author_email_' . COOKIEHASH ] );
		$comment_author_email = stripslashes( $comment_author_email );
		$comment_author_email = esc_attr( $comment_author_email );
		$_COOKIE['comment_author_email_' . COOKIEHASH ] = $comment_author_email;
	}

	if ( isset( $_COOKIE['comment_author_url_' . COOKIEHASH ] ) ) {
		$comment_author_url = apply_filters( 'pre_comment_author_url', $_COOKIE['comment_author_url_' . COOKIEHASH ] );
		$comment_author_url = stripslashes( $comment_author_url );
		$_COOKIE['comment_author_url_' . COOKIEHASH ] = $comment_author_url;
	}

	$template_name = 'form-social-email.php';
	$template_path = locate_template( $template_name );
	if ( ! $template_path ) {
		appthemes_display_notice( 'error', sprintf( __( 'Error: template "%s" not found.', APP_TD ), $template_name ) );
		die;
	}

	include $template_path;
	die;
}


/**
 * Handles sending share coupon email via AJAX.
 *
 * @return void
 */
function clpr_send_email_ajax() {

	nocache_headers();

	if ( ! isset( $_POST['post_ID'] ) || ! $post_id = absint( $_POST['post_ID'] ) ) {
		die( json_encode( array( 'success' => false, 'message' => __( 'Sorry, item does not exist.', APP_TD ) ) ) );
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		die( json_encode( array( 'success' => false, 'message' => __( 'Sorry, item does not exist.', APP_TD ) ) ) );
	}

	$errors = new WP_Error();

	$fields = array(
		'author',
		'email',
		'recipients',
		'message',
	);

	if ( isset( $_POST['checking'] ) ) {
		$fields[] = 'checking';
	}

	// Get (and clean) data
	foreach ( $fields as $field ) {
		$posted[ $field ] = isset( $_POST[ $field ] ) ? appthemes_clean( $_POST[ $field ] ) : '';
	}

	// Check required fields
	$required = array(
		'author' => __( 'Your Name', APP_TD ),
		'email' => __( 'Your Email', APP_TD ),
		'recipients' => __( 'Recipients', APP_TD ),
		'message' => __( 'Message', APP_TD ),
	);

	foreach ( $required as $field => $name ) {
		if ( empty( $posted[ $field ] ) ) {
			$errors->add( $field, sprintf( __( '<strong>ERROR</strong>: "%s" is a required field.', APP_TD ), $name ) );
		}
	}

	// check email
	if ( ! is_email( $posted['email'] ) ) {
		$errors->add( 'email', sprintf( __( '<strong>ERROR</strong>: "%s" is a invalid field.', APP_TD ), __( 'Your Email', APP_TD ) ) );
	}

	// check errors
	if ( $errors->get_error_codes() ) {
		die( json_encode( array( 'success' => false, 'message' => $errors->get_error_message() ) ) );
	}

	$from_name = $posted['author'];
	$from_email = $posted['email'];
	$the_message = $posted['message'];

	$recipients = explode( ',', $posted['recipients'] );
	$recipients = array_map( 'trim', $recipients );

	$link = get_permalink( $post_id );
	$blogname = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

	$results = array();

	foreach ( $recipients as $recipient ) {
		if ( ! is_email( $recipient ) ) {
			$results[ $recipient ]['success'] = false;
			$results[ $recipient ]['recipient'] = $recipient;
		} else {
			$subject = sprintf( __( '%1$s shared a coupon with you from %2$s', APP_TD ), $from_name, $blogname );

			$message  = html( 'p', __( 'Hi,', APP_TD ) ) . PHP_EOL;
			$message .= html( 'p', sprintf( __( '%s thought you might be interested in the following coupon.', APP_TD ), $from_name ) ) . PHP_EOL;
			$message .= html( 'p', sprintf( __( 'View coupon: %s', APP_TD ), html_link( $link ) ) ) . PHP_EOL;
			$message .= html( 'p', sprintf( __( 'Message: %s', APP_TD ), $the_message ) ) . PHP_EOL;
			$message .= html( 'p',
				__( 'Regards,', APP_TD ) . '<br />' .
				sprintf( __( 'Your %s Team', APP_TD ), $blogname ) . '<br />' .
				html_link( home_url( '/' ) )
			) . PHP_EOL;

			$email = array( 'to' => $recipient, 'subject' => $subject, 'message' => $message, 'from' => $from_email, 'from_name' => $from_name );
			$email = apply_filters( 'clpr_email_share_coupon', $email );

			APP_Mail_From::apply_once( array( 'email' => $email['from'], 'name' => $email['from_name'], 'reply' => true ) );
			appthemes_send_email( $email['to'], $email['subject'], $email['message'] );

			$results[ $recipient ]['success'] = true;
			$results[ $recipient ]['recipient'] = $recipient;
		}
	}

	die( json_encode( array( 'success' => true, 'items' => $results ) ) );
}


/**
 * Provides joins for expired coupon filters.
 *
 * @param string $join
 * @param object $wp_query
 *
 * @return string
 */
function clpr_expired_coupons_joins( $join, $wp_query ) {
	global $wpdb;

	if ( $wp_query->get( 'not_expired_coupons' ) || $wp_query->get( 'filter_unreliable' ) ) {
		$join .= " INNER JOIN $wpdb->postmeta AS exp1 ON ($wpdb->posts.ID = exp1.post_id) ";
		$join .= " INNER JOIN $wpdb->postmeta AS exp2 ON ($wpdb->posts.ID = exp2.post_id) ";

		// Only provide second join to queries that need it
		$join .= " INNER JOIN $wpdb->postmeta AS exp3 ON ($wpdb->posts.ID = exp3.post_id) ";
	}

	return $join;
}
add_filter( 'posts_join', 'clpr_expired_coupons_joins', 10, 2 );


/**
 * Filters out anything that isn't unreliable or expired.
 *
 * @param string $where
 * @param object $wp_query
 *
 * @return string
 */
function clpr_filter_unreliable_coupons( $where, $wp_query ) {

	if ( ! $wp_query->get( 'filter_unreliable' ) ) {
		return $where;
	}

	$not_zero = " ( exp1.meta_key = 'clpr_votes_down' AND CAST( exp1.meta_value AS SIGNED) NOT BETWEEN '0' AND '0' ) ";

	$low_percent = " ( exp2.meta_key = 'clpr_votes_percent' AND CAST( exp2.meta_value AS SIGNED ) BETWEEN '0' AND '50' ) ";

	$votes_match = " ( $low_percent AND $not_zero ) ";

	$expired = " ( exp3.meta_key = 'clpr_expire_date' AND exp3.meta_value < CURRENT_DATE() ) ";

	$not_empty = " ( exp3.meta_key = 'clpr_expire_date' AND exp3.meta_value != '' ) ";

	$expired_match = " ( $expired AND $not_empty ) ";

	$meta_matches = " ( $votes_match OR $expired_match )";

	$where .= " AND ( $meta_matches ) ";

	return $where;
}
add_filter( 'posts_where', 'clpr_filter_unreliable_coupons', 10, 2 );


/**
 * Filters out expired coupons.
 *
 * @param string $where
 * @param object $wp_query
 *
 * @return string
 */
function clpr_not_expired_coupons_filter( $where, $wp_query ) {

	if ( $wp_query->get( 'not_expired_coupons' ) ) {
		$where .= " AND ( (exp1.meta_key = 'clpr_expire_date' AND exp1.meta_value >= CURRENT_DATE()) OR ( exp1.meta_key = 'clpr_expire_date' AND exp1.meta_value = '') )";
	}

	return $where;
}
add_filter( 'posts_where', 'clpr_not_expired_coupons_filter', 10, 2 );


/**
 * Filters out non-expired coupons.
 *
 * @param string $where
 * @param object $wp_query
 *
 * @return string
 */
function clpr_expired_coupons_filter( $where, $wp_query ) {
	global $wpdb;

	if ( $wp_query->get( 'expired_coupons' ) ) {
		$where .= " AND ($wpdb->postmeta.meta_key = 'clpr_expire_date' AND $wpdb->postmeta.meta_value < CURRENT_DATE())";
	}

	return $where;
}
add_filter( 'posts_where', 'clpr_expired_coupons_filter', 10, 2 );


/**
 * Prunes expired coupons.
 *
 * @return void
 */
function clpr_coupon_prune() {
	global $clpr_options;

	$message = '';
	$links_list = '';
	$subject = __( 'Clipper Coupons Expired', APP_TD );

	if ( ! $clpr_options->prune_coupons ) {
		return;
	}

	// Get all coupons with an expired date that have expired
	$args = array(
		'post_type' => APP_POST_TYPE,
		'expired_coupons' => true,
		'posts_per_page' => -1,
		'fields' => 'ids',
		'no_found_rows' => true,
		'meta_query' => array(
			array(
				'key' => 'clpr_expire_date',
				'value' => '',
				'compare' => '!=',
			)
		)
	);
	$expired = new WP_Query( $args );

	if ( isset( $expired->posts ) && is_array( $expired->posts ) ) {
		foreach ( $expired->posts as $post_id ) {
			wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
			$links_list .= html( 'li', get_permalink( $post_id ) ) . PHP_EOL;
		}
	}

	$message .= html( 'p', __( 'Your cron job has run successfully. ', APP_TD ) ) . PHP_EOL;
	if ( empty( $links_list ) ) {
		$message .= html( 'p', __( 'No expired coupons were found.', APP_TD ) ) . PHP_EOL;
	} else {
		$message .= html( 'p', __( 'The following coupons expired and have been taken down from your website: ', APP_TD ) ) . PHP_EOL;
		$message .= html( 'ul', $links_list ) . PHP_EOL;
	}

	$message .= html( 'p', __( 'Regards,', APP_TD ) . '<br />' . __( 'Clipper', APP_TD ) ) . PHP_EOL;

	if ( $clpr_options->prune_coupons_email ) {
		$email = array( 'to' => get_option( 'admin_email' ), 'subject' => $subject, 'message' => $message );
		$email = apply_filters( 'clpr_email_admin_coupons_expired', $email );

		appthemes_send_email( $email['to'], $email['subject'], $email['message'] );
	}
}
add_action( 'clpr_coupon_prune', 'clpr_coupon_prune' );


/**
 * Schedules a daily event to prune coupons which have expired.
 *
 * @return void
 */
function clpr_schedule_coupon_prune() {
	if ( ! wp_next_scheduled( 'clpr_coupon_prune' ) ) {
		wp_schedule_event( time(), 'daily', 'clpr_coupon_prune' );
	}
}
add_action( 'init', 'clpr_schedule_coupon_prune' );


/**
 * Displays coupon type/code box.
 *
 * @param string $coupon_type (optional)
 *
 * @return void
 */
if ( ! function_exists( 'clpr_coupon_code_box' ) ) :
	function clpr_coupon_code_box( $coupon_type = null ) {
		global $post;

		if ( ! $post || $post->post_type != APP_POST_TYPE ) {
			return;
		}

		if ( ! $coupon_type ) {
			$coupon_type = clpr_get_coupon_type( $post->ID );
		}

		// display additional info if coupon is expired
		clpr_display_expired_info( $post->ID );

		get_template_part( 'content-codebox', $coupon_type );
	}
endif;


/**
 * Loads all page templates, setups cache, limits db queries.
 *
 * @return void
 */
function clpr_load_all_page_templates() {
	$pages = get_posts( array(
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'posts_per_page' => -1,
		'no_found_rows' => true,
	) );

}


/**
 * Updates post status.
 *
 * @param int $post_id
 * @param string $new_status
 *
 * @return void
 */
function clpr_update_post_status( $post_id, $new_status ) {
	wp_update_post( array(
		'ID' => $post_id,
		'post_status' => $new_status
	) );
}


/**
 * Deletes coupon listing.
 *
 * @param int $post_id
 *
 * @return bool
 */
function clpr_delete_coupon( $post_id ) {

	// delete post and it's revisions, comments, metadata, tax relations, etc.
	if ( wp_delete_post( $post_id, true ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Deletes all attachments associated to coupon listing.
 *
 * @param int $post_id
 *
 * @return bool
 */
function clpr_delete_coupon_attachments( $post_id ) {
	global $wpdb;

	if ( ! $post_id = absint( $post_id ) ) {
		return false;
	}

	if ( APP_POST_TYPE != get_post_type( $post_id ) ) {
		return false;
	}

	$attachment_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'attachment'", $post_id ) );

	// delete all associated attachments
	foreach ( $attachment_ids as $attachment_id ) {
		wp_delete_attachment( $attachment_id, true );
	}

	return true;
}
add_action( 'before_delete_post', 'clpr_delete_coupon_attachments' );


/**
 * Returns coupons which are marked as featured for slider.
 * @since 1.5
 *
 * @return object|bool A boolean False if no coupons found.
 */
function clpr_get_featured_slider_coupons() {
	global $clpr_options;

	$args = array(
		'post_type' => APP_POST_TYPE,
		'post_status' => array( 'publish', 'unreliable' ),
		'meta_key' => 'clpr_featured',
		'meta_value' => '1',
		'posts_per_page' => 15,
		'orderby' => 'rand',
		'no_found_rows' => true,
		'suppress_filters' => false,
	);

	if ( $clpr_options->exclude_unreliable_featured ) {
		$args['post_status'] = array( 'publish' );
	}

	$args = apply_filters( 'clpr_featured_slider_args', $args );

	$featured = new WP_Query( $args );

	if ( ! $featured->have_posts() ) {
		return false;
	}

	return $featured;
}


/**
 * Returns localized status if available.
 *
 * @param string $status
 *
 * @return string
 */
function clpr_get_status_i18n( $status ) {
	$statuses = array(
		'draft' => __( 'Draft', APP_TD ),
		'ended' => __( 'Ended', APP_TD ),
		'expired' => __( 'Expired', APP_TD ),
		'future' => __( 'Scheduled', APP_TD ),
		'live' => __( 'Live', APP_TD ),
		'live_expired' => __( 'Live-Expired', APP_TD ),
		'live_unreliable' => __( 'Live-Unreliable', APP_TD ),
		'offline' => __( 'Offline', APP_TD ),
		'pending' => __( 'Pending', APP_TD ),
		'pending_moderation' => __( 'Awaiting approval', APP_TD ),
		'pending_payment' => __( 'Awaiting payment', APP_TD ),
		'private' => __( 'Private', APP_TD ),
		'publish' => __( 'Published', APP_TD ),
		'trash' => __( 'Trash', APP_TD ),
		'unreliable' => __( 'Unreliable', APP_TD ),
	);

	$status = strtolower( $status );

	if ( array_key_exists( $status, $statuses ) ) {
		return $statuses[ $status ];
	} else {
		return ucfirst( $status );
	}
}


/**
 * Returns coupon listing status name.
 *
 * @param int $listing_id (optional)
 *
 * @return string
 */
function clpr_get_listing_status_name( $listing_id = 0 ) {
	global $clpr_options;

	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$listing = get_post( $listing_id );

	if ( clpr_is_listing_expired( $listing->ID ) ) {
		if ( in_array( $listing->post_status, array( 'publish', 'unreliable' ) ) && ! $clpr_options->prune_coupons ) {
			return 'live_expired';
		} else {
			return 'ended';
		}
	} else if ( $listing->post_status == 'draft' ) {
		return 'offline';
	} else if ( $listing->post_status == 'pending' ) {
		if ( clpr_have_pending_payment( $listing->ID ) ) {
			return 'pending_payment';
		} else {
			return 'pending_moderation';
		}
	} else if ( $listing->post_status == 'unreliable' ) {
		return 'live_unreliable';
	}

	return 'live';
}


/**
 * Creates terms list.
 * @since 1.5
 *
 * @param array $args (optional)
 *
 * @return string
 */
function clpr_terms_list( $args = array() ) {

	$defaults = array(
		'taxonomy' => 'category',
		'exclude' => array(),
		'menu' => true,
		'count' => true,
		'top_link' => true,
		'class' => 'terms',
	);

	$options = wp_parse_args( (array) $args, $defaults );
	$options = apply_filters( 'clpr_terms_list_args', $options );

	$terms = get_terms( $options['taxonomy'], array( 'hide_empty' => 0, 'child_of' => 0, 'pad_counts' => 0, 'app_pad_counts' => 1 ) );

	$navigation = '';
	$list = '';
	$groups = array();

	if ( empty( $terms ) || ! is_array( $terms ) ) {
		return html( 'p', __( 'Sorry, but no terms were found.', APP_TD ) );
	}

	// unset child terms
	foreach ( $terms as $key => $value ) {
		if ( $value->parent != 0 ) {
			unset( $terms[ $key ] );
		}
	}

	foreach ( $terms as $term ) {
		$letter = mb_strtoupper( mb_substr( $term->name, 0, 1 ) );
		if ( is_numeric( $letter ) ) {
			$letter = '#';
		}

		if ( ! empty( $letter ) ) {
			$groups[ $letter ][] = $term;
		}
	}

	if ( empty( $groups ) ) {
		return;
	}

	foreach ( $groups as $letter => $terms ) {
		$old_list = $list;
		$old_navigation = $navigation;
		$letter_items = false;

		$letter = apply_filters( 'the_title', $letter );
		$letter_id = ( preg_match( '/\p{L}/', $letter ) ) ? $letter : substr( md5( $letter ), 0, 5 ); // hash special chars
		$navigation .= html_link( '#' . $options['class'] . '-' . $letter_id, $letter );
		$top_link = ( $options['top_link'] ) ? html_link( '#top', __( 'Top', APP_TD ) . ' &uarr;' ) : '';

		$list .= '<h2 class="' . $options['class'] . '" id="' . $options['class'] . '-' . $letter_id . '">' . $letter . $top_link . '</h2>';
		$list .= '<ul class="' . $options['class'] . '">';

		foreach ( $terms as $term ) {
			if ( in_array( $term->term_id, $options['exclude'] ) ) {
				continue;
			}

			$letter_items = true;
			$name = apply_filters( 'the_title', $term->name );
			$link = html_link( get_term_link( $term, $options['taxonomy'] ), $name );
			$count = ( $options['count'] ) ? ' (' . intval( $term->count ) . ')' : '';

			$list .= html( 'li', $link . $count );
		}

		$list .= '</ul>';

		if ( ! $letter_items ) {
			$list = $old_list;
			$navigation = $old_navigation;
		}
	}

	$navigation = html( 'div class="grouplinks"', $navigation );

	if ( $options['menu'] ) {
		$list = $navigation . $list;
	}

	return $list;
}


/**
 * Creates categories list.
 * @since 1.5
 *
 * @return string
 */
function clpr_categories_list() {
	$args = array(
		'taxonomy' => APP_TAX_CAT,
		'class' => 'categories',
	);

	return clpr_terms_list( $args );
}


/**
 * Creates stores list.
 * @since 1.5
 *
 * @return string
 */
function clpr_stores_list() {
	$hidden_stores = clpr_hidden_stores();
	$args = array(
		'taxonomy' => APP_TAX_STORE,
		'exclude' => $hidden_stores,
		'class' => 'stores',
	);

	return clpr_terms_list( $args );
}


/**
 * Displays report coupon form.
 *
 * @param bool $echo (optional)
 *
 * @return string
 */
function clpr_report_coupon( $echo = false ) {
	global $post;

	$form = appthemes_get_reports_form( $post->ID, 'post' );
	if ( ! $form ) {
		return;
	}

	$content = '<li><div class="reports_wrapper"><div class="reports_form_link">';
	$content .= '<a href="#" class="problem">' . __( 'Report a Problem', APP_TD ) . '</a>';
	$content .= '</div></div></li>';
	$content .= '<li class="report">' . $form . '</li>';

	if ( $echo ) {
		echo $content;
	}

	return $content;
}


/**
 * Displays additional information if coupon is expired.
 *
 * @since 1.5
 *
 * @param int $post_id Post ID.
 *
 * @return void
 */
function clpr_display_expired_info( $post_id ) {
	// do not show on taxonomy pages, there is Unreliable section
	if ( is_tax() ) {
		return;
	}

	if ( ! clpr_is_listing_expired( $post_id ) ) {
		return;
	}

	echo html( 'div class="expired-coupon-info"', __( 'This offer has expired.', APP_TD ) );
}


/**
 * Displays coupon title or link - depend on settings.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_coupon_title() {
	global $clpr_options;

	if ( ! in_the_loop() ) {
		return;
	}

	if ( $clpr_options->link_single_page ) {
		$title = ( mb_strlen( get_the_title() ) >= 87 ) ? mb_substr( get_the_title(), 0, 87 ) . '...' : get_the_title();
		$title_attr = sprintf( esc_attr__( 'View the "%s" coupon page', APP_TD ), the_title_attribute( 'echo=0' ) );
		echo html( 'a', array( 'href' => get_permalink(), 'title' => $title_attr, 'rel' => 'bookmark' ), $title );
	} else {
		the_title();
	}
}


/**
 * Displays coupon content or content preview - depend on settings.
 *
 * @since 1.5
 *
 * @return void
 */
function clpr_coupon_content() {
	global $post, $clpr_options;

	if ( ! in_the_loop() ) {
		return;
	}

	if ( $clpr_options->link_single_page ) {
		$content = mb_substr( strip_tags( $post->post_content ), 0, 200 ) . '... ';
		$title_attr = sprintf( esc_attr__( 'View the "%s" coupon page', APP_TD ), the_title_attribute( 'echo=0' ) );
		echo $content . html( 'a', array( 'href' => get_permalink(), 'class' => 'more', 'title' => $title_attr ), __( 'more &rsaquo;&rsaquo;', APP_TD ) );
	} else {
		the_content();
	}
}


/**
 * Returns coupon tags for edit field.
 *
 * @param int $listing_id
 *
 * @return string
 */
function clpr_get_listing_tags_to_edit( $listing_id ) {
	$tags = '';

	if ( isset( $_POST[ APP_TAX_TAG ] ) ) {
		$tags = trim( $_POST[ APP_TAX_TAG ] );
	} else {
		$terms = get_the_terms( $listing_id, APP_TAX_TAG );
		if ( $terms ) {
			$tags = implode( ', ', wp_list_pluck( $terms, 'name' ) );
		}
	}

	return esc_attr( $tags );
}


/**
 * Adds Open Graph meta tags.
 *
 * @since 1.5.1
 */
class CLPR_Open_Graph extends APP_Open_Graph {

	/**
	 * Setups meta tags.
	 *
	 * @param array $args (optional)
	 *
	 * @return void
	 */
	public function __construct( $args = array() ) {

		if ( get_header_image() ) {
			$args['default_image'] = get_header_image();
		} else {
			$args['default_image'] = appthemes_locate_template_uri( 'images/logo.png' );
		}

		parent::__construct( $args );
	}

	/**
	 * Returns image url.
	 *
	 * @return string
	 */
	public function get_image_url() {
		$image_url = '';
		$queried_object = get_queried_object();

		if ( is_singular( APP_POST_TYPE ) ) {
			$image_url = clpr_get_store_image_url( $queried_object->ID, 'post_id', 250 );
		} else if ( is_tax( APP_TAX_STORE ) ) {
			$image_url = clpr_get_store_image_url( $queried_object->term_id, 'term_id', 250 );
		} else {
			$image_url = parent::get_image_url();
		}

		if ( empty( $image_url ) ) {
			$image_url = $this->args['default_image'];
		}

		return $image_url;
	}

}


/**
 * Generates unique ID for coupons.
 * @since 1.5.1
 *
 * @return string
 */
function clpr_generate_id() {
	$id = uniqid( rand( 10, 1000 ), false );

	if ( clpr_get_listing_by_ref( $id ) ) {
		return clpr_generate_id();
	}

	return $id;
}


/**
 * Retrieves listing data by given reference ID.
 * @since 1.5.1
 *
 * @param string $reference_id An listing reference ID.
 *
 * @return object|bool A listing object, boolean False otherwise.
 */
function clpr_get_listing_by_ref( $reference_id ) {

	if ( empty( $reference_id ) || ! is_string( $reference_id ) ) {
		return false;
	}

	$reference_id = appthemes_numbers_letters_only( $reference_id );

	$listing_q = new WP_Query( array(
		'post_type' => APP_POST_TYPE,
		'post_status' => 'any',
		'meta_key' => 'clpr_id',
		'meta_value' => $reference_id,
		'posts_per_page' => 1,
		'suppress_filters' => true,
		'no_found_rows' => true,
	) );

	if ( empty( $listing_q->posts ) ) {
		return false;
	}

	return $listing_q->posts[0];
}


/**
 * Returns an array of settings for WP Editor used on the frontend.
 * @since 1.5.1
 *
 * @return array An array of WP Editor settings.
 */
function clpr_get_editor_settings() {
	$settings = array(
		'wpautop' => true,
		'media_buttons' => false,
		'textarea_rows' => 10,
		'editor_class' => 'required',
		'teeny' => false,
		'dfw' => true,
		'tinymce' => true,
		'quicktags' => array(
			'buttons' => 'strong,em,ul,ol,li,link,close',
		),
	);

	return $settings;
}


/**
 * Displays coupon code popup.
 *
 * @since 1.5.1
 *
 * @return void
 */
function clpr_coupon_code_popup() {
	if ( 'GET' != $_SERVER['REQUEST_METHOD'] ) {
		appthemes_display_notice( 'error', __( 'Sorry, only get method allowed.', APP_TD ) );
		die;
	}

	$post_id = isset( $_GET['id'] ) ? (int) appthemes_numbers_only( $_GET['id'] ) : 0;
	if ( $post_id < 1 ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	$post = get_post( $post_id );
	if ( ! $post ) {
		appthemes_display_notice( 'error', __( 'Sorry, item does not exist.', APP_TD ) );
		die;
	}

	if ( $post->post_type != APP_POST_TYPE ) {
		appthemes_display_notice( 'error', __( 'Sorry, wrong item type.', APP_TD ) );
		die;
	}

	$coupon_type = clpr_get_coupon_type( $post->ID );
	if ( $coupon_type != 'coupon-code' ) {
		appthemes_display_notice( 'error', __( 'Sorry, wrong item type.', APP_TD ) );
		die;
	}

	$coupon_code = wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) );

	$template_name = 'form-popup-coupon-code.php';
	$template_path = locate_template( $template_name );
	if ( ! $template_path ) {
		appthemes_display_notice( 'error', sprintf( __( 'Error: template "%s" not found.', APP_TD ), $template_name ) );
		die;
	}

	include $template_path;
	die;
}


/**
 * Retrieves Listing object.
 *
 * @param int $listing_id (optional)
 *
 * @return object|bool A boolean False on failure.
 */
function clpr_get_listing_obj( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();

	$listing = get_post( $listing_id );

	if ( ! $listing ) {
		return false;
	}

	$category = clpr_get_first_term( $listing->ID, APP_TAX_CAT );
	$listing->category_id = ( $category ) ? $category->term_id : false;

	$store = clpr_get_first_term( $listing->ID, APP_TAX_STORE );
	$listing->store_id = ( $store ) ? $store->term_id : false;

	$type = clpr_get_first_term( $listing->ID, APP_TAX_TYPE );
	$listing->type_id = ( $type ) ? $type->term_id : false;

	// Clear the default 'Auto Draft' title
	if ( $listing->post_title == __( 'Auto Draft' ) ) {
		$listing->post_title = '';
	}

	return $listing;
}


/**
 * Returns coupon listing CTR.
 *
 * @param int $listing_id (optional)
 *
 * @return string
 */
function clpr_get_coupon_ctr( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();

	$views = (int) get_post_meta( $listing_id, 'clpr_total_count', true );
	$clicks = (int) get_post_meta( $listing_id, 'clpr_coupon_aff_clicks', true );

	if ( $views > 0 ) {
		$ctr = ( $clicks / $views * 100 );
	} else {
		$ctr = 0;
	}

	return number_format_i18n( $ctr, 2 ) . '%';
}


/**
 * Returns coupon listing type.
 *
 * @param int $listing_id (optional)
 *
 * @return string
 */
function clpr_get_coupon_type( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$type = clpr_get_first_term( $listing_id, APP_TAX_TYPE );

	if ( ! $type ) {
		return '';
	}

	return $type->slug;
}


/**
 * Returns coupon listing store name.
 *
 * @param int $listing_id (optional)
 *
 * @return string
 */
function clpr_get_coupon_store_name( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$store = clpr_get_first_term( $listing_id, APP_TAX_STORE );

	if ( ! $store ) {
		return '';
	}

	return $store->name;
}


/**
 * Returns coupon listing category name.
 *
 * @param int $listing_id (optional)
 *
 * @return string
 */
function clpr_get_coupon_category_name( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$category = clpr_get_first_term( $listing_id, APP_TAX_CAT );

	if ( ! $category ) {
		return '';
	}

	return $category->name;
}


/**
 * Returns the first taxonomy term for an coupon listing.
 *
 * @param int $listing_id
 * @param string $taxonomy
 *
 * @return object|bool
 */
function clpr_get_first_term( $listing_id, $taxonomy ) {
	$terms = get_the_terms( $listing_id, $taxonomy );

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return false;
	}

	return reset( $terms );
}


/**
 * Returns the first taxonomy term link for an coupon listing.
 *
 * @param int $listing_id
 * @param string $taxonomy
 *
 * @return object|bool
 */
function clpr_get_first_term_link( $listing_id, $taxonomy ) {
	$terms = get_the_terms( $listing_id, $taxonomy );

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return false;
	}
	$term = reset( $terms );

	return get_term_link( $term, $taxonomy );
}


/**
 * Prints HTML with meta information for attachments.
 *
 * @return void
 */
function clpr_attachment_entry_meta() {
	if ( ! is_attachment() ) {
		return;
	}

	$parts = array();
	$separator = '<span class="meta-sep"> | </span>';

	if ( get_the_author() ) {
		$parts['author'] = sprintf( '<span class="byline">%1$s <span class="author vcard"><a class="url fn n" href="%2$s" title="%3$s" rel="author">%4$s</a></span></span>',
			__( 'By:', APP_TD ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all coupons by %s', APP_TD ), get_the_author() ),
			get_the_author()
		);
	}

	$time_string = sprintf( '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="entry-date updated" datetime="%3$s">%4$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	$parts['date'] = sprintf( __( '<span class="posted-on">%1$s %2$s</span>', APP_TD ),
		__( 'Uploaded:', APP_TD ),
		$time_string
	);

	if ( wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		$parts['image-size'] = sprintf( '<span class="full-size-link">%1$s <a href="%2$s">%3$s &times; %4$s</a></span>',
			__( 'Full size:', APP_TD ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	} else {
		$attached_file = get_attached_file( get_the_ID() );
		if ( file_exists( $attached_file ) ) {
			$file_size = size_format( filesize( $attached_file ) );
			$file_type = wp_check_filetype( wp_basename( get_the_guid() ) );

			$parts['file-type'] = sprintf( '<span class="file-type">%1$s %2$s</span>',
				__( 'File type:', APP_TD ),
				strtoupper( $file_type['ext'] )
			);

			$parts['file-size'] = sprintf( '<span class="file-size">%1$s %2$s</span>',
				__( 'File size:', APP_TD ),
				$file_size
			);
		}
	}

	if ( current_user_can( 'edit_others_posts' ) ) {
		$parts['edit-link'] = sprintf( '<span class="edit-link"><a href="%1$s">%2$s</a></span>',
			get_edit_post_link( get_the_ID() ),
			__( 'Edit', APP_TD )
		);
	}

	echo implode( $separator, $parts );
}

