<?php
/**
 * Post loop content template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div <?php post_class( 'content-box' ); ?> id="post-<?php the_ID(); ?>">

	<div class="box-holder">

		<div class="blog">

			<?php appthemes_before_blog_post_title(); ?>

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php appthemes_after_blog_post_title(); ?>

			<?php appthemes_before_blog_post_content(); ?>

			<div class="text-box">

				<?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>

				<?php the_content( '<p>' . __( 'Continue reading &raquo;', APP_TD ) . '</p>' ); ?>

				<?php edit_post_link( __( 'Edit Post', APP_TD ), '<p class="edit">', '</p>' ); ?>

			</div>

			<?php appthemes_after_blog_post_content(); ?>

		</div>

	</div>

</div>
