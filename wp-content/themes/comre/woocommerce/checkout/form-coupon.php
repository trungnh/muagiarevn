<?php


/**


 * Checkout coupon form


 *


 * @author 		WooThemes


 * @package 	WooCommerce/Templates


 * @version     2.2


 */





if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





if ( ! WC()->cart->coupons_enabled() ) {


	return;


}





$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'comre' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'comre' ) . '</a>' );


wc_print_notice( $info_message, 'notice' );


?>





<form class="checkout_coupon" method="post" style="display:none">





	<p class="form-row form-row-first col-md-10">


		<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_html_e( 'Coupon code', 'comre' ); ?>" id="copon_code" value="" />


	</p>





	<p class="form-row form-row-last button-wrapper">


		<input type="submit" class="button btn btn-primary" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'comre' ); ?>" />


	</p>





	<div class="clear"></div>


</form>