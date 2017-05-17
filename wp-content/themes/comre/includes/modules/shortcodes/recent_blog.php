<?php  
   global $post ;
   $count = 0;
   $excerpt = ( $excerpt ) ? $excerpt : 20;
   $query_args = array('post_type' => 'post' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['category_name'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $query = new WP_Query($query_args) ; 
   
   ob_start() ;?>

  <section class="blog">
    <div class="container"> 
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title);?></h3>
      </div>
      
      <!--======= BLOG ROW =========-->
  <?php if($query->have_posts()):  ?>
  
      <ul class="row">
        
        <!--======= BLOG 1 =========-->
        
        <?php while($query->have_posts()): $query->the_post();
			global $post ; 
			$post_meta = _WSH()->get_meta();
		?>

        <li class="col-sm-4">
          <div class="b-img"> <?php the_post_thumbnail('371x252', array('class'=>'img-responsive'));?>
            <div class="b-over animated pulse"> <a href="<?php the_permalink();?>"><i class="fa fa-search"></i> </a> </div>
          </div>
          <div class="b-details">
            <h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
            <ul class="tag-info">
            
              <li> <i class="fa fa-camera"></i>
               	<?php /* for categories without anchor*/ $term_list = wp_get_post_terms(get_the_id(), 'category', array("fields" => "names")); ?>
                         <?php echo implode( ', ', (array)$term_list );?>	
               <span> / </span> </li>
              <li> <i class="fa fa-user"></i><?php esc_html_e(' By ', 'comre');?><?php the_author();?> <span> / </span></li>
              <li><i class="fa fa-comments"></i> <?php comments_number();?> </li>
            </ul>
            <?php if(!$extras == 'exc_status'):?>
            <p><?php echo _sh_trim(get_the_content(), $excerpt);?></p>
          	<?php endif;?>
          </div>
        </li>
        
        <?php endwhile
		;
		wp_reset_query();?>
        
      </ul>
      
      <?php endif; ?>
    
    </div>
  </section>


<?php return ob_get_clean();