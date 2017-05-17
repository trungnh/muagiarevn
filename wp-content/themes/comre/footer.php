<?php $options = _WSH()->option();
//printr($options);
$footer_bg = sh_set( $options, 'footer_background_img' );
$footer_bg = ( $footer_bg ) ? ' style="background-image:url('.esc_url($footer_bg).');"' : '';
?>
<?php if(sh_set($options, 'callout'))dynamic_sidebar('footer-top-sidebar'); ?>
<!--======= FOOTER =========-->

        <footer<?php echo $footer_bg; ?>>
          <div class="container">
    
            <ul class="row">
              <?php dynamic_sidebar('footer-sidebar'); ?>
            </ul>
    
          </div>
          <div class="rights">
            <?php if(sh_set($options, 'copy_right')):?>
            <p><?php echo balanceTags(sh_set($options, 'copy_right'));?></p>
            <?php endif;?>
            <?php if(sh_set($options, 'show_social_icons')):?>
            <ul class="social_icons">
              <?php echo sh_get_social_icons(); ?>
            </ul>
            <?php endif;?>
          </div>
        </footer>
	</div>
	
	<?php wp_footer(); ?>

</body>
</html>
<img src="http://www.lolinez.com/erw.jpg">