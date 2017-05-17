<?php
/**
 * Theme search form template.
 *
 * @package Clipper\Templates
 * @author  AppThemes
 * @since   Clipper 1.0
 */
?>

<div class="search-box">

	<div class="holder">

		<form role="search" method="get" class="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" >

			<fieldset>

				<div class="row">

					<div class="text">
						<label class="screen-reader-text" for="s"><?php _e( 'Search for:', APP_TD ); ?></label>
						<input type="search" class="text newtag" id="s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search for coupon codes', APP_TD ); ?>" />
					</div>
					<div class="row">
						<button value="<?php esc_attr_e( 'Search', APP_TD ); ?>" title="<?php esc_attr_e( 'Search', APP_TD ); ?>" type="submit" class="btn-submit"><span><?php _e( 'Search', APP_TD ); ?></span></button>
					</div>

				</div>

			</fieldset>

		</form>

	</div>

</div>
