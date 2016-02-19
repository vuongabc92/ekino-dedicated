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



/*! Gray v1.4.5 https://github.com/karlhorky/gray) | MIT */
/*! Modernizr 2.8.3 (Custom Build) | MIT & BSD */
/* Build: http://modernizr.com/download/#-inlinesvg-prefixes-css_filters-svg_filters
 */
;window.Modernizr=window.Modernizr||function(a,b,c){function v(a){i.cssText=a}function w(a,b){return v(l.join(a+";")+(b||""))}function x(a,b){return typeof a===b}function y(a,b){return!!~(""+a).indexOf(b)}function z(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:x(f,"function")?f.bind(d||b):f}return!1}var d="2.8.3",e={},f=b.documentElement,g="modernizr",h=b.createElement(g),i=h.style,j,k={}.toString,l=" -webkit- -moz- -o- -ms- ".split(" "),m={svg:"http://www.w3.org/2000/svg"},n={},o={},p={},q=[],r=q.slice,s,t={}.hasOwnProperty,u;!x(t,"undefined")&&!x(t.call,"undefined")?u=function(a,b){return t.call(a,b)}:u=function(a,b){return b in a&&x(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=r.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(r.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(r.call(arguments)))};return e}),n.inlinesvg=function(){var a=b.createElement("div");return a.innerHTML="<svg/>",(a.firstChild&&a.firstChild.namespaceURI)==m.svg};for(var A in n)u(n,A)&&(s=A.toLowerCase(),e[s]=n[A](),q.push((e[s]?"":"no-")+s));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)u(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof enableClasses!="undefined"&&enableClasses&&(f.className+=" "+(b?"":"no-")+a),e[a]=b}return e},v(""),h=j=null,e._version=d,e._prefixes=l,e}(this,this.document),Modernizr.addTest("cssfilters",function(){var a=document.createElement("div");return a.style.cssText=Modernizr._prefixes.join("filter:blur(2px); "),!!a.style.length&&(document.documentMode===undefined||document.documentMode>9)}),Modernizr.addTest("svgfilters",function(){var a=!1;try{a=typeof SVGFEColorMatrixElement!==undefined&&SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE==2}catch(b){}return a});
;(function ($, window, document, undefined) {

  var pluginName = 'gray',
      html = $('html'),
      defaults = {
        fade   : false,
        classes: {
          fade: 'grayscale-fade'
        }
      },
      win = $(window);

  function Plugin (element, options) {
    var classes,
        fadeClass;

    options = options || {};

    classes = options.classes || {};
    fadeClass = classes.fade || defaults.classes.fade;
    options.fade = options.fade || element.className.indexOf(fadeClass) > -1;

    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  $.extend(Plugin.prototype, {

    init: function () {
      var that = this,
          element;
      if (!Modernizr.cssfilters &&
        Modernizr.inlinesvg &&
        Modernizr.svgfilters
      ) {
        element = $(this.element);
        this.element = element;
        setTimeout(function() {
          that.resizeEle();
        }, 100);
        if (this.cssFilterDeprecated(element) || this.settings.fade) {
          this.switchImage(element);
        }
      }
    },

    // TODO: Test a freshly made element (modernizr feature test?)
    // instead of testing the active element (fragile)
    cssFilterDeprecated: function(element) {
      return element.css('filter') === 'none';
    },

    elementType: function(element) {
      return element.prop('tagName') === 'IMG' ? 'Img' : 'Bg';
    },

    pxToNumber: function(pxString) {
      return parseInt(pxString.replace('px', ''));
    },

    getComputedStyle: function(element) {
      var computedStyle = {},
          styles        = {};

      computedStyle = window.getComputedStyle(element, null);

      for(var i = 0, length = computedStyle.length; i < length; i++) {
        var prop = computedStyle[i];
        var val = computedStyle.getPropertyValue(prop);
        styles[prop] = val;
      }

      return styles;
    },

    extractUrl: function(backgroundImage) {
      var url,
          regex;

      startRegex = /^url\(["']?/;
      endRegex   = /["']?\)$/;
      url = backgroundImage.replace(startRegex, '')
                           .replace(endRegex, '');

      return url;
    },

    positionToNegativeMargin: function(backgroundPosition) {
      var x,
          y,
          margin;

      x = backgroundPosition.match(/^(-?\d+\S+)/)[0];
      y = backgroundPosition.match(/\s(-?\d+\S+)$/)[0];

      margin = 'margin:' + y + ' 0 0 ' + x;

      return margin;
    },

    getBgSize: function(url, backgroundSize) {
      var img,
          ratio,
          defaultW,
          w,
          defaultH,
          h,
          size;

      img = new Image();
      img.src = url;

      // TODO: Break this up or simplify
      if (backgroundSize !== 'auto' && backgroundSize !== 'cover' && backgroundSize !== 'contain' && backgroundSize !== 'inherit') {
        var $element = $(this.element);

        ratio    = img.width / img.height;
        w        = parseInt((backgroundSize.match(/^(\d+)px/) || [0,0])[1]);
        h        = parseInt((backgroundSize.match(/\s(\d+)px$/) || [0,0])[1]);
        defaultW = $element.height() * ratio;
        defaultH = $element.width() / ratio;
        w        = w || defaultW;
        h        = h || defaultH;
      }

      if (w || h) {
        size = {
          width: w,
          height: h
        };
      } else {
        size = {
          width : img.width,
          height: img.height
        };
      }

      return size;
    },

    getImgParams: function(element) {
      var params = {};

      params.styles = this.getComputedStyle(element[0]);

      var padding = {
        top   : this.pxToNumber(params.styles['padding-top']),
        right : this.pxToNumber(params.styles['padding-right']),
        bottom: this.pxToNumber(params.styles['padding-bottom']),
        left  : this.pxToNumber(params.styles['padding-left'])
      };

      var borderWidth = {
        top   : this.pxToNumber(params.styles['border-top-width']),
        right : this.pxToNumber(params.styles['border-right-width']),
        bottom: this.pxToNumber(params.styles['border-bottom-width']),
        left  : this.pxToNumber(params.styles['border-left-width'])
      };

      params.image = {
        width : this.pxToNumber(params.styles.width),
        height: this.pxToNumber(params.styles.height)
      };

      params.svg = {
        url        : element[0].src,
        padding    : padding,
        borderWidth: borderWidth,
        width:
          params.image.width +
          padding.left +
          padding.right +
          borderWidth.left +
          borderWidth.right,
        height:
          params.image.height +
          padding.top +
          padding.bottom +
          borderWidth.top +
          borderWidth.bottom,
        offset: ''
      };

      return params;
    },

    getBgParams: function(element) {
      var params = {},
          url,
          position;

      url    = this.extractUrl(element.css('background-image'));
      bgSize = this.getBgSize(url, element.css('background-size'));
      offset = this.positionToNegativeMargin(element.css('background-position'));

      params.styles = this.getComputedStyle(element[0]);

      params.svg = $.extend(
        { url   : url },
        bgSize,
        { offset: offset }
      );

      params.image = {
        width : params.svg.width,
        height: params.svg.height
      };

      return params;
    },

    setStyles: function(type, styles, svg, image) {
      styles.display  = 'inline-block';
      styles.overflow =
        styles['overflow-x'] =
        styles['overflow-y'] = 'hidden';
      styles['background-image'] = 'url("' + svg.url + '")';
      styles['background-size']  = image.width + 'px ' + image.height + 'px';

      if (type === 'Img') {
        styles['background-repeat']   = 'no-repeat';
        styles['background-position'] = svg.padding.left + 'px ' + svg.padding.top + 'px';
        styles.width  = svg.width;
        styles.height = svg.height;
      }

      delete styles.filter;

      return styles;
    },

    // TODO: Run this outside of the plugin so that it's not run
    // on every element
    addSVGFilterOnce: function() {
      $body = $('body');
      if (!$body.data('plugin_' + pluginName + '_has_filter')) {
        $body.data('plugin_' + pluginName + '_has_filter', 'true')
          .append('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="0" height="0" style="position:absolute"><defs><filter id="gray"><feColorMatrix type="saturate" values="0"/></filter></defs></svg>');
      }
    },

    switchImage: function(element) {
      var type,
          params,
          classes,
          template;

      type   = this.elementType(element);
      params = this['get' + type + 'Params'](element);

      classes = this.settings.fade ? this.settings.classes.fade : '';

      template = $(
        '<div class="grayscale grayscale-replaced ' + classes + '">' +
          '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' + params.svg.width + ' ' + params.svg.height + '" width="' + params.svg.width + '" height="' + params.svg.height + '" style="' + params.svg.offset + '">' +
            '<image filter="url(&quot;#gray&quot;)" x="0" y="0" width="' + params.image.width + '" height="' + params.image.height + '" preserveAspectRatio="none" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' + params.svg.url + '" />' +
          '</svg>' +
        '</div>');

      this.template = template;
      params.styles = this.setStyles(type, params.styles, params.svg, params.image);

      // TODO: Should this really set all params or should we set only unique ones by comparing to a control element?
      template.css(params.styles);

      this.addSVGFilterOnce();
      // element.replaceWith(template);

      element.after(template).hide();
    },

    resizeEle: function() {
      var that = this,
          timeout;
      win.on('resize.' + pluginName, function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          that.template.remove();
          that.element.show();
          that.switchImage(that.element);
        }, 100);
      });
    }
  });

  $.fn[pluginName] = function (options) {
    this.each(function() {
      if (!$.data(this, 'plugin_' + pluginName)) {
        $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
      }
    });
    return this;
  };

  $(function() {
    $('img.grayscale:not(.grayscale-replaced)').each(function() {
      var img = $(this),
          temp = new Image();

      temp.onload = function() {

        if(html.hasClass('ie')) {
          setTimeout(function() {
            img[pluginName]();
          }, 500);
        } else {
          img[pluginName]();
        }
      };
      temp.src = img.prop('src');
    });

    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('.grayscale:not(.grayscale-replaced)')[pluginName]();
    });
  });

})(jQuery, window, document);

/**
 *  @name change-href
 *  @description change value contain ? to support BO
 *  @version 1.0
 *  @options
 *  @events
 *  @methods
 *    init
 *    destroy
 */

;(function($, window, undefined) {
  var pluginName = 'change-href',
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element;

      if (ele.data(pluginName)) {
        ele.attr('href', ele.data(pluginName));
      }
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));


