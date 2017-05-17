<?php
/**
 * Admin Coupon Listings Metaboxes.
 *
 * @package Clipper\Admin\Metaboxes\Listings
 * @author  AppThemes
 * @since   Clipper 1.6
 */


add_action( 'add_meta_boxes_' . APP_POST_TYPE, 'clpr_setup_meta_box' );
add_filter( 'media_upload_tabs', 'clpr_remove_media_library_tab' );


/**
 * Adds and removes meta boxes on the coupon edit admin page.
 *
 * @return void
 */
function clpr_setup_meta_box() {

	//remove_meta_box( 'storesdiv', APP_POST_TYPE, 'side' );
	remove_meta_box( 'coupon_typediv', APP_POST_TYPE, 'side' );

	remove_meta_box( 'postimagediv', APP_POST_TYPE, 'side' );
	remove_meta_box( 'postexcerpt', APP_POST_TYPE, 'normal' );
	remove_meta_box( 'authordiv', APP_POST_TYPE, 'normal' );
	remove_meta_box( 'postcustom', APP_POST_TYPE, 'normal' );

	//custom post statuses
	//temporary hack until WP will fully support custom post statuses
	remove_meta_box( 'submitdiv', APP_POST_TYPE, 'side' );
	add_meta_box( 'submitdiv', __( 'Publish', APP_TD ), 'clpr_post_submit_meta_box', APP_POST_TYPE, 'side', 'high' );

}


/**
 * Removes media library tab to escape assignment second time the same printable coupon.
 *
 * @param array $tabs
 *
 * @return array
 */
function clpr_remove_media_library_tab( $tabs ) {
	if ( isset( $_REQUEST['post_id'] ) ) {
		$post_type = get_post_type( $_REQUEST['post_id'] );
		if ( APP_POST_TYPE == $post_type ) {
			unset( $tabs['library'] );
		}
	}

	return $tabs;
}


/**
 * Coupon Listing Info Metabox.
 * @since 1.6
 */
class CLPR_Listing_Info_Metabox extends APP_Meta_Box {

