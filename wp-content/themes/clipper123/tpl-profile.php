<?php
/**
 * Template Name: User Profile
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */

global $wp_version;

$current_user = wp_get_current_user(); // grabs the user info and puts into vars
?>

<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Edit Profile', APP_TD ); ?></h1>

				<div class="text-box">

					<?php do_action( 'appthemes_notices' ); ?>

					<p><?php _e( 'Update your user profile below.', APP_TD ); ?></p>

				</div>

				<div class="post-box">

					<form name="profile" id="loginForm" action="" method="post" class="loginForm">
						<?php wp_nonce_field( 'app-edit-profile' ); ?>

						<input type="hidden" name="from" value="profile" />
						<input type="hidden" name="checkuser_id" value="<?php echo $user_ID; ?>" />


						<fieldset>

							<ol>
								<li>
									<label><?php _e( 'Username:', APP_TD ); ?></label>
									<input type="text" name="user_login" class="text regular-text" id="user_login" value="<?php echo $current_user->user_login; ?>" maxlength="100" disabled />
								</li>

								<li>
									<label for="first_name"><?php _e( 'First Name:', APP_TD ); ?></label>
									<input type="text" name="first_name" class="text regular-text" id="first_name" value="<?php echo $current_user->first_name; ?>" maxlength="100" />
								</li>

								<li>
									<label for="last_name"><?php _e( 'Last Name:', APP_TD ); ?></label>
									<input type="text" name="last_name" class="text regular-text" id="last_name" value="<?php echo $current_user->last_name; ?>" maxlength="100" />
								</li>

								<li>
									<label for="nickname"><?php _e( 'Nickname:', APP_TD ); ?></label>
									<input type="text" name="nickname" class="text regular-text" id="nickname" value="<?php echo $current_user->nickname; ?>" maxlength="100" />
								</li>

								<li>
									<label for="display_name"><?php _e( 'Display Name:', APP_TD ); ?></label>
									<select name="display_name" class="text regular-text" id="display_name">
									<?php foreach ( appthemes_get_user_profile_display_name_options() as $id => $item ) { ?>
										<option id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $item ); ?>" <?php selected( $current_user->display_name, $item ); ?>><?php echo esc_attr( $item ); ?></option>
									<?php } ?>
									</select>
								</li>

								<li>
									<label for="email"><?php _e( 'Email:', APP_TD ); ?></label>
									<input type="email" name="email" class="text regular-text" id="email" value="<?php echo $current_user->user_email; ?>" maxlength="100" />
								</li>

								<li>
									<label for="url"><?php _e( 'Website:', APP_TD ); ?></label>
									<input type="url" name="url" class="text regular-text" id="url" value="<?php echo $current_user->user_url; ?>" maxlength="100" />
								</li>

								<li>
									<label for="description"><?php _e( 'About Me:', APP_TD ); ?></label>
									<textarea name="description" class="text regular-text" id="description" rows="10" cols="50"><?php echo $current_user->description; ?></textarea>
								</li>

								<?php foreach ( _wp_get_user_contactmethods( $current_user ) as $name => $desc ) : ?>
									<li>
										<label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?>:</label>
										<input type="text" name="<?php echo $name; ?>" class="text regular-text" id="<?php echo $name; ?>" value="<?php echo esc_attr( $current_user->$name ); ?>" />
										<?php echo clpr_profile_fields_description( $name ); ?>
									</li>
								<?php endforeach; ?>

								<?php
									$show_password_fields = apply_filters( 'show_password_fields', true );
									if ( $show_password_fields ) :
								?>
										<?php if ( $wp_version < 4.3 ) : ?>

											<li>
												<label for="pass1"><?php _e( 'New Password:', APP_TD ); ?></label>
												<input type="password" name="pass1" class="text regular-text" id="pass1" maxlength="50" value="" /><br />
												<span class="description"><?php _e( 'Leave this field blank unless you would like to change your password.', APP_TD ); ?></span>
											</li>

											<li>
												<label for="pass2"><?php _e( 'Password Again:', APP_TD ); ?></label>
												<input type="password" name="pass2" class="text regular-text" id="pass2" maxlength="50" value="" /><br />
												<span class="description"><?php _e( 'Type your new password again.', APP_TD ); ?></span>
											</li>

											<li>
												<label>&nbsp;</label>
												<div id="pass-strength-result"><?php _e( 'Strength indicator', APP_TD ); ?></div><br /><br /><br />
												<span class="description"><?php _e( 'Your password should be at least seven characters long.', APP_TD ); ?></span>
											</li>

										<?php else: ?>

											<div class="user-pass1-wrap manage-password">
												<label for="pass1"><?php _e( 'New Password', APP_TD ); ?></label>
												<li>
													<button type="button" class="button wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', APP_TD ); ?></button>

													<span class="wp-pwd hide-if-js">
														<?php $initial_password = wp_generate_password( 24 ); ?>
														<input type="password" id="pass1" name="pass1" class="text regular-text" autocomplete="off" data-pw="<?php echo esc_attr( $initial_password ); ?>" aria-describedby="pass-strength-result" />
														<input type="text" style="display:none" name="pass2" id="pass2" autocomplete="off" />
													</span>
												</li>
												<li class="wp-pwd hide-if-js">
													<label>&nbsp;</label>
													<div>
														<button type="button" class="button wp-hide-pw hide-if-no-js" data-start-masked="<?php echo (int) isset( $_POST['pass1'] ); ?>" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password' ); ?>">
															<span class="dashicons dashicons-hidden"></span>
															<span class="text"><?php _e( 'Hide', APP_TD ); ?></span>
														</button>
														<button type="button" class="button wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', APP_TD ); ?>">
															<span class="text"><?php _e( 'Cancel', APP_TD ); ?></span>
														</button>
													</div>
												</li>
												<li class="wp-pwd hide-if-js">
													<label>&nbsp;</label>
													<div id="pass-strength-result"><?php _e( 'Strength indicator', APP_TD ); ?></div>
													<span class="description"><?php _e( 'Your password should be at least seven characters long.', APP_TD ); ?></span>
												</li>
											</div>

									<?php endif; ?>

								<?php endif; ?>

								<?php
									do_action( 'profile_personal_options', $current_user );
									do_action( 'show_user_profile', $current_user );
								?>

								<li>
									<button type="submit" class="btn profile" id="update-profile" name="submit" value="submit"><?php _e( 'Update Profile &raquo;', APP_TD ); ?></button>
								</li>

							</ol>

						</fieldset>

						<input type="hidden" name="action" value="app-edit-profile" />
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_ID; ?>" />
						<input type="hidden" name="admin_color" value="<?php echo esc_attr( $current_user->admin_color ); ?>" />
						<input type="hidden" name="rich_editing" value="<?php echo esc_attr( $current_user->rich_editing ); ?>" />
						<input type="hidden" name="comment_shortcuts" value="<?php echo esc_attr( $current_user->comment_shortcuts ); ?>" />

						<?php if ( _get_admin_bar_pref( 'front', $user_ID ) ) { ?>
							<input type="hidden" name="admin_bar_front" value="true" />
						<?php } ?>

					</form>

				</div> <!-- #post-box -->


			</div> <!-- #blog -->

		</div> <!-- #box-holder -->

	</div> <!-- #content-box -->


</div>

<?php get_sidebar( 'user' ); ?>
