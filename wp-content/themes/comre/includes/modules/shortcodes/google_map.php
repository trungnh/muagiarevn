<?php ob_start(); ?>
<section class="contact"> 
    
    <!--======= MAP =========-->
    <div id="map"></div>
</section>

<!-- MAP --> 
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/mapmarker.js"></script> 
<script type="text/javascript">
	// Use below link if you want to get latitude & longitude
	// http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude.php	
	jQuery(document).ready(function($){
	
		//set up markers 
		var myMarkers = {"markers": [
				{"latitude": "-37.8176419", "longitude":"144.9554397", "icon": "images/map-locator.png", "baloon_text": '121 King St, Melbourne VIC 3000, Australia'}
			]
		};
		
		//set up map options
		$("#map").mapmarker({
			zoom	: 18,
			center	: '121 King Street Melbourne Victoria 3000 Australia',
			markers	: myMarkers
		});

	});
</script>

<?php return ob_get_clean();