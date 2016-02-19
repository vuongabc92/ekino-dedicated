	(function ($){
    Drupal.behaviors.milestone = {
    attach: function (context) { 
	/* Corporate Milestone Page JS start here */
	//alert('milestone');
	$('#mpager').carouFredSel({
		auto: false,
		scroll  : 1,
		circular: false,
		infinite: false,			
		width:'100%',
		prev: '#prev2',
		next: '#next2',
		swipe: {
			onMouse: true,
			onTouch: true
		}
	});
	mactiveSlide();	
	function mactiveSlide(){				
		$('#mpager li').click(function() {					
				$(this).addClass('active');
				$(this).siblings().removeClass('active');					
		})
		var mYear = $('#mpager li.active').text();
		//alert(mYear);
		setMilestoneData(mYear);
	}
	
	$('#mpager').find('li').click(function(){			
		yearChange();						
	})
	
	function setMilestoneData(mYear){
		if(mYear != ""){
			$('#loader').show();  
			var get_milestone_url = Drupal.settings.basePath+'milestone/'+mYear;
			/*ajax*/
			$.ajax
			({
				type: "POST",
				url: get_milestone_url,
				//data: dataString,
				cache: false,
				success: function(html)
				{
					$("div#year-content").html(html);
					$('#loader').hide(); 
				}
			});
		}
	}
	
	function yearChange(){			
		var mYear = $('#mpager li.active').text();
		//alert(mYear);
		setMilestoneData(mYear);
		//$('#mileYear').html(mYear);		
	}
	
	/* Corporate Milestone Page JS end here */
        }
    }
})(jQuery);
