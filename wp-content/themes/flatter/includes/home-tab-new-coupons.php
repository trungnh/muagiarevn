<?php 
$post_status = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );
$posts_count = appthemes_count_posts( APP_POST_TYPE, $post_status );
if( !isset( $type ) ) {
	$type = '';
}
?>

<div class="head">
	<div class="counter"><?php printf( _n( 'Có %s mã giảm giá đang hoạt động', 'Có %s mã giảm giá đang hoạt động', $posts_count, APP_TD ), html( 'span', $posts_count ) ); ?></div>

</div> <!-- #head -->

<?php
// show all coupons and setup pagination
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$paged = ( isset( $_GET['tab'] ) && $_GET['tab'] != $type ) ? 1 : $paged;
query_posts( array( 'post_type' => APP_POST_TYPE, 'post_status' => $post_status, 'ignore_sticky_posts' => 1, 'paged' => $paged ) );
add_filter( 'appthemes_pagenavi_args', array( $hold = new FL_Filter_Storage( $type ), 'fl_add_tab_args' ) );

get_template_part( 'loop', 'coupon' ); 

remove_filter( 'appthemes_pagenavi_args', array( $hold, 'fl_add_tab_args' ) );
wp_reset_query();