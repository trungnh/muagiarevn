<?php    
global $post ;
   $count = 0;
   $query_args = array('post_type' => 'sh_testimonials' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['testimonial_category'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $query = new WP_Query($query_args) ;   // printr($query);
   $ext = explode( ',', $extras );
   ob_start() ;?>
   
 <section class="clients with-bg" style="background-image: url('<?php echo wp_get_attachment_url( $bg, 'full' ); ?>');">
    <div class="overlay">
      <div class="container"> 
        
        <!--======= TITTLE =========-->
        <div class="tittle">
          <h3><?php echo balanceTags($title);?></h3>
        </div>
        
        <?php if($query->have_posts()):  ?>
        
        <ul class="row">
        
          <?php while($query->have_posts()): $query->the_post();
						global $post ; 
						$post_meta = _WSH()->get_meta();
						?>
          <!--======= CLIENTS WORD =========-->
          <li class="col-md-4">
            <div class="clients-in">
              <p><?php echo _sh_trim(get_the_excerpt(), $excerpt);?></p>
            </div>
            <div class="clients-detail">
              <div class="avatar"> <?php the_post_thumbnail('86x86');?>
                <h6><?php the_title();?></h6>
                <?php if(in_array('designation', $ext )):?>
                	<p><?php echo sh_set($post_meta, 'designation');?></p>
              	<?php endif;?>
              </div>
            </div>
          </li>
          
          <?php endwhile; ?>
          
        </ul>
        <?php endif;?>
      </div>
    </div>
  </section>
  
<?php return ob_get_clean();