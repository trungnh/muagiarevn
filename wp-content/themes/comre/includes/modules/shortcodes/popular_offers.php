<?php /**
 * The template for displaying the coupons in grid view.
 *
 * Override this template by copying it to comre-child/includes/modules/shortcodes/popular_offers.php
 *
 * @author    WoWThemes
 * @package   Modules/Shortcodes
 * @version     1.1.0
 */

   $count = 0; 
   $query_args = array('post_type' => 'sh_coupons' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order);
   
   if( $cat ) {
	   $termby_slug = get_term_by('slug', $cat, 'coupons_category');
	   
	   if( $termby_slug ) {
		   $child = get_terms( 'coupons_category', array('parent'=>$termby_slug->term_id, 'fields'=>'ids')); //printr($child);
		   if($child) $query_args['tax_query'] = array(array('taxonomy' => 'coupons_category','field'    => 'slug','terms'    => $child));
		   else $query_args['coupons_category'] = $cat;
	   }
	   else $query_args['coupons_category'] = $cat;
   }
	$query = new WP_Query($query_args);
    
	$filteration = array();
	$posts_data = array();

 ?>
<?php $active_term = '';
while( $query->have_posts() ): $query->the_post(); 
	$meta = _WSH()->get_meta();
?>
	<?php $terms = wp_get_post_terms( get_the_id(), 'coupons_category' );
	$active = ( $query->current_post == 0 ) ? ' active' : '';
    foreach( $terms as $t ) :
        if($active) $active_term = $t->term_id;
    	$term_active = ( $active_term == $t->term_id ) ? ' active' : '';
		$filteration[$t->term_id] = '<li role="presentation" class="col-xs-2'.$term_active.'"><a href="#'.$t->slug.'"  role="tab" data-toggle="tab">'.$t->name.'</a></li>'; ?>
		<?php ob_start(); ?>

		<!--======= ROW =========-->
		
		<div class="col-md-3 margin-bottom">
			<div class="offer-in"> 
			<?php the_post_thumbnail('270x185', array('class' => 'img-responsive'));?>
			 
				
				<!--======= SMALL IMAGE =========--> 
				<span class="small-spon">
					<img src="<?php echo sh_set($meta, 'small_image');?>" alt="" class="img-responsive" />
				</span>
				<h6><?php the_title();?></h6>
				<p class="text-uppercase"><?php esc_html_e('Expires: ', 'comre');?><?php echo sh_set($meta, 'expires_date');?></p>
				<div class="btm-offer">
					<p class="text-uppercase"><?php echo sh_set($meta, 'cashback');?></p>
				</div>
				<!--======= SMALL IMAGE HOVER =========-->
				<h6><?php the_title();?></h6>
				<p class="text-uppercase"><?php esc_html_e('Expires: ', 'comre');?><?php echo sh_set($meta, 'expires_date');?></p>
				<div class="btm-offer">
					<p class="text-uppercase"><?php echo sh_set($meta, 'cashback');?></p>
				</div>
				<!--======= SMALL IMAGE HOVER =========-->
				<div class="off-over">
					<h6><?php the_title();?></h6>
					<p class="text-uppercase"><?php esc_html_e('Expires: ', 'comre');?><?php echo sh_set($meta, 'expires_date');?></p>
					

					<?php if(sh_set( $meta, 'coupon_code')):
						$coupon_link = _set_refferer_to_link( sh_set( $meta, 'coupon_link') );
						$ext_link =  ($coupon_link) ? ' data-href="'. $coupon_link.'" target="_blank"' : ''; ?>
					
                    	<?php if(sh_set($meta, 'coupon_display_type') == 'coupon_copied'):?>
						<div class="text-center" data-id="get_the_coupon_code<?php echo $count; ?>"> 
							<a<?php echo $ext_link; ?> data-text="<?php echo sh_set($post_meta, 'coupon_code');?>" class="btn get_coupon_code" id="get_coupon_code<?php echo $count; ?>"><?php esc_html_e('get coupon code', 'comre');?></a> 
						</div>
						<?php else:?>
							<div class="text-center"> 
								<a<?php echo $ext_link; ?> class="btn get_coupon_code" data-toggle="modal" data-target="#myModal<?php echo $count;?>" id="get_coupon_code<?php echo $count; ?>"><?php esc_html_e('get coupon code', 'comre');?></a> 
							</div>
						<?php endif;?>
                    
					<?php endif;?>
					
					<div class="btm-offer">
						<p class="text-uppercase"><?php echo sh_set($meta, 'cashback');?></p>
						
						<!--======= SHARE INFO =========-->
						<ul class="btm-info">
							<?php if(sh_set($meta, 'safe')):?><li class="col-xs-4"><a href="#."> <i class="fa fa-bookmark"></i><?php esc_html_e(' Save', 'comre');?></a></li><?php endif;?>
							<?php if(sh_set($meta, 'share')):?><li class="col-xs-4"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><i class="fa fa-share"></i><?php esc_html_e(' Share ', 'comre');?></a></li><?php endif;?>
							<?php if(sh_set($meta, 'discuss')):?><li class="col-xs-4"><a class="disqus" href="javascript:;" data-id="<?php the_ID(); ?>" data-toggle="modal" data-target="#myModaltest"> <i class="fa fa-comments"></i><?php esc_html_e(' Discuss', 'comre');?></a></li><?php endif;?>
						</ul>
					</div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" id="myModal<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><?php esc_html_e('Get Coupon Code', 'comre');?></h4>
					  </div>
					  <div class="modal-body">
						<?php echo sh_set($meta, 'coupon_code');?>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php esc_html_e('Close', 'comre');?></button>
					  </div>
					</div>
				  </div>
				</div>
				
			</div>
		</div>
		
		<?php $posts_data[$t->slug][get_the_id()] = ob_get_clean();
    endforeach; ?>

<?php $count++; endwhile; 
//printr($posts_data);
wp_reset_query();
//$posts_data = ob_get_clean();	
	
ob_start();?>
<section class="coupen-tab">
	<div role="tabpanel"> 
		
		<!--======= COUPON NAV TAB =========-->
		<div class="tab-role">
			<div class="copo-tab">
				<div class="container">
					<ul class="nav nav-tabs">
						<?php if( $filteration ) echo implode("\n", $filteration ); ?>
					</ul>
				</div>
			</div>
			<div class="container"> 
				<!--======= TAB PANES =========-->
				<div class="tab-content">
					<?php $count = 0; 
					if( $posts_data )
					
					foreach( $posts_data as $k => $p_data ): ?>
						<div role="tabpanel" class="tab-pane <?php if( $count == 0 ) echo esc_attr('active'); ?>" id="<?php echo esc_attr( $k ); ?>">
							<div class="row"> <?php echo balanceTags( implode("\n", $p_data ) ); ?> </div>
						</div>
					<?php $count++;
					endforeach; ?>
				</div>
			</div>
		</div>
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
<?php return ob_get_clean();
