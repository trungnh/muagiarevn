<?php    
global $post ;
   $count = 0;
   $query_args = array('post_type' => 'sh_team' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   if( $cat ) $query_args['team_category'] = $cat;
   //echo balanceTags($cat); exit('sssss');
   $query = new WP_Query($query_args) ;   // printr($query);
   $ext = explode( ',', $extras );
   ob_start() ;?>


 
  <section id="team">
    <div class="container"> 
      
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title); ?></h3>
      </div>
      
      <?php if($query->have_posts()):  ?>
      <!--======= TEAM MEMBER 1 =========-->
      <div class="row">
        <div class="col-md-6">
          <ul class="row">
            <?php while($query->have_posts()): $query->the_post();
						global $post ; 
						$post_meta = _WSH()->get_meta();
						?>
                        <?php if(($count%2) == 0 && $count != 0):?>
                            </ul></div><div class="col-md-6"><ul class="row">
                        <?php endif; ?>
                                 
            <li class="col-sm-6">
              <div class="team"> 
                
                <!--======= HOVER DETAIL =========-->
                <div class="img"><?php the_post_thumbnail('270x270')?>
                  <h5><?php the_title(); ?></h5>
                  <?php if(in_array('designation', $ext )):?>
                  	<p><span><?php echo sh_set($post_meta,'designation')?></span></p>
                  <?php endif;?>
                  <?php if(in_array('excerpt', $ext )):?>
                  <p><?php echo _sh_trim(get_the_excerpt(), $limit);?></p>
                  <?php endif;?>
                </div>
                
                <!--======= HOVER DECTION =========-->
                <div class="bottm-over-t">
                  <div class="btm-detail"> 
                    
                    <!--======= HOVER SOCIAL ICON =========-->
                    <div class="social_icons">
                      <?php if(in_array('social', $ext )):?>
                      <?php if($social = sh_set($post_meta, 'sh_team_social')): //print_r($social)?>
                      <ul>
                        <?php foreach($social as $key => $val):?>
                        	<li class="facebook"> <a href="<?php echo sh_set($val, 'social_link');?>"><i class="fa <?php echo sh_set($val, 'social_icon');?>"></i> </a> </li>
                        <?php endforeach;?>
                      </ul>
                      <?php endif;?>
                      <?php endif;?>
                    </div>
                    <h5><?php the_title(); ?></h5>
                    <?php if(in_array('designation', $ext )):?>
                    	<p><span><?php echo sh_set($post_meta, 'designation') ?></span></p>
                    <?php endif;?>
                  </div>
                </div>
              </div>
            </li>
            
           <?php $count++; endwhile; wp_reset_query(); ?>
          
          </ul>
        </div>
      </div>
      
      <?php endif; ?>
    
   </div>
  </section>
  
<?php return ob_get_clean();