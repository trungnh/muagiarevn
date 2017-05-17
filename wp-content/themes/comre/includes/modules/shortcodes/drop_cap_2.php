<?php ob_start(); ?>


   <div>
          <div class="drop-cobs">
            <p><span class="border"><?php echo $title;?></span> <?php echo $contents;?> </p>
          </div>
        </div>
        
<?php return ob_get_clean();