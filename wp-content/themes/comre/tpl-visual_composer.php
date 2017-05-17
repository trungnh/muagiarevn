<?php /* Template Name: VC Page */
get_header() ;
$meta = _WSH()->get_meta();
$meta1 = _WSH()->get_meta('_sh_header_settings'); //printr($meta1);
?>
<?php if(sh_set($meta1, 'bread_crumb')):?>
<?php $header_bg_image = sh_set( $meta1, 'bg_image' ) ? ' style=background-image:url('.$meta1['bg_image'].');' : ''; //printr($header_bg_image); ?>
<!--======= BANNER =========-->
<section class="sub-banner" <?php echo esc_attr($header_bg_image); ?>>
<div class="overlay">
  <div class="container">
	<h2><?php if(sh_set($meta1, 'header_title')) echo sh_set($meta1, 'header_title'); else echo wp_title('');?></h2>
	<?php echo get_the_breadcrumb();?>	
	</div>
</div>
</section>
<?php endif;?>
<?php //if( !sh_set( $meta, 'is_home' ) ) get_template_part( 'includes/modules/header/header', 'single' ); ?>
<div class="white-bg" id="portfoli">
	<?php while( have_posts() ): the_post(); ?>
	     <?php the_content(); ?>
	<?php endwhile;  ?>
</div>
<?php get_footer() ; ?>