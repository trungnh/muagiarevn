<?php


/**


 * Shipping Calculator


 *


 * @author 		WooThemes


 * @package 	WooCommerce/Templates


 * @version     2.0.8


 */





if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() )


	return;


?>





<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>





<div class="col-md-6">


	<form class="shipping_calculato" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">


	


		<div class="widget-title">


            <h3><?php esc_html_e( 'Calculate Shipping', 'comre' ); ?></h3>


        </div>


        <div class="clearfix"></div>


        


		<div class="shipping-calculato-form box2">


	


			<p class="form-row form-row-wide">


				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state form-control" rel="calc_shipping_state">


					<option value=""><?php esc_html_e( 'Select a country&hellip;', 'comre' ); ?></option>


					<?php


						foreach( WC()->countries->get_shipping_countries() as $key => $value )


							echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';


					?>


				</select>


			</p>


	


			<p class="form-row form-row-wide">


				<?php


					$current_cc = WC()->customer->get_shipping_country();


					$current_r  = WC()->customer->get_shipping_state();


					$states     = WC()->countries->get_states( $current_cc );


	


					// Hidden Input


					if ( is_array( $states ) && empty( $states ) ) {


	


						?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'comre' ); ?>" /><?php


	


					// Dropdown Input


					} elseif ( is_array( $states ) ) {


	


						?><span>


							<select name="calc_shipping_state" class="form-control" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'comre' ); ?>">


								<option value=""><?php esc_html_e( 'Select a state&hellip;', 'comre' ); ?></option>


								<?php


									foreach ( $states as $ckey => $cvalue )


										echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' .  esc_html( $cvalue ).'</option>';


								?>


							</select>


						</span><?php


	


					// Standard Input


					} else {


	


						?><input type="text" class="input-text form-control" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_html_e( 'State / county', 'comre' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php


	


					}


				?>


			</p>


	


			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>


	


				<p class="form-row form-row-wide">


					<input type="text" class="input-text form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_html_e( 'City', 'comre' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />


				</p>


	


			<?php endif; ?>


	


			<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>


	


				<p class="form-row form-row-wide">


					<input type="text" class="input-text form-control" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_html_e( 'Postcode / Zip', 'comre' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />


				</p>


	


			<?php endif; ?>


	


			<p><button type="submit" name="calc_shipping" value="1" class="btn btn-primary"><?php esc_html_e( 'Update Totals', 'comre' ); ?></button></p>


	


			<?php wp_nonce_field( 'woocommerce-cart' ); ?>


		</div>


	</form>


</div>


<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>