<?php global $wp_query; //printr($wp_query);  
$options = _WSH()->option();
get_header(); 
$meta = _WSH()->get_term_meta( '_sh_category_settings' );
_WSH()->page_settings = $meta; 
$layout = sh_set( $meta, 'layout', 'full' );
$sidebar = sh_set( $meta, 'sidebar', 'blog-sidebar' );
$view = sh_set( $meta, 'view', 'list' );
$view = sh_set( $_GET, 'view' ) ? sh_set( $_GET, 'view' ) : $view;
$classes = ( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) ? ' col-sm-12' : ' col-sm-9' ;
$bg = sh_set( $meta, 'header_img' );
$title = sh_set( $meta, 'header_title' );
?>
<section class="sub-banner <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>">
    <div class="overlay">
      <div class="container">
        <h2><?php if($title) echo  balanceTags( $title ); else wp_title('');?></h2>
        <?php echo get_the_breadcrumb();?>
      </div>
    </div>
  </section>


<section class="blog">
<div class="container">
  <ul class="row">
  <?php if( $layout == 'left' ): ?>  <?php // yay wala bnana h  ?>
		
                <?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<li class="col-sm-3">
                        <div class="blog-side-bar">        
							<?php dynamic_sidebar( $sidebar ); ?>
                		</div>
                </li>
				<?php } ?>
		
		<?php endif; ?><!-- end sidebar -->
	<li class="<?php echo esc_attr($classes);?>"> 
	
	
	  
	  <?php while( have_posts() ): the_post();?>
	  
	  <div id="post-<?php the_ID(); ?>" <?php post_class();?>>
	  	<?php get_template_part( 'blog' ); ?>
	  </div><!-- End Post -->	
	  
	  <?php endwhile; ?> 
	  
	  <!--======= PAGINATION =========-->
	  <ul class="pagination">
		<?php _the_pagination(); ?>
	  </ul>
	</li>
	
	<!--======= SIDE BAR =========-->
	<?php if( $layout == 'right' ): ?>
		
                <?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<li class="col-sm-3">
                        <div class="blog-side-bar">        
							<?php dynamic_sidebar( $sidebar ); ?>
                		</div>
                </li>
				<?php } ?>
		
	<?php endif; ?><!-- end sidebar -->
  
  </ul>
</div>
</section>  


<?php get_footer(); ?>