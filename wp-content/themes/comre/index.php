<?php
global $wp_query; //printr($wp_query);
$settings  = _WSH()->option();
get_header(); 
if( $wp_query->is_posts_page ) {
    $queried_object = get_queried_object();
	$meta = _WSH()->get_meta('_sh_layout_settings', $queried_object->ID);//printr($meta);
	$meta1 = _WSH()->get_meta('_sh_header_settings', $queried_object->ID);//printr($meta1);
	$layout = sh_set( $meta, 'layout', 'right' );
	$sidebar = sh_set( $meta, 'sidebar', 'default-sidebar' );
	$bg = sh_set( $meta1, 'archive_page_header_img' );
	$title = sh_set( $meta1, 'archive_page_title', sh_set($queried_object, 'post_title') );
} else {
	$layout = (sh_set($_GET, 'layout')) ? sh_set($_GET, 'layout') : sh_set($settings, 'archive_page_layout');
	$layout = $layout ? $layout : 'right';
	$sidebar = sh_set($settings, 'archive_page_sidebar', 'default-sidebar');
	$bg = sh_set( $settings, 'archive_page_header_img' );
	$title = sh_set( $settings, 'archive_page_title', 'Blog' );
	
}
$sidebar = $sidebar ? $sidebar : 'default-sidebar';
$classes = ( $layout && $layout === 'full') ? ' col-sm-12' : ' col-sm-9';
?>
<!--======= BANNER =========-->
  <section class="sub-banner <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>">
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
<?php
get_footer();
?>
