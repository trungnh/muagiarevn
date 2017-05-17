<?php $options = _WSH()->option();
//wp_enqueue_script( array( 'jquery-flexslider' ) );
get_header(); 
$settings  = sh_set(sh_set(get_post_meta(get_the_ID(), 'sh_page_meta', true) , 'sh_page_options') , 0);
$meta = _WSH()->get_meta('_sh_layout_settings');
$meta1 = _WSH()->get_meta('_sh_header_settings');
$meta2 = _WSH()->get_meta();

$bg = sh_set($meta1, 'bg_image');
$title = sh_set( $meta1, 'header_title' ); 
_WSH()->page_settings = $meta;

$layout = sh_set( $meta, 'layout', 'full' );
if( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) $sidebar = ''; else
$sidebar = sh_set( $meta, 'sidebar', 'product-sidebar' );
$classes = ( !$layout || $layout == 'full' || sh_set($_GET, 'layout_style')=='full' ) ? '  col-sm-12' : ' col-sm-9';
/** Update the post views counter */
_WSH()->post_views( true );
 // Header Code ?>

<!--======= BANNER =========-->

<section class="sub-banner" <?php if($bg):?>style="background-image: url('<?php echo esc_url($bg); ?>');"<?php endif;?>>
	<div class="overlay">
		<div class="container">
			<h2>
				<?php if($title) echo  balanceTags( $title ); else wp_title('');?>
			</h2>
			<?php echo get_the_breadcrumb();?>
		</div>
	</div>
</section>

