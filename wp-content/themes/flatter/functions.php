<?php
/**
 * Child Theme functions file
 *
 * @package Flatter
 * @author Themebound
 */

define( 'FL_VERSION', '4.0.1' );
define( 'FL_PARENT_MIN', '1.6.4' );

require( dirname(__FILE__) . '/includes/defaults.php' );
require( dirname(__FILE__) . '/includes/actions.php' );
require( dirname(__FILE__) . '/includes/functions.php' );
require( dirname(__FILE__) . '/includes/comments.php' );
require( dirname(__FILE__) . '/includes/mobile-widgets.php' );
require( dirname(__FILE__) . '/includes/filter-storage.php' );

function fl_load_after_parent() {
	if ( is_admin() )  {
		require( dirname(__FILE__) . '/includes/admin.php' );
	}
	if( !get_option( 'fl_version' ) || get_option( 'fl_version' ) < FL_VERSION ) {
		require( dirname(__FILE__) . '/includes/upgrade.php' );
	}
}
add_action( 'appthemes_init', 'fl_load_after_parent' );