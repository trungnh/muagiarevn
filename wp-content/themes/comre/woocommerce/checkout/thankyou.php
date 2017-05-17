<?php


/**


 * Thankyou page


 *


 * @author 		WooThemes


 * @package 	WooCommerce/Templates


 * @version     2.2.0


 */





if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





if ( $order ) : ?>





	<?php if ( $order->has_status( 'failed' ) ) : ?>





		<p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'comre' ); ?></p>





		<p><?php


			if ( is_user_logged_in() )


				esc_html_e( 'Please attempt your purchase again or go to your account page.', 'comre' );


			else


				esc_html_e( 'Please attempt your purchase again.', 'comre' );


		?></p>





		<p>


			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'comre' ) ?></a>


			<?php if ( is_user_logged_in() ) : ?>


			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php esc_html_e( 'My Account', 'comre' ); ?></a>


			<?php endif; ?>


		</p>





	<?php else : ?>





		<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'comre' ), $order ); ?></p>





		<ul class="order_details">


			<li class="order">


				<?php esc_html_e( 'Order:', 'comre' ); ?>


				<strong><?php echo balanceTags($order->get_order_number()); ?></strong>


			</li>


			<li class="date">


				<?php esc_html_e( 'Date:', 'comre' ); ?>


				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>


			</li>


			<li class="total">


				<?php esc_html_e( 'Total:', 'comre' ); ?>


				<strong><?php echo balanceTags($order->get_formatted_order_total()); ?></strong>


			</li>


			<?php if ( $order->payment_method_title ) : ?>


			<li class="method">


				<?php esc_html_e( 'Payment method:', 'comre' ); ?>


				<strong><?php echo balanceTags($order->payment_method_title); ?></strong>


			</li>


			<?php endif; ?>


		</ul>


		<div class="clear"></div>





	<?php endif; ?>





	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>


	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>





<?php else : ?>





	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'comre' ), null ); ?></p>





<?php endif; ?>