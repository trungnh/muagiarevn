<?php $sq = get_search_query() ? get_search_query() : __( 'Tìm kiếm', APP_TD ); ?>

<div class="search-box">

	<form role="search" method="get" class="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" >

		<button value="<?php esc_attr_e( 'Tìm kiếm', APP_TD ); ?>" title="<?php esc_attr_e( 'Tìm kiếm', APP_TD ); ?>" type="submit" class="btn-submit"><i class="fa fa-search"></i><span><?php _e( 'Tìm kiếm', APP_TD ); ?></span></button>
		
		<label class="screen-reader-text" for="s"><?php _e( 'Kết quả tìm kiếm:', APP_TD ); ?></label>
		<input type="search" class="text newtag" id="s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e( 'Tìm kiếm theo gian hàng', APP_TD ); ?>" />
		
	</form>

</div>