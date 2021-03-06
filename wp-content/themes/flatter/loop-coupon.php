<?php
/**
 * The loop that displays the coupons.
 *
 * @package AppThemes
 * @subpackage Clipper
 *
 */
?>



<?php appthemes_before_loop(); ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php appthemes_before_post(); ?>
		
		<?php get_template_part( 'content', get_post_type() ); ?>
		
		<?php appthemes_after_post(); ?>

	<?php endwhile; ?>

	<?php appthemes_after_endwhile(); ?>

<?php else: ?>

	<?php appthemes_loop_else(); ?>

	<div class="blog">

		<h3><?php _e( 'Tìm mãi không thấy mã giảm giá nào :(', APP_TD ); ?></h3>

	</div> <!-- #blog -->

<?php endif; ?>

<?php appthemes_after_loop(); ?>

