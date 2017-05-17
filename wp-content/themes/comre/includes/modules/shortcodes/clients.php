<?php 

   $settings = _WSH()->option();

    $clients = sh_set(sh_set($settings, 'brand_or_client'),'brand_or_client');

    //print_r($clients);

	//echo "<br>";

	//print_r($settings);

   ob_start() ;?>

       <div class="row all-clients">

   <?php if($clients = sh_set(sh_set($settings, 'brand_or_client'), 'brand_or_client')):

        foreach($clients as $key => $client):

		$counter=($key%2==0)?'first':'last';



        if(sh_set($client, 'tocopy')) continue;

        ?>

	 <div class="col-md-6 col-sm-6 <?php echo esc_attr($counter);?>">

	<div class="client">

	<figure class="effect-milo">

      <?php $b_img_size = @getimagesize(esc_url( sh_set($client, 'brand_img') )); ?>

      <img  src="<?php echo esc_url( sh_set($client, 'brand_img') );?>" class="img-responsive" alt="<?php echo esc_url( sh_set($client, 'title') );?>" width="<?php echo sh_set( $b_img_size, 0); ?>" height="<?php echo sh_set( $b_img_size, 1); ?>" />

		<figcaption> 

     <?php $a_img_size = @getimagesize(esc_url( sh_set($client, 'back_img') )); ?>
     <img  src="<?php echo esc_url( sh_set($client, 'back_img') );?>" class="img-responsive image" alt="<?php echo esc_url( sh_set($client, 'title') );?>" width="<?php echo sh_set( $a_img_size, 0); ?>" height="<?php echo sh_set( $a_img_size, 1); ?>" />

		</figcaption>   

	 </figure>

	</div><!-- end client -->

</div>	

<?php  endforeach; endif;?>



</div>

<?php 



   $output = ob_get_contents(); 



   ob_end_clean(); 



   return $output ; ?>