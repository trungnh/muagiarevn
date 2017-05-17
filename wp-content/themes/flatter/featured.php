<?php
/**
 * The featured slider on the home page
 *
 */
?>

<?php appthemes_before_loop( 'slider' ); ?>

<?php if ( $featured = clpr_get_featured_slider_coupons() ) : ?>

<div class="featured-slider">
	
	<div class="head">
		
		<h2><?php _e( 'Mã giảm giá nổi bật', APP_TD ); ?></h2>
	
	</div>

    <div class="gallery-c">

        <div class="gallery-holder">
		
			<div class="link-l">

				<a href="#" class="prev">&nbsp;</a>

			</div>

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
			
			 <div class="link-r">

				<a href="#" class="next">&nbsp;</a>

			</div>


        </div>

    </div>

</div>

<?php endif; ?>

<?php appthemes_after_loop( 'slider' ); ?>

<?php wp_reset_postdata(); ?>