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



<section class="great-deals">
    <div class="container"> 
        
        <div class="coupon">
        <?php if(have_posts()):  

            $count = 0;?>
        
            <ul class="row">
                
                <!--======= COUPEN DEALS =========-->
                 <?php while(have_posts()): the_post();
                        global $post ; 
                        $post_meta = _WSH()->get_meta();
                  ?>
                  <?php 
				       $buton_title = (sh_set($post_meta, 'buttons_title')) ? sh_set($post_meta, 'buttons_title') : 'get coupon code'; 
				   ?>
                <li class="col-sm-4">
                    <div class="coupon-inner">
                        <div class="top-tag">
                            <?php  if (sh_set($post_meta, 'banner') ) :?>
                                <span class="ribn-red"><span><?php echo sh_set($post_meta, 'banner');?></span></span> 
                            <?php endif; ?>
                            <span class="star"><i class="fa fa-star-o"></i></span> 
                        </div>
                        <div class="c-img">
                        <?php the_post_thumbnail('324x143',array('class'=>'img-responsive')); ?><a class="head" href="<?php the_permalink();?>"><?php the_title(); ?></a>

                            <?php if( sh_set($post_meta, 'expires_date') ): ?>
                            <p><?php esc_html_e('Expires On :','comre');?> <?php echo sh_set($post_meta, 'expires_date');?></p>
                            <?php endif;?>
                            
                            <?php $ext_link =  sh_set($post_meta, 'coupon_link') ? ' data-href="'. sh_set($post_meta, 'coupon_link').'" target="_blank"' : ''; ?>
                            <?php if(sh_set($post_meta, 'coupon_display_type') == 'coupon_popup'):?>
						<div class="text-center"> 
							<a<?php echo $ext_link; ?> href="<?php echo sh_set($post_meta, 'coupon_link');?>" class="btn get_coupon_code" data-text="<?php echo sh_set($post_meta, 'coupon_code');?>" data-toggle="modal" data-target="#myModal<?php the_ID();?>"><?php echo $buton_title;?></a> 
						</div>
						<?php else:?>
								<div class="text-center"> <a<?php echo $ext_link; ?> href="<?php echo sh_set($post_meta, 'coupon_link');?>" class="btn get_coupon_code" data-text="<?php echo sh_set($post_meta, 'coupon_code');?>" id="get_coupon_code<?php the_id(); ?>" target="blank"><?php echo $buton_title;?></a> </div>
						<?php endif;?>
                            
                            <?php /*?><div class="text-center"> <a class="btn" data-toggle="modal" data-target="#myModal<?php echo $count;?>"><?php esc_html_e('get coupon code', 'comre');?></a> </div><?php */?>
                            
                        </div>
                        <ul class="btm-info">
                            <?php if(sh_set($post_meta, 'verified')):?><li class="col-xs-4"> <i class="fa fa-check-square-o"></i><?php esc_html_e(' Verified', 'comre');?></li><?php endif;?>
                            <?php if(sh_set($post_meta, 'safe')):?><li class="col-xs-3"> <i class="fa fa-bookmark"></i><?php esc_html_e(' Save', 'comre');?></li><?php endif;?>
                            <?php if(sh_set($post_meta, 'share')):?><li class="col-xs-2"> <i class="fa fa-share"></i><?php esc_html_e(' Share', 'comre');?></li><?php endif;?>
                            <?php if(sh_set($post_meta, 'discuss')):?><li class="col-xs-3"> <i class="fa fa-comments"></i><?php esc_html_e(' Discuss', 'comre');?></li><?php endif;?>
                        </ul>
                        </div>
                    </li>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="myModal<?php the_id();?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php esc_html_e('Get Coupon Code', 'comre');?></h4>
                          </div>
                          <div class="modal-body">
                            <?php echo sh_set($post_meta, 'coupon_code');?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php esc_html_e('Close', 'comre');?></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $count++; 

                    endwhile ;?>
                
                <!--======= COUPEN DEALS =========-->
                
            </ul>
        </div>
        <?php endif?>
    </div>   
</section>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.get_coupon_code').each(function(index, element) {

			var elem_id = $(this).attr('id');
			var coupon_code = $(this).data('text');
			
			if( coupon_code ) {
				$("#"+elem_id).zclip({
					path: '<?php echo get_template_directory_uri(); ?>/js/ZeroClipboard.swf',
					copy: coupon_code,
					afterCopy: function() {
					   console.log('copied');
					  alert('Data in clipboard! Now you can paste it somewhere');
					}
				});
			}
		});
		
	});
</script>

<?php wp_enqueue_script(array('zeroclipboard'));
get_footer(); ?>