<?php ob_start(); ?>





	<div class="section-w">





        <?php if( $title ): ?>


	        <div class="widget-title">


	            <h3><span class="divider"></span> <?php echo balanceTags($title); ?></h3>


	        </div><!-- end widget -->


    	<?php endif; ?>


        





        <div class="contact_details">


            


            <?php if( $address ): ?>


            	<p><i class="fa fa-home"></i> <?php echo balanceTags($address); ?> </p>


            <?php endif; ?>





            <?php if( $phone  ): ?>


            	<span><?php esc_html_e('Phone', 'comre'); ?>: <?php echo balanceTags($phone); ?></span><br>


            <?php endif; ?>





            <?php if( sanitize_email($email) ): ?>


            	<span><?php esc_html_e('Email',  'comre');?>: <?php echo sanitize_email($email); ?> </span><br>


            <?php endif; ?>





            <?php if( esc_url($website) ): ?>


            	<span><?php esc_html_e('Web', 'comre');?>: <?php echo esc_url($website); ?> </span>


            <?php endif; ?>





        </div><!-- end services -->





        <hr>





        <?php if( $contents ): ?>


	        <span class="contact_details">


	            <i class="fa fa-calendar"></i> <?php echo balanceTags($contents); ?>


	        </span><!-- end -->


	    <?php endif; ?>





	</div>


	


<?php return ob_get_clean(); 


