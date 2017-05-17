<?php

/** Include the TGM_Plugin_Activation class. */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins()
{
	$plugins = array(
		array(
            'name'               => 'Theme Support (Required)', // The plugin name.
            'slug'               => 'theme_support_comre', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/includes/thirdparty/tgm-plugin-activation/plugins/theme_support_comre.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
        array(
            'name'               => 'Comre Accounts Manager', // The plugin name.
            'slug'               => 'wt_account_manager', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/includes/thirdparty/tgm-plugin-activation/plugins/wt_account_manager.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'				  => SH_ROOT. '/includes/thirdparty/tgm-plugin-activation/plugins/revslider.zip',
			'required' 				=> true,
			'version' 				 => '5.1.6',
			'force_activation' 		=> false,
			'force_deactivation' 	  => false,
			'external_url' 			=> SH_URL . '/includes/thirdparty/tgm-plugin-activation/plugins/revslider.zip',
			'file_path'			   =>  ABSPATH.'wp-content/plugins/revslider/revslider.php'
		),
		array(
			'name'     				=> 'WPBakery Visual Composer',
			'slug'     				=> 'js_composer',
			'source'   				  => SH_ROOT . '/includes/thirdparty/tgm-plugin-activation/plugins/js_composer.zip',
			'required' 				=> true,
			'version' 				 => '4.9.2',
			'force_activation' 		=> false,
			'force_deactivation' 	  => false,
			'external_url' 			=> SH_URL . '/includes/thirdparty/tgm-plugin-activation/plugins/js_composer.zip',
			'file_path'			   =>  ABSPATH.'wp-content/plugins/js_composer/js_composer.php'
		),
		array(
			'name'     				=> 'Woocommerce',
			'slug'     				=> 'woocommerce',
			'required' 				=> true,
			'version' 				 => '2.1.9',
		),
		array(
			'name'     				=> 'Social Login',
			'slug'     				=> 'wordpress-social-login',
			'required' 				=>  false,
			'version' 				 => '2.2.3',
		),
	);
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'comre';
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 		=> 'themes.php', 				// Default parent menu and URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		
	);
	tgmpa($plugins, $config);
}