	/**
	 * Sets up metabox.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct( 'coupon-info', __( 'Coupon Info', APP_TD ), APP_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Returns an array of form fields.
	 *
	 * @return array
	 */
	public function form() {
		$form_fields = array(
			array(
				'title' => __( 'Reference ID', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_id',
				'default' => clpr_generate_id(),
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Display URL', APP_TD ),
				'type' => 'text',
				'name' => '_blank',
				'desc' => $this->get_display_url(),
				'extra' => array( 'style' => 'display: none;' ),
			),
			array(
				'title' => __( 'Views Today', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_daily_count',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Views Total', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_total_count',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Clicks', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_coupon_aff_clicks',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'CTR', APP_TD ),
				'type' => 'text',
				'name' => '_blank',
				'desc' => clpr_get_coupon_ctr( $this->get_post_id() ),
				'extra' => array( 'style' => 'display: none;' ),
			),
			array(
				'title' => __( 'Votes Up', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_votes_up',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Votes Down', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_votes_down',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Votes Percent', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_votes_percent',
				'sanitize' => 'absint',
				'default' => '100',
				'extra' => array( 'readonly' => 'readonly' ),
			),
			array(
				'title' => __( 'Votes Chart', APP_TD ),
				'type' => 'text',
				'name' => '_blank',
				'desc' => $this->get_votes_chart(),
				'extra' => array( 'style' => 'display: none;' ),
			),
			array(
				'title' => __( 'Submitted from IP', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_sys_userIP',
				'default' => appthemes_get_ip(),
				'extra' => array( 'readonly' => 'readonly' ),
			),
		);

		return $form_fields;
	}

	/**
	 * Filter data before save.
	 *
	 * @param array $post_data
	 * @param int $post_id
	 *
	 * @return array
	 */
	protected function before_save( $post_data, $post_id ) {
		$post_keys = get_post_custom_keys( $post_id );

		// do not update fields if already exist
		foreach ( $post_keys as $post_key ) {
			if ( isset( $post_data[ $post_key ] ) ) {
				unset( $post_data[ $post_key ] );
			}
		}

		return $post_data;
	}

	/**
	 * Returns coupon outgoing URL.
	 *
	 * @return string
	 */
	public function get_display_url() {

		$post = get_post( $this->get_post_id() );
		$url = clpr_get_coupon_out_cloak_url( $post );

		$output = html( 'code', $url ) . ' ';
		if ( 'auto-draft' != $post->post_status ) {
			$output .= html( 'a', array( 'href' => $url, 'target' => '_blank' ), __( 'Visit link', APP_TD ) );
		}

		return $output;
	}

	/**
	 * Returns votes chart.
	 *
	 * @return string
	 */
	public function get_votes_chart() {
		ob_start();
		clpr_votes_chart( $this->get_post_id() );
		$chart = ob_get_clean();

		if ( empty( $chart ) ) {
			$chart = __( 'No votes yet', APP_TD );
		}

		return $chart;
	}

}


/**
 * Coupon Listing Custom Forms Metabox.
 * @since 1.6
 */
class CLPR_Listing_Custom_Forms_Metabox extends APP_Meta_Box {

	/**
	 * Sets up metabox.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct( 'coupon-custom-forms', __( 'Coupon Details', APP_TD ), APP_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Enqueues admin scripts.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'jquery-ui-style' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-datepicker-lang' );
	}

	/**
	 * Returns an array of form fields.
	 *
	 * @return array
	 */
	public function form() {
		$form_fields = array(
			array(
				'title' => __( 'Coupon Type', APP_TD ),
				'type' => 'select',
				'name' => APP_TAX_TYPE,
				'values' => $this->available_types(),
				'selected' => $this->current_type(),
				'extra' => array(
					'id' => 'coupon_type_dropdown',
				),
			),
			array(
				'title' => __( 'Coupon Code', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_coupon_code',
				'default' => '',
			),
			array(
				'title' => __( 'Printable Coupon URL', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_print_url',
				'sanitize' => 'esc_url_raw',
				'default' => '',
				'desc' => $this->wrap_upload( 'clpr_print_url', '<br />' . __( 'Upload a coupon or paste an image URL directly.', APP_TD ) ),
			),
			array(
				'title' => __( 'Printable Coupon ID', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_print_imageid',
				'sanitize' => 'absint',
				'default' => '0',
				'extra' => array(
					'id' => 'clpr_print_url_id',
				),
			),
			array(
				'title' => __( 'Destination URL', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_coupon_aff_url',
				'sanitize' => 'esc_url_raw',
				'extra' => array(
					'placeholder' => 'http://',
					'class' => 'regular-text',
				),
			),
			array(
				'title' => __( 'Expiration Date', APP_TD ),
				'type' => 'text',
				'name' => 'clpr_expire_date',
				'default' => '',
				'extra' => array(
					'readonly' => 'readonly',
					'class' => 'datepicker',
				),
			),
			array(
				'title' => __( 'Featured Coupon', APP_TD ),
				'type' => 'checkbox',
				'name' => 'clpr_featured',
				'desc' => __( 'Yes', APP_TD ),
				'tip' => __( 'Should this coupon be displayed in the home page slider?', APP_TD ),
			),
		);

		return $form_fields;
	}

	/**
	 * Validates posted data.
	 *
	 * @param array $data
	 * @param int $post_id
	 *
	 * @return object
	 */
	public function validate_post_data( $data, $post_id ) {

		$errors = new WP_Error();

		// Validate coupon type.
		if ( empty( $data[ APP_TAX_TYPE ] ) ) {
			$errors->add( APP_TAX_TYPE, sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Type', APP_TD ) ) );
		} else {
			$type = get_term_by( 'slug', $data[ APP_TAX_TYPE ], APP_TAX_TYPE );
			if ( ! $type ) {
				$errors->add( APP_TAX_TYPE, sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Coupon Type', APP_TD ) ) );
			} else {
				// update coupon type tax
				wp_set_object_terms( $post_id, $data[ APP_TAX_TYPE ], APP_TAX_TYPE );
			}
		}

		// Validate coupon code.
		if ( $data[ APP_TAX_TYPE ] == 'coupon-code' && empty( $data['clpr_coupon_code'] ) ) {
			$errors->add( 'clpr_coupon_code', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Coupon Code', APP_TD ) ) );
		}

		// Validate coupon destination url.
		if ( empty( $data['clpr_coupon_aff_url'] ) ) {
			$errors->add( 'clpr_coupon_aff_url', sprintf( __( 'Error: The "%s" field is empty.', APP_TD ), __( 'Destination URL', APP_TD ) ) );
		} else if ( ! wp_http_validate_url( $data['clpr_coupon_aff_url'] ) ) {
			$errors->add( 'clpr_coupon_aff_url', sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Destination URL', APP_TD ) ) );
		}

		// Validate expiration date.
		if ( ! empty( $data['clpr_expire_date'] ) && ! clpr_is_valid_expiration_date( $data['clpr_expire_date'] ) ) {
			$errors->add( 'clpr_expire_date', sprintf( __( 'Error: The "%s" field is invalid.', APP_TD ), __( 'Expiration Date', APP_TD ) ) );
		}

		// Set new printable coupon image.
		if ( $data[ APP_TAX_TYPE ] == 'printable-coupon' && ! empty( $data['clpr_print_imageid'] ) ) {
			$attach_id = (int) $data['clpr_print_imageid'];
			$previous_attach_id = (int) get_post_meta( $post_id, 'clpr_print_imageid', true );

			if ( $previous_attach_id != $attach_id ) {
				// Remove old assigned printable coupons.
				clpr_remove_printable_coupon( $post_id );

				// Associate it to the coupon listing.
				wp_update_post( array( 'ID' => $attach_id, 'post_parent' => $post_id ) );
				wp_set_object_terms( $attach_id, 'printable-coupon', APP_TAX_IMAGE, false );
			}
		}

		return $errors;
	}

	/**
	 * Displays extra HTML before the form.
	 *
	 * @param object $post
	 *
	 * @return void
	 */
	public function before_form( $post ) {
?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($) {
				/* initialize the datepicker feature */
				$('table input.datepicker').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });

				/* hide printable coupon id field */
				jQuery('input#clpr_print_url_id').closest('tr').css({ "position": "absolute", "top": "-9999px" });

				/* show the coupon code or upload field based on coupon type selected */
				jQuery('select#coupon_type_dropdown').change(function() {
					if ( jQuery(this).val() == 'coupon-code' ) {
						jQuery('input#clpr_coupon_code').closest('tr').show();
						jQuery('input#clpr_print_url').closest('tr').hide();
					} else if ( jQuery(this).val() == 'printable-coupon' ) {
						jQuery('input#clpr_coupon_code').closest('tr').hide();
						jQuery('input#clpr_print_url').closest('tr').show();
					} else {
						jQuery('input#clpr_coupon_code').closest('tr').hide();
						jQuery('input#clpr_print_url').closest('tr').hide();
					}
				}).change();

				/* upload images button */
				jQuery('.upload_button').click(function() {
					formfield = jQuery(this).attr('rel');
					tb_show('', 'media-upload.php?type=image&amp;post_id=<?php echo $post->ID; ?>&amp;TB_iframe=true');
					return false;
				});

				var formfield;
				window.original_send_to_editor = window.send_to_editor;

				/* send the uploaded image url to the field */
				window.send_to_editor = function(html) {
					if ( formfield ) {
						html_holder = jQuery('<div></div>');
						html_holder.html( html );

						attachment_id = 0;
						a_href = html_holder.find('a:first').attr('href');
						img_src = html_holder.find('img:first').attr('src');
						img_class = html_holder.find('img:first').attr('class');

						if ( img_class && typeof img_class !== 'undefined' ) {
							matches = img_class.match(/\bwp-image-(\d+)\b/);
							if ( matches ) {
								attachment_id = parseInt( matches[1], 10 );
							}
						}

						if ( a_href && typeof a_href !== 'undefined' ) {
							attachment_url = a_href;
						} else {
							attachment_url = img_src;
						}

						jQuery('#' + formfield).val( attachment_url );
						jQuery('#' + formfield + '_id').val( attachment_id );
						jQuery('#' + formfield + '_image').html('<img src="' + attachment_url + '" />');
						tb_remove();
						formfield = null;
					} else {
						window.original_send_to_editor(html);
					}
				}

			});
			//]]>
		</script>
<?php
	}

	/**
	 * Returns an upload image buttons, and image preview.
	 *
	 * @param string $field_name
	 * @param string $desc
	 *
	 * @return string
	 */
	private function wrap_upload( $field_name, $desc ) {
		$upload_button = html( 'input', array( 'class' => 'upload_button button', 'rel' => $field_name, 'type' => 'button', 'value' => __( 'Upload Image', APP_TD ) ) );
		$clear_button = html( 'input', array( 'class' => 'delete_button button', 'rel' => $field_name, 'type' => 'button', 'value' => __( 'Clear Image', APP_TD ) ) );
		$img_url = get_post_meta( $this->get_post_id(), $field_name, true );
		$img = $img_url ? html( 'img', array( 'src' => $img_url ) ) : '';
		$preview = html( 'div', array( 'id' => $field_name . '_image', 'class' => 'upload_image_preview' ), $img );

		return $upload_button . ' ' . $clear_button . $desc . $preview;
	}

	/**
	 * Returns an array of available coupon types.
	 *
	 * @return array
	 */
	private function available_types() {
		$types = array();
		$terms = get_terms( APP_TAX_TYPE, array( 'hide_empty' => 0 ) );

		foreach ( (array) $terms as $term ) {
			$types[ $term->slug ] = $term->name;
		}

		return $types;
	}

	/**
	 * Returns current coupon type.
	 *
	 * @return string
	 */
	private function current_type() {
		$type = clpr_get_coupon_type( $this->get_post_id() );

		if ( ! $type ) {
			$type = 'coupon-code';
		}

		return $type;
	}

}


/**
 * Coupon Listing Author Metabox.
 * @since 1.6
 */
class CLPR_Listing_Author_Metabox extends APP_Meta_Box {

	/**
	 * Sets up metabox.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct( 'listingauthordiv', __( 'Author', APP_TD ), APP_POST_TYPE, 'side', 'low' );
	}

	/**
	 * Checks if metabox should be registered.
	 *
	 * @return bool
	 */
	protected function condition() {
		return current_user_can( 'edit_others_posts' );
	}

	/**
	 * Displays content.
	 *
	 * @param object $post
	 *
	 * @return void
	 */
	public function display( $post ) {
		$author_id = empty( $post->post_author ) ? get_current_user_id() : $post->post_author;
		$author = get_userdata( $author_id );
		// display current author avatar and edit link
		echo html( 'div', array( 'class' => 'avatar' ), get_avatar( $author_id, '96', '' ) );
		$edit_url = get_edit_user_link( $author_id );
		if ( $edit_url ) {
			echo html( 'p', html_link( $edit_url, sprintf( __( 'Edit: %s', APP_TD ), $author->display_name ) ) );
		}
		?>
		<label class="screen-reader-text" for="post_author_override"><?php _e( 'Author', APP_TD ); ?></label>
		<?php
		wp_dropdown_users( array(
			/* 'who' => 'authors', */
			'name' => 'post_author_override',
			'selected' => $author_id,
			'include_selected' => true,
		) );
	}

}


/**
 * Coupon Listing Moderation Metabox.
 * @since 1.4
 */
class CLPR_Listing_Publish_Moderation extends APP_Meta_Box {

	/**
	 * Sets up metabox.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct( 'listing-publish-moderation', __( 'Moderation Queue', APP_TD ), APP_POST_TYPE, 'side', 'high' );
	}

	/**
	 * Checks if metabox should be registered.
	 *
	 * @return bool
	 */
	protected function condition() {
		if ( ! isset( $_GET['post'] ) || get_post_status( $_GET['post'] ) != 'pending' ) {
			return false;
		}

		return current_user_can( 'edit_others_posts' );
	}

	/**
	 * Displays content.
	 *
	 * @param object $post
	 *
	 * @return void
	 */
	public function display( $post ) {

		echo html( 'p', array(), __( 'You must approve this coupon before it can be published.', APP_TD ) );

		echo html( 'input', array(
			'type' => 'submit',
			'class' => 'button-primary',
			'value' => __( 'Accept', APP_TD ),
			'name' => 'publish',
			'style' => 'padding-left: 30px; padding-right: 30px; margin-right: 20px; margin-left: 15px;',
		) );

		echo html( 'a', array(
			'class' => 'button',
			'style' => 'padding-left: 30px; padding-right: 30px;',
			'href' => get_delete_post_link( $post->ID ),
		), __( 'Reject', APP_TD ) );

		echo html( 'p', array(
			'class' => 'howto'
		), __( 'Rejecting a Coupon sends it to the trash.', APP_TD ) );

	}

}

