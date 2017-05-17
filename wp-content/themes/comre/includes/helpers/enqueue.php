<?php

class SH_Enqueue
{
	
	function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'sh_enqueue_scripts' ) );
		add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );
		
		// Apply filter
		add_filter('body_class', array( $this, 'custom_body_classes') );
		
		add_action( '_sh_body_id', array( $this, 'body_id' ) );
		
	}
	
	function sh_enqueue_scripts()
	{
		global $post, $wp_query;
		$options = _WSH()->option();
		$rtl = sh_set($options,'rtl');
		$current_theme = wp_get_theme();
		$header_style = sh_set( $options, 'header_style' );
		//$header_style = sh_set( $_GET, 'header_style' ) ? 'side' : 'normal';
 
		$version = $current_theme->get( 'Version' );
		
		$yellow = str_replace( '#', '' , sh_set( $options, 'main_color_scheme', 'ffdd00' ) );
		$blue = str_replace( '#', '' , sh_set( $options, 'hover_color_scheme', '002b5e' ) );
		$ping = str_replace( '#', '' , sh_set( $options, 'offer_color_scheme', 'f01b3b' ) );
		$black = str_replace( '#', '' , sh_set( $options, 'footer_color_scheme', '111111' ) );
		
		$protocol = is_ssl() ? 'https' : 'http';
		$styles = array( 
						 
						 'Montserrat' => $protocol.'://fonts.googleapis.com/css?family=Montserrat:400,700',
						 'Lato' => $protocol.'://fonts.googleapis.com/css?family=Lato:100,300,400,700,900',
 						 
						 'font-awesome' => 'css/font-awesome.min.css',
						 'comre-bootstrap' => 'css/bootstrap.css',
						 'comre-animate' => 'css/animate.css',
						 'comre-main' => 'css/main.css',
						 'main_style' => 'style.css',
						 //'prettyPhoto' => 'css/prettyPhoto.css', 
						 
						 'woocommerce' => ( class_exists('woocommerce') ) ? 'css/woocommerce.css' : '',
						 //'color_scheme' => 'css/color.less' ,
						 'comre-responsive' => 'css/responsive.css',
						 'main-color' => 'css/color.php?y='.$yellow.'&b='.$blue.'&bl='.$black
					   );
					if ($rtl){
						$styles['rtl-style'] = 'css/rtl.css';
					}
					   
		
		$styles = $this->custom_fonts($styles); //Load google fonts that user choose from theme options
		
		//if( $dark_color ) $styles['dark_scheme'] = 'css/dark-style.css';
							
		foreach( $styles as $name => $style )
		{
			if( !$style ) continue;
			if(strstr($style, 'http') || strstr($style, 'https') ) wp_enqueue_style( $name, $style);
			else wp_enqueue_style( $name, _WSH()->includes( $style, true ), '', $version );
		}
		
		$scripts = array( 
						  'bootstrap' => 'js/bootstrap.min.js',
						  'jflickrfeed' => 'js/jflickrfeed.min.js',
						  'bootstrap-hover' => 'js/bootstrap-hover-dropdown.js', 
-						  'jquery-flexslider'		=> 'js/jquery.flexslider-min.js',
						  'owl-carousel'		=> 'js/owl.carousel.min.js',
						  'zeroclipboard'		=> 'js/jquery.zclip.js',
						  'own-menu'		=> 'js/own-menu.js',		  
						  'jquery-stellar'	=> 'js/jquery.stellar.js',
						  'jquery-sticky' => 'js/jquery.sticky.js',
						  'jquery-mapmarker' => 'js/mapmarker.js',
						  'builder_prettyphoto_theme' => 'js/jquery.prettyPhoto.js',
						  'jquery-isotope'=>'js/jquery.isotope.min.js',
						  'jquery-mixitup'=> 'js/jquery.mixitup.min.js',
						  'jquery-wow' => 'js/wow.min.js',
						  'main-script'	 => 'js/main.js',
						 );
		//wp_enqueue_script('zeroclipboard', get_template_directory_uri().'/js/ZeroClipboard.js');
		foreach( $scripts as $name => $js )
		{
			wp_register_script( $name, _WSH()->includes( $js, true ), '', $version, true);
		}
		
		wp_enqueue_script( array('jquery', 'bootstrap', 'jquery-sticky', 'own-menu', 'jquery-wow', 'main-script'));
		
		if( is_singular() ) wp_enqueue_script('comment-reply');
		
		
		
		
	}
	
	function wp_head()
	{
		$opt = _WSH()->option(); ?>
		<script type="text/javascript"> if( ajaxurl === undefined ) var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php'));?>";</script>
		<style type="text/css">
			<?php
			if( sh_set( $opt, 'body_custom_font') )
			echo sh_get_font_settings( array( 'body_font_size' => 'font-size', 'body_font_family' => 'font-family', 'body_font_style' => 'font-style', 'body_font_color' => 'color', 'body_line_height' => 'line-height' ), 'body, p {', '}' );
			
			if( sh_set( $opt, 'use_custom_font' ) ){
				echo sh_get_font_settings( array( 'h1_font_size' => 'font-size', 'h1_font_family' => 'font-family', 'h1_font_style' => 'font-style', 'h1_font_color' => 'color', 'h1_line_height' => 'line-height' ), 'h1 {', '}' );
				echo sh_get_font_settings( array( 'h2_font_size' => 'font-size', 'h2_font_family' => 'font-family', 'h2_font_style' => 'font-style', 'h2_font_color' => 'color', 'h2_line_height' => 'line-height' ), 'h2 {', '}' );
				echo sh_get_font_settings( array( 'h3_font_size' => 'font-size', 'h3_font_family' => 'font-family', 'h3_font_style' => 'font-style', 'h3_font_color' => 'color', 'h3_line_height' => 'line-height' ), 'h3 {', '}' );
				echo sh_get_font_settings( array( 'h4_font_size' => 'font-size', 'h4_font_family' => 'font-family', 'h4_font_style' => 'font-style', 'h4_font_color' => 'color', 'h4_line_height' => 'line-height' ), 'h4 {', '}' );
				echo sh_get_font_settings( array( 'h5_font_size' => 'font-size', 'h5_font_family' => 'font-family', 'h5_font_style' => 'font-style', 'h5_font_color' => 'color', 'h5_line_height' => 'line-height' ), 'h5 {', '}' );
				echo sh_get_font_settings( array( 'h6_font_size' => 'font-size', 'h6_font_family' => 'font-family', 'h6_font_style' => 'font-style', 'h6_font_color' => 'color', 'h6_line_height' => 'line-height' ), 'h6 {', '}' );
			}
			echo sh_set( $opt, 'header_css' );
			?>
		</style>
        
        <?php $color_scheme = sh_set($opt, 'custom_color_scheme', '#f4c212');
        //if(function_exists('sh_theme_color_scheme')) echo balanceTags('<style>'.sh_theme_color_scheme($color_scheme).'</style>'); ?>
        
        <?php
	}
	
	function wp_footer()
	{
		$analytics = sh_set( _WSH()->option(), 'footer_analytics');
		
		echo balanceTags($analytics);
		
		$theme_options = _WSH()->option();
		
		if( sh_set( $theme_options, 'footer_js' ) ): ?>
			<script type="text/javascript">
                <?php echo sh_set( $theme_options, 'footer_js' );?>
            </script>
        <?php endif;
	}
	
	function custom_fonts( $styles )
	{
		$opt = _WSH()->option();
		$protocol = ( is_ssl() ) ? 'https' : 'http';
		$font = array();
		//$font_options = array('h1_font_family', 'h2_font_family', 'h3_font_family');
		
		if( sh_set( $opt, 'use_custom_font' ) ){
			
			if( $h1 = sh_set( $opt, 'h1_font_family' ) ) $font[$h1] = urlencode( $h1 ).':400,300,600,700,800';
			if( $h2 = sh_set( $opt, 'h2_font_family' ) ) $font[$h2] = urlencode( $h2 ).':400,300,600,700,800';
			if( $h3 = sh_set( $opt, 'h3_font_family' ) ) $font[$h3] = urlencode( $h3 ).':400,300,600,700,800';
		}
		
		if( sh_set( $opt, 'body_custom_font' ) ){
			if( $body = sh_set( $opt, 'body_font_family' ) ) $font[$body] = urlencode( $body ).':400,300,600,700,800';
		}
		
		if( $font ) $styles['sh_google_custom_font'] = $protocol.'://fonts.googleapis.com/css?family='.implode('|', $font);
		
		return $styles;
	}
	
	function custom_body_classes( $classes )
	{
		$options = _WSH()->option();
		
		$dark_color = ( sh_set( $options, 'website_theme' ) == 'dark' ) ? true : false;
		
		$dark_color = ( sh_set( $_GET, 'color_style' ) == 'dark' ) ? true : $dark_color;
		
		if( $dark_color ) $classes[] = 'dark-style';
	
		return $classes;
	}
	
	function body_id() 
	{
		$options = _WSH()->option();
		
		$boxed = sh_set( $options, 'boxed_layout' );
		
		$boxed_layout = ( $boxed && !$nobg ) ? ' id="boxed" ' : ''; 
		
		echo balanceTags($boxed_layout);
	}
}