<?php

function fl_init() {

	global $clpr_options;

	/* force disable style sheet */
	$clpr_options->disable_stylesheet = 1;

	set_post_thumbnail_size( 180, 110, true ); // blog post thumbnails
	add_image_size( 'thumb-store-showcase', 110, 50, true ); // used on the store page
	add_image_size( 'thumb-store', 180, 110, true ); // used on the store page
	add_image_size( 'thumb-featured', 180, 110, true ); // used in featured coupons slider
	add_image_size( 'thumb-large', 180, 110, true );

	//Remove the main theme actions
	remove_action( 'appthemes_before_blog_post_content', 'clpr_blog_post_meta' );
	remove_action( 'appthemes_after_blog_post_content', 'clpr_blog_post_tags' );
	remove_action( 'appthemes_after_blog_post_content', 'clpr_user_bar_box' );
	remove_action( 'stores_edit_form_fields', 'clpr_edit_stores' );
	remove_action( 'stores_add_form_fields', 'add_store_extra_fields' );

	remove_action('appthemes_blog_comments_form', 'clpr_main_comment_form');
	remove_action( 'wp_ajax_nopriv_comment-form', 'clpr_comment_form' );
	remove_action( 'wp_ajax_comment-form', 'clpr_comment_form' );
	remove_action( 'wp_ajax_nopriv_post-comment', 'clpr_post_comment_ajax' );
	remove_action( 'wp_ajax_post-comment', 'clpr_post_comment_ajax' );

	if( is_admin() ) {
		appthemes_add_instance( array( 'FL_Theme_Settings_General' => $clpr_options ) );
	}

	register_nav_menus( array(
		'top' => sprintf( __( 'Top Panel Navigation (Shows only in <a href="%s">Dual Navigation Mode</a>)', APP_TD ), admin_url( 'admin.php?page=flatter' ) ),
		'home_tabs' => __( 'Homepage Tabbed Area', APP_TD ),
	) );

	if( fl_get_option( 'fl_store_thumbs_area' ) == 'slider_area' ) {
		add_action( 'appthemes_after_header', 'fl_add_store_thumbs' );
	} elseif( fl_get_option( 'fl_store_thumbs_area' ) == 'below_coupons' ) {
		add_action( 'appthemes_before_footer', 'fl_add_store_thumbs' );
	}

}
add_action( 'init', 'fl_init' );

/**
 * Enqueue Font Awesome
 */
function fl_add_my_stylesheet() {
	// Respects SSL, Style.css is relative to the current file
	wp_enqueue_style( 'font-awesome' );

	if( isset( $_GET['css'] ) ) {
		$css = $_GET['css'];
	} else {
		$css = fl_get_option( 'fl_stylesheet' );
	}

	wp_enqueue_style( 'fl-color', get_stylesheet_directory_uri() . '/css/' . $css . '.css', false );
}
add_action( 'wp_enqueue_scripts', 'fl_add_my_stylesheet', 100 );

function fl_add_google_fonts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic' );
}
add_action( 'wp_enqueue_scripts', 'fl_add_google_fonts', 1 );

function fl_load_scripts() {
	global $clpr_options;

	wp_deregister_script( 'theme-scripts' );
	wp_enqueue_script( 'tinynav', get_bloginfo( 'stylesheet_directory' ) . '/includes/js/jquery.tinynav.js', array( 'jquery' ) );
	wp_enqueue_script( 'theme-scripts', get_bloginfo( 'stylesheet_directory' ) . '/includes/js/theme-scripts.js', array( 'jquery' ) );

	/* Script variables */
	$params = array(
		'app_tax_store' => APP_TAX_STORE,
		'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ),
		'templateurl' => get_template_directory_uri(),
		'is_mobile' => wp_is_mobile(),
		'text_copied' => __( 'Copied', APP_TD ),
		'home_url' => home_url( '/' ),
		'text_mobile_primary' => fl_get_option( 'fl_lbl_tinynav' ),
		'text_mobile_top' => fl_get_option( 'fl_lbl_top_navigation' ),
		'text_before_delete_coupon' => __( 'Are you sure you want to delete this coupon?', APP_TD ),
		'text_sent_email' => __( 'Your email has been sent!', APP_TD ),
		'text_shared_email_success' => __( 'This coupon was successfully shared with', APP_TD ),
		'text_shared_email_failed' => __( 'There was a problem sharing this coupon with', APP_TD ),
		'force_affiliate' => fl_get_option( 'fl_coupon_force_affiliate' ),
		'direct_links' => $clpr_options->direct_links,
		'coupon_code_hide' => $clpr_options->coupon_code_hide,
		'home_tab' => ( isset( $_GET['tab'] ) && is_front_page() ) ? $_GET['tab'] : false,
	);
	wp_localize_script( 'theme-scripts', 'flatter_params', $params );

}
if ( !is_admin() ) {
	add_action( 'wp_print_scripts', 'fl_load_scripts', 20 );
}

function fl_body_class( $classes ) {

	if( fl_get_option( 'fl_layout_width' ) == 'extra' ) {
		$classes[] = 'extra-width';
	}

	if( fl_get_option( 'fl_mobile_navigation' ) == 'css' ) {
		$classes[] = 'responsive-menu';
	}

	return $classes;
}
add_filter( 'body_class', 'fl_body_class' );

function fl_add_featured_slider() {
	global $clpr_options;
	if( is_front_page() && $clpr_options->featured_slider ) {
?>
<div id="featured">
	<div class="frame">
		<?php get_template_part( 'featured' ); ?>
	</div>
</div>
<?php
	}
}
add_action( 'appthemes_after_header', 'fl_add_featured_slider' );

