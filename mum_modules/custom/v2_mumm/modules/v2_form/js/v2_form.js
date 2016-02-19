(function ($) {

  Drupal.behaviors.v2_form = {
    attach: function (context, settings)
    {
      if (settings.v2_form !== undefined && settings.v2_form.errors) {
        this.displayFormErrors(settings.v2_form.errors, context);
      }
    },
    displayFormErrors: function (form_errors, context)
    {
      var field_name, field_msg_element;
      for (field_name in form_errors) {
        if (form_errors.hasOwnProperty(field_name)) {
          field_msg_element = $('<p class="message-error">' + form_errors[field_name] + '</p>');
          $('[name="' + field_name + '"]', context).eq(0)
                  .closest('.webform-component')
                  .addClass('field-error')
                  .append(field_msg_element);

        }
      }
      ;
    }
  };

}(jQuery));