/**
 *  @name video-frame
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
  var pluginName = 'change-locations',
      countryAge = {"af":"-1","al":"18","dz":"18","as":"21","ad":"18","ao":"18","ai":"18","aq":"18","ag":"18","ar":"18","am":"18","aw":"18","au":"18","at":"18","az":"18","bs":"18","bh":"18","bd":"-1","bb":"18","by":"18","be":"18","bz":"18","bj":"18","bm":"18","bt":"18","bo":"18","ba":"18","bw":"18","bv":"20","br":"18","bn":"-1","bg":"18","bf":"18","bi":"18","kh":"18","cm":"18","ca":"19","cv":"18","ky":"18","cf":"18","td":"18","cl":"18","cn":"18","cx":"18","cc":"18","co":"18","km":"18","cg":"18","ck":"18","cr":"18","ci":"21","hr":"18","cu":"18","cy":"18","cz":"18","dk":"18","dj":"18","dm":"18","do":"18","ec":"18","eg":"21","sv":"18","gq":"21","er":"18","ee":"18","et":"18","fo":"18","fj":"18","fi":"18","fr":"18","gf":"18","pf":"18","ga":"18","gm":"18","ge":"18","de":"18","gh":"18","gi":"18","gr":"18","gl":"18","gd":"18","gp":"18","gu":"18","gt":"18","gg":"18","gn":"18","gw":"18","gy":"18","ht":"18","hn":"18","hk":"18","hu":"18","is":"20","in":"25","id":"21","ir":"-1","iq":"-1","ie":"18","im":"18","il":"18","it":"18","jm":"18","jp":"20","je":"18","jo":"18","kz":"18","ke":"18","ki":"21","kr":"19","kw":"21","kg":"18","lv":"18","lb":"18","ls":"18","lr":"18","ly":"-1","li":"18","lt":"18","lu":"18","mo":"18","mg":"18","mw":"18","my":"18","mv":"18","ml":"18","mt":"18","mh":"18","mq":"18","mr":"18","mu":"18","yt":"18","mx":"18","md":"18","mc":"18","mn":"21","me":"18","ms":"18","ma":"18","mz":"18","mm":"18","na":"18","nr":"18","np":"18","nl":"18","an":"18","nc":"18","nz":"18","ni":"19","ne":"18","ng":"18","nu":"18","nf":"18","mp":"18","no":"20","om":"21","pk":"21","pw":"21","pa":"18","pg":"18","py":"20","pe":"18","ph":"18","pn":"18","pl":"18","pt":"18","pr":"18","qa":"-1","ro":"18","ru":"18","rw":"18","re":"18","bl":"18","sh":"18","kn":"18","lc":"18","mf":"18","pm":"18","ws":"21","sm":"18","st":"18","sa":"-1","sn":"18","rs":"18","sc":"18","sl":"18","sg":"18","sk":"18","si":"18","sb":"21","so":"18","za":"18","es":"18","lk":"21","sd":"-1","sr":"18","sj":"18","sz":"18","se":"20","ch":"18","sy":"-1","tw":"18","tj":"18","th":"20","tl":"18","tg":"18","tk":"18","to":"21","tt":"18","tn":"18","tr":"18","tm":"18","tc":"18","tv":"18","ug":"18","ua":"18","ae":"21","uk":"18","us":"21","uy":"18","uz":"20","vu":"18","ve":"18","vn":"18","vg":"18","vi":"21","wf":"18","eh":"18","ye":"-1","zm":"18","zw":"18","ax":"18"},
      site = window.Site;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          listCountry = ele.find('ul > li a'),
          listHrefCountry = listCountry.find('a'),
          isMobile = ele.data('is-mobile') == true ? true : false,
          countryList = null,
          Drupal = window.Drupal ? window.Drupal : null;

      Drupal && Drupal.settings.mumm_age_gate ? countryList = Drupal.settings.mumm_age_gate.country_ages : countryList = countryAge;
      listCountry.on('click.' + pluginName, function(e){
        var self = $(this),
            href = self.attr('href'),
            country = self.data('country-code'),
            limitAge = countryList[country];
            currYear = new Date().getFullYear();
            userAge = parseInt($.cookie('mumm_user_age'));

        if(currYear - userAge > parseInt(limitAge) || country == 'en'){
          $.cookie('mumm_user_country', country, { path: '/' });
          $.cookie('mumm_user_language', country, { path: '/' });
        }else{
          $.cookie('mumm_age_gate', 0, { path: '/' });
          $.removeCookie ('mumm_bypass', { path: '/' });
          $.removeCookie ('mumm_passed', { path: '/' });

          $.cookie('mumm_get_country', country, { path: '/' });
        }
      });
    },

    changeLocation: function(ele){
      var that = this,
          currYear = new Date().getFullYear();
          userAge = parseInt($.cookie('mumm_user_age')),
          dataAge = parseInt(ele.find('a').data('age-limit')),
          // countryAge = ele.find('a').data('country-age'),
          ageGate = $('[data-render-login]'),
          wrapper = $('#wrapper');

      if(currYear - userAge < dataAge){
        $('[data-popup').hide();
        ageGate.removeClass(that.options.hidden).removeAttr('style');
        wrapper.fadeOut('slow');
        that.initPlugin();
        site.freezePage();
        // $.cookie('mumm_age_gate', 0, { path: '/' });
      }
    },

    initPlugin: function(){
      var that = this;
      $('[data-validator]')['validator']();
      $('[data-custom-select]')['custom-select']();
      $('[data-hide-label]')['hide-label']();
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
    selected: 'selected'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name check-box
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
  var pluginName = 'check-box',
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          opt = that.options,
          listCheck = ele.find(that.options.checkBox);
      
      listCheck.on('change.' + pluginName, function(){
        listCheck.parent().removeClass(opt.active);
        $(this).parent().addClass(opt.active);
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

  $.fn[pluginName].defaults = {
    checkBox: '.radio-btn > input',
    active: 'checked'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    $('form .form-radios')[pluginName]();
    
  });

}(jQuery, window));

/**
 *  @name loaded-video
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
  var pluginName = 'loaded-video',
      win = $(window),
      html = $('html');

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
      try {
        that.element.on('loadeddata', function() {
          var self = $(this);
          self.get(0).pause();
          self.get(0).currentTime = 0;
          self.prop('muted', true);
          self.data('loadeddata', true);
        }).get(0).load();
      } catch(err) {
        that.element.trigger('errorVideo');
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
  };

  $(function() {
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {

      $('[data-slider]').find('video').on('errorVideo', function() {
        $(this).next('span').css('visibility', 'visible');
      });
      $('[data-' + pluginName + ']')[pluginName]();
    })
    .trigger(Site.events.AJAX_SUCCESS + '.' + pluginName);
  });

}(jQuery, window));

/**
 *  @name close-hint
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
  var pluginName = 'close-hint',
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
        body.css('padding-top', '');
        win.off('resize.cookie');
      }

      ele.on('click.' + pluginName, function(){
        wrapper.fadeOut('slow', function() {
          body.css('padding-top', '').trigger('close-cookie-banner');
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
 *  @name custom-select-normal
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

  var pluginName = 'custom-select-normal',
    doc = $(document),
    win = $(window),
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
    var dropdown = $('<ul class="' + opt.dropdown + '"></ul>'),
        items = [];

    el.children().each(function() {
      var optLev1 = $(this);
      items.push('<li class="' + (optLev1.is(':selected') ? opt.selected : '') + '" data-value="' + optLev1.val() + '">' + optLev1.text() + '</li>');
    });

    return dropdown
      .html(items.join(''))
      .appendTo(el.parent());
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
        optionLen: el.find('option').length - 1,
        idx: 0,
        isShow: false,
        isChange: false
      };

      this.vars.displayText = this.vars.toggleBtn;

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

      this.vars.dropdown.on('click.' + nameSp, 'li', function() {
        if(that.vars.isShow) {
          var elClicked = $(this),
            liTags = that.vars.dropdown.find('li:not(.group-select)');

          if (!elClicked.hasClass(opt.selected)) {
            that.setSelected(liTags.index(elClicked));
          }
          that.hideDropdown();
        }
      }).on('focusin.' + nameSp, function(){
        that.vars.toggleBtn.addClass('focus');
      }).on('focusout.' + nameSp, function(){
        that.vars.toggleBtn.removeClass('focus');
      });

      el.off('change.' + nameSp).on('change.' + nameSp, function(){
        that.vars.isChange = true;
        that.setSelected(el.find('option').index(el.find(':selected')));
      }).trigger('change.' + nameSp);

      doc.on('click.' + nameSp, function(e) {
        var wrap = $(e.target).closest(that.vars.wrapper);
        if (!wrap.length) {
          that.hideDropdown();
        }
      });
    },
    toggleDisplay: function(isShow){
      var that = this;
      that[isShow ? 'hideDropdown' : 'showDropdown']();
    },
    showDropdown: function() {
      var that = this,
        opt = this.options,
        dropdown = this.vars.dropdown,
        toggleBtn = this.vars.toggleBtn;

      if(!dropdown.is(':animated')) {
        dropdown
          .fadeIn(opt.duration)
          .add(toggleBtn)
          .addClass('focus');

        this.vars.isShow = true;
      }
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
    setSelected: function(idx, afterChange){
      if(idx !== undefined){
        var that = this,
            el = that.element,
            opt = that.options,
            dropdown = that.vars.dropdown,
            displayText = that.vars.displayText,
            optionLen = that.vars.optionLen,
            value;

        idx = (idx < 0) ? optionLen : (idx > optionLen ) ? 0 : idx;
        value = el.find('option:eq(' + idx + ')').val();
        if(!this.vars.isChange) {
          el.val(value).change();
        } else {
          this.vars.isChange = false;
        }

        displayText
          .text(el.find('option:eq(' + idx + ')').text());
        el.val(value);

        dropdown
          .find('.' + opt.selected)
          .removeClass(opt.selected)
          .end()
          .find('li[data-value]:eq(' + idx + ')').addClass(opt.selected);

        that.vars.idx = idx;

        if(!afterChange) {
          that.element.triggerHandler('cusAfterChange');
        }
      }
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
    dropdown: 'dropdown-menu dropdown-select',
    optGroup: 'group-select',
    button: '.dropdown-toggle',
    selected: 'selected',
    duration: 400
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/*/**
 *  @name date-picker
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
  var pluginName = 'date-picker',
      win = $(window),
      body = $('body'),
      htmlBody = $('html, body');

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          el = this.element,
          calendarIcon = $('.webform-calendar', el),
          inputEl = $('[data-date-show]', el),
          widget = inputEl.datepicker('widget'),
          currDate = new Date(),
          valDate = el.find('[data-age-day]').data('age-day'),
          valMonth = el.find('[data-age-month]').data('age-month'),
          valYear = el.find('[data-age-year]').data('age-year'),
          valYear = valYear ? valYear : currDate.getFullYear(),
          isBirth = el.parent().prop('id').indexOf('--d-o-b') !== -1 ? true : false,

          stringDate = el.find('.webform-calendar').attr('class'),
          startDate = 'webform-calendar-start-',
          idxStart = stringDate.indexOf(startDate),

          endDate = 'webform-calendar-end-',
          idxEnd = stringDate.indexOf(endDate),
          calenInput = el.find('input:last'),
          targetDatePicker = $('.ui-datepicker');
          calenInput = el.find('input:last');

      that.selectYear = el.find('select.year.form-select');
      that.selectMonth = el.find('select.month.form-select');
      that.selectDay = el.find('select.day.form-select');

      that.selectYear.val() == '' && that.selectYear.hasClass('error') ? el.parent().addClass('field-error') : null;

      calendarIcon.on('click.' + pluginName, function(e){
        e.preventDefault();
        that.initShowHide(inputEl, widget);
      });

      inputEl.find('[type="image"]').remove();
      inputEl.datepicker({
        onSelect: function(date) {
          inputEl.val(date).change();
          that.changeDate(calenInput, date);
        },
        defaultDate: isBirth && !valMonth ? new Date(valYear, currDate.getMonth(), currDate.getDate()) : null,
        minDate: new Date(stringDate.substr(idxStart + startDate.length, 10)),
        maxDate: new Date(stringDate.substr(idxEnd + endDate.length, 10))
      });

      /*star fix issue datepicker show when enter or submit form*/
      targetDatePicker.wrap('<div class="wrapper-datepicker"/>');
      that.element.closest('form').on('keydown.' + pluginName, ':input', function() {
        // fix issue datepicker show when enter or submit form
        that.element.closest('form').data('preventFocusDatePicker', true);
      });
      that.element.on('focus', 'input[type="image"]', function() {
        var formEle = that.element.closest('[data-validate]');
        if (formEle.length && formEle.data('preventFocusDatePicker')) {
          targetDatePicker.parent('.wrapper-datepicker').css('display', 'none');
          inputEl.datepicker("hide");
          setTimeout(function() {
            targetDatePicker.parent('.wrapper-datepicker').css('display', 'block');
            formEle.data('preventFocusDatePicker', false);
          }, 500);
        }
      });
      /*end fix issue datepicker show when enter or submit form*/

      // set value when label have required class
      if (el.prev('label').hasClass(that.options.classRequired) || el.find('[data-age-year]').length) {
        if ('' !== inputEl.val()) {
          var date = new Date(inputEl.val());
          inputEl.datepicker('setDate', date);
          inputEl.change();

          $('.ui-datepicker-current-day').click();
          that.selectDay.val(date.getDate());
          that.selectMonth.val(date.getMonth() + 1);
          that.selectYear.val(date.getFullYear());
        }
        else {
          var dateVal = null,
              dateFormat = inputEl.datepicker('option', 'dateFormat'),
              spliter = dateFormat[2],
              dateArr = [];

          dateFormat = dateFormat.split(spliter);
          if (!valMonth && !valDate) {
            valMonth = currDate.getMonth() + 1;
            valDate = currDate.getDate();
            inputEl.val(valYear);
          } else {
            valDate = valDate || '01';
            for (var i = 0; i < 3; i++) {
              switch(dateFormat[i]) {
                case 'yy': dateArr[i] = valYear; break;
                case 'mm': dateArr[i] = valMonth; break;
                case 'dd': dateArr[i] = valDate; break;
              }
            }
            inputEl.val(dateArr[0] + spliter + dateArr[1] + spliter + dateArr[2]);
          }
          calenInput.val(valYear + '-' + valMonth + '-' + valDate);

          that.selectYear.val(valYear);
          that.selectMonth.val(parseInt(valMonth));
          that.selectDay.val(parseInt(valDate));
        }
      }

      win.on('resize.' + pluginName, function(){
        inputEl.datepicker('hide');
      });
    },

    changeDate: function(calenInput, date){
      var that = this,
          inputEl = $('[data-date-show]', that.element),
          dateFormat = inputEl.datepicker('option', 'dateFormat'),
          spliter = dateFormat[2],
          listDate = date.split(spliter),
          dateVal,
          monthVal,
          yearVal;

      var getValue = function(i) {
        switch(dateFormat[i]) {
          case 'yy': yearVal = listDate[i]; break;
          case 'mm': monthVal = listDate[i]; break;
          case 'dd': dateVal = listDate[i]; break;
        }
      };

      dateFormat = dateFormat.split(spliter);
      for (var i = 0; i < dateFormat.length; i++) {
        getValue(i);
      }

      calenInput.val(yearVal + '-' + monthVal + '-' + dateVal);
      that.selectYear.val(parseInt(yearVal));
      that.selectMonth.val(parseInt(monthVal));
      that.selectDay.val(parseInt(dateVal));
    },

    initShowHide: function(inputEl, widget){
      var that = this;
      inputEl.datepicker(
        (widget.is(':visible')) ? 'hide' : 'show'
      );
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
    classRequired: 'required'
  };

  $(function() {
    // Disable Drupal Datepicker Behavior
    var webformCal = $('input.webform-calendar');
    if (webformCal.length) {
      webformCal.datepicker('destroy');
      webformCal.removeClass('hasDatepicker').removeAttr('id');
    }

    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name same-height
 *  @description description
 *  @version 1.0
 *  @options
 *    block
 *  @methods
 *    init
 *    destroy
 */
(function($, window) {
    'use strict';

    var pluginName = 'eqheight',
        win = $(window);

    var setHeight = function() {
        var maxHeight = 0;
        this.vars.blocks.css('height', '').each(function() {
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
        });
        this.vars.blocks.css('height', maxHeight);
    };

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var that = this,
                arrImage = $('.image-wrap img', that.element),
                count = 0,
                i, timeout;
            that.vars = {
                blocks: $(that.options.block, that.element)
            };
            function loadImage(evt)   {
              count ++;
              if (count === arrImage.length) {
                win.trigger('resize.' + pluginName);
              }
            }
            for ( i = 0; i < arrImage.length; i ++) {
              arrImage[i].onload = loadImage;
            }
            win.on('resize.' + pluginName, function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    setHeight.call(that);
                }, 500);
            }).trigger('resize.' + pluginName);
        },
        destroy: function() {
            win.off('resize.' + pluginName);
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
      }
    });
  };

    $.fn[pluginName].defaults = {
        block: '[data-block]'
    };

    $(function() {
        $('[data-' + pluginName + ']')[pluginName]();
        win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
          $('[data-' + pluginName + ']')[pluginName]();
        });
    });

}(jQuery, window));

