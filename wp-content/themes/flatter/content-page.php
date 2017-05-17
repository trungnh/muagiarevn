<?php
/**
 * Page loop content template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div class="content-box">

	<div class="box-holder">

		<div class="blog">

			<?php appthemes_before_page_title(); ?>

			<h1><?php the_title(); ?></h1>

			<?php appthemes_after_page_title(); ?>

			<?php appthemes_before_page_content(); ?>

			<div class="text-box">

				<?php the_content(); ?>

			</div>

			<?php appthemes_after_page_content(); ?>

		</div> <!-- #blog -->

	</div> <!-- #box-holder -->

</div> <!-- #content-box -->
