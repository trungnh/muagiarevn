<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="content">

	<?php get_template_part( 'loop' ); ?>

	<?php appthemes_advertise_content(); ?>

	<?php if ( comments_open() ) comments_template(); ?>

</div>

<?php get_sidebar( 'blog' ); ?>
