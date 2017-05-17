<?php global $product, $post;

$options = _WSH()->option();
//wp_enqueue_script( array( 'jquery-flexslider' ) );
get_header(); 

$meta1 = _WSH()->get_meta('_sh_header_settings');
$meta2 = _WSH()->get_meta();

$bg = sh_set($meta1, 'bg_image');
$title = sh_set( $meta1, 'header_title' ); 

 // Header Code ?>

<!--======= BANNER =========-->

<section class="sub-banner" <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>>
	<div class="overlay">
		<div class="container">
			<h2>
				<?php if($title) echo  balanceTags( $title ); else echo get_the_title();?>
			</h2>
			<?php echo get_the_breadcrumb();?>
		</div>
	</div>
</section>

<section class="blog coupon-detail-page woocommerce">
	<div class="container">

		<?php if( function_exists('WC')) wc_print_notices(); ?>

		<ul class="row">
			
			<!-- end sidebar -->
			<li class="col-sm-9">
				<?php $count = 1;
				
				while( have_posts() ): the_post(); 

					$post_meta = _WSH()->get_meta();

					if(sh_set( $post_meta, 'is_purchaseable') && function_exists('WC')) {
						$product = new WC_Product( get_the_id() );
						$product->product_type = ($product->get_type()) ? $product->get_type() : 'simple';

					} ?>
                    <?php 
				       $buton_title = (sh_set($post_meta, 'buttons_title')) ? sh_set($post_meta, 'buttons_title') : 'get coupon code'; 
				   ?>
					<div class="row">
						<div class="col-md-4">
							<?php the_post_thumbnail('830x390', array('class'=>'img-responsive')) ?>
							
							<?php if(!sh_set( $post_meta, 'is_purchaseable')): ?>
								
								<?php $ext_link =  sh_set($post_meta, 'coupon_link') ? ' data-href="'. sh_set($post_meta, 'coupon_link').'" target="_blank"' : ''; ?>
                        
								<?php if(sh_set($post_meta, 'coupon_display_type') == 'coupon_popup'):?>
									
									<div class="text-center"> 
										<a<?php echo $ext_link; ?> href="<?php echo sh_set($post_meta, 'coupon_link');?>" class="btn get_coupon_code" data-toggle="modal" data-target="#myModal<?php the_ID();?>"><?php echo $buton_title;?></a> 
									</div>
								
								<?php else:?>
										<div class="text-center"> <a<?php echo $ext_link; ?> href="<?php echo sh_set($post_meta, 'coupon_link');?>" class="btn get_coupon_code" data-text="<?php echo sh_set($post_meta, 'coupon_code');?>" id="get_coupon_code<?php the_id(); ?>" target="blank"><?php echo $buton_title;?></a> </div>
								<?php endif;?>
								
								<!-- Modal -->
								<div class="modal fade" id="myModal<?php the_ID();?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

							<?php endif; ?>

							<div class="share-post text-center">
								<h5 class="text-uppercase"><?php esc_html_e('share this post', 'comre');?></h5>
								<ul class="social_icons">
									<li class="facebook"><a href="javascript:void(0);" title="Facebook"><i class="fa fa-facebook st_facebook_large"></i></a></li>
									<li class="twitter"><a href="javascript:void(0);" title="Twitter"><i class="fa fa-twitter st_twitter_large"></i></a></li>
									<li class="linkedin"><a href="javascript:void(0);" title="Linkedin"><i class="fa fa-linkedin st_linkedin_large"></i></a></li>
									<li class="tumblr"><a href="javascript:void(0);" title="Tumblr"><i class="fa fa-tumblr st_tumblr_large"></i></a></li>
								</ul>
								<script type="text/javascript">var switchTo5x=true;</script> 
								<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script> 
								<script type="text/javascript">stLight.options({publisher: "e5f231e9-4404-49b7-bc55-0e8351a047cc", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> 
							</div>

						</div>
						
						<!--======= BLOG POST=========-->
						<div class="col-md-8">
							
							<div class="blog-post">
								<a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>" class="title-hed">
								<?php the_title(); ?>
								</a> 
								<?php if(sh_set( $post_meta, 'is_purchaseable') && function_exists('WC')): ?>
									<?php woocommerce_template_loop_price();?>
								<?php endif; ?>
							
								<?php the_content();?>
								
								<?php if(sh_set( $post_meta, 'is_purchaseable') && function_exists('WC')): ?>
									<?php woocommerce_template_single_add_to_cart(); ?>
								<?php endif; ?>
							
							</div>
						</div>
					</div>
					<!--======= SHARE POST =========-->
				
					<!-- end button -->
					<div class="clearfix"></div>
					
					<!--=======  COMMENTS =========-->
					<?php $post_id = get_the_id();
					$post_url = get_permalink($post_id); ?>
					<div id="disqus_thread"></div>
				    <script type="text/javascript">
					    /* * * CONFIGURATION VARIABLES: THIS CODE IS ONLY AN EXAMPLE * * */
					    var disqus_shortname = '<?php echo (sh_set( $options, 'disqus_idetifier')) ? esc_js(sh_set( $options, 'disqus_idetifier') ) : esc_js('example'); ?>'; // Required - Replace example with your forum shortname
					    var disqus_identifier = 'disqus_thread<?php echo $post_id; ?>';
					    var disqus_title = '<?php echo get_the_title(); ?>';
					    var disqus_url = '<?php echo esc_url($post_url); ?>';

					    /* * * DON'T EDIT BELOW THIS LINE * * */
					    (function() {
					        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					    })();
					</script>
			
				<?php endwhile;?>
			</li>

			<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>
			<li class="col-sm-3">
				<div class="blog-side-bar">
					<?php dynamic_sidebar( 'default-sidebar' ); ?>
				</div>
			</li>
			<?php endif; ?>
		
		</ul>
	</div>
</section>
<?php get_footer(); ?>
