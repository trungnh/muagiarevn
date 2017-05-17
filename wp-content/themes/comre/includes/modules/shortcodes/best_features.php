<?php ob_start(); ?>

 <section class="our-best">
    <div class="container"> 
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title);?></h3>
      </div>
      <ul class="row">
      	<?php echo do_shortcode( $contents );?>	
      </ul>
    </div>
  </section> 

<?php return ob_get_clean();