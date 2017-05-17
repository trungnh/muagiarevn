<?php global $wp_query;







wp_enqueue_script( array( 'jquery-prettyphoto', 'custom-script','jquery-isotope', 'masonry-cube','owl-carousel','owl-scripts','jquery-jigowatt' ) );	



$paged = get_query_var('paged');



$args = array('post_type' => 'sh_services', 'showposts'=>$num, 'orderby'=>$sort, 'order'=>$order, 'paged'=>$paged);



if( $cat ) $args['tax_query'] = array(array('taxonomy' => 'services_category','field' => 'id','terms' => $cat));



query_posts($args);











$t = $GLOBALS['_sh_base'];



$paged = get_query_var('paged');







$data_filtration = '';



$data_posts = '';



$tabs = '';?>











<?php if( have_posts() ):



	



ob_start();?>







	<?php $counter=1; 



	$fliteration = array();?>



	<?php while( have_posts() ): the_post(); 



		



        $meta = _WSH()->get_meta(); //printr($meta);



		$image2 = $meta['service_image'];







		$post_terms = get_the_terms( get_the_id(), 'services_category'); //printr($post_terms); exit();



		foreach( (array)$post_terms as $pos_term ) $fliteration[$pos_term->term_id] = $pos_term;



		$temp_category = get_the_term_list(get_the_id(), 'services_category', '', ', ');?>







		<?php $post_terms = wp_get_post_terms( get_the_id(), 'services_category'); 



		$term_slug = '';



        $active_class = ($wp_query->current_post == 0) ? ' active' : '';



		//if( $post_terms ) foreach( $post_terms as $p_term ) $term_slug .= $p_term->slug.' ';



		$tabs .= " <a href='#' title='".the_title_attribute(array('echo'=>false))."' class='list-group-item  text-center$active_class'>".get_the_title()."</a>";?>		



                



        <div class="bhoechie-tab-content<?php echo esc_attr($active_class); ?>">



            



            <div class="row">



                <div class="col-lg-8 col-md-8 col-xs-12">



                    <div class="media">



                       <?php the_post_thumbnail('770x356', array('class'=>'img-responsive'));?>



                   </div><!-- end media -->



                </div><!-- end col -->







                <div class="col-lg-4 col-md-4 col-xs-12">



                    <div class="media">

                       <?php $img2_size = @getimagesize(esc_url($image2)); ?>

                       <img src="<?php echo esc_url($image2);?>" alt="<?php the_title_attribute() ?>" class="img-responsive" width="<?php echo sh_set( $img2_size, 0 ); ?>" height="<?php echo sh_set( $img2_size, 1 ); ?>">



                   </div><!-- end media -->



                </div>



            </div><!-- end row -->



            <br>



            



            <div class="row">



                <?php the_content();?> 



            </div><!-- end row -->



            <br>







        </div>



	



  <?php $counter++; endwhile;?>



  



<?php wp_reset_query();



$data_posts = ob_get_contents();



ob_end_clean();







endif; 







ob_start();?>	 



 <section class="section-w clearfix">



            <div class="container">



                <div class="row clearfix">



                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">



                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 bhoechie-tab-menu">



                            <div class="list-group">



                             <?php echo balanceTags($tabs);?>                            



                            </div>



                        </div>



                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 bhoechie-tab">



                            <!-- flight section -->



                            <?php echo balanceTags($data_posts);?>







                        </div>



                    </div>



                </div><!-- end row -->



            </div><!-- end container -->



        </section><!-- end section -->







<?php $output = ob_get_contents();



ob_end_clean(); 



return $output;?>