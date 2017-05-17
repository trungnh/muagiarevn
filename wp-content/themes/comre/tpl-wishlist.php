<?php /** Template Name: Wishlist */

$options = _WSH()->option();
//wp_enqueue_script( array( 'jquery-flexslider' ) );
get_header(); 
$settings  = sh_set(sh_set(get_post_meta(get_the_ID(), 'sh_page_meta', true) , 'sh_page_options') , 0);
$meta = _WSH()->get_meta('_sh_layout_settings');
$meta1 = _WSH()->get_meta('_sh_header_settings');
$meta2 = _WSH()->get_meta();

$bg = sh_set($meta1, 'bg_image');
$title = sh_set( $meta1, 'header_title' ); 
_WSH()->page_settings = $meta;

$layout = sh_set( $meta, 'layout', 'full' );
if( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) $sidebar = ''; else
$sidebar = sh_set( $meta, 'sidebar', 'product-sidebar' );
$classes = ( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) ? '  col-sm-12' : ' col-sm-9';

 // Header Code ?>

<!--======= BANNER =========-->

<section class="sub-banner" <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>>
	<div class="overlay">
		<div class="container">
			<h2>
				<?php if($title) echo  balanceTags( $title ); else wp_title('');?>
			</h2>
			<?php echo get_the_breadcrumb();?>
		</div>
	</div>
</section>

<section class="white-wrapper clearfix padding-top padding-bottom blog">
            <div class="container">
                <div class="row">
			<?php if( $layout == 'left' ): ?>
	
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="sidebar">        
				
					<?php if(is_active_sidebar($sidebar)) dynamic_sidebar( $sidebar ); ?>
				
				</div>
	
			<?php endif; ?>
        
			<div id="content" class="shop_wrapper<?php echo esc_attr($classes); ?> col-sm-12 col-xs-12 woocommerce">
				
				<?php while( have_posts() ): the_post(); ?>
					<?php the_content();?>
				<?php endwhile;?>
				
				<?php if( is_user_logged_in() ): 

					$meta = get_user_meta( $current_user->ID, '_ja_product_wishlist', true );//printr($meta);
					$meta = array_filter( (array)$meta );?>
						   
					<div class="single-page">
						<table class="cart_table table table-hover">
							
							<thead style="text-align:center;">
								<tr>
									<th><?php esc_html_e('PRODUCT', 'comre'); ?></th>
									<th><?php esc_html_e('PRICE', 'comre'); ?></th>
									<th><?php esc_html_e('ACTION', 'comre'); ?></th>
                                    <th><?php esc_html_e('DELETE', 'comre'); ?></th>
								</tr>
							</thead>
							
							<?php
							foreach( (array)$meta as $met ): $post = get_post( $met );//printr($post);
								$product = new WC_Product( $post ); //printr(get_product( $post ))?>
								<tbody>
									<tr>
										<td>
											<?php echo get_the_post_thumbnail( $met, array(65, 65), array('class'=>'img-responsive alignleft', 'width'=>65) ); ?>
		
		
											<a class="cart_title" href="<?php echo get_permalink( $met ); ?>" title="<?php echo esc_attr(get_the_title( $met )); ?>"><?php echo get_the_title( $met ); ?></a>
										</td>
										<td><?php echo balanceTags($product->get_price_html()); ?></td>
										<td><?php woocommerce_template_loop_add_to_cart(); ?></td>
										<td class="wishlist_delete">
											<a class="remove" rel="product_del_wishlist" data-id="<?php echo esc_attr($met); ?>" href="javascript:;"><?php esc_html_e('Delete', 'comre'); ?></a>
										</td>
									</tr>
								</tbody>
							<?php endforeach; ?>
							
							
						</table>
					</div>
				<?php else: ?>
				
					<?php $acc_page = get_option('user_account_url'); ?>
					<h2><?php printf(__('To view this page sign in at <a href="%s" title="Account Page">Account Page</a>', 'comre'), $acc_page); ?></h2>
				<?php endif; ?>
			
			</div>
        
			<?php if( $layout == 'right' ): ?>
	
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="sidebar">        
				
					<?php if(is_active_sidebar($sidebar)) dynamic_sidebar( $sidebar ); ?>
				
				</div>
	
			<?php endif; ?>
			
		</div>
    
    </div>
        
</section>
<?php get_footer(); ?>