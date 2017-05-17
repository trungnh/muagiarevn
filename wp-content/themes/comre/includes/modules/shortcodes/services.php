<?php  

   $count = 1; 

   $query_args = array('post_type' => 'sh_services' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);

   

   if( $cat ) $query_args['services_category'] = $cat;

   $query = new WP_Query($query_args) ; 

    // print_r($query);

   ob_start() ;?>

<?php if( $query->have_posts() ):?>

 <section class="section-w clearfix">

            <div class="container">

                <div class="section-title">

                    <h3><?php echo balanceTags($title);?></h3>

                    <span class="divider"></span>

                    <p><?php echo balanceTags($title_inner);?></p>

                </div><!-- end section-title -->

                <div class="row section-wrapper clearfix">

				 

                  <?php while($query->have_posts()): $query->the_post();

        					  

                    global $post ;

        					  $services_meta = _WSH()->get_meta(); ?>

                    <div class="col-md-4 col-sm-6 services-three-col">

                        <div class="service clearfix">

                            <div class="entry">

								                

                                <?php //the_post_thumbnail('370x495', array('class'=>'img-responsive TEST'));

                                the_post_thumbnail('283x191', array('class'=>'img-responsive'));?>

                                <div class="magnifier">

                                    <a href="<?php echo sh_set($services_meta, 'single_link');?>" title="<?php the_title_attribute();?>">

                                    <span class="buttons">

                                        <i class="fa fa-arrow-right"></i>

                                    </span>

                                    </a>

                                </div>

                            </div>

                            <h3><?php the_title();?></h3>

                            <p><?php echo get_the_excerpt();?></p>

                        </div><!-- end sercive-box -->

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