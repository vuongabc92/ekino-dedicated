(function ($){
    Drupal.behaviors.sectors = {
    attach: function (context) { 
/*new solution listing js*/
	$('#soluMenu').hide();	
	$("#soluMenuCont .header").click(function(){	
	$('#soluMenu').slideDown("slow");	
	})

var removeCl = 'comms';
	$("#soluMenu ul li a").click(function(){

	var listId = $(this).attr('id');			
		$('div#drop_dn #solMenuInCont').removeClass(removeCl).addClass('comms-' + listId);
		removeCl = 'comms-' + listId;
		$('#soluMenu').slideUp("slow");	
		$(this).parent().addClass('active').siblings().removeClass('active');
		$('div#drop_dn #solMenuInCont .logoBText').html(listId+'Comms');

	
	$('div#drop_dn #solMenuInCont a.sector_url').attr('href',Drupal.settings.basePath+listId+'-comms');

    $('#loadingmessage').show();  
	var solution_load = Drupal.settings.basePath+'sectors/'+listId+'comms';
	/*ajax*/
	$.ajax
	({
	type: "POST",
	url: solution_load,
	//data: dataString,
	cache: false,
	success: function(html)
	{
	$("div#solutionsajax").html(html);
	$('#loadingmessage').hide(); 
	} 
	});
   /*end ajax*/

	});

	$("#soluMenu #closeArrow").click(function(){		
	$('#soluMenu').slideUp("slow");	
	});

	/*end solution listing js*/
	}
	}



})(jQuery);