<?php

// Prevent direct file calls
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( post_password_required() ) {
?> 
	
    <p><?php _e( 'This post is password protected. Enter the password to view the comments.', APP_TD ); ?></p>
	
<?php
    return;
}
	
if ( have_comments() ) : ?>

    <div class="comments-box coupon">

        <ul class="comments-mini">
		
			<?php wp_list_comments(array('callback' => 'fl_mini_comments', 'reverse_top_level' => 'desc')); ?>
		
        </ul>

    </div>

<?php endif; ?>