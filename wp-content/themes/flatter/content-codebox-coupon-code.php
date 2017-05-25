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
$coupon_type = clpr_get_first_term( $post->ID, APP_TAX_TYPE )->slug;

if ( $clpr_options->coupon_code_hide ) {
	$button_text = '<i class="fa fa-lock"></i>' . fl_get_option( 'fl_lbl_show_coupon' );
	$class = 'coupon-hidden';
} else {
	$class = $coupon_type;
	$button_text = wptexturize( get_post_meta( $post->ID, 'clpr_coupon_code', true ) );
}
?>

<div class="couponAndTip">

	<div class="link-holder">

		<a href="<?php echo clpr_get_coupon_out_url( $post ); ?>" id="coupon-link-<?php echo $post->ID; ?>" class="coupon-code-link btn <?php echo $class; ?>" title="<?php _e( 'Click để lấy mã', APP_TD ); ?>" target="_blank" data-coupon-nonce="<?php echo wp_create_nonce( 'popup_' . $post->ID ); ?>" data-coupon-id="<?php echo $post->ID; ?>" data-clipboard-text="<?php echo $coupon_code; ?>"><span><?php echo $button_text; ?></span></a>

	</div> <!-- #link-holder -->

	<p class="link-popup"><span class="link-popup-arrow"></span><span class="link-popup-inner"><?php _e( 'Click để lấy mã', APP_TD ); ?></span></p>

</div><!-- /couponAndTip -->
