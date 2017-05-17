<?php
/**
 * Coupon Code Box content - Printable Coupon.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<h5><?php _e( 'Code:', APP_TD ); ?></h5>

<div class="couponAndTip">

	<div class="link-holder">

		<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link" title="<?php _e( 'Click to Print', APP_TD ); ?>" target="_blank" data-clipboard-text="<?php _e( 'Print Coupon', APP_TD ); ?>"><span><?php _e( 'Print Coupon', APP_TD ); ?></span></a>

	</div> <!-- #link-holder -->

	<p class="link-popup"><span><?php _e( 'Click to print coupon', APP_TD ); ?></span></p>

</div><!-- /couponAndTip -->
