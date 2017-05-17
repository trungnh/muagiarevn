<?php
/**
 * Coupon Listing loop content template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */

global $clpr_options, $withcomments;

$withcomments = 1;
?>

<div <?php post_class( 'item' ); ?> id="post-<?php echo $post->ID; ?>">

	<div class="item-holder">

		<div class="store-holder">
			<div class="store-image">
				<a href="<?php echo clpr_get_first_term_link( $post->ID, APP_TAX_STORE ); ?>"><img src="<?php echo fl_get_store_image_url( $post->ID, 'post_id', '180' ); ?>" alt="" /></a>
			</div>
			<?php /*
			<div class="store-name">
				<?php //echo get_the_term_list( $post->ID, APP_TAX_STORE, ' ', ', ', '' ); ?>
			</div>
			*/?>
		</div>

		<div class="item-frame">

			<div class="item-panel">

				<div class="clear"></div>

				<?php appthemes_before_post_title(); ?>

				<h3 class="entry-title"><?php clpr_coupon_title(); ?></h3>

				<?php appthemes_after_post_title(); ?>

				<div class="content-holder">

					<?php appthemes_before_post_content(); ?>

					<p class="desc entry-content"><?php clpr_coupon_content(); ?></p>

					<?php appthemes_after_post_content(); ?>

				</div>

			</div> <!-- #item-panel -->

			<div class="clear"></div>

			<?php if( ! fl_get_option( 'fl_hide_loop_taxonomy' ) ) { ?>

				<div class="taxonomy">
					<?php echo get_the_term_list( $post->ID, APP_TAX_CAT, '<p class="category">' . __( 'Danh mục:', APP_TD ) . ' ', ', ', '</p>' ); ?>
					<?php echo get_the_term_list( $post->ID, APP_TAX_TAG, '<p class="tag">' . __( 'Tags:', APP_TD ) . ' ', ', ', '</p>' ); ?>
				</div>

			<?php } ?>

		</div> <!-- #item-frame -->

		<div class="item-actions">

			<?php clpr_vote_box_badge( $post->ID ); ?>

			<?php if( get_post_meta( $post->ID, 'clpr_expire_date', true ) ) { ?>
				<p class="time-left iconfix">
					<i class="fa fa-bell-o"></i>
					<time class="entry-date expired" datetime="<?php echo clpr_get_expire_date( $post->ID, 'c' ); ?>"><?php echo clpr_get_expire_date( $post->ID, 'display' ); ?></time>
					<time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
					<time class="entry-date updated" datetime="<?php echo get_the_modified_date( 'c' ); ?>"><?php echo get_the_modified_date(); ?></time>
				</p>
			<?php } ?>

			<?php fl_display_expired_info( $post->ID ); ?>

			<?php clpr_coupon_code_box(); ?>

		</div>

		<div class="item-footer">

			<ul class="social">

				<li class="stats">
					<?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) { ?>
						<i class="fa fa-bar-chart"></i>
						<?php appthemes_stats_counter( $post->ID );
					} ?>
				</li>

				<li>
					<i class="fa fa-share-square-o"></i><a class="share" href="#"><?php _e( 'Chia sẻ', APP_TD ); ?> </a>
					<?php get_template_part( 'share', 'loop' ); ?>
				</li>

				<li class="loop-comments"><?php fl_comments_popup_link( '<span></span> ' . __( 'Bình luận', APP_TD ), '<span>1</span> ' . __( 'Bình luận', APP_TD ), __( '<span>%</span> bình luận', APP_TD ), 'show-comments', '' ); // leave spans for ajax to work correctly ?></li>

				<?php clpr_report_coupon( false ); ?>

			</ul>

			<div id="comments-<?php echo $post->ID; ?>" class="comments-list">

				<p class="links">
					<i class="fa fa-pencil"></i>
					<?php if ( comments_open() ) fl_comments_popup_link( __( 'Bình luận', APP_TD ), __( 'Bình luận', APP_TD ), __( 'Bình luận', APP_TD ), 'mini-comments' ); else echo '<span class="closed">' . __( 'Comments closed', APP_TD ) . '</span>'; ?>
					<i class="fa fa-remove"></i>
					<?php fl_comments_popup_link( __( 'Đóng', APP_TD ), __( 'Đóng', APP_TD ), __( 'Đóng', APP_TD ), 'show-comments' ); ?>
				</p>

				<?php comments_template( '/comments-mini.php' ); ?>

			</div>

			<div class="author vcard">
				<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a>
			</div>

		</div>

	</div>

</div>

