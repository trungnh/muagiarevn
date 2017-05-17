<?php
/**
 * Child Theme functions file.
 *
 * BEFORE USING: Move the clipper-child theme into the /themes/ folder.
 *
 * You can add you own actions, filters and code below.
 *
 * Remove below actions, "includes" folder and "tpl-featured-coupons-home.php" file from your child theme if you don't wish to have that homepage.
 *
 * @package Clipper\Child-Theme
 * @author  AppThemes
 * @since   Clipper 1.4
 */


/**
 * Setup Featured Coupons template.
 *
 * @return void
 */
function child_setup_featured_coupons_template() {
	require_once( dirname( __FILE__ ) . '/includes/child-views.php' );
	new Child_Featured_Coupons_Home;
}
add_action( 'appthemes_init', 'child_setup_featured_coupons_template' );


/**
 * Assign Featured Coupons template to front page.
 *
 * @return void
 */
function child_assign_templates_on_activation() {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', Child_Featured_Coupons_Home::get_id() );
	update_option( 'page_for_posts', CLPR_Blog_Archive::get_id() );
}
add_action( 'appthemes_first_run', 'child_assign_templates_on_activation' );

