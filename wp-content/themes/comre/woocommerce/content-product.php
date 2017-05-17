<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;
// Increase loop count
$woocommerce_loop['loop']++;
// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first1';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last1';
$classes[] = 'item';
$meta = _WSH()->get_meta('_sh_layout_settings', get_option( 'woocommerce_shop_page_id' ));
$layout = sh_set( $meta, 'layout', 'full' );
$layout = sh_set( $_GET, 'layout' ) ? $_GET['layout'] : $layout;
if( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) $classes[] = 'col-lg-3 col-md-3 col-sm-3 col-xs-12'; else $classes[] = 'col-lg-4 col-md-4 col-sm-4 col-xs-12'; 
$attachment_ids = $product->get_gallery_attachment_ids();
?>
<li class="item">
	
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<?php /** Customized add to cart button */
	$cart_button = apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="price a1 %s product_type_%s"><i class="icon-cart"></i></a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			esc_attr( $product->product_type ),
			esc_html( $product->add_to_cart_text() )
		),
	$product ); ?>
	
		<div class="prod-item">
			<div class="top-brand"><?php the_post_thumbnail('114x42'); ?> 
				<div class="up-to"> <span>UP TO 2.5%</span> <span>CASHBACK</span> </div>
			</div>

			<!--======= ITEM IMAGE =========--> 
			<?php the_post_thumbnail('242x229',array('class'=>'img-responsive img-product')) ?>
			<h5><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"> <?php the_title();?> </a></h5>

			<!--======= ITEM INFO =========-->
			<div class="items-info">
				<h5><?php woocommerce_template_loop_price();?></h5>
				<span class="free-ship">FREE SHIPPING</span>
				<div class="clearfix"></div>
				
				<a href="<?php the_permalink();?>" class="btn"><?php esc_html_e('SHOP NOW', 'comre');?></a>
				
			</div>
		</div>
	
	
	<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
		
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>
