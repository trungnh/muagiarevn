<?php
get_header();
the_post();
get_template_part( 'includes/inner_header' );
global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'post_type' => 'post' ) );
$main_query = new WP_Query( $args );

$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$page_links_total =  $main_query->max_num_pages;
$page_links = paginate_links( 
				array(
					'prev_next' => true,
					'end_size' => 2,
					'mid_size' => 2,
					'total' => $page_links_total,
					'current' => $cur_page,	
					'prev_next' => false,
					'type' => 'array'
				)
			 );
?>
<!-- blog-home -->
<section class="blog-home">

	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">

			<!-- blog-home-container -->
			<div class="col-md-<?php echo is_active_sidebar('sidebar-right_blog') ? '9' : '12' ?>">
				
				<?php if( $main_query->have_posts() ): ?>
					<!-- row -->
					<div class="row">
						<?php while( $main_query->have_posts() ): ?>
							<?php $main_query->the_post() ?>

							<!-- blog-post-1 -->
							<div class="col-md-12">
								<div <?php post_class( 'blog-post' ); ?>>

									<div class="blog-inner blog-inner-home">
										
										<!-- blog-image -->
										<?php if( has_post_thumbnail() ): ?>
											<div class="image-placeholder col-md-5">
												<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'listing-blog-wull-width' ) ); ?>
											</div>
										<?php endif; ?>
										<!-- .blog-image -->

										<!-- blog-post-content -->
										<div class="blog-post-content col-md-<?php echo has_post_thumbnail() ? '7' : '12' ?>">
											<div class="item-meta blog-meta">
												<ul class="list-inline list-unstyled">
													<li>
														<a href="javascript:;">
															<span class="fa fa-clock-o"></span><?php the_time( 'F j, Y' ) ?></a>
													</li>
													<li>
														<a href="javascript:;">
															<span class="fa fa-user"></span><?php the_author(); ?></a>
													</li>
													<li>
														<a href="javascript:;"><span class="fa fa-bars"></span></a>
														<?php echo coupon_categories_list( get_the_category() ); ?>
													</li>
													<li>
														<a href="<?php the_permalink(); ?>">
															<span class="fa fa-comment"></span><?php comments_number( '0', '1', '%' ); ?>
														</a>
													</li>
												</ul>
											</div>

											<!-- title -->
											<div class="blog-caption caption">
												<h3><?php the_title(); ?></h3>
											</div>
											<!-- .title -->

											<!-- blog-post-text -->
											<div class="text">
												<?php echo coupon_the_excerpt(); ?>
											</div>
											<!-- .blog-post-text -->

											<!-- blog-single-lead-icon -->
											<div class="blog-single-lead-icon pull-right <?php echo has_post_thumbnail() ? '' : 'pad-bottom-plus' ?>">
												<a href="<?php the_permalink(); ?>">
													<span class="fa fa-plus-square green"></span>
												</a>
											</div>
											<!-- .blog-single-lead-icon -->

										</div>
										<!-- .blog-post-content -->

									</div>

								</div>
							</div>
							<!-- .blog-post-1 -->
						<?php endwhile; ?>
						<?php if( !empty( $page_links ) ): ?>
							<!-- pagination -->
							<div class="blog-pagination col-md-12">
								<ul class="pagination">
									<?php echo coupon_format_pagination( $page_links ); ?>
								</ul>
							</div>
							<!-- .pagination -->
						<?php endif; ?>

					</div>
					<!-- .row -->
				<?php else: ?>
					<p><?php _e( 'No blog posts yet!', 'coupon' ); ?></p>
				<?php endif; ?>
			</div>
			<!-- .blog-home-container -->

			<!-- sidebar -->
			<div class="col-md-3">
				<?php 
				wp_reset_query();
				get_sidebar('right_blog'); 
				?>
			</div>
			<!-- .sidebar -->


		</div>
		<!-- .row -->
	</div>
	<!-- .container -->

</section>
<!-- .blog-home -->
<?php
get_template_part( 'includes/shop_carousel' );
get_footer();
?>