(function ($){
Drupal.behaviors.home = {
	
attach: function (context) { 
$('div').removeClass('press-list-bg');
$('.carrer-holder1').hide();
$('.show_div1').show();
$(".hline1").click(function(){
$(this).find('.ui-icon').removeClass('mini-plus').addClass('mini-minus');
$(this).parent().siblings().find('.carrer-holder1').slideUp('slow');
$(this).parent().siblings().find('.ui-icon').removeClass('mini-minus').addClass('mini-plus');
$(this).next().slideDown('slow');
})
		
          }
    }
})(jQuery);