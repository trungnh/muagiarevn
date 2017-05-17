	<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce; ?>
<section class="white-wrapper clearfix">
    <div class="container">
        <div class="row">
            <div id="content" class="col-md-12 col-sm-12 col-xs-12">
				<div class="single-page">
<?php
wc_print_notices();
do_action( 'woocommerce_before_cart' ); ?>
<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="order-form">
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="product-name"><?php esc_html_e( 'Product', 'comre' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Price', 'comre' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'comre' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Total', 'comre' ); ?></th>
					<th class="product-remove">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<td class="product-name">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
									if ( ! $_product->is_visible() )
										echo balanceTags($thumbnail);
									else
										printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
								?>
								<?php
									if ( ! $_product->is_visible() )
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
									else
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );
									// Meta data
									echo WC()->cart->get_item_data( $cart_item );
		               				// Backorder notification
		               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
		               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'comre' ) . '</p>';
								?>
							</td>
							<td class="product-price">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
							</td>
							<td class="product-quantity">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input( array(
											'input_name'  => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											'min_value'   => '0'
										), $_product, false );
									}
									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
								?>
							</td>
							<td class="product-subtotal">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								?>
							</td>
							
							<td class="product-remove">
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'comre' ) ), $cart_item_key );
								?>
							</td>
							
						</tr>
						<?php
					}
				}
				do_action( 'woocommerce_cart_contents' );
				?>
				<tr>
					<td colspan="6" class="actions">
						<?php if ( WC()->cart->coupons_enabled() ) { ?>
							<div class="coupon">
								<label for="coupon_code"><?php esc_html_e( 'Coupon', 'comre' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_html_e( 'Coupon code', 'comre' ); ?>" /> <input type="submit" class="btn btn-primary" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'comre' ); ?>" />
								<?php do_action('woocommerce_cart_coupon'); ?>
							</div>
						<?php } ?>
						<input type="submit" class="btn btn-primary pull-right" name="update_cart" value="<?php esc_html_e( 'Update Cart', 'comre' ); ?>" /> <input type="submit" class="checkout-button btn btn-primary alt wc-forward pull-right" name="proceed" value="<?php esc_html_e( 'Proceed to Checkout', 'comre' ); ?>" />
						<?php //do_action( 'woocommerce_proceed_to_checkout' ); ?>
						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
					</td>
				</tr>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>
	</div>
<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
<hr />
<div class="clearfix"></div>
<div class="row calculate">
	<div class="cart-collaterals">
		<div class="padding-top">
			<?php woocommerce_cart_totals(); ?>
		
			<?php woocommerce_shipping_calculator(); ?>
	        <div class="clearfix"></div>
	        
			<?php //do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
