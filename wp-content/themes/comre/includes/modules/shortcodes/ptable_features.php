 <?php ob_start(); ?>

<li><?php echo balanceTags(do_shortcode($contents)); ?></li>
          
<?php return ob_get_clean();