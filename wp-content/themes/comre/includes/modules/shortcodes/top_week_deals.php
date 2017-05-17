<?php  
   global $post ;
   $count = 0;
   $query_args = array('post_type' => 'sh_coupons' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   //if( $cat ) $query_args['coupons_category'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $query = new WP_Query( $query_args );
   ob_start() ;?>
<section class="top-w-deal">
    <div class="container"> 
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title); ?></h3>
      </div>
      <ul class="row">
        
        <!--======= WEEK DEAL 1 =========-->
        						<?php while($query->have_posts()): $query->the_post();
								global $post ; 
								$post_meta = _WSH()->get_meta();
							    ?>
        
        <li>
          <div class="w-deal-in">
		  <img src="<?php echo sh_set($post_meta, 'small_image');?>" alt="" class="img-responsive" />
		  <?php //the_post_thumbnail('119x60',array('class'=>'img-responsive'));?> 
            <p><?php the_title(); ?></p>
            
            <!--======= HOVER DETAL =========-->
            <div class="w-over"> <a href="<?php the_permalink(); ?>"><?php esc_html_e('show deal', 'comre');?></a> </div>
          </div>
        </li>
        <?php endwhile;
		wp_reset_query(); ?>
         </ul>
    </div>
  </section>


<?php return ob_get_clean();