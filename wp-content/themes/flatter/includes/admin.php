<?php
global $clpr_options;
require_once( get_template_directory() . '/framework/load.php' );

class FL_Theme_Settings_General extends APP_Tabs_Page {

	function setup() {
		$this->textdomain = 'clipper';

		$this->args = array(
			'page_title' => __( 'Flatter Settings', APP_TD ),
			'menu_title' => __( 'Flatter Settings', APP_TD ),
			'page_slug' => 'flatter',
			'parent' => 'app-dashboard',
			'screen_icon' => 'options-general',
			'admin_action_priority' => 100,
		);

	}

	protected function init_tabs() {
		// Remove unwanted query args from urls
		$_SERVER['REQUEST_URI'] = esc_url_raw( remove_query_arg( array( 'firstrun', 'prune-coupons', 'reset-votes', 'reset-stats', 'reset-search-stats' ), $_SERVER['REQUEST_URI'] ) );

		$this->tabs->add( 'general', __( 'General', APP_TD ) );

		$this->tab_sections['general']['styling'] = array(
			'title' => __( 'Styling', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Colour Scheme', APP_TD ),
					'type' => 'select',
					'name' => 'fl_stylesheet',
					'desc' => '',
					'tip' => __( 'Select the color scheme you would like your coupons ads site to use.', APP_TD ),
					'value' => fl_get_option( 'fl_stylesheet' ),
					'values' => array(
						'blue' => __( 'Blue (Default)', APP_TD ),
						'green' => __( 'Green', APP_TD ),
						'red' => __( 'Red', APP_TD ),
						'golden' => __( 'Golden', APP_TD ),
						'dark-blue' => __( 'Dark Blue', APP_TD ),
						'purple' => __( 'Purple', APP_TD ),
						'grey' => __( 'Grey', APP_TD ),
						'bronze' => __( 'Bronze', APP_TD ),
						'brown' => __( 'Brown', APP_TD ),
						'turquoise' => __( 'Turquoise', APP_TD ),
						'charcoal' => __( 'Charcoal', APP_TD ),
					),
				),
				array(
					'title' => __( 'Layout Width', APP_TD ),
					'type' => 'select',
					'name' => 'fl_layout_width',
					'desc' => '',
					'tip' => __( 'Select layout width. Use 1140px for extra wide layout.', APP_TD ),
					'value' => fl_get_option( 'fl_layout_width' ),
					'values' => array(
						'normal' => __( '960px (Default)', APP_TD ),
						'extra' => __( '1140px', APP_TD ),
					),
				),
			),
		);

