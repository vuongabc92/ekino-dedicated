/**
 * @name Site
 * @description Define global variables and functions
 * @version 1.0
 */
window.Site = (function($, window, undefined) {
  var doc = $(document),
      htmlBody = $('html, body'),
      body = $('body'),
      mobileMaxWidth = 991;

  var GlobalEvents = {
    AJAX_SUCCESS: 'load-ajax-success',
    AGEGATE_HIDDEN: 'age-gate-hidden'
  };

  var checkMobile = function() {
    return window.innerWidth <= mobileMaxWidth;
  };

  var freezeMenu = function(){
    htmlBody.addClass('freeze');
  };

  var unfreezeMenu = function(){
    var blocks = $('[data-popup]:visible, .overlay:visible');
    if (0 === blocks.length && !body.hasClass('age-gate-show')) {
      htmlBody.removeClass('freeze');
    }
  };

  var freezePage = function() {
    body.addClass('freeze');
  };

  var unfreezePage = function() {
    var blocks = $('[data-popup]:visible, .overlay:visible');
    if (0 === blocks.length && !body.hasClass('age-gate-show')) {
      body.removeClass('freeze');
    }
  };

  var checkVertical = function(imgSrc, wrapper) {
    var that = this,
        temp = new Image(),
        width, height,
        box = wrapper;
    temp.onload = function() {
      if (this.height > this.width) {
        box.addClass('vertical');
      } else {
        box.removeClass('vertical');
      }
    };
    temp.src = imgSrc;
  };

  function correctSliderPos() {
    var touchedSlide = null;
    doc.on('touchstart.setTouchedSlide', '.slick-initialized', function() {
      touchedSlide = $(this);
    })
    .on('touchend.correctSliderPos', function(e) {
      var target = $(e.target),
          isClickNextPrev = target.hasClass('slick-next') || target.hasClass('slick-prev'),
          isClickPaging = target.closest('.slick-dots').length;
      if(touchedSlide && !isClickNextPrev && !isClickPaging) {
        var slider = touchedSlide[0];
        touchedSlide = null;
        slider.slick.goTo(slider.slick.slickCurrentSlide());
      }
    });
  }

  function grayscale(src){
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var imgObj = new Image();
    imgObj.src = src;
    canvas.width = imgObj.width;
    canvas.height = imgObj.height;
    ctx.drawImage(imgObj, 0, 0);
    var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
    for(var y = 0; y < imgPixels.height; y++){
      for(var x = 0; x < imgPixels.width; x++){
        var i = (y * 4) * imgPixels.width + x * 4;
        var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
        imgPixels.data[i] = avg;
        imgPixels.data[i + 1] = avg;
        imgPixels.data[i + 2] = avg;
      }
    }
    ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
    return canvas.toDataURL();
  }

  return {
    correctSliderPos: correctSliderPos,
    grayscale: grayscale,
    isMobile: checkMobile,
    freezePage: freezePage,
    freezeMenu: freezeMenu,
    unfreezePage: unfreezePage,
    unfreezeMenu: unfreezeMenu,
    events: GlobalEvents,
    checkVertical: checkVertical
  };



})(jQuery, window);

jQuery(function($) {
  var win = $(window),
      html = $('html'),
      desktopTouchClass = 'touch-screen',
      windowTouchWidth = 1024;

  window.Site.correctSliderPos();
  win.on('load',function() {
    if($('html').hasClass('android')){
      $('.grayscale').each(function(){
        var el = $(this);
        el.addClass('img_grayscale').insertBefore(el).queue(function(){
          el.dequeue();
          el.attr('src', window.Site.grayscale(el.attr('src')));
        });
      });
    }

    $('.item.visual .image-wrap').each(function() {
      var el = $(this);
      window.Site.checkVertical(el.find('img')[0].src, el);
    });

  if (html.hasClass('tablet') && html.hasClass('windows')) {
    win.on('resize orientationchange', function() {
      if (window.innerWidth >= windowTouchWidth) {
        html.addClass(desktopTouchClass);
      } else {
        html.removeClass(desktopTouchClass);
      }
    }).trigger('resize');
  }

  });
});

/*
 * Validator.js
 *  */