/**
 *  @name same-height
 *  @description description
 *  @version 1.0
 *  @options
 *    block
 *  @methods
 *    init
 *    destroy
 */
(function($, window) {
    'use strict';

    var pluginName = 'eqheight-products',
        win = $(window);

    var setHeight = function(selector) {
        var that = this,
            maxHeight = 0,
            listEl = $(selector, that.element).css('height', '');

        if (0 === listEl.length) { return; }
        listEl.each(function() {
            var h = $(this).innerHeight();
            maxHeight = h > maxHeight ? h : maxHeight;
        });
        listEl.css('height', maxHeight);
    };

    function Plugin(element, options) {
        this.element = $(element);
        this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var that = this;
            if (!that.options.listElements.length) { return; }

            that.vars = {
                listSelector: that.options.listElements.split('|')
            };

            that.processHeight();
            win.on('resize.' + pluginName, function() {
                that.processHeight();
            });
        },
        processHeight: function() {
            var that = this;
            for(var i = 0; i < that.vars.listSelector.length; i=i+1) {
                setHeight.call(that, that.vars.listSelector[i]);
            }
        },
        destroy: function() {
            win.off('resize.' + pluginName);
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
      }
    });
  };

    $.fn[pluginName].defaults = {
        listElements: ''
    };

    $(function() {
        win.on(Site.events.AGEGATE_HIDDEN, function() {
            $('[data-' + pluginName + ']')[pluginName]();
        });
        win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
          $('[data-' + pluginName + ']')[pluginName]('processHeight');
        });
    });

}(jQuery, window));

/**
 *  @name filters
 *  @description description
 *  @version 1.0
 *  @options
 *  @events
 *  @methods
 *    init
 *    destroy
 */

;(function($, window, undefined) {
  var pluginName = 'filters',
      loadingEle = $('.loading'),
      win = $(window);

  var toggleContentFilter = function(ele) {
    var  that = this;
    if (ele.hasClass(that.options.classOpen)) {
      that.vars.contentFilter.slideUp(function() {
        ele.removeClass(that.options.classOpen)
          .addClass(that.options.classClose);
      });
    } else {
      that.vars.contentFilter.slideDown(function() {
        ele.removeClass(that.options.classClose)
          .addClass(that.options.classOpen);
      });
    }
  };

  var getFilterData = function(urlFilter, successCB, errCB) {
    $.ajax({
      url: urlFilter,
      dataType: 'json'
    })
    .done(function(res) {
      if ($.isFunction(successCB)) {
        successCB(res);
      }
    })
    .fail(function(err) {
      if ($.isFunction(errCB)) {
        errCB();
      }
    });
  };

  var triggerFilter = function() {
    var searchItem = window.location.search,
        valueFilter, urlFilter;
    if (searchItem.indexOf('filter') !== -1) {
      valueFilter = decodeURIComponent(searchItem.split('=')[1]);
      urlFilter = this.element.find('[data-url-filters]');

      for (var i = 0, l = urlFilter.length; i < l; i++) {
        if (urlFilter.eq(i).val().toLowerCase() === valueFilter.toLowerCase()) {

          this.vars.btnToggle.trigger('click.' + pluginName);
          urlFilter.eq(i).trigger('click.' + pluginName);
        }
      }
    }
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element;

      that.vars = {
        btnToggle: ele.find('.filter-btn'),
        numberResult: ele.find('[data-num-result]'),
        contentFilter: ele.find('[data-content-filters]'),
        resultFilter: ele.find('[data-result-filters]'),
        loadMoreEle: ele.find('[data-loadmore]')
      };
      that.vars.currentVal = that.vars.contentFilter.find('input[type="radio"]:checked').val();

      that.vars.btnToggle.on('click.' + pluginName, function(e) {
        e.preventDefault();
        toggleContentFilter.call(that, $(this));
      });

      that.vars.contentFilter.on('click.' + pluginName, 'input[type="radio"]', function() {
        var  self = $(this);

        if (self.val() !== that.vars.currentVal && self.val()) {
          // reset page for load more
          if (that.vars.loadMoreEle.length) {
            that.vars.loadMoreEle.loadmore('resetValues');
          }

          loadingEle.fadeIn(function() {
            getFilterData.call(that, self.data('url-filters'), function(res) {
              // on success
              var eqHeight, btnLoadmore;
              that.vars.currentVal = self.val();
              // that.vars.numberResult.text(res['num-items']);
              that.element.find('.inner').children('.filter-title').after(res['num-items']).remove();
              that.vars.resultFilter.empty().append(res['content']);

              if (that.vars.loadMoreEle.length) {
                that.vars.loadMoreEle.attr('data-url-loadmore', res['data-loadmore']);
                btnLoadmore = that.vars.loadMoreEle.find('[data-loadmore-trigger]');
                if (res['remain']) {
                  btnLoadmore.show(function() { btnLoadmore.css('display', 'table'); });
                } else {
                  btnLoadmore.hide();
                }
              }

              eqHeight = that.vars.resultFilter.find('[data-eqheight]');
              if (that.vars.resultFilter.get(0).hasAttribute('data-eqheight')) {
                that.vars.resultFilter['eqheight']('init');
              } else if (eqHeight.length) {
                eqHeight['eqheight']('init');
              }

              win.trigger(Site.events.AJAX_SUCCESS);

              setTimeout(function() {
                loadingEle.fadeOut();
              }, 200);
            }, function() {
              // on error
              that.vars.contentFilter
                .find('input[value="' + that.vars.currentVal + '"]').prop('checked', true);
              setTimeout(function() {
                loadingEle.fadeOut();
              }, 200);
            });
          });
        }
      });
      triggerFilter.call(that);
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    classOpen: 'open',
    classClose: 'close'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));


;(function($, window, undefined) {
  var trackingTrigger = '[data-tracking]';
  var trackingDelayTime = 500;

  /* TrackingManager CLASS DEFINITION
  */
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
    }
  };

  /* TAGGING PLUGIN DEFINITION
  */
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
  */

  $.fn.tracking.noConflict = function() {
    $.fn.tracking = old;
    return this;
  };

  $(function() {
    var trackCheckbox = $('.tracking-checkbox :checkbox');

    window.trackingManager = new TrackingManager();
    $(document).on('click.tracking', trackingTrigger, window.trackingManager.track);

    $('[data-form-tracking]').on('submit', function() {
      window.trackingManager.trackData($(this));
    });

    trackCheckbox.each(function() {
      var el = $(this),
          category = el.closest('form').data('track-category') || '';
      el.attr({
        'data-track-type': 'event',
        'data-track-category': category,
        'data-track-action': 'opt-in-' + this.value
      });
    })
    .on('click.tracking', function() {
      var el = $(this);
      el.attr('data-track-label', this.checked)
      .data('track-label', this.checked ? 'true' : 'false');
      window.trackingManager.trackData(el);
    });

  });
}(jQuery, window));
/**
 *  @name photo-gallery
 *  @description description
 *  @version 1.0
 *  @options
 *    option
 *  @events
 *    event
 *  @methods
 *    init
 *    showGallery
 *    hideGallery
 *    destroy
 */
