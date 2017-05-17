<?php
/**
 * Page search loop content template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div <?php post_class( 'item' ); ?> id="post-<?php echo $post->ID; ?>">

	<div class="box-c">
		
		<div class="box-holder">
			
			<div class="blog">

				<?php appthemes_before_post_title( 'search' ); ?>

				<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

				<?php appthemes_after_post_title( 'search' ); ?>

				<?php appthemes_before_post_content( 'search' ); ?>

				<p class="desc entry-content">
					<?php echo mb_substr( strip_tags( $post->post_content), 0, 200 ) . '... '; ?>
					<a class="more" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'View the %s page', APP_TD ), the_title_attribute( 'echo=0' ) ); ?>"><?php _e( 'more &rsaquo;&rsaquo;', APP_TD ); ?></a>
				</p>

				<?php appthemes_after_post_content( 'search' ); ?>

			</div>

			<div class="clear"></div>

		</div>

	</div>

</div>
