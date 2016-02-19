count = 0;
(function($){
	Drupal.behaviors.mobile = {
    attach: function (context) {
    	count ++;
    	
		$('#main_menu').hide();
		$width = 1000 ;
		$('#edit-submit').val('');
		$('form#search-block-form div.form-item').removeClass('form-item');

		var windowWidth;
		windowWidth = $(window).width();
		window.onorientationchange = function() {

			var orientation = window.orientation;
			var $menuWidth = '100%';
			var $mainMenuLeftPos = '70%';
			var meninMenuWidth = "30%";
		   
		    switch(orientation){
		    case 0:{
		    	$menuWidth  = '70%'
		    	$mainMenuLeftPos = '70%';	
		    	 meninMenuWidth = "30%";
		    }
		    case 90:{
		    	$menuWidth  = '60%'
		    	$mainMenuLeftPos = '60%';
		    	meninMenuWidth = "40%";
		    }
		    case -90:{
		    	$menuWidth  = '60%'
		    	$mainMenuLeftPos = '60%';
		    	meninMenuWidth = "40%";
		    	}
		    }	    
		};
		
		$("body").css({'width':'100%','overflow-x':'hidden'});
    	if(count == 1) {
		$('#btn_mainMenu').bind('click', function(e){
    		
    		//tui-menu-btn
    		
    		if(($(this).attr('data-nav') == null) || ($(this).attr('data-nav') == 'close') || ($(this).attr('data-nav') == 'undefined'))
    		{
    			$('#main_menu').show().
    			css({left:-$(window).width(), 
    				overflow:'hidden', 
    				position:'absolute',
    				top:50,
    				width:'100%'
    			})
    			.animate({left:0 },  500);
    			 $('.main-dv').css({background:'#000'});
    			
    			$('.tui-content').css({position:'relative'})
    			.animate({
    				left:'100%'
    			});
    			
    			$('.tui-page').css({background:'#000'});
    			$(this).attr('data-nav', 'open');    			
    		} else {
    			
    			$('#main_menu')
    			.css({overflow:'hidden', position:'absolute'})
    			.animate({left:-$(window).width()},  100, function(){ 
    				$(this).hide(); 
    			});
    			
    			$('.tui-content').css({position:'relative'})
    			.animate({
    				left:'0%'
    			});
    			$('.tui-page').css({background:'#fff'});
    			$(this).attr('data-nav', 'close')
    		}
    	});
    	}
		var navIcon = $('#btn_mainMenu').width();
		$('#logo').css('margin-left',navIcon/2);
	
		$('#main_items').find('li').click(function(){
			
			var count = 0; 
			var todalCount =  $('#main_items').find('li').length;
			var currentIndex = $(this).index();
			$("html").scrollTop(0);
			$('#main_items').find('li').each(function(index){
			if( $(this).attr('class').indexOf('sub') >=  'sub'  && index < currentIndex ){
				count++;	
			}									  
		});
		
		if($(this).attr('class').indexOf('sub') >= 0) {
			$('.tui-sub').css({position:'absolute', top:0, left:$width});
			$('#main_items').css({position:'relative'}).animate({left:-$width},  100);
			$('.tui-sub').show().animate({left:0}, 100);
			$('.tui-sub').find('ul').hide();
			$($('.tui-sub').find('ul')[($(this).index()-1)]).show();
		}
		 	$(document).scrollTop(0);
			
		});
		 $('.tui-sub').find('ul').each(function(){
			 $(this).find('li:first').click(function(){
				$('#main_items').css({position:'relative'}).animate({left:0}, 100);	
				$('.tui-sub').animate({left:$width}, 100, function(){ $(this).hide(); });										
			});										
		});		 
		function createLayer(){
			$html  =  '<div id="menu_layer"></div>';
			$('body').append($html);
			$('#menu_layer').css({
				background:'#000',
				'z-index':2,
				opacity:.7,
				position:'absolute',
				top:414,
				left:0,
				width:'100%',
				height:($(document).height() - 70) 
			});
		}    	
	
	}
  }
})(jQuery);