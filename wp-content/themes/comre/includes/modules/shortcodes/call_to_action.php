<?php ob_start(); ?>

 <section class="community" style="background-image: url('<?php echo wp_get_attachment_url( $bg, 'full' ); ?>');">
    <div class="container">
      <ul class="row">
        <li class="col-sm-6 text-center">
          <h4><?php echo esc_attr($title);?></h4>
          <a href="<?php echo esc_url($btn_link);?>" class="btn"><?php echo balanceTags($btn_text);?></a> </li>
        <li><span class="sizer"></span></li>
        <li class="col-sm-6 text-center">
          <h4><?php echo balanceTags($title2);?></h4>
          <?php $images_arr = explode(",", $images);?>
          <?php foreach($images_arr as $value):?>
          	<a href="#."><img class="img-responsive" src="<?php echo wp_get_attachment_url( $value, 'full' ); ?>" alt=""></a> 
          <?php endforeach;?>
		  </li>	
      </ul>
    </div>
  </section>
  
<?php return ob_get_clean();