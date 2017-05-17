<?php
/**
 * Coupon Code Box content - Printable Coupon.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div class="couponAndTip">

	<div class="link-holder">

		<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link btn printable-coupon" title="<?php _e( 'Click to Print', APP_TD ); ?>" target="_blank" data-coupon-nonce="<?php echo wp_create_nonce( 'popup_' . $post->ID ); ?>" data-coupon-id="<?php echo $post->ID; ?>" data-clipboard-text="<?php echo fl_get_option( 'fl_lbl_print_coupon' ); ?>"><span><i class="fa fa-print"></i><?php echo fl_get_option( 'fl_lbl_print_coupon' ); ?></span></a>

	</div> <!-- #link-holder -->

	<p class="link-popup"><span class="link-popup-arrow"></span><span class="link-popup-inner"><?php _e( 'Click to print coupon', APP_TD ); ?></span></p>

</div><!-- /couponAndTip -->
