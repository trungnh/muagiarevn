<?php
/**
 * Action and filter hooks.
 *
 * @package Clipper\Actions
 * @author  AppThemes
 * @since   Clipper 1.0
 */


/**
 * Adds version number in the header for troubleshooting.
 *
 * @return void
 */
function clpr_generator() {
	echo "\n\t" . '<meta name="generator" content="Clipper ' . CLPR_VERSION . '" />' . "\n";
}
add_action( 'wp_head', 'clpr_generator' );


/**
 * Adds the google analytics tracking code in the footer.
 *
 * @return void
 */
function clpr_google_analytics_code() {
	global $clpr_options;

	if ( empty( $clpr_options->google_analytics ) ) {
		return;
	}

	echo stripslashes( $clpr_options->google_analytics );
}
add_action( 'wp_footer', 'clpr_google_analytics_code' );


/**
 * Adds the debug code to the footer.
 *
 * You must add following code to the wp-config.php file in order to see queries:
 * define( 'WP_DEBUG', true );
 * define( 'SAVEQUERIES', true );
 *
 * NOTE: This will have a performance impact on your site, so make sure to turn this off when you aren't debugging.
 *
 * @return void
 */
function clpr_add_after_footer() {
	global $wpdb, $wp_query, $clpr_options;

	if ( ! $clpr_options->debug_mode || ! current_user_can( 'manage_options' ) ) {
		return;
	}
?>
	<div class="clr"></div>
	<div class="debug">
		<h3><?php _e( 'Debug Mode On', APP_TD ); ?></h3>
		<br /><br />
		<h3>$wp_query->query_vars output</h3>
		<p><pre><?php print_r( $wp_query->query_vars ); ?></pre></p>
		<br /><br />
		<h3>$wpdb->queries output</h3>
		<p><pre><?php print_r( $wpdb->queries ); ?></pre></p>
	</div>

<?php
}
add_action( 'appthemes_after_footer', 'clpr_add_after_footer' );


/**
 * Sets custom favicon if specified in theme settings.
 *
 * @param string $favicon
 *
 * @return string
 */
function clpr_custom_favicon( $favicon ) {
	global $clpr_options;

	if ( ! empty( $clpr_options->favicon_url ) ) {
		$favicon = $clpr_options->favicon_url;
	}

	return $favicon;
}
add_filter( 'appthemes_favicon', 'clpr_custom_favicon', 10, 1 );


/**
 * Adds the colorbox to blog post galleries.
 *
 * @return void
 */
function clpr_colorbox_blog() {
?>
	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function($){
			$(".gallery").each(function(index, obj){
				var galleryid = Math.floor(Math.random()*10000);
				$(obj).find("a").colorbox({rel:galleryid, maxWidth:"95%", maxHeight:"95%"});
			});
			$("a.lightbox").colorbox({maxWidth:"95%", maxHeight:"95%"});
		});
	// ]]>
	</script>
<?php
}
add_action( 'appthemes_before_blog_loop', 'clpr_colorbox_blog' );


/**
 * Adds the post meta before the blog post content.
 *
 * @return void
 */
function clpr_blog_post_meta() {
	if ( is_page() ) {
		return;
	}
?>
	<div class="content-bar">
		<p class="meta">
			<span>
				<time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
				<time class="entry-date updated" datetime="<?php echo get_the_modified_date( 'c' ); ?>"><?php echo get_the_modified_date(); ?></time>
			</span>
			<i><?php the_category( '<span class="sep">, </span>' ); ?></i>
		</p>
		<p class="comment-count"><?php comments_popup_link( __( '0 Comments', APP_TD ), __( '1 Comment', APP_TD ), __( '% Comments', APP_TD ) ); ?></p>
	</div>
<?php
}
add_action( 'appthemes_before_blog_post_content', 'clpr_blog_post_meta' );


/**
 * Adds the pagination to the coupons lists.
 *
 * @return void
 */
function clpr_coupon_pagination() {
	if ( is_singular( APP_POST_TYPE ) ) {
		return;
	}

	appthemes_pagination();
?>

	<div class="top"><a href="#top"><?php _e( 'Top', APP_TD ); ?> &uarr;</a></div>

<?php
}
add_action( 'appthemes_after_endwhile', 'clpr_coupon_pagination' );
add_action( 'appthemes_after_search_endwhile', 'clpr_coupon_pagination' );


