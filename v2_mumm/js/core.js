(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/* ========
 * Validator.js
 * ========= */
(function($, Site) {

  "use strict";
  var winElm = $(window);

  /* =============== */
  /* MODULE DATA-API */
  /* =============== */
  Site.Validator = {
    vars : {
      mobileMaxWidth: 768,
      layerClass : 'alert-layer',
      timeHide : 5000,
      timeWait : null,
      reEmail : /^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i,
      reString : /(([a-zA-Z]_*)+)/,
      rePass : /^[a-z0-9._%-].{7,100}$/i,
      reCode : /^[a-z0-9._%-].{5,5}$/,
      reNum : /\d/i,
      rePhone : /^(\+?|d+)?(\(\+?\d+\))?(-|\s)?\d+(-|\s)?\d+(-|\s)?\d+(-|\s)?\d+$/,
      reUrl: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i,
      notAllowChar: /[‘’“”„‚†‡‰‹›♠♣♥♦←↑→↓™!"#$%&'()*+,.\/0123456789:;<=>?@\[\\\]^`{|}~…—¡¢£¤¥¦§¨©ª«¬®¯°±²³´¶·¸¹º»¼½¾¿÷●•]/
    },
    initialize : function (options) {
      $.extend(this.vars, options);

      this.layer = $('<div id="alert-form" class="' + this.vars.layerClass + '">' + '<p class="message"></p>' + '</div>');

      $(document).unbind('mousedown.zhlayer').bind('mousedown.zhlayer', function () {
        Site.Validator.hide();
      });
    },
    show : function (element, message, offset) {
      var elm = $(element),
      offs = {
        x : 0,
        y : 0,
        w : 11,
        h : 0
      },
      elmoffs = elm.offset();

      $.extend(offs, offset);
      this.layer.css('width', 'auto').find('p.message').html(message);
      this.layer.css({
        'top' : elmoffs.top + elm.outerHeight() + offs.y,
        'left' : elmoffs.left + offs.x,
        'width' : Math.max(0, Math.min(winElm.width() - elmoffs.left + offs.x, Math.max(elm.outerWidth() - 6, this.layer.width()))) + offs.w - 15 //10 = padding left + right of layer
      });

      var tag = elm[0].tagName;
      if (tag === 'INPUT' || tag === 'TEXTAREA') {
        elm[0].select();
        elm[0].focus();
      }

      this.layer.stop(true).fadeTo(300, 1);
      this.layer.data('show', 1);

      var scrollTop = winElm.scrollTop(),
      wndHeight = winElm.height(),
      layerTop = this.layer.offset().top;

      if (layerTop < scrollTop) {
        $('html, body').stop().animate({
          scrollTop : Math.max(0, layerTop - 50)
        });
      } else if (layerTop > scrollTop + wndHeight) {
        $('html, body').stop().animate({
          scrollTop : Math.max(0, layerTop - wndHeight + 50)
        });
      }

      var that = this;
      clearInterval(this.vars.timeWait);
      this.vars.timeWait = setInterval(function () {
          Site.Validator.hide();
        }, this.vars.timeHide);
    },
    showInner : function (element, message, hCheck) {
      var elm = $(element),
          elmParent;
      if(elm.length){
        elmParent = elm.parent();
        if (elm.attr('type') === 'checkbox') {
          elmParent.addClass('error');
          elmParent.unbind('click.alter').bind('click.alter', function () {
            elmParent.removeClass('error');
          });
        } else if (elmParent[0].tagName === 'SPAN') {
          if (elm[0].tagName === 'TEXTAREA') {
            elmParent.addClass('error');
            elm.val(message);
            elm.unbind('blur.alter').unbind('focus.alter').bind('blur.alter', function () {
              if (elm.val() === '') {
                elm.val(message);
                elmParent.addClass('error');
              }
            }).bind('focus.alter', function () {
              if (elm.val() === message) {
                elm.val('');
                elmParent.removeClass('error');
              }
            });
          } else {
            elmParent.addClass('error');
            elmParent.unbind('click.alter').bind('click.alter', function () {
              elmParent.removeClass('error');
            });
          }
        } else if (elm.attr('type') === 'password') {
          elm.addClass('error');
          elm.unbind('blur.alter').unbind('focus.alter').bind('blur.alter', function () {
            if (elm.val() === '') {
              elm.addClass('error');
            } else {
              elm.removeClass('error');
            }
          }).bind('focus.alter', function () {
            if (elm.val() === '') {
              elm.val('');
              elm.removeClass('error');
            }
          });
        } else {
          if (navigator.platform === 'iPad' || window.screen.height === 768) {
            elm.addClass('error').val(message);
            elm.css('font-size', '85%');
          } else {
            elm.addClass('error').val(message);
            elm.unbind('keydown.valid').bind('keydown.valid', function () {
              if (elm.val() === message) {
                elm.val('');
                elm.removeClass('error');
              }
            });
          }
          if(elm.data('handler') === undefined) {
            elm.unbind('blur.alter').unbind('focus.alter').bind('blur.alter', function () {
              if (elm.val() === '') {
                if (navigator.platform === 'iPad') {
                  elm.addClass('error').val(message);
                  elm.css('font-size', '85%');
                } else {
                  if (!hCheck) {
                    elm.addClass('error').val(message);
                  }
                }
              }
            }).bind('focus.alter', function () {
              if (elm.val() === message || !elm.val()) {
                elm.val('');
                elm.removeClass('error');
              }
            });
          }
        }
      }
    },
    autoHideMessage: function(element, delay, duration) {
      delay = delay || 3000;
      duration = duration || 400;
      return setTimeout(function () {
        element.animate({
          opacity : 0
        }, duration, function () {
          $(this).css({
            opacity : 1,
            display : "none"
          });
        });
      }, delay);
    },
    hide : function () {
      if (this.layer.data('show')) {
        clearInterval(this.vars.timeWait);
        this.layer.stop(true).fadeTo(200, 0, function () {
          Site.Validator.layer.css('top',  - 50000);
        });
        this.layer.data('show', 0);
      }
    },
    initTextRemain : function (element, counter, limit, zalert) {
      var counterElm = $(counter),
          elmParent = element.parent();
      element.unbind('keypress.zcremain').bind('keypress.zcremain', function (e) {
        if (elmParent.hasClass('error')) {
          element.val('');
          elmParent.removeClass('error');
          counterElm.text('0/1500 ');
        }
        var code = typeof(e.charCode) !== 'undefined' ? e.charCode : e.keyCode,
        key = (code === 0) ? '' : String.fromCharCode(code);
        if (key !== '' && this.value.length >= limit) {
          Site.Validator.showInner(element, zalert);
          element.focus(function () {
            counterElm.text('0/1500 ');
          });
          return false;
        }
      })
      .unbind('keyup.zcremain').bind('keyup.zcremain', function (e) {
        var code = typeof(e.charCode) !== 'undefined' ? e.charCode : e.keyCode,
        key = (code === 0) ? '' : String.fromCharCode(code);

        if (key !== '' && this.value.length >= limit) {
          Site.Validator.showInner(element, zalert);
          element.focus(function () {
            counterElm.text('0/1500 ');
          });
          return false;
        } else {
          if (this.value.replace(/^\s+|\s+$/g, '').replace(/\s+/g, ' ') !== "") {
            counterElm.text(this.value.length + '/1500 ');
          } else {
            counterElm.text('0/1500 ');
          }
        }
      })
      .unbind('change.zcremain').bind('change.zcremain', function (e) {
        counterElm.text(this.value.length + '/1500 ');
      });
    },
    requireField : function (element, init, temptext) {
      if (element && ($.trim(element.val()).length === 0 || $.trim(element.val()) === init || $.trim(element.val()) === temptext)) {
        return false;
      }
      return true;
    },
    isValidDate : function (day, month, year) {
      var valid = true;
      day =  parseInt(day);
      month =  parseInt(month);
      year =  parseInt(year);
      var newDate = new Date(year, month - 1, day);
      if(newDate.getDate() !== day || newDate.getMonth() + 1 !== month || newDate.getFullYear() !== year){
        valid = false;
      }
      return valid;
    },
    checkConfirmPass : function (element, curpass) {
      if (element && ($.trim(element.val()) !== curpass.val())) {
        return false;
      }
      return true;
    },
    checkSelect : function (select) {
      var selectedOpt= $('option:selected', select);
      if (!selectedOpt.val() || selectedOpt.index() === 0) {
        return false;
      }
      return true;
    },
    checkCharacters : function (element, limit) {
      if (element.val().length > limit) {
        return false;
      }
      return true;
    },
    validEmail : function (element) {
      return this.vars.reEmail.test(element.val());
    },
    validPass : function (element) {
      return this.vars.rePass.test(element.val());
    },
    validUrl: function(element){
      return this.vars.reUrl.test(element.val());
    },
    resetText : function (element, init, color) {
      if (element.attr('type') === 'checkbox') {
        element.removeClass('error');
        element.parent().removeClass('checked');
      } else if (element.tagName === "SPAN") {
        element.text(init);
      } else {
        if (color) {
          element.val(init);
          element.css('color', color);
        } else {
          element.val(init);
        }
      }
      element.removeClass('error');
    },
    checkFirstLastName: function(el, holder){
      if(this.requireField(el, holder)){
        return $.trim(el.val()).length > 0 && $.trim(el.val()).length < 36 && !this.vars.notAllowChar.test(el.val());
      }
      return false;
    },
    checkCity: function(el, holder){
      if(this.requireField(el, holder)){
        return $.trim(el.val()).length > 1 && $.trim(el.val()).length < 51 && !this.vars.notAllowChar.test(el.val());
      }
      return false;
    },
    checkPhoneNumber: function(el, holder){
      return !$.trim(el.val()).length || $.trim(el.val()) === holder || /^[0-9]{5,11}$/.test(el.val());
    },
    checkCountryhasState: function(value) {
      for (var i = 0, l = Site.settings.countryHaveState.length; i < l; i++) {
        if (value === Site.settings.countryHaveState[i]) {
          return true;
        }
      }
      return false;
    },
    isMobile: function() {
      return window.Modernizr.touch && (Site.viewportWidth() <= this.vars.mobileMaxWidth) ? true : false;
    },
    validatePhoneNumber: function(selectCountryCode, handlerPhoneCountryCode, txtPhone) {
      var trimPhoneNumber = function(value) {
            value = $.trim(value);
            var firstChar = value[0];
            while (firstChar === '0') {
              value = value.replace(/^0/g, '');
              firstChar = value[0];
            }
            return value;
          },
          phoneValue = trimPhoneNumber(txtPhone.val()),
          isNullPhone = !phoneValue || phoneValue === window.L10N.valid.phone || phoneValue === window.L10N.required.phone,
          selectedValue = selectCountryCode.find('option:selected').val(),
          hasError = false;
      txtPhone.val(phoneValue);
      handlerPhoneCountryCode.removeClass('error');
      if(isNullPhone && (!selectedValue || selectedValue === '0')) {
        txtPhone.removeClass('error').val('');
      }
      else {
        if(isNullPhone) {
          Site.Validator.showInner(txtPhone, window.L10N.required.phone);
          hasError = true;
        }
        else {
          if(!Site.Validator.checkPhoneNumber(txtPhone, window.L10N.valid.phone)){
            Site.Validator.showInner(txtPhone, window.L10N.valid.phone);
            hasError = true;
          }
          else {
            if(!Site.Validator.checkSelect(selectCountryCode)) {
              Site.Validator.showInner(handlerPhoneCountryCode);
              hasError = true;
            }
          }
        }
      }
      return hasError;
    },
    initPlaceHolder: function(input) {
      var val, placeHolderVal = $.trim(input.data('placeholder') || input.attr('placeholder')) ,
          timeoutBlur;
      if($('html').hasClass('ie9') || input.data('placeholder')) {
        input.on('focus.checkPlaceHolder', function() {
          if(timeoutBlur) {
            clearTimeout(timeoutBlur);
          }
          val = $.trim(input.val());
          if(val === placeHolderVal) {
            input.val('');
          }
        }).on('blur.checkPlaceHolder', function() {
          timeoutBlur = setTimeout(function() {
            val = $.trim(input.val());
            if(!val) {
              input.val(placeHolderVal);
            }
          }, 200);
        });
      }
    },
    initDatepicker: function(input, inputHidden, timeSlotReq) {
      var listDisableDate = input.data('disable-date'),
          ajaxURL = input.data('url'),
          timeSlotRadioGroup = $('.radio-group', timeSlotReq),
          listRadio = timeSlotRadioGroup.children(),
          morning = listRadio.eq(0),
          afternoon = listRadio.eq(1),
          allday = listRadio.eq(2),
          inputMorning = $('input', morning),
          inputAfternoon = $('input', afternoon),
          inputAllday = $('input', allday),
          msgErr = $('.text-danger', timeSlotReq),
          opts = {
        showOn: 'both',
        buttonImage: input.data('img-src'),
        buttonImageOnly: true,
        dateFormat : 'dd/mm/yy',
        minDate: new Date(),
        onSelect: function(date){
          var arrayDate = date.split('/'),
              string = $.datepicker.formatDate('mm/dd/yy', new Date(arrayDate[2], (parseInt(arrayDate[1]) - 1), arrayDate[0])),
              stringDate = $.datepicker.formatDate('yy-mm-dd', new Date(arrayDate[2], (parseInt(arrayDate[1]) - 1), arrayDate[0]));
          input.removeClass('error');
          inputHidden.val(string);
          $.ajax({
            type: 'post',
            url: ajaxURL,
            data: {
              currentDate: stringDate
            },
            success: function(res) {
              if(typeof res !== 'object') {
                res = $.parseJSON(res);
              }
              timeSlotRadioGroup.show();
              listRadio.show();
              msgErr.addClass('hidden');
              if(res.un) {
                switch(res.un) {
                  case "1":
                    morning.hide();
                    afternoon.show();
                    allday.hide();
                    inputAfternoon.prop('checked', true);
                    break;
                  case "2":
                    morning.show();
                    afternoon.hide();
                    allday.hide();
                    inputMorning.prop('checked', true);
                    break;
                  case "3":
                    timeSlotRadioGroup.hide();
                    msgErr.removeClass('hidden').text(res.message);
                    break;
                }
              }
            }
          });
        }
      };
      if(listDisableDate) {
        opts.beforeShowDay = function(date) {
          var string = $.datepicker.formatDate('dd/mm/yy', date);
          return [listDisableDate.indexOf(string) === -1];
        };
      }
      input.datepicker(opts);
    }
  };

}(window.jQuery, window.Site));
/* ========
 * jquery.gray.js
 * ========= */
(function($, Site) {
  $('.grayscale').gray();
}(window.jQuery, window.Site));



},{}]},{},[1]);
