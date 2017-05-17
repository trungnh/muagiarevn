<?php
/**
 * Post search loop content template.
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

		<div class="item-frame">

			<div class="item-panel">

				<?php appthemes_before_post_title( 'search' ); ?>

				<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

				<?php appthemes_after_post_title( 'search' ); ?>

				<?php appthemes_before_post_content( 'search' ); ?>

				<p class="desc entry-content">
					<?php echo mb_substr( strip_tags( $post->post_content ), 0, 200 ) . '... '; ?>
					<a class="more" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'View the %s post', APP_TD ), the_title_attribute( 'echo=0' ) ); ?>"><?php _e( 'more &rsaquo;&rsaquo;', APP_TD ); ?></a>
				</p>

				<?php appthemes_after_post_content( 'search' ); ?>

			</div> <!-- #item-panel -->

			<div class="clear"></div>

			<div class="calendar">
				<ul>
					<li class="create"><time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time></li>
					<li class="modify"><time class="entry-date updated" datetime="<?php echo get_the_modified_date( 'c' ); ?>"><?php echo get_the_modified_date(); ?></time></li>
				</ul>
			</div>

			<div class="taxonomy">
				<span class="folder"><?php the_category( ', ' ); ?></span>
			</div>

		</div> <!-- #item-frame -->

		<div class="item-footer">

			<ul class="social">

				<li class="stats"><?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) appthemes_stats_counter( $post->ID ); ?></li>
				<li><a class="share" href="#"><?php _e( 'Chia sẻ', APP_TD ); ?></a>

					<div class="drop">

					<?php
						// assemble the text and url we'll pass into each social media share link
						$social_text = urlencode( strip_tags( get_the_title() . ' ' . __( 'post from', APP_TD ) . ' ' . get_bloginfo( 'name' ) ) );
						$social_url	= urlencode( get_permalink( $post->ID ) );
					?>

						<ul>
							<li><a class="mail" href="#" data-id="<?php echo $post->ID; ?>" rel="nofollow"><?php _e( 'Email to Friend', APP_TD ); ?></a></li>
							<li><a class="facebook" href="javascript:void(0);" onclick="window.open('http://www.facebook.com/sharer.php?t=<?php echo $social_text; ?>&amp;u=<?php echo $social_url; ?>','doc', 'width=638,height=500,scrollbars=yes,resizable=auto');" rel="nofollow"><?php _e( 'Facebook', APP_TD ); ?></a></li>
							<li><a class="twitter" href="http://twitter.com/home?status=<?php echo $social_text; ?>+-+<?php echo $social_url; ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
							<li><a class="digg" href="http://digg.com/submit?phase=2&amp;url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Digg', APP_TD ); ?></a></li>
							<li><a class="reddit" href="http://reddit.com/submit?url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Reddit', APP_TD ); ?></a></li>
						</ul>

					</div>

				</li>

				<li><?php clpr_comments_popup_link( '<span></span> ' . __( 'Bình luận', APP_TD ), '<span>1</span> ' . __( 'Bình luận', APP_TD ), __( '<span>%</span> bình luận', APP_TD ), 'show-comments' ); // leave spans for ajax to work correctly ?></li>

			</ul>

			<div id="comments-<?php echo $post->ID; ?>" class="comments-list">

				<p class="links">
					<span class="pencil"></span>
					<?php if ( comments_open() ) clpr_comments_popup_link( __( 'Bình luận', APP_TD ), __( 'Bình luận', APP_TD ), __( 'Bình luận', APP_TD ), 'mini-comments' ); else echo '<span class="closed">' . __( 'Comments closed', APP_TD ) . '</span>'; ?>
					<span class="minus"></span>
					<?php clpr_comments_popup_link( __( 'Đóng', APP_TD ), __( 'Đóng', APP_TD ), __( 'Đóng', APP_TD ), 'show-comments' ); ?>
				</p>

				<?php comments_template( '/comments-mini.php' ); ?>

			</div>

			<div class="author vcard">
				<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a>
			</div>

		</div>

	</div>

</div>