/**
 * Adds the pagination to blog posts lists.
 *
 * @return void
 */
function clpr_blog_pagination() {
	if ( is_singular( 'post' ) ) {
		return;
	}
?>
	<div class="content-box">

		<div class="box-holder">

			<?php appthemes_pagination(); ?>

			<div class="top"><a href="#top"><?php _e( 'Top', APP_TD ); ?> &uarr;</a></div>

		</div>

	</div>
<?php
}
add_action( 'appthemes_after_blog_endwhile', 'clpr_blog_pagination' );


/**
 * Adds the share coupon button to sidebar.
 *
 * @return void
 */
function clpr_sidebar_share_button() {
?>

	<a href="<?php echo clpr_get_submit_coupon_url(); ?>" class="share-box">
		<img src="<?php echo appthemes_locate_template_uri( 'images/share_icon.png' ); ?>" title="" alt="" />
		<span class="lgheading"><?php _e( 'Share a Coupon', APP_TD ); ?></span>
		<span class="smheading"><?php _e( 'Spread the Savings with Everyone!', APP_TD ); ?></span>
	</a>

<?php
}
//add_action( 'appthemes_before_sidebar_widgets', 'clpr_sidebar_share_button' );


/**
 * Adds the post tags, and stats after the blog post content.
 *
 * @return void
 */
function clpr_blog_post_tags() {
	global $post, $clpr_options;

	if ( is_page() ) {
		return;
	}
?>

	<div class="text-footer">

		<div class="tags"><?php _e( 'Tags:', APP_TD ); ?> <?php if ( get_the_tags() ) the_tags( ' ', ', ', '' ); else echo ' ' . __( 'None', APP_TD ); ?></div>

		<?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) { ?>
			<div class="stats"><?php appthemes_stats_counter( $post->ID ); ?></div>
		<?php } ?>

		<div class="author vcard">
			<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a>
		</div>

		<div class="clear"></div>

	</div>

<?php
}
add_action( 'appthemes_after_blog_post_content', 'clpr_blog_post_tags' );


/**
 * Adds the author box after the blog post content.
 *
 * @return void
 */
function clpr_author_box() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( ! get_the_author_meta( 'description' ) ) {
		return;
	}
?>

	<div class="author-wrap">

		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'clpr_author_bio_avatar_size', 60 ) ); ?>

		<p class="author"><?php printf( esc_attr__( 'About %s', APP_TD ), get_the_author() ); ?></p>
		<p><?php the_author_meta( 'description' ); ?></p>

	</div>

<?php
}
add_action( 'appthemes_after_blog_post_content', 'clpr_author_box' );


/**
 * Adds the user bar box after the blog post content.
 *
 * @return void
 */
function clpr_user_bar_box() {
  global $post;

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	// assemble the text and url we'll pass into each social media share link
	$social_text = urlencode( strip_tags( get_the_title() . ' ' . __( 'post from', APP_TD ) . ' ' . get_bloginfo( 'name' ) ) );
	$social_url  = urlencode( get_permalink( $post->ID ) );
?>

	<div class="user-bar">

		<?php if ( comments_open() ) comments_popup_link( ( '<span>' . __( 'Leave a comment', APP_TD ) . '</span>' ), ( '<span>' . __( 'Leave a comment', APP_TD ) . '</span>' ), ( '<span>' . __( 'Leave a comment', APP_TD ) . '</span>' ), 'leave', '' ); ?>

		<ul class="social">
			<li><a class="rss" href="<?php echo get_post_comments_feed_link( get_the_ID() ); ?>" rel="nofollow"><?php _e( 'Post Comments RSS', APP_TD ); ?></a></li>
			<li><a class="twitter" href="https://twitter.com/home?status=<?php echo $social_text; ?>+-+<?php echo $social_url; ?>" target="_blank" rel="nofollow"><?php _e( 'Twitter', APP_TD ); ?></a></li>
			<li><a class="facebook" href="javascript:void(0);" onclick="window.open('https://www.facebook.com/sharer.php?t=<?php echo $social_text; ?>&amp;u=<?php echo $social_url; ?>','doc', 'width=638,height=500,scrollbars=yes,resizable=auto');" rel="nofollow"><?php _e( 'Facebook', APP_TD ); ?></a></li>
			<li><a class="digg" href="https://digg.com/submit?phase=2&amp;url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" target="_blank" rel="nofollow"><?php _e( 'Digg', APP_TD ); ?></a></li>
		</ul>

	</div>

<?php
}
add_action( 'appthemes_after_blog_post_content', 'clpr_user_bar_box' );


