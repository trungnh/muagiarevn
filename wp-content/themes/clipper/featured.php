<?php
/**
 * Featured coupons slider template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>

<?php appthemes_before_loop( 'slider' ); ?>

<?php if ( $featured = clpr_get_featured_slider_coupons() ) : ?>

	<div class="featured-slider">

		<div class="gallery-t">&nbsp;</div>

		<div class="gallery-c">

			<div class="gallery-holder">

				<div class="prev"></div>

				<div class="slide">

					<div class="slide-contain">

						<ul class="slider">

							<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

								<?php appthemes_before_post( 'slider' ); ?>

								<?php get_template_part( 'content-slider', get_post_type() ); ?>

								<?php appthemes_after_post( 'slider' ); ?>

							<?php endwhile; ?>

							<?php appthemes_after_endwhile( 'slider' ); ?>

						</ul>

					</div>

				</div>

				<div class="next"></div>

			</div>

		</div>

		<div class="featured-button">

			<span class="button-l">&nbsp;</span>

			<h1><?php _e( 'Featured Coupons', APP_TD ); ?></h1>

			<span class="button-r">&nbsp;</span>

		</div>

		<div class="gallery-b">&nbsp;</div>

	</div>

<?php endif; ?>

<?php appthemes_after_loop( 'slider' ); ?>

<?php wp_reset_postdata(); ?>
