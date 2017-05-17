<?php

/**

 * Lost password form

 *

 * @author 		WooThemes

 * @package 	WooCommerce/Templates

 * @version     2.3.0

 */

if ( ! defined( 'ABSPATH' ) ) {

    exit;

}

?>

<?php wc_print_notices(); ?>

<form method="post" class="lost_reset_password">

	<?php if( 'lost_password' == $args['form'] ) : ?>

        <p><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'comre' ) ); ?></p>

        <p class="form-row form-row-first"><label for="user_login"><?php esc_html_e( 'Username or email', 'comre' ); ?></label> <input class="input-text" type="text" name="user_login" id="user_login" /></p>

	<?php else : ?>

        <p><?php echo apply_filters( 'woocommerce_reset_password_message', __( 'Enter a new password below.', 'comre' ) ); ?></p>

        <p class="form-row form-row-first">

            <label for="password_1"><?php esc_html_e( 'New password', 'comre' ); ?> <span class="required">*</span></label>

            <input type="password" class="input-text form-control" name="password_1" id="password_1" />

        </p>

        <p class="form-row form-row-last">

            <label for="password_2"><?php esc_html_e( 'Re-enter new password', 'comre' ); ?> <span class="required">*</span></label>

            <input type="password" class="input-text form-control" name="password_2" id="password_2" />

        </p>

        <input type="hidden" name="reset_key" value="<?php echo isset( $args['key'] ) ? $args['key'] : ''; ?>" />

        <input type="hidden" name="reset_login" value="<?php echo isset( $args['login'] ) ? $args['login'] : ''; ?>" />

    <?php endif; ?>

    <div class="clear"></div>

    <p class="form-row"><input type="submit" class="button btn btn-primary" name="wc_reset_password" value="<?php echo 'lost_password' == $args['form'] ? __( 'Reset Password', 'comre' ) : __( 'Save', 'comre' ); ?>" /></p>

	<?php wp_nonce_field( $args['form'] ); ?>

</form>