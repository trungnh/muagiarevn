<?php global $wp_query;



wp_enqueue_script( array( 'jquery-prettyphoto', 'main-script','jquery-isotope', 'masonry-cube','owl-carousel','owl-scripts' ) );	



$paged = get_query_var('paged');



$args = array('post_type' => 'sh_services', 'showposts'=>$num, 'orderby'=>$sort, 'order'=>$order, 'paged'=>$paged);







if( $cat ) $args['services_category'] = $cat;//$args['tax_query'] = array(array('taxonomy' => 'services_category','field' => 'id','terms' => array($cat)));



query_posts($args);











$t = $GLOBALS['_sh_base'];



$paged = get_query_var('paged');







$data_filtration = '';



$data_posts = '';



$tabs = '';



?>











<?php if( have_posts() ):



	



ob_start();?>







	<?php $counter=1;



	$fliteration = array();?>



	<?php while( have_posts() ): the_post(); 







		$meta = _WSH()->get_meta(); //printr($meta);



		$post_terms = get_the_terms( get_the_id(), 'services_category'); //printr($post_terms); exit();



		foreach( (array)$post_terms as $pos_term ) $fliteration[$pos_term->term_id] = $pos_term;



		$temp_category = get_the_term_list(get_the_id(), 'services_category', '', ', ');?>







		<?php $post_terms = wp_get_post_terms( get_the_id(), 'services_category'); 



		$term_slug = '';



	



		if($counter ==1):$active='active'; else: $active =''; endif;



		



        //if( $post_terms ) foreach( $post_terms as $p_term ) $term_slug .= $p_term->slug.' ';



		$tabs .= "<li role='presentation' class='col-md-3 col-sm-3 col-xs-6 ".$active."'>



					<a href='#services_post".get_the_ID()."' aria-controls='services_post".get_the_ID()."' role='tab' data-toggle='tab'>



						<span class='bubble'>".$counter."</span> 



						<h3>".get_the_title()."</h3>



					</a>



				</li>";?>		



                



                            <div role="tabpanel" class="tab-pane fade <?php if($counter ==1):echo'in active'; endif;?> " id="services_post<?php the_ID(); ?>">



                                <br>



                                <div class="row">



                                    <div class="col-lg-8 col-md-8 col-xs-12">



                                        <div class="media">



								       <?php the_post_thumbnail('770x356', array('class'=>'img-responsive'));?>



                                        </div><!-- end media -->



                                    </div><!-- end col -->







                                    <?php if( $service_image = sh_set($meta, 'service_image')): ?>



                                        <div class="col-lg-4 col-md-4 col-xs-12">



                                            <div class="media">

                                                <?php $img2_size = @getimagesize(esc_url($service_image)); ?>

                                               <img src="<?php echo esc_url($service_image);?>" alt="<?php the_title_attribute() ?>" class="img-responsive" width="<?php echo sh_set( $img2_size, 0 ); ?>" height="<?php echo sh_set( $img2_size, 1 ); ?>">



                                            </div><!-- end media -->



                                        </div>



                                    <?php endif; ?>



                                </div><!-- end row -->



                                <br>



                                <div class="row">



                                   <?php the_content();?>



                                </div><!-- end row -->



                            </div>



                            



                            



                            



	



  <?php $counter++; endwhile;?>



  



<?php wp_reset_query();



$data_posts = ob_get_contents();



ob_end_clean();







endif; 







ob_start();?>	 



<section class="section-g clearfix">



            <div class="container">



                <div class="section-title">



                    <h3><?php echo balanceTags($title);?></h3>



                    <span class="divider"></span>



                    <p><?php echo balanceTags($title_inner);?></p>



                </div><!-- end section-title -->



                



                <div class="row section-wrapper clearfix">



                    <div id="colorful-tab" role="tabpanel">



                          <!-- Nav tabs -->



                        <ul class="nav nav-tabs row" role="tablist">



                         <?php echo balanceTags($tabs);?>



                        </ul>







                        <!-- Tab panes -->



						<div class="tab-content">







                        <?php echo balanceTags($data_posts);?>



						</div>



                    </div><!-- end coloful-tab -->



                </div><!-- end row -->



            </div><!-- end container -->



        </section><!-- end section -->







<?php $output = ob_get_contents();



ob_end_clean(); 



return $output;?>