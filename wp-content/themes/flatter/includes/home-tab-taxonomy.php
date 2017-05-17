<?php $taxonomy = ( $object_id == CLPR_Coupon_Stores::get_id() ? APP_TAX_STORE : APP_TAX_CAT ); ?>

<div class="blog">
	<div class="head">
		<h2><?php echo $title; ?></h2>
	</div> <!-- #head -->
	<div class="directory <?php echo $taxonomy; ?> clearfix">
		<?php echo fl_create_categories_list( 'tab', $taxonomy ); ?>
	</div>
</div>