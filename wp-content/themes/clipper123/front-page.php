<?php
/**
 * Template Name: Coupons Home Template
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.5
 */

// Featured Slider
if ( $clpr_options->featured_slider ) {
	get_template_part( 'featured' );
}

$post_status = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );
$posts_count = appthemes_count_posts( APP_POST_TYPE, $post_status );
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="head">

				<h2><?php _e( 'New Coupons', APP_TD ); ?></h2>

				<div class="counter"><?php printf( _n( 'There are currently %s active coupon', 'There are currently %s active coupons', $posts_count, APP_TD ), html( 'span', $posts_count ) ); ?></div>

			</div> <!-- #head -->

			<?php
				// show all coupons and setup pagination
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				query_posts( array( 'post_type' => APP_POST_TYPE, 'post_status' => $post_status, 'ignore_sticky_posts' => 1, 'paged' => $paged ) );
			?>

			<?php get_template_part( 'loop', 'coupon' ); ?>

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->

</div><!-- #container -->

<?php get_sidebar( 'home' ); ?>
