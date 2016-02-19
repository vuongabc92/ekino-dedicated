(function ($){
    Drupal.behaviors.common = {
    attach: function (context) {   
  var s = $('form input#edit-keys').length;
  if(s == '1'){
    var r = $('h1').html();
	if(r != null){
    $('.breadcrumbs').after('<h1>'+r+'</h1>');
	}
  }

	// RSS navigation
	$('#snMenuItems').find('li:first').hover(function(event){
		event.stopPropagation();
		$(this).find('ul').css({display:'block'});
		$(this).find('ul li a').hover(function(){
		$(this).css({color:"#0AA9EE"});
       $('.ui-header-nav .main-nav ul').css('z-index','-1');
  }, function(){ $(this).css({color:"#999"}); })
	}, function(event){
		event.stopPropagation();
		$(this).find('ul').css({display:'none'});
	       $('.ui-header-nav .main-nav ul').css('z-index','9999');
	})

	var whr = $('.openlayers-views-map').html();
    if(whr == ''){
       $('#wrb_no_results').show();
    }
	
    //alert('>>'+window.location.pathname);
   // var dropdown = document.getElementById('mob-menu').childNodes;
    //alert(dropdown);
    var pageURL = window.location.pathname;

    /*for(var i=0, max=dropdown.children.length; i<max; i++) {
        textSelected = dropdown.children[i].innerHTML;
        alert(textSelected);
        if(textSelected == pageURL)
        {return;}
    }*/
    if($('#mob-menu').length == 1){
    var dropdown = document.getElementById('mob-menu').childNodes;
    for(i = 0; i < dropdown.length; i++)
    {
      subOptions = dropdown[i].childNodes;
      for(j = 0; j < subOptions.length; j++){
    	  //alert(subOptions[j].value);
         if(subOptions[j].value == pageURL){
        	 subOptions[j].selected = true;
        	 break;
         }
      }
    }
    }
    
       /*sales enquiry form*/
	var sales_en =$('ul.sales_enquiry_form').length;
	var contact_en =$('ul#contactus_form').length;
	var prodserv_en =$('ul#prodServInqForm').length;
	var bussprop_en =$('ul#bussPropForm').length;
	var complaint_en =$('ul#complaintForm').length;
	var feedback_en =$('ul#feedbackForm').length;	
	var reg_form = $('div.register').length;
	var media_form = $('ul.media_enquiry_form').length;
	var partner_form = $('ul#partnerForm').length;


  function ucFirstAllWords( str )
	{
		var pieces = str.split(" ");
		for ( var i = 0; i < pieces.length; i++ )
		{
			if(pieces[i] == "imei" || pieces[i] == "msisdn" || pieces[i] == "gps"){
				pieces[i] = pieces[i].toUpperCase();
			} else {
				var j = pieces[i].charAt(0).toUpperCase();
				pieces[i] = j + pieces[i].substr(1);
			}
		}
		return pieces.join(" ");
	}
	
	/*login form placeholders*/
	$('#user-login #edit-name').attr('placeholder','Email');
 $('#user-login #edit-pass').attr('placeholder','Password');
 $('form#user-register-form #edit-mail').attr('placeholder','Email*');
$('li.btn-log input#edit-submit').val('Login');

    if(reg_form == '1'){
/*reg step 2 accordion*/
$('.carrer-holder').hide();
	$('.show_div').show();
	$(".hline").click(function(){
	$(this).find('.ui-icon').removeClass('plus').addClass('minus');
	$(this).parent().siblings().find('.carrer-holder').slideUp('slow');
	$(this).parent().siblings().find('.ui-icon').removeClass('minus').addClass('plus');
	$(this).next().slideDown('slow');
	})
	
/* end reg step 2 accordion*/

     $('input[type="text"],input[type="email"], textarea').each(function(){
        var def_text_reg = $(this).attr('name');
        var clsName = $(this).attr('class');
        var search_str = def_text_reg.match("field_(.*)und");
        if(search_str !=null){
           var str = search_str[1];
           var t = str.replace(']','');
           var defalt_strng2 = t.replace('[','');
           var defalt_strng3 = defalt_strng2.replace('multi_','');
            
          while(defalt_strng3.search("_") > 0){
            defalt_strng3 = defalt_strng3.replace("_", " ");
          }
          defalt_strng3 = ucFirstAllWords(defalt_strng3);
               var reqStar = "*";

          defalt_strng = defalt_strng3;
          if(clsName.search("required") > 0){
            defalt_strng3 = defalt_strng3 + reqStar;
          }
          
          if(defalt_strng3 != 'Captcha response' && def_text_reg != 'custom_search_criteria_or'){
            $(this).attr('placeholder',defalt_strng3);
          }
        }		
      });
	} 

var birth_const = '#edit-profile-main-field-birthday-und-0-value';
var birth_field = '#edit-profile-main-field-birthday-und';

$(birth_const+' div.date-month').prepend('<span class="select selectbox-bg" id="birthdaymonth">MM</span>');
	$(birth_const+' div.date-day').prepend('<span class="select selectbox-bg" id="birthdaydate">DD</span>');
	$(birth_const+' div.date-year').prepend('<span class="select selectbox-bg" id="birthdayyear">YYYY</span>');

	/*start birthday*/
	$(birth_field+"-0-value-month").change(function(){
		var selValue = $("select"+birth_field+"-0-value-month option:selected").text();				
		$("#birthdaymonth").html(selValue);
	 });
     $(birth_field+"-0-value-day").change(function(){
		var selValue = $("select"+birth_field+"-0-value-day option:selected").text();				
		$("#birthdaydate").html(selValue);
	 });
	 $(birth_field+"-0-value-year").change(function(){
		var selValue = $("select"+birth_field+"-0-value-year option:selected").text();				
		$("#birthdayyear").html(selValue);
	 });
     /*end bidthday*/

	 /*available date*/
	 var availdate_const = '#edit-profile-main-field-available-date';
	 var aval_field = '#edit-profile-main-field-available-date-und';

$(availdate_const+' div.date-month').prepend('<span class="select selectbox-bg" id="availmonth">MM</span>');
	$(availdate_const+' div.date-day').prepend('<span class="select selectbox-bg" id="availdate">DD</span>');
	$(availdate_const+' div.date-year').prepend('<span class="select selectbox-bg" id="availyear">YYYY</span>');

	$(aval_field+"-0-value-month").change(function(){
		var selValue = $("select"+aval_field+"-0-value-month option:selected").text();				
		$("#availmonth").html(selValue);
	 });
     $(aval_field+"-0-value-day").change(function(){
		var selValue = $("select"+aval_field+"-0-value-day option:selected").text();				
		$("#availdate").html(selValue);
	 });
	 $(aval_field+"-0-value-year").change(function(){
		var selValue = $("select"+aval_field+"-0-value-year option:selected").text();				
		$("#availyear").html(selValue);
	 });
	 /*end avail date*/


$('label[for=edit-profile-main-field-birthday-und-0-value-month]').hide();
$('label[for=edit-profile-main-field-birthday-und-0-value-day]').hide();
$('label[for=edit-profile-main-field-birthday-und-0-value-year]').hide();
$('label[for=edit-profile-main-field-available-date-und-0-value-month]').hide();
$('label[for=edit-profile-main-field-available-date-und-0-value-day]').hide();
$('label[for=edit-profile-main-field-available-date-und-0-value-year]').hide();

	
	/* start by setting selected value for back to step 1 form */
	//Gender
	var selValuegender = $("select#edit-profile-main-field-gender-und option:selected").text();
	if (selValuegender == '- Select a value -') {
		$("#genderselect").html('Gender*');
		var clsName = $('.select_box select').attr('class');
		if(clsName.search('error') > 0){
			$('#genderselect').addClass('error');
		}
	} else {
		$("#genderselect").html(selValuegender);
	}
	
	//DOB
	
	//Month
	var selValuemonth = $("select#edit-profile-main-field-birthday-und-0-value-month option:selected").text();
	
	if (selValuemonth == '') {
	$("#birthdaymonth").html('MM');
	
	} else {
	$("#birthdaymonth").html(selValuemonth);
	}
	
	//default vlaue
	$("select#edit-profile-main-field-birthday-und-0-value-month option").each(function() {
     if($(this).text() == '') {
        $(this).text('MM');            
     }                        
    });
	//Day
	var selValueday = $("select#edit-profile-main-field-birthday-und-0-value-day option:selected").text();

	if (selValueday == '') {
	$("#birthdaydate").html('DD');
		
	} else {
	$("#birthdaydate").html(selValueday);	
	}
	//default vlaue
	$("select#edit-profile-main-field-birthday-und-0-value-day option").each(function() {
     if($(this).text() == '') {
        $(this).text('DD');            
     }                        
    });
	//Year
	var selValueyear = $("select#edit-profile-main-field-birthday-und-0-value-year option:selected").text();
	
		if (selValueyear == "") {
		$("#birthdayyear").html('YYYY');	
		
		} else {
		$("#birthdayyear").html(selValueyear);	
		} 

	//default vlaue
	$("select#edit-profile-main-field-birthday-und-0-value-year option").each(function() {
     if($(this).text() == '') {
        $(this).text('YYYY');            
     }                        
    });

  //available date
  //Month
	var selValuemonth = $("select#edit-profile-main-field-available-date-und-0-value-month option:selected").text();
	
	if (selValuemonth == '') {
	$("#availmonth").html('MM');
	
	} else {
	$("#availmonth").html(selValuemonth);
	}
	
	//default vlaue
	$("select#edit-profile-main-field-available-date-und-0-value-month option").each(function() {
     if($(this).text() == '') {
        $(this).text('MM');            
     }                        
    });
	//Day
	var selValueday = $("select#edit-profile-main-field-available-date-und-0-value-day option:selected").text();

	if (selValueday == '') {
	$("#availdate").html('DD');
		
	} else {
	$("#availdate").html(selValueday);	
	}
	//default vlaue
	$("select#edit-profile-main-field-available-date-und-0-value-day option").each(function() {
     if($(this).text() == '') {
        $(this).text('DD');            
     }                        
    });
	//Year
	var selValueyear = $("select#edit-profile-main-field-available-date-und-0-value-year option:selected").text();
	
		if (selValueyear == "") {
		$("#availyear").html('YYYY');	
		
		} else {
		$("#availyear").html(selValueyear);	
		} 

	//default vlaue
	$("select#edit-profile-main-field-available-date-und-0-value-year option").each(function() {
     if($(this).text() == '') {
        $(this).text('YYYY');            
     }                        
    });
  //end avail date

	//Visa Status
    var selvisavalue = $("select#edit-profile-main-field-visa-status-und option:selected").text();
	//console.log(selvisavalue);
		if (selvisavalue == '- None -') {
		$("#visa-status").html('Visa Status');	
		} else {
		$("#visa-status").html(selvisavalue);
		}
	
	//Experience level
	
	$("#edit-profile-main-field-experience-level-und").change(function(){
		var selValue = $("select#edit-profile-main-field-experience-level-und option:selected").text();				
		$("#experiencelevel").html(selValue);
	 });
	var exp_level = $('edit-profile-main-field-experience-level-und option:selected').text();
		if (exp_level == '' || exp_level == '_none') {
		$("#experiencelevel").html('Experience Level');	
		} else {
		$("#experiencelevel").html(exp_level);
		}
	var onloadExpVal = $("select#edit-profile-main-field-experience-level-und option:selected").text();
	if (onloadExpVal == '' || onloadExpVal == '_none') {
		$("#experiencelevel").html('Experience Level');	
		} else {
		$("#experiencelevel").html(onloadExpVal);
		}
	
	//Industry exp	
	$("#edit-profile-main-field-industry-experience-und").change(function(){
		var selValue = $("select#edit-profile-main-field-industry-experience-und option:selected").text();				
		$("#industryexperience").html(selValue);
	 });
	var ind_exp = $('edit-profile-main-field-industry-experience-und option:selected').text();
		if (ind_exp == '' || ind_exp == '_none') {
		$("#industryexperience").html('Industry Experience');	
		} else {
		$("#industryexperience").html(ind_exp);
		}
	var onloadIndExpVal = $("select#edit-profile-main-field-industry-experience-und option:selected").text();
	if (onloadIndExpVal == '' || onloadIndExpVal == '_none') {
	$("#industryexperience").html('Industry Experience');	
	} else {
	$("#industryexperience").html(onloadIndExpVal);
	}

	//Nationality Status
    var selnationalityvalue = $("select#edit-profile-main-field-nationality-und").val();
	
		if (selnationalityvalue == '' || selnationalityvalue== '_none') {
		$("#nationality").html('Nationality');	
		} else {
		$("#nationality").html(selnationalityvalue);
		}	

			//Marital Status
    var selmaritalvalue = $("select#edit-profile-main-field-marital-status-und").val();
	
		if (selmaritalvalue == '' || selmaritalvalue == '_none') {
		$("#maritialstatus").html('Marital Status');	
		} else {
		$("#maritialstatus").html(selmaritalvalue);
		}
		
		//Country PO
		var countrypovalue = $("select#edit-profile-main-field-country-p-o-box-und").val();
		if (countrypovalue == '' || countrypovalue == '_none') {
		$("#countrypobox").html('Country P.O. Box');	
		} else {
		$("#countrypobox").html(countrypovalue);
		}
		
		
		//Available Date
		var availablemonthvalue = $("select#edit-profile-main-field-available-date-und-0-value-month option:selected").text();
		//console.log(availablemonthvalue);
		
	$("#edit-profile-main-field-gender-und").change(function(){
		var selValue = $("select#edit-profile-main-field-gender-und option:selected").text();	
		if (selValue == '- Select a value -') {
	       $("#genderselect").html('Gender*');
		} else {
			$("#genderselect").html(selValue);
			$('#genderselect').removeClass('error');
		}
	 });

	 /*available date*/
	$("#edit-profile-main-field-available-date-und-0-value-month").change(function(){
		var selValue = $("select#edit-profile-main-field-available-date-und-0-value-month option:selected").text();				
		if (selValue == "") {
		$("#availmonth").html('MM');
		} else {
		$("#availmonth").html(selValue);
		}
	 });



     $("#edit-profile-main-field-available-date-und-0-value-day").change(function(){
		var selValue = $("select#edit-profile-main-field-available-date-und-0-value-day option:selected").text();
			if (selValue == '') {
			$("#availdate").html('DD');
			} else {
			$("#availdate").html(selValue);
		}
	 });
	 $("#edit-profile-main-field-available-date-und-0-value-year").change(function(){
		var selValue = $("select#edit-profile-main-field-available-date-und-0-value-year option:selected").text();	
			if (selValue == '') {
				$("#availyear").html('YYYY');
			} else {
			 $("#availyear").html(selValue);
		}
	 });
     /*end available date*/
	 
	 
	 /* Birthdate */
	 
	 //MM
	 	$("#edit-profile-main-field-birthday-und-0-value-month").change(function(){
		var selValue = $("#edit-profile-main-field-birthday-und-0-value-month option:selected").text();				
		if (selValue == "") {
		$("#birthdaymonth").html('MM');
		} else {
		$("#birthdaymonth").html(selValue);
		}
	 });
	 
	 //DD
	 	$("#edit-profile-main-field-birthday-und-0-value-day").change(function(){
		var selValue = $("#edit-profile-main-field-birthday-und-0-value-day option:selected").text();	
//console.log(selValue);		
		if (selValue == "") {
		$("#birthdaydate").html('DD');
		} else {
		$("#birthdaydate").html(selValue);
		}
	 });

	 	 //YYYY
	 	$("#edit-profile-main-field-birthday-und-0-value-year").change(function(){
		var selValue = $("#edit-profile-main-field-birthday-und-0-value-year option:selected").text();	
	
		if (selValue == "") {
		$("#birthdayyear").html('YYYY');
		} else {
		$("#birthdayyear").html(selValue);
		}
	 });


$('div.multiple-field-skill-level div.form-item,div.multiple-field-lang-skill-level div.form-item').each(function(){
	$(this).addClass('select_box');
	var s = $(this).find('select').attr('id');
	$(this).prepend('<span class="select selectbox-bg" id="'+s+'">Skill Level</span>');

	$('select.form-select').change(function(){
		var id = $(this).attr('id');
		var sel_val = $(this).val();
		 var sel_id =$("#"+id+" option[value='"+sel_val+"']").text();
		if(sel_id == '- None -'){
			 $('span.select#'+id+'').html('Skill Level');
		} else {
		 $('span.select#'+id+'').html(sel_id);
		}
	  });


	  $('select.form-select').each(function(){
    var id = $(this).attr('id');   
     var sel_id =$("#"+id+" option[selected=selected]").text();
     if(sel_id!=''){
     $('span.select#'+id+'').html(sel_id);
     }
  });

});


/*delete*/

/*var h='0';
var j = 'fgm_profile2_main_form_group_professional_experiences-add-more-wrapper';
$('div.multiple-field-period').each(function(){
if(h!='0'){
 var id = $(this).find('input').attr('id');

 var r = '<input type="button" name="prof_exp" value="Delete" class="btn-reset" id="'+h+'">';
 $('input#'+id+'').after(''+r+'');
}
h++;
});

$('input.btn-reset').click(function(){
  var g = $(this).attr('id');  
  $('div#'+j+' div.multiple-item-'+g+'').remove();
});*/

/*end delete*/
/*end multi group*/

	 $("#edit-profile-main-field-visa-status-und").change(function(){
		var selValue = $("select#edit-profile-main-field-visa-status-und option:selected").text();				
		if(selValue == '- None -'){
			$("#visa-status").html('Visa Status');
		} else {
		$("#visa-status").html(selValue);
		}
	 });

	 $("#edit-profile-main-field-nationality-und").change(function(){
		var selValue = $("select#edit-profile-main-field-nationality-und option:selected").text();				
		if(selValue == '- None -'){
			$("#nationality").html('Nationality');
		} else {
		$("#nationality").html(selValue);
		}
	 });
	 
	 $("#edit-profile-main-field-marital-status-und").change(function(){
		var selValue = $("select#edit-profile-main-field-marital-status-und option:selected").text();
         if (selValue == '- None -') {
		 $("#maritialstatus").html('Marital Status');
		} else {		 
		$("#maritialstatus").html(selValue);
		}
	 });

	$("#edit-profile-main-field-country-p-o-box-und").change(function(){
		var selValue = $("select#edit-profile-main-field-country-p-o-box-und option:selected").text();				
		$("#countrypobox").html(selValue);
	 });
	 
	 
	 	 $("#edit-profile-main-field-notice-period-new-und").change(function(){
		var selValue = $("#edit-profile-main-field-notice-period-new-und option:selected").text();
         if (selValue == '- None -') {
		 $("#notice_period").html('Notice Period');
		} else {		 
		$("#notice_period").html(selValue);
		}
	 });
	/*end reg form*/


/*careers*/
/*job postings*/
$('select#edit-field-category-value option:contains("- Any -")').text('All');

$('input#edit-combine').attr('placeholder','Search');
$('select#edit-field-category-value').addClass('styled');
$('#edit-profile-main-field-birthday').addClass('date-select-box');

$('.carrer-holder').hide();
	$('.show_div').show();
	$(".hline").click(function(){
		$(this).find('.ui-icon').removeClass('plus').addClass('minus');
		$(this).parent().siblings().find('.carrer-holder').slideUp('slow');
		$(this).parent().siblings().find('.ui-icon').removeClass('minus').addClass('plus');
		$(this).next().slideDown('slow');
	});

	$('input#edit-submit-job-posting').click(function(){
		if ($('input#edit-combine').val() === 'Search') {
			$('input#edit-combine').val('');
		}
	});
	var query_string = getParameters();
	if (query_string.field_category_value != undefined) {
		var filt = decodeURIComponent(query_string.field_category_value);
		var filt_reg = new RegExp("\\+","g");
		filt = filt.replace(filt_reg, " ");
			$("#vacancies_filter").html(filt);
			$('#edit-combine').val(query_string.combine);
	}
	$("select#edit-field-category-value").change(function(){
		var selValue = $("select#edit-field-category-value option:selected").text();
		
		$("#vacancies_filter").html(selValue);
	 });
$('div.multiple-field-completion-date div.fieldset-wrapper').addClass('form-item');

$('li.btn-log #edit-actions input').removeClass('form-submit');
$('li.btn-log #edit-actions input').addClass('btn-login');

/*end job postings*/

/*end careers*/
	
	if(contact_en == '2'){
		$("#edit-submitted-country").addClass('customstyled');
		$("#edit-submitted-buycountry").addClass('customstyled');	
	}
	
	
	if(sales_en == '1' || contact_en == '1' || prodserv_en == '1' || bussprop_en == '1' || complaint_en == '1' || feedback_en == '1' || media_form == '1' || partner_form == '1'){
		if(sales_en == '1' || contact_en == '1')
			$("#edit-submitted-country").addClass('customstyled');
		else
		$("#edit-submitted-country").addClass('styled');
		
		$("#edit-submitted-products").addClass('styled');
		$("#edit-submitted-form2-products").addClass('styled');
		$("#edit-submitted-form2-country").addClass('styled');
		$("#edit-submitted-products-price-plan").addClass('styled');
		$("#edit-submitted-nature-of-complaint").addClass('styled');
		$("#edit-submitted-form3-country").addClass('styled');
		$("#edit-submitted-feedback-type").addClass('styled');
		$("#edit-submitted-form4-country").addClass('styled');
		$("#edit-submitted-partner-type").addClass('styled');
		$("#edit-submitted-partner-country").addClass('styled');
		
		var selValue = $("#edit-submitted-partner-type option:selected").text();
		//alert(">>"+selValue);
		if(selValue == "- None -" || selValue == "- Select -"){
		 $("#partnertype").html('Partner Type');
		}
		else{
		 $("#partnertype").html(selValue);
		}
			
		$("#edit-submitted-partner-type").change(function(){
			selValue = $("#edit-submitted-partner-type option:selected").text();
			if(selValue == "- None -" || selValue == "- Select -"){
				$("#partnertype").html('Partner Type');
			} else{
			$("#partnertype").html(selValue);
			}
		});
		
		//Partner Country
		var selValue = $("#edit-submitted-partner-country option:selected").text();
		//alert(">>"+selValue);
		if(selValue == "- None -" || selValue == "- Select -"){
			$("#partner-country").html('Country*');
			if( $('#edit-submitted-partner-country').hasClass('error') ){
				$('#partner-country').addClass('error');
			}
		}
		else{
			$("#partner-country").html(selValue);
		}
			
		$("#edit-submitted-partner-country").change(function(){
			selValue = $("#edit-submitted-partner-country option:selected").text();
			if(selValue == "- None -" || selValue == "- Select -"){
				$("#partner-country").html('Country*');				
			} else{
				$("#partner-country").html(selValue);
				$('#partner-country').removeClass('error');
			}
		});
	
		/* Countries onchange functions - start here */
		//Country 1
		var selValue = $("#edit-submitted-country option:selected").text();
		//alert(">>"+selValue);
		if(selValue == "- None -" || selValue == "- Select -"){
			$("#countrybox").html('Country*');
			if( $('#edit-submitted-country').hasClass('error') ){
				$('#countrybox').addClass('error');
			}
		}
		else{
			$("#countrybox").html(selValue);
		}

		//Country 2
		selValue = $("#webform-component-form2-country option:selected").text();
		if(selValue == "- Select -"){
			$("#countrybox2").html('Country*');
			if( $('#edit-submitted-form2-country').hasClass('error') ){
				$('#countrybox2').addClass('error');
			}
		}else{
			$("#countrybox2").html(selValue);
		}
		
			
		$("#webform-component-form2-country").change(function(){
			selValue = $("#webform-component-form2-country option:selected").text();			
			if(selValue == "- Select -"){
				$("#countrybox2").html('Country*');
			} else {
				$("#countrybox2").html(selValue);
				$('#countrybox2').removeClass('error');
			}
		});
		
		//Country 3
		selValue = $("#webform-component-form3-country option:selected").text();
		if(selValue == "- Select -"){
			$("#countrybox3").html('Country*');
			if( $('#edit-submitted-form3-country').hasClass('error') ){
				$('#countrybox3').addClass('error');
			}
		} else {
			$("#countrybox3").html(selValue);
		}
			
		$("#webform-component-form3-country").change(function(){
			selValue = $("#webform-component-form3-country option:selected").text();			
			if(selValue == "- Select -"){
				$("#countrybox3").html('Country*');
			} else {
				$("#countrybox3").html(selValue);
				$('#countrybox3').removeClass('error');
			}
		});
		
		//Country 4
		selValue = $("#webform-component-form4-country option:selected").text();
		if(selValue == "- Select -"){
			$("#countrybox4").html('Country*');
			if( $('#edit-submitted-form4-country').hasClass('error') ){
				$('#countrybox4').addClass('error');
			}
		} else {
			$("#countrybox4").html(selValue);
		}
		
			
		$("#webform-component-form4-country").change(function(){
			selValue = $("#webform-component-form4-country option:selected").text();			
			if(selValue == "- Select -"){
				$("#countrybox4").html('Country*');
			} else {
				$("#countrybox4").html(selValue);
				$('#countrybox4').removeClass('error');
			}
		});
		
		/* Countries onchange functions - end here */
		
		/* Products onchange functions - start here */
		
		//Product 1
		selValue = $("#edit-submitted-products option:selected").text();
		if(selValue != "- Select -")
			$("#productspriceplan").html(selValue);
			
		$("#edit-submitted-products").change(function(){
			selValue = $("#edit-submitted-products option:selected").text();				
			$("#productspriceplan").html(selValue);
		});
		
		//Product 2
		selValue = $("#edit-submitted-form2-products option:selected").text();
		if(selValue != "- Select -")
			$("#productspriceplan2").html(selValue);
			
		$("#edit-submitted-form2-products").change(function(){
			selValue = $("#edit-submitted-form2-products option:selected").text();				
			$("#productspriceplan2").html(selValue);
		});
		
		//Product 3
		selValue = $("#edit-submitted-products-price-plan option:selected").text();
		if(selValue != "- Select -")
			$("#productspriceplan3").html(selValue);
			
		$("#edit-submitted-products-price-plan").change(function(){
			selValue = $("#edit-submitted-products-price-plan option:selected").text();				
			$("#productspriceplan3").html(selValue);
		});
		
		//Nature of Complaint
		selValue = $("#edit-submitted-nature-of-complaint option:selected").text();
		if(selValue != "- Select -")
			$("#nfcomplaint").html(selValue);
			
		$("#edit-submitted-nature-of-complaint").change(function(){
			selValue = $("#edit-submitted-nature-of-complaint option:selected").text();				
			$("#nfcomplaint").html(selValue);
		});
		
		//Feedback Type
		selValue = $("#edit-submitted-feedback-type option:selected").text();
		if(selValue != "- Select -")
			$("#feedbacktype").html(selValue);
			
		$("#edit-submitted-feedback-type").change(function(){
			selValue = $("#edit-submitted-feedback-type option:selected").text();				
			$("#feedbacktype").html(selValue);
		});
		
		/* Products onchange functions - end here */

		 $('input[type="text"],input[type="email"], textarea').each(function(){
        var def_text = $(this).attr('name');
        var clsName = $(this).attr('class');
        //alert(">>"+clsName.search("required"));
        var reqStar = "*";
		 
        var def_words = eval("/submitted/g");
        var defalt_strng1 = def_text.replace(def_words, "");
        var defalt_strng2 = defalt_strng1.replace("[", "");
        var defalt_strng3 = defalt_strng2.replace("]", "");
		
        while(defalt_strng3.search("_") > 0){
          defalt_strng3 = defalt_strng3.replace("_", " ");
        }
        //defalt_strng3 = defalt_strng3.charAt(0).toUpperCase() + defalt_strng3.substring(1);
        defalt_strng3 = ucFirstAllWords(defalt_strng3);
        /*String.prototype.capitalize = function() {
          return this.charAt(0).toUpperCase() + this.slice(1);
        }*/
        defalt_strng = defalt_strng3;
        if(clsName.search("required") > 0){
          defalt_strng3 = defalt_strng3 + reqStar;
          //alert(defalt_strng3);
        }
		    // comment this now using webform hint module
        if(defalt_strng3 != 'Captcha response' && defalt_strng3 != 'Title' && def_text != 'custom_search_criteria_or'){          
          $(this).attr('placeholder',defalt_strng3);
        }
		
		});
    }
	//Added by Samy to change the placeholder text for Profile Address field
	$("#edit-profile-main-field-profile-address-und-0-value").attr('placeholder','Address');
	$("#edit-profile-main-field-po-box-und-0-value").attr('placeholder','Country P.O Box');
	
	$('#back-btn, #back-btn2, #back-btn3, #back-btn4').click(function(){
		//alert('clicked');
		$('#form1, #form2, #form3, #form4').hide();
		$('#complaint').val('Select a subject').attr('selected',true);
		$('#complaintservice').html('Select a subject');
	});
	
	/*end sales enquiry form*/
	
	$("#complaint").change(function(){
		var selValue = $("#complaint").val();
		//alert(selValue);
		$("#complaintservice").html(selValue);
		if(selValue == "Product or Service Inquiry"){
			$("#form2, #form3, #form4").hide();
			$("#form1").show();
		} else if(selValue == "Business Proposal or Sales Inquiry"){
			$("#form1, #form3, #form4").hide();
			$("#form2").show();
		} else if(selValue == "Complaint or Service Request"){
			$("#form1, #form2, #form4").hide();
			$("#form3").show();
		} else if(selValue == "Feedback"){
			$("#form1, #form2, #form3").hide();
			$("#form4").show();
		} else {
			$("#form1, #form2, #form3, #form4").hide();
		}
	}); 
            

	


	var words = eval("/Gold|Bronze|Silver/g");
  
   var popup_tier_text=$('div.bottom_popup').html();
		if(popup_tier_text != null){
	var whrby_popup_tier_values = popup_tier_text.replace(words, "");
		$('div.bottom_popup').html(''+whrby_popup_tier_values+'');
	}


$('div#popup_close').css({'width':'26px','height':'25px'});

            /*search form textbox in where to buy /service partners*/
			var form_action = $('form#views-exposed-form-service-partners-page').attr('action');

			var title_box = $('input#edit-title').val();
			if(title_box == ""){
			$('input#edit-title').val('Company');
			}
            
			 $('input#edit-title').each(function(){
              this.value =  $(this).attr('value');
			  $(this).focus(function(){
						if(this.value == 'Company') {
							this.value = '';
						}
					});
	 
				$(this).blur(function(){
					if(this.value == '') {
						this.value = 'Company';
					}
				});

		     });
          

         $('input#edit-submit-where-to-buy, input#edit-submit-where-to-buy-spiderify').click(function(){
			if($('input#edit-title').val() == 'Company'){
			 $('input#edit-title').val('');
			}			
			});

			$('input#edit-submit-service-partners').click(function(){
							var title_box1 = $('input#edit-title').val();

			if(title_box1 == 'Company'){
			 $('input#edit-title').val('');
			}
			
			var act = Drupal.settings.basePath+'partners/all';
            var act_retailer = Drupal.settings.basePath+'retailer-partners/all'; 
			$('form#views-exposed-form-service-partners-page').attr('action',''+act+'');
			$('form#views-exposed-form-service-partners-page-1').attr('action',''+act_retailer+'');
			});
			/*end search form text box*/

			function getParameters() {
			  var searchString = window.location.search.substring(1)
				, params = searchString.split("&")
				, hash = {}
				;

			  for (var i = 0; i < params.length; i++) {
				var val = params[i].split("=");
				hash[unescape(val[0])] = unescape(val[1]);
			  }
			  return hash;
			}

		    
		/*top menu search form*/
			
	


		
		var srch_result_form = $('.search-results').length;
		var sd = $('form#search-form').length;

         

		if(srch_result_form ==1 || sd == 1){
			  
		  var br_url = document.location.href;
		  var src_wor_reg = eval("/OR/g");

          var search_str = br_url.match("search/node/(.*)?page");
		  if(search_str != null){
			  var search_str1 = search_str[1].replace("?", "");

			    search_str1 = search_str1.replace(src_wor_reg, "");
			}
		  else {
			  var search_str = br_url.split("search/node/");
			  var search_str1 = search_str[1].replace("?", "");
			   search_str1 = search_str1.replace(src_wor_reg, "");
			  }	
      
		  var srch_str = decodeURIComponent(search_str1).trim();
		  
		   $('input#edit-keys').val(''+srch_str+'');
  
		}
 
     /*default text in search box*/

		  $('input#edit-search-block-form--2').attr('placeholder','Search');
         $('input#edit-search-block-form--2').focus(function() {
	       $('input#edit-search-block-form--2').attr('placeholder','');
		 });
		 $('input#edit-search-block-form--2').blur(function() {
	     $('input#edit-search-block-form--2').attr('placeholder','Search');
		  });

		  /*end top menu search form*/

 /*where to buy*/
var br_url_ser = document.location.href;
var ser_part = br_url_ser.split("/");
        
if(ser_part[3] == 'partners'){
	$('li.menu-639').addClass('active');
}
if(ser_part[3] == 'sectors'){
$('li.menu-642').addClass('active');
}

if(ser_part[3] == 'products'){
$('li.menu-453').addClass('active-trail');
}

/*default select of dropdown values*/

$('select#edit-field-address-country option:contains("- Any -")').text('Region/Country');
$('select#edit-field-products-nid option:contains("- Any -")').text('Products');
$('select#edit-field-partner-tier-value option:contains("- Any -")').text('Partner tier');


	var browser_arg = getParameters();

	if(browser_arg.field_partner_tier_value != undefined && browser_arg.field_partner_tier_value != 'All'){
		var partner_text = browser_arg.field_partner_tier_value;
		var selPartner = $("#edit-field-partner-tier-value option[value='"+partner_text+"']").text();				
		$("#Partnerbox").html(selPartner);
	}

if(browser_arg.field_products_nid != undefined && browser_arg.field_products_nid != 'All'){
		var selProducts = $("#edit-field-products-nid option[value='"+browser_arg.field_products_nid+"']").text();
		$("#productsbox").html(selProducts);
	}
	


if(browser_arg.field_address_country != undefined){

/*remove default selected items*/
	if(browser_arg.field_address_country != 'All'){
		var selCountry = $("#edit-field-address-country option[value='"+browser_arg.field_address_country+"']").text();
		$("#regionbox").html(selCountry);
	}

	if(browser_arg.field_products_nid != 'All'){
		var selProducts = $("#edit-field-products-nid option[value='"+browser_arg.field_products_nid+"']").text();
		$("#productsbox").html(selProducts);
	}
	if(browser_arg.field_partner_tier_value != 'All'){
		var partner_text = browser_arg.field_partner_tier_value;
		var selPartner = $("#edit-field-partner-tier-value option[value='"+partner_text+"']").text();				
		$("#Partnerbox").html(selPartner);
	}
} else {
 var r = $("#edit-field-address-country option:selected").val();
  $('#edit-field-address-country > option[value=' + r + ']').removeAttr('selected')

	var s = $("#edit-field-products-nid option:selected").val();
   $('#edit-field-products-nid > option[value=' + s + ']').removeAttr('selected');

var t = $("#edit-field-partner-tier-value").val();
$('#edit-field-partner-tier-value > option[value=' + t + ']').removeAttr('selected');

}
       $("select#edit-field-address-country,#regionbox").change(function(){
			var selValue = $("select#edit-field-address-country option:selected").text();				
			$("#regionbox").html(selValue);
		 }); 
		 $("select#edit-field-products-nid").change(function(){
			var selValue = $("#edit-field-products-nid option:selected").text();				
			$("#productsbox").html(selValue);
		 });
		 $("select#edit-field-partner-tier-value").change(function(){
			var selValue = $("#edit-field-partner-tier-value option:selected").text();			
			$("#Partnerbox").html(selValue);
		 });
   /*start a-z listing*/
	 $('div.list-container').each(function(){
		var id = $(this).attr('id');

       var tt = $('div#'+id+' div.bottom').html();
        if(tt != null){

		var pro_tier_values = tt.replace(words, "");
			$('div#'+id+' div.bottom').html(''+pro_tier_values+'');
		   }

		var r= $('div#'+id+' li.col-1').length;
		if(r=='0'){
		$('div#'+id+' li.col-2').removeClass('col-2');
		$('div#'+id+' li').addClass('nocol1');
		}
    });
		/*end a-z listing*/
	
	/* Network Coverage Page JS start here */
	$('.inactive').click(function(){
		$('.content2').hide();
		$('.content1').show();
	})
	
	$('.inactive1').click(function(){
		$('.content2').show();
		$('.content1').hide();
	})
	
	$('#reg-sel').change(function(){
		selValue = $("#reg-sel option:selected").text();
		selId = $("#reg-sel option:selected").val();		
		//alert(selId);
		$("#region-sel").html(selValue);
		
		$('#loader').show();  
		var get_partners_url = Drupal.settings.basePath+'network_partners/'+selId;
		/*ajax*/
		$.ajax
		({
		type: "POST",
		url: get_partners_url,
		//data: dataString,
		cache: false,
		success: function(html)
		{
			$("div#partners-list").html(html);
			$('#loader').hide(); 
		}
		});
	});
	/* Network Coverage Page JS end here */		
	/*where to buy scroll bar Start here */
	
	/* where to buy scroll bar Ends here */

//for IE browser adding placeholder.js file to show the labels.
	var browserVersion = '8.0';
	if(($.browser.version == browserVersion || $.browser.version == '9.0') &&  $.browser.msie) {
       

$.fn.placeHolder = function() {  
      var input = this;
	  var vl = input.val();
	  
	  if(vl == ''){
      var text = input.attr('placeholder');  

		   if (text) input.val(text).css({ color:'grey' });
      input.focus(function(){  
        
		 input.val('');
      });
      input.blur(function(){ 
         if (input.val() == "" || input.val() === text) input.val(text).css({ color:'grey' }); 
      }); 
      input.keyup(function(){ 
        if (input.val() == "") input.val(text).css({ color:'lightGrey' }).selectRange(0,0).one('keydown', function(){
            input.val("").css({ color:'black' });
        });               
      });
      input.mouseup(function(){
        if (input.val() === text) input.selectRange(0,0); 
      });  
	 
	  }
	 
   };			

	var baspath = Drupal.settings.basePath;
	var path = baspath+"sites/all/themes/thuraya/";
	$(":input").each(function(){  									
		$(this).placeHolder();					                     
	});								
		
	$('input#edit-next').click(function () {
		$(":input").each(function(){ 							
			if ($(this).val() === $(this).attr('placeholder')){ $(this).val(''); }	
		});
	});		
     								
	}
        }
    }
    
    /* job applications */
  var jobapplications = window.location.pathname ;
  if(jobapplications == '/jobapplications'){	
	var pathArray = window.location.pathname.split( '/' );	
	var get_partners_url = Drupal.settings.basePath+'jobapplications/';
	/*ajax*/
   $.ajax
	({
	type: "POST",
	url: get_partners_url,
	//data: dataString,
	cache: false,
	success: function(data)
	{
		
	}
	}); 
   }
    
})(jQuery);

/* dc code start here for color box */ 

jQuery(function(){
	jQuery(".colorbox-inline").colorbox({
		innerWidth: '100%',
		maxWidth: '500',

    onComplete: function(){
			jQuery("#edit-submitted-buycountry").addClass('styled');
		  // Buy
      jQuery("#edit-submitted-buycountry").change(function(){      
        selValue = jQuery("#edit-submitted-buycountry option:selected").text();
        if(selValue == "- None -" || selValue == "- Select -"){
          jQuery("#countrybox-buy").html('Country*');
        } else{
          jQuery("#countrybox-buy").html(selValue);
          jQuery('#countrybox-buy').removeClass('error');
        }
      });
    }
	})
  
  jQuery("#edit-submitted-country").addClass('styled');
  
  
})

/* dc code ends here for color box */ 
