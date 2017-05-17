<?php //wp_enqueue_script(array('jquery', 'owl-carousel'));
   $count = 0;
   $term_args = array('hide_empty' => $empty , 'number' => $num , 'order_by' => $sort , 'order' => $order);
   //if( $cat ) $query_args['category_name'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $terms = get_terms( 'product_cat', $term_args) ; 
   //printr($terms);
   ob_start() ;?>
 <!--======= FEATURED CATEGORIES =========-->
<section class="featured by-cate">
<div class="container"> 
  <!--======= TITTLE =========-->
  <div class="tittle">
	<h3><?php echo balanceTags($title);?></h3>
  </div>
  
  <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ):?>
  
  <ul class="row"> 
	 <?php foreach ( $terms as $term ) :
			$meta = _WSH()->get_term_meta( '_sh_product_cat_settings', $term->term_id );//printr($meta);
		?>
	<!--======= CATEGORIES =========-->
		<li class="col-sm-3">
		  <div class="cate-in">
		  <?php   $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ); ?>
			<div class="cate"> <?php echo wp_get_attachment_image( $thumbnail_id, 'full' ); ?>
			  <div class="cate-over"> <i class="fa <?php echo esc_attr(sh_set($meta, 'product_icon'));?>"></i>
				<div class="after-over animated flipInY">
				  <p><?php echo sprintf( _n( '1 coupon inside', '%s coupons inside', $term->count, 'comre'), $term->count );?></p>
				  <a href="<?php echo esc_url(get_term_link($term, 'product_cat'));?>"><?php esc_html_e('SHOP NOW', 'comre');?></a> </div>
			  </div>
			  <!--======= TITTLE =========-->
			  <div class="cate-tittle"> <?php echo balanceTags($term->name);?> </div>
			</div>
		  </div>
		</li>
		
		<?php endforeach;?>
</ul>

<?php endif;?>

</div>
</section>
  
<?php return ob_get_clean();