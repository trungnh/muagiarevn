<?php $options = _WSH()->option();
//wp_enqueue_script( array( 'jquery-flexslider' ) );
get_header(); 
$settings  = sh_set(sh_set(get_post_meta(get_the_ID(), 'sh_page_meta', true) , 'sh_page_options') , 0);
$meta = _WSH()->get_meta('_sh_layout_settings');
$meta1 = _WSH()->get_meta('_sh_header_settings');
$meta2 = _WSH()->get_meta();
//printr($meta); 
_WSH()->page_settings = $meta;
$layout = sh_set( $meta, 'layout', 'full' );
if( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) $sidebar = ''; else
$sidebar = sh_set( $meta, 'sidebar', 'product-sidebar' );
$classes = ( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) ? ' col-md-12 col-sm-12 col-xs-12' : ' col-md-8 col-sm-12 col-xs-12';
/** Update the post views counter */
_WSH()->post_views( true );
$bg = sh_set( $settings, 'archive_page_header_img' );
$title = sh_set( $settings, 'archive_page_title' );
?>


 <section class="sub-banner <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>">
    <div class="overlay">
      <div class="container">
        <h2><?php if($title) echo  balanceTags( $title ); else wp_title('');?></h2>
        <?php echo get_the_breadcrumb();?>
      </div>
    </div>
  </section>



<section class="section-w clearfix" id="portfolio">
    <div class="container">
        <div class="row">
            
            <?php if( $layout == 'left' ): ?>
        
                <?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<div class="pull-right col-md-4 col-sm-4 col-xs-12">
                        <div id="sidebar" class="clearfix">        
                            <?php dynamic_sidebar( $sidebar ); ?>
                        </div>
                </div>
				<?php } ?>
        
           <?php endif; ?><!-- end sidebar -->  
            
            <div class="pull-left <?php echo esc_attr($classes);?> col-xs-12">
                <div class="clearfix">
                    <?php while( have_posts() ): the_post(); ?>
                        
                        <div class="blog-item">
                            
                            <?php if(has_post_thumbnail()):?>
                                <div class="entry">
                                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
                                    <div class="magnifier">
                                        <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id());?>" title="<?php the_title_attribute();?>" data-gal="prettyPhoto[product-gallery]">
                                        <span class="buttons">
                                            <i class="fa fa-search"></i>
                                        </span><!-- end buttons -->
                                        </a>
                                    </div><!-- end magnifier -->
                                </div>
                            <?php endif; ?>
                            <div class="blog-desc">
                                <?php the_content();?>
                                <?php the_tags('<div class="tags">', ', ', '</div>');?>
                            </div><!-- end desc -->
                            <div class="clearfix"></div>
                            <?php comments_template(); ?><!-- end comments -->
                        </div><!-- end blog -->
                    
                    <?php endwhile;?>
                </div><!-- end blog -->
            </div><!-- end pull-right -->
            <?php if( $layout == 'right' ): ?>
        
                <?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<div class="pull-right col-md-4 col-sm-4 col-xs-12">
                        <div id="sidebar" class="clearfix">        
                            <?php dynamic_sidebar( $sidebar ); ?>
                        </div>
                </div>
				<?php } ?>
        
        <?php endif; ?><!-- end sidebar -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end section white -->
<?php get_footer(); ?>