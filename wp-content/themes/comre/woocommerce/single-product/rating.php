<?php

/**

 * Single Product Rating

 *

 * @author 		WooThemes

 * @package 	WooCommerce/Templates

 * @version     2.3.2

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )

	return;

$count   = $product->get_rating_count();

$average = $product->get_average_rating();

if ( $count > 0 ) : ?>

	<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><span><?php printf( _n( '%s customer review', '%s customer reviews', $count, 'comre' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?></span></a>				

	<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">

		<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'comre' ), $average ); ?>">

			<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">

				<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php esc_html_e( 'out of 5', 'comre' ); ?>

			</span>

		</div>

		

	</div>

<?php endif; ?>