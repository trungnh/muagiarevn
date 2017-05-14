<?php
/**
 * Order Summary template.
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

				<h1><?php _e( 'Order Summary', APP_TD ); ?></h1>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<div class="text-holder">

						<div class="order-summary">

							<?php the_order_summary(); ?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>
