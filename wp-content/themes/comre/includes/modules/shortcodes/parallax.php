<?php ob_start(); ?>

  <section class="app-com" style="background-image: url('<?php echo wp_get_attachment_url( $bg, 'full' ); ?>');">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 text-center"> <img class="img-responsive" src="<?php echo wp_get_attachment_url( $fimage, 'full' ); ?>" alt=""> </div>
        <div class="col-sm-6">
          <div class="text-sec">
            <h3><?php echo balanceTags($title);?></h3>
            <p><?php echo _sh_trim($excerpt, $excerpt_length);?></p>
            	<?php echo balanceTags($contents);?>
            </div>
        </div>
      </div>
    </div>
  </section>

<?php return ob_get_clean();