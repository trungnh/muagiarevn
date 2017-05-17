<?php
/**
 * Free Listing Received Template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Thanks for Sharing!', APP_TD ); ?></h1>

				<div class="content-bar"></div>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<div class="text-holder">

						<p><?php _e( 'Your coupon has successfully been submitted.', APP_TD ); ?></p>

						<div class="pad75"></div>

					</div>

				</div>

			</div> <!-- #blog -->

		</div>

	</div>

</div>

<?php get_sidebar( 'submit' ); ?>
