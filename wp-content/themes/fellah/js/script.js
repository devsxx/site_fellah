// jQuery(document).ready(function(){
 
// 	jQuery("#menu_burger").click(function(){
// 		jQuery("#shadow").addClass("background");
// 		jQuery("#side-menu").addClass("opn");
// 	});

// 	jQuery("#side-menu .close").click(function(){
// 		jQuery("#shadow").removeClass("background");
// 		jQuery("#side-menu").removeClass("opn");
// 	});

// 	jQuery("#shadow").click(function(){
// 		jQuery("#shadow").removeClass("background");
// 		jQuery("#side-menu").removeClass("opn");
// 	});

// 	jQuery("#lang > a").click(function(event){
// 		event.preventDefault()
// 		jQuery("#lang ul").toggleClass("show-lang");
// 	});



// 	jQuery('.checkbox_pics input:checkbox').change(function(){
// 		if(jQuery(this).is(':checked')) 
// 			 jQuery(this).parent().addClass('checked'); 
// 	  else 
// 			jQuery(this).parent().removeClass('checked')
// 	});
//});

jQuery(document).ready(function($) {
	
	$('#showMore').click(function(){
		$(this).toggleClass('open');
		$('.suite').slideToggle();
	});

	$(document).on( 'scroll', function(){
		if ($(window).scrollTop() > 100) {
			 $('.GoToHeader').addClass('show');
		} else {
			 $('.GoToHeader').removeClass('show');
		}
  });

	// if (window.matchMedia("(min-width: 992px)").matches) {  
		$a = $( "#site-navigation .show-sub-menu > a" ); 
		$a.click(function(evt){
			evt.preventDefault(); 
			$ul = $(this).next('ul');  
			$ul.toggleClass('showAll'); 
			$( ".showAll" ).append("<div class='close'><i class='fas fa-times'></i></div>");
		}); 
		
		$( ".showAll .close" ).live('click',function( ){ 
			$( "#site-navigation .show-sub-menu > a" ).next('ul').removeClass('showAll'); 
		});  

	// }

   $(document).on( 'scroll', function(){
		if (window.matchMedia("(min-width: 992px)").matches) { 

			if ($(window).scrollTop() > 100) {
				$('#masthead').addClass('fixed');
				$('#header_fix').addClass('fixed'); 
			} else { 
				$('#masthead').removeClass('fixed');
				$('#header_fix').removeClass('fixed'); 
			}

			if ($(window).scrollTop() > 50) { 
				$('.main-navigation .sub-menu').removeClass('showAll');
			} else {  
				// $('.main-navigation .sub-menu').addClass('showAll');
			}

		}
	});
 
	 
	$('.GoToHeader').click(function(){
		$('html').animate({scrollTop:0}, 'slow');
		return false;
	}); 

	$('#annoces_slider').owlCarousel({
		loop:true,
		margin: 30,
		dots: false,
		autoWidth: true,
		nav:true,	 
		navText: ['<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/fellah/img/icons/arrow-right.png">'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			} ,
			1000:{
				items:1
			} 
		}
	});

	$('#top_annoces_slider').owlCarousel({
		loop:true,
		margin: 30,
		dots: false,
		autoWidth: true,
		nav:true,	
		navText: ['<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/fellah/img/icons/arrow-right.png">'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			} ,
			1000:{
				items:1
			} 
		}
	});

	$('#activites_slide').owlCarousel({
		loop:true,
		items:1,
		margin:0,
		dots: true,
		autoplay: true,
		loop: true,
		dots: false,
		nav:true,	 
		navText: ['<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/prev.png">','<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/next.png">'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	});

	$('#stories_slide').owlCarousel({
		loop:true,
		margin:0,
		dots: false,
		nav:true,	 
		navText: ['<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/prev.png">','<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/next.png">'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	});

	$('#actualites_slider').owlCarousel({
		loop:true,
		margin:0,
		dots: false,
		nav:true,	 
		navText: ['<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/prev_white.png">','<img src="http://cloudces.myds.me/oe/fellah/wp-content/themes/tmz/images/next_white.png">'],
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1024:{
				items:2
			}
		}
	});

	if (window.matchMedia("(max-width: 1200px)").matches) {

		$("#site-navigation #primary-menu .menu-item-has-children").each(function(evt){
			$a = $( this ).children("a");  
			$a.click(function(evt){
				evt.preventDefault(); 
			});

		});

	}

	$('.checkbox_2 input:checkbox').change(function(){
		if($(this).is(':checked')) 
				$(this).parent().addClass('checked'); 
		else 
			$(this).parent().removeClass('checked')
	});

	$('.checkbox_pics input:checkbox').change(function(){
		if($(this).is(':checked')) 
			$(this).parent().addClass('checked'); 
		else 
			$(this).parent().removeClass('checked')
	});

   // Perform AJAX login on form submit
   $('#connect').on('click', function(e){
		e.preventDefault();
		//alert($('#username').val()+" "+$('#password').val() );
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
					'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
					'username': $('#username').val(), 
					'password': $('#password').val() 
				},
				beforeSend: function() {
					jQuery("#ajaxloader").show();
					jQuery("#ajaxShadow").show();
				},
			//'security': $('form#login #security').val() },
            success: function(data){  
					if(data.etat){
						$(".adverts-field-name-connect .register_form").css("display", "none"); 
						$(".advert_success").css("display", "block").delay(3000).slideUp(100);
					}else{
						$(".advert_danger").css("display", "block").delay(3000).slideUp(100);
					}
					jQuery("#ajaxloader").hide();
					jQuery("#ajaxShadow").hide();
            }
        });
	});
	
	$("#creation_compte").on('click', function(e){
		e.preventDefault();
		var prenom = $("#prenom").val();
		var email = $("#email").val();
		var nom = $("#nom").val();
		// var telephone = $("#telephone").val();
		var mot_passe = $("#mot_passe").val();
		var confirm_mot_passe = $("#confirm_mot_passe").val();

		var submit = true;

		if(prenom == "" && nom == ""){
			submit = false;
		}

		if( mot_passe == "" || mot_passe == "" || confirm_mot_passe == "" )
			submit = false;

		if(confirm_mot_passe != mot_passe){
			submit = false;
		}

		if(submit){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_login_object.ajaxurl,
				data: { 
					'action': 'ajaxsignup',
					'prenom' : prenom,
					'nom' : nom,
					// 'telephone' : telephone,
					'email' : email,
					'mot_passe' : mot_passe,
					'confirm_mot_passe' : confirm_mot_passe,
				},
				beforeSend: function() {
					jQuery("#ajaxloader").show();
					jQuery("#ajaxShadow").show();
				},
				success: function(data){ 
					if(data.etat){
						$(".adverts-field-name-connect .register_form").css("display", "none"); 
						$(".advert_success").css("display", "block").delay(3000).slideUp(100);
					}else{
						$(".advert_danger").css("display", "block").delay(3000).slideUp(100);
					} 
					jQuery("#ajaxloader").hide();
					jQuery("#ajaxShadow").hide();
				}
			});
		}
	});


	$('.advert_success').click(function () {
		$(this).slideUp();
  	});

	$('.advert_danger').click(function () {
		$(this).slideUp();
	});

	$('.adverts-field-prev-next-2').addClass("hide_section"); 
	$('.adverts-field-prev-next-3').addClass("hide_section");
 
	$('.adverts-field-name-post_title').addClass("hide_section");
	$('.adverts-field-name-adverts_phone ').addClass("hide_section");
	$('.adverts-field-name-adverts_email ').addClass("hide_section");
	$('.adverts-field-name-post_content').addClass("hide_section");
	$('.adverts-field-name-adverts_price').addClass("hide_section");
	$('.adverts-field-name-gallery').addClass("hide_section");
	$('.adverts-field-name-localisation').addClass("hide_section"); 

	$('.adverts-field-name-connect').addClass("hide_section");
	$('.adverts-field-name-submit').addClass("hide_section");

	$('#prev_step_1').click(function(event){
		event.preventDefault();
		
		$('.adverts-field-prev-next-1').removeClass("hide_section"); 
		$('.adverts-field-name-type_annonce').removeClass("hide_section");
		$('.adverts-field-name-advert_category').removeClass("hide_section");
		
		$('.adverts-field-prev-next-2').addClass("hide_section");
		$('.adverts-field-name-post_title').addClass("hide_section");
		$('.adverts-field-name-adverts_phone ').addClass("hide_section");
		$('.adverts-field-name-adverts_email ').addClass("hide_section");
		$('.adverts-field-name-post_content').addClass("hide_section");
		$('.adverts-field-name-adverts_price').addClass("hide_section");
		$('.adverts-field-name-gallery').addClass("hide_section");
		$('.adverts-field-name-localisation').addClass("hide_section"); 
	});

	$('#next_step_2').click(function(event){
		event.preventDefault();
		$('.adverts-field-prev-next-1').addClass("hide_section");
		$('.adverts-field-name-type_annonce').addClass("hide_section");
		$('.adverts-field-name-advert_category').addClass("hide_section");
		
		$('.adverts-field-prev-next-2').removeClass("hide_section"); 
		$('.adverts-field-name-post_title').removeClass("hide_section");
		$('.adverts-field-name-adverts_phone ').removeClass("hide_section");
		$('.adverts-field-name-adverts_email ').removeClass("hide_section");
		$('.adverts-field-name-post_content').removeClass("hide_section");
		$('.adverts-field-name-adverts_price').removeClass("hide_section");
		$('.adverts-field-name-gallery').removeClass("hide_section");
		$('.adverts-field-name-localisation').removeClass("hide_section"); 
	});

	$('#prev_step_2').click(function(event){
		event.preventDefault();
		$('.adverts-field-prev-next-3').addClass("hide_section");
		$('.adverts-field-name-connect').addClass("hide_section");
		$('.adverts-field-name-submit').addClass("hide_section");
		
		$('.adverts-field-prev-next-2').removeClass("hide_section"); 
		$('.adverts-field-name-post_title').removeClass("hide_section");
		$('.adverts-field-name-adverts_phone ').removeClass("hide_section");
		$('.adverts-field-name-adverts_email ').removeClass("hide_section");
		$('.adverts-field-name-post_content').removeClass("hide_section");
		$('.adverts-field-name-adverts_price').removeClass("hide_section");
		$('.adverts-field-name-gallery').removeClass("hide_section");
		$('.adverts-field-name-localisation').removeClass("hide_section"); 
	});

	$('#next_step_3').click(function(event){
		event.preventDefault(); 
		
		$('.adverts-field-prev-next-2').addClass("hide_section"); 
		$('.adverts-field-name-post_title').addClass("hide_section");
		$('.adverts-field-name-adverts_phone ').addClass("hide_section");
		$('.adverts-field-name-adverts_email ').addClass("hide_section");
		$('.adverts-field-name-post_content').addClass("hide_section");
		$('.adverts-field-name-adverts_price').addClass("hide_section");
		$('.adverts-field-name-gallery').addClass("hide_section");
		$('.adverts-field-name-localisation').addClass("hide_section"); 

		$('.adverts-field-prev-next-3').removeClass("hide_section");
		$('.adverts-field-name-connect').removeClass("hide_section");
		$('.adverts-field-name-submit').removeClass("hide_section");
	});
	
	$(".adverts-field-customadvertscategory input[type='checkbox']").click(function(){
		var checkbox = $(this);
		var allVals = [];

		$("input[name='advert_category[]']:checked").each( function () {
			allVals.push($(this).val());
		});
		
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: ajax_login_object.ajaxurl,
			data: { 
				'action': 'ajaxsouscat',
				'ids' : allVals,
			},
			beforeSend: function() {
				jQuery("#ajaxloader").show();
				jQuery("#ajaxShadow").show();
			},
			success: function(response){
				if($(".ajaxed").length > 0){
					$(".ajaxed").remove();
				}
				checkbox.closest(".adverts-field-customadvertscategory")
				.append( response );
				jQuery("#ajaxloader").hide();
				jQuery("#ajaxShadow").hide();
			}
		});
		

	});

	$('.adverts-field-name-gallery').find('.row').append("<div class='col-md-6'><div class='gallerymessage'>" + ajax_login_object.GALLERYMESSAGE + "</div></div>");



	$('.slide.current').click(function () {
		$("#swipebox-close").trigger();
	  });
	  
	  $('.slide.current').click(function () {
		alert('erere');
	  });




	$( "#slider-range-LCD" ).slider({
		range: true,
		min: 10,
		max: 100000,
		values: [ 10, 100000 ],
		slide: function( event, ui ) {
			$( "#input-amount-LCD" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
			$( "#amount-LCD" ).html( "<strong>&nbsp;&nbsp; Price</strong> " + number_format(ui.values[ 0 ], 0, ',', ' ') + " DH - " + number_format(ui.values[ 1 ], 0, ',', ' ') + " DH &nbsp;&nbsp;" );
		}
	});
	$( "#input-amount-LCD" ).val( $( "#slider-range-LCD" ).slider( "values", 0 ) + "-" + $( "#slider-range-LCD" ).slider( "values", 1 ) );
	$( "#amount-LCD" ).html( "<strong>&nbsp;&nbsp; Price</strong> " + number_format($( "#slider-range-LCD" ).slider( "values", 0 ), 0, ',', ' ')  + " DH - " + number_format($( "#slider-range-LCD" ).slider( "values", 1 ), 0, ',', ' ') + " DH &nbsp;&nbsp;"  );



});



