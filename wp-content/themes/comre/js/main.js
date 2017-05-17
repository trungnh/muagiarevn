/*-----------------------------------------------------------------------------------*/
/* 		Mian Js Start 
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function($) {
	"use strict"
	/*-----------------------------------------------------------------------------------*/
	/*    STICKY NAVIGATION
	
	/*$(".sticky").sticky({topSpacing:0});*/
	
	$('.get_coupon_code').on('click',function(e){
		var link = $(this).data('href');
		if( link ) window.open(link, '_blank');
		
	});	
	
	$('#product_sort_by_category').on('change', 'select', function(e) {
		$('#product_sort_by_category').submit();
	});
	
	$('.right-bar-side.social_icons > li[data-color]').hover(function(e){
		$(this).css('background-color', $(this).data('color') );
	},
	function(e){
		$(this).css('background-color', '#fff' );
	});
	
	$('footer .social_icons > li[data-color]').hover(function(e){
		$(this).css('background-color', $(this).data('color') );
	},
	function(e){
		$(this).css('background-color', '#333333' );
	});
	
	try {
		/*-----------------------------------------------------------------------------------*/
		/*  ISOTOPE PORTFOLIO
		/*-----------------------------------------------------------------------------------*/
		var $container = $('.portfolio-wrapper .items');
		   $container.imagesLoaded(function () {
		   $container.isotope({
		   itemSelector: '.item',
		   layoutMode: 'fitRows'
		  });
		});
		$('.filter li a').click(function () {
		   $('.filter li a').removeClass('active');
		   $(this).addClass('active');
		   var selector = $(this).attr('data-filter');
		   $container.isotope({
		   filter: selector
		   });
		   return false;
		});
	} catch( e ) {
		console.log( 'isotope error' );
	}

	/*-----------------------------------------------------------------------------------*/
	/* 	MENU
	/*-----------------------------------------------------------------------------------*/
	$().ownmenu();


	/*-----------------------------------------------------------------------------------*/
	/* 	FLEX SLIDER
	/*-----------------------------------------------------------------------------------*/
	if( $('.flexslider').length ) {
		$('.flexslider').flexslider({
			animation: "fade",
			slideshow: true,                //Boolean: Animate slider automatically
			slideshowSpeed: 6000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
			animationSpeed: 500,            //Integer: Set the speed of animations, in milliseconds
			autoPlay : true
		});
	}

	/*-----------------------------------------------------------------------------------*/
	/* 	WOW ANIMATION
	/*-----------------------------------------------------------------------------------*/
	var wow = new WOW({
		boxClass:     'wow',      // animated element css class (default is wow)
		animateClass: 'animated', // animation css class (default is animated)
		offset:       10,          // distance to the element when triggering the animation (default is 0)
		mobile:       false,       // trigger animations on mobile devices (default is true)
		live:         true,       // act on asynchronously loaded content (default is true)
		callback:     function(box) {
	}});
	wow.init();

	/*-----------------------------------------------------------------------------------*/
	/*    Parallax
	/*-----------------------------------------------------------------------------------*/
	try {
		jQuery.stellar({
			horizontalScrolling: false,
			scrollProperty: 'scroll',
			positionProperty: 'position'
		});
	} catch( e ) {
		console.log( 'stellar' );
	}


