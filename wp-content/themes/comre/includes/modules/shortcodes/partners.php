<?php ob_start(); 
$options = _WSH()->option();
?>

 <section class="parthner">
    <div class="container"> 
      <!--======= TITTLE =========-->
      <div class="tittle">
        <h3><?php echo balanceTags($title);?></h3>
      </div>
      <?php if($brands = sh_set(sh_set($options, 'brand_or_client'), 'brand_or_client')): //printr($brands);?>
      <ul class="row">
        <?php foreach($brands as $value):
			if(sh_set($value, 'tocopy')) continue;
		?>
        	<li> <a href="<?php echo sh_set($value, 'brand_link');?>"><img class="img-responsive" src="<?php echo sh_set($value, 'brand_img');?>" alt=""></a> </li>
 	  	<?php endforeach;?>
      </ul>
      <?php endif;?>
    </div>
  </section>
  
  
<?php return ob_get_clean();