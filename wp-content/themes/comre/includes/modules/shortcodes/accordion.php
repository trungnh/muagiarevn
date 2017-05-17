<?php  



   $query_args = array('post_type' => 'post' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);



   wp_enqueue_script( array( 'owl-scripts', 'main-script','jquery-isotope', 'masonry-cube','owl-carousel' ) );	

   



   if( $cat ) $query_args['category'] = $cat;



   $query = new WP_Query($query_args) ;

   ob_start() ;?>

<?php if($query->have_posts()): ?> 

<div class="widget">



	<div class="widget-title">

		<h3><span class="divider"></span> <?php echo balanceTags($title);?></h3>

	</div><!-- end widget title -->



	<div class="accordion-widget">



		<div id="accordion-first" class="clearfix">

			

			<div class="accordion" id="accordion1">

				<?php while($query->have_posts()): $query->the_post();

					global $post ; 

					$meta = _WSH()->get_meta() ; 

					$arrow_right = ( $query->current_post == 0 ) ? 'right' : 'down';

					$in_class = ( $query->current_post == 0 ) ? ' in' : '';?>



					<div class="accordion-group clearfix">

						<div class="accordion-heading">

							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?php the_ID();?>">

								<em class="fa fa-arrow-<?php echo esc_attr($arrow_right); ?> icon-fixed-width"></em><?php the_title();?>

							</a>

						</div>

						

						<div id="<?php the_ID();?>" class="accordion-body collapse<?php echo esc_attr($in_class); ?>">

							<div class="accordion-inner">

								

								<p>	<?php the_post_thumbnail('thumbnail', array('class'=>'img-responsive alignleft'));?></p>



								<?php the_content();?>

								

							</div>

						</div>

					</div>

				<?php endwhile;?>

			</div><!-- end accordion -->

		</div><!-- end accordion first -->

	</div><!-- end accordion-widget -->



</div><!-- end widget -->



<?php endif;?>



<?php return ob_get_clean();

