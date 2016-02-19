(function ($) {

    Drupal.behaviors.mumm_age_gate = {
        attach: function (context, settings) {

            /*
             * Handling fields
             */

            var form = $('#birthdate-wrapper', context);
            if (!form.length) {
                return;
            }

            var countrySelector = $('#edit-country', context);

            var yearField = $('input[name=year]', form),
                    monthField = $('input[name=month]', form),
                    dayField = $('input[name=day]', form),
                    infoField = $('#info-field'),
                    errorField = $('#error-field'),
                    changedCountry = 0,
                    year = $('.form-item-year', form),
                    month = $('.form-item-month', form),
                    day = $('.form-item-day', form),
                    fieldMandatoryFields = $('#error-mandatory-fields'),
                    fieldUnderagedFormat = $('#error-underaged-format'),
                    fieldUnderaged = $('#error-underaged'),
                    fieldNoLegalAge = $('#error-no-legal-age');

            month.hide();
            day.hide();
            fieldUnderagedFormat.hide();

            function sortByFormat() {
                var countryId,
                        strDateFormat;

                countryId = countrySelector.val();
                strDateFormat = Drupal.settings.mumm_age_gate.country_date_formats[countryId] || 'ddmmyyyy';

                switch (strDateFormat) {
                    case 'mmddyyyy':
                        day.insertAfter(month);
                        year.insertAfter(day);
                        break;
                    case 'yyyymmdd':
                        month.insertAfter(year);
                        day.insertAfter(month);
                        break;
                    default:
                        month.insertAfter(day);
                        year.insertAfter(month);
                        break;
                }


            }

            function showHideFullField() {
                var countryId = countrySelector.val();

                var isFullBirthday = Drupal.settings.mumm_age_gate.country_full_birthday[countryId];

                if (isFullBirthday && isFullBirthday === true) {
                    month.stop(true, true).fadeIn();
                    day.stop(true, true).fadeIn();

                    return true;
                }

                return false;

            }

            function showHideMonth() {
                var countryId = countrySelector.val(),
                        minimumAge = Drupal.settings.mumm_age_gate.country_ages[countryId],
                        currentAge = new Date().getFullYear() - yearField.val();

                if (currentAge == minimumAge) {
                    month.stop(true, true).fadeIn();
                } else {
                    month.stop(true, true).fadeOut();
                    day.stop(true, true).fadeOut();
                }
            }

            function showHideDay() {
                var currentMonth = new Date().getMonth() + 1,
                        ageMonth;

                if (monthField.val()[0] == '0' && monthField.val().length == 1) {
                    return;
                } else if (monthField.val()[0] == '0' && monthField.val().length == 2) {
                    ageMonth = monthField.val()[1];
                } else {
                    ageMonth = monthField.val();
                }

                if (currentMonth == ageMonth) {
                    day.stop(true, true).fadeIn();
                } else {
                    day.stop(true, true).fadeOut();
                }
            }

            function fillInfoFields() {
                var countryId = countrySelector.val(),
                        minimumAge = Drupal.settings.mumm_age_gate.country_ages[countryId],
                        hasBeenSubmitted = $('input[name=has_been_submitted]').val();

                fieldMandatoryFields.hide();
                fieldUnderaged.hide();
                fieldNoLegalAge.hide();

                if (minimumAge == -1) {
                    fieldNoLegalAge.show();
                } else {
                    if (hasBeenSubmitted == 1 && changedCountry == 0) {
                        if (yearField.val()) {
                            fieldNoLegalAge.show();
                        }
                    }
                    else {
                        var formatString = fieldUnderagedFormat.text();
                        fieldUnderaged.text(formatString.replace('@legal_age', minimumAge));
                        fieldUnderaged.show();
                    }
                }

                if (yearField.val().length == 0 && hasBeenSubmitted == 1) {
                    fieldMandatoryFields.show();
                }
            }

            function countrySelectedChanged() {
                // changedCountry = 1;
                //fillInfoFields();

                fillInfoFields();
                sortByFormat();

                if (showHideFullField() === true) {
                    return;
                }

                showHideMonth();
                showHideDay();

            }

            countrySelector.change(countrySelectedChanged);
            countrySelectedChanged();

            //countrySelector.change(showHideDay).change(showHideMonth).change(fillInfoFields);
            yearField.keyup(function () {
                if (yearField.val().length == 4) {
                    if (showHideFullField() === true) {
                        return;
                    }
                    showHideMonth();
                }
            });

            monthField.keyup(function () {
                if (monthField.val().length >= 1) {
                    if (showHideFullField() === true) {
                        return;
                    }
                    showHideDay();
                }
            });

            //showHideMonth();
            //showHideDay();


            // showHideFullField();


            (function (el) {
                if (!el.length) {
                    return;
                }

                setTimeout(function () {
                    el.addClass('loaded');
                }, 100);
            })($('.inner-age-gate', context));

            /*
             * Facebook connect
             */

            $(context).on('fb_initialized', function () {
                var connectButton = $('.fb-connect', context),
                        dialogOpen = false,
                        loggedIn = false;

                function onFbConnect(response) {
                    dialogOpen = false;

                    if (response.status === 'connected') {
                        loggedIn = true;
                        prefillUsingFbProfile();
                    }

                }

                function prefillUsingFbProfile() {
                    FB.api('/me', function (profile) {
                        if (profile.hasOwnProperty('birthday')) {
                            var birthdate = profile.birthday.match(/(\d{2})\/(\d{2})\/(\d{4})/);
                            yearField.val(birthdate[3]);
                            monthField.val(birthdate[1]);
                            dayField.val(birthdate[2]);
                        }
                    });
                }

                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        loggedIn = true;
                        connectButton.addClass('disabled');

                        prefillUsingFbProfile();
                        return;
                    }

                    connectButton.click(function (evt) {
                        evt.preventDefault();

                        if (!loggedIn && !dialogOpen) {
                            dialogOpen = true;
                            FB.login(onFbConnect, {scope: 'user_location, user_birthday'});
                        }
                    });
                });
            });
        }
    };

})(jQuery);
