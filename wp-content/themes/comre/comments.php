<?php


/**


 * The template for displaying Comments.


 *


 * The area of the page that contains comments and the comment form.


 *


 * @package WordPress


 * @subpackage Twenty_Thirteen


 * @since Twenty Thirteen 1.0


 */


/*


 * If the current post is protected by a password and the visitor has not yet


 * entered the password we will return early without loading the comments.


 */


if ( post_password_required() )


	return;


?>


<div itemscope itemtype="http://schema.org/Comment" id="comments-single" class="comments clearfix">


	<?php if ( have_comments() ) : ?>


	


		<div class="widget-title">


         <h3><span class="divider"></span> <?php esc_html_e('Comments', 'comre');?></h3>


            <p><?php esc_html_e('Your feedbacks very important for us!', 'comre');?></p>


        </div><!-- end section title -->


        <div class="clearfix"></div>


        


		<div class="comments_wrapper clearfix">


			


			<ul class="media-list">


				<?php


					wp_list_comments( array(


						'style'       => 'ul',


						'short_ping'  => true,


						'avatar_size' => 74,


						'callback'=>'sh_list_comments'


					) );


				?>


			</ul><!-- .comment-list -->


		</div>


		<?php


			// Are there comments to navigate through?


			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :


		?>


		<nav class="navigation comment-navigation" role="navigation">


			<h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'comre' ); ?></h1>


			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'comre' ) ); ?></div>


			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'comre' ) ); ?></div>


		</nav><!-- .comment-navigation -->


		<?php endif; // Check for comment navigation ?>


		<?php if ( ! comments_open() && get_comments_number() ) : ?>


		<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'comre' ); ?></p>


		<?php endif; ?>


	<?php endif; // have_comments() ?>


		<div class="contact-widget clearfix">


			<?php sh_comment_form(); ?>


        </div>    


</div><!-- #comments -->


