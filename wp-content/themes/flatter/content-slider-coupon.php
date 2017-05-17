<?php
/**
 * Slider Coupon Listings loop content.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */

global $clpr_options;
?>

<li>

	<div class="wrapper">

		<div class="image">

			<a href="<?php echo clpr_get_first_term_link( $post->ID, APP_TAX_STORE ); ?>"><img src="<?php echo fl_get_store_image_url( $post->ID, 'post_id', '180' ); ?>" alt="" /></a>

		</div>

		<?php appthemes_before_post_title( 'slider' ); ?>

		<h3><?php fl_coupon_title( 40 ); ?></h3>

		<?php appthemes_after_post_title( 'slider' ); ?>

		<p class="store-name"><?php echo get_the_term_list($post->ID, APP_TAX_STORE, ' ', ', ', ''); ?></p>

		<?php if ( $clpr_options->link_single_page ) : ?>
			<a class="btn blue" href="<?php the_permalink(); ?>"><?php echo fl_get_option( 'fl_lbl_learn_more' ); ?></a>
		<?php else : ?>
			<?php clpr_coupon_code_box(); ?>
		<?php endif; ?>

	</div>

</li>

