(function ($){
Drupal.behaviors.home = {
	
attach: function (context) { 

	$('.left-menu').hide();
	$('.show_div').show();
	$(".faq-list h3").click(function(){
		$(this).find('.icon-r').removeClass('plus-add').addClass('minus');
		$(this).parent().siblings().find('.left-menu').slideUp('slow');
		$(this).parent().siblings().find('.icon-r').removeClass('minus').addClass('plus-add');
		$(this).next().slideDown('slow');
	})
		
          }
    }
})(jQuery);