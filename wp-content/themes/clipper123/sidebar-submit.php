<?php
/**
 * Submit Coupon Sidebar template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="sidebar">

	<?php appthemes_before_sidebar_widgets( 'submit' ); ?>

	<?php if ( ! dynamic_sidebar( 'sidebar_submit' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->

	<?php endif; ?>

	<?php appthemes_after_sidebar_widgets( 'submit' ); ?>

</div> <!-- #sidebar -->
