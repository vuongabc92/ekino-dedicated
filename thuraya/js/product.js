/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */
(function ($){
    Drupal.behaviors.common = {
        attach: function (context) {
			$(".hover-div").hover( function() {
			//mouse over
			 $(this).find('.prod-img').hide();
			$(this).find('.info-div').show();
			}, function() {
			//mouse out
			$(this).find('.prod-img').show();
			$(this).find('.info-div').hide();
			});		
		}
	}
})(jQuery);

function showDivs(divId){
	//alert("id="+divId);
	if(divId == "pmain"){
		jQuery("#features, #useit, #learnit, #buyit, #accessories, #cform").hide();
		jQuery("#pmain").show();
	} else if(divId == "features"){
		jQuery("#pmain, #useit, #learnit, #buyit, #accessories, #cform").hide();
		jQuery("#features").show();
	} else if(divId == "useit"){
		jQuery("#pmain, #features, #learnit, #buyit, #accessories, #cform").hide();
		jQuery("#useit").show();
	} else if(divId == "learnit"){
		jQuery("#pmain, #useit, #features, #buyit, #accessories, #cform").hide();
		jQuery("#learnit").show();
	} else if(divId == "buyit"){
		jQuery("#pmain, #useit, #learnit, #features, #accessories, #cform").hide();
		jQuery("#buyit").show();
	} else if(divId == "accessories"){
		jQuery("#pmain, #useit, #learnit, #features, #buyit, #cform").hide();
		jQuery("#accessories").show();
	}
	jQuery(".menu-list li").removeClass('active');
	jQuery("#"+divId+"div").addClass('active');
	jQuery("#"+divId).addClass('right-push');
	jQuery("#"+divId).css({ display: "inline-block" });
	jQuery("#"+divId).css({ width: "95%" });
}

function showPage(divId){
	jQuery('#subpage').html(jQuery('#'+divId).html());
	jQuery("#centerdiv").hide();
	jQuery("#subpagediv").show();
}

function backtoMain(){
	jQuery("#centerdiv").show();
	jQuery("#subpagediv").hide();
}

function showForm() {
	jQuery("#pmain").hide();
	jQuery("#cform").show();
	jQuery("#cform").addClass('right-push');
	//jQuery("#cform").css({ display: "inline-block" });
  			
		jQuery("#edit-submitted-country").change(function(){
			selValue = jQuery("#edit-submitted-country option:selected").text();
			if(selValue == "- None -" || selValue == "- Select -"){
				jQuery("#countrybox").html('Country*');
			} else{
				jQuery("#countrybox").html(selValue);
				jQuery('#countrybox').removeClass('error');
			}
		});
}

function showMain() {
	jQuery("#cform").hide();
	jQuery("#pmain").show();
}

function showMore(){
	if(jQuery('#teaser').css('display') == 'none'){ 
		jQuery("#bodydata").hide();
		jQuery("#teaser").show();
	} else {
		jQuery("#bodydata").show();
		jQuery("#teaser").hide();
	}
}
