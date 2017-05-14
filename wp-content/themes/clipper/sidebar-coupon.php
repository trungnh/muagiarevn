<?php
/**
 * Coupon listing Sidebar template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="sidebar">

	<?php appthemes_before_sidebar_widgets( 'coupon' ); ?>

	<?php if ( ! dynamic_sidebar( 'sidebar_coupon' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->

	<?php endif; ?>

	<?php appthemes_after_sidebar_widgets( 'coupon' ); ?>

</div> <!-- #sidebar -->
