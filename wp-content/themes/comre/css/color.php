<?php


/** Set ABSPATH for execution */
define( 'ABSPATH', dirname(dirname(__FILE__)) . '/' );
define( 'WPINC', 'wp-includes' );


/**
 * @ignore
 */
function add_filter() {}

/**
 * @ignore
 */
function esc_attr($str) {return $str;}

/**
 * @ignore
 */
function apply_filters() {}

/**
 * @ignore
 */
function get_option() {}

/**
 * @ignore
 */
function is_lighttpd_before_150() {}

/**
 * @ignore
 */
function add_action() {}

/**
 * @ignore
 */
function did_action() {}

/**
 * @ignore
 */
function do_action_ref_array() {}

/**
 * @ignore
 */
function get_bloginfo() {}

/**
 * @ignore
 */
function is_admin() {return true;}

/**
 * @ignore
 */
function site_url() {}

/**
 * @ignore
 */
function admin_url() {}

/**
 * @ignore
 */
function home_url() {}

/**
 * @ignore
 */
function includes_url() {}

/**
 * @ignore
 */
function wp_guess_url() {}

if ( ! function_exists( 'json_encode' ) ) :
/**
 * @ignore
 */
function json_encode() {}
endif;



/* Convert hexdec color string to rgb(a) string */
 
function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
$blue = $_GET['b'];
$yellow = $_GET['y'];
$black = $_GET['bl'];

ob_start(); ?>

.btn-border:hover, header nav, .slide-products, .text-slide, #banner .owl-buttons div, .great-deals .coupon-inner .btn,.great-deals .coupon-inner .btn,
.featured .cate-tittle, .top-w-deal li .w-over a, .top-offer .owl-nav div:hover, .coupen-tab .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .pagination li a:hover, #team .btm-detail, .pricing .price-head, .filter li a:hover, .filter li a.active, .stores .finde button, .cou-type .nav-tabs > li > a:hover, .cou-type .nav-tabs > li.active > a, .coupon-win .join:hover, .blog .blog-post .btn:hover, .hight-lights .w-bg,
.drop-cobs p span, .drop-cobs p span.border, #accordion .panel-default > .panel-heading, #tabs .nav-tabs > li.active a, .skills-bar .progress-bar, footer button, .tp-leftarrow::before, .tp-rightarrow::before,    
.btn, .button {

	background: #<?php echo $blue; ?>;
}

header .search button,.btn-border,.great-deals .coupon-inner .btn:hover, .great-deals .btm-info li:nth-child(1) i, .featured .cate-over .after-over a:hover,
.blog .b-details h6 a:hover, .top-offer .owl-nav div, .clients .clients-detail .avatar h6, filter li a, .filter li select, .portfolio .items-info h5, .portfolio .prod-item a:hover, .portfolio .up-to span, .stores .letters h3, .stores .letters li a:hover, .stores .letters li a:hover, .policy a, .com-feature li i, .coupon-win .join, .blog .title-hed:hover, .blog .blog-post .btn, .blog-side-bar a:hover, .post-navi span.hiding:hover, .comments .media a, .contact-info .con-det i, .hight-lights .w-under, .drop-cobs p span.border, 
.btn:hover{
	color: #<?php echo $blue; ?>;
}

.btn-border, .top-offer .owl-nav div, .our-best li:hover .icon, filter li a, .filter li a:hover, .filter li a.active, .filter li select, .sign-up li .form-control:focus, .form-control:focus, .coupon-win, .blog .blog-post .btn, .drop-cobs p span.border, #tabs .nav-tabs  {
	border-color: #<?php echo $blue; ?>;
}


/* Black color */

footer .rights {

	background: #<?php echo $black; ?>;
}

/* Yellow color */

body .btn:hover, body .button:hover, header nav li.active a, header nav li a:hover, header .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .ownmenu > li:hover > a, .ownmenu > li.active > a, .sub-nav-co a,  .great-deals .coupon-inner .btn:hover, .top-w-deal li .w-over a:hover, .coupon-win, #accordion .icon-accor {

	background: #<?php echo $yellow; ?>;
}

header .ownmenu ul.dropdown li a:hover, .sub-nav li i, footer .links a:hover {
	color: #<?php echo $yellow; ?>;

}
.great-deals .coupon-inner:hover, .our-best .icon, .cou-type .nav-tabs > li > a:hover, .cou-type .nav-tabs > li.active > a, .ownmenu ul.dropdown {
	border-color: #<?php echo $yellow; ?>;
}

.coupon-win {
	outline: 10px solid #<?php echo $yellow; ?>;
}
.sub-nav-co a::before {
	border-right-color: #<?php echo $yellow; ?>;
	left: -18px;
}

<?php 

$out = ob_get_clean();
$expires_offset = 31536000; // 1 year
header('Content-Type: text/css; charset=UTF-8');
header('Expires: ' . gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
header("Cache-Control: public, max-age=$expires_offset");
header('Vary: Accept-Encoding'); // Handle proxies
header('Content-Encoding: gzip');

echo gzencode($out);
exit;