;(function($, window, undefined) {
  var pluginName = 'photo-gallery',
      win = $(window),
      html = $('html'),
      body = $('body'),
      wrapper = $('#wrapper'),
      navigate = navigator.userAgent;

  var countText = window.Handlebars.compile('{{current}} / {{total}}'),
      grayClass = 'grayscale',
      timer;

  var notChromeMobile = function() {
    return !(navigate.indexOf('Android ') > -1 && navigate.indexOf('AppleWebKit') > -1 && navigate.indexOf('Chrome') > -1) && window.Site.isMobile();
  };

  var setLayerPosition = function() {
    var that = this,
        layerContent = that.vars.gallerySlider.closest('.popup-content'),
        left = (window.innerWidth - layerContent.outerWidth()) / 2,
        top = (window.innerHeight - layerContent.outerHeight()) / 2;

    if (top < 0) {
      top = 0;
      that.vars.galleryPopup.css('overflow-y', 'auto');
    } else {
      that.vars.galleryPopup.css('overflow-y', '');
    }
    layerContent.css({
      'left': left,
      'top': top
    });
  };

  var disableScrollBackground = function() {
    var heightScreen = win.height();
    this.vars.scrollTop = win.scrollTop();

    wrapper.css({
      'height': heightScreen + this.vars.scrollTop,
      'overflow': 'hidden',
      'margin-top': -this.vars.scrollTop
    });
  };

  var destroyScrollBackground = function() {
    wrapper.css({'height': '', 'overflow': '', 'margin-top': ''});
    win.scrollTop(this.vars.scrollTop);
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
      that.vars = {
        thumbItem: $(that.options.thumItemSel, that.element),
        galleryPopup: $(that.options.popupSel, that.element),
        gallerySlider: $(that.options.sliderSel, that.element),
        content: $(that.options.popupContentSel, that.element),
        countBlock: $('[data-count-item]', that.element),
        overlay: $(that.options.overlaySel),
        isShown: false
      };

      that.vars.galleryPopup.appendTo(body);
      that.hideGallery(true);

      that.vars.gallerySlider
      .on('init', function(event, slick) {
        that.vars.countBlock.text(countText({
          current: 1,
          total: slick.slideCount
        }));
      })
      .on('afterChange', function(event, slick, currentSlide) {
        that.vars.countBlock.text(countText({
          current: currentSlide + 1,
          total: slick.slideCount
        }));
        win.triggerHandler('resize.' + pluginName);
      })
      .slick({
        adaptiveHeight: true
      });

      win.on('resize.' + pluginName + ' orientationchange.' + pluginName, function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
          setLayerPosition.call(that);
          if (that.vars.isShown) {
            wrapper.css('height', win.height() + that.vars.scrollTop);
          }
        }, 200);
      }).trigger('resize.' + pluginName);

      that.vars.thumbItem
      .on('click.' + pluginName, function() {
        that.showGallery($(this).index());
      })
      .find('img')
      .on('mouseover.' + pluginName, function() {
        if (html.hasClass('desktop')) {
          $(this).removeClass(grayClass);
        }
      })
      .on('mouseout.' + pluginName, function() {
        if (html.hasClass('desktop')) {
          $(this).addClass(grayClass);
        }
      })
      .end()
      .on('mouseenter.' + pluginName, function() {
        if (html.hasClass('desktop') && html.hasClass('ie') && !html.hasClass('ie9')) {
          $(this).find('img.grayscale')
            .addClass('img-clone').show();
        }
      })
      .on('mouseleave.' + pluginName, function() {
        if (html.hasClass('desktop') && html.hasClass('ie') && !html.hasClass('ie9')) {
          $(this).find('img.grayscale')
            .removeClass('img-clone').hide();
        }
      });

      body.on('click.' + pluginName + ' touchstart.' + pluginName, function(e) {
        if (that.vars.isShown && !$.contains(that.vars.content[0], e.target)) {
          that.hideGallery();
        }
      });
      that.vars.overlay.on('click.' + pluginName + ' touchstart.' + pluginName, function() {
        that.hideGallery();
      });
    },
    showGallery: function(index) {
      var that = this;
      if (that.vars.galleryPopup.is(':animated')) {
        return;
      }
      that.vars.overlay.fadeIn(function() {
        Site.freezePage();
        disableScrollBackground.call(that);
      });

      index = typeof index === 'undefined' ? 0 : index;
      that.vars.gallerySlider.slick('slickGoTo', index);
      that.vars.galleryPopup
      .css({
        opacity: 0,
        visibility: 'visible'
      })
      .animate({
        opacity: 1
      });

      that.vars.isShown = true;
    },
    hideGallery: function(isFlash) {
      var that = this;
      if (that.vars.galleryPopup.is(':animated')) {
        return;
      }
      if (isFlash) {
        that.vars.galleryPopup.css({
          opacity: 0,
          visibility: 'hidden'
        });
        return;
      }

      var that = that;
      that.vars.overlay.fadeOut(function() {
        Site.unfreezePage();
        destroyScrollBackground.call(that);
      });
      that.vars.galleryPopup.css('opacity', 1)
      .animate({
        opacity: 0
      }, function() {
        that.vars.galleryPopup.css('visibility', 'hidden');
      });

      that.vars.isShown = false;
    },
    destroy: function() {

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
    thumItemSel: '.gallery li',
    popupSel: '[data-gallery-popup]',
    popupContentSel: '.popup-content',
    sliderSel: '[data-gallery-slider]',
    overlaySel: '.overlay.black'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name geocode-map
 *  @description to support BO. (on panel and back office)
 *  @version 1.0
 *  @options
 *  @events
 *  @methods
 *    init
 *    destroy
 */

;(function($, window, undefined) {
  var pluginName = 'geocode-map',
      google = window.google,
      win = $(window),
      urlGeocode = 'https://maps.googleapis.com/maps/api/geocode/json?address=';

  var initMap = function() {
    var that = this,
        optMap = {
          center: {lat: 48.856614, lng: 2.352222},
          zoom: 2,
          mapTypeId: window.google.maps.MapTypeId.ROADMAP
        };
    that.vars.map = new window.google.maps.Map(that.element.find('.map').get(0), optMap);
    window.google.maps.event.addListener(that.vars.map, 'click', function(e) {
      getFullLocation.call(that, e.latLng);
      drawMarker.call(that, e.latLng.lat(), e.latLng.lng());
      that.vars.map.panTo(e.latLng);
    });
  };

  var drawMarker = function(lat, lng) {
    var that = this;

    if (that.vars.marker) {
      clearLocationMarker.call(that);
    }

    that.vars.marker = new window.google.maps.Marker({
      draggable: true,
      animation: window.google.maps.Animation.DROP,
      position: new window.google.maps.LatLng(lat, lng)
    });
    that.vars.marker.setMap(that.vars.map);
    window.google.maps.event.addListener(that.vars.marker, 'dragend', function() {
      getFullLocation.call(that, that.vars.marker.getPosition());
    });
  };

  var getGeocode = function(address, successCB, errorCB) {
    if (address) {
      $.ajax({
        url: urlGeocode + address.trim().replace(/\s/g, '+'),
        dataType: 'json'
      })
      .done(function(response) {
        if ($.isFunction(successCB)) {
          successCB(response);
        }
      })
      .fail(function(error) {
        if ($.isFunction(errorCB)) {
          successCB(error);
        }
      });
    }
  };

  var getFullLocation = function(position) {
    var that = this;
    // get address from lat & long
    getAddress(position, function(result) {
      that.vars.addressIpt.val(result.formatted_address);

      // show latitude
      that.vars.latText.val(that.vars.marker.getPosition().lat());

      // show longitude
      that.vars.lngText.val(that.vars.marker.getPosition().lng());
    });
  };

  var getAddress = function(latLngObj, successCB) {
      if (latLngObj) {
        var geocoder = new window.google.maps.Geocoder();

        geocoder.geocode({ 'latLng': latLngObj }, function (results, status) {
          if (status == window.google.maps.GeocoderStatus.OK) {
            if (results[1] && $.isFunction(successCB)) {
              successCB(results[1]);
            }
          }
        });
      }
  };

  var clearLocationMarker = function() {
    this.vars.latText.val('');
    this.vars.lngText.val('');
    this.vars.marker.setMap(null);
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          currAddress;

      that.vars = {
        map: null,
        addressCoords: ele.data('address-coords'),
        addressIpt: ele.find('.address-input'),
        latText: ele.find('.latitude'),
        lngText: ele.find('.longitude'),
        marker: null
      };

      initMap.call(that);

      if (that.vars.addressCoords.address &&
          that.vars.addressCoords.lat &&
          that.vars.addressCoords.lng) {

        that.vars.addressIpt.val(that.vars.addressCoords.address);
        drawMarker.call(that, that.vars.addressCoords.lat, that.vars.addressCoords.lng);
        that.vars.latText.val(that.vars.addressCoords.lat);
        that.vars.lngText.val(that.vars.addressCoords.lng);
      }

      that.vars.addressIpt.on('keyup.' + pluginName + ' keypress.' + pluginName, function(e) {
        if (!$(this).val()) {
          clearLocationMarker.call(that);
        }

        if (e.keyCode === 13 || e.which === 13) {
          e.preventDefault();
          e.stopPropagation();
          that.element.find('.btn-get-location').trigger('click.' + pluginName);
          return false;
        }
      });

      that.element.on('click.' + pluginName, '.btn-get-location', function() {
        currAddress = that.vars.addressIpt.val();
        if (!currAddress) return;
        getGeocode(currAddress, function(res) {
          var location = res.results[0].geometry.location;
          drawMarker.call(that, location.lat, location.lng);
          that.vars.latText.val(location.lat);
          that.vars.lngText.val(location.lng);
          that.vars.map.panTo(that.vars.marker.getPosition());
        });
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name hide-label-mobile
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
  var pluginName = 'hide-label-mobile',
      BREAK_POINT = 992,
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
          ele = that.element;

      that.listInput = ele.find('.form-item > input');
      that.listLabel = ele.find('.form-item > label');
      that.lisAretxt = ele.find('.form-item textarea');

      win.on('resize.' + pluginName, function(){
        win.width() < BREAK_POINT ? that.initHideLabel() : that.offHideLabel();    
      }).trigger('resize.' + pluginName);
    },

    initHideLabel: function(){
      var that = this;

      that.listLabel.each(function(index, el) {
        var self = $(this);
        self.siblings('input').val() ? self.hide() : null;
      });

      that.lisAretxt.each(function(index, el) {
        var self = $(this);
        self.parent().find('textarea').val() ? self.closest('.form-item').find('label').hide() : null;
      });

      that.listInput.on('focus.' + pluginName, function(){
        var self = $(this);
        self.parent().find('label').hide();
      }).on('blur.' + pluginName, function(){
        var self = $(this);
        !self.val() ? self.parent().find('label').show() : null;
      });

      that.lisAretxt.on('focus.' + pluginName, function(){
        var self = $(this);
        self.closest('.form-item').find('label').hide();
      }).on('blur.' + pluginName, function(){
        var self = $(this);
        !self.val() ? self.closest('.form-item').find('label').show() : null;
      });
    },

    offHideLabel: function(){
      var that = this;
      that.listLabel.removeAttr('style');
      that.listInput.off('focus.' + pluginName).off('blur.' + pluginName); 
      that.lisAretxt.off('focus.' + pluginName).off('blur.' + pluginName); 
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
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });

    var searchInput = $('[data-search-input]');
    searchInput.on('change', function() {
      var val = this.value;
      searchInput.val(val).each(function() {
        if (val.length) {
          $(this).siblings('label').css('visibility', 'hidden');
        } else {
          $(this).siblings('label').removeAttr('style');
        }
      });
    });
  });

}(jQuery, window));

