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
		slideBy: 1,
		dots: false,
		autoWidth: true,
		nav:true,	 
		navText: ['<img src="wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="wp-content/themes/fellah/img/icons/arrow-right.png">'],
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

	jQuery('#top_annoces_slider').owlCarousel({
		loop:true,
		margin: 30,
		slideBy: 1,
		dots: false,
		autoWidth: true,
		nav:true,	
		navText: ['<img src="wp-content/themes/fellah/img/icons/arrow-left.png">','<img src="wp-content/themes/fellah/img/icons/arrow-right.png">'],
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

	if (window.matchMedia("(max-width: 1200px)").matches) {

		jQuery("#site-navigation #primary-menu .menu-item-has-children").each(function(evt){
			$a = jQuery( this ).children("a");  
			$a.click(function(evt){
				evt.preventDefault(); 
			});

		});

	}


	// if (jQuery('#set_views_count').length) {
	// 	var ID_count = jQuery('#set_views_count').attr('data-id');
	// 	console.log(jQuery('#set_views_count').length);
	// 	console.log(ID_count);
	// 	jQuery.post( ajaxurl, {
	// 		action: 'my_set_get_PostViews',
	// 		'ID_count': ID_count
	// 	},
	// 	function(response) {
	// 		jQuery('#set_views_count').html(response);
	// 	});
	// 	return false;
	// 	alert(ID_count);
	// }

});