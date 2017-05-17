<?php

/**

 * Edit account form

 *

 * @author 		WooThemes

 * @package 	WooCommerce/Templates

 * @version     2.2.7

 */

if ( ! defined( 'ABSPATH' ) ) {

    exit;

}

?>

<?php wc_print_notices(); ?>

<form action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="form-row form-row-first">

		<label for="account_first_name"><?php esc_html_e( 'First name', 'comre' ); ?> <span class="required">*</span></label>

		<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />

	</p>

	<p class="form-row form-row-last">

		<label for="account_last_name"><?php esc_html_e( 'Last name', 'comre' ); ?> <span class="required">*</span></label>

		<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />

	</p>

	<p class="form-row form-row-wide">

		<label for="account_email"><?php esc_html_e( 'Email address', 'comre' ); ?> <span class="required">*</span></label>

		<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />

	</p>

	<fieldset>

		<legend><?php esc_html_e( 'Password Change', 'comre' ); ?></legend>

	

		<p class="form-row form-row-thirds">

			<label for="password_current"><?php esc_html_e( 'Current Password (leave blank to leave unchanged)', 'comre' ); ?></label>

			<input type="password" class="input-text" name="password_current" id="password_current" />

		</p>

		<p class="form-row form-row-thirds">

			<label for="password_1"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'comre' ); ?></label>

			<input type="password" class="input-text" name="password_1" id="password_1" />

		</p>

		<p class="form-row form-row-thirds">

			<label for="password_2"><?php esc_html_e( 'Confirm New Password', 'comre' ); ?></label>

			<input type="password" class="input-text" name="password_2" id="password_2" />

		</p>

	</fieldset>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>

		<?php wp_nonce_field( 'save_account_details' ); ?>

		<input type="submit" class="button" name="save_account_details" value="<?php esc_html_e( 'Save changes', 'comre' ); ?>" />

		<input type="hidden" name="action" value="save_account_details" />

	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

	

</form>