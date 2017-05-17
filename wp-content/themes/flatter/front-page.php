<?php
// Template Name: Coupons Home Template

?>
<div id="content<?php echo fl_get_option( 'fl_homepage_full_width' ) ? '-fullwidth' : ''; ?>">

    <div class="content-box">

        <div class="box-c">

            <div class="box-holder<?php echo fl_get_option( 'fl_homepage_grid_layout' ) ? ' grid' : ''; ?>">
			
				<?php if( fl_get_option( 'fl_homepage_tab_layout' ) ) {
					get_template_part( 'home', 'tabbed' ); 	
				} else {
					get_template_part( 'home', 'default' ); 
				} ?>

            </div> <!-- #box-holder -->

        </div> <!-- #box-c -->

    </div> <!-- #content-box -->

</div><!-- #container -->

<?php if( !fl_get_option( 'fl_homepage_full_width' ) ) {
	get_sidebar( 'home' ); 
} ?>
<?php wp_reset_query(); ?>
