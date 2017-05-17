<?php /**
 * The template for displaying the coupons in grid view.
 *
 * Override this template by copying it to comre-child/includes/modules/shortcodes/great_deals.php
 *
 * @author    WoWThemes
 * @package   Modules/Shortcodes
 * @version     1.0.0
 */

wp_enqueue_script(array('jquery-isotope')); 
$query_args = array('post_type' => 'product' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);

$cat = sh_set( $_GET, 'sort_by_category' );   
 
if( $cat ) $query_args['product_cat'] = $cat;
$query = new WP_Query($query_args);

$ext = explode( ',', $extras );  
$filteration = array();
$posts_data = '';

ob_start(); ?>


	<?php while( $query->have_posts() ): $query->the_post(); ?>
    
  <?php $terms = wp_get_post_terms( get_the_id(), 'product_cat' );
    $current_terms = array();
    foreach( $terms as $t ) {
    $filteration[$t->term_id] = '<li><a href="#" data-filter=".'.$t->slug.'">'.$t->name.'</a></li>'; 
    $current_terms[$t->term_id] = $t->slug;
  }
		if( $cat ) $filteration = array();?>
        
        <!--======= ITEM =========-->
        <li class="item store <?php echo implode(' ', $current_terms ); ?>">
          <div class="prod-item">
            <div class="top-brand"><?php the_post_thumbnail('114x42'); ?> 
              <div class="up-to"> <span>UP TO 2.5%</span> <span>CASHBACK</span> </div>
            </div>
            
            <!--======= ITEM IMAGE =========--> 
           <?php the_post_thumbnail('242x229',array('class'=>'img-responsive img-product')) ?>
            <h5><a href="<?php the_permalink();?>"> <?php the_title();?> </a></h5>
            
            <!--======= ITEM INFO =========-->
            <div class="items-info">
              <h5><?php woocommerce_template_loop_price();?> </h5>
              <span class="free-ship">FREE SHIPPING</span>
              <div class="clearfix"></div>
			  <?php if(sh_set($ext, 'shop_btn')):?>
              	<a href="<?php the_permalink();?>" class="btn"><?php esc_html_e('SHOP NOW', 'comre');?></a>
			  <?php endif;?>
			  </div>
          </div>
        </li>
    
    <?php endwhile; 
	wp_reset_query();
	$posts_data = ob_get_clean();	
	
ob_start();?>


 <!--======= PORTFOLIO =========-->
  <section id="portfolio">
    <div class="portfolio portfolio-filter"> 
      
      <!--======= PORTFOLIO ITEMS =========-->
      <div class="portfolio-wrapper">
        <div class="container"> 
          
          
          
          <!--======= PORTFOLIO FILTER =========-->
          <ul class="filter">
            <li><a class="active" href="#." data-filter="*"><?php esc_html_e('All  offers', 'comre'); ?></a></li>
            
            <?php if( $filteration )
			foreach( $filteration as $filter )
				echo balanceTags($filter);?>
            
            <li class="pull-right">
			 <?php $all_terms = get_terms( 'product_cat' ); 
			 
			 if( $all_terms ):?>
              <form action="<?php echo get_permalink();?>" id="product_sort_by_category">
				  <select name="sort_by_category">
				  	<option value=""><?php esc_html_e('All', 'comre');?></option>
				  	<?php foreach( $all_terms as $a_term ): ?>
						<option value="<?php echo $a_term->slug; ?>" <?php selected($a_term->slug, $cat); ?>><?php echo $a_term->name; ?></option>
					<?php endforeach; ?> 
					
				  </select>
			   </form>
			   <?php endif; ?>
            </li>
          </ul>
          
          <!--======= ITEMS =========-->
          <ul class="items">
  			<?php echo balanceTags( $posts_data ); ?>
          </ul>
          
          <!--======= PAGINATION =========-->
          <ul class="pagination">
            <li><a href="#."><i class="fa fa-angle-double-left"></i></a></li>
            <li><a href="#.">1</a></li>
            <li><a href="#.">2</a></li>
            <li><a href="#.">3</a></li>
            <li><a href="#."><i class="fa fa-angle-double-right"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  
<?php return ob_get_clean();