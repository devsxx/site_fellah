jQuery(document).ready(function(){
 
	jQuery("#menu_burger").click(function(){
		jQuery("#shadow").addClass("background");
		jQuery("#side-menu").addClass("opn");
	});

	jQuery("#side-menu .close").click(function(){
		jQuery("#shadow").removeClass("background");
		jQuery("#side-menu").removeClass("opn");
	});

	jQuery("#shadow").click(function(){
		jQuery("#shadow").removeClass("background");
		jQuery("#side-menu").removeClass("opn");
	});

	jQuery("#lang > a").click(function(event){
		event.preventDefault()
		jQuery("#lang ul").toggleClass("show-lang");
	});

	jQuery("#side-menu ul li").each(function() {

		$li = jQuery( this );
		$ulNiv1 = $li.children("ul");

		if ($ulNiv1.length) {
			$a = $li.children('a');
			$a.addClass('bullet');


			$a.click(function(evt){
				evt.preventDefault();

				$currentUl = jQuery(this).next('ul');
				jQuery("#side-menu ul li ul").not($currentUl).removeClass('showAll');
				jQuery("#side-menu ul li a").not(jQuery(this)).removeClass('up');

				$currentUl.toggleClass('showAll');
				jQuery(this).toggleClass('up');
			});

		}else 
		jQuery( this ).children("ul").removeClass('showAll')
	});


	jQuery(window).scroll(function () {

		$scrollTop = jQuery(this).scrollTop();
		if ($scrollTop >= 250) {
			jQuery('blockquote').addClass("show"); 
			jQuery('blockquote').removeClass("hide"); 
		} else {
			jQuery('blockquote').addClass("hide"); 
			jQuery('blockquote').removeClass("show"); 
		}

		if(jQuery(".Processus").length > 0){

			if(jQuery(".Processus").offset().top - $scrollTop >= 50 ){
				jQuery(".Processus .bloc-phase .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < 50 ){
				jQuery(".Processus .bloc-phase:nth-child(1) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(1) .phase .progress").css({
					"height" : "100%"
				});

				jQuery(".Processus .bloc-phase:nth-child(2) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(2) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -300 ){
				jQuery(".Processus .bloc-phase:nth-child(2) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(2) .phase .progress").css({
					"height" : "100%"
				});

				jQuery(".Processus .bloc-phase:nth-child(3) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(3) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -700 ){
				jQuery(".Processus .bloc-phase:nth-child(3) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(3) .phase .progress").css({
					"height" : "100%"
				});

				jQuery(".Processus .bloc-phase:nth-child(4) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(4) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -900 ){
				jQuery(".Processus .bloc-phase:nth-child(4) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(4) .phase .progress").css({
					"height" : "100%"
				});
				jQuery(".Processus .bloc-phase:nth-child(5) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(5) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -1300 ){
				jQuery(".Processus .bloc-phase:nth-child(5) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(5) .phase .progress").css({
					"height" : "100%"
				});
				jQuery(".Processus .bloc-phase:nth-child(6) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(6) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -1600 ){
				jQuery(".Processus .bloc-phase:nth-child(6) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(6) .phase .progress").css({
					"height" : "100%"
				});
				jQuery(".Processus .bloc-phase:nth-child(7) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(7) .phase .progress").css({
					"height" : "0"
				});
			}
			if(jQuery(".Processus").offset().top - $scrollTop < -1900 ){
				jQuery(".Processus .bloc-phase:nth-child(7) .phase").css({
					"visibility" : "visible",
					"opacity" : "1"
				});
				jQuery(".Processus .bloc-phase:nth-child(7) .phase .progress").css({
					"height" : "100%"
				});
				jQuery(".Processus .bloc-phase:nth-child(8) .phase").css({
					"visibility" : "visible",
					"opacity" : ".2"
				});
				jQuery(".Processus .bloc-phase:nth-child(8) .phase .progress").css({
					"height" : "0"
				});
			}
		}

	});

jQuery('#showMore').click(function(){
	jQuery(this).toggleClass('open');
	jQuery('.suite').slideToggle();
});


jQuery('#annoces_slider').owlCarousel({
	loop:true,
	margin: 30,
	slideBy: 3,
	dots: false,
	autoWidth: true,
	nav:true,	 
	navText: ['<img src="wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="wp-content/themes/fellah/img/icons/arrow-right.png">'],
});

jQuery('#top_annoces_slider').owlCarousel({
	loop:true,
	margin: 30,
	slideBy: 3,
	dots: false,
	autoWidth: true,
	nav:true,	 
	navText: ['<img src="wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="wp-content/themes/fellah/img/icons/arrow-right.png">'],
});

jQuery('#activites_slide').owlCarousel({
	loop:true,
	items:1,
	margin:0,
	dots: true,
	autoplay: true,
	loop: true,
	dots: false,
	nav:true,	 
	navText: ['<img src="wp-content/themes/tmz/images/prev.png">','<img src="wp-content/themes/tmz/images/next.png">'],
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

jQuery('#stories_slide').owlCarousel({
	loop:true,
	margin:0,
	dots: false,
	nav:true,	 
	navText: ['<img src="wp-content/themes/tmz/images/prev.png">','<img src="wp-content/themes/tmz/images/next.png">'],
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



// if (window.matchMedia("(max-width: 992px)").matches) {
	jQuery('#actualites_slider').owlCarousel({
		loop:true,
		margin:0,
		dots: false,
		nav:true,	 
		navText: ['<img src="wp-content/themes/tmz/images/prev_white.png">','<img src="wp-content/themes/tmz/images/next_white.png">'],
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
// }else{
// 	jQuery('#actualites_slider').owlCarousel({
// 		loop:true,
// 		margin:0,
// 		dots: false,
// 		nav:true,	 
// 		navText: ['<img src="wp-content/themes/tmz/images/prev_white.png">','<img src="wp-content/themes/tmz/images/next_white.png">'],
// 		responsive:{
// 			0:{
// 				items:2
// 			},
// 			600:{
// 				items:2
// 			},
// 			1000:{
// 				items:2
// 			}
// 		}
// 	});
// }

if (window.matchMedia("(max-width: 1200px)").matches) {

	jQuery("#site-navigation #primary-menu .menu-item-has-children").each(function(evt){
		$a = jQuery( this ).children("a");  
		$a.click(function(evt){
			evt.preventDefault(); 
		});

	});

}



jQuery(document).ready(function($) {

    // Perform AJAX login on form submit
    $('#connect').on('click', function(e){
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
			//'security': $('form#login #security').val() },
            success: function(data){
				if(data.etat){
					$(".adverts-field-name-coordonnées,.adverts-field-name-connect").css("display", "none");
				}
            }
        });
        e.preventDefault();
	});
	
	$("#creation_compte").click(function(){
		var prenom = $("#prenom").val();
		var email = $("#email").val();
		var nom = $("#nom").val();
		var telephone = $("#telephone").val();
		var mot_passe = $("#mot_passe").val();
		var confirm_mot_passe = $("#confirm_mot_passe").val();

		var submit = true;

		if(prenom == "" && nom == ""){
			submit = false;
		}

		if(telephone == "" || mot_passe == "" || mot_passe == "" || confirm_mot_passe == "" )
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
					'telephone' : telephone,
					'email' : email,
					'mot_passe' : mot_passe,
					'confirm_mot_passe' : confirm_mot_passe,
				},
				success: function(data){
				   if(data.etat){
					   $(".adverts-field-name-coordonnées,.adverts-field-name-connect").css("display", "none");
				   }
				}
			});
		}
	});


	$("input[type='checkbox']").click(function(){
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
			success: function(response){
				console.log(response);
				if($(".ajaxed").length > 0){
					$(".ajaxed").remove();
				}
				checkbox.closest(".adverts-field-customadvertscategory")
				.append('<div class="adverts-control-group adverts-field-customadvertscategory adverts-field-name-type_annonce ajaxed "><div><div class="container"><div class="row"><div class="col-md-12"><label for="type_annonce">Type d\'annonce </label><div class="adverts-form-input-group adverts-form-input-group-checkbox adverts-field-rows-0"><div>'+response+'</div></div></div></div></div></div></div>');
			}
		});
		

	});

});


});