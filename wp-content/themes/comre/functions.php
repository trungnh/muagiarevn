<?php

add_action('after_setup_theme', 'sh_theme_setup');

function sh_theme_setup()
{
	
	global $wp_version;
	if(!defined('SH_VERSION')) define('SH_VERSION', '1.0');
	if( !defined( 'SH_NAME' ) ) define( 'SH_NAME', 'wp_builder' );
	if( !defined( 'SH_ROOT' ) ) define('SH_ROOT', get_template_directory().'/');
	if( !defined( 'SH_URL' ) ) define('SH_URL', get_template_directory_uri().'/');	
	include_once( 'includes/loader.php' );
	
	load_theme_textdomain('comre', get_template_directory() . '/languages');
	add_editor_style();
	//ADD THUMBNAIL SUPPORT
	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio' ) );
	add_theme_support('menus'); //Add menu support
	add_theme_support('automatic-feed-links'); //Enables post and comment RSS feed links to head.
	add_theme_support('widgets'); //Add widgets and sidebar support
	add_theme_support( 'woocommerce' );
	add_theme_support( "title-tag" );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	/** Register wp_nav_menus */
	if(function_exists('register_nav_menu'))
	{
		register_nav_menus(
			array(
				/** Register Main Menu location header */
				'main_menu' => __('Main Menu', 'comre'),
				'footer_menu' => __('Footer Menu', 'comre'),
			)
		);
	}
	if ( ! isset( $content_width ) ) $content_width = 960;
	add_image_size( '371x252', 371, 252, true );
	add_image_size( '324x143', 324, 143, true );
	add_image_size( '119x60', 119, 60, true );
	add_image_size( '268x160', 268, 160, true );
	add_image_size( '86x86', 86, 86, true );
	add_image_size( '270x270', 270, 270, true );
	add_image_size( '114x42', 114, 42, true );
	add_image_size( '242x229', 242, 229, true );
	add_image_size( '80x30', 80, 30, true );
	add_image_size( '830x390', 830, 390, true );
	
	comre_sh_login_user();	
}