(function($, Site) {

  "use strict";
  var winElm = $(window);

  /*  */
  /* MODULE DATA-API */
  /*  */
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



/**
 *  @name close-hint-agegate
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'close-hint-agegate',
      body = $('body'),
      html = $('html'),
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element,
          wrapper = ele.parent(),
          isInform = $.cookie('cookie_agree'),
          isLogin = $.cookie('mumm_age_gate');

      if (wrapper.is(':visible')) {
        win.on('resize.cookie', function() {
          body.css('padding-top', wrapper.outerHeight());
        });

        setTimeout(function() {
          win.trigger('resize.cookie');
        }, 400);
      }

      if(parseInt(isInform) === 1){
        wrapper.hide();
        body.css('padding-top', '').trigger('close-cookie-banner');
        win.off('resize.cookie');
      }

      ele.on('click.' + pluginName, function(){
        wrapper.fadeOut('slow', function() {
          body.css('padding-top', '');
          win.off('resize.cookie');
        });
        $.cookie('cookie_agree', 1, { path: '/' });
      });

    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {};

  $(function() {
    var pLegal = $('footer [data-legal]');

    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });

    if ('fr-fr' === html.attr('lang') && pLegal.length) {
      win.on('scroll', function() {
        if (win.scrollTop() + window.innerHeight > pLegal.parent().offset().top) {
          pLegal.removeClass('legal-fixed');
        } else {
          pLegal.addClass('legal-fixed');
        }
      });
    }
  });

}(jQuery, window));

/**
 *  @name custom-select
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  'use strict';

  var pluginName = 'custom-select',
    doc = $(document),
    win = $(window),
    agBlock = $('.age-gate-block'),
    BREAK_MOBILE = 992,
    nameSp;
  var Keys = {
      DOWN: 40,
      UP: 38,
      ESC: 27,
      ENTER: 13
  };
  function createUid() {
    return ('0000' + (Math.random() * Math.pow(36, 4) << 0).toString(36)).slice(-4);
  }
  function initTemplate(el, opt) {
    var dropdown = $('<div class="agegate-choose-country">' +
                    '<span class="dropdown-title">' + opt.dropdownTitle +
                    '</span>' +
                    '<input type="text" class="search-text">' +
                    '<div class="' + opt.dropdown + '">' +
                    '<dl class="group-country">' +
                    '</dl>' +
                    '</div>' +
                    '<a id="scroll-down" class="btn-scroll-down hidden-xs" href="javascript:;" title="Next"> Next' +
                    '</a>' +
                    '</div>'),
        items = [];
    var isFisrt = true,
        firstClass = '';
    el.children().each(function() {
      var optgroup = $(this);
      if(isFisrt){
        firstClass = 'first';
      }
      else {
        firstClass = '';
      }
       items.push('<dt class="optgroup '+ firstClass +'">' + optgroup.attr('label') + '</dt>');
      optgroup.children().each(function() {
        var optLev1 = $(this);
        items.push('<dd class="item-country ' + (optLev1.is(':selected') ? opt.selected : '') + '" data-value="' + optLev1.val() + '" data-age-limit="'+ optLev1.data('age-limit') + '" data-country-age="'+ optLev1.data('country-age') + '">' + optLev1.text() + '</dd>');
      });
      isFisrt = false;
    });

    return dropdown.find('.group-country')
      .html(items.join(''))
      .closest('.agegate-choose-country')
      .appendTo($('.welcome-block'));
  }

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          el = this.element,
          opt = this.options;

      nameSp  = pluginName + createUid();

      this.vars = {
        wrapper: el.closest(opt.wrapper),
        dropdown: initTemplate(el, opt),
        toggleBtn: el.siblings(opt.button),
        optionLen: null,
        idx: 0,
        isShow: false,
        isChange: false
      };

      that.searchText = el.find('.search-text');
      that.scrollDown = $('#scroll-down');
      that.ageform = $('#age-form');
      this.vars.displayText = this.vars.toggleBtn;
      that.cloneListCountry = null;
      that.currCountry = null;
      that.hiddenCountry = $('input[name="country-hidden"]');

      this.vars.toggleBtn
        .on('click.' + nameSp, function() {
          that.toggleDisplay(that.vars.isShow);
        }).on('keydown.' + nameSp, function(e){
          var idx = that.vars.idx;
          switch(e.which){
            case Keys.DOWN:
              e.preventDefault();
              that.setSelected(++idx);
              break;

            case Keys.UP:
              e.preventDefault();
              that.setSelected(--idx);
              break;

            case Keys.ESC:
              that.hideDropdown();
              break;
          }
        });

      this.vars.dropdown.on('click.' + nameSp, 'dd', function(isTrigger) {
        if(that.vars.isShow || isTrigger) {
          var elClicked = $(this),
            liTags = that.vars.dropdown.find('.item-country');

          if (!elClicked.hasClass(opt.selected)) {
            var currIdx = that.vars.idx;
            that.setSelected(liTags.index(elClicked));
            if(typeof that.options.onChangeHandle === 'function') {
              var current = el.find('option').eq(currIdx).text();
              that.options.onChangeHandle(el, current, elClicked.text());
            }
          }
          that.hideDropdown();
        }
      }).on('focusin.' + nameSp, function(){
        that.vars.toggleBtn.addClass('focus');
      }).on('focusout.' + nameSp, function(){
        that.vars.toggleBtn.removeClass('focus');
      });

      var curCountry = $.cookie('mumm_get_country') || '';
      if ('' !== curCountry) {
        var dd = that.vars.dropdown.find('dd');
        dd.each(function(idx) {
          var item = $(this),
              val = item.data('value');
          if (curCountry === val) {
            item.trigger('click.' + nameSp, [true]);
            return false;
          }
        });
      }

      el.off('change.' + nameSp).on('change.' + nameSp, function(){
        that.vars.isChange = true;
        that.setSelected(el.find('option').index(el.find(':selected')));
      }).trigger('change.' + nameSp);

      doc.on('click.' + nameSp, function(e) {
        var wrap = $(e.target).closest(that.vars.wrapper),
            groupCountry = $('dl.group-country');
        if (!wrap.length && !$(e.target).is('dt.optgroup') && !$(e.target).is('.agegate-choose-country') && !$(e.target).is('.search-text')) {
          that.hideDropdown();
        }
      });

      that.filterCountry();
      that.calAllPos();
    },
    toggleDisplay: function(isShow){
      var that = this;
      that[isShow ? 'hideDropdown' : 'showDropdown']();
    },

    showDropdown: function() {
      var that = this,
        opt = this.options,
        dropdown = this.vars.dropdown,
        toggleBtn = this.vars.toggleBtn,
        scrollPane = that.vars.dropdown.children('.dropdown-menu');

      if(!dropdown.is(':animated')) {
        dropdown
          .fadeIn(opt.duration, function(){
            if(win.width() >= BREAK_MOBILE){
              that.setHeightDropdown();
              scrollPane.jScrollPane({animateScroll: true});
            }else{
              scrollPane.jScrollPane().data('jsp').destroy();
            }
          })
          .add(toggleBtn)
          .addClass('focus');
        this.vars.isShow = true;
      }

      var api = scrollPane.jScrollPane({animateScroll: true}).data('jsp');
      that.scrollDown.on('click.' + nameSp, function () {
        api.scrollByY(scrollPane.height());
        return false;
      });

    },

    hideDropdown: function() {
      var dropdown = this.vars.dropdown,
        toggleBtn = this.vars.toggleBtn;

      if(!dropdown.is(':animated')){
        dropdown
          .fadeOut(this.options.duration)
          .add(toggleBtn)
          .removeClass('focus');
        this.vars.isShow = false;
      }
    },

    calAllPos: function(){
      var that = this,
          isShow = false,
          welBlock = $('.welcome-block');

      win.on('resize.leftCountry', function(){
        if(win.width() < BREAK_MOBILE){
          if(!that.vars.dropdown.is(':hidden')){
            isShow = true;
          }
          that.vars.dropdown.removeAttr('style');
          that.vars.dropdown.children('.dropdown-menu').jScrollPane().data('jsp').destroy();
          that.vars.dropdown.children('.dropdown-menu').removeAttr('style');
          if(isShow){
            that.vars.dropdown.show();
            isShow = false;
          }
          that.scrollDown.hide();
        }else{
          that.vars.dropdown.css({
            top: that.ageform.offset().top - parseInt(welBlock.css('margin-top')) + agBlock.scrollTop(),
            position: 'absolute',
            zIndex: 999,
            width: welBlock.width()
          });
          setTimeout(function(){
            that.setHeightDropdown();
            that.vars.dropdown.children('.dropdown-menu').jScrollPane();
          }, 50);
          that.scrollDown.show();
        }
      }).trigger('resize.leftCountry');
    },

    setHeightDropdown: function(){
      var that = this,
          welBlock = $('.welcome-block'),
          titleDrop = $('span.dropdown-title'),
          searchText = $('.search-text'),
          hwelBlock = welBlock.outerHeight(),
          moreHeight = (win.height() - welBlock.offset().top - hwelBlock)/2;
      // - titleDrop.outerHeight()
      var heightDrop = hwelBlock - (that.ageform.offset().top - welBlock.offset().top) + moreHeight,
          heightInner = heightDrop - parseInt(titleDrop.css('margin-bottom')) - that.scrollDown.outerHeight() - parseInt(that.scrollDown.css('margin-top')) -  parseInt(that.scrollDown.css('margin-bottom')) - searchText.outerHeight() - parseInt(searchText.css('margin-bottom'));

      that.vars.dropdown.css({
        height: heightDrop
      });
      that.vars.dropdown.children('.dropdown-menu').css({
        height: heightInner
      });
    },

    setSelected: function(idx, afterChange){
      if(idx !== undefined){
        var that = this,
            eleOpt = null,
            el = that.element,
            opt = that.options,
            dropdown = that.vars.dropdown,
            displayText = that.vars.displayText,
            optionLen = that.vars.dropdown.find('.item-country').length - 1;

        idx = (idx < 0) ? optionLen : (idx > optionLen ) ? 0 : idx;
        eleOpt = $('.group-country').find('dd:eq(' + idx + ')');

        if(!this.vars.isChange){
          eleOpt.prop('selected', true);
        } else {
          this.vars.isChange = false;
        }
        displayText
          .text(eleOpt.text())
          .data('age-limit', eleOpt.data('age-limit'))
          .data('country-age', eleOpt.data('country-age'));
        that.currCountry = dropdown.find('dd[data-value]:eq(' + idx + ')');
        dropdown
          .find('.' + opt.selected)
          .removeClass(opt.selected)
          .end()
          .find('dd[data-value]:eq(' + idx + ')').addClass(opt.selected);

        var eleSelect = dropdown.find('dd[data-value]:eq(' + idx + ')').addClass(opt.selected);

        that.vars.idx = idx;
        that.element.find('option').removeAttr('selected');
        // that.element.find('option:eq(' + idx + ')').attr('selected', 'selected');
        that.element.find('option').each(function(index, el) {
          var self = $(this);
          if(self.attr('value') === eleSelect.data('value')){
            self.attr('selected', 'selected');
          }
        });
        that.hiddenCountry.val(eleSelect.data('value'));

        that.showDateOfBirth(eleOpt.data('country-age'));
        that.element.trigger('afterSubmit');
        $('[data-hide-label-agegate]')['hide-label-agegate']().data('hide-label-agegate').destroy();
        $('[data-hide-label-agegate]')['hide-label-agegate']();
      }
    },
    showDateOfBirth: function(age){
      var that = this,
          country = $('[data-name=#'+ that.element.attr('id') +']'),
          date = country.find('#date').parent(),
          month = country.find('#month').parent(),
          year = country.find('#year').parent();

      switch(age){
        case "mmddyyyy":
          date.show();
          month.show();
          country.html(null).append(month).append(date).append(year);
          that.initPluginInput(country);
          break;
        case "ddmmyyyy":
          date.show();
          month.show();
          country.html(null).append(date).append(month).append(year);
          that.initPluginInput(country);
          break;
        case "yyyymmdd":
          date.show();
          month.show();
          country.html(null).append(year).append(month).append(date);
          that.initPluginInput(country);
          break;
        default:
          date.hide();
          month.hide();
          country.html(null).append(date).append(month).append(year);
          that.initPluginInput(country);
          break;
      }
      win.trigger('change-birth-input');
    },

    initPluginInput: function(country){
      var date = country.find('#date').parent(),
          month = country.find('#month').parent();

      $('[data-hide-label-agegate]')['hide-label-agegate']().data('hide-label-agegate').destroy();
      // $('[data-limit-number]')['limit-number']().data('limit-number').destroy();
      $(country, '[data-limit-number]')['limit-number']();
      $(country, '[data-hide-label-agegate]')['hide-label-agegate']();
    },

    filterCountry: function(){
      var that = this,
          groupCountry = $('dl.group-country'),
          listCountry = groupCountry.children(),
          searchTxt =  $('input.search-text'),
          groupNew = $('<div class=""></div>');

      that.cloneListCountry = groupCountry.children().clone();
      searchTxt.on('keyup', function(e){
        if(searchTxt.val() == ''){
          groupCountry.html(that.cloneListCountry);
        }else{
          groupCountry.html(null);
          groupNew.html(null);
          listCountry.each(function(idx, ele){
            var self = $(ele);
            if(self.is('dd')){
              if(self.text().toLowerCase().indexOf(searchTxt.val().toLowerCase()) > -1){
                // groupNew.append(self.prevAll('dt:first').clone());
                groupNew.append(self.clone());
              }
            }
          });
          groupCountry.html(groupNew.html());
        }
        groupCountry.children('dd').removeClass(that.options.selected);
        groupCountry.children().each(function(idx, ele){
          var self = $(ele);
          if(self.text() == that.currCountry.text()){
            self.addClass(that.options.selected);
          }
        });
        var scrollPane = that.vars.dropdown.children('.dropdown-menu');
        scrollPane.jScrollPane().data('jsp').destroy();
        // scrollPane.jScrollPane();

        if(win.width() >= BREAK_MOBILE){
          var api = $('.dropdown-menu').jScrollPane({animateScroll: true}).data('jsp');
          that.scrollDown.on('click.' + nameSp, function () {
            api.scrollByY(scrollPane.height());
            return false;
          });
          that.setHeightDropdown();
        }
        win.trigger('resize.leftCountry');
      });
    },

    destroy: function() {
      $.removeData(this.element[0], nameSp);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    wrapper: '.dropdown',
    dropdown: 'dropdown-menu',
    optGroup: 'group-select',
    button: '.dropdown-toggle',
    selected: 'selected',
    duration: 400,
    dropdownTitle: 'Select your country',
    onChangeHandle: null
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]({
      onChangeHandle: function(select, old, cur) {
        if(window.trackingManager) {
          var old = old || '',
              cur = cur || '',
              lbl = old + '-' + cur;

          select
          .attr('data-track-label', lbl)
          .data('trackLabel', lbl);
          window.trackingManager.trackData(select);
        }
      }
    });

  });

}(jQuery, window));

;(function($, window, undefined) {
  var trackingTrigger = '[data-tracking]';
  var trackingDelayTime = 500;

  /* TrackingManager CLASS DEFINITION
   *  */
  function TrackingManager() {}

  TrackingManager.prototype = {
    constructor: TrackingManager,
    track: function(e) {
      if(window.ga) {
        var elm = $(this);
        TrackingManager.prototype.trackData(elm);
        if(elm.data('tracking-leave') !== undefined){
          e.preventDefault();
          setTimeout(function(){
            window.top.location.href = elm.attr('href');
          }, trackingDelayTime);
        }
      }
    },
    trackData: function(elm) {
      if(window.ga) {
        var hitType = elm.data('track-type') || null,
            category = elm.data('track-category') || null,
            action = elm.data('track-action') || null,
            label = elm.data('track-label') || null,
            value = elm.data('track-value') || null,
            nonInteraction = {
              nonInteraction: elm.data('track-non-interaction') || false
            };

        if(hitType === 'event') {
          window.ga('send', hitType, category, action, label, value, nonInteraction);
        }
      }
    },
    trackCustomEvent: function(cat, act, lbl, val, isNonInteraction) {
      cat = typeof cat !== 'undefined' ? cat : '';
      act = typeof act !== 'undefined' ? act : '';
      lbl = typeof lbl !== 'undefined' ? lbl : '';
      val = typeof val !== 'undefined' ? val : '';
      isNonInteraction = typeof isNonInteraction !== 'undefined' ? isNonInteraction : '';

      window.ga('send', 'event', cat, act, lbl, val, isNonInteraction);
    }
  };

  /* TAGGING PLUGIN DEFINITION
   *  */
  var old = $.fn.tracking;
  $.fn.tracking = function(option) {
    return this.each(function() {
      var $this = $(this),
        data = $this.data('tracking');
      if (!data) {
        data = new TrackingManager(this);
        $this.data('tracking', data);
      }
      if (typeof option === 'string') {
        data[option].call($this);
      }
    });
  };

  $.fn.tracking.Constructor = TrackingManager;

  /* TAGGING NO CONFLICT
   *  */

  $.fn.tracking.noConflict = function() {
    $.fn.tracking = old;
    return this;
  };

  $(function() {
    window.trackingManager = new TrackingManager();
    // $(document).on('click.tracking', trackingTrigger, window.trackingManager.track);

    var inputYear = $('#year'),
        inputMonth = $('#month'),
        inputDate = $('#date');

    $(window).on('change-birth-input', function() {
      inputYear = $('#year');
      inputMonth = $('#month');
      inputDate = $('#date');

      inputYear.on('change', function() {
        if ('' !== this.value) {
          inputYear
          .attr('data-track-label', this.value)
          .data('trackLabel', this.value);
          window.trackingManager.trackData(inputYear);
        }
      });
      inputMonth.on('change', function() {
        if ('' !== this.value) {
          inputMonth
          .attr('data-track-label', this.value)
          .data('trackLabel', this.value);
          window.trackingManager.trackData(inputMonth);
        }
      });
      inputDate.on('change', function() {
        if ('' !== this.value) {
          inputDate
          .attr('data-track-label', this.value)
          .data('trackLabel', this.value);
          window.trackingManager.trackData(inputDate);
        }
      });
    }).trigger('change-birth-input');

  });
}(jQuery, window));