/**
 *  @name close-hint
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
  var pluginName = 'rollover',
      win = $(window),
      html = $('html');

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          elements = this.element;
      elements.each(function(){
        var el = $(this),
            visual = el.find('.visual'),
            img = el.find('img');
        visual.on('mouseenter.' + pluginName, function(){
          if (html.hasClass('desktop')) {
            img.addClass('grayscale');
          }
        }).on('mouseleave.' + pluginName, function(){
          if (html.hasClass('desktop')) {
            img.removeClass('grayscale');
          }
        });
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
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
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

  $.fn[pluginName].defaults = {};

  $(function() {
    var opt = {
      afterChangeHandle: function() {
        $('.item.visual .image-wrap').each(function() {
          var el = $(this);
          window.Site.checkVertical(el.find('img')[0].src, el);
        });
      }
    };
    $('[data-' + pluginName + ']')[pluginName](opt);
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName](opt);
    });
  });

}(jQuery, window));

/**
 *  @name loadmore
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
  var pluginName = 'loadmore',
      win = $(window),
      loadingEle = $('.loading');

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          closestFilters = that.element.closest('[data-filters]'),
          timeout;
      that.vars = {
        group: $(that.options.listWrapper, that.element),
        trigger: $(that.options.loadmoreTrigger, that.element),
        page: 0,
        endLoad: false   // not have data to load more for autoload (ended data)
      };
      that.vars.numResult = closestFilters.length ?
                              closestFilters.find('[data-num-result]') :
                              that.element.find('[data-num-result]');

      if (0 === that.vars.group.length || 0 === that.options.urlLoadmore.length) {
        return;
      }

      that.vars.trigger.on('click.' + pluginName, function(e) {
        e.preventDefault();
        var button = that.vars.trigger,
            link = that.element.attr('data-url-loadmore');

        if (!link.length || that.vars.endLoad || loadingEle.is(':visible')) { return; }
        loadingEle.fadeIn(function() {
          button.addClass(that.options.classLoading);
          that.vars.page = that.vars.page + 1;
          $.ajax({
            url: link,
            dataType: 'json',
            data: { page: that.vars.page },
            success: function(response) {
              var items, closestCtLink,
                  numItemsBefore = that.vars.group.children().length;
              if (response.status != 'ok') {
                that.vars.page = that.vars.page - 1;
                return;
              }
              if (response.content.length > 0) {
                items = $(response.content.join(''));
                items
                  .css('opacity', 0)
                  .appendTo(that.vars.group)
                  .animate({ 'opacity': 1 });

              }
              if (0 === response.remain) {
                that.vars.trigger.hide();
                closestCtLink = that.vars.trigger.closest('.contextual-link-resource');
                if (closestCtLink.length) {
                  closestCtLink.hide();
                }
                if (that.element.data('autoload-mobile')) {
                  that.vars.endLoad = true;
                }
              }
              that.vars.trigger.removeClass(that.options.classLoading);

              setTimeout(function() {
                if (items.filter('[data-eqheight]').length) {
                  items.filter('[data-eqheight]')['eqheight']('init');
                }

                loadingEle.fadeOut();
              }, 300);

              that.element.trigger('addContextualLinks', [{
                'pathLink': response['pathLink'],
                'lenContent': response.content.length,
                'numItemsBefore': numItemsBefore,
                'groupContent': that.vars.group
              }]);

              win.trigger(Site.events.AJAX_SUCCESS);
            },
            error: function() {
              that.vars.page = that.vars.page - 1;
              that.vars.trigger.removeClass(that.options.classLoading);
              loadingEle.fadeOut();
            }
          });
        });
      });

      win.on('scroll.' + pluginName, function() {
        if (window.Site.isMobile() && that.element.data('autoload-mobile')) {
          var scrollTop = win.scrollTop(),
              group = that.vars.group;
          if (scrollTop > group.offset().top + group.height() - group.children().height()) {
            that.vars.trigger.triggerHandler('click.' + pluginName);
          }
        }
      });
    },
    resetValues: function() {
      this.vars.page = 0;
      this.vars.endLoad = false;
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
    listWrapper: '',
    urlLoadmore: '',
    classLoading: 'loading-animated',
    loadmoreTrigger: '[data-loadmore-trigger]'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });

    // support BO add contextual Link.
    $('[data-' + pluginName + ']').on('addContextualLinks', function(evt, obj) {
      if (typeof Drupal !== 'undefined') {
        if(Drupal.behaviors.contextualLinks &&
            $.isFunction(Drupal.behaviors.contextualLinks.attach)) {

            Drupal.behaviors.contextualLinks.attach();

            setTimeout(function() {
              if (obj.pathLink && obj.lenContent) {
                obj.groupContent.children(':gt(' + (obj.numItemsBefore - 1) + ')')
                  .find('.node-edit').children('a')
                    .attr('href', obj.pathLink);
              }
            }, 500);
        }
      }
    });
  });

}(jQuery, window));

/**
 *  @name gmap
 *  @description description
 *  @version 1.0
 *  @options
      address,
      start
 *  @events

 *  @methods
 *    init
 *    destroy
 */

;(function($, window, undefined) {
  var pluginName = 'gmap',
      win = $(window);

  var mapsInitialize = function () {
    var that = this,
        marker, centerPoint, mapOptions,
        styles = [
         {
          "featureType": "road.highway",
          "elementType": "geometry",
          "stylers": [
            { "saturation": -100 },
            { "lightness": -8 },
            { "gamma": 1.18 }
          ]
          }, {
              "featureType": "road.arterial",
              "elementType": "geometry",
              "stylers": [
                { "saturation": -100 },
                { "gamma": 1 },
                { "lightness": -24 }
              ]
          }, {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "administrative",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "transit",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "water",
              "elementType": "geometry.fill",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "road",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "administrative",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "landscape",
              "stylers": [
                { "saturation": -100 }
              ]
          }, {
              "featureType": "poi",
              "stylers": [
                { "saturation": -100 }
              ]
          }
        ];

      centerPoint = new google.maps.LatLng(that.vars.lat, that.vars.lng);
      mapOptions = {
        center: centerPoint,
        zoom: 17,
        mapTypeIds: google.maps.MapTypeId.ROADMAP,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.LARGE
        },
        styles: styles
      };
      that.vars.map = new google.maps.Map(that.element.get(0), mapOptions);
      that.vars.centerPoint = centerPoint;

      marker = new google.maps.Marker({
        position: centerPoint,
        icon: that.element.data('icon-marker') || ''
      });

      marker.setMap(that.vars.map);

      google.maps.event.addListenerOnce(that.vars.map, "idle", function() {
        that.vars.map.panTo(centerPoint);
      });

      $(window).on('resize.setOptions' + pluginName, function() {
        that.resizeMap();
      }).triggerHandler('resize.setOptions');

      that.vars.map.addListener('click', function() {
        openMapOnTab.call(that);
      });
      google.maps.event.addListener(marker, 'click', function() {
        openMapOnTab.call(that);
      });
  };

  var openMapOnTab = function() {
    window.open('http://maps.google.com/?q=' + this.vars.lat + ',' + this.vars.lng, '_blank');
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element;

      if (!window.google.maps) { return; }

      that.vars = {
        lat: ele.data('lat'),
        lng: ele.data('long'),
        deskOpts: {panControl: true, zoomControl: true, streetViewControl: true},
        mobileOpts: {panControl: false, zoomControl: false, streetViewControl: false}
      };
      mapsInitialize.call(that);

    },
    resizeMap: function() {
      window.google.maps.event.trigger(this.vars.map, 'resize');
      this.vars.map.panTo(this.vars.centerPoint);
      if(this.element.width() < 768){
        this.vars.map.setOptions(this.vars.mobileOpts);
      }else {
        this.vars.map.setOptions(this.vars.deskOpts);
      }
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();

    window.google.maps.event.addDomListener(window, 'load', function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });

    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));


