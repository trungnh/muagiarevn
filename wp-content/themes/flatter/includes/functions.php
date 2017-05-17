<?php

// return store image url with specified size
function fl_get_store_image_url( $id, $type = 'post_id', $width = 180 ) {
	$store_url = false;
	$store_image_id = false;

	$sizes = array( 75 => 'thumb-med', 180 => 'post-thumbnail', 110 => 'thumb-store-showcase', 180 => 'thumb-store', 180 => 'thumb-featured', 250 => 'thumb-large-preview' );
	$sizes = apply_filters( 'clpr_store_image_sizes', $sizes );

	if ( ! array_key_exists( $width, $sizes ) ) {
		$width = 110;
	}

	if ( ! isset( $sizes[ $width ] ) ) {
		$sizes[ $width ] = 'post-thumbnail';
	}

	if ( $type == 'term_id' && $id ) {
		$store_url = clpr_get_store_meta( $id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $id, 'clpr_store_image_id', true );
	}

	if ( $type == 'post_id' && $id ) {
		$term_id = appthemes_get_custom_taxonomy( $id, APP_TAX_STORE, 'term_id' );
		$store_url = clpr_get_store_meta( $term_id, 'clpr_store_url', true );
		$store_image_id = clpr_get_store_meta( $term_id, 'clpr_store_image_id', true );
	}

	if ( is_numeric( $store_image_id ) ) {
		$store_image_src = wp_get_attachment_image_src( $store_image_id, $sizes[ $width ] );
		if ( $store_image_src ) {
			return apply_filters( 'clpr_store_image', $store_image_src[0], $width, $id, $type );
		}
	}
	$mshots_url = is_ssl() ? 'https://s0.wordpress.com/mshots/v1/' : 'http://s.wordpress.com/mshots/v1/';
	if ( ! empty( $store_url ) ) {
		$store_image_url = $mshots_url . urlencode( $store_url ) . "?w=" . $width;
		return apply_filters( 'clpr_store_image', $store_image_url, $width, $id, $type );
	} else {
		$store_image_url = apply_filters( 'clpr_store_default_image', appthemes_locate_template_uri( 'images/clpr_default.jpg' ), $width );
		return apply_filters( 'clpr_store_image', $store_image_url, $width, $id, $type );
	}

}

function fl_social_share() {
	global $post;
	$social_text = urlencode( strip_tags( get_the_title() . ' ' . __( 'coupon from', APP_TD ) . ' ' . get_bloginfo( 'name' ) ) );
	$social_url = urlencode( get_permalink( $post->ID ) );
	?>
	<ul class="inner-social">
		<li><a class="mail" href="#" data-id="<?php echo $post->ID; ?>" rel="nofollow"><?php _e( 'Email to Friend', APP_TD ); ?></a></li>
		<li><a class="rss" href="<?php echo get_post_comments_feed_link( get_the_ID() ); ?>" rel="nofollow"><?php _e( 'Coupon Comments RSS', APP_TD ); ?></a></li>
		<li><a class="twitter" href="https://twitter.com/home?status=<?php echo $social_text; ?>+-+<?php echo $social_url; ?>" rel="nofollow" target="_blank"><?php _e( 'Twitter', APP_TD ); ?></a></li>
		<li><a class="facebook" href="javascript:void(0);" onclick="window.open('https://www.facebook.com/sharer.php?t=<?php echo $social_text; ?>&amp;u=<?php echo $social_url; ?>','doc', 'width=638,height=500,scrollbars=yes,resizable=auto');" rel="nofollow"><?php _e( 'Facebook', APP_TD ); ?></a></li>
		<li><a class="pinterest" href="//pinterest.com/pin/create/button/?url=<?php echo $social_url; ?>&amp;media=<?php echo fl_get_store_image_url( $post->ID, 'post_id', '180' ); ?>&amp;description=<?php echo $social_text; ?>" data-pin-do="buttonPin" data-pin-config="beside" rel="nofollow" target="_blank"><?php _e( 'Pinterest', APP_TD ); ?></a></li>
		<li><a class="digg" href="https://digg.com/submit?phase=2&amp;url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Digg', APP_TD ); ?></a></li>
		<li><a class="reddit" href="https://reddit.com/submit?url=<?php echo $social_url; ?>&amp;title=<?php echo $social_text; ?>" rel="nofollow" target="_blank"><?php _e( 'Reddit', APP_TD ); ?></a></li>
	</ul>
	<?php
}

function fl_shorten_content( $content = false, $len = 50 ) {
	if( !$content ) return;

	if( mb_strlen( $content ) > $len )
		return mb_substr( $content, 0, $len - 3 ) . '...';
	else
		return $content;
}

/**
 * Displays additional information if coupon is expired.
 *
 * @since 1.1 (Clipper 1.5)
 *
 * @param int $post_id Post ID.
 *
 * @return void
 */
function fl_display_expired_info( $post_id ) {
	// do not show on taxonomy pages, there is Unreliable section
	if ( is_tax() )
		return;

	$expire_time = clpr_get_expire_date( $post_id, 'time' );
	if ( ! $expire_time )
		return;

	$expire_time += ( 24 * 3600 ); // + 24h, coupons expire in the end of day
	if ( $expire_time > current_time( 'timestamp' ) )
		return;

	echo html( 'div class="expired-coupon-info iconfix"', html( 'i class="fa fa-info-circle"', '' ) . __( 'Expired!', APP_TD ) );
}

