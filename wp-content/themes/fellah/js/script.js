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

// 	jQuery("#side-menu ul li").each(function() {

// 		$li = jQuery( this );
// 		$ulNiv1 = $li.children("ul");

// 		if ($ulNiv1.length) {
// 			$a = $li.children('a');
// 			$a.addClass('bullet');


// 			$a.click(function(evt){
// 				evt.preventDefault();

// 				$currentUl = jQuery(this).next('ul');
// 				jQuery("#side-menu ul li ul").not($currentUl).removeClass('showAll');
// 				jQuery("#side-menu ul li a").not(jQuery(this)).removeClass('up');

// 				$currentUl.toggleClass('showAll');
// 				jQuery(this).toggleClass('up');
// 			});

// 		}else 
// 		jQuery( this ).children("ul").removeClass('showAll')
// 	});

// 	jQuery('.checkbox_2 input:checkbox').change(function(){
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

   $(document).on( 'scroll', function(){
  		if (window.matchMedia("(min-width: 992px)").matches) { 
			if ($(window).scrollTop() > 100) {
				$('#masthead').addClass('fixed');
				$('#header_fix').addClass('fixed');
			} else { 
					$('#masthead').removeClass('fixed');
					$('#header_fix').removeClass('fixed');
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

});

