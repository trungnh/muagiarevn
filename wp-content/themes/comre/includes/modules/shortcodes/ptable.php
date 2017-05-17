<?php ob_start(); ?>

 
<!--======= PRICE 1 =========-->
          
            <div class="price-in"> 
              
              <!--======= PRICING HEAD =========-->
              <div class="price-head"> <?php echo $title;?> </div>
              <div class="price">
                <h3><?php echo $duration;?></h3>
                <span class="price-tag"><?php echo balanceTags($discount); ?></span> </div>
              
              <!--======= PRICING DETAIL =========-->
              <ul class="price-details">
                <?php echo balanceTags(do_shortcode($contents)); ?>
                <li> <a href="<?php echo $btn_link;?>" class="btn btn-small"> <?php echo $btn;?></a> </li>
              </ul>
            </div>
          

<?php return ob_get_clean(); ?>

 <section class="pricing">
      <div class="container"> 
        <!--======= TITTLE =========-->
        <div class="tittle">
          <h3 class="text-left"><?php echo $title;?></h3>
        </div>
        
        <!--======= PRICING ROW =========-->
        <ul class="row">
			     <?php echo do_shortcode($contents);?>        
        </ul>
      </div>
    </section>
 
<?php return ob_get_clean();