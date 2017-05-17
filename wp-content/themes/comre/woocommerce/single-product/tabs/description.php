<?php


/**


 * Description tab


 *


 * @author 		WooThemes


 * @package 	WooCommerce/Templates


 * @version     2.0.0


 */





if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly





global $post;





$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'comre' ) ) );


?>





<?php if ( $heading ): ?>


	<div class="mini-title">


		<h5><?php echo balanceTags($heading); ?></h5>


	</div>


<?php endif; ?>





<?php the_content(); ?>


