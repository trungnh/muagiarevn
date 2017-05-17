 <?php  


   ob_start() ;?>


 


 


		<div class="widget">


			<div class="widget-title">


				<h3><span class="divider"></span> <?php echo  balanceTags($title);?></h3>


			</div><!-- end widget title -->


			<div class="about-widget">


			<img src="<?php echo wp_get_attachment_url( $image, '80x80' ); ?>"  class="img-responsive alignleft">


			 <?php echo balanceTags($title_inner);?>


			</p>


			</div><!-- end about-widget -->


		</div><!-- end widget -->


<?php 





   $output = ob_get_contents(); 





   ob_end_clean(); 





   return $output ; ?>