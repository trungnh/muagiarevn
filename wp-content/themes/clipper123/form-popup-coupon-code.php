<?php
/**
 * Coupon Code Popup Form Template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div class="content-box comment-form coupon-code-popup">

	<div class="box-holder">

		<div class="post-box">

			<div class="head"><h3><?php printf( __( 'Your %s coupon code:', APP_TD ), get_the_term_list( $post->ID, APP_TAX_STORE, ' ', ', ', '' ) ); ?></h3></div>

			<div id="respond">

				<div class="popup-code-copy">
					<div class="text"><?php echo esc_attr( $coupon_code ); ?></div>
					<button id="copy-button" class="btn submit" data-clipboard-text="<?php echo esc_attr( $coupon_code ); ?>" ><?php _e( 'Copy', APP_TD ); ?></button>
				</div>

				<div class="popup-code-info">
					<p><?php _e( 'Paste this code at checkout when you are done shopping.', APP_TD ); ?></p>
					<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" title="<?php _e( 'Click to open site', APP_TD ); ?>" target="_blank" ><?php _e( 'Open site', APP_TD ); ?></a>
				</div>

				<?php do_action( 'clpr_coupon_code_popup', $post->ID ); ?>

			</div>

		</div>

	</div>

</div>
