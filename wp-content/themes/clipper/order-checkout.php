<?php
/**
 * Order Checkout template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.4
 */
?>

<div id="content-fullwidth">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<div class="order-gateway">

					<?php
						process_the_order();
						// Retrieve updated order object
						$order = get_order(); 
						if ( in_array( $order->get_status(), array( APPTHEMES_ORDER_COMPLETED, APPTHEMES_ORDER_ACTIVATED ) ) ) {
							$redirect_to = get_post_meta( $order->get_id(), 'complete_url', true );
							echo html( 'a', array( 'href' => $redirect_to ), __( 'Continue', APP_TD ) );
							echo html( 'script', 'location.href="' . $redirect_to . '"' );
						}
					?>

				</div>

			</div>

		</div>

	</div>

</div>
