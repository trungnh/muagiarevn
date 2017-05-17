<?php  
   global $post ;
   $count = 0;
   $query_args = array('post_type' => 'sh_testimonials' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['coupons_category'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $excerpt = ( $excerpt ) ? $excerpt : 20;
   $query = new WP_Query($query_args) ;  
   $ext = explode( ',', $extras );     //printr($ext);
   ob_start() ;?>

  <section class="clients">
    <div class="container"> 
      
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title);?></h3>
      </div>
       <?php if($query->have_posts()):  ?>
      <ul class="row">
        
        <!--======= CLIENTS WORD =========-->
        				 <?php while($query->have_posts()): $query->the_post();
						global $post ; 
						$post_meta = _WSH()->get_meta();
					
						  ?>
            <li class="col-md-4">
          <div class="clients-in">
           <p> <?php echo _sh_trim(get_the_content(), $excerpt);?></p>
          </div>
          <div class="clients-detail">
            <div class="avatar"> <?php the_post_thumbnail('86x86'); ?>
              <h6><?php the_title(); ?></h6>
              <?php if(in_array('designation', $ext)):?>
              	<p><?php echo sh_set($post_meta,'designation');?></p> 
			  <?php endif;?> 
            </div>
          </div>
        </li>
        <?php endwhile; 
		wp_reset_query();?>
       
      </ul>
      <?php endif; ?>
    </div>
  </section>

<?php return ob_get_clean();