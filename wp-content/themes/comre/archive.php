<?php global $wp_query; //printr($wp_query); 
$options = _WSH()->option();
get_header(); 
$settings  = _WSH()->option(); 
$layout = sh_set( $settings, 'archive_page_layout', 'full' );
if( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) $sidebar = ''; else
$sidebar = sh_set( $settings, 'archive_page_sidebar', 'blog-sidebar' );
$view = sh_set( $settings, 'archive_page_view', 'list' );
_WSH()->page_settings = array('layout'=>$layout, 'view'=> $view, 'sidebar'=>$sidebar);
$classes = ( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) ? ' col-sm-12' : ' col-sm-9' ;
$bg = sh_set( $settings, 'archive_page_header_img' );
$title = sh_set( $settings, 'archive_page_title' );
?>

<!--======= BANNER =========-->
  <section class="sub-banner" <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>>
    <div class="overlay">
      <div class="container">
        <h2><?php if($title) echo  balanceTags( $title ); else wp_title('');?></h2>
        <?php echo get_the_breadcrumb();?>
      </div>
    </div>
  </section>
 <!--======= BLOG =========-->
<section class="blog">
<div class="container">
  <ul class="row">
  <?php if( $layout == 'left' ): ?>
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
	  <!--======= BLOG POST=========-->
	  
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