/**
 * Modifies Social Connect plugin redirect to url.
 * @since 1.3.1
 *
 * @param string
 *
 * @return string
 */
function clpr_social_connect_redirect_to( $redirect_to ) {
	if ( preg_match( '#/wp-(admin|login)?(.*?)$#i', $redirect_to ) ) {
		$redirect_to = home_url();
	}

	if ( current_theme_supports( 'app-login' ) ) {
		if ( APP_Login::get_url( 'redirect' ) == $redirect_to || appthemes_get_registration_url( 'redirect' ) == $redirect_to ) {
			$redirect_to = home_url();
		}
	}

	return $redirect_to;
}
add_filter( 'social_connect_redirect_to', 'clpr_social_connect_redirect_to', 10, 1 );


/**
 * Processing Social Connect plugin request if App Login pages are enabled.
 * @since 1.3.2
 *
 * @return void
 */
function clpr_social_connect_login() {
	if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'social_connect' ) {
		if ( current_theme_supports( 'app-login' ) && function_exists( 'sc_social_connect_process_login' ) ) {
			sc_social_connect_process_login( false );
		}
	}
}
add_action( 'init', 'clpr_social_connect_login' );


/**
 * Adds reCaptcha theme support.
 * @since 1.3.2
 *
 * @return void
 */
function clpr_recaptcha_support() {
	global $clpr_options;

	if ( ! $clpr_options->captcha_enable ) {
		return;
	}

	add_theme_support( 'app-recaptcha', array(
		'file' => get_template_directory() . '/includes/lib/recaptchalib.php',
		'theme' => $clpr_options->captcha_theme,
		'public_key' => $clpr_options->captcha_public_key,
		'private_key' => $clpr_options->captcha_private_key,
	) );

	add_filter( 'registration_errors', 'clpr_recaptcha_verify' );
}
add_action( 'appthemes_init', 'clpr_recaptcha_support' );
add_action( 'register_form', 'appthemes_recaptcha' );

