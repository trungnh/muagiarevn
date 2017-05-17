<?php 
$options = _WSH()->option();
get_header(); 
//$settings  = sh_set(sh_set(get_post_meta(get_the_ID(), 'sh_page_meta', true) , 'sh_page_options') , 0);
//$meta = _WSH()->get_meta('_sh_layout_settings');
//$layout = sh_set( $meta, 'layout', 'full' );
//$sidebar = sh_set( $meta, 'sidebar', 'product-sidebar' );
//$classes = ( !$layout || $layout == 'full' ) ? ' col-lg-12 col-md-12' : ' col-lg-9 col-md-9';
?>
<section class="sub-banner">
<div class="overlay">
  <div class="container">
	<h2><?php echo wp_title('');?></h2>
	<?php echo get_the_breadcrumb();?>	
	</div>
</div>
</section>

<!--======= 404 =========-->
  <section class="error-page">
    <div class="container">
    
    <!--======= PAGE NOT FOUND =========-->
      <div class="not-found"> <i class="fa fa-warning"></i> <span>error<br>
        404</span> W P L O C K E R .C O M</div>
      <div class="warng">
        <p>OOPS!Looks like the page you are looking for isn't there.You may have mistyped 
          the content or the page may have moved.</p>
        
        <!--=======  SEARCH =========-->
        <div class="search">
          <div class="form-group">
		  	<?php echo get_search_form();?>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<?php get_footer(); ?>