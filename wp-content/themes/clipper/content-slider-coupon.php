<?php
/**
 * Slider Coupon Listings loop content.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<li>

	<div class="image">

		<a href="<?php the_permalink(); ?>"><img src="<?php echo clpr_get_store_image_url( $post->ID, 'post_id', 160 ); ?>" alt="" /></a>

	</div>

	<?php appthemes_before_post_title( 'slider' ); ?>

	<span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>

	<?php appthemes_after_post_title( 'slider' ); ?>

</li>

