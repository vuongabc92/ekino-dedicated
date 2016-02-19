	(function($) {
            
            Drupal.behaviors.associated_products = {
              attach: function (context) {
	      $("#edit-field-associated-solutions-und").attr("size","15");
		//	Scrolled by user interaction
		$('#foo2').carouFredSel({
			auto: false,
			circular: false,
			infinite: false,			
            width:'100%',
			prev: '#prev2',
			next: '#next2',
			pagination: "#pager2",
			mousewheel: true,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});
		
		$(".hover-div").hover( function() {
		//mouse over
		$(this).find('.prod-img').hide();
		$(this).find('.info-div').show();
		}, function() {
		//mouse out
		$(this).find('.prod-img').show();
		$(this).find('.info-div').hide();
		});
		
		var baspath = Drupal.settings.basePath;
		var path = baspath+"sites/all/themes/thuraya/";
		//var path="http://thuraya.stg.valuelabs.net/sites/all/themes/thuraya/"
		
		var mLeft = 0;
		var nex =0;
		var noSlides = 1;
		var imgChild = $("#moveSlider").find('li').length;
		var lWidth = $('#moveSlider').parent().width();		
		$('#moveSlider').css({"width": lWidth * imgChild});
		$('#moveSlider ul li').css({"width": lWidth});
		var thumbWidth = $('#pager ul li').width();
		var thumbLength = $('#pager ul li').length;
		var pagerWidth = (thumbWidth * thumbLength);
		$('#pager ul').css({'width':pagerWidth});
		activeSlide();
		$('#prev').css({'opacity':0.8});
		$('#pager').find('li').click(function(){
			nex = $(this).index();			
			mLeft = lWidth * $(this).index();			
			$('#moveSlider').animate({"left": -mLeft}, 1200);							
			activeSlide();
			prevDeactive();
			nextDeactive();
		})
		
		$('#next').click(function(){
			//alert("noSlides="+noSlides);
			if(noSlides+3 <= thumbLength)
			{
			nex++;
			noSlides++;
			$('#prev').html("<img src='"+path+"images/l-ar-active.png'>");
			nextDeactive();			
			pLeft = thumbWidth * 1;
			if((thumbLength > 3))
			{
				$('#pager ul').animate({"left": -pLeft}, 1200);	
			}
			}			
		})		
		$('#prev').click(function(){
			//alert("noSlides="+noSlides+" thumbLength="+thumbLength);		
			if(noSlides > 1)
			{
			nex--;
			noSlides--;	
			$('#next').html("<img src='"+path+"images/r-ar-active.png'>");
			//activeSlide();
			prevDeactive();			
			pLeft = thumbWidth * (noSlides-1);
			if((thumbLength > 3))
			{
				$('#pager ul').animate({"left": -pLeft}, 1200);	
			}
			}			
		})	
		function activeSlide(){				
			$('#pager li').each(function() {	
				$(this).hover(function(){
				
					$(this).css({'background-image':'url('+path+'images/p-hover.png)',
						'background-repeat':'no-repeat',
						'background-position':'center top',
						'background-size':'80% 100%'
					})
					$(this).find('img').css({'opacity':.1});
				}, function(){
					$(this).css({'background-image':'none',
						'background-repeat':'no-repeat',
						'background-position':'center top',
						'background-size':'80% 100%'
					})
					$(this).find('img').css({'opacity':1});
				})
				if(nex == ($(this).index()))
				{	
					$(this).css({//'background-image':'url('+path+'images/p-hover.png)',
						'background-repeat':'no-repeat',
						'background-position':'center top',
						'background-size':'80% 100%'
					})
					//$(this).find('img').css({'opacity':1});
					$(this).siblings().css({'background':'none'});					
					$(this).siblings().find('img').css({'opacity': '1'});
				}
			})
		}		
		function nextDeactive(){
			//alert("imgChild="+imgChild);
			//if(nex == ($('#pager').find('li').length - 3))
			if(noSlides > 1)
			{$('#next').html("<img src='"+path+"images/r-ar.png'>");}
			else
			{$('#next').html("<img src='"+path+"images/r-ar-active.png'>");	}
		}
		
		function prevDeactive(){			
			//if(nex === 0)
			if(noSlides == 1)
			{$('#prev').html("<img src='"+path+"images/l-ar.png'>");}
			else
			{$('#prev').html("<img src='"+path+"images/l-ar-active.png'>");}		
		}
                
            }
           }		   
	})(jQuery);