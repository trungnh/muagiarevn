<?php
/**
 * Template Name: Register
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.3.2
 */

global $wp_version;

// set a redirect for after logging in
if ( isset( $_REQUEST['redirect_to'] ) ) {
	$redirect = $_REQUEST['redirect_to'];
}

if ( ! isset( $redirect ) ) {
	$redirect = home_url();
}

$show_password_fields = apply_filters( 'show_password_fields_on_registration', true );
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Register', APP_TD ); ?></h1>

				<div class="content-bar">

					<span><?php _e( 'Complete the fields below to become a member.', APP_TD ); ?></span>

				</div>

			</div>

			<div class="post-box">

				<?php do_action( 'appthemes_notices' ); ?>

				<?php if ( get_option( 'users_can_register' ) ) : ?>

					<form action="<?php echo appthemes_get_registration_url( 'login_post' ); ?>" method="post" class="loginForm" name="registerform" id="loginForm">

						<fieldset>

							<ol>
								<li>
									<label for="user_login"><?php _e( 'Username:', APP_TD ); ?></label>
									<input tabindex="1" type="text" class="text required" name="user_login" id="user_login" value="<?php if ( isset( $_POST['user_login'] ) ) echo esc_attr( stripslashes( $_POST['user_login'] ) ); ?>" />
								</li>

								<li>
									<label for="user_email"><?php _e( 'Email:', APP_TD ); ?></label>
									<input tabindex="2" type="email" class="text required email" name="user_email" id="user_email" value="<?php if ( isset( $_POST['user_email'] ) ) echo esc_attr( stripslashes( $_POST['user_email'] ) ); ?>" />
								</li>

								<?php if ( $show_password_fields ) : ?>

									<?php if ( $wp_version < 4.3 ) : ?>

										<li>
											<label for="pass1"><?php _e( 'Password:', APP_TD ); ?></label>
											<input tabindex="3" type="password" class="text required" name="pass1" id="pass1" value="" autocomplete="off" />
										</li>

										<li>
											<label for="pass2"><?php _e( 'Password Again:', APP_TD ); ?></label>
											<input tabindex="4" type="password" class="text required" name="pass2" id="pass2" value="" autocomplete="off" />
										</li>

									<?php else: ?>

										<div class="user-pass1-wrap manage-password">

											<p>
												<label for="pass1"><?php _e( 'Password:', APP_TD ); ?></label>

												<?php $initial_password = isset( $_POST['pass1'] ) ? stripslashes( $_POST['pass1'] ) : wp_generate_password( 18 ); ?>

												<input tabindex="3" type="password" id="pass1" name="pass1" class="text required" autocomplete="off" data-reveal="1" data-pw="<?php echo esc_attr( $initial_password ); ?>" aria-describedby="pass-strength-result" />
												<input type="text" style="display:none" name="pass2" id="pass2" autocomplete="off" />

												<button type="button" class="btn_orange wp-hide-pw hide-if-no-js" data-start-masked="<?php echo (int) isset( $_POST['pass1'] ); ?>" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', APP_TD ); ?>">
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

								<?php endif; ?>

								<?php do_action( 'register_form' ); ?>

								<li id="checksave">
									<button tabindex="6" type="submit" class="btn reg" id="register" name="register" value="register"><?php _e( 'Register', APP_TD ); ?></button>
								</li>

							</ol>

						</fieldset>

						<!-- autofocus the field -->
						<script type="text/javascript">try{document.getElementById('user_login').focus();}catch(e){}</script>

						<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect ); ?>" />

					</form>

				<?php else: ?>

					<h3><?php _e( 'User registration has been disabled.', APP_TD ); ?></h3>

				<?php endif; ?>

			</div>

		</div><!--/box-holder -->

	</div>

</div><!-- /content -->

<?php get_sidebar( 'login' ); ?>
