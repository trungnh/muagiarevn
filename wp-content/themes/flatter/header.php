<div id="header">

	<div class="holder holder-panel clearfix">

		<div class="frame">

			<div class="panel">
				
				<?php if( fl_get_option( 'fl_enable_dual_navigation' ) ) { 
					
					$top_menu_location = 'top';
				
				} else {
					
					$top_menu_location = 'primary';
					
				}

				wp_nav_menu( array( 'menu_id' => 'nav', 'theme_location' => $top_menu_location, 'container' => '', 'fallback_cb' => false, 'depth' => 2 ) ); ?>

				<div class="bar clearfix">

					<ul class="social">

						<li><a class="rss" href="<?php echo appthemes_get_feed_url(); ?>" rel="nofollow" target="_blank"><i class="fa fa-rss"></i><?php _e( 'RSS', APP_TD ); ?></a></li>

						<?php if ( ! empty( $clpr_options->facebook_id ) ) { ?>
							<li><a class="facebook" href="<?php echo appthemes_make_fb_profile_url( $clpr_options->facebook_id ); ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<?php } ?>

						<?php if ( ! empty( $clpr_options->twitter_id ) ) { ?>
							<li><a class="twitter" href="https://twitter.com/<?php echo stripslashes( $clpr_options->twitter_id ); ?>" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<?php } ?>

					</ul>

					<ul class="add-nav">

						<?php clpr_login_head(); ?>

					</ul>

				</div>

			</div>

		</div> <!-- #frame -->

	</div> <!-- #holder -->
	
	<div class="holder holder-logo clearfix">
		
		<div class="frame">
			
			<div class="header-bar">
				
				<div id="logo">
					
					<?php if ( get_header_image() ) { ?>
						<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php header_image(); ?>" class="header-logo" alt="" />
						</a>
					<?php } else if ( display_header_text() ) { ?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
					<?php } ?>
					<?php if ( display_header_text() ) { ?>
						<div class="description" style="color: #ffffff"><?php bloginfo( 'description' ); ?></div>
					<?php } ?>
					
				</div>
				
			</div>
			
		</div> <!-- #frame -->
		
	</div> <!-- #holder -->
	
	<?php if( fl_get_option( 'fl_enable_dual_navigation' ) ) { ?>
	
		<div class="header_menu">

			<div class="header_menu_res">
			
				<a class="menu-toggle" href="#"><i class="fa fa-reorder"></i><?php _e( 'Navigation', APP_TD ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => false, 'container' => false, 'depth' => 3 ) ); ?>
				
				<?php if( fl_get_option( 'fl_navigation_share_coupon' ) ) { ?>
					<a href="<?php echo clpr_get_submit_coupon_url(); ?>" class="obtn btn"><?php echo fl_get_option( 'fl_lbl_share_coupon' ); ?></a>
				<?php } ?>
				<?php get_search_form(); ?>
				<div class="clr"></div>

			</div><!-- /header_menu_res -->

		</div><!-- /header_menu -->
		
	<?php } ?>

</div> <!-- #header -->
