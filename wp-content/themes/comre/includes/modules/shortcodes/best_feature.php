<?php ob_start(); ?>

<li>
  <div class="icon"> <img src="<?php echo wp_get_attachment_url( $img, 'full' ); ?>" alt="" > </div>
  <h6><?php echo balanceTags($title);?></h6>
</li>
 
<?php return ob_get_clean();