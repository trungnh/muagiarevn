<?php
/**
 * 'Email to a Friend' Form Template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>

<div class="content-box comment-form">

	<div class="box-holder">

		<div class="post-box">

			<div class="head"><h3><?php _e( 'Email to a Friend:', APP_TD ); ?> &#8220;<?php echo get_the_title( $post->ID ); ?>&#8221;</h3></div>

			<div id="respond" class="email-wrap">

				<form action="/" method="post" id="commentform-<?php echo $post->ID; ?>" class="commentForm">

					<?php if ( is_user_logged_in() ) : global $user_identity; ?>

						<p><?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>.', APP_TD ), clpr_get_profile_url(), $user_identity ); ?> <a href="<?php echo clpr_logout_url( get_permalink( $post->ID ) ); ?>"><?php _e( 'Log out &raquo;', APP_TD ); ?></a></p>

					<?php endif; ?>

					<p>
						<label><?php _e( 'Your Name:', APP_TD ); ?></label>
						<input type="text" class="text required" name="author" id="author-<?php echo $post->ID; ?>" value="<?php echo esc_attr( $comment_author ); ?>" />
					</p>

					<p>
						<label><?php _e( 'Your Email:', APP_TD ); ?></label>
						<input type="email" class="text required email" name="email" id="email-<?php echo $post->ID; ?>" value="<?php echo esc_attr( $comment_author_email ); ?>" />
					</p>

					<p>
						<label><?php _e( 'Recipients Email:', APP_TD ); ?></label>
						<input type="text" class="text required email" name="recipients" id="recipients-<?php echo $post->ID; ?>" value="" />
					</p>

					<p>
						<label><?php _e( 'Your Message:', APP_TD ); ?></label>
						<textarea cols="30" rows="10" name="message" class="commentbox required" id="message-<?php echo $post->ID; ?>"></textarea>
					</p>

					<p>
						<button type="submit" class="send-email btn submit" id="submit-<?php echo $post->ID; ?>" name="submitted" value="submitted"><?php _e( 'Send Email', APP_TD ); ?></button>
						<input type='hidden' name='post_ID' value='<?php echo $post->ID; ?>' class='post_ID' />
						<input type='hidden' name='submitted' value='submitted' />
					</p>

					<?php do_action( 'comment_form', $post->ID ); ?>

				</form>

			</div>

		</div>

	</div>

</div>