// add the post meta before the blog post content
function fl_blog_post_meta() {
	if(is_page()) return; // don't do post-meta on pages
?>
<div class="content-bar iconfix">
	<p class="meta">
		<span>
			<i class="fa fa-calendar"></i>
			<span>
				<time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
				<time class="entry-date updated" datetime="<?php echo get_the_modified_date( 'c' ); ?>"><?php echo get_the_modified_date(); ?></time>
			</span>
		</span>
		<span><i class="fa fa-folder-open"></i><?php the_category(', '); ?></span>
	</p>
	<p class="comment-count"><i class="fa fa-comments"></i><?php comments_popup_link( __( '0 Comments', APP_TD ), __( '1 Comment', APP_TD ), __( '% Comments', APP_TD ) ); ?></p>
</div>
<?php
}
// hook into the correct action
add_action('appthemes_before_blog_post_content', 'fl_blog_post_meta');

// add the post tags after the blog post content
function fl_blog_post_tags() {
	global $post, $clpr_options;
	if( is_page() ) return; // don't do post-meta on pages

?>

<div class="text-footer iconfix">

	<?php if( get_the_tags() ) { ?>
		<div class="tags"><i class="fa fa-tags"></i><?php _e( 'Tags:', APP_TD ); ?> <?php the_tags(' ', ', ', ''); ?></div>
	<?php } ?>

	<?php if ( $clpr_options->stats_all && current_theme_supports( 'app-stats' ) ) { ?>
		<div class="stats"><i class="fa fa-bar-chart"></i><?php appthemes_stats_counter( $post->ID ); ?></div>
	<?php } ?>

	<div class="author vcard">
			<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author(); ?></a>
		</div>

	<div class="clear"></div>

</div>

<?php
}
// hook into the correct action
add_action( 'appthemes_after_blog_post_content', 'fl_blog_post_tags' );

// add the user bar box after the blog post content
function fl_user_bar_box() {
	global $post;

	if( !is_singular('post') ) return; // only show on blog post single page

	// assemble the text and url we'll pass into each social media share link
	$social_text = urlencode(strip_tags(get_the_title() . ' ' . __( 'post from', APP_TD ) . ' ' . get_bloginfo('name')));
	$social_url  = urlencode(get_permalink($post->ID));
?>

<div class="user-bar">

	<?php if (comments_open()) comments_popup_link( ('<span>' . __( 'Leave a comment', APP_TD ) . '</span>'), ('<span>' . __( 'Leave a comment', APP_TD ) . '</span>'), ('<span>' . __( 'Leave a comment', APP_TD ) . '</span>'), 'btn', '' ); ?>

	<?php fl_social_share(); ?>

</div>

<?php
}
// hook into the correct action
add_action('appthemes_after_blog_post_content', 'fl_user_bar_box', 100);


function fl_disable_children( $items, $args ) {

	if( !fl_get_option( 'fl_enable_dual_navigation' ) || $args->theme_location != 'primary' ) {
		return $items;
	}

	$menu_ids = array();

	foreach ( $items as $key => $item ) {
		if ( fl_get_option( 'fl_enable_store_mega_menu' ) && $item->object_id == CLPR_Coupon_Stores::get_id() ) {
			$item->current_item_ancestor = false;
			$item->current_item_parent = false;
			$menu_ids[] = $item->ID;
		}

		if ( fl_get_option( 'fl_enable_category_mega_menu' ) && $item->object_id == CLPR_Coupon_Categories::get_id() ) {
			$item->current_item_ancestor = false;
			$item->current_item_parent = false;
			$menu_ids[] = $item->ID;
		}
	}

	if ( $menu_ids ) {
		foreach ( $items as $key => $item )
			if ( in_array( $item->menu_item_parent, $menu_ids ) )
				unset( $items[$key] );
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'fl_disable_children', 10, 2 );

function fl_insert_stores_dropdown( $item_output, $item, $depth, $args ) {

	if( !( fl_get_option( 'fl_enable_dual_navigation' ) && fl_get_option( 'fl_enable_store_mega_menu' ) && $args->theme_location == 'primary' ) ) {
		return $item_output;
	}

	if ( $item->object_id == CLPR_Coupon_Stores::get_id() && $item->object == 'page' ) {
		$item_output .= '<div class="adv_taxonomies" id="adv_stores">' . fl_create_categories_list( 'menu', APP_TAX_STORE ) . '</div>';
	}
	return $item_output;
}
// Replace any children the "Stores" menu item might have with the stores dropdown
add_filter( 'walker_nav_menu_start_el', 'fl_insert_stores_dropdown', 10, 4 );

function fl_insert_categories_dropdown( $item_output, $item, $depth, $args ) {

	if( !( fl_get_option( 'fl_enable_dual_navigation' ) && fl_get_option( 'fl_enable_category_mega_menu' ) && $args->theme_location == 'primary' ) ) {
		return $item_output;
	}

	if ( $item->object_id == CLPR_Coupon_Categories::get_id() && $item->object == 'page' ) {
		$item_output .= '<div class="adv_taxonomies" id="adv_categories">' . fl_create_categories_list( 'menu', APP_TAX_CAT ) . '</div>';
	}
	return $item_output;
}
// Replace any children the "Categories" menu item might have with the category dropdown
add_filter( 'walker_nav_menu_start_el', 'fl_insert_categories_dropdown', 10, 4 );

function fl_remove_tab_querystring( $link ) {
	return remove_query_arg( 'tab', $link );
}
add_filter( 'get_pagenum_link', 'fl_remove_tab_querystring' );

function fl_slider_args( $args ) {
	global $clpr_options;
	if( version_compare( CLPR_VERSION, '1.6.3', '<' ) ) {
		$args['post_status'] = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );
	}
	return $args;
}
add_filter( 'clpr_featured_slider_args', 'fl_slider_args' );