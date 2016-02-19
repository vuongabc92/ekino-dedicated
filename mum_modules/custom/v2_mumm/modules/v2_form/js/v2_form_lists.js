(function ($) {

    Drupal.behaviors.mumm_forms_lists = {
        attach: function (context, settings) {
            var fieldsets = $('fieldset'),
                formItems = $('.form-item');

            var fieldset,
                value = '',
                key = '';

            $('#edit-submit').click(submit);

            init();

            function init() {
                $.each(fieldsets, function () {
                    fieldset = $(this);

                    // Set 'add element' link
                    var id = $(this).attr('id');
                    $(this).find('.fieldset-wrapper').append('<a href="#nogo" id="add-' + id + '-item">Add element</a>');
                    $(this).find('a').click(addFieldOnClick);

                    // Create and fill input fields with existing data
                    var hiddenField = $(this).find('.fieldset-wrapper').children('input:hidden')[0];
                    var values = hiddenField.value.split('|');

                    var i = 1;
                    $.each(values, function(objectKey, item) {
                        if (item.indexOf('@@') != -1) {
                            var element = item.split('@@');
                            key = element[0];
                            value = element[1];
                        }
                        else {
                            key = i;
                            value = item;
                        }
                        i++;
                        addField();
                    });
                });
            }

            function addFieldOnClick() {
                var wrapper = $(this).parent();
                fieldset = wrapper.parent();
                value = '';
                key = '';
                addField();
            }

            function addField() {
                var wrapper = fieldset.find('.fieldset-wrapper'),
                    inputKey,
                    inputValue;

                if (key != '') {
                    inputKey = '<input class="form-text key" type="text" value="' + key + '" size="2" maxlength="4" style="margin-right: 20px;" />';
                } else {
                    inputKey = '<input class="form-text key" type="text" value="" size="2" maxlength="2" style="margin-right: 20px;" />';
                }

                if (value != '') {
                    inputValue = '<input class="form-text value" type="text" value="' + value + '" size="60" maxlength="128" />';
                }
                else {
                    inputValue = '<input class="form-text value" type="text" value="" size="60" maxlength="128" />';
                }

                var input = '<div class="form-item form-type-textfield">' + inputKey + inputValue + '</div>';

                var link = wrapper.find('a');
                link.before(input);

                formItems = $('.form-item');
                removeMargin();
            }

            function removeMargin() {
                $.each(formItems, function () {
                    $(this).css('margin', 0);
                });
            }

            function submit() {
                $.each(fieldsets, function () {
                    var inputValues = $(this).find('.fieldset-wrapper').find('div').find('.value');
                    var values = [];

                    var i = 0;
                    $.each(inputValues, function () {
                        var value = $(this).val(),
                            key = $(this).prev('.key').val();
                        if (key == '') {
                            key = i.toString();
                        }
                        if (value.length > 0) {
                            var element = key+'@@'+value;
                            values.push(element);
                        }
                        i++;
                    });

                    var result = values.join('|');
                    var hiddenField = $(this).find('.fieldset-wrapper').children('input:hidden')[0];
                    hiddenField.value = result;
                });
            }
        }
    };

})(jQuery);