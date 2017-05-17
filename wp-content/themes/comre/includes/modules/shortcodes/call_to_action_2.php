<?php ob_start(); ?>

   <div class="coupon-win" style="background-color:none repeat scroll 0 0 #000000;">
          <h4 class="text-uppercase"><?php echo balanceTags($contents);?></h4>
          <a href="<?php echo esc_url($btn_link);?>" class="join" ><?php echo balanceTags($btn_text);?></a> 
	</div>
     
<?php return ob_get_clean();