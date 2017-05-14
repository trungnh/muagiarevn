<?php
/**
 * Generic Header template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>


<div id="header">

	<div class="shadow">&nbsp;</div>

	<div class="holder">

		<div class="frame">

			<div class="panel">

				<?php wp_nav_menu( array( 'menu_id' => 'nav', 'theme_location' => 'primary', 'container' => '', 'fallback_cb' => false ) ); ?>

				<div class="bar">

					<ul class="social">

						<li><a class="rss" href="<?php echo appthemes_get_feed_url(); ?>" rel="nofollow" target="_blank"><?php _e( 'RSS', APP_TD ); ?></a></li>

						<?php if ( ! empty( $clpr_options->facebook_id ) ) { ?>
							<li><a class="facebook" href="<?php echo appthemes_make_fb_profile_url( $clpr_options->facebook_id ); ?>" rel="nofollow" target="_blank"><?php _e( 'Facebook', APP_TD ); ?></a></li>
						<?php } ?>

						<?php if ( ! empty( $clpr_options->twitter_id ) ) { ?>
							<li><a class="twitter" href="https://twitter.com/<?php echo stripslashes( $clpr_options->twitter_id ); ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
						<?php } ?>

					</ul>

					<ul class="add-nav">

						<?php clpr_login_head(); ?>

					</ul>

				</div>

			</div>

			<div class="header-bar">

				<?php get_search_form(); ?>

				<div id="logo">

					<?php if ( get_header_image() ) { ?>
						<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php header_image(); ?>" class="header-logo" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
						</a>
					<?php } else if ( display_header_text() ) { ?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
					<?php } ?>
					<?php if ( display_header_text() ) { ?>
						<div class="description"><?php bloginfo( 'description' ); ?></div>
					<?php } ?>

				</div>

			</div>

		</div> <!-- #frame -->

	</div> <!-- #holder -->

</div> <!-- #header -->
