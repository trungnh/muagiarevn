<?php
/**
 * Page Sidebar template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="sidebar">

	<?php appthemes_before_sidebar_widgets( 'page' ); ?>

	<?php if ( ! dynamic_sidebar( 'sidebar_page' ) ) : ?>

		<!-- no dynamic sidebar so don't do anything -->

	<?php endif; ?>

	<?php appthemes_after_sidebar_widgets( 'page' ); ?>

</div> <!-- #sidebar -->
