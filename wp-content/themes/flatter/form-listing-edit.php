<?php
/**
 * Listing Edit Details Template.
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

				<h1><?php _e( 'Edit Your Coupon', APP_TD ); ?></h1>

				<div class="content-bar">
					<span><?php _e( 'Edit the fields below and click save to update your coupon. Your changes will be updated instantly on the site.', APP_TD ); ?></span>
				</div>

				<?php do_action( 'appthemes_notices' ); ?>

				<form id="couponForm" method="post" class="post-form" enctype="multipart/form-data" action="<?php echo esc_url( appthemes_get_step_url() ); ?>">

					<input type="hidden" name="action" value="<?php echo esc_attr( $action ); ?>">
					<?php wp_nonce_field( $action ); ?>

					<fieldset>

						<ol>
							<li>
								<label><?php _e( 'Store Name:', APP_TD ); ?></label>
								<p id="store-name"><?php echo clpr_get_coupon_store_name( $listing->ID ); ?></p>
							</li>

							<li>
								<label><?php _e( 'Coupon Title:', APP_TD ); ?> </label>
								<input type="text" class="text required" id="post_title" name="post_title" value="<?php echo esc_attr( $listing->post_title ); ?>" />
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
								<input type="text" class="text datepicker" name="clpr_expire_date" value="<?php echo esc_attr( $listing->clpr_expire_date ); ?>" <?php disabled( $clpr_options->prune_coupons ); ?> />
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
								<button type="submit" class="btn coupon" id="submitted" name="submitted" value="submitted"><?php echo esc_html_e( 'Update Coupon &raquo;', APP_TD ); ?></button>
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

<?php get_sidebar( 'user' ); ?>
