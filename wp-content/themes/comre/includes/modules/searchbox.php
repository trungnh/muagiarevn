<?php $options = _WSH()->option('search_post_types'); //printr($options);
$post_type = array('post'=> "Blog Posts", 'product' => 'Products', 'sh_coupons' => 'Coupons'  );?>
<form action="<?php echo home_url(); ?>" method="get">

<?php if( $options ): ?>
<select class="form-control" name="post_type">

    <option>All</option>

    <?php foreach( $options as $opt ): ?>
    	<option value="<?php echo esc_attr($opt); ?>"><?php echo sh_set( $post_type, $opt ); ?></option>
	<?php endforeach; ?>

</select>
<?php endif; ?>
<input class="form-control" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Enter your keyword...',  'comre'); ?>">

<button type="submit"><i class="fa fa-search"></i></button>

</form>