/**
 *  @name hide-label-agegate
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'hide-label-agegate',
      site = window.Site;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element,
          labels = ele.find('label'),
          inputs = ele.find('input'),
          currInput;
      
      inputs.each(function(){
        currInput = $(this);
        if(currInput.val() !== ''){
          labels.eq(inputs.index(currInput)).css('visibility', 'hidden');
        }
      });

      inputs.on('focus.' + pluginName, function(){
        currInput = $(this);
        labels.eq(inputs.index(currInput)).css('visibility', 'hidden');
      });

      inputs.on('blur.' + pluginName, function(){
        currInput = $(this);
        if(currInput.val() == ''){
          labels.eq(inputs.index(currInput)).removeAttr('style');
        }
      });
    },

    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        // window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {};

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name hide-label
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'hide-label',
      site = window.Site;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element,
          labels = ele.find('label'),
          inputs = ele.find('input'),
          currInput;
      
      inputs.each(function(){
        currInput = $(this);
        if(currInput.val() !== ''){
          labels.eq(inputs.index(currInput)).css('visibility', 'hidden');
        }
      });

      inputs.on('focus.' + pluginName, function(){
        currInput = $(this);
        labels.eq(inputs.index(currInput)).css('visibility', 'hidden');
      });

      inputs.on('blur.' + pluginName, function(){
        currInput = $(this);
        if(currInput.val() == ''){
          labels.eq(inputs.index(currInput)).removeAttr('style');
        }
      });
    },

    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        // window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {};

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name cover-image
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'interchange',
      win = $(window),
      BREAK_POINT1 = 768,
      BREAK_POINT2 = 992,
      width = 0;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element;

      that.listCover = ele.data('interchange');
      that.vars = {
        iscover0 : false,
        iscover1 : false,
        iscover2 : false
      };

      win.on('resize.' + pluginName, function(){
        width = win.width();
        ele.data('type') == 'background-image' ? that.initBackground(ele) : that.initImageSrc(ele);
        if(typeof that.options.afterChangeHandle === 'function') {
          that.options.afterChangeHandle();
        }
      }).trigger('resize.' + pluginName);
    },

    initBackground: function(ele){
      var that = this,
          vars = that.vars,
          listCover = that.listCover;

      if(width < BREAK_POINT2 && width >= BREAK_POINT1 && !vars.iscover1){
        ele.css('backgroundImage', 'url('+ listCover[1] +')');
        vars.iscover1 = true;
        vars.iscover0 = false;
        vars.iscover2 = false;

      }else if(width < BREAK_POINT1 && !vars.iscover2){
        ele.css('backgroundImage', 'url('+ listCover[2] +')');
        vars.iscover2 = true;
        vars.iscover1 = false;
        vars.iscover0 = false;

      }else if(width >= BREAK_POINT2 && !vars.iscover0){
        ele.css('backgroundImage', 'url('+ listCover[0] +')');
        vars.iscover0 = true;
        vars.iscover1 = false;
        vars.iscover2 = false;

      }
    },

    initImageSrc: function(ele){
      var that = this,
          vars = that.vars,
          listCover = that.listCover;

      if(width < BREAK_POINT2 && width >= BREAK_POINT1 && !vars.iscover1){
        ele.attr('src', listCover[1]);
        vars.iscover1 = true;
        vars.iscover0 = false;
        vars.iscover2 = false;

      }else if(width < BREAK_POINT1 && !that.isMobile && !vars.iscover2){
        ele.attr('src', listCover[2]);
        vars.iscover2 = true;
        vars.iscover1 = false;
        vars.iscover0 = false;

      }else if(width >= BREAK_POINT2 && !vars.iscover0){
        ele.attr('src', listCover[0]);
        vars.iscover0 = true;
        vars.iscover1 = false;
        vars.iscover2 = false;

      }
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        // window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    afterChangeHandle: null
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name limit-number
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'limit-number',
      win = $(window),
      site = window.Site;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          inputs = this.element.find('input');

      that.element.on('keyup keypress blur change', 'input', function(e) {
        //return false if not 0-9
        if (e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
      });

      inputs.each(function() {
        var self = $(this);
        self[0].oninput = function() {
          if (this.value.length >= this.maxLength) {
            this.value = this.value.slice(0, this.maxLength);
          }
        }
      });

      window.addEventListener('orientationchange', function() {
        $(':focus').blur();
      }, false);
    },

    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        // window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {

  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name render-login
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'render-login',
      wrapper = $('#wrapper'),
      win = $(window),
      site = window.Site,
      body = $('body');

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          isLogin = $.cookie('mumm_age_gate'),
          wrapper = $('#wrapper'),
          overlay = $('.overlay-agegate.black'),
          Drupal = window.Drupal ? window.Drupal : null;

      that.termCondition = window.Drupal ? Drupal.settings.mumm_age_gate.terms_conditions_link : [];

      that.ele = this.element;
      that.notAgeGate = false;
      that.initNotAgeGate();
      if(!Drupal){
        //  Code for HTML
        if(parseInt(isLogin) === 1) {
          if(typeof that.options.isLoginHandle === 'function') {
            that.options.isLoginHandle();
          }
          that.ele.addClass(that.options.hidden);
          wrapper.css({
            'height': '',
            'overflow': ''
          });
          wrapper.fadeIn('slow', function() {
            win.trigger(Site.events.AGEGATE_HIDDEN);
          });
          body.removeClass(that.options.classAgeGateShow);
          site.unfreezePage();
        }else{
          if(typeof that.options.displayAgeGateHandle === 'function') {
            that.options.displayAgeGateHandle();
          }
          overlay.removeAttr('style').show();
          that.ele.removeClass(that.options.hidden);
          overlay.removeAttr('style');
          wrapper.fadeOut('slow', function() {
            wrapper.css({
              'height': window.innerHeight,
              'overflow': 'hidden'
            });
          });
          that.initPlugin();
          body.addClass(that.options.classAgeGateShow);
          site.freezePage();
        }
      }else{
        //  Code for PHP
        if(parseInt(isLogin) === 1) {
          if(typeof that.options.isLoginHandle === 'function') {
            that.options.isLoginHandle();
          }
          that.ele.addClass(that.options.hidden);
          wrapper.attr('style', '');
          wrapper.fadeIn('slow', function() {
            win.trigger(Site.events.AGEGATE_HIDDEN);
          });
          body.removeClass(that.options.classAgeGateShow);
          site.unfreezePage();
        }else{
          if(typeof that.options.displayAgeGateHandle === 'function') {
            that.options.displayAgeGateHandle();
          }
          var frame = $('#iframe-agegate');
          overlay.removeAttr('style').show();
          body.addClass(that.options.classAgeGateShow);
          site.freezePage();
          var url = location.pathname.split('/'),
              lang = url[1],
              srcName;

          url.splice(0, 2)
          url = url.join('/');
          srcName = '/' + lang + '/age-gate?overlay=1&destination=' + url;

          frame.attr('src', srcName);

          if(that.notAgeGate || window.location.pathname.indexOf('admin') > -1 || $('body').hasClass('adminimal-menu') || window.location.pathname.indexOf('user') > -1){
            overlay.removeAttr('style');
            that.ele.addClass(that.options.hidden);
            wrapper.css({
              'height': '',
              'overflow': ''
            });
            wrapper.fadeIn('slow', function() {
              win.trigger(Site.events.AGEGATE_HIDDEN);
            });
            body.removeClass(that.options.classAgeGateShow);
            site.unfreezePage();
          }
          frame.load(function(){
            that.initNotAgeGate();
            if(parseInt($.cookie('mumm_age_gate')) !== 1 && !that.notAgeGate && window.location.pathname.indexOf('admin') < 0 && !$('body').hasClass('adminimal-menu') && window.location.pathname.indexOf('user') < 0){
              $('#age-form').attr('action', srcName);
              that.ele.removeClass(that.options.hidden);
              overlay.removeAttr('style');
              wrapper.fadeOut('slow', function() {
                wrapper.css({
                  'height': window.innerHeight,
                  'overflow': 'hidden'
                });
              });
              that.initPlugin();
              body.addClass(that.options.classAgeGateShow);
              site.freezePage();
            }
          });
        }
      }

    },

    initNotAgeGate: function(){
      var that = this;
      $.each(that.termCondition, function(index, value) {
        if(window.location.href.indexOf(that.termCondition[index]) > -1){
          that.notAgeGate = true;
          return false;
        }else{
          that.notAgeGate = false;
        }
      });
    },

    initPlugin: function(){
      var that = this;
      setTimeout(function(){
        $('[data-hide-label-agegate]')['hide-label-agegate']();
        $('[data-validator]')['validator']();
        $('[data-custom-select]')['custom-select']();
        $('[data-close-hint-agegate]')['close-hint-agegate']();
      }, 500);
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    hidden: 'hidden',
    isLoginHandle: null,
    classAgeGateShow: 'age-gate-show',
    displayAgeGateHandle: null
  };

  $(function() {

    var nua = navigator.userAgent,
        isAndroidNative = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));

    if (isAndroidNative) {
      $('html').addClass('android-native');
    }

    $('[data-' + pluginName + ']')[pluginName]({
      isLoginHandle: function() {
        var trackedBypass = $.cookie('mumm_bypass');
        if ($.cookie('mumm_passed')) {
          $.cookie('mumm_passed', false, { path: '/' });
          $.removeCookie('mumm_passed', { path: '/' });
          return;
        }

        if(window.trackingManager && !trackedBypass) {
          body
          .attr('data-track-action', 'bypass')
          .data('trackAction', 'bypass');
          trackingManager.trackData(body);

          $.cookie('mumm_bypass', true, { path: '/' });
        }
      },
      displayAgeGateHandle: function() {
        if(window.trackingManager) {
          body
          .attr('data-track-action', 'display')
          .data('trackAction', 'display');
          trackingManager.trackData(body);
        }
      }
    });
  });

}(jQuery, window));

/**
 *  @name validator
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    publicMethod
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'validator',
      site = window.Site;

  var ErrorType = {
    MISSPELLING: 'misspelling',
    FORBIDDEN: 'forbiddenAccess'
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element,
          countryAge = null,
          ageLimit = null,
          currYear = $('input[name="current-year"]').val(),
          groupInput = ele.find('.group-input'),
          classErr = that.options.error,
          Drupal = window.Drupal ? window.Drupal : null;

      var day = new Date(currYear * 1000),
          year = day.getFullYear(),
          month = day.getMonth(),
          date = day.getDate(),
          age = 0;

      that.vars = {
        errMsg : $('.error-mess'),
        errMsgTrans : $('.error-mess-trans'),
        errMsgForbid : $('.error-no-legal-age'),
        date : ele.find('#date'),
        month : ele.find('#month'),
        year : ele.find('#year')
      };

      that.vars.date.val(null);
      that.vars.month.val(null);
      that.vars.year.val(null);

      ele.on('afterSubmit', function(e){
        var btnCountry = $(e.delegateTarget).find('.btn-dropdown');
        ageLimit = btnCountry.data('age-limit');
        countryAge = btnCountry.data('country-age');
        that.validSelectCountry(ageLimit);
        that.initKeyUpYear(ageLimit, countryAge, age, year, month);
      }).trigger('afterSubmit');

      ele.bind('submit.' + pluginName, function (e) {
        !Drupal ? e.preventDefault() : null;
        var vars = that.vars,
            inDate = vars.date.is(':hidden') ? false : true,
            inMonth = vars.month.is(':hidden') ? false : true,
            curYear = parseInt(vars.year.val()),
            curMonth = parseInt(vars.month.val()) - 1,
            curDate = parseInt(vars.date.val());

        var regexNum = /^[0-9]*$/;
        age = year - parseInt(vars.year.val());

        var passValidate = function(){
          if(!Drupal){
            $.cookie('mumm_user_age', parseInt(vars.year.val()), { path: '/' });
            $.cookie('mumm_age_gate', 1, { path: '/' });
          }
          $(':focus').blur();
          groupInput.removeClass(classErr);

          if (typeof that.options.onPassedHandle === 'function') {
            that.options.onPassedHandle(groupInput);
          }

          window.parent.$('#wrapper').show();
          window.parent.$('.loading').show();
          window.parent.window.setTimeout(function(){
            window.parent.$('.loading').removeAttr('style');
            window.parent.$('[data-render-login]').hide();
            window.parent.$('[data-close-hint]').parent().show();
            $('html, body', window.parent.document).removeClass(that.options.freeze);
            // window.parent.$('html, body').removeClass(that.options.freeze);
          }, 3000);

          if(!Drupal){
            return false;
          }
        };

        if(ageLimit == -1){
          return false;
        }
        if(!curYear){
          groupInput.addClass(classErr);
          if (typeof that.options.onErrorHandle === 'function') {
            that.options.onErrorHandle(groupInput, ErrorType.MISSPELLING);
          }
          return false;
        }
        if(curYear >= 1890){
          if(regexNum.test(curYear) && age > ageLimit){
            passValidate();
          }else if(age == ageLimit && regexNum.test(curMonth) && curMonth < month && curMonth >= 0){
            passValidate();
          }else if(age == ageLimit && curMonth == month && regexNum.test(curDate) && curDate <= date && curDate > 0){
            passValidate();
          }else if(curYear >= 1890){
            groupInput.addClass(classErr);
            if (typeof that.options.onErrorHandle === 'function') {
              that.options.onErrorHandle(groupInput, ErrorType.FORBIDDEN);
            }
            return false;
          }
        }else{
          groupInput.addClass(classErr);
          if (typeof that.options.onErrorHandle === 'function') {
            that.options.onErrorHandle(groupInput, ErrorType.FORBIDDEN);
          }
          return false;
        }

      });
    },

    initKeyUpYear: function(ageLimit, countryAge, age, year, month){
      var that = this;
      that.vars.year.on('keyup.' + pluginName, function(){
        if(ageLimit !== -1){
          var vars = that.vars;
          age = year - parseInt(that.vars.year.val());
          if(countryAge !== 'ddmmyyyy' && countryAge !== 'mmddyyyy' && countryAge !== 'yyyymmdd'){
            if(age == ageLimit){
              vars.month.parent().show();
            }else{
              vars.month.parent().hide();
              vars.date.parent().hide();
              vars.month.val(null);
              vars.date.val(null);
            }
          }
        }
      });

      that.vars.month.on('keyup.' + pluginName, function(){
        var vars = that.vars;
        if(countryAge !== 'ddmmyyyy' && countryAge !== 'mmddyyyy' && countryAge !== 'yyyymmdd'){
          if(parseInt(vars.month.val()) == month + 1){
            vars.date.parent().show();
          }else{
            vars.date.parent().hide();
            vars.date.val(null);
          }
        }
      });
    },

    validSelectCountry: function(ageLimit){
      var that = this,
          errMsgTrans = that.vars.errMsgTrans,
          errMsgForbid = that.vars.errMsgForbid,
          errMsg = that.vars.errMsg;
      that.element.find('.group-input').removeClass(that.options.error);
      that.vars.date.val(null);
      that.vars.date.parent().find('label').removeAttr('style');
      that.vars.month.val(null);
      that.vars.month.parent().find('label').removeAttr('style');
      that.vars.year.val(null);
      that.vars.year.parent().find('label').removeAttr('style');

      switch(ageLimit){
        case -1:
          errMsg.text(errMsgForbid.text());
          errMsg.removeClass(that.options.hidden);
          break;
        default:
          errMsg.text(errMsgTrans.text().replace("@legal_age", ageLimit));
          errMsg.removeClass(that.options.hidden);
          break;
      }
    }

  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      } else {
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    error: 'error-agegate',
    freeze: 'freeze',
    hidden: 'hidden',
    onErrorHandle: null,
    onPassedHandle: null
  };

  $(function() {
    var trackingManager = window.trackingManager;

    $('[data-' + pluginName + ']')[pluginName]({
      onErrorHandle: function(group, errorType) {
        if (trackingManager) {
          var form = group.closest('form'),
              countryCode = form.find('#country').val(),
              yearVal = form.find('#year').val() || 'null',
              monthVal = form.find('#month').val(),
              dateVal = form.find('#date').val(),
              msg = countryCode + '-' + yearVal + '|' + errorType;

          if (monthVal) {
            var idx = (countryCode + '-').length;
            msg = msg.substring(0, idx) + monthVal + '-' + msg.substring(idx);
            if (dateVal) {
              msg = msg.substring(0, idx) + dateVal + '-' + msg.substring(idx);
            }
          }
          group
          .attr('data-track-action', 'error')
          .data('trackAction', 'error')
          .attr('data-track-label', msg)
          .data('trackLabel', msg);
          trackingManager.trackData(group);
        }
      },
      onPassedHandle: function(group) {
        if (trackingManager) {
          var form = group.closest('form'),
              yearVal = form.find('#year').val(),
              monthVal = form.find('#month').val(),
              dateVal = form.find('#date').val(),
              label = yearVal;

          if (monthVal.length) {
            label = monthVal + '-' + yearVal;
          }
          if (dateVal.length) {
            label = monthVal + '-' + dateVal + '-' + yearVal;
          }
          group
          .attr('data-track-action', 'passed')
          .data('trackAction', 'passed')
          .attr('data-track-label', label)
          .data('trackLabel', label);
          trackingManager.trackData(group);

          $.cookie('mumm_passed', true, { path: '/' });
        }
      }
    });
  });

}(jQuery, window));
