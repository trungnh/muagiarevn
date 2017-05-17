<?php  /**
 * The template for displaying the coupons in grid view.
 *
 * Override this template by copying it to comre-child/includes/modules/shortcodes/great_deals.php
 *
 * @author    WoWThemes
 * @package   Modules/Shortcodes
 * @version     1.1.0
 */

wp_enqueue_script(array('zeroclipboard'));
global $post ;
 
//echo balanceTags($cat); exit('sssss');

   
  $ext = explode( ',', $extras );   
  ob_start() ; 
  
  $permalink = get_permalink();
  $paged = get_query_var('paged');
  if( !$paged ) $paged = sh_set( $_GET, 'paged' ) ? sh_set( $_GET, 'paged' ) : 1;
  $load_num = balanceTags($num_load_more);
  
  $num = ( $paged > 1 ) ? $load_num : $num;
  $count = 0;
  $query_args = array('post_type' => 'sh_coupons' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order, 'paged' => $paged);
  if( $cat ) $query_args['coupons_category'] = $cat;
	$query = new WP_Query($query_args) ;
?>


<!--======= BANNER =========-->
<section class="great-deals">
	<div class="container"> 
		<!--======= TITTLE =========-->
		<div class="tittle"> 
			<h3><?php echo balanceTags($title); ?></h3>
		</div>
		<div class="coupon">
        <?php if($query->have_posts()):  ?>
        
			<ul class="row _great_deals">
				
				<!--======= COUPEN DEALS =========-->
                 <?php while($query->have_posts()): $query->the_post();
						global $post ; 
						$post_meta = _WSH()->get_meta();
						 $last_class = ( ( $query->current_post % 3 ) == 0 ) ? ' first' : '';
				  ?>
                   <?php 
				       $buton_title = (sh_set($post_meta, 'buttons_title')) ? sh_set($post_meta, 'buttons_title') : 'get coupon code'; 
				   ?>
                <li class="col-sm-4 <?php  echo $last_class;?>">
					<div class="coupon-inner">
						<div class="top-tag"> <?php if(in_array('labels', $ext )):?><span class="ribn-red"><span><?php echo sh_set($post_meta, 'banner');?></span></span><?php endif;?> <span class="star"><i class="fa fa-star-o"></i></span> </div>
						<div class="c-img">
						<?php the_post_thumbnail('324x143',array('class'=>'img-responsive')); ?><a class="head" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							<p><?php esc_html_e('Expires On :','comre');?> <?php echo sh_set($post_meta, 'expires_date');?></p>
							<?php if(in_array('coupon_code', $ext )):
								$coupon_link = _set_refferer_to_link( sh_set( $post_meta, 'coupon_link') );
								$ext_link =  ($coupon_link) ? ' data-href="'. $coupon_link.'" target="_blank"' : ''; ?>
							
                            	<?php if(sh_set($post_meta, 'coupon_display_type') == 'coupon_copied'):?>
								<div class="text-center" data-id="get_the_coupon_code<?php echo $count; ?>"> 
									<a<?php echo $ext_link; ?> data-text="<?php echo sh_set($post_meta, 'coupon_code');?>" class="btn get_coupon_code" id="get_coupon_code<?php echo $count; ?>"><?php echo $buton_title;?></a> 
								</div>
								<?php else:?>
									<div class="text-center"> 
										<a<?php echo $ext_link; ?> class="btn get_coupon_code" data-toggle="modal" data-target="#myModal<?php echo $count;?>" id="get_coupon_code<?php echo $count; ?>"><?php echo $buton_title;?></a> 
									</div>
								<?php endif;?>
                            
							<?php endif;?>
						</div>
						<ul class="btm-info">
							<?php if(sh_set($post_meta, 'verified')):?><li class="col-xs-4"> <i class="fa fa-check-square-o"></i><?php esc_html_e(' Verified', 'comre');?></li><?php endif;?>
							<?php if(sh_set($post_meta, 'safe')):?><li class="col-xs-3"><a href="javascript;" class="add_to_wishlist" data-id="<?php the_ID(); ?>"> <i class="fa fa-bookmark"></i><?php esc_html_e(' Save', 'comre');?></a></li><?php endif;?>
							<?php if(sh_set($post_meta, 'share')):?><li class="col-xs-2"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <i class="fa fa-share"></i><?php esc_html_e(' Share', 'comre');?></a></li><?php endif;?>
							<?php if(sh_set($post_meta, 'discuss')):?><li class="col-xs-3"><a class="disqus" href="javascript;" data-id="<?php the_ID(); ?>" data-toggle="modal" data-target="#myModaltest"> <i class="fa fa-comments"></i><?php esc_html_e(' Discuss', 'comre');?></a></li><?php endif;?>
						</ul>
                        </div>
					</li>
                    
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <?php $count++; endwhile ;wp_reset_query();?>
				
				<!--======= COUPEN DEALS =========-->
				
			</ul>
            <div class="load_more_btn">
            <center><a title="<?php esc_html_e('Load More', 'comre'); ?>" href="javascript:void(0);" class="btn-primary btn ajax_load_more">
				<?php esc_html_e('Load More', 'comre'); ?>
			</a></center>
            </div>
		</div>
        <?php endif?>
		
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModaltest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php esc_html_e('Start Discussion with Disqus', 'comre');?></h4>
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
</section>
<script type="text/javascript">
	
	jQuery(document).ready(function($){

		try{
			
			$('.ajax_load_more').on('click', function(e){
				e.preventDefault();
				var thiselem = this;
				var paged = $(this).data('paged');
				paged = ( paged === undefined ) ? 2 : paged;
				var load_more = $(this).data('load_more');
				load_more = (load_more===undefined) ? true : load_more;
				
				if( load_more === false ) {
					$(this).html('No More data to load');	
					return;
				}

				var permalink = '<?php echo esc_url($permalink); ?>';

				var old_text = $(this).text();
				$(this).html(old_text + '<i class="fa fa-refresh fa-spin"></i>');

				$.ajax({
					url: permalink+'?paged='+paged,
					type: 'GET',
					success: function(res) {
						$(thiselem).html(old_text);
						var newpage = paged + 1;
						var content = $('._great_deals > li', res);
						console.log(content.length);
						if( content.length ) {
							$(thiselem).data('paged', newpage );
							$('._great_deals').append(content);//.masonry('appended', content);
						}
						else {
							$(thiselem).data('load_more', false);
							$(thiselem).html('No More data to load');
						}
					},
					error: function(res) {
						$(thiselem).data('load_more', false);
						
						$(thiselem).html(old_text);
					}
				});
			});

		}
		catch(e) {
			console.log(e.message);
		}
	});
	
</script>

<?php return ob_get_clean();