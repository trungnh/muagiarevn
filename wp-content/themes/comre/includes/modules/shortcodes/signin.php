<?php ob_start(); ?>

<?php $messages = '';
if( sh_set( $_POST, 'user_login' ) )
	$messages = comre_sh_login_user( $_POST );?>

 <section class="sign-up">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <h4><?php echo $title;?></h4>
          <img class="img-responsive" src="<?php echo wp_get_attachment_url($image, 'full');?>" alt="" > </div>
        
        <!--======= SIGN UP FORM =========-->
        <div class="col-sm-6">
				<?php echo $messages; ?>
		  <?php if( !is_user_logged_in() ): ?>
		  <form action="<?php echo get_permalink(); ?>" name="loginform" method="post" id="loginform1" class="form form-register" >
            <ul class="row">

              <?php if( $social_position == 'top' ): ?>
              <li class="col-md-12"><?php do_action('login_form'); ?></li>
              <?php endif; ?>

              <li class="col-md-6">
                <div class="form-group">
                  <label for="lname"><?php esc_html_e('User Name *', 'comre');?>
                    <input type="text" name="user_login" class="form-control" id="lname" placeholder="">
                  </label>
                </div>
              </li>

              <li class="col-md-6">
                <div class="form-group">
                  <label for="password"><?php esc_html_e('Password', 'comre');?>
                    <input type="password" name="user_password" class="form-control" id="password" placeholder="">
                  </label>
                </div>
              </li>
              <li class="col-md-6">
                <?php $nonce = wp_create_nonce( '__comre_login_nonce' ); ?>
                <input type="hidden" name="_nounce" value="<?php echo esc_attr($nonce); ?>" />  
                <button type="submit" class="btn"><?php esc_html_e('Login', 'comre'); ?></button>
			  </li>

            </ul>
          </form>
          
          <?php if( $social_position == 'bottom' ) do_action('login_form'); ?>
		  <?php else: ?>

    		<a href="<?php echo wp_logout_url(home_url()); ?>" title="<?php esc_html_e('Logout', 'comre'); ?>" class="btn btn-primary"><?php esc_html_e('Logout', 'comre'); ?></a>				

   		  <?php endif; ?>
          <div class="policy">
            <p><?php echo $text;?></p>
          </div>
        </div>
      </div>
    </div>
  </section>


<?php return ob_get_clean();