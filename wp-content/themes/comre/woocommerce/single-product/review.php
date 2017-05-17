<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>

<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<a class="pull-left" href="#">

        	<?php $email = sh_set( $comment, 'comment_author_email' ); ?>

            <img class="img-circle media-object" src="<?php echo get_gravatar_url( $email ); ?>" alt="avatar" />

        </a>

		<div class="media-body">

        	<h4 class="media-heading"><?php comment_author(); ?>

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

				<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'comre' ), $rating ) ?>">

					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo balanceTags($rating); ?></strong> <?php esc_html_e( 'out of 5', 'comre' ); ?></span>

				</span>

			<?php endif; ?>

            </h4>

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<p class="meta"><em><?php esc_html_e( 'Your comment is awaiting approval', 'comre' ); ?></em></p>

			<?php else : ?>

			<?php endif; ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>

		</div>

	</div>