		$this->tab_sections['general']['navigation'] = array(
			'title' => __( 'Navigation', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Primary Navigation Label on Mobile', APP_TD ),
					'type' => 'text',
					'name' => 'fl_lbl_tinynav',
					'desc' => '',
					'tip' => __( 'Select the label for primary navigation for smaller screen mobile widths.', APP_TD ),
					'value' => fl_get_option( 'fl_lbl_tinynav' ),
				),
				array(
					'title' => __( 'Enable Dual Navigation', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_enable_dual_navigation',
					'desc' => __( '<br /><strong>Recommended!</strong> Enabling this option will push the "Primary Navigation" <em>below</em> the logo and create an additional navigation area (menu location) above the logo in the topmost panel. It is recommended you enable it to take maximum advantage of some very significant child theme features as they will only work when this option is selected.', APP_TD ),
				),
				array(
					'title' => __( 'Enable Category Mega Menu', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_enable_category_mega_menu',
					'tip' => __( 'Only works if dual navigation is enabled. Enable large three column mega menu under Categories link in the primary navigation.', APP_TD ),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
				array(
					'title' => __( 'Number of Categories', APP_TD ),
					'type' => 'text',
					'name' => 'fl_mega_menu_category_number',
					'desc' => '',
					'tip' => __( 'Number of categories to show in the mega menu. Leave empty to show all.', APP_TD ),
					'value' => fl_get_option( 'fl_mega_menu_category_number' ),
					'extra' => array( 'class' => 'requires_mega_menu_category' ),
				),
				array(
					'title' => __( 'Order Categories By', APP_TD ),
					'type' => 'select',
					'name' => 'fl_mega_menu_category_orderby',
					'tip' => __( 'Order of the categories in the mega menu.', APP_TD ),
					'value' => fl_get_option( 'fl_mega_menu_category_orderby' ),
					'values' => array(
						'name' => __( 'Name (default)', APP_TD ),
						'count' => __( 'Count', APP_TD ),
					),
					'extra' => array( 'class' => 'requires_mega_menu_category' ),
				),
				array(
					'title' => __( 'Hide Empty Categories', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_mega_menu_category_hide_empty',
					'tip' => __( 'Hide categories with 0 coupons.', APP_TD ),
					'extra' => array( 'class' => 'requires_mega_menu_category' ),
				),
				array(
					'title' => __( 'Enable Stores Mega Menu', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_enable_store_mega_menu',
					'tip' => __( 'Only works if dual navigation is enabled. Enable large three column mega menu under Stores link in the primary navigation.', APP_TD ),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
				array(
					'title' => __( 'Number of Stores', APP_TD ),
					'type' => 'text',
					'name' => 'fl_mega_menu_stores_number',
					'desc' => '',
					'tip' => __( 'Number of stores to show in the mega menu. Leave empty to show all.', APP_TD ),
					'value' => fl_get_option( 'fl_mega_menu_stores_number' ),
					'extra' => array( 'class' => 'requires_mega_menu_stores' ),
				),
				array(
					'title' => __( 'Order Stores By', APP_TD ),
					'type' => 'select',
					'name' => 'fl_mega_menu_stores_orderby',
					'tip' => __( 'Order of the stores in the mega menu.', APP_TD ),
					'value' => fl_get_option( 'fl_mega_menu_stores_orderby' ),
					'values' => array(
						'name' => __( 'Name (default)', APP_TD ),
						'count' => __( 'Count', APP_TD ),
					),
					'extra' => array( 'class' => 'requires_mega_menu_stores' ),
				),
				array(
					'title' => __( 'Hide Empty Stores', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_mega_menu_stores_hide_empty',
					'tip' => __( 'Hide stores with 0 coupons.', APP_TD ),
					'extra' => array( 'class' => 'requires_mega_menu_stores' ),
				),
				array(
					'title' => __( 'Primary Navigation on Mobile', APP_TD ),
					'type' => 'select',
					'name' => 'fl_mobile_navigation',
					'tip' => __( 'Select the type of primary navigation for smaller screen mobile widths. Only works if dual navigation is enabled as that is when the primary navigation is below the logo.', APP_TD ),
					'value' => fl_get_option( 'fl_mobile_navigation' ),
					'values' => array(
						'select' => __( 'HTML Select Box (Default)', APP_TD ),
						'css' => __( 'Responsive CSS', APP_TD ),
					),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
				array(
					'title' => __( 'Top Panel Navigation Label on Mobile', APP_TD ),
					'type' => 'text',
					'name' => 'fl_lbl_top_navigation',
					'tip' => __( 'Select the label for top panel navigation (additional menu above logo) for smaller screen mobile widths. Only works if dual navigation is enabled as that is when the additional menu will show.', APP_TD ),
					'value' => fl_get_option( 'fl_lbl_top_navigation' ),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
				array(
					'title' => __( 'Enable "Share Coupon" Button from Navigation', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_navigation_share_coupon',
					'tip' => __( 'The button will show next to primary menu with the label you set in the next option.', APP_TD ),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
				array(
					'title' => __( '"Share Coupon" Button Label', APP_TD ),
					'type' => 'text',
					'name' => 'fl_lbl_share_coupon',
					'tip' => __( 'Only works if the "Share Coupon" Button (the last option) is enabled.', APP_TD ),
					'value' => fl_get_option( 'fl_lbl_share_coupon' ),
					'extra' => array( 'class' => 'requires_dual_navigation' ),
				),
			),
		);

		$this->tab_sections['general']['instructions'] = array(
			'title' => __( 'Instructions', APP_TD ),
			'description' => html( 'p', __('If you were using the default Clipper theme or another child theme before, your image thumbnails may need to be updated for optimum usage with the Flatter theme. Please install the <a href="http://wordpress.org/plugins/ajax-thumbnail-rebuild/" target="_blank">AJAX Thumbnail Rebuild</a> plugin and rebuild all your thumbnails just once for this purpose.', APP_TD) )
			. html( 'p', __('Read the installation guide <a href="https://themebound.com/shop/flatter-responsive-child-theme-clipper/" target="_blank">here</a>. Enjoy the theme and please report any issue you encounter to <a href="mailto:info@themebound.com">info@themebound.com</a>. Follow us on <a href="https://twitter.com/#!/themebound" target="_blank">Twitter</a>, and like us on <a href="https://www.facebook.com/themebound" target="_blank">Facebook</a> to get updates on new products and useful tips.', APP_TD) ),
			'renderer' => array( $this, 'render_instructions' ),
			'fields' => array(),
		);

		$this->tabs->add( 'homepage', __( 'Homepage', APP_TD ) );

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['home_tabs'];
		$menu_url = admin_url( 'nav-menus.php' );
		$menu_url = $locations['home_tabs'] ? esc_url( add_query_arg( array( 'action' => 'edit', 'menu' => $locations['home_tabs'] ), $menu_url ) ) : $menu_url;

		$this->tab_sections['homepage']['layout'] = array(
			'title' => __( 'Layout', APP_TD ),
			'desc' =>  sprintf( __( 'Configuration for overall view of the homepage. For <strong>tabbed view</strong>, you will need to make sure you have a navigation menu in the <strong>"Homepaged Tabbed Area"</strong> section. We have already attempted to create a <a href="%s" target="_blank"><strong>navigation menu</strong></a> for you that you can modify. If it does not exist, please create one a new one and add it to the "Homepage Tabbed Area" section. Using the "Menus" section for tabs will let you add tabs for <strong>coupon categories and stores</strong> and <strong>define the order and custom labels</strong> of your tabs.', APP_TD ), $menu_url ),
			'fields' => array(
				array(
					'title' => __( 'Tabbed Layout', APP_TD ),
					'desc' => __( 'Displays the homepage in a tabbed view. Check the tooltip to see what items are accepted for tabs.', APP_TD ),
					'tip' => '<p>' . __( 'You can add the following items as homepage tabs:', APP_TD ) . '</p>'
							. '<ol>'
							. '<li>' . __( 'Any item under the "Homepage Tabs" section', APP_TD ) . '</li>'
							. '<li>' . __( 'Any item under the "Stores" section', APP_TD ) . '</li>'
							. '<li>' . __( 'Any item under the "Categories" (coupon categories) section', APP_TD ) . '</li>'
							. '<li>' . __( 'From the "Pages" section, you can add "Stores" or "Categories" pages.', APP_TD ) . '</li>'

							. '</ol>',
					'type' => 'checkbox',
					'name' => 'fl_homepage_tab_layout',
				),
				array(
					'title' => __( 'Grid Layout', APP_TD ),
					'desc' => __( 'Displays coupons in grid view on the homepage.', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_homepage_grid_layout',
				),
				array(
					'title' => __( 'Full Width', APP_TD ),
					'desc' => __( 'Removes sidebar on the homepage.', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_homepage_full_width',
				),
			),
		);

		$this->tab_sections['homepage']['store_thumbs'] = array(
			'title' => __( 'Stores Area', APP_TD ),
			'desc' => __( 'Configuration for stores thumbnail area on the homepage.', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Enable on Homepage', APP_TD ),
					'type' => 'select',
					'name' => 'fl_store_thumbs_area',
					'tip' => __( 'This will display a list of store thumbnails on the home page configurable via the following options', APP_TD ),
					'value' => fl_get_option( 'fl_store_thumbs_area' ),
					'values' => array(
						'below_coupons' => __( 'Below Coupon List (Default)', APP_TD ),
						'slider_area' => __( 'Above Coupon List', APP_TD ),
						'no' => __( 'Do not enable', APP_TD ),
					),
				),
				array(
					'title' => __( 'Title', APP_TD ),
					'tip' => __( 'Title for the Stores Area', APP_TD ),
					'name' => 'fl_store_thumbs_title',
					'type' => 'text',
					'value' => fl_get_option( 'fl_store_thumbs_title' ),
				),
				array(
					'title' => __( 'Number of Stores', APP_TD ),
					'tip' => __( 'Total number of store thumbnails to display, ideally a multiple of 7', APP_TD ),
					'name' => 'fl_store_thumbs_number',
					'type' => 'text',
					'value' => fl_get_option( 'fl_store_thumbs_number' ),
				),
				array(
					'title' => __( 'Order By', APP_TD ),
					'type' => 'select',
					'name' => 'fl_store_thumbs_orderby',
					'tip' => __( 'Order the list of stores by', APP_TD ),
					'value' => fl_get_option( 'fl_store_thumbs_orderby' ),
					'values' => array(
						'count' => __( 'Number of coupons (default)', APP_TD ),
						'name' => __( 'Store name', APP_TD ),
					),
				),
				array(
					'title' => __( 'Order', APP_TD ),
					'type' => 'select',
					'name' => 'fl_store_thumbs_order',
					'value' => fl_get_option( 'fl_store_thumbs_order' ),
					'values' => array(
						'DESC' => __( 'Descending (Default)', APP_TD ),
						'ASC' => __( 'Ascending', APP_TD ),
					),
				),
				array(
					'title' => __( 'Show Only Featured Stores', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_store_thumbs_featured_only',
				),
				array(
					'title' => __( 'Include Empty Stores', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_store_thumbs_show_empty',
					'tip' => __( 'Include stores with no coupons listed under them?', APP_TD ),
				),
				array(
					'title' => __( 'Singular "coupon"', APP_TD ),
					'type' => 'text',
					'name' => 'fl_store_thumbs_singular',
					'tip' => __( 'Singular for coupon, eg. 1 <em>coupon</em>', APP_TD ),
					'value' => fl_get_option( 'fl_store_thumbs_singular' ),
				),
				array(
					'title' => __( 'Plural "coupons"', APP_TD ),
					'type' => 'text',
					'name' => 'fl_store_thumbs_plural',
					'tip' => __( 'Plural for coupon, eg. 5 <em>coupons</em>', APP_TD ),
					'value' => fl_get_option( 'fl_store_thumbs_plural' ),
				),
			),
		);

		$this->tabs->add( 'coupons', __( 'Coupon Listings', APP_TD ) );

		$this->tab_sections['coupons']['coupon_code'] = array(
			'title' => __( 'Coupon Code', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Force Open Affiliate Link', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_coupon_force_affiliate',
					'desc' => __( '<br /><strong>Recommended!</strong> Enabling this option will try to force open the affiliate link in a new tab when clicking on "Show Coupon" button that opens the code in a popup to copy implemented in Clipper 1.5.1. It seems to not work sometimes with IE but it is better to have it enabled anyway.', APP_TD ),
				),
			),
		);

		$this->tab_sections['coupons']['loop'] = array(
			'title' => __( 'Coupon Loop View', APP_TD ),
			'desc' => __( 'Coupon lists view, like on the homepage, stores page, and the categories page.', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Hide Category and Tag', APP_TD ),
					'type' => 'checkbox',
					'name' => 'fl_hide_loop_taxonomy',
					'tip' => __( 'Hide category and tag below coupon description to reduce clutter.', APP_TD ),
				),
			),
		);

		$this->tab_sections['coupons']['labels'] = array(
			'title' => __( 'Button and Other Labels', APP_TD ),
			'fields' => array(
				array(
					'title' => __( 'Show Coupon', APP_TD ),
					'tip' => __( 'Appears on coupon list for coupon codes when they are hidden', APP_TD ),
					'tip' => __( 'Keep it short.', APP_TD ),
					'name' => 'fl_lbl_show_coupon',
					'type' => 'text',
					'value' => fl_get_option( 'fl_lbl_show_coupon' ),
				),
				array(
					'title' => __( 'Print Coupon', APP_TD ),
					'tip' => __( 'Appears on coupon list for printable coupons', APP_TD ),
					'tip' => __( 'Keep it short.', APP_TD ),
					'name' => 'fl_lbl_print_coupon',
					'type' => 'text',
					'value' => fl_get_option( 'fl_lbl_print_coupon' ),
				),
				array(
					'title' => __( 'Redeem Offer', APP_TD ),
					'tip' => __( 'Appears on coupon list for promo coupons. Keep it short.', APP_TD ),
					'name' => 'fl_lbl_redeem_offer',
					'type' => 'text',
					'value' => fl_get_option( 'fl_lbl_redeem_offer' ),
				),
				array(
					'title' => __( 'Learn More', APP_TD ),
					'type' => 'text',
					'name' => 'fl_lbl_learn_more',
					'tip' => __( 'Appears on the slider. Keep it short.', APP_TD ),
					'value' => fl_get_option( 'fl_lbl_learn_more'),
				),
				array(
					'title' => __( 'Leave a Comment', APP_TD ),
					'tip' => __( 'Appears as title on the comment form, replacing the duplicate title which shows above the list of comments as well.', APP_TD ),
					'name' => 'fl_lbl_leave_comment',
					'type' => 'text',
					'value' => fl_get_option( 'fl_lbl_leave_comment' ),
				),
			),
		);

	}

	function form_handler() {
		if ( empty( $_POST['action'] ) || ! $this->tabs->contains( $_POST['action'] ) )
			return;

		check_admin_referer( $this->nonce );

		$form_fields = array();

		foreach ( $this->tab_sections[ $_POST['action'] ] as $section )
			$form_fields = array_merge( $form_fields, $section['fields'] );

		$to_update = scbForms::validate_post_data( $form_fields, null, $this->options->get() );

		$this->options->update( $to_update, false );

		do_action( 'tabs_' . $this->pagehook . '_form_handler', $this );
		add_action( 'admin_notices', array( $this, 'admin_msg' ) );
	}

		function page_footer() {
		parent::page_footer();
?>
<script type="text/javascript">
jQuery(document).ready(function($) {

	fl_options_toggle($);
	$( 'input[name="fl_enable_dual_navigation"]' ).click( function() {
		fl_options_toggle($);
	});
	$( 'input[name="fl_enable_store_mega_menu"], input[name="fl_enable_category_mega_menu"]' ).click( function() {
		fl_options_toggle($);
	});
	$( 'input[name="fl_coupon_popup_enable"]' ).click( function() {
		fl_options_toggle($);
	});

});
function fl_options_toggle($) {

	if( $( 'input[name="fl_enable_dual_navigation"]' ).is( ':checked' ) ) {
		$( '.requires_dual_navigation' ).parents('tr').show();
		if( $( 'input[name="fl_enable_store_mega_menu"]' ).is( ':checked' ) ) {
			$( '.requires_mega_menu_stores' ).parents('tr').show();
		} else {
			$( '.requires_mega_menu_stores' ).parents('tr').hide();
		}
		if( $( 'input[name="fl_enable_category_mega_menu"]' ).is( ':checked' ) ) {
			$( '.requires_mega_menu_category' ).parents('tr').show();
		} else {
			$( '.requires_mega_menu_category' ).parents('tr').hide();
		}
	} else {
		$( '.requires_dual_navigation' ).parents('tr').hide();
		$( '.requires_mega_menu_stores' ).parents('tr').hide();
		$( '.requires_mega_menu_category' ).parents('tr').hide();
	}

	if( $( 'input[name="fl_coupon_popup_enable"]' ).is( ':checked' ) ) {
		$( '[name="fl_coupon_popup_description"], [name="fl_coupon_popup_button"]' ).parents('tr').show();
	} else {
		$( '[name="fl_coupon_popup_description"], [name="fl_coupon_popup_button"]' ).parents('tr').hide();
	}

}
</script>
<?php
	}

	function render_instructions( $section, $section_id ) {
		if( in_array( $section_id, array( 'instructions', 'popup_solution_info' ) ) ) {
			echo $section['description'];
		}
	}

}

// display the custom url meta field for the stores taxonomy
function fl_edit_stores( $tag, $taxonomy ) {

	$the_store_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_url', true );
	$the_store_aff_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_aff_url', true );
	$the_store_active = clpr_get_store_meta( $tag->term_id, 'clpr_store_active', true );
	$store_featured = clpr_get_store_meta( $tag->term_id, 'clpr_store_featured', true );
	$the_store_aff_url_clicks = clpr_get_store_meta( $tag->term_id, 'clpr_aff_url_clicks', true );
	// $clpr_store_image_url = clpr_get_store_meta( $tag->term_id, 'clpr_store_image_url', true );
	$clpr_store_image_id = clpr_get_store_meta( $tag->term_id, 'clpr_store_image_id', true );
	$clpr_store_image_preview = clpr_get_store_image_url( $tag->term_id, 'term_id', 100 );
?>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_url"><?php _e( 'Store URL', APP_TD ); ?></label></th>
	<td>
		<input type="text" name="clpr_store_url" id="clpr_store_url" value="<?php echo $the_store_url; ?>"/><br />
		<p class="description"><?php _e( 'The URL for the store (i.e. http://www.website.com)', APP_TD ); ?></p>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_aff_url"><?php _e( 'Destination URL', APP_TD ); ?></label></th>
	<td>
		<input type="text" name="clpr_store_aff_url" id="clpr_store_aff_url" value="<?php echo $the_store_aff_url; ?>"/><br />
		<p class="description"><?php _e( 'The affiliate URL for the store (i.e. http://www.website.com/?affid=12345)', APP_TD ); ?></p>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_aff_url_cloaked"><?php _e( 'Display URL', APP_TD ); ?></label></th>
	<td><?php echo clpr_get_store_out_url( $tag ); ?></td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_aff_url_clicks"><?php _e( 'Clicks', APP_TD ); ?></label></th>
	<td><?php echo esc_attr( $the_store_aff_url_clicks ); ?></td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_active"><?php _e( 'Store Active', APP_TD ); ?></label></th>
	<td>
		<select class="postform" id="clpr_store_active" name="clpr_store_active" style="min-width:125px;">
				<option value="yes" <?php selected( $the_store_active, 'yes' ); ?>><?php _e( 'Yes', APP_TD ); ?></option>
				<option value="no" <?php selected( $the_store_active, 'no' ); ?>><?php _e( 'No', APP_TD ); ?></option>
		</select>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_featured"><?php _e( 'Store Featured', APP_TD ); ?></label></th>
	<td>
		<input type="checkbox" value="1" name="clpr_store_featured" <?php checked( $store_featured ); ?>> <span class="description"><?php _e( 'Yes', APP_TD ); ?></span>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_url"><?php _e( 'Store Screenshot', APP_TD ); ?></label></th>
	<td>
		<span class="thumb-wrap">
			<a href="<?php echo $the_store_url; ?>" target="_blank"><img class="store-thumb" src="<?php echo clpr_get_store_image_url($tag->term_id, 'term_id', '250'); ?>" alt="" /></a>
		</span>
	</td>
</tr>

<tr class="form-field">
	<th scope="row" valign="top"><label for="clpr_store_image_id"><?php _e( 'Store Image <strong>(180x110)</strong>', APP_TD ); ?></label></th>
	<td>
		<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo $clpr_store_image_preview; ?>" width="100px" height="55px" /></div>
		<div style="line-height:75px;">
			<input type="hidden" name="clpr_store_image_id" id="clpr_store_image_id" value="<?php echo $clpr_store_image_id; ?>" />
			<button type="submit" class="button" id="button_add_image" rel="clpr_store_image_url"><?php _e( 'Add Image', APP_TD ); ?></button>
			<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', APP_TD ); ?></button>
		</div>
		<div class="clear"></div>
		<p class="description"><?php _e( 'Choose custom image for the store. For best results with <strong>Flatter</strong> child theme, use the size 180x110.', APP_TD ); ?></p>
		<p class="description"><?php _e( 'Leave blank if you want use image generated by store URL.', APP_TD ); ?></p>
	</td>
</tr>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {

		var formfield;

		if ( ! jQuery('#clpr_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery( document ).on('click', '#button_add_image', function() {
			formfield = jQuery(this).attr('rel');
			tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;taxonomy=<?php echo APP_TAX_STORE; ?>&amp;TB_iframe=true');
			return false;
		});

		jQuery( document ).on('click', '#button_remove_image', function() {
			jQuery('#stores_image img').attr('src', '<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>');
			jQuery('#clpr_store_image_id').val('0');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});

		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html) {
			if ( formfield ) {
				var imageClass = jQuery('img', html).attr('class');
				var imageID = parseInt(/wp-image-(\d+)/.exec(imageClass)[1], 10);
				var imageURL = jQuery('img', html).attr('src');

				jQuery('input[name=clpr_store_image_id]').val(imageID);
				jQuery('#stores_image img').attr('src', imageURL);
				jQuery('#button_remove_image').show();
				jQuery('#button_add_image').hide();
				tb_remove();
				formfield = null;
			} else {
				window.original_send_to_editor(html);
			}
		}

	});
	//]]>
</script>

<?php
}
add_action( 'stores_edit_form_fields', 'fl_edit_stores', 10, 2 );


// add extra fields to the create store admin page
function fl_add_store_fields( $tag ) {
?>

<div class="form-field">
	<label for="clpr_store_url"><?php _e( 'Store URL', APP_TD ); ?></label>
	<input type="text" name="clpr_store_url" id="clpr_store_url" value="" />
	<p class="description"><?php _e( 'The URL for the store (i.e. http://www.website.com)', APP_TD ); ?></p>
</div>

<div class="form-field">
	<label for="clpr_store_image_id"><?php _e( 'Store Image <strong>(180x110)</strong>', APP_TD ); ?></label>
	<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>" width="100px" height="55px" /></div>
	<div style="line-height:75px;">
		<input type="hidden" name="clpr_store_image_id" id="clpr_store_image_id" value="" />
		<button type="submit" class="button" id="button_add_image" rel="clpr_store_image_url"><?php _e( 'Add Image', APP_TD ); ?></button>
		<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', APP_TD ); ?></button>
	</div>
	<div class="clear"></div>
	<p class="description"><?php _e( 'Choose custom image for the store. For best results with <strong>Flatter</strong> child theme, use the size 180x110.', APP_TD ); ?></p>
	<p class="description"><?php _e( 'Leave blank if you want use image generated by store URL.', APP_TD ); ?></p>
</div>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {

		var formfield;

		if ( ! jQuery('#clpr_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery( document ).on('click', '#button_add_image', function() {
			formfield = jQuery(this).attr('rel');
			tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;taxonomy=<?php echo APP_TAX_STORE; ?>&amp;TB_iframe=true');
			return false;
		});

		jQuery( document ).on('click', '#button_remove_image', function() {
			jQuery('#stores_image img').attr('src', '<?php echo appthemes_locate_template_uri('images/clpr_default.jpg'); ?>');
			jQuery('#clpr_store_image_id').val('0');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});

		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html) {
			if ( formfield ) {
				var imageClass = jQuery('img', html).attr('class');
				var imageID = parseInt(/wp-image-(\d+)/.exec(imageClass)[1], 10);
				var imageURL = jQuery('img', html).attr('src');

				jQuery('input[name=clpr_store_image_id]').val(imageID);
				jQuery('#stores_image img').attr('src', imageURL);
				jQuery('#button_remove_image').show();
				jQuery('#button_add_image').hide();
				tb_remove();
				formfield = null;
			} else {
				window.original_send_to_editor(html);
			}
		}

	});
	//]]>
</script>

<?php
}
add_action( 'stores_add_form_fields', 'fl_add_store_fields', 10, 2 );

function fl_add_nav_meta_boxes() {

	$items = fl_get_preset_tab_items();
	add_meta_box( 'fl_tabs_home', __( 'Homepage Tabs', APP_TD ), 'fl_nav_meta_box_callback', 'nav-menus', 'side', 'low', array( $items ) );
}
add_action( 'admin_init', 'fl_add_nav_meta_boxes' );

function fl_nav_meta_box_callback( $object, $params ) {
	global $_nav_menu_placeholder;

	$items = $params['args'][0];
	$post_type_name = $params['id'];
	//echo '<pre>';
	//print_r( $params );
	//echo '</pre>';

	$walker = new Walker_Nav_Menu_Checklist();
	$args = array( 'walker' => $walker );

	?>
	<div id="posttype-<?php echo $post_type_name; ?>" class="posttypediv">
		<div id="tabs-panel-posttype-<?php echo $post_type_name; ?>-all" class="tabs-panel tabs-panel-active">
			<ul id="<?php echo $post_type_name; ?>checklist" data-wp-lists="list:<?php echo $post_type_name?>" class="categorychecklist form-no-clear">
				<?php
				$output = '';
				foreach( $items as $id => $title ) {
					$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
					$possible_object_id = $_nav_menu_placeholder;
					$possible_db_id = 0;

					$output .= '<li>';

					$output .= '<label class="menu-item-title">';
					$output .= '<input type="checkbox" class="menu-item-checkbox" name="menu-item[' . $possible_object_id . '][menu-item-object-id]" value="'. esc_attr( $id ) .'" /> ';
					$output .= isset( $title ) ? esc_html( $title ) : '';
					$output .= '</label>';

					// Menu item hidden fields
					$output .= '<input type="hidden" class="menu-item-db-id" name="menu-item[' . $possible_object_id . '][menu-item-db-id]" value="' . $possible_db_id . '" />';
					$output .= '<input type="hidden" class="menu-item-object" name="menu-item[' . $possible_object_id . '][menu-item-object]" value="'. esc_attr( $params['id'] ) .'" />';
					$output .= '<input type="hidden" class="menu-item-parent-id" name="menu-item[' . $possible_object_id . '][menu-item-parent-id]" value="0" />';
					$output .= '<input type="hidden" class="menu-item-type" name="menu-item[' . $possible_object_id . '][menu-item-type]" value="custom" />';
					$output .= '<input type="hidden" class="menu-item-title" name="menu-item[' . $possible_object_id . '][menu-item-title]" value="'. esc_attr( $title ) .'" />';
					$output .= '<input type="hidden" class="menu-item-url" name="menu-item[' . $possible_object_id . '][menu-item-url]" value="#'. esc_attr( $id ) .'" />';
					$output .= '<input type="hidden" class="menu-item-target" name="menu-item[' . $possible_object_id . '][menu-item-target]" value="" />';
					$output .= '<input type="hidden" class="menu-item-attr_title" name="menu-item[' . $possible_object_id . '][menu-item-attr_title]" value="" />';
					$output .= '<input type="hidden" class="menu-item-classes" name="menu-item[' . $possible_object_id . '][menu-item-classes]" value="" />';
					$output .= '<input type="hidden" class="menu-item-xfn" name="menu-item[' . $possible_object_id . '][menu-item-xfn]" value="" />';
					$output .= '</li>';
				}
				echo $output;
				?>
			</ul>
		</div><!-- /.tabs-panel -->

		<p class="button-controls">
			<span class="list-controls">
				<a href="#posttype-<?php echo $post_type_name; ?>" class="select-all"><?php _e('Select All'); ?></a>
			</span>

			<span class="add-to-menu">
				<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-post-type-menu-item" id="<?php echo esc_attr( 'submit-posttype-' . $post_type_name ); ?>" />
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
}

function fl_setup_nav_menu_item( $menu_item ) {
	//print_r( $menu_item );
	$presets = fl_get_preset_tab_items();
	$tab_type = false;
	if( isset( $_POST['menu-item'] ) ) {
		$tab_type = ltrim( $menu_item->url, '#' );
	} elseif( array_key_exists( $menu_item->type, $presets ) ){
		$tab_type = $menu_item->type;
	}
	
	if( $tab_type && array_key_exists( $tab_type, $presets ) ) {
		add_post_meta( $menu_item->ID, 'fl_tab_type', $tab_type );
	} else {
		$tab_type = get_post_meta( $menu_item->ID, 'fl_tab_type', true );
	}
	
	if( $menu_item->type == 'fl_tabs_home' || ( $tab_type && array_key_exists( $tab_type, $presets ) ) ) {
		$menu_item->type = 'fl_tabs_home';
		$menu_item->type_label = __( 'Homepage Tab', APP_TD );
	}
	return $menu_item;
}
add_filter( 'wp_setup_nav_menu_item', 'fl_setup_nav_menu_item' );

function fl_admin_notices() {
	$fl_name = wp_get_theme()->get( 'Name' );
	$fl_version = wp_get_theme()->get( 'Version' );
	$fl_parent = wp_get_theme()->parent()->get( 'Name' );
	$fl_parent_version = wp_get_theme()->parent()->get( 'Version' );

	if( version_compare( $fl_parent_version, FL_PARENT_MIN, '>=' ) ) {
		return;
	}

	$request_link = ( sprintf( 'mailto:info@themebound.com?subject=Request for a %1$s version compatible with %2$s %3$s&body=My AppThemes username is: APPTHEMES_USERNAME (replace with your correct username).', $fl_name, $fl_parent, $fl_parent_version ) );

	$msg = sprintf( __( '<strong>%1$s %2$s</strong> <em>requires at least</em> <strong>%3$s %5$s</strong> to function properly, please either upgrade %3$s or <a href="%6$s">request</a> a version of %1$s that is compatible with %3$s %4$s.', APP_TD ), $fl_name, $fl_version, $fl_parent, $fl_parent_version, FL_PARENT_MIN, $request_link );

	echo scb_admin_notice( $msg, 'notice notice-error' );
}
add_action( 'admin_notices', 'fl_admin_notices' );