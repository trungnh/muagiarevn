<form action="<?php echo home_url(); ?>" method="get" class="clearfix">

<select class="form-control" name="post_type">

    <option>All Categories</option>

    <option value="post">Exclusive</option>

    <option>Coupon</option>

    <option>Cashback</option>

</select>

<input class="form-control" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_html_e('Enter your keyword...',  'comre'); ?>">

<button type="submit"><i class="fa fa-search"></i></button>

</form>