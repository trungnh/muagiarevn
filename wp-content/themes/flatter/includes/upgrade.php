<?php

$locations = get_theme_mod( 'nav_menu_locations' );

if( !$locations['home_tabs'] ) {

	$name = 'Tab Menu';
	$menu_id = wp_create_nav_menu( $name );
	
	if ( !is_wp_error( $menu_id ) ) {
		$presets = fl_get_preset_tab_items();

		foreach( $presets as $key => $label ) {
			$item_id = wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title' => $label,
				'menu-item-url' => '#',
				'menu-item-type' => 'fl_tabs_home',
				'menu-item-status' => 'publish',
			) );
			add_post_meta( $item_id, 'fl_tab_type', $key );
		}
		
		$locations['home_tabs'] = $menu_id;
	
		set_theme_mod( 'nav_menu_locations', $locations );

	}

	update_option( 'fl_version', FL_VERSION );
}