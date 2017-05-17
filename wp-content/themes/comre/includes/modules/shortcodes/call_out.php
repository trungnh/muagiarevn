<?php  





   ob_start() ;?>


<div class="landing-message <?php if($color=='true'):echo 'colorful'; endif;?>" style="background-image: url('<?php echo wp_get_attachment_url( $image, 'full' ); ?>');">


	<div class="container">


		<div class="row">


			<div class="col-md-12">


			  <h3 class="pull-left"><?php echo balanceTags($msg); ?></h3>


				<a href="<?php echo esc_url($btn_link);?>" class="btn btn-default btn-lg pull-right"><?php echo balanceTags($btn_text); ?></a>


			</div>


		</div><!-- end row -->


	</div><!-- end container -->


</div><!-- end landing -->





<?php 





   $output = ob_get_contents(); 





   ob_end_clean(); 





   return $output ; ?>