function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/number_format/
	// original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// improved by: davook
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Brett Zamir (http://brett-zamir.me)
	// improved by: Theriault (https://github.com/Theriault)
	// improved by: Kevin van Zonneveld (http://kvz.io)
	// bugfixed by: Michael White (http://getsprink.com)
	// bugfixed by: Benjamin Lupton
	// bugfixed by: Allan Jensen (http://www.winternet.no)
	// bugfixed by: Howard Yeend
	// bugfixed by: Diogo Resende
	// bugfixed by: Rival
	// bugfixed by: Brett Zamir (http://brett-zamir.me)
	//  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	//  revised by: Luke Smith (http://lucassmith.name)
	//    input by: Kheang Hok Chin (http://www.distantia.ca/)
	//    input by: Jay Klehr
	//    input by: Amir Habibi (http://www.residence-mixte.com/)
	//    input by: Amirouche
	//   example 1: number_format(1234.56)
	//   returns 1: '1,235'
	//   example 2: number_format(1234.56, 2, ',', ' ')
	//   returns 2: '1 234,56'
	//   example 3: number_format(1234.5678, 2, '.', '')
	//   returns 3: '1234.57'
	//   example 4: number_format(67, 2, ',', '.')
	//   returns 4: '67,00'
	//   example 5: number_format(1000)
	//   returns 5: '1,000'
	//   example 6: number_format(67.311, 2)
	//   returns 6: '67.31'
	//   example 7: number_format(1000.55, 1)
	//   returns 7: '1,000.6'
	//   example 8: number_format(67000, 5, ',', '.')
	//   returns 8: '67.000,00000'
	//   example 9: number_format(0.9, 0)
	//   returns 9: '1'
	//  example 10: number_format('1.20', 2)
	//  returns 10: '1.20'
	//  example 11: number_format('1.20', 4)
	//  returns 11: '1.2000'
	//  example 12: number_format('1.2000', 3)
	//  returns 12: '1.200'
	//  example 13: number_format('1 000,50', 2, '.', ' ')
	//  returns 13: '100 050.00'
	//  example 14: number_format(1e-8, 8, '.', '')
	//  returns 14: '0.00000001'
 
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	var n = !isFinite(+number) ? 0 : +number
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''
 
	var toFixedFix = function (n, prec) {
	  var k = Math.pow(10, prec)
	  return '' + (Math.round(n * k) / k)
	  .toFixed(prec)
	}
 
	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
	  s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
	  s[1] = s[1] || ''
	  s[1] += new Array(prec - s[1].length + 1).join('0')
	}
 
	return s.join(dec)
 }