<section class="blog">
	<div class="container">
		<ul class="row">
			<?php if( $layout == 'left' ): ?>
				<?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<div class="col-sm-3">
					<div id="sidebar" class="clearfix">
						<?php dynamic_sidebar( $sidebar ); ?>
					</div>
				</div>
				<?php } ?>
			<?php endif; ?>
			<!-- end sidebar -->
			<li class="col-sm-9">
				<?php while( have_posts() ): the_post(); ?>
					
					<!--======= BLOG POST=========-->
					<div class="blog-post">
						<?php the_post_thumbnail('830x390', array('class'=>'img-responsive')) ?>
						<span class="post-date-big">
						<?php  echo get_the_date('d');?>
						<br>
						<?php echo get_the_date('M')?></span> <a href="<?php the_permalink();?>" class="title-hed">
						<?php the_title(); ?>
						</a> 
						
						<!--======= TAGS =========-->
						<ul class="small-tag">
							<li>
								<?php /* for categories without anchor*/ $term_list = wp_get_post_terms(get_the_id(), 'category', array("fields" => "names")); ?>
								<span><i class="fa fa-tag"></i><?php echo implode( ', ', (array)$term_list );?></span> / <span><i class="fa fa-user"></i>
								<?php esc_html_e('By', 'comre')?>
								<?php the_author();?>
								</span> / <span> <i class="fa fa-comments"></i>
								<?php comments_number();?>
								</span> / <span> <i class="fa fa-eye"></i>  <a class="post_view" href="javascript:void(0);"><?php echo _WSH()->post_views(); ?> <?php esc_html_e('Viewers', 'comre'); ?></a></span> </li>
						</ul>
						
						<?php the_content();?>
						
						<div class="tags"></div>
						<?php the_tags(); ?>
					</div>
	
					<!--======= SHARE POST =========-->
					<div class="share-post">
						<h3 class="pull-left text-uppercase"><?php esc_html_e('share this post', 'comre');?></h3>
						<ul class="social_icons pull-right">
							<li class="facebook"><a href="javascript:void(0);" title="Facebook"><i class="fa fa-facebook st_facebook_large"></i></a></li>
							<li class="twitter"><a href="javascript:void(0);" title="Twitter"><i class="fa fa-twitter st_twitter_large"></i></a></li>
							<li class="linkedin"><a href="javascript:void(0);" title="Linkedin"><i class="fa fa-linkedin st_linkedin_large"></i></a></li>
							<li class="tumblr"><a href="javascript:void(0);" title="Tumblr"><i class="fa fa-tumblr st_tumblr_large"></i></a></li>
						</ul>
						<script type="text/javascript">var switchTo5x=true;</script> 
						<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script> 
						<script type="text/javascript">stLight.options({publisher: "e5f231e9-4404-49b7-bc55-0e8351a047cc", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script> 
					</div>
	
					<!-- end button -->
					<div class="clearfix"></div>
					
					<?php wp_link_pages(array('before'=>'<div class="paginate-links">'.__('Pages: ', 'comre'), 'after' => '</div>', 'link_before'=>'<span>', 'link_after'=>'</span>')); ?>
					
					<!--======= ADMIN INFO =========-->
					<div class="admin-info">
						<h6 class="text-uppercase">
							<?php esc_html_e('About thr author : ', 'comre')?>
							<?php the_author();?>
						</h6>
						<ul class="row">
							<li class="col-xs-2"><?php echo get_avatar('',80);?></li>
							<li class="col-xs-10">
								<p>
									<?php the_author_meta( 'description', get_the_author_meta('ID') ); ?>
								</p>
							</li>
						</ul>
						
						<!--======= SOCIAL ICONS =========-->
						<ul class="social_icons">
							<?php $socials = array('facebook'=>'fa-facebook', 'twitter'=>'fa-twitter', 'linkedin'=>'fa-linkedin', 'pinterest'=>'fa-pinterest','tumblr'=>'fa-tumblr', 'googleplus'=>'fa-google-plus');
								  foreach( $socials as $social => $clas ):  
								  
									if( $value = get_user_meta(get_the_author_meta('ID'), $social, true)):?>
							<li class="<?php echo esc_attr($social); ?>"> <a href="<?php echo esc_url( $value ); ?>"><i class="fa <?php echo esc_attr($clas); ?>"></i> </a></li>
							<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
	
					<!--=======  POST NAVIGATION =========-->
					<div class="post-navi">
						<ul class="row">
							<?php $prev_post = get_previous_post();
								  $next_post = get_next_post(); ?>
							
							<?php if( $prev_post ): ?>
								<!--=======  PREVIES POST =========-->
								<li class="col-md-6">
									<div class="row">
										<div class="col-xs-4"> <a href="<?php echo get_permalink($prev_post->ID); ?>" title="<?php echo get_the_title( $prev_post->ID ); ?>"> <?php echo get_the_post_thumbnail( $prev_post->ID, 'thumbnail', array('class' => 'img-responsive') ); ?> </a> </div>
										<div class="col-xs-8"> <a href="<?php echo get_permalink($prev_post->ID); ?>" title="<?php echo get_the_title( $prev_post->ID ); ?>"> <span><i class="fa fa-angle-double-left"></i>
											<?php esc_html_e('Previous Post', 'comre');?>
											</span> <span class="hiding"><?php echo get_the_title( $prev_post->ID ); ?></span> </a> </div>
									</div>
								</li>
							<?php endif; ?>

							<?php if( $next_post ): ?>
								<!--=======  NEXT POST =========-->
								<li class="col-md-6">
									<div class="row">
										<div class="col-xs-8 text-right"> <a href="<?php echo get_permalink($next_post->ID); ?>" title="<?php echo get_the_title( $next_post->ID ); ?>"> <span>
											<?php esc_html_e('Next Post', 'comre')?>
											<i class="fa fa-angle-double-right"></i></span> <span class="hiding"><?php echo get_the_title( $next_post->ID ); ?></span> </a> </div>
										<div class="col-xs-4"> <a href="<?php echo get_permalink($next_post->ID); ?>" title="<?php echo get_the_title( $next_post->ID ); ?>"> <?php echo get_the_post_thumbnail( $next_post->ID, 'thumbnail', array('class' => 'img-responsive') ); ?> </a> </div>
									</div>
								</li>
							<?php endif; ?>
						</ul>
					</div>
	
					<!--=======  COMMENTS =========-->
					<?php comments_template(); ?>
			
				<?php endwhile;?>
			</li>
			

			<?php if( $layout == 'right' ): ?>
				<?php if ( is_active_sidebar( $sidebar ) ) { ?>
				<li class="col-sm-3">
					<div class="blog-side-bar">
						<?php dynamic_sidebar( $sidebar ); ?>
					</div>
				</li>
				<?php } ?>
			<?php endif; ?>
		</ul>
	</div>
</section>
<?php get_footer(); ?>