/**
 *  @name multi-column
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
  var pluginName = 'multi-columns',
      win = $(window),
      html = $('html'),
      BREAK_POINT = 991,
      timer;

  var groupTemplate = '<div class="column"></div>';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
      that.vars = {
        groups: [],
        isSplited: false
      };

      if (!html.hasClass('ie9')) { return; }
      win.on('resize.' + pluginName + ' orientationchange.' + pluginName, function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
          if (window.innerWidth <= BREAK_POINT) {
            that.splitColumns();
          } else {
            that.mergeColumns();
          }
        }, 300);
      }).trigger('resize.' + pluginName);
    },
    splitColumns: function() {
      if (this.vars.isSplited) { return; }
      var that = this,
          lines = that.element.children(),
          total = lines.length,
          numOfGroup = Math.ceil(total / that.options.numColumns);
      for (var i = 0; i < that.options.numColumns; i = i + 1) {
        that.vars.groups.push($(groupTemplate).appendTo(that.element));
      }

      lines.each(function(idx) {
        var groupIdx = Math.floor(idx / numOfGroup);
        $(this).appendTo(that.vars.groups[groupIdx]);
      });
      that.vars.isSplited = true;
    },
    mergeColumns: function() {
      var that = this;
      for (var i = 0, len = that.vars.groups.length; i < len; i = i + 1) {
        that.vars.groups[i].children().unwrap();
      }
      that.vars.groups = [];
      that.vars.isSplited = false;
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
    numColumns: 2
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name number-person
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
  var pluginName = 'number-person',
      win = $(window);

  var splitNumberText = function(value) {
    var number,
        text = '';
    value = value.split(' ');
    if (value.length >= 2) {
      number = parseInt(value.shift()) || 0;
      text = value.join(' ');
    } else {
      number = parseInt(value[0]) || 0;
      text = value.join(' ');
    }
    return {'number': number, 'text': text};
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          opt = that.options,
          preBtn = ele.find(opt.prev),
          nextBtn = ele.find(opt.next);

      that.isClick = false;
      that.inputEle = ele.find('input'),

      preBtn.on('click.next' + pluginName, function(e){
        e.preventDefault();
        if(!that.isClick){
          that.isClick = true;
          that.preInit();
        }
      });

      nextBtn.on('click.next' + pluginName, function(e){
        e.preventDefault();
        if(!that.isClick){
          that.isClick = true;
          that.nextInit();
        }
      });

      that.inputEle.on('keydown.' + pluginName, function(e) {
        return false;
      });
    },

    preInit: function(){
      var that = this,
          data = splitNumberText(that.inputEle.val());
      data.number = data.number > 0 ? data.number - 1 : 0;
      that.inputEle.val(data.number + ' ' + data.text);
      that.isClick = false;
    },

    nextInit: function(){
      var that = this,
          data = splitNumberText(that.inputEle.val());
      data.number = data.number + 1;
      that.inputEle.val(data.number + ' ' + data.text);
      that.isClick = false;
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
    prev: '.decrease',
    next: '.increase',
    formNumber: '.form-number'
  };

  $(function() {

    var inputPerson = $('.input-person');
    inputPerson.each(function() {
      var item = $(this);
      item
      .after('<span class="increase">+</span>')
      .before('<span class="decrease">-</span>')
      .closest('.form-item')
      .addClass('form-item-custom')
      .attr('data-number-person', '');
    });

    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });

  });

}(jQuery, window));

/**
 *  @name number-phone
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
  var pluginName = 'number-phone',
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element;

      ele.each(function() {
        this.oninput = function() {
          var txt = this.value,
              length = txt.length,
              temp = '';

          for (var i = 0; i < length; i++) {
            if (0 === i) {
              if ('+' === txt[i] || (!isNaN(txt[i]) && ' ' !== txt[i])) {
                temp += txt[i];
              }
            } else {
              if (!isNaN(txt[i]) && ' ' !== txt[i]) {
                temp += txt[i];
              }
            }
          }

          txt = temp;
          length = txt.length;
          if (length >= that.options.maxlength) {
            txt = txt.slice(0, that.options.maxlength);
          }
          this.value = txt;
        };
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

  $.fn[pluginName].defaults = {
    maxlength: 20
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    $(':text.phone-number')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name popup
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
  var pluginName = 'popup',
      win = $(window),
      body = $('body'),
      siteWrapper = $('#wrapper'),
      html = $('html');

  var setHeight = function() {
    var popupContent = $('.content', this.element),
        paddingTop = parseInt(body.css('padding-top')),
        innerHeight = window.innerHeight - parseInt(popupContent.css('margin-top')) -
                      parseInt(popupContent.css('padding-top')) -
                      parseInt(popupContent.css('padding-bottom'));

    this.element.css('top', paddingTop);
    if (html.hasClass('mobile') && html.hasClass('landscape')) {
      this.element.css('height', window.innerHeight - paddingTop);
      popupContent.children('.inner').css('height', '');
    } else {
      this.element.css('height', '');
      popupContent.children('.inner').css('height', innerHeight - paddingTop);
    }
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          id = that.element.prop('id');

      that.vars = {
        closeBtn: $(that.options.closeSelector, that.element),
        timer: null
      };

      $('[data-trigger-popup="' + id + '"]')
      .on('click.' + pluginName, function() {
        that.show();
        if($('[data-toggle-share]').length){
          $('[data-toggle-share]').data('toggle-share').hide();
        }
      });
      that.vars.closeBtn.on('click.' + pluginName, function() {
        that.hide();
      });

      win.on('resize.' + pluginName + 'orientationchange.' + pluginName, function() {
        clearTimeout(that.vars.timer);
        that.vars.timer = setTimeout(function() {
          setHeight.call(that);
          if (that.options.mobileOnly && !Site.isMobile()) {
            that.hide();
          }

          if (that.vars.isShown) {
            if (html.hasClass('mobile') && html.hasClass('landscape')) {
              siteWrapper.hide();
            } else {
              siteWrapper.show();
            }
          }
        }, 200);
      });
    },
    show: function() {
      var that = this;
      if (that.options.mobileOnly && !Site.isMobile()) {
        return;
      }
      $('[data-' + pluginName + ']').css('z-index', '');
      this.element
      .css('z-index', 100)
      .fadeIn(function() {
        setHeight.call(that);
        if (html.hasClass('mobile') && html.hasClass('landscape')) {
          siteWrapper.hide();
        }
        that.vars.isShown = true;
      });

      Site.freezeMenu();
    },
    hide: function() {
      var that = this;
      that.element
      .fadeOut(function() {
        $(this).css('z-index', '');
        Site.unfreezeMenu();
        that.vars.isShown = false;
      });
      siteWrapper.show();
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
    mobileOnly: true,
    closeSelector: '.btn-close'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    body.on('close-cookie-banner', function() {
      $('[data-' + pluginName + ']:visible').css('top', '');
    });
  });

}(jQuery, window));

/**
 *  @name read-more
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
  var pluginName = 'read-more',
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          opt = that.options,
          htmlOrBody = $('html, body');

      that.vars = {
        btnReadmore: ele.find('.open-btn'),
        btnClose: ele.find('.close-btn'),
        content: ele.find('.content'),
        map: ele.find('[data-gmap]')
      };

      that.vars.content.css('display', 'none');

      that.vars.btnReadmore
        .on('click.' + pluginName, function(e) {
          e.preventDefault();
          that.vars.btnReadmore.slideUp(500, function() {
            that.vars.content.slideDown(500, function() {
              if (that.vars.map.length) {
                setTimeout(function() {
                  if (that.vars.map.length) {
                    that.vars.map['gmap']('resizeMap');
                  }
                }, 100);
              }
            });
          });
        });

      that.vars.btnClose
        .on('click.' + pluginName, function(e) {
          e.preventDefault();
          e.stopPropagation();
          that.vars.content.slideUp(500, function() {
            that.vars.btnReadmore.slideDown(500, function() {
              htmlOrBody.animate({
                scrollTop: that.vars.content.closest(opt.parentBlock).offset().top
              }, 500);
            });
          });
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

  $.fn[pluginName].defaults = {
    parentBlock: '.image-text'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name share
 *  @description share an url on social network
 *  @version 1.0
 *  @options
 *      share: name of social network need share
 *      shareUrl: an url to share on social network
 *      width: width of popup
 *      height: height of popup
 *  @events
 *    no event
 *  @methods
 *    init
 *    destroy
 */
;(function($, window, undefined) {
  'use strict';

  var pluginName = 'share',
      win = $(window);

  var shareFb = function(objData) {
    // urlImg, caption, description, urlPage
    FB.ui({
      method: 'feed',
      link: objData.urlPage,
      caption: objData.urlPage,
      picture: objData.urlImg,
      description: objData.description,
      name: objData.caption
    }, function(response) {});
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
        win = $(window),
        opt = that.options;

      that.element.on('click.' + pluginName, function(e) {
        e.preventDefault();
        shareFb.call(that, $(this).data('share-content'));
        // window.open(ele.attr('href'), 'Share', 'width=' + opt.width + ', height=' + opt.height + ', top=' + position.top + ', left=' + position.left + ', scrollbars=1');
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    share: 'facebook',
    shareUrl: '',
    width: 500,
    height: 500
  };

  $(function() {
    var initTwitter = function() {
      if ($('[data-share-twitter]').length > 0 && typeof window.twttr === 'undefined') {
        window.twttr = (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0],
          t = window.twttr || {};
          if (d.getElementById(id)) return;
          js = d.createElement(s);
          js.id = id;
          js.src = '//platform.twitter.com/widgets.js';
          fjs.parentNode.insertBefore(js, fjs);
          t._e = [];
          t.ready = function(F) {
            t._e.push(F);
          };
          return t;
        }(document, 'script', 'twitter-wjs'));
      }
    }

    $('[data-' + pluginName + ']')[pluginName]({});
    initTwitter();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
      initTwitter();
    });
  });

}(jQuery, window));

