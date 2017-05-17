<?php
/**
 * Listing Submit Details Template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.6
 */
?>


<div id="content">

	<div class="content-box">

		<div class="box-holder">

			<div class="blog">

				<h1><?php _e( 'Share a Coupon', APP_TD ); ?></h1>

				<div class="content-bar"></div>

				<div class="text-box-form">

					<p><?php _e( 'Complete the form below to share your coupon with us.', APP_TD ); ?></p>

				</div>

			</div> <!-- #blog -->

			<div class="post-box">

				<?php do_action( 'appthemes_notices' ); ?>

				<form id="couponForm" method="post" class="post-form" enctype="multipart/form-data" action="<?php echo esc_url( appthemes_get_step_url() ); ?>">

					<input type="hidden" name="action" value="<?php echo esc_attr( $action ); ?>">
					<?php wp_nonce_field( $action ); ?>

					<fieldset>

						<ol>
							<li>
								<label><?php _e( 'Coupon Title:', APP_TD ); ?> </label>
								<input type="text" class="text required" id="post_title" name="post_title" value="<?php echo esc_attr( $listing->post_title ); ?>" />
							</li>

							<li>
								<label><?php _e( 'Store:', APP_TD ); ?></label>
								<?php clpr_dropdown_coupon_stores( $listing->store_id ); ?>
							</li>

							<li id="new-store-name" class="new-store">
								<label><?php _e( 'New Store Name:', APP_TD ); ?></label>
								<input type="text" class="text" name="new_store_name" value="" />
							</li>

							<li id="new-store-url" class="new-store">
								<label><?php _e( 'New Store URL:', APP_TD ); ?> </label>
								<input type="url" class="text" id="new_store_url" name="new_store_url" value="" />
							</li>

							<li>
								<label><?php _e( 'Coupon Category:', APP_TD ); ?> </label>
								<?php clpr_dropdown_coupon_categories( $listing->category_id ); ?>
							</li>

							<li>
								<label><?php _e( 'Coupon Type:', APP_TD ); ?> </label>
								<?php clpr_dropdown_coupon_types( $listing->type_id ); ?>
							</li>

							<li id="ctype-coupon-code" class="ctype">
								<label><?php _e( 'Coupon Code:', APP_TD ); ?> </label>
								<input type="text" class="text" name="clpr_coupon_code" value="<?php echo esc_attr( $listing->clpr_coupon_code ); ?>" />
							</li>

							<?php if ( clpr_has_printable_coupon( $listing->ID ) ) { ?>
								<li id="ctype-printable-coupon-preview" class="ctype">
									<label><?php _e( 'Current Coupon:', APP_TD ); ?> </label>
									<?php echo clpr_get_printable_coupon( $listing->ID ); ?>
								</li>
							<?php } ?>

							<li id="ctype-printable-coupon" class="ctype">
								<label><?php _e( 'Printed Coupon:', APP_TD ); ?> </label>
								<input type="file" class="fileupload text" name="coupon-upload" />
							</li>

							<li>
								<label><?php _e( 'Destination URL:', APP_TD ); ?></label>
								<input type="url" class="text required" name="clpr_coupon_aff_url" value="<?php echo esc_url( $listing->clpr_coupon_aff_url ); ?>" />
							</li>

							<li>
								<label><?php _e( 'Expiration Date:', APP_TD ); ?> </label>
								<input type="text" class="text datepicker" name="clpr_expire_date" value="<?php echo esc_attr( $listing->clpr_expire_date ); ?>" />
							</li>

							<li>
								<label><?php _e( 'Tags:', APP_TD ); ?> </label>
								<input type="text" class="text" name="<?php echo APP_TAX_TAG; ?>" value="<?php echo clpr_get_listing_tags_to_edit( $listing->ID ); ?>" />
								<p class="tip"><?php _e( 'Separate tags with commas', APP_TD ); ?></p>
							</li>

							<li class="description">
								<label for="post_content"><?php _e( 'Full Description:', APP_TD ); ?> </label>
								<?php if ( $clpr_options->allow_html && ! wp_is_mobile() ) { ?>
									<?php wp_editor( $listing->post_content, 'post_content', clpr_get_editor_settings() ); ?>
								<?php } else { ?>
									<textarea class="required" id="post_content" cols="30" rows="5" name="post_content"><?php echo esc_textarea( $listing->post_content ); ?></textarea>
								<?php } ?>
							</li>

							<li>
								<?php
									// include the spam checker if enabled
									appthemes_recaptcha();
								?>
							</li>

							<?php
								$button_text = __( 'Share It!', APP_TD );
								if ( clpr_payments_is_enabled() ) {
									$button_text = __( 'Continue', APP_TD );
									do_action( 'appthemes_purchase_fields' );
								}
							?>

							<li>
								<button type="submit" class="btn coupon" id="submitted" name="submitted" value="submitted"><?php echo esc_html( $button_text ); ?></button>
							</li>

						</ol>

					</fieldset>

					<!-- autofocus the field -->
					<script type="text/javascript">try{document.getElementById('post_title').focus();}catch(e){}</script>

				</form>

			</div> <!-- #post-box -->

		</div>

	</div>

</div>

<?php get_sidebar( 'submit' ); ?>