function fl_coupon_title( $len = 50 ) {
	global $clpr_options;

	if ( $clpr_options->link_single_page ) {
		$title = fl_shorten_content( get_the_title(), $len );
		$title_attr = sprintf( esc_attr__( 'View the "%s" coupon page', APP_TD ), the_title_attribute( 'echo=0' ) );
		echo html( 'a', array( 'href' => get_permalink(), 'title' => $title_attr ), $title );
	} else {
		echo fl_shorten_content( get_the_title(), $len );
	}
}

// categories list display
function fl_create_categories_list( $location = 'menu', $taxonomy = APP_TAX_STORE ) {

	$term_args = $args = array();

	$args['taxonomy'] = $taxonomy;
	$args['cat_parent_count'] = true;
	$args['cat_child_count'] = true;
	$args['cat_hide_empty'] = false;
	$args['cat_nocatstext'] = true;
	$args['cat_order'] = 'ASC';
	$args['menu_cols'] = 3;
	$args['menu_depth'] = 3;
	$args['menu_sub_num'] = 999;

	if( $taxonomy == APP_TAX_STORE ) {
		$hidden_stores = clpr_hidden_stores();
		$term_args['exclude'] = $hidden_stores;
	}

	if( $location == 'menu' ) {
		$args['menu_sub_num'] = 3;

		if( $taxonomy == APP_TAX_STORE ) {
			$term_args['number'] = fl_get_option( 'fl_mega_menu_stores_number' );
			$term_args['hide_empty'] = fl_get_option( 'fl_mega_menu_stores_hide_empty' );
			$term_args['orderby'] = fl_get_option( 'fl_mega_menu_stores_orderby' );
			$term_args['order'] = fl_get_option( 'fl_mega_menu_stores_orderby' ) == 'count' ? 'DESC' : 'ASC';
		} elseif( $taxonomy == APP_TAX_CAT ) {
			$term_args['number'] = fl_get_option( 'fl_mega_menu_category_number' );
			$term_args['hide_empty'] = fl_get_option( 'fl_mega_menu_category_hide_empty' );
			$term_args['orderby'] = fl_get_option( 'fl_mega_menu_category_orderby' );
			$term_args['order'] = fl_get_option( 'fl_mega_menu_category_orderby' ) == 'count' ? 'DESC' : 'ASC';
		}
	}
	return appthemes_categories_list( $args, $term_args );
}

function fl_get_terms( $taxonomy = APP_TAX_STORE, $args = array() ) {
	return get_terms( $taxonomy, $args );
}

function fl_add_store_thumbs() {
	global $clpr_options;
	if( is_front_page() && fl_get_option( 'fl_store_thumbs_area' ) != 'no' ) :

?>
<div id="store-thumb-container" class="<?php echo fl_get_option( 'fl_store_thumbs_area' ); ?>">
	<div class="frame">
		<?php get_template_part( 'store-thumbs' ); ?>
	</div>
</div>
<?php
	endif;
}

function fl_get_preset_tab_items() {
	return apply_filters( 'fl_preset_tab_items', array(
		'new-coupons' => 'New Coupons',
		'popular-coupons' => 'Popular Coupons',
		'featured-coupons' => 'Featured Coupons',
	) );
}

function fl_get_home_tabs() {
	$locations = get_nav_menu_locations();
	if( empty( $locations['home_tabs'] ) ) {
		return false;
	}
	$menu = wp_get_nav_menu_object( $locations['home_tabs'] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
	$presets = fl_get_preset_tab_items();
	$tax_page_ids = array();
	if( CLPR_Coupon_Stores::get_id() ) {
		$tax_page_ids[] = CLPR_Coupon_Stores::get_id();
	}
	if( CLPR_Coupon_Categories::get_id() ) {
		$tax_page_ids[] = CLPR_Coupon_Categories::get_id();
	}

	$return = array();

	foreach( $menu_items as $x => $item ) {
		$tab_type = get_post_meta( $item->ID, 'fl_tab_type', true );
		if( !( $item->type == 'fl_tabs_home' || array_key_exists( $item->type, $presets ) || $item->type == 'taxonomy' || ( $tax_page_ids && in_array( $item->object_id, $tax_page_ids ) && $item->type == 'post_type' && $item->object == 'page' ) ) ) {
			unset( $menu_items[$x] );
		} else {
			if( $tab_type && array_key_exists( $tab_type, $presets ) ) {
				$key = $item->type = $tab_type;
				$template = 'includes/home-tab-' . $key . '.php';
			} elseif( array_key_exists( $item->type, $presets ) ) {
				$key = $item->type;
				$template = 'includes/home-tab-' . $key . '.php';
			} elseif( $item->type == 'taxonomy' ) {
				$key = get_term( $item->object_id, $item->object )->slug;
				$template = 'includes/home-tab-terms.php';
			} elseif ( $item->object == 'page' ) {
				$key = get_post( $item->object_id )->post_name;
				$template = 'includes/home-tab-taxonomy.php';
			}
			$tab_array = (array) $item;
			$tab_array['template'] = $template;
			$return[$key] = $tab_array;
		}
	}
	return $return;
}

function fl_tax_pagenum_link( $args, $tax_array ) {
	$args = $args[0];
	$tax_link = get_term_link( (int) $tax_array['terms'], $tax_array['taxonomy'] );
	if( !is_wp_error( $tax_link ) ) {
		$args['base'] = str_replace( home_url( '/' ), $tax_link, $args['base'] );
	}
	return $args;
}

function fl_add_tab_args( $args, $name ) {
	$args = $args[0];
	$args['add_args'] = $name ? array( 'tab' => $name ) : false;
	return $args;
}