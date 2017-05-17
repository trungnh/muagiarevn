<?php
$options = _WSH()->option();
$header_style = sh_set( $options, 'header_style' );
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$meta = _WSH()->get_meta('_sh_layout_settings');
$layout = sh_set( $meta, 'layout', 'full' );
$sidebar = sh_set( $meta, 'sidebar', 'product-sidebar' );
$classes = ( !$layout || $layout == 'full' ) ? ' col-lg-12 col-md-12' : ' col-lg-9 col-md-9';
get_header( 'shop' ); ?>
	<?php //get_template_part( 'includes/modules/header/header', $header_style ); ?>

<section class="sub-banner">
	<div class="overlay">
		<div class="container">
			<h2><?php woocommerce_page_title(); ?></h2>
			<?php echo get_the_breadcrumb(); ?>
		</div>
	</div>
</section>
    
<section class="section-w clearfix" id="portfolio">
	<div class="container">
    	<div class="row">
                
				<?php if( $layout == 'left' ): ?>
		
                 <div class="pull-right col-md-3 col-sm-4 col-xs-12">
                        <div id="sidebar" class="clearfix">
						<?php dynamic_sidebar( $sidebar ); ?>
					</div>
                  </div>
		
				<?php endif; ?>
				<div class="<?php echo esc_attr($classes); ?>" id="content">
                	<div class="clearfix">
                        <div id="shop-page" class="row clearfix">
                
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>
                   <!-- <p class="post-meta"><?php //esc_html_e('Your Cart ', 'comre');?><a href="#">2 ITEM</a> Go to <a href="#">Checkout <i class="icon-right-thin"></i></a></p> -->
                   		<?php while ( have_posts() ) : the_post(); ?>
				
							<?php wc_get_template_part( 'content', 'single-product' ); ?>
				
						<?php endwhile; // end of the loop. ?>
					</div>
                    <hr />
					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?>
					</div>
                    
				<?php if( $layout == 'right' ): ?>
		
                     <div class="pull-right col-md-3 col-sm-4 col-xs-12">
                        <div id="sidebar" class="clearfix">
						<?php dynamic_sidebar( $sidebar ); ?>
						
						<?php
							/**
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							do_action( 'woocommerce_sidebar' );
						?>
					</div>
                    </div>
		
				<?php endif; ?>
		</div>
       </div>
	</div>
</section>	
<?php wp_enqueue_script(array( 'jquery-modernizr', 'jquery-glasscase', 'main_script'));?>
<script type="text/javascript"> 
jQuery(document).ready(function($) {
"use strict";
	jQuery('a[data-gal]').each(function() {
	jQuery(this).attr('rel', jQuery(this).data('gal'));
	});     
	jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',slideshow:false,overlay_gallery: false,theme:'dark_square',social_tools:false,deeplinking:false});
});
</script>
<?php get_footer( 'shop' ); ?>