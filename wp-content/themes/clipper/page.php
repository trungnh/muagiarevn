<?php
/**
 * The template for displaying pages.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="content">

	<?php appthemes_before_page_loop(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php appthemes_before_page(); ?>

			<?php get_template_part( 'content', get_post_type() ); ?>

			<?php appthemes_after_page(); ?>

		<?php endwhile; ?>

			<?php appthemes_after_page_endwhile(); ?>

	<?php else: ?>

		<?php appthemes_page_loop_else(); ?>

	<?php endif; ?>

	<?php appthemes_after_page_loop(); ?>

	<?php if ( comments_open() ) comments_template(); ?>

</div> <!-- #content -->

<?php get_sidebar( 'page' ); ?>
