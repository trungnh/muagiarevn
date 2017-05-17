<?php
/**
 * Pay for order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<form id="order_review" method="post">

	<table class="shop_table">

		<thead>

			<tr>

				<th class="product-name"><?php esc_html_e( 'Product', 'comre' ); ?></th>

				<th class="product-quantity"><?php esc_html_e( 'Qty', 'comre' ); ?></th>

				<th class="product-total"><?php esc_html_e( 'Totals', 'comre' ); ?></th>

			</tr>

		</thead>

		<tbody>

			<?php

			if ( sizeof( $order->get_items() ) > 0 ) :

				foreach ( $order->get_items() as $item ) :

					echo '

						<tr>

							<td class="product-name">' . $item['name'].'</td>

							<td class="product-quantity">' . $item['qty'].'</td>

							<td class="product-subtotal">' . $order->get_formatted_line_subtotal( $item ) . '</td>

						</tr>';

				endforeach;

			endif;

			?>

		</tbody>

		<tfoot>

		<?php

			if ( $totals = $order->get_order_item_totals() ) foreach ( $totals as $total ) :

				?>

				<tr>

					<th scope="row" colspan="2"><?php echo balanceTags($total['label']); ?></th>

					<td class="product-total"><?php echo balanceTags($total['value']); ?></td>

				</tr>

				<?php

			endforeach;

		?>

		</tfoot>

	</table>

	<div id="payment">

		<?php if ( $order->needs_payment() ) : ?>

		<h3><?php esc_html_e( 'Payment', 'comre' ); ?></h3>

		<ul class="payment_methods methods">

			<?php

				if ( $available_gateways = WC()->payment_gateways->get_available_payment_gateways() ) {

					// Chosen Method

					if ( sizeof( $available_gateways ) )

						current( $available_gateways )->set_current();

					foreach ( $available_gateways as $gateway ) {

						?>

						<li class="payment_method_<?php echo esc_attr($gateway->id); ?>">

							<input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

							<label for="payment_method_<?php echo esc_attr($gateway->id); ?>"><?php echo balanceTags($gateway->get_title()); ?> <?php echo balanceTags($gateway->get_icon()); ?></label>

							<?php

								if ( $gateway->has_fields() || $gateway->get_description() ) {

									echo '<div class="payment_box payment_method_' . $gateway->id . '" style="display:none;">';

									$gateway->payment_fields();

									echo '</div>';

								}

							?>

						</li>

						<?php

					}

				} else {

					echo '<p>' . __( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'comre' ) . '</p>';

				}

			?>

		</ul>

		<?php endif; ?>

		<div class="form-row">

			<?php wp_nonce_field( 'woocommerce-pay' ); ?>

			<?php

				$pay_order_button_text = apply_filters( 'woocommerce_pay_order_button_text', __( 'Pay for order', 'comre' ) );

				

				echo apply_filters( 'woocommerce_pay_order_button_html', '<input type="submit" class="btn btn-primary" id="place_order" value="' . esc_attr( $pay_order_button_text ) . '" data-value="' . esc_attr( $pay_order_button_text ) . '" />' );

			?>			

			<input type="hidden" name="woocommerce_pay" value="1" />

		</div>

	</div>

</form>

