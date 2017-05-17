<?php ob_start(); ?>
              <h3><?php echo balanceTags($title);?></h3>
              <p><?php echo balanceTags($description);?></p>
              <ul class="con-det">
                
                <!--======= ADDRESS =========-->
				<?php if($address):?>
                <li> <i class="fa fa-map-marker"></i>
                  <h6><?php esc_html_e('Address', 'comre');?></h6>
                  <p><?php echo balanceTags($address);?></p>
                </li>
                <?php endif;?>
                <!--======= EMAIL =========-->
                <?php if($email):?>
				<li> <i class="fa fa-envelope"></i>
                  <h6><?php esc_html_e('email', 'comre');?></h6>
                  <p><?php echo balanceTags($email);?></p>
                </li>
                <?php endif;?>
                <!--======= ADDRESS =========-->
				<?php if($phone):?>
                <li> <i class="fa fa-phone"></i>
                  <h6><?php esc_html_e('our phone', 'comre');?></h6>
                  <p><?php echo balanceTags($phone);?></p>
                </li>
				<?php endif;?>
              </ul>
              
              <!--======= SOCIAL ICON =========-->
              <?php if($contents):?>
			  	<?php echo balanceTags($contents);?>
			  <?php endif;?>

<?php return ob_get_clean();