<?php
$post_status = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );

$tax_args = array(
	'taxonomy' => $object,
	'terms' => $object_id,
);

$args = array(
	'post_status' => $post_status,
	'ignore_sticky_posts' => 1,
	'tax_query' => array(
		$tax_args,
	),
);
query_posts( $args );

add_filter( 'appthemes_pagenavi_args', array( $hold = new FL_Filter_Storage( $tax_args ), 'fl_tax_pagenum_link' ) );
?>

<div class="head">
	<h2><?php echo $title; ?></h2>
	<div class="counter"><?php printf( _n( 'Có %s mã giảm giá đang hoạt động', 'Có %s mã giảm giá đang hoạt động', $wp_query->found_posts, APP_TD ), html( 'span', $wp_query->found_posts ) ); ?></div>
</div> <!-- #head -->

<?php
get_template_part( 'loop', 'coupon' );

remove_filter( 'appthemes_pagenavi_args', array( $hold, 'fl_tax_pagenum_link' ) );
wp_reset_query();