<?php
$post_status = ( $clpr_options->exclude_unreliable ) ? array( 'publish' ) : array( 'publish', 'unreliable' );
	
$args = array(
	'post_type' => APP_POST_TYPE,
	'post_status' => $post_status,
	'ignore_sticky_posts' => 1,
	'orderby' => 'comment_count',
	'order' => 'DESC',
	'paged' => ( get_query_var( 'paged' ) && isset( $_GET['tab'] ) && $_GET['tab'] == $type ) ? get_query_var( 'paged' ) : 1,
);
query_posts( $args );
add_filter( 'appthemes_pagenavi_args', array( $hold = new FL_Filter_Storage( $type ), 'fl_add_tab_args' ) );
?>

<div class="head">
	<div class="counter"><?php printf( _n( 'Có %s mã giảm giá đang hoạt động', 'Có %s mã giảm giá đang hoạt động', $wp_query->found_posts, APP_TD ), html( 'span', $wp_query->found_posts ) ); ?></div>
</div> <!-- #head -->

<?php

get_template_part( 'loop', 'coupon' );

remove_filter( 'appthemes_pagenavi_args', array( $hold, 'fl_add_tab_args' ) );
wp_reset_query();