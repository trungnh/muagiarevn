<?php
/**
 * Payment functions.
 *
 * @package Clipper\Payments
 * @author  AppThemes
 * @since   Clipper 1.5
 */


add_action( 'pending_to_publish', 'clpr_handle_moderated_transaction' );

add_action( 'appthemes_transaction_completed', 'clpr_handle_transaction_completed' );
add_action( 'appthemes_transaction_activated', 'clpr_handle_coupon_listing' );

add_action( 'appthemes_after_order_summary', 'clpr_payments_display_order_summary_continue_button' );
add_action( 'appthemes_purchase_fields', 'clpr_display_listing_price_field', 9 );


/**
 * Activates coupon listing order and redirects user to order summary.
 *
 * @param object $order
 *
 * @return void
 */
function clpr_handle_transaction_completed( $order ) {
	global $clpr_options;

	$coupon_id = _clpr_get_order_coupon_id( $order );
	if ( ! $coupon_id ) {
		return;
	}

	$order_url = $order->get_return_url();

	if ( ! $clpr_options->coupons_require_moderation ) {
		$order->activate();
		if ( ! is_admin() ) {
			if ( did_action( 'wp_head' ) ) {
				clpr_js_redirect( $order_url );
			} else {
				wp_redirect( $order_url );
			}
		}
		return;
	} else {
		// set coupon as pending
		wp_update_post( array(
			'ID' => $coupon_id,
			'post_status' => 'pending',
		) );

		if ( ! is_admin() ) {
			if ( did_action( 'wp_head' ) ) {
				clpr_js_redirect( $order_url );
			} else {
				wp_redirect( $order_url );
			}
		}
		return;
	}
}


/**
 * Handles moderated transaction.
 *
 * @param object $post
 *
 * @return void
 */
function clpr_handle_moderated_transaction( $post ) {

	if ( $post->post_type != APP_POST_TYPE ) {
		return;
	}

	$orders_post = _appthemes_orders_get_connected( $post->ID );
	if ( ! $orders_post->posts ) {
		return;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || $order->get_status() !== APPTHEMES_ORDER_COMPLETED ) {
		return;
	}

	add_action( 'save_post', 'clpr_activate_moderated_transaction', 11 );
}


/**
 * Activates moderated transaction.
 *
 * @param int $post_id
 *
 * @return void
 */
function clpr_activate_moderated_transaction( $post_id ) {

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts ) {
		return;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || $order->get_status() !== APPTHEMES_ORDER_COMPLETED ) {
		return;
	}

	$order->activate();
}


/**
 * Processes coupon listing activation on order activation.
 *
 * @param object $order
 *
 * @return void
 */
function clpr_handle_coupon_listing( $order ) {

	foreach ( $order->get_items( CLPR_COUPON_LISTING_TYPE ) as $item ) {
		// publish coupon
		wp_update_post( array(
			'ID' => $item['post_id'],
			'post_status' => 'publish',
		) );
	}

}


/**
 * Returns associated listing ID for given order, false if not found.
 *
 * @param object $order
 *
 * @return int|bool
 */
function _clpr_get_order_coupon_id( $order ) {
	foreach ( $order->get_items( CLPR_COUPON_LISTING_TYPE ) as $item ) {
		return $item['post_id'];
	}

	return false;
}


/**
 * Prints an redirect button and javascript.
 *
 * @param string $url
 * @param string $message (optional)
 *
 * @return void
 */
function clpr_js_redirect( $url, $message = '' ) {
	if ( empty( $message ) ) {
		$message = __( 'Continue', APP_TD );
	}

	echo html( 'a', array( 'href' => $url ), $message );
	echo html( 'script', 'location.href="' . $url . '"' );
}


/**
 * Checks if payments are enabled on site.
 *
 * @return bool
 */
function clpr_payments_is_enabled() {
	global $clpr_options;

	if ( ! current_theme_supports( 'app-payments' ) || ! current_theme_supports( 'app-price-format' ) ) {
		return false;
	}

	if ( ! $clpr_options->charge_coupons || ! is_numeric( $clpr_options->coupon_price ) ) {
		return false;
	}

	return true;
}


