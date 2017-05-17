<?php

/**

 * Display single product reviews (comments)

 *

 * @author 		WooThemes

 * @package 	WooCommerce/Templates

 * @version     2.3.2

 */

global $product;

if ( ! defined( 'ABSPATH' ) )

	exit; // Exit if accessed directly

if ( ! comments_open() )

	return;

?>

<div id="reviews">

	<div id="comments" class="comments clearfix">

		<div class="mini-title">

			<h3><?php

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_rating_count() ) )

					printf( _n( '%s review for %s', '%s reviews for %s', $count, 'comre' ), $count, get_the_title() );

				else

					esc_html_e( 'Reviews', 'comre' );

			?></h3>

		</div>

		

		<?php if ( have_comments() ) : ?>

			<ul class="media-list">

				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>

			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :

				echo '<nav class="woocommerce-pagination">';

				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(

					'prev_text' => '&larr;',

					'next_text' => '&rarr;',

					'type'      => 'list',

				) ) );

				echo '</nav>';

			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'comre' ); ?></p>

		<?php endif; ?>

	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper">

			<div id="review_form">

				<?php

					$commenter = wp_get_current_commenter();

					

					$comment_form = array(

						'title_reply'          => have_comments() ? __( 'Leave a feedback', 'comre' ) : __( 'Be the first to review', 'comre' ) . ' &ldquo;' . get_the_title() . '&rdquo;',

						'title_reply_to'       => __( 'Leave a Reply to %s', 'comre' ),

						//'comment_notes_before' => '',

						'comment_notes_after'  => '',

						'fields'               => array(

							'author' => '<input id="author" class="form-control" placeholder="' . __( 'Name', 'comre' ) .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" />',

							'email'  => '<input id="email" class="form-control" placeholder="' . __( 'Email address', 'comre' ) .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" />',

						),

						'label_submit'  => __( 'Send Comment', 'comre' ),

						'logged_in_as'  => '',

						'comment_field' => ''

					);

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {

						$comment_form['comment_notes_before'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'comre' ) .'</label><select name="rating" id="rating">

							<option value="">' . __( 'Rate&hellip;', 'comre' ) . '</option>

							<option value="5">' . __( 'Perfect', 'comre' ) . '</option>

							<option value="4">' . __( 'Good', 'comre' ) . '</option>

							<option value="3">' . __( 'Average', 'comre' ) . '</option>

							<option value="2">' . __( 'Not that bad', 'comre' ) . '</option>

							<option value="1">' . __( 'Very Poor', 'comre' ) . '</option>

						</select></p>';

					}

					$comment_form['comment_field'] .= '<textarea id="comment" name="comment" class="form-control" placeholder="' . __( 'Enter your comment here...', 'comre' ) .'" cols="45" rows="8" aria-required="true"></textarea>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

				?>

			</div>

		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'comre' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>

</div>