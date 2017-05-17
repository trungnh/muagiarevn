<?php
/**
 * Coupon Code Box content - Coupon Code.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
global $clpr_options;

$coupon_code = wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) );
$button_text = ( $clpr_options->coupon_code_hide ) ? __( 'Show Coupon Code', APP_TD ) : $coupon_code;
?>

<h5><?php _e( 'Code:', APP_TD ); ?></h5>

<div class="couponAndTip">

	<div class="link-holder">

		<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link" title="<?php _e( 'Click to copy &amp; open site', APP_TD ); ?>" target="_blank" data-clipboard-text="<?php echo $coupon_code; ?>"><span><?php echo $button_text; ?></span></a>

	</div> <!-- #link-holder -->

	<p class="link-popup"><span><?php _e( 'Click to copy &amp; open site', APP_TD ); ?></span></p>

</div><!-- /couponAndTip -->