function sh_widget_init()
{
	global $wp_registered_sidebars;
	$theme_options = _WSH()->option();
	if( class_exists( 'SH_About_Us' ) )register_widget( 'SH_About_Us' );
    if( class_exists( 'SH_Show_Services' ) )register_widget( 'SH_Show_Services' );
    if( class_exists( 'SH_Show_News' ) )register_widget( 'SH_Show_News' );
    if( class_exists( 'SH_Recent_Posts' ) )register_widget( 'SH_Recent_Posts' );
    if( class_exists( 'SH_Show_Testimonials' ) )register_widget( 'SH_Show_Testimonials' );
    if( class_exists( 'SH_Instagram_Gallery' ) )register_widget( 'SH_Instagram_Gallery' );
	if( class_exists( 'SH_NewsLetter' ) )register_widget( 'SH_NewsLetter' );
	if( class_exists( 'SH_Quicklinks' ) )register_widget( 'SH_Quicklinks' );
	if( class_exists( 'SH_Flickr' ) )register_widget( 'SH_Flickr' );
	if( class_exists( 'SH_Twitter' ) )register_widget( 'SH_Twitter' );
	
	
	if( class_exists( 'SH_Call_Out' ) )register_widget( 'SH_Call_Out' );
	register_sidebar(array(
	  'name' => __( 'Default Sidebar', 'comre' ),
	  'id' => 'default-sidebar',
	  'description' => __( 'Widgets in this area will be shown on the right-hand side.', 'comre' ),
	  'class'=>'',
	  'before_widget'=>'<div id="%1$s" class="blog-side-bar widget %2$s">',
	  'after_widget'=>'</div>',
	  'before_title' => '<h5>',
	  'after_title' => '</h5>'
	));
	register_sidebar(array(
	  'name' => __( 'Footer Top Sidebar', 'comre' ),
	  'id' => 'footer-top-sidebar',
	  'description' => __( 'Widgets in this area will be shown in Footer Area.', 'comre' ),
	  'class'=>'',
	  'before_widget'=>'<div id="%1$s"  class="col-lg-4 col-md-6 col-xs-12 %2$s"><div class="widget">',
	  'after_widget'=>'</div></div>',
	  'before_title' => '<div class="widget-title"><h3><span class="divider"></span>',
	  'after_title' => '</h3></div>'
	));
	
	register_sidebar(array(
	  'name' => __( 'Footer Sidebar', 'comre' ),
	  'id' => 'footer-sidebar',
	  'description' => __( 'Widgets in this area will be shown in Footer Area.', 'comre' ),
	  'class'=>'',
	  'before_widget'=>'<li id="%1$s" class="col-sm-4 %2$s">',
	  'after_widget'=>'</li>',
	  'before_title' => '<h6>',
	  'after_title' => '</h6>'
	));
	register_sidebar(array(
	  'name' => __( 'Blog Listing', 'comre' ),
	  'id' => 'blog-sidebar',
	  'description' => __( 'Widgets in this area will be shown on the right-hand side.', 'comre' ),
	  'class'=>'',
	  'before_widget' => '<div class="widget %2$s">',
	  'after_widget' => "</div>",
	  'before_title' => '<div class="widget-title"><h3><span class="divider"></span>',
	  'after_title' => '</h3></div>',
	));
	register_sidebar(array(
	  'name' => __( 'Header Sidebar', 'comre' ),
	  'id' => 'header-sidebar',
	  'description' => __( 'Widgets in this area will be shown in the header.', 'comre' ),
	  'class'=>'',
	  'before_widget' => '<div class="search">',
	  'after_widget' => "</div>",
	  'before_title' => '<div class="widget-title"><h3><span class="divider"></span>',
	  'after_title' => '</h3></div>',
	));
	
	
	
	
	if( !is_object( _WSH() )  )  return;
	$sidebars = sh_set(sh_set( $theme_options, 'dynamic_sidebar' ) , 'dynamic_sidebar' ); 
	foreach( array_filter((array)$sidebars) as $sidebar)
	{
		if(sh_set($sidebar , 'topcopy')) continue ;
		
		$name = sh_set( $sidebar, 'sidebar_name' );
		
		if( ! $name ) continue;
		$slug = sh_slug( $name ) ;
		
		register_sidebar( array(
			'name' => $name,
			'id' =>  $slug ,
		    'before_widget' => '<div class="widget">',
	        'after_widget' => "</div>",
	        'before_title' => '<div class="widget-title"><h3><span class="divider"></span>',
	        'after_title' => '</h3></div>',
		) );		
	}
	
	update_option('wp_registered_sidebars' , $wp_registered_sidebars) ;
}
add_action( 'widgets_init', 'sh_widget_init' );
// Update items in cart via AJAX
add_filter('add_to_cart_fragments', 'sh_woo_add_to_cart_ajax');
function sh_woo_add_to_cart_ajax( $fragments ) {
    
	global $woocommerce;
    
	
	ob_start(); ?>
	<li class="cartbutton"><a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>"><i class="fa fa-shopping-cart"></i><span class="bubble"><?php echo balanceTags( $woocommerce->cart->cart_contents_count )?></span></a></li>
	
	<?php $fragments['li.cartbutton'] = ob_get_clean();	
    return $fragments;
}
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
if( function_exists('vc_map')) {
	vc_set_shortcodes_templates_dir( get_template_directory().'/includes/modules/shortcodes' );
	vc_disable_frontend();
	
	add_action( 'vc_before_init', '_sh_prefix_vcSetAsTheme' );
	function _sh_prefix_vcSetAsTheme() {
	    vc_set_as_theme();
	}

	//if( function_exists('wpb_js_composer_check_version_schedule_deactivation')) wpb_js_composer_check_version_schedule_deactivation();
}
