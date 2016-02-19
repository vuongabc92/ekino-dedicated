
Drupal.behaviors.ajaxContent = {
	attach: function(context, setting) {
		$('[data-slider]').each(function() {
			$(this).slider();
		});
	}
};
  
