<?php $settings = _WSH()->option();
//printr($settings);
?>

	 <!--======= BLOG POST=========-->
  	
  	<div class="blog-post"> 
  		
		<?php if( has_post_thumbnail() ):?>
	  		<?php the_post_thumbnail('830x390', array('class'=>'img-reponsive'));?>
	  	
		  	<span class="post-date-big">
		  		<?php echo get_the_date('d'); ?><br><?php echo get_the_date('M'); ?>
		  	</span> 
	  	<?php endif; ?>
  		
  		<a href="<?php the_permalink(); ?>" class="title-hed"><?php the_title(); ?></a> 
		<!--======= TAGS =========-->
		<ul class="small-tag">
		  <li>
		  <?php /* for categories without anchor*/ $term_list = wp_get_post_terms(get_the_id(), 'category', array("fields" => "names")); ?>
	      <span><i class="fa fa-tag"></i> <?php echo implode( ', ', (array)$term_list );?> </span> / 
		  <span><i class="fa fa-user"></i> <?php esc_html_e(' By ', 'comre');?><?php the_author(); ?></span> / 
		  <span> <i class="fa fa-comments"></i> <?php comments_number(); ?></span> / 
		  <span> <i class="fa fa-eye"></i> <a class="post_view" href="javascript:void(0);"><?php echo _WSH()->post_views(); ?> <?php esc_html_e('Viewers', 'comre'); ?></a></span></li>
		</ul>
		<p><?php echo get_the_excerpt(); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn"><i class="fa fa-book"></i><?php esc_html_e('Continue Reading', 'comre'); ?> </a> 
	</div>
  
 
	
