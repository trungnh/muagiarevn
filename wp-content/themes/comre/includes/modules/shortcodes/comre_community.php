<?php  
   global $post ;
   $count = 0;
   $query_args = array('post_type' => 'sh_services' , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['services_category'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $query = new WP_Query($query_args) ; 
	//$ext = explode( ',', $extras );   
   ob_start() ;?>

<div class="core-com">
  <h4 class="text-center text-uppercase"><?php echo $title;?></h4>
  <p><?php echo $subtitle;?></p>
  <div class="com-img"> 
  <img class="img-responsive" src="<?php echo wp_get_attachment_url( $fimage, 'full' ); ?>" alt="" > </div>

  <?php if($query->have_posts()):  ?>

  <div class="com-feature">
	<h4 class="text-uppercase"><?php echo $title2;?></h4>
	<ul>
	  <?php while($query->have_posts()): $query->the_post();
						global $post ; 
						$service_meta = _WSH()->get_meta();
				  ?>
	  <!--======= SECTION =========-->
	  <li>
		<div class="row">
		  <div class="col-xs-1"> <i class="fa <?php echo sh_set($service_meta, 'fontawesome');?>"></i> </div>
		  <div class="col-xs-11">
			<h6><?php the_title();?></h6>
			<p><?php echo _sh_trim(get_the_excerpt(), $text_limit);?></p>
		  </div>
		</div>
	  </li>
	  
	  <?php endwhile;?>
	  
	</ul>
  </div>
  <?php endif;?>
</div>

<?php return ob_get_clean();