function clpr_recaptcha_verify( $errors ) {

	list( $options ) = get_theme_support( 'app-recaptcha' );

	require_once( $options['file'] );

	// Check and make sure the reCaptcha values match.
	$resp = recaptcha_check_answer( $options['private_key'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'] );

	if ( ! $resp->is_valid ) {
		$errors->add( 'invalid_recaptcha', __( '<strong>ERROR</strong>: The reCaptcha anti-spam response was incorrect.', APP_TD ) );
	}

	return $errors;
}


/**
 * Displays 336 x 280 Ad box.
 * @since 1.4
 *
 * @return void
 */
function clpr_adbox_336x280() {
	global $clpr_options;

	if ( ! $clpr_options->adcode_336x280_enable ) {
		return;
	}

	if ( ! empty( $clpr_options->adcode_336x280 ) ) {
		echo stripslashes( $clpr_options->adcode_336x280 );
	} else {
		if ( $clpr_options->adcode_336x280_url ) {
			$img = html( 'img', array( 'src' => $clpr_options->adcode_336x280_url, 'alt' => '' ) );
			echo html( 'a', array( 'href' => $clpr_options->adcode_336x280_dest, 'target' => '_blank' ), $img );
		}
	}

}


/**
 * Adds advertise to single blog page.
 * @since 1.4
 *
 * @return void
 */
function clpr_adbox_single_page() {
	global $clpr_options;

	if ( ! is_singular( array( 'post' ) ) ) {
		return;
	}

	if ( ! $clpr_options->adcode_336x280_enable ) {
		return;
	}
?>
	<div class="content-box">

		<div class="box-holder">

			<div class="post-box">

				<div class="head">

					<h3><?php _e( 'Sponsored Ads', APP_TD ); ?></h3>

				</div>

				<div class="text-box">

					<?php clpr_adbox_336x280(); ?>

				</div>

			</div>

		</div>

	</div>
<?php
}
add_action( 'appthemes_advertise_content', 'clpr_adbox_single_page' );


/**
 * Disables WordPress 'auto-embeds' option.
 * @since 1.5
 *
 * @return void
 */
function clpr_disable_auto_embeds() {
	global $clpr_options;

	if ( $clpr_options->allow_html ) {
		return;
	}

	remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
}
add_action( 'init', 'clpr_disable_auto_embeds' );


/**
 * Checks and updates coupon status, unreliable vs. publish.
 * @since 1.5
 *
 * @return void
 */
function clpr_maybe_update_coupon_status() {
	global $post;

	if ( ! in_the_loop() || $post->post_type != APP_POST_TYPE ) {
		return;
	}

	clpr_status_update( $post->ID, $post->post_status );
}
add_action( 'appthemes_before_post', 'clpr_maybe_update_coupon_status' );


/**
 * Pings 'update services' while publish coupon.
 * @since 1.5
 */
add_action( 'publish_' . APP_POST_TYPE, '_publish_post_hook', 5, 1 );


/**
 * Moves social URLs into custom fields on user registration.
 * @since 1.5
 *
 * @return void
 */
function clpr_move_social_url_on_user_registration( $user_id ) {

	$user_info = get_userdata( $user_id );

	if ( empty( $user_info->user_url ) ) {
		return;
	}

	if ( preg_match( '#facebook.com#i', $user_info->user_url ) ) {
		wp_update_user( array ( 'ID' => $user_id, 'user_url' => '' ) );
		update_user_meta( $user_id, 'facebook_id', $user_info->user_url );
	}
}
add_action( 'user_register', 'clpr_move_social_url_on_user_registration' );


/**
 * Make the options object instantly available in templates.
 * @since 1.5
 *
 * @return void
 */
function clpr_set_default_template_vars() {
	global $clpr_options;

	appthemes_add_template_var( 'clpr_options', $clpr_options );
}
add_action( 'template_redirect', 'clpr_set_default_template_vars' );


/**
 * Disables some WordPress features.
 * @since 1.5
 *
 * @return void
 */
function clpr_disable_wp_features() {
	global $clpr_options;

	// remove the WordPress version meta tag
	if ( $clpr_options->remove_wp_generator ) {
		remove_action( 'wp_head', 'wp_generator' );
	}

	// remove the new 3.1 admin header toolbar visible on the website if logged in
	if ( $clpr_options->remove_admin_bar ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}

}
add_action( 'init', 'clpr_disable_wp_features' );


/**
 * Display a noindex meta tag for single coupon pages if linking is disabled.
 * @since 1.5
 *
 * @return void
 */
function clpr_noindex_single_coupon_page() {
	global $clpr_options;

	// if the blog is not public, meta tag is already there.
	if ( '0' == get_option( 'blog_public' ) ) {
		return;
	}

	if ( ! $clpr_options->link_single_page && is_singular( APP_POST_TYPE ) ) {
		wp_no_robots();
	}
}
add_action( 'wp_head', 'clpr_noindex_single_coupon_page' );


/**
 * Modify available buttons in html editor.
 * @since 1.5.1
 *
 * @param array $buttons
 * @param string $editor_id
 *
 * @return array
 */
function clpr_editor_modify_buttons( $buttons, $editor_id ) {
	if ( is_admin() || ! is_array( $buttons ) ) {
		return $buttons;
	}

	$remove = array( 'wp_more', 'spellchecker' );

	return array_diff( $buttons, $remove );
}
add_filter( 'mce_buttons', 'clpr_editor_modify_buttons', 10, 2 );


/**
 * Add coupon type to the post class.
 * @since 1.5.1
 *
 * @param array $classes
 * @param string $class
 * @param int $post_id
 *
 * @return array
 */
function clpr_add_coupon_type_to_post_class( $classes, $class, $post_id ) {

	$post = get_post( $post_id );

	if ( is_object_in_taxonomy( $post->post_type, APP_TAX_TYPE ) ) {
		foreach ( (array) get_the_terms( $post->ID, APP_TAX_TYPE ) as $term ) {
			if ( empty( $term->slug ) ) {
				continue;
			}

			$classes[] = APP_TAX_TYPE . '-' . sanitize_html_class( $term->slug, $term->term_id );
		}
	}

	return $classes;
}
add_filter( 'post_class', 'clpr_add_coupon_type_to_post_class', 10, 3 );


/**
 * Temporary fix for invalid reset password URL.
 *
 * @todo: remove after framework update.
 */
function _cp_fix_password_reset_url( $message, $key ) {
	return html_entity_decode( $message);
}
add_filter( 'retrieve_password_message', '_cp_fix_password_reset_url', 10, 2 );