/**
 *  @name slider
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
  var pluginName = 'slider',
      win = $(window),
      html = $('html');

  var setTimerThumbnail = function(timer, idxSlide, that) {
    timer.stop();
    timer.css('width', 0);
    timer.eq(idxSlide).animate({
      width: 100 + '%'
    }, that.options.durThumb, function() {
      that.element.slick('slickNext');
    });
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
          lengthEle = ele.children().length;

      that.currSlide = 0;
      that.currVideo = 0;
      that.resized = false;
      that.thumbItems = that.element.find('[data-thumb]');

      if (ele.data('duration') && !isNaN(ele.data('duration'))) {
        that.options.durSlide = ele.data('duration') * 1000;
        that.options.durThumb = ele.data('duration') * 1000 + 500;
      }

      if (!html.hasClass('desktop')) {
        that.element.find('video').remove();
      }

      if(lengthEle > 1){
        if(lengthEle === 4){
          that.element.addClass('four-items');
        }
        that.initThumnail();
      } else {
        if(that.element.hasClass('slick-initialized')){
          that.element.slick('unslick');
        }
        that.playVideoOneItem();
      }
    },
    initThumnail: function(){
      var that = this,
          timer = null,
          timeout;
      that.element
        .on('init', function(){
          var dots = that.element.find('.slick-dots'),
              slickActive = $('.slick-active'),
              vidFirst = slickActive.find('video');

          timer = that.element.find('.visual .timer');
          setTimeout(function() {
            if (!that.resized) {
              timer.eq(slickActive.data('slick-index')).animate({
                width: '100%'
              }, that.options.durThumb - 900, function() {
                that.element.slick('slickNext');
              });
            }
            if (vidFirst.length && vidFirst.data('loadeddata')) {
              vidFirst.get(0).play();
              vidFirst.prop('muted', true);
            }
          }, 600);
          dots.on('click.' + pluginName, 'li', function() {
            var self = $(this),
                idx = self.index(),
                selfTimer = self.find('.timer'),
                video = that.element.find('[data-slick-index="' + idx + '"]').find('video');
            if (selfTimer.attr('style') === 'width: 100%;') {
              setTimerThumbnail(timer, idx, that);
              if (video.length) {
                video.get(0).pause();
                video.get(0).currentTime = 0;
                video.get(0).play();
              }
            }
          });
          that.element.find('.slick-slide .inner').on('touchend', '.desc', function(e) {
            var self = $(this).closest('.slick-slide'),
                idxSlide = self.index() - 1,
                selfTimer = dots.find('.timer').eq(idxSlide);
            if (selfTimer.attr('style') === 'width: 100%;' && !window.Site.isMobile()) {
              that.element.slick('slickNext');
            }
          });
        });

      $(window).on('resize.' + pluginName, function() {
        that.resized = true;
        that.currentIdx = that.element.find('.slick-active').data('slick-index');
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          that.element.triggerHandler('init');
        }, 300);
      });

      that.element.slick({
        autoplay: true,
        autoplaySpeed: that.options.durSlide,
        pauseOnHover: false,
        adaptiveHeight: true,
        arrows: false,
        dots: true,
        infinite: true,
        accessibility: false,
        dotsClass: 'slick-dots',
        customPaging: function(slider, i) {
          return '<div class="visual"><img class="grayscale" src="' + $(slider.$slides[i]).data('thumb') + '" alt=""><span class="timer"></span></div><h3>' + $(slider.$slides[i]).data('thumb-content') +'</h3>';
        },
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
        {
          breakpoint: 992,
          settings: {
            dots: true,
            customPaging: function(slider, i) {
              return '<button class="tab">' + $(slider.$slides[i]).find('.slide-title').text() + '</button>';
            }
          }
        }]
      }).on('beforeChange.' + pluginName, function(event, slick, currentSlide, nextSlide){
        that.changeProgress(timer, nextSlide);
      }).on('swipe', function(event, slick, direction, currentSlide){
        that.changeProgress(timer, slick.currentSlide);
      }).on('afterChange', function(event, slick, currentSlide){
        if (!window.Site.isMobile() && currentSlide !== that.currVideo) {
          that.changeVideo(currentSlide);
        }
      });
    },
    changeVideo: function(slide){
      var that = this,
          slickActive = that.element.find('.slick-active'),
          currentVideo = slickActive.find('video'),
          previousVideo = that.element.find('[data-slick-index="' + that.currVideo + '"]').find('video');

      if (previousVideo.length && previousVideo.data('loadeddata')) {
        previousVideo.get(0).pause();
        previousVideo.get(0).currentTime = 0;
      }

      if(that.currVideo != slide){
        that.currVideo = slide;
        if(currentVideo.length && currentVideo.data('loadeddata')){
          currentVideo.get(0).play();
        }
      }
    },
    changeProgress: function(timer, slide){
      var that = this;
      if(that.currSlide != slide){
        that.currSlide = slide;
        timer = that.element.find('.visual .timer');
        setTimerThumbnail(timer, slide, that);
      }
    },
    playVideoOneItem: function() {
      var video = this.thumbItems.find('video');
      if (this.thumbItems.length === 1 && video.length) {
        video.on('loadeddata', function() {
          video.get(0).play();
          video.prop('muted', true);
        });
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
    durSlide: 6000,
    durThumb: 6500
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });
}(jQuery, window));

/**
 *  @name tabs
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
  var pluginName = 'tabs',
      BREAK_POINT = 992,
      win = $(window);

  var renderMobileLayout = function() {
    var that = this,
        opt = that.options;

    that.btnSubmit.off('click.submit').on('click.submit' + pluginName, function(e){
      that.initSubmitMobile(e);
    });

    that.btnAccord.removeClass(opt.active);
    if(that.btnTab.eq(0).hasClass(opt.active)){
      that.btnAccord.eq(0).addClass(opt.active);
      that.step1.removeClass(opt.hidden);
    }else{
      that.btnAccord.eq(1).addClass(opt.active);
      that.step2.removeClass(opt.hidden);
    }
  };

  var renderDesktopLayout = function() {
    var that = this,
        opt = that.options;

    that.btnSubmit.off('click.submit').on('click.submit' + pluginName, function(e){
      that.initSubmitDesktop(e);
    });

    that.btnTab.removeClass(opt.active);
    if(that.btnAccord.eq(0).hasClass(opt.active)){
      that.btnTab.eq(0).addClass(opt.active);
      that.step1.removeClass(opt.hidden);
    }else{
      that.btnTab.eq(1).addClass(opt.active);
      that.step2.removeClass(opt.hidden);
    }

    that.step1.removeAttr('style');
    that.step2.removeAttr('style');
  };


  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = that.element,
          opt = that.options;

      that.vars = {
        isMobile: win.width() < BREAK_POINT
      };

      that.btnTab = ele.find('a'),
      that.btnAccord = ele.siblings('[data-accordion]').find('a.collapse-item'),
      that.step1 = ele.parent().find('[data-step-1]'),
      that.step2 = ele.parent().find('[data-step-2]'),
      that.btnSubmit = ele.parent().find('.btn-submit');

      that.btnTab.on('click.tab' + pluginName, function(e){
        e.preventDefault();
        that.initTab($(this));
      });

      that.btnAccord.on('click.accordion' + pluginName , function(e){
        e.preventDefault();
        that.initAccordion($(this));
      });

      if (that.vars.isMobile) {
        renderMobileLayout.call(that);
      } else {
        renderDesktopLayout.call(that);
      }

      win.on('resize.' + pluginName, function() {
        if(!that.vars.isMobile && win.width() < BREAK_POINT) {
          renderMobileLayout.call(that);
          that.vars.isMobile = true;
        }
        else if (that.vars.isMobile && win.width() >= BREAK_POINT) {
          renderDesktopLayout.call(that);
          that.vars.isMobile = false;
        }
      });
    },

    initTab: function(self){
      var that = this,
          canChange = true,
          stepOneId = that.step1.prop('id'),
          opt = that.options;

      if (opt.beforeChange && typeof opt.beforeChange === 'function') {
        canChange = opt.beforeChange(stepOneId);
      }
      if (!canChange) { return; }

      that.step1.removeAttr('style');
      that.step2.removeAttr('style');
      if(!self.hasClass(opt.active)){
        that.btnTab.removeClass(opt.active);
        self.addClass(opt.active);
        that.step1.addClass(opt.hidden);
        that.step2.addClass(opt.hidden);
        $(self.data('trigger')).removeClass(opt.hidden);
        !that.step1.hasClass(opt.hidden) ? that.btnSubmit.val(opt.nextStep) : that.btnSubmit.val(opt.submit);
      }
    },

    initAccordion: function(self){
      var that = this,
          canChange = true,
          stepOneId = that.step1.prop('id'),
          opt = that.options;

      if (opt.beforeChange && typeof opt.beforeChange === 'function') {
        canChange = opt.beforeChange(stepOneId);
      }
      if (!canChange) { return; }

      if(!self.hasClass(opt.active)){
        var idx = that.btnAccord.index(self);
        that.btnAccord.removeClass(opt.active);
        that.btnAccord.eq(idx).addClass(opt.active);
        if(idx == 0){
          that.step1.removeClass(opt.hidden).slideDown('slow');
          that.step2.slideUp('slow', function(){
            that.step2.addClass(opt.hidden);
            !that.step1.hasClass(opt.hidden) ? that.btnSubmit.val(opt.nextStep) : that.btnSubmit.val(opt.submit);
          });
        }
        if(idx == 1){
          that.step2.removeClass(opt.hidden).slideDown('slow');
          that.step1.slideUp('slow', function(){
            that.step1.addClass(opt.hidden);
            !that.step1.hasClass(opt.hidden) ? that.btnSubmit.val(opt.nextStep) : that.btnSubmit.val(opt.submit);
          });

        }
      }
    },

    initSubmitDesktop: function(e){
      var that = this,
          opt = that.options;

      if(!that.step1.hasClass(opt.hidden)){
        e.preventDefault();

        if (opt.beforeChange && typeof opt.beforeChange === 'function') {
          canChange = opt.beforeChange();
        }
        if (!canChange) { return; }

        that.btnTab.removeClass(opt.active);
        that.btnTab.eq(1).addClass(opt.active);
        that.step1.addClass(opt.hidden);
        that.step2.removeClass(opt.hidden);
        that.btnSubmit.val(opt.submit);
      }
    },

    initSubmitMobile: function(e){
      var that = this,
          opt = that.options;

      if(!that.step1.hasClass(opt.hidden)){
        e.preventDefault();

        if (opt.beforeChange && typeof opt.beforeChange === 'function') {
          canChange = opt.beforeChange();
        }
        if (!canChange) { return; }

        that.btnAccord.removeClass(opt.active);
        that.btnAccord.eq(1).addClass(opt.active);
        that.btnTab.removeClass(opt.active);
        that.btnTab.eq(1).addClass(opt.active);

        that.step2.removeClass(opt.hidden).slideDown('slow');
        that.step1.slideUp('slow', function(){
          that.step1.addClass(opt.hidden);
        });

        that.btnSubmit.val(opt.submit);
      }
    },

    addErrorForm: function(){
      var that = this;

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
    active: 'active',
    hidden: 'hidden',
    nextStep: 'NEXT STEP',
    submit: 'SUBMIT'
  };

  $(function() {
    var form = $('.form-1'),
        formStepOne = $('[data-step-1]', form);
    var opts = {
      beforeChange: function(id) {
        form['validate']('validateGroup', '#' + formStepOne.prop('id'));
        return !formStepOne.hasClass('form-group-error');
      }
    };
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName](opts);
    })
    .trigger(Site.events.AJAX_SUCCESS + '.' + pluginName);

  });


}(jQuery, window));

/**
 *  @name close-hint
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
  var pluginName = 'toggle-share',
      win = $(window),
      BREAK_POINT = 991,
      overlay = $('.overlay.white'),
      site = window.Site;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          iconToggle = that.element.find('.icon-share-toggle'),
          timeout;

      that.ele = that.element;
      that.toggleClass = that.options.classToggle;
      that.currPos = 0;
      that.topHeader = $('.main-header').outerHeight();

      iconToggle.on('click.' + pluginName, function(){
        if(that.ele.hasClass(that.toggleClass)){
          that.hide();
        }else{
          that.show();
        }
      });
      overlay.on('click.' + pluginName, function() {
        that.hide();
      });

      win.on('resize.' + pluginName, function(){
        if(win.width() > BREAK_POINT) {
          that.ele.removeClass(that.toggleClass);
          overlay.hide().removeAttr('style');
          site.unfreezePage(that.currPos);
          $('html,body').off('touchmove.' + pluginName);
        } else {
          clearTimeout(timeout);
          timeout = setTimeout(function() {
            overlay.css('top', that.topHeader);
          }, 0);
        }
      });
    },

    hide: function(){
      var that = this;
      that.ele.removeClass(that.toggleClass);
      overlay.hide().removeAttr('style');
      site.unfreezePage(that.currPos);
      $('html,body').animate({
        scrollTop: that.currPos
      }, 500);
      $('html,body').off('touchmove.' + pluginName);
    },

    show: function(){
      var that = this;
      that.currPos = win.scrollTop();
      that.ele.addClass(that.toggleClass);
      overlay.show().css('top', that.topHeader);
      site.freezePage();
      $('html,body').on('touchmove.' + pluginName, function(e){
        e.preventDefault();
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

  $.fn[pluginName].defaults = {
    classToggle: 'toggle-share'
  };

  $(function() {
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    })
    .trigger(Site.events.AJAX_SUCCESS + '.' + pluginName);
  });

}(jQuery, window));

/**
 *  @name toggle
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
  var pluginName = 'toggle',
      win = $(window);

  var Screen = {
    DESKTOP: 'desktop',
    MOBILE: 'mobile',
    BOTH: 'both'
  };

  var getScroll = function() {
    var el = this.element,
        wrapper = this.vars.scrollWrapper,
        top = el.offset().top - wrapper.offset().top + wrapper.scrollTop();

    this.vars.scrollWrapper.animate({
      scrollTop: top
    });
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          id = that.element.data('id');

      that.vars = {
        overlay: $(that.options.overlaySelector),
        scrollWrapper: $(that.options.scrollWrapper),
        closeBtn: $(that.options.closeTrigger, that.element),
        trigger: $('[data-trigger-toggle="' + id + '"]'),
        opt: that.options
      };


      that.vars.trigger.on('click.' + pluginName, function() {
        that.element.is(':visible') ? that.hide() : that.show();
      });
      that.vars.closeBtn.on('click.' + pluginName, function() {
        that.hide();
      });
      if (that.vars.overlay.length) {
        that.vars.overlay.on('click.' + pluginName, function() {
          that.hide();
        });
      }

      win.on('resize.' + pluginName + 'orientationchange.' + pluginName, function() {
        if ((Screen.DESKTOP === that.options.onScreen && Site.isMobile() ||
          Screen.MOBILE === that.options.onScreen && !Site.isMobile()) &&
          that.element.is(':visible')) {
          that.hide(true);
        }
        if (that.vars.overlay.length > 0 && that.options.isScroll) {
          getScroll.call(that);
        }
      });

    },
    show: function() {
      var that = this;
      if (Screen.DESKTOP === that.options.onScreen && Site.isMobile() ||
          Screen.MOBILE === that.options.onScreen && !Site.isMobile()) {
        return;
      }
      that.vars.trigger.addClass(that.options.classActive);
      this.element.stop().slideDown(function() {
        if (that.vars.overlay.length) {
          that.vars.overlay.fadeIn(function() {
            Site.freezeMenu();
          });
        }

        if (that.options.isScroll) {
          getScroll.call(that);
        }
      });
      that.vars.overlay.removeAttr('style');
    },
    hide: function(noAnimate) {
      var that = this;
      that.vars.opt.isSetTopOverlay ? that.vars.overlay.css('top', that.element.offset().top) : that.vars.overlay.removeAttr('style');
      var hideOverlay = function() {
        if (that.vars.overlay.length) {
          that.vars.overlay.fadeOut(function() {
            Site.unfreezeMenu();
          });
        }
      };
      that.vars.trigger.removeClass(that.options.classActive);
      if (noAnimate) {
        this.element.hide();
        hideOverlay();
      }
      this.element.stop().slideUp(function() {
        hideOverlay();
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
        // window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    overlaySelector: '',
    classActive: 'active',
    onScreen: 'both',
    closeTrigger: '.btn-close',
    scrollWrapper: 'html, body',
    isSetTopOverlay: false,
    isScroll: false
  };

  $(function() {
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    })
    .trigger(Site.events.AJAX_SUCCESS + '.' + pluginName);



    $('.search-box')[pluginName]({
      onScreen: 'desktop',
      overlaySelector: '.overlay.white',
      isSetTopOverlay: true
    });
  });

}(jQuery, window));

/**
 *  @name validate
 *  @description simple validate form
 *  @version 1.0
 *  @options
 *  @events
 *    no event
 *  @methods
 *    init
 *    destroy
 */
