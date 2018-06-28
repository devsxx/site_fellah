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
	
	$a = $( "#site-navigation .show-sub-menu > a" ); 
	$a.click(function(evt){
		evt.preventDefault(); 
		$ul = $(this).next('ul');  
		// $ul.toggleClass('showAll'); 
		// $( ".showAll .close" ).remove();
		// $( ".showAll" ).append("<div class='close'><i class='fas fa-times'></i></div>");
	}); 
	
	$( ".showAll .close" ).live('click',function( ){ 
		$( "#site-navigation .show-sub-menu > a" ).next('ul').removeClass('showAll'); 
	}); 

	$( "#swipebox-slider" ).live('click',function( ){ 
		$( "#swipebox-close" ).trigger("click"); 
	});  

	$('.wpadverts-slide-nav-thumbnails').click(function (evt) {
		evt.preventDefault();  
		$(".wpadverts-swipe").trigger("click");
	}); 

	$(document).on( 'scroll', function(){
		if (window.matchMedia("(min-width: 1200px)").matches) { 

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

	$('.checkbox_2 input:checkbox').each(function(){
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
					$(".advert_success").text(data.message);
					$(".adverts-field-name-connect .register_form").css("display", "none"); 
					$(".advert_success").css("display", "block").delay(3000).slideUp(100);
				}else{
					$(".advert_danger").text(data.message);
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
		var telephone = $("#telephone").val();
		var nom = $("#nom").val();

		var mot_passe = $("#mot_passe").val();
		var confirm_mot_passe = $("#confirm_mot_passe").val();

		var submit = true;

		// if(prenom == "" && nom == ""){
		// 	submit = false;
		// }

		// if( mot_passe == "" || mot_passe == "" || confirm_mot_passe == "" )
		// 	submit = false;

		// if(confirm_mot_passe != mot_passe){
		// 	submit = false;
		// }

		if(submit){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_login_object.ajaxurl,
				data: { 
					'action': 'ajaxsignup',
					'prenom' : prenom,
					'nom' : nom,
					'email' : email,
					'telephone' : telephone,
					'mot_passe' : mot_passe,
					'confirm_mot_passe' : confirm_mot_passe,
				},
				beforeSend: function() {
					jQuery("#ajaxloader").show();
					jQuery("#ajaxShadow").show();
				},
				success: function(data){ 
					if(data.etat){
						$(".advert_success").text(data.message);
						$(".adverts-field-name-connect .register_form").css("display", "none"); 
						$(".advert_success").css("display", "block").delay(3000).slideUp(100);
						document.location.href="/";
					}else{
						$(".advert_danger").text(data.message);
						$(".advert_danger").css("display", "block").delay(3000).slideUp(100);
					}  
					jQuery("#ajaxloader").hide();
					jQuery("#ajaxShadow").hide();
				}
			});
		}
	});

	$("#update_compte").on('click', function(e){
		e.preventDefault();
		var prenom = $("#prenom").val(); 
		var telephone = $("#telephone").val();
		var nom = $("#nom").val(); 

		var submit = true;

		if(prenom == "" && nom == ""){
			submit = false;
		}  

		if(submit){
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_login_object.ajaxurl,
				data: { 
					'action': 'updateAccount',
					'prenom' : prenom,
					'nom' : nom, 
					'telephone' : telephone, 
				},
				beforeSend: function() {
					jQuery("#ajaxloader").show();
					jQuery("#ajaxShadow").show();
				},
				success: function(data){ 
					if(data.etat){
						$(".advert_success").text(data.message);
						$(".adverts-field-name-connect .register_form").css("display", "none"); 
						$(".advert_success").css("display", "block").delay(3000).slideUp(100);
					}else{
						$(".advert_danger").text(data.message);
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
	
	$(".custom_radio input[type=checkbox]").change(function()	{
		var group = ".custom_radio input:checkbox[name='"+$(this).attr("name")+"']";
		$(group).attr("checked",false);
		$(this).attr("checked",true);

		$(".custom_radio input[type=checkbox]").parent().removeClass('checked')
		$(this).parent().addClass('checked'); 
	});
	
	$("input[type=checkbox].class_advert_category ").change(function()	{
		var group = "input:checkbox[name='"+$(this).attr("name")+"'].class_advert_category ";
		$(group).attr("checked",false);
		$(this).attr("checked",true);

		$("input[type=checkbox].class_advert_category ").parent().removeClass('checked')
		$(this).parent().addClass('checked'); 
	});

   $(".adverts-field-customadvertscategory input[type='checkbox']").click(function(){
   	var checkbox = $(this);
		var allVals = 0;
		
		if ( $( this ).is(':checked') ) {
			allVals = $(this).val(); 
		} 

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
 
	$(document).on('change', 'input[type=checkbox].class_localisation',function()	{
		var group = "input:checkbox[name='"+$(this).attr("name")+"'].class_localisation";
		$(group).attr("checked",false);
		$(this).attr("checked",true);

		$("input[type=checkbox].class_localisation").parent().removeClass('checked')
		$(this).parent().addClass('checked'); 
	});

	$("input[type=checkbox].class_localisation_parent").change(function()	{
		var group = "input:checkbox[name='"+$(this).attr("name")+"'].class_localisation_parent";
		$(group).attr("checked",false);
		$(this).attr("checked",true);

		$("input[type=checkbox].class_localisation_parent").parent().removeClass('checked')
		$(this).parent().addClass('checked'); 
	});

	$(".adverts-field-custom-localisation input[type='checkbox']").click(function(){
   	var localisation_checkbox = $(this); 
		var localisation_allVals = 0;
		
		if ( $( this ).is(':checked') ) {
			localisation_allVals = $(this).val(); 
		} 

   	var id = $(this).val();
   	$.ajax({
   		type: 'POST',
   		url: ajax_login_object.ajaxurl,
   		data: { 
   			'action': 'ajaxSousLocalisation',
   			'ids' : localisation_allVals,
   		},
   		beforeSend: function() {
   			jQuery("#ajaxloader").show();
   			jQuery("#ajaxShadow").show();
   		},
   		success: function(response){
   			if($(".ajaxedLocalisation").length > 0){
   				$(".ajaxedLocalisation").remove();
   			}
   			localisation_checkbox.closest(".adverts-field-custom-localisation").append( response );
   			jQuery("#ajaxloader").hide();
   			jQuery("#ajaxShadow").hide();
   		}
   	});


	});

	$("#show_localisation").live('click', function(){
		$(".adverts-form-input-group-checkbox-localisation .adverts-control-container").addClass('show');
	});

	$("#show_localisation_region").live('click', function(){
		$(".adverts-control-container-region").addClass('show');
	});
	
	$(".adverts-form-input-group-checkbox-localisation .adverts-control-container").live('click', function(){
		var checked = [];
		$( this ).find("input[type=checkbox]").each(function(j, c) {
			 if($(c).is(":checked")) { 
				 checked = $(c).parent().text().trim();
				 $("#show_localisation").html("<i class='fas fa-map-pin'></i><div class=''>" +  checked + "</div>");
			 }
		});
		$(this).removeClass('show');
	}); 

	$(".adverts-control-container-region").live('click', function(){
		var checked = [];
		$( this ).find("input[type=checkbox]").each(function(j, c) {
			 if($(c).is(":checked")) {
				 checked = $(c).parent().text().trim();
				 $("#show_localisation_region").html("<i class='fas fa-map-pin'></i><div class=''>" +  checked + "</div>");
			 }
		});
		$(this).removeClass('show');
	});   

   $('.adverts-field-name-gallery').find('.row').append("<div class='col-md-6'><div class='gallerymessage'>" + ajax_login_object.GALLERYMESSAGE + "</div></div>");
   $("select.adverts-multiselect").each(function(index, item) {
   	var $this = $(item);
   	var $parent = $this.parent();
   	var text = adverts_multiselect_lang.hint;

   	var holder = $("<div></div>");
   	holder.addClass("adverts-multiselect-holder");

   	if ( $this.attr("id") == "advert_category" ) 
   		text = adverts_multiselect_lang.advert_category;
   	else if( $this.attr("id") == "localisation" )
   		text = adverts_multiselect_lang.localisation;

   	if($this.data("empty-option-text")) {
   		text = $this.data("empty-option-text");
   	}

   	var input = $('<input type="text" />');
   	input.attr("id", $this.attr("name"));
   	input.attr("id", $this.attr("id"));
   	input.attr("placeholder", text);
   	input.attr("autocomplete", "off");
   	input.addClass("adverts-multiselect-input");
   	input.on("focus", function(e) {

   		$(this).blur();
   		e.stopPropagation();

   		if($(this).hasClass("adverts-multiselect-open")) {
   			$(this).removeClass("adverts-multiselect-open");
   			$(this).parent().find(".adverts-multiselect-options").hide();
   		} else {
   			$(this).addClass("adverts-multiselect-open");
   			$(this).parent().find(".adverts-multiselect-options").css("width", $(this).outerWidth()-1);
   			$(this).parent().find(".adverts-multiselect-options").show();
   		}
   	});


   	var options = $("<div></div>");
   	options.addClass("adverts-multiselect-options");

   	$this.find("option").each(function(i, o) {
   		var o = $(o);
   		var label = $("<label></label>");              
   		label.attr("for", input.attr("id")+"-"+i);

   		if(o.data("depth")) {
   			label.addClass("adverts-option-depth-"+o.data("depth"));
   			label.css("padding-left", (parseInt(o.data("depth"))*20).toString() + "px" )
   		} else {
   			label.addClass("adverts-option-depth-0");
   		}

   		var checkbox = $('<input type="checkbox" />');
   		checkbox.attr("id", input.attr("id")+"-"+i);
   		checkbox.attr("value", o.attr("value"));
   		checkbox.attr("name", $this.attr("name"));
   		checkbox.data("wpjb-owner", input.attr("id"));
   		checkbox.change(function() {
   			var owner = $("#"+$(this).data("wpjb-owner"));
   			var all = $(this).closest(".adverts-multiselect-options").find("input");
				var checked = [];

				input.removeClass("adverts-multiselect-open");
				input.parent().find(".adverts-multiselect-options").hide();
				
   			all.each(function(j, c) {
   				if($(c).is(":checked")) {
   					checked.push($(c).parent().text().trim());
   				}
   			});

   			owner.attr("value", checked.join(", "));
   		});
   		if(o.is(":selected")) {
   			checkbox.attr("checked", "checked");
   		}

   		label.append(checkbox).append(" ").append(o.text());
   		options.append(label);
   	});

   	holder.append(input).append(options);

   	$this.replaceWith(holder);

   	var checked = [];
   	options.find("input[type=checkbox]").each(function(j, c) {
   		if($(c).is(":checked")) {
   			checked.push($(c).parent().text().trim());
   		}
   	});
   	input.attr("value", checked.join(", "));
   });

	$(".wpadverts-slide-nav-thumbnails-list").click(function(){
		$( this ).toggle();
	});

   $( "#slider-range-LCD" ).slider({
   	range: true,
   	min: 10,
   	max: 10000000,
   	values: [ SEARCH_VARS.slider_min_value , SEARCH_VARS.slider_max_value ],
   	slide: function( event, ui ) {
   		$( "#input-amount-LCD" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
   		$( "#amount-LCD" ).html( SEARCH_VARS.price + number_format(ui.values[ 0 ], 0, ',', ' ') + " DH - " + number_format(ui.values[ 1 ], 0, ',', ' ') + " DH &nbsp;&nbsp;" );
		},
		stop: function () {
			$("#adverts-search-form").submit(); 
		}
	});
	
   $( "#input-amount-LCD" ).val( $( "#slider-range-LCD" ).slider( "values", 0 ) + "-" + $( "#slider-range-LCD" ).slider( "values", 1 ) );
   $( "#amount-LCD" ).html( SEARCH_VARS.price + number_format($( "#slider-range-LCD" ).slider( "values", 0 ), 0, ',', ' ')  + " DH - " + number_format($( "#slider-range-LCD" ).slider( "values", 1 ), 0, ',', ' ') + " DH &nbsp;&nbsp;"  );

	$('#post_title').keyup(function(e){
		updateOutput();
	});
	
	function updateOutput(){
		var sampleInput = $('#post_title').val(),
			sampleInputLength = sampleInput.length;
	
		if(sampleInputLength >= 25) {    
			$('#post_title').val( sampleInput.substr(0,25) );    
		} 
	}

	$('.checkbox_pics input:checkbox').change(function(){
		if($(this).is(':checked')) 
			$(this).parent().addClass('checked'); 
		else 
			$(this).parent().removeClass('checked')
	});
	
	$("#pics").change(function(){ 
		$("#adverts-search-form").submit(); 
	});
	
});


function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase

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