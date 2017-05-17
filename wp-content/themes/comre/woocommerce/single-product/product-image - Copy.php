<?php


/**


 * Single Product Image


 *


 * @author 		WooThemes


 * @package 	WooCommerce/Templates


 * @version     2.0.14


 */





if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





global $post, $woocommerce, $product;





?>





<?php /** Customized add to cart button */


$cart_button = apply_filters( 'woocommerce_loop_add_to_cart_link',


	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s"><i class="icon-cart"></i></a>',


		esc_url( $product->add_to_cart_url() ),


		esc_attr( $product->id ),


		esc_attr( $product->get_sku() ),


		esc_attr( isset( $quantity ) ? $quantity : 1 ),


		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',


		esc_attr( $product->product_type ),


		esc_html( $product->add_to_cart_text() )


	),


$product ); ?>

















		<?php


			if ( has_post_thumbnail() ) {


	


				$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );


				$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );


				$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', '600x720' ), array(


					'title' => $image_title


					) );


	


				$attachment_count = count( $product->get_gallery_attachment_ids() );


	


				if ( $attachment_count > 0 ) {


					$gallery = '[product-gallery]';


				} else {


					$gallery = '';


				}


	


				//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $post->ID );


	


			} else {


	


				//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'comre' ) ), $post->ID );


	


			}


		?>


		


		


		


	


	


	<ul id="glasscase" class="gc-start" >


		<?php do_action( 'woocommerce_product_thumbnails' ); ?>


	</ul>


