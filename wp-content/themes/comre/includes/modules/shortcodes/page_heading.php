<?php  





   ob_start() ;?>





        <div class="section-title clearfix">


            <div class="container">


              <h3><?php echo balanceTags($title);?></h3>


              <span class="divider"></span>


              <p><?php echo balanceTags($title_inner);?></p>


            </div><!-- end container -->


        </div><!-- end section -->


<?php return ob_get_clean(); ?>