<?php
// Template Name: Password Reset
?>

<?php global $wp_version; ?>

<div id="content">

	<div class="content-box">

		<div class="box-c">

			<div class="box-holder">

				<div class="blog">

					<h1><?php _e( 'Password Reset', APP_TD ); ?></h1>

					<div class="content-bar">

						<span><?php _e( 'Enter your new password below.', APP_TD ); ?></span>

					</div>

					<?php do_action( 'appthemes_notices' ); ?>

					<form action="<?php echo esc_url( appthemes_get_password_reset_url( 'login_post' ) ); ?>" method="post" class="loginForm password-reset-form" name="resetpassform" id="loginForm">

						<input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />

						<fieldset>

							<ol>
							<?php if ( $wp_version < 4.3 ) : ?>
								<li>
									<label for="pass1"><?php _e( 'New password', APP_TD ); ?></label>
									<input type="password" name="pass1" id="pass1" class="text" size="20" value="" autocomplete="off" tabindex="1" />
								</li>

								<li>
									<label for="pass2"><?php _e( 'Confirm new password', APP_TD ); ?></label>
									<input type="password" name="pass2" id="pass2" class="text" size="20" value="" autocomplete="off" tabindex="2" />
								</li>

							<?php else: ?>

								<div class="user-pass1-wrap manage-password">
									<p>
										<label for="pass1"><?php _e( 'New Password', APP_TD ); ?></label>

										<?php $initial_password = isset( $_POST['pass1'] ) ? stripslashes( $_POST['pass1'] ) : wp_generate_password( 18 ); ?>

										<input tabindex="3" type="password" id="pass1" name="pass1" class="text required" autocomplete="off" data-reveal="1" data-pw="<?php echo esc_attr( $initial_password ); ?>" aria-describedby="pass-strength-result" />
										<input type="text" style="display:none" name="pass2" id="pass2" autocomplete="off" />

										<button type="button" class="btn wp-hide-pw hide-if-no-js" data-start-masked="<?php echo (int) isset( $_POST['pass1'] ); ?>" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', APP_TD ); ?>">
											<span class="dashicons dashicons-hidden"></span>
											<span class="text"><?php _e( 'Hide', APP_TD ); ?></span>
										</button>
									</p>
								</div>

							<?php endif; ?>

							<div class="strength-meter">
								<div id="pass-strength-result" class="hide-if-no-js"><?php _e( 'Strength indicator', APP_TD ); ?></div>
								<span class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', APP_TD ); ?></span>
							</div>

							<li>
								<button tabindex="3" type="submit" class="btn forgot" id="resetpass" name="resetpass" value="resetpass"><?php _e( 'Reset Password', APP_TD ); ?></button>
								<?php do_action( 'lostpassword_form' ); ?>
							</li>
						</ol>


						</fieldset>

						<!-- autofocus the field -->
						<script type="text/javascript">try{document.getElementById('pass1').focus();}catch(e){}</script>

					</form>

				</div>

			</div><!--/box-holder -->

		</div>

	</div>

</div><!-- /content -->

<?php get_sidebar('login'); ?>
