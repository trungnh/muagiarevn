<?php 

$home_tabs = fl_get_home_tabs();

if( $home_tabs ) { ?>

	<ul class="home-tab-section clearfix">

		<?php foreach( $home_tabs as $key => $tab_array ) { ?>

			<li class="<?php echo implode( ' ', $tab_array['classes'] ); ?>"><a href="#home-<?php echo $key; ?>"><?php echo $tab_array['title']; ?></a></li>

		<?php } ?>
	</ul>

	<?php foreach( $home_tabs as $key => $tab_array ) { ?>

		<div id="home-<?php echo $key; ?>" class="home-tab-content clearfix">
			<?php appthemes_load_template( array( $tab_array['template'] ), $tab_array ); ?>
		</div>

	<?php } 
	
} else {
	
	get_template_part( 'includes/home-tab', 'new-coupons' ); 
	
} ?>