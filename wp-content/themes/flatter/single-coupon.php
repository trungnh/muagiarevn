<?php
/**
 * The Template for displaying all single coupons.
 *
 * @package AppThemes
 * @subpackage Clipper
 * @since 1.0
 */
 
global $clpr_options;
?>


<div id="content">

	<?php do_action( 'appthemes_notices' ); ?>

	<?php appthemes_before_loop(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php appthemes_stats_update( $post->ID ); //records the page hit ?>

			<?php clpr_status_update($post->ID, $post->post_status); //updates coupon status ?>

			<?php appthemes_before_post(); ?>

			<div <?php post_class( 'content-box' ); ?> id="post-<?php the_ID(); ?>">

				<div class="box-c">

					<div class="box-holder">

						<div class="blog">

							<?php appthemes_before_post_title(); ?>

							<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

							<?php appthemes_after_post_title(); ?>

							<div class="content-bar iconfix">
								<?php

								// Get the expiration date and format it for display
								$expire_date = get_post_meta( $post->ID, 'clpr_expire_date', true );
								if ( ! empty( $expire_date ) ) {
									$expire_date = __( ' - Hết hạn: ', APP_TD ) . '<time class="entry-date expired" datetime="' . clpr_get_expire_date( $post->ID, 'c' ) . '">' . clpr_get_expire_date( $post->ID, 'display' ) . '</time>';
								}

								?>
								<p class="meta">
									<span>
										<i class="fa fa-calendar"></i>
										<time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
										<time class="entry-date updated" datetime="<?php echo get_the_modified_date( 'c' ); ?>"><?php echo get_the_modified_date(); ?></time>
										<?php echo $expire_date; ?>
									</span>
									<span><?php echo get_the_term_list( $post->ID, APP_TAX_CAT, '<i class="fa fa-folder-open"></i>', '<span class="sep">, </span>', '' ); ?></span>
								</p>
								<p class="comment-count"><i class="fa fa-comments"></i><?php comments_popup_link( __( '0 Comments', APP_TD ), __( '1 Comment', APP_TD ), __( '% Comments', APP_TD ) ); ?></p>

							</div>

							<div class="head-box">

								<div class="store-holder">
									<div class="store-image">
										<a href="<?php echo clpr_get_first_term_link( $post->ID, APP_TAX_STORE ); ?>"><img src="<?php echo fl_get_store_image_url($post->ID, 'post_id', '180'); ?>" alt="" /></a>
									</div>
								</div>
								
								<div class="coupon-main">
								
									<?php fl_display_expired_info( $post->ID ); ?>
									
									<?php clpr_coupon_code_box(); ?>
									
									<div class="clear"></div>
									
									<div class="store-info">
										<?php echo get_the_term_list( $post->ID, APP_TAX_STORE, '<i class="icon-building"></i> ', ', ', '' ); ?>
									</div>
									
								</div> <!-- #coupon-main -->

								<?php clpr_vote_box_badge( $post->ID ); ?>

							</div> <!-- #head-box -->

							<div class="text-box">

								<h2><?php _e( 'Chi tiết', APP_TD ); ?></h2>

								<?php appthemes_before_post_content(); ?>

								<?php the_content(); ?>

								<?php clpr_edit_coupon_link(); ?>

								<?php clpr_reset_coupon_votes_link(); ?>

								<?php appthemes_after_post_content(); ?>

							</div>

							<div class="text-footer iconfix">
							
								<div class="tags"><?php if ( get_the_term_list( $post->ID, APP_TAX_TAG ) ) echo get_the_term_list( $post->ID, APP_TAX_TAG, '<i class="fa fa-tags"></i>' . __( 'Tags:', APP_TD ), ', ', '' ); ?></div>

								<?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) { ?>
									<div class="stats"><i class="fa fa-bar-chart"></i><?php appthemes_stats_counter( $post->ID ); ?></div>
								<?php } ?>

								<div class="clear"></div>

							</div>
							
							<div class="author vcard">
								<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a>
							</div>

							<div class="user-bar">

								<?php if (comments_open()) comments_popup_link( ('<span>' . __( 'Bình luận', APP_TD ) . '</span>'), ('<span>' . __( 'Bình luận', APP_TD ) . '</span>'), ('<span>' . __( 'Bình luận', APP_TD ) . '</span>'), 'btn', '' ); ?>

								<?php fl_social_share(); ?>
								
							</div> <!-- #user-bar -->

						</div> <!-- #blog -->

					</div> <!-- #box-holder -->

				</div> <!-- #box-c -->

			</div> <!-- #content-box -->

			<?php appthemes_after_post(); ?>

			<?php comments_template(); ?>

	<?php endwhile; ?>


		<?php appthemes_after_endwhile(); ?>


	<?php else: ?>


		<?php appthemes_loop_else(); ?>


		<div class="blog">

			<h3><?php _e( 'Sorry, no coupons yet.', APP_TD ); ?></h3>

		</div> <!-- #blog -->


	<?php endif; ?>

	<?php appthemes_after_loop(); ?>

</div> <!-- #content -->

<?php get_sidebar( 'coupon' ); ?>
