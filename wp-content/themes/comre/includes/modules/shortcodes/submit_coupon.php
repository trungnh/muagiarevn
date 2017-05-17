<?php ob_start(); ?>

<div class="sub-cin">
	
	<?php _sh_submit_a_coupon(); ?>
	
	<?php if( is_user_logged_in() ): ?>
	<form action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data">
		<h6>Coupon Title</h6>
		<input class="form-control" type="text" name="post_title" >
		<h6>Description</h6>
		<textarea class="form-control" name="post_content"></textarea>
		
		<?php $terms = get_terms('coupons_category' ); 
		
		if( $terms ):?>
		<h6>Category</h6>
		<select class="form-control" name="coupons_category">
		<?php foreach( $terms as $term ): ?>
			<option value="<?php echo esc_attr( $term->slug ); ?>"><?php echo $term->name; ?></option>
		<?php endforeach; ?>
		
		</select>
		<?php endif; ?>
		
		<h6><?php esc_html_e('Featured Image', 'comre');?></h6>
		<input class="form-control" type="file" name="featured_image" />
		
		<h6><?php esc_html_e('Expiration', 'comre');?></h6>
		<input class="form-control" type="date" name="expiration" />
		
		<h6><?php esc_html_e('Coupon Code', 'comre');?></h6>
		<input class="form-control" type="text" name="coupon_code" />
		
		<?php $nonce = wp_create_nonce( '__comre_nonce' ); ?>
		<input type="hidden" name="_nounce" value="<?php echo esc_attr($nonce); ?>" />
		
		<div class="clearfix">
		<input type="submit" class="btn btn-primary pull-right" value="Submit" />
		
		</div>
    </form>
	<?php else: ?>
		<h3> <?php esc_html_e('Sign in or Register to post Coupon', 'comre' ); ?> </h3>
	<?php endif; ?>
</div>

<?php return ob_get_clean();