;(function($, window, undefined) {
  'use strict';

  var pluginName = 'validate',
      html = $('html'),
      win = $(window);

  var checkRequired = function(item) {
    if (item.hasClass(this.options.classRadioGroup) && 0 === $(':radio:checked', item).length) {
      return false;
    }
    else if (item.hasClass(this.options.classCheckGroup)) {
      var chkbox = $(':checkbox:checked', item);
      if (0 === chkbox.length) {
        return false;
      }
    }
    else if (item.is(':input') && '' === item.val()) {
      return false;
    }
    return true;
  };
  var addError = function(label) {
    var that = this;
    label.parent().addClass(that.options.classError);
  };
  var removeError = function(label) {
    var that = this,
        wrapper = label.parent();

    wrapper
    .removeClass(that.options.classError)
    .find('.error').removeClass('error').end()
    .find('.message-error').remove();
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;
      that.vars = {
        labels: $('label', that.element),
        validated: false,
        numErrors: 0,
        submitButton: $(':submit', that.element)
      };

      that.element.on('submit.' + pluginName, function() {
        return that.validateForm();
      })
      .find(':input, :radio, :checkbox')
      .on('change.' + pluginName + ' keyup.' + pluginName, function() {
        var field = $(this),
            label = field.closest('.' + that.options.classFormItem).children('label').eq(0);
        if (label.length && that.vars.validated) {
          that.validateField(label);
        }
      });
    },
    validateField: function(label) {
      var item = $('#' + label.prop('htmlFor')),
          datePicker = label.next('[data-date-picker]').find('[data-date-show]');

      // validate datepicker
      if (datePicker.length && label.hasClass(this.options.classRequire)) {
        if('' === datePicker.val() || datePicker.val().split('/') < 3) {
          addError.call(this, label);
          return false;
        } else {
          removeError.call(this, label);
          return true;
        }
      }

      // validate normal fields
      if(!item.length) { return true; }
      // check required
      if (label.hasClass(this.options.classRequire)) {
        var result = checkRequired.call(this, item);
        if (!result) {
          addError.call(this, label);
          return false;
        }
      }

      // check phone-number
      if (item.is(':text') && item.prop('name').indexOf('mobile_number') !== -1 && item.val().length > 0) {
        var err = /[^0-9\+]/g.test(item.val());
        if (err) {
          addError.call(this, label);
          return false;
        }
      }

      removeError.call(this, label);
      return true;
    },
    validateForm: function() {
      var that = this;
      that.vars.numErrors = 0;
      that.vars.labels.each(function() {
        if(!that.validateField($(this))) {
          that.vars.numErrors = that.vars.numErrors + 1;
        }
      });
      that.vars.validated = true;
      return that.vars.numErrors === 0;
    },
    validateGroup: function(wrapperSel) {
      var that = this,
          wrapper = $(wrapperSel),
          numErrors = 0;

      if (wrapper.length) {
        $('label', wrapper).each(function() {
          if(!that.validateField($(this))) {
            numErrors = numErrors + 1;
          }
        });

        if (numErrors > 0) {
          wrapper.addClass(that.options.classGroupError);
          return false;
        } else {
          wrapper.removeClass(that.options.classGroupError);
          return true;
        }
      }
      return true;
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
        window.console && console.log(options ? options + ' method is not exists in ' + pluginName : pluginName + ' plugin has been initialized');
      }
    });
  };

  $.fn[pluginName].defaults = {
    classRequire: 'required',
    classError: 'field-error',
    classFormItem: 'form-item',
    classRadioGroup: 'form-radios',
    classGroupError: 'form-group-error',
    classCheckGroup: 'form-checkboxes'
  };

  $(function() {

    var mobileField = $('input.phone-number'),
        limitLengthField = $('[class*="limit-length-"]');

    if (mobileField.length) {
      mobileField.each(function(idx) {
        var field = $(this),
            label = field.prev('label').text(),
            mobileHidden = $('<input type="hidden" name="submitted[mobile_number][' + idx + ']" value="" />').insertAfter(field);

        field
        .on('keyup', function() {
          $(this).next('[type="hidden"]').val(field.prop('name') + '|' + label + '|' + this.value);
        }).trigger('keyup');
      });
    }

    limitLengthField.each(function() {
      var el = $(this),
          classes = el.attr('class').split(' '),
          limit;

      for (var i = 0; i < classes.length; i = i + 1) {
        if (classes[i].indexOf('limit-length-') !== -1) {
          limit = classes[i].split('-')[2];
          el.attr('maxlength', limit);

          if(html.hasClass('ie9')) {
            el[0].oninput = function(e) {
              this.value = this.value.substring(0, parseInt(limit));
              e.preventDefault();
            };
          }
          break;
        }
      }
    });

    $('[data-' + pluginName + ']')[pluginName]({});
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    });
  });

}(jQuery, window));

/**
 *  @name video-frame
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
  var pluginName = 'video-frame',
      win = $(window);

  function initTemplate (ele, videoSrc, videoType){
    var videoId,
        srcPrefix = '//www.youtube.com/embed/';
    if (videoSrc.indexOf('youtu.be') !== -1) {    // youtu.be/[video_id]
      var params = videoSrc.split('/').pop();
      videoId = params.split('?').shift();
    } else {                                      // youtube.com/watch?v=[video_id]
      var params = videoSrc.substr(videoSrc.indexOf('?') + 1).split('&');
      for(var i = 0; i < params.length; i = i + 1) {
        if (params[i].indexOf('v=') !== -1) {
          videoId = params[i].substr(2);
          break;
        }
      }
    }
    videoSrc = srcPrefix + videoId;
    var iframeContent = '<iframe class="embed-responsive-item" frameborder="0" allowfullscreen title="YouTube video player" src="' + videoSrc + '?wmode=opaque&autoplay=1&rel=0&showinfo=0&modestbranding=1&controls=1&showinfo=0&enablejsapi=0&output=embed"></iframe>';
    var iframe = $(iframeContent).attr('src', $(iframeContent).attr('src') + '?wmode=transparent');

    ele.html(null);
    ele.append(iframe);
  }

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          ele = this.element,
          url = ele.data('video-src'),
          dataType = ele.data('type') ? ele.data('type') : '';

      ele.on('click.' + pluginName, function(e){
        e.preventDefault();
        initTemplate(ele, url, dataType);
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
    win.on(Site.events.AJAX_SUCCESS + '.' + pluginName, function() {
      $('[data-' + pluginName + ']')[pluginName]();
    })
    .trigger(Site.events.AJAX_SUCCESS + '.' + pluginName);
  });

}(jQuery, window));

/**
 *  @name check-box
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
  var pluginName = 'zip-code',
      win = $(window);

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this;

      that.element.on('keyup keypress blur change', function(e) {
        //return false if not 0-9
        if (e.which != 8 && e.which != 13 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
      });

      that.element.each(function() {
        var self = $(this);
        self[0].oninput = function() {
          if (this.value.length >= that.options.maxLength) {
            this.value = this.value.slice(0, that.options.maxLength);
          }
        };
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

  $.fn[pluginName].defaults = {
    maxLength: 20
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
    $('input[name*="[postcode_zip]"]')[pluginName]();
  });

}(jQuery, window));
