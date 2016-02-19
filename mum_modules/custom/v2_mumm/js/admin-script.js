Drupal.behaviors.ajaxContent = {
  attach: function(context, setting) {
    if($) {
      $(window).trigger('load-ajax-success');
    }
  }
};

if ($) {
  $(document).ready(function() {
    $(window).on('load-ajax-success', function() {
      if(Drupal.behaviors.contextualLinks &&
      $.isFunction(Drupal.behaviors.contextualLinks.attach)) {
        Drupal.behaviors.contextualLinks.attach();
      }
    });
  });
}