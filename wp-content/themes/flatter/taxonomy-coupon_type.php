<?php $term = get_queried_object(); ?>

<div id="content">


	<div class="content-box">

		<div class="box-c">

			<div class="box-holder">

				<div class="store">

					<div class="text-box">
						<a class="rss-link" href="<?php echo get_term_feed_link( $term->term_id, $taxonomy ); ?>" rel="nofollow" target="_blank"><?php _e( 'Coupon Type RSS', APP_TD ); ?></a>
						<h1><?php printf( __( '%s', APP_TD ), $term->name ); ?></h1>
						<div class="desc"><?php echo term_description(); ?></div>
					</div> <!-- #text-box -->

					<div class="clr"></div>

				</div> <!-- #store -->

			</div> <!-- #box-holder -->

		</div> <!-- #box-c -->

	</div> <!-- #content-box -->


	<div class="content-box">

		<div class="box-c">

			<div class="box-holder">

				<div class="head">

					<h2><?php _e( 'MÃ GIẢM GIÁ ĐANG HOẠT ĐỘNG', APP_TD ); ?></h2>

					<?php
						// show all active coupons for this type and setup pagination
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						query_posts( array(
							'post_type' => APP_POST_TYPE,
							'post_status' => 'publish',
							APP_TAX_TYPE => $term->slug,
							'ignore_sticky_posts' => 1,
							'paged' => $paged
						) );

						// singular or plural for counter
						$foundtxt = _n( 'Có %s mã giảm giá', 'Có %s mã giảm giá', $wp_query->found_posts, APP_TD );
					?>

					<div class="counter"><?php printf( $foundtxt, '<span>'. $wp_query->found_posts . '</span>' ); ?></div>

				</div> <!-- #head -->

				<?php get_template_part( 'loop', 'coupon' ); ?>

			</div> <!-- #box-holder -->

		</div> <!-- #box-c -->

		<div class="box-b">&nbsp;</div>

	</div> <!-- #content-box -->


	<div class="content-box">

		<div class="box-t">&nbsp;</div>

		<div class="box-c">

			<div class="box-holder">

				<div class="head">

					<h2><?php _e( 'MÃ GIẢM GIÁ HẾT HẠN', APP_TD ); ?></h2>

					<?php
						// show all unreliable coupons for this type and setup pagination
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						query_posts( array(
							'post_type' => APP_POST_TYPE,
							'post_status' => 'unreliable',
							APP_TAX_TYPE => $term->slug,
							'ignore_sticky_posts' => 1,
							'paged' => $paged
						) );

						// singular or plural for counter
						$foundtxt = _n( 'Có %s mã giảm giá', 'Có %s mã giảm giá', $wp_query->found_posts, APP_TD );
					?>

					<div class="counter-red"><?php printf( $foundtxt, '<span>'. $wp_query->found_posts . '</span>' ); ?></div>

				</div> <!-- #head -->

				<?php get_template_part( 'loop', 'coupon' ); ?>

			</div> <!-- #box-holder -->

		</div> <!-- #box-c -->

	</div> <!-- #content-box -->


</div><!-- #content -->

<?php wp_reset_query(); ?>

<?php get_sidebar('coupon'); ?>
