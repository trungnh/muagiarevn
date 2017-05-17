<?php
/**
 * Template Name: Categories Template
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.1
 */
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Browse by Coupon Category', APP_TD ); ?></h1>

				<div class="text-box">

					<?php echo clpr_categories_list(); ?>

				</div>

			</div> <!-- #blog -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

</div>

<?php get_sidebar( 'main' ); ?>
