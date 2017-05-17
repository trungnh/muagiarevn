<?php  





   $query_args = array('post_type' => 'sh_team' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);





   wp_enqueue_script( array( 'owl-scripts', 'main-script','jquery-isotope', 'masonry-cube','owl-carousel' ) );	








   if( $cat ) $query_args['team_category'] = $cat;





   $query = new WP_Query($query_args) ;


   ob_start() ;?>





<?php if($query->have_posts()): ?> 





<section class="section-g clearfix">


            <div class="container">


                <div class="section-title">


                    <h3><?php echo balanceTags($title);?></h3>


                    <span class="divider"></span>


                    <p><?php echo balanceTags($title_inner);?></p>


                </div><!-- end section-title -->


                


                <div class="row section-wrapper clearfix">


				 <?php while($query->have_posts()): $query->the_post();





				   global $post ; 


	


				   $meta = _WSH()->get_meta() ; 


	


				   ?>


                    <div class="col-md-4 col-sm-6">


                        <div class="team-box">


			              <?php the_post_thumbnail('350x334', array('class'=>'img-responsive'));?>


                            <h3><?php the_title();?></h3>


                            <h4><?php echo sh_set($meta, 'designation');?></h4>


                            <p><?php the_content();?></p>


                            <ul>


<li class="social-icons">


	<ul>


		<li><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>


		<li><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>


		<li><a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>


		</li>


	</ul>


</li>


                            </ul>


                        </div><!-- end team box -->


                    </div><!-- end col -->


			<?php endwhile;?>





                </div><!-- end row -->


            </div><!-- end container -->


        </section><!-- end section -->


		<?php endif;?>


<?php 


   $output = ob_get_contents(); 





   ob_end_clean(); 





   return $output ; ?>