/*-----------------------------------------------------------------------------------*/
/*    BANNER SLIDER
/*-----------------------------------------------------------------------------------*/
if( $(".bnr-itms").length ) {
	$(".bnr-itms").owlCarousel({ 
		autoPlay: 5000, //Set AutoPlay to 6 seconds 
		items : 1,
		singleItem	: true,
		navigation : true, // Show next and prev buttons
		pagination : false,
		navigationText: ["<i class='fa fa-angle-up'></i>","<i class='fa fa-angle-down'></i>"]
	});
}

	/*-----------------------------------------------------------------------------------*/
	/*    Feature Slider
	/*-----------------------------------------------------------------------------------*/
	if( $('.today-top').length ) {
		$('.today-top').owlCarousel({
			loop:true,
			autoPlay: 6000, //Set AutoPlay to 6 seconds 
			items : 4,
			margin:30,
			navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:2,
					nav:false
				},
				1000:{
					items:4,
					nav:true,
					loop:false
				}}
			});
	}

	
	/*-----------------------------------------------------------------------------------*/
	/*    Feature Slider
	/*-----------------------------------------------------------------------------------*/
	if( $(".fea-cate").length ) {
			$(".fea-cate").owlCarousel({ 
				autoPlay: 6000, //Set AutoPlay to 6 seconds 
				items : 4,
				margin:30,
				responsiveClass:true,
				navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				//responsiveClass:true,
				responsive:{
					0:{
						items:1,
						nav:true
					},
					600:{
						items:2,
						nav:false
					},
					1000:{
						items:4,
						nav:true,
						loop:false
					}
			}});
	}
	
	
	if($('.stores .filter-list').length) {
		$('.stores .filter-list').mixitup({
			efffects: ['fade', 'blur']
		});
	}
	
	$('select#store').on('change', function(e) {
         //$(this).parents('form').submit();
		 var cur_val = $(this).val();
		 console.log(cur_val);
		 // Filter the mixed elements
		$('.stores .filter-list').mixitup('filter', cur_val);
		
		//$container.mixitup('filter', 'custom-price-filter');
		 
	});
	
	$('#_store_show_all').on('click', function(e){
		$('.stores .filter-list').mixitup('filter', 'mix');
	});

});
/*-----------------------------------------------------------------------------------*/
/*    CONTACT FORM
/*-----------------------------------------------------------------------------------*/
function checkmail(input){
  var pattern1=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  	if(pattern1.test(input)){ return true; }else{ return false; }}     
    function proceed(){
    	var name = document.getElementById("name");
		var email = document.getElementById("email");
		var company = document.getElementById("company");
		var web = document.getElementById("website");
		var msg = document.getElementById("message");
		var errors = "";
		  if(name.value == ""){ 
		  	name.className = 'error';
		  return false;}    
		  else if(email.value == ""){
		  email.className = 'error';
		  return false;}
		    else if(checkmail(email.value)==false){
		        alert('Please provide a valid email address.');
		        return false;}
		    else if(company.value == ""){
		        company.className = 'error';
		        return false;}
		   else if(web.value == ""){
		        web.className = 'error';
		        return false;}
		   else if(msg.value == ""){
		        msg.className = 'error';
		        return false;}
		   else 
		  {
    	$.ajax({
			type: "POST",
			url: "submit.php",
			data: $("#contact_form").serialize(),
			success: function(msg){
			//alert(msg);
            if(msg){
                $('#contact_form').fadeOut(1000);
                $('#contact_message').fadeIn(1000);
                document.getElementById("contact_message");
            return true;
        }}
    });
}};



jQuery( function($) {

	// Quantity buttons
    $( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );
    	
    	$( document ).on( 'click', '.plus, .minus', function() {
        // Get values
        var $qty        = $( this ).closest( '.quantity' ).find( '.qty' ),
            currentVal  = parseFloat( $qty.val() ),
            max         = parseFloat( $qty.attr( 'max' ) ),
            min         = parseFloat( $qty.attr( 'min' ) ),
            step        = $qty.attr( 'step' );
        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;
        // Change the value
        if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }
        } else {
            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }
        }
        // Trigger change event
        $qty.trigger( 'change' );
    });
});


// JavaScript Document

(function($){
	"use strict";
	var wow_themes = {			
			count: 0,
			tweets: function( options, selector ){
				
				options.action = '_sh_ajax_callback';
				options.subaction = 'tweets';

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data:options,
					//dataType:"json",
					success: function(res){
						
						$(selector).html( res );	
					}
				});
				
			},
			
			wishlist: function(options, selector)
			{
				options.action = '_sh_ajax_callback';
				
				if( $(selector).data('_sh_add_to_wishlist') === true ){
					wow_themes.msg( 'You have already done this job', 'error' );
					return;
				}
				
				$(selector).data('_sh_add_to_wishlist', true );

				wow_themes.loading(true);
				
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data:options,
					dataType:"json",
					success: function(res){

						try{
							var newjason = res;

							if( newjason.code === 'fail'){
								$(selector).data('_sh_add_to_wishlist', false );
								wow_themes.loading(false);
								wow_themes.msg( newjason.msg, 'error' );
							}else if( newjason.code === 'exists'){
								$(selector).data('_sh_add_to_wishlist', true );
								wow_themes.loading(false);
								wow_themes.msg( newjason.msg, 'error' );
							}else if( newjason.code === 'success' ){
								wow_themes.loading(false);
								$(selector).data('_sh_add_to_wishlist', true );
								wow_themes.msg( newjason.msg, 'success' );
							}else if( newjason.code === 'del' ){
								wow_themes.loading(false);
								$(selector).data('_sh_add_to_wishlist', true );
								$(selector).parents('tbody').remove();
								wow_themes.msg( newjason.msg, 'success' );
							}
							
							
						}
						catch(e){
							wow_themes.loading(false);
							$(selector).data('_sh_add_to_wishlist', false );
							wow_themes.msg( 'There was an error while adding product to whishlist '+e.message, 'error' );
							
						}
					}
				});
			},
			likeit: function(options, selector)
			{
				options.action = '_sh_ajax_callback';
				
				if( $(selector).data('_sh_like_it') === true ){
					wow_themes.msg( 'You have already done this job', 'error' );
					return;
				}
				
				$(selector).data('_sh_like_it', true );

				wow_themes.loading(true);
				
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data:options,
					dataType:"json",
					success: function(res){

						try{
							var newjason = res;

							if( newjason.code === 'fail'){
								$(selector).data('_sh_like_it', false );
								wow_themes.loading(false);
								wow_themes.msg( newjason.msg, 'error' );
							}else if( newjason.code === 'success' ){
								//$('a[data-id="'+options.data_id+'"]').html( '<i class="fa fa-heart-o"></i> '+newjason.value );
								wow_themes.loading(false);
								$(selector).data('_sh_like_it', true );
								wow_themes.msg( newjason.msg, 'success' );
							}
							
						}
						catch(e){
							wow_themes.loading(false);
							$(selector).data('_sh_like_it', false );
							wow_themes.msg( 'There was an error with request '+e.message, 'error' );
							
						}
					}
				});
			},
			loading: function( show ){
				if( $('.ajax-loading' ).length === 0 ) {
					$('body').append('<div class="ajax-loading" style="display:none;"></div>');
				}
				
				if( show === true ){
					$('.ajax-loading').show('slow');
				}
				if( show === false ){
					$('.ajax-loading').hide('slow');
				}
			},
			
			msg: function( msg, type ){
				if( $('#pop' ).length === 0 ) {
					$('body').append('<div style="display: none;" id="pop"><div class="pop"><div class="alert"><p></p></div></div></div>');
				}
				if( type === 'error' ) {
					type = 'danger';
				}
				var alert_type = 'alert-' + type;
				
				$('#pop > .pop p').html( msg );
				$('#pop > .pop > .alert').addClass(alert_type);
				
				$('#pop').slideDown('slow').delay(5000).fadeOut('slow', function(){
					$('#pop .pop .alert').removeClass(alert_type);
				});
				
				
			},
			
		};
	
	$.fn.tweets = function( options ){
		
		var settings = {
				screen_name	:	'wordpress',
				count		:	3,
				template	:	'blockquote'
			};
			
			options = $.extend( settings, options );
			
			wow_themes.tweets( options, this );
			
			
	};
	
	$(document).ready(function() {
        
		$('.add_to_wishlist, a[rel="product_del_wishlist"]').click(function(e) {
			e.preventDefault();
			
			if( $(this).attr('rel') === 'product_del_wishlist' ){
				if( confirm( 'Are you sure! you want to delete it' ) ){
					var opt = {subaction:'wishlist_del', data_id:$(this).attr('data-id')};
					wow_themes.wishlist( opt, this );
				}
			}else{
				var opt = {subaction:'wishlist', data_id:$(this).attr('data-id')};
				wow_themes.wishlist( opt, this );
			}
			
		});/**wishlist end*/
		
		$('.jolly_like_it').click(function(e) {
			e.preventDefault();
			
				var opt = {subaction:'likeit', data_id:$(this).attr('data-id')};
				wow_themes.wishlist( opt, this );
			
			
		});/**wishlist end*/
		
		$('span.cart_quentity_plus, span.cart_quentity_minus').click(function(e) {
            e.preventDefault();
			
			var field = $('input[data-rel="quantity"]', $(this).parents('.shop_meta'));//$('input[name="quantity"]');
			console.log(field);
			var value = parseInt(field.val());
			console.log(value);
			var newval = 0;
			if( $(this).hasClass('cart_quentity_plus') ) {
				newval = value + 1;
				field.val(newval);
			}
			else if( $(this).hasClass('cart_quentity_minus') ) {
				if( value > 1 ) {
					newval = value - 1;
					field.val(newval);
				}
			}
			
			
        });
		
		/*$('body').bind('added_to_cart', function( frag, hash ) {
			//console.log( hash );
			$('body').append('<div id="sh_added_to_cart"></div>');
			$('div#sh_added_to_cart').html('Product Added');//.prettyPhoto();
			//$.prettyPhoto.open('Title','Description');
			//jQuery("div#sh_added_to_cart").prettyPhoto().open();
		});*/
		
		$('#contact_form').submit(function(){

			var action = $(this).attr('action');
	
			$("#message").slideUp(750,function() {
			$('#message').hide();
	
			$('button#submit').attr('disabled','disabled');
			$('img.loader').css('visibility', 'visible');
	
			$.post(action, {
				contact_name: $('#contact_name').val(),
				contact_email: $('#contact_email').val(),
				contact_website: $('#contact_website').val(),
				contact_company: $('#contact_company').val(),
				contact_message: $('#contact_message').val(),
				verify: $('#verify').val()
			},
				function(data){
					document.getElementById('message').innerHTML = data;
					$('#message').slideDown('slow');
					$('#contact_form img.loader').css('visibility', 'hidden' );
					
					$('#submit').removeAttr('disabled');
					if(data.match('success') != null) $('#contactform').slideUp('slow');
	
				}
			);

		});

		return false;

	});

		$('.disqus').click(function(e){
			var post_id = $(this).data('id');
			$('#myModaltest .modal-body').html('Getting Disqus...');
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {action:'_sh_ajax_callback', subaction:'_disqus', uniq_id:post_id},
				success: function(data){
					$('#myModaltest .modal-body').html(data);
				}
			});
		})
		
    });/** document.ready end */
	
	
	
	
		
})(jQuery);