/**
 * Checks if post have some pending payment orders.
 *
 * @param int $post_id
 *
 * @return bool
 */
function clpr_have_pending_payment( $post_id ) {

	if ( ! clpr_payments_is_enabled() ) {
		return false;
	}

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts ) {
		return false;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order || ! in_array( $order->get_status(), array( APPTHEMES_ORDER_PENDING, APPTHEMES_ORDER_FAILED ) ) ) {
		return false;
	}

	return true;
}


/**
 * Returns url of order connected to given Post ID.
 *
 * @param int $post_id
 *
 * @return string
 */
function clpr_get_order_permalink( $post_id ) {

	if ( ! clpr_payments_is_enabled() ) {
		return;
	}

	$orders_post = _appthemes_orders_get_connected( $post_id );
	if ( ! $orders_post->posts ) {
		return;
	}

	$order = appthemes_get_order( $orders_post->post->ID );
	if ( ! $order ) {
		return;
	}

	return get_permalink( $order->get_id() );
}


/**
 * Returns order gateway name.
 *
 * @param object $order
 *
 * @return string
 */
function clpr_get_order_gateway_name( $order ) {

	if ( ! clpr_payments_is_enabled() ) {
		return;
	}

	$gateway_id = $order->get_gateway();

	if ( ! empty( $gateway_id ) ) {
		$gateway = APP_Gateway_Registry::get_gateway( $gateway_id );
		if ( $gateway ) {
			$gateway_name = $gateway->display_name( 'admin' );
		} else {
			$gateway_name = __( 'Unknown', APP_TD );
		}
	} else {
		$gateway_name = __( 'Undecided', APP_TD );
	}

	return $gateway_name;
}


/**
 * Displays ordered items.
 *
 * @param object $order
 *
 * @return void
 */
function clpr_display_ordered_items( $order ) {

	if ( ! clpr_payments_is_enabled() ) {
		return;
	}

	$items = $order->get_items();

	foreach ( $items as $item ) {
		if ( ! APP_Item_Registry::is_registered( $item['type'] ) ) {
			$item_title = __( 'Unknown', APP_TD );
		} else {
			$item_title = APP_Item_Registry::get_title( $item['type'] );
		}
		echo html( 'div', $item_title );
	}

}


/**
 * Adds coupon listing price into submission form.
 * @since 1.4
 *
 * @return void
 */
function clpr_display_listing_price_field() {
	global $clpr_options;

	$price = appthemes_get_price( $clpr_options->coupon_price );
?>
	<li id="coupon-listing-fee">
		<label><?php _e( 'Listing Fee', APP_TD ); ?></label>
		<p class="info"><?php printf( __( '%s for submitting coupon.', APP_TD ), $price ); ?></p>
	</li>
<?php
}


/**
 * Displays Continue button on order summary page.
 *
 * @return void
 */
function clpr_payments_display_order_summary_continue_button() {

	$url = '';
	$text = '';

	$step = _appthemes_get_step_from_query();
	if ( ! is_singular( APPTHEMES_ORDER_PTYPE ) && ( ! empty( $step ) && 'order-summary' !== $step ) ) {
		return;
	}

	$order = get_order();

	if ( $listing_id = _clpr_get_order_coupon_id( $order ) ) {
		$url = get_permalink( $listing_id );
		$text = __( 'Continue to coupon', APP_TD );
	}

	if ( $url && $text ) {
		if ( ! in_array( $order->get_status(), array( APPTHEMES_ORDER_PENDING, APPTHEMES_ORDER_FAILED ) ) ) {
			echo html( 'p', __( 'Your order has been completed.', APP_TD ) );
		}
		echo html( 'button', array( 'type' => 'submit', 'class' => 'btn', 'onClick' => "location.href='" . $url . "';return false;" ), $text );
	}
}

