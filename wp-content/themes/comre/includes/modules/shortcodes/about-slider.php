<?php ob_start();

$img=explode(",",$image);
 wp_enqueue_script( array( 'jquery-prettyphoto', 'custom-script','jquery-isotope', 'masonry-cube','owl-carousel','owl-scripts','jquery-jigowatt' ) );	

?>

 <div class="row">
	<div class="col-md-12 col-sm-12">
		<div id="about-slider">
			  <?php foreach($img as $key=>$val):?>
			    <div class="slide">
				  <img src="<?php echo wp_get_attachment_url( $val, '1169x500' ); ?>"  class="img-responsive">
			    </div><!-- end slide -->
			  <?php endforeach;?>	
		</div>
	</div><!-- end col -->
</div><!-- end row -->









<?php 

   $output = ob_get_contents(); 

   ob_end_clean(); 

   return $output ; ?>