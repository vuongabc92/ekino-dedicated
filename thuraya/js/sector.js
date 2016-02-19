/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */
/*(function ($){
    Drupal.behaviors.sector = {
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
})(jQuery);*/
function showDivs(divId, tabId, nid){
	if (jQuery('#subsectors-num').val() > 0) {
		jQuery('.media-solutions').hide();
		jQuery('.'+divId).show();
		jQuery('.menu-list-sectors li').removeClass('active');
		jQuery('#'+tabId).addClass('active');
		if (jQuery('#foo'+nid).length > 0) {
			jQuery('#foo'+nid).carouFredSel({
				auto: false,
				circular: false,
				infinite: false,			
				width:'100%',
				prev: '#prev'+nid,
				next: '#next'+nid,
				pagination: "#pager"+nid,
				mousewheel: true,
				swipe: {
					onMouse: true,
					onTouch: true
				}
			});
		}
	}
}