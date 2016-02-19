(function($, window){

  var htmlElm = $('html'),
      win = $(window);

  window.Site = {};

  Site.curWinW = window.innerWidth;
  Site.curScreenMode = 'desktop';
  Site.events = {
    AJAX_SUCCESS: 'ajax-success'
  };

  Site.isMobile = function() {
    return (window.innerWidth < 992) ? true : false;
  };

  Site.isCustomMobile = function() {
    return (window.innerWidth < 1025) ? true : false;
  }

  Site.isIe9 = function(){
    return htmlElm.hasClass('ie9');
  }

  Site.isIos = function(){
    return htmlElm.hasClass('ios');
  }

  Site.changeScreenMode = function(){
    var mode = Site.isMobile() ? 'mobile' : 'desktop';
    if (mode === Site.curScreenMode) {
      return false;
    }
    Site.curScreenMode = mode;
    return true;
  }

  Site.isRealResize = function() {
    var curWinW = window.innerWidth;
    if (curWinW !== Site.curWinW) {
      setTimeout(function(){
        Site.curWinW = curWinW;
      }, 600);
      return true;
    }
    return false;
  };

  Site.onAjaxSuccessHandle = function() {
    win.trigger(Site.events.AJAX_SUCCESS);
  };

  // Setting 404 background-layer height
  if ($('.background-layer').length) {
    Site.setBackgroundLayerH = function(){
      $('.background-layer')
      .attr('style', '')
      .css({
        'min-height': $(document).height()
      });
    };

    win.on('resize.resetBgLayerHeight', function(){
      Site.setBackgroundLayerH();
    });

    // Reset height after a sp
    setTimeout(function(){
      Site.setBackgroundLayerH();
    }, 380);
  }

  // Square picture forcing
  function resizeBox() {
    $('.wrap-box').each(function(){
      var wrapBox = $(this),
          box = wrapBox.find('.box'),
          wrapBoxW, wrapBoxH,
          desc = wrapBox.find('.desc');

      wrapBox.attr('style', '');

      if (desc.length) {
        desc
        .trigger('destroy')
        .attr('style', '')
        .removeAttr('style');

        wrapBoxW = wrapBox.outerWidth();
        wrapBoxH = wrapBox.outerHeight();

        if (!Site.isMobile() && wrapBoxW < wrapBoxH) {
          desc.css('height', desc.height() - (wrapBoxH - wrapBoxW))
          .dotdotdot();
        }
      }

      if (wrapBox.outerWidth() > wrapBox.outerHeight()) {
        wrapBox.css({
          'height': wrapBox.outerWidth()
        });
      }

    });
  }

  $(function(){
    var timer;
    if ($('.wrap-box').length) {
      win.on('resize.resizeBox', function(){
        // Double trigger for lately-resized boxes
        clearTimeout(timer);
        timer = setTimeout(function(){
          resizeBox();
        }, 300);
      }).trigger('resize.resizeBox');
    }
  });

}(jQuery, window));

(function ($, window) {
  // Stop from running again, if accidently included more than once.
  if (window.hasCookieConsent) return;
  window.hasCookieConsent = true;

  /*
   Constants
   */

  // Client variable which may be present containing options to override with
  var OPTIONS_VARIABLE = 'cookieconsent_options';

  // Change cookie consent options on the fly.
  var OPTIONS_UPDATER = 'update_cookieconsent_options';

  // Name of cookie to be set when dismissed
  var DISMISSED_COOKIE = 'cookieconsent_dismissed';

  // The path to built in themes (s3 bucket)
  var THEME_BUCKET_PATH = '//s3.amazonaws.com/cc.silktide.com/';

  // No point going further if they've already dismissed.
  if (document.cookie.indexOf(DISMISSED_COOKIE) > -1) {
    return;
  }

  // IE8...
  if(typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
      return this.replace(/^\s+|\s+$/g, '');
    };
  }

  /*
   Helper methods
   */
  var Util = {
    isArray: function (obj) {
      var proto = Object.prototype.toString.call(obj);
      return proto == '[object Array]';
    },

    isObject: function (obj) {
      return Object.prototype.toString.call(obj) == '[object Object]';
    },

    each: function (arr, callback, /* optional: */context, force) {
      if (Util.isObject(arr) && !force) {
        for (var key in arr) {
          if (arr.hasOwnProperty(key)) {
            callback.call(context, arr[key], key, arr);
          }
        }
      } else {
        for (var i = 0, ii = arr.length; i < ii; i++) {
          callback.call(context, arr[i], i, arr);
        }
      }
    },

    merge: function (obj1, obj2) {
      if (!obj1) return;
      Util.each(obj2, function (val, key) {
        if (Util.isObject(val) && Util.isObject(obj1[key])) {
          Util.merge(obj1[key], val);
        } else {
          obj1[key] = val;
        }
      })
    },

    bind: function (func, context) {
      return function () {
        return func.apply(context, arguments);
      };
    },

    /*
     find a property based on a . separated path.
     i.e. queryObject({details: {name: 'Adam'}}, 'details.name') // -> 'Adam'
     returns null if not found
     */
    queryObject: function (object, query) {
      var queryPart;
      var i = 0;
      var head = object;
      query = query.split('.');
      while ( (queryPart = query[i++]) && head.hasOwnProperty(queryPart) && (head = head[queryPart]) )  {
        if (i === query.length) return head;
      }
      return null;
    },

    setCookie: function (name, value, expiryDays, domain, path) {
      expiryDays = expiryDays || 365;

      var exdate = new Date();
      exdate.setDate(exdate.getDate() + expiryDays);

      var cookie = [
        name + '=' + value,
        'expires=' + exdate.toUTCString(),
        'path=' + path || '/'
      ];

      if (domain) {
        cookie.push(
          'domain=' + domain
        );
      }

      document.cookie = cookie.join(';');
    },

    addEventListener: function (el, event, eventListener) {
      if (el.addEventListener) {
        el.addEventListener(event, eventListener);
      } else {
        el.attachEvent('on' + event, eventListener);
      }
    }
  };

  var DomBuilder = (function () {
    /*
     The attribute we store events in.
     */
    var eventAttribute = 'data-cc-event';
    var conditionAttribute = 'data-cc-if';

    /*
     Shim to make addEventListener work correctly with IE.
     */
    var addEventListener = function (el, event, eventListener) {
      // Add multiple event listeners at once if array is passed.
      if (Util.isArray(event)) {
        return Util.each(event, function (ev) {
          addEventListener(el, ev, eventListener);
        });
      }

      if (el.addEventListener) {
        el.addEventListener(event, eventListener);
      } else {
        el.attachEvent('on' + event, eventListener);
      }
    };

    /*
     Replace {{variable.name}} with it's property on the scope
     Also supports {{variable.name || another.name || 'string'}}
     */
    var insertReplacements = function (htmlStr, scope) {
      return htmlStr.replace(/\{\{(.*?)\}\}/g, function (_match, sub) {
        var tokens = sub.split('||');
        var value;
        while (token = tokens.shift()) {
          token = token.trim();

          // If string
          if (token[0] === '"') return token.slice(1, token.length - 1);

          // If query matches
          value =  Util.queryObject(scope, token);

          if (value) return value;
        }

        return '';
      });
    };

    /*
     Turn a string of html into DOM
     */
    var buildDom = function (htmlStr) {
      var container = document.createElement('div');
      container.innerHTML = htmlStr;
      return container.children[0];
    };

    var applyToElementsWithAttribute = function (dom, attribute, func) {
      var els = dom.parentNode.querySelectorAll('[' + attribute + ']');
      Util.each(els, function (element) {
        var attributeVal = element.getAttribute(attribute);
        func(element, attributeVal);
      }, window, true);
    };

    /*
     Parse event attributes in dom and set listeners to their matching scope methods
     */
    var applyEvents = function (dom, scope) {
      applyToElementsWithAttribute(dom, eventAttribute, function (element, attributeVal) {
        var parts = attributeVal.split(':');
        var listener = Util.queryObject(scope, parts[1]);
        addEventListener(element, parts[0], Util.bind(listener, scope));
      });
    };

    var applyConditionals = function (dom, scope) {
      applyToElementsWithAttribute(dom, conditionAttribute, function (element, attributeVal) {
        var value = Util.queryObject(scope, attributeVal);
        if (!value) {
          element.parentNode.removeChild(element);
        }
      });
    };

    return {
      build: function (htmlStr, scope) {
        if (Util.isArray(htmlStr)) htmlStr = htmlStr.join('');

        htmlStr = insertReplacements(htmlStr, scope);
        var dom = buildDom(htmlStr);
        applyEvents(dom, scope);
        applyConditionals(dom, scope);

        return dom;
      }
    };
  })();


  /*
   Plugin
   */
  var cookieconsent = {
    options: {
      message: 'This website uses cookies to ensure you get the best experience on our website. ',
      dismiss: 'Got it!',
      learnMore: 'More info',
      link: null,
      container: null, // selector
      theme: '',
      domain: null, // default to current domain.
      path: '/',
      expiryDays: 365,
      markup: [
        '<div class="cc_banner-wrapper {{containerClasses}}">',
        '<div class="cc_banner cc_container cc_container--open">',
        '<a href="#null" data-cc-event="click:dismiss" target="_blank" class="cc_btn cc_btn_accept_all">{{options.dismiss}}</a>',

        '<p class="cc_message">{{options.message}} <a data-cc-if="options.link" target="_blank" class="cc_more_info" href="{{options.link || "#null"}}">{{options.learnMore}}</a></p>',

        '<a class="cc_logo" target="_blank" href="http://silktide.com/cookieconsent">Cookie Consent plugin for the EU cookie law</a>',
        '</div>',
        '</div>'
      ]
    },

    init: function () {
      var options = window[OPTIONS_VARIABLE];
      if (options) this.setOptions(options);

      this.setContainer();

      // Calls render when theme is loaded.
      if (this.options.theme) {
        this.loadTheme(this.render());
      } else {
        this.render();
      }
    },

    setOptionsOnTheFly: function (options) {
      this.setOptions(options);
      this.render();
    },

    setOptions: function (options) {
      Util.merge(this.options, options);
    },

    setContainer: function () {
      if (this.options.container) {
        this.container = document.querySelector(this.options.container);
      } else {
        this.container = document.body;
      }

      // Add class to container classes so we can specify css for IE8 only.
      this.containerClasses = '';
      if (navigator.appVersion.indexOf('MSIE 8') > -1) {
        this.containerClasses += ' cc_ie8'
      }
    },

    loadTheme: function (callback) {
      var theme = this.options.theme;

      // If theme is specified by name
      if (theme.indexOf('.css') === -1) {
        theme = THEME_BUCKET_PATH + theme + '.css';
      }

      var link = document.createElement('link');
      link.rel = 'stylesheet';
      link.type = 'text/css';
      link.href = theme;

      var loaded = false;
      link.onload = Util.bind(function () {
        if (!loaded && callback) {
          callback.call(this);
          loaded = true;
        }
      }, this);

      document.getElementsByTagName("head")[0].appendChild(link);
    },

    render: function () {
      // remove current element (if we've already rendered)
      if (this.element && this.element.parentNode) {
        this.element.parentNode.removeChild(this.element);
        delete this.element;
      }

      this.element = DomBuilder.build(this.options.markup, this);


      if (!this.container.firstChild) {
        this.container.appendChild($(this.element).clone(true).addClass('cloned').get(0));
        this.container.appendChild($(this.element).addClass('default').get(0));
      } else {
        this.container.insertBefore($(this.element).clone(true).addClass('cloned').get(0), this.container.firstChild);
        this.container.insertBefore($(this.element).addClass('default').get(0), this.container.firstChild);
      }

      // CUSTOM CLASS FOR COOKIE-BANNER IN ADMIN LAYOUT
      function isMobile() {
        return (window.innerWidth <= 1024)
      }
      var popin = $(this.element),
          scrollClass = 'scroll-banner';
      if ($(this.element, 'document').length) {
        $(window).on('scroll.cookieBannerPosition', function(e){
          if (isMobile()) {
            ($(window).scrollTop() > 47) ? popin.addClass(scrollClass) : popin.removeClass(scrollClass);
          } else {
            popin.removeClass(scrollClass);
          }
        });
      }
    },

    dismiss: function (evt) {
      evt.preventDefault && evt.preventDefault();
      evt.returnValue = false;
      this.setDismissedCookie();
      this.container.removeChild(this.element);
      // Remove cloned popup
      $(this.container).find('.cloned').remove();
      $(window)
        .trigger('resize.cookieBannerNavAffect')
        .off('resize.cookieBannerNavAffect');
    },

    setDismissedCookie: function () {
      Util.setCookie(DISMISSED_COOKIE, 'yes', this.options.expiryDays, this.options.domain, this.options.path);
    }
  };

  var init;
  var initialized = false;
  (init = function () {
    if (!initialized && document.readyState == 'complete') {
      cookieconsent.init();
      initialized = true;
      window[OPTIONS_UPDATER] = Util.bind(cookieconsent.setOptionsOnTheFly, cookieconsent);
    }
  })();

  Util.addEventListener(document, 'readystatechange', init);

})(jQuery, window);

/**
 *  @name column
 *  @description Setting column style for column-count css3 property. (especially for IE9)
 *  @version 1.0
 *  @options
 *  columnNum: 3,
    maxHeight: null,
    onCallback: null,
    renderClass: 'render-columns',
    wrapClass: 'row',
    containerClass: '',
    listSelecter: 'ul.lists',
    titleClass: 'tab-title',
    groupClass: 'item',
    activeClass: 'active',
    colClass: 'col-sm',
    applyplugins: '',
    listWrapClass: 'tab-content',
    listWrapper: '<div class="tab-content"><ul class="lists multi-col"></ul></div>',
    langGroupWrapper: '',
    resizeDelay: 120
 *  @methods
 *    init
 *    destroy
 */
;(function($, window) {
  'use strict';

  var pluginName = 'column';
  var cols = [],
      curCol = 0;

  var appendLangList = function(itemElm, contentElm) {
    itemElm.append(contentElm);
    cols[curCol].append(itemElm);
  };

  var applyExistingPlugins = function() {
    var opt = this.options,
        appliedPlugins = opt.applyplugins.split(','),
        renderedColumns = this.vars.renderedColumns,
        plugin = '';
    for (var i = 0, len = appliedPlugins.length; i < len; i++) {
      plugin = appliedPlugins[i];
      (plugin !== '') && renderedColumns[plugin]();
    }
  };

  var renderColumns = function(){
    var that = this,
        opt = this.options,
        elm = this.element,
        activeClass = opt.activeClass,
        renderClass = opt.renderClass,
        wrapClass = opt.wrapClass,
        group = elm.find('.' + opt.groupClass),
        items = group.find('.' + opt.listWrapClass),
        colNum = opt.columnNum,
        colRatio = 12 / colNum,
        colH = 0,
        columnWrap = null;

    (elm.find('.' + renderClass).length) ? this.reRender() : elm.append('<div class="' + renderClass + ' ' + opt.containerClass + '"><div class="' + wrapClass + '"></div></div>');

    columnWrap = elm.find('.' + renderClass + ' .' + wrapClass);

    for (var i =1; i <= colNum; i++) {
      var colClass = opt.colClass + '-' + colRatio + ' col' + i;
      columnWrap.append('<div class="' + colClass + '"></div>');
      cols.push(elm.find('.col' + i));
    }

    items.show();
    colH = (opt.maxHeight !== null) ? opt.maxHeight : (elm.height() / colNum);
    items.attr('style', '');
    group.each(function(){
      var self = $(this),
          listClone = self.clone(),
          groupID = listClone.find('.' + opt.listWrapClass).data('id'),
          listSelecter = opt.listSelecter,
          lists = listClone.find(listSelecter),
          active = self.hasClass(activeClass),
          items = lists.find('li'),
          itemHTML = '<div class="' + opt.groupClass + '"></div>',
          contentHTML = opt.listWrapper,
          titleHTML = $('<div class="' + opt.titleClass + '"></div>'),
          itemElm, contentElm, titleElm, listElm,
          curLangItems = null,
          newList = false,
          breakCol = false;
      if (self.height() >= colH) {
        breakCol = true;
      }
      // Add group-item
      itemElm = $(itemHTML);
      if (active) {
        itemElm.addClass(activeClass);
      }
      cols[curCol].append(itemElm);

      // Add lang-item
      contentElm = $(contentHTML);
      contentElm.attr('data-id', groupID);
      listElm = contentElm.find(listSelecter);
      itemElm.append(contentElm);

      // Add title
      titleElm = listClone.find('.' + opt.titleClass);
      itemElm.append(titleElm);

      // Add language-item
      lists.find('li').each(function(){
        var lang = $(this),
            lastChild = lang.is(':last-child');
        if (newList) {
          itemElm = $(itemHTML);
          if (active) {
            itemElm.addClass(activeClass);
          }
          contentElm = $(contentHTML);
          contentElm.attr('data-id', groupID);
          listElm = contentElm.find(listSelecter);
          itemElm.append(contentElm);
          newList = false;
        }
        listElm.append(lang);

        if (cols[curCol].height() > colH) {
          // The languague group is overflow
          if (breakCol) {
            // This group can be break in to multi column
            appendLangList(itemElm, contentElm);
            newList = true;
          } else if (lastChild) {
            // Move the whole group to next column
            appendLangList(itemElm, contentElm);
            newList = true;
          }
          if (cols[curCol + 1] !== undefined) {
            curCol++;
          }
        } else if (lastChild) {
          // Reach the last item of group
          appendLangList(itemElm, contentElm);
          newList = false;
        }
      });
      self.addClass('hide');
    });
    Site.setBackgroundLayerH();
    this.vars.renderedColumns = columnWrap;
    applyExistingPlugins.call(this);
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          opt = this.options,
          renderQueueTimer = null;
      this.vars = {
        renderedColumns: null
      }
      if (!Site.isMobile()) {
        renderColumns.call(this);
      }
      $(window).on('resize.' + pluginName, function(){
        clearTimeout(renderQueueTimer)
        renderQueueTimer = setTimeout(function() {
          (!Site.isMobile()) ? that.reRender() : that.destroy();
        }, opt.resizeDelay);
      });
      Site.setBackgroundLayerH();
    },
    reRender: function() {
      this.destroy();
      renderColumns.call(this);
    },
    destroy: function() {
      var elm = this.element,
          opt = this.options;
      cols = [];
      curCol = 0;
      $.removeData(this.element[0], pluginName);
      elm.find('.' + opt.groupClass).removeClass('hide');
      elm.find('.' + opt.renderClass).remove();
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
    columnNum: 3,
    maxHeight: null,
    onCallback: null,
    renderClass: 'render-columns',
    wrapClass: 'row',
    containerClass: '',
    listSelecter: 'ul.lists',
    titleClass: 'tab-title',
    groupClass: 'item',
    activeClass: 'active',
    colClass: 'col-sm',
    applyplugins: '',
    listWrapClass: 'tab-content',
    listWrapper: '<div class="tab-content"><ul class="lists multi-col"></ul></div>',
    langGroupWrapper: '',
    resizeDelay: 120
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
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

  var pluginName = '.form-custom-select select',
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

      el.after('<span class="btn-select input-1"></span>');

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
      var initText = el.find('option[value="' + el.val() + '"]').html() || '';
      this.vars.toggleBtn.text(initText);

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
    button: '.btn-select',
    selected: 'selected',
    duration: 400
  };

  $(function() {
    // $('[data-' + pluginName + ']')[pluginName]();
    $('.form-custom-select select')[pluginName]();

    $('form').on('change', function() {
      $(this).find('[data-required-show]')
      .each(function() {
        var ip = $(this),
        disabled = ip.prop('disabled');

        if (disabled) {
          ip.removeAttr('required');
        } else {
          ip.attr('required', 'required');
        }
      });
    });

  });

}(jQuery, window));

/**
 *  @name expandable
 *  @description expand and collapse a block by clicking or some other events
 *  @version 1.0
 *  @options
 *  switchSelector: '.tab-title',
    contentSelector: '.tab-content',
    containerSelector: '.item',
    accordion: true,
    duration: 500,
    activeClass: 'active'
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'expandable';

  var setExpandClickEvent = function() {
    var that = this,
        elem = this.element,
        opt = this.options,
        containerSelector = opt.containerSelector,
        duration = opt.duration,
        content = $(opt.contentSelector);

    elem.find(opt.switchSelector).on('click.' + pluginName, function(){
      var target = $(this),
          container = target.closest(opt.containerSelector),
          expanded = container.hasClass(opt.activeClass),
          id = target.data('content-id');
      if (Site.isMobile()) {
        if (opt.accordion) {
          content.each(function(){
            if ($(this).css('display') === 'block') {
              $(this).stop().css('display', 'block').slideUp(duration, function(){
                $(this).attr('style', '');
                elem.find(containerSelector).removeClass(opt.activeClass);
                Site.setBackgroundLayerH();
              });
            }
          });
        }
        if (!expanded) {
          content.filter('[data-id="' + id + '"]').stop().slideDown(duration, function(){
            container.addClass(opt.activeClass).attr('style', '');
            checkOutOfview.call(that, target);
            Site.setBackgroundLayerH();
          });
        }
      }
    });
  };

  var unsetExpandClickEvent = function() {
    this.element.find(this.options.switchSelector).off('click.' + pluginName);
  }

  var checkOutOfview = function(switchBtn) {
    var paddingTop = 10,
        scrollDuration = 250,
        vars = this.vars,
        targetTop = switchBtn.offset().top - paddingTop;
    if (targetTop < vars.winElm.scrollTop()) {
      vars.bodyElm.animate({
        scrollTop: targetTop
      }, 250);
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
          opt = this.options;
      this.vars = {
        bodyElm: $('html, body'),
        winElm: $(window)
      }
      setExpandClickEvent.call(this);
    },
    destroy: function() {
      unsetExpandClickEvent.call(this);
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
    switchSelector: '.tab-title',
    contentSelector: '.tab-content',
    containerSelector: '.item',
    accordion: true,
    duration: 500,
    activeClass: 'active'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

;(function($, window) {
  L10n = {
    validation: {
      subcribe: {
        "require": "* Hang on, you haven't filled in all fields",
        "email": "* It looks like the email address you've entered is incorrect"
      }
    }
  };
}(jQuery, window));

/**
 *  @name load more
 *  @description This plugin is used for loading more article/news.
 *  @version 1.0
 *  @options
    loadMode: show/hide or ajax mode
    hideClass: 'hidden',
    itemClass: '.news-block',
    loadmoreClass: '.btn-viewmore',
    loadmoreWrap: '.text-center',
    ajaxUrl: 'assets/datas/news.json',
    newArticleClass: 'new',
    limit: 2,
    offset: 0
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'load-more',
      articleId = window.location.hash,
      sharingScript = '//s7.addthis.com/js/250/addthis_widget.js#domready=1';

  var setShowHideLoadmore = function() {
    var that = this,
        elem = this.element,
        opt = this.options,
        vars = this.vars,
        hideClass = opt.hideClass,
        loadmoreBtn = vars.loadmoreBtn,
        showPerLoad = opt.limit;

    function showMoreBlock() {
      var hideBlock = vars.items.filter('.' + opt.hideClass),
          hideBlockNum = hideBlock.length,
          loadNum = (showPerLoad > hideBlockNum) ? hideBlockNum : showPerLoad,
          curBlock = null,
          BlockIdx = 0;
      while (BlockIdx < limit) {
        curBlock = hideBlock.eq(BlockIdx);
        curBlock.removeClass(opt.hideClass).slideDown();
        TweenMax.fromTo(curBlock, 1,
        {
          y: -50,
          opacity: 0
        },
        {
          y: 0,
          opacity: 1
        });
        BlockIdx++;
      }
      (loadNum < showPerLoad) && loadmoreBtn.fadeOut();
    }

    loadmoreBtn.on('click.' + pluginName, function(e){
      e.preventDefault();
      showMoreBlock();
    });
  };

  var setAjaxLoadMore = function() {
    // LOAD MORE BLOCK USING AJAX
      var that = this,
          elem = this.element,
          vars = this.vars,
          opt = this.options,
          loadmoreWrap = vars.loadmoreWrap,
          newArticleClass = opt.newArticleClass,
          loadmoreBtn = vars.loadmoreBtn;

    function loadNewsAjax(successCallback) {
      var params = vars.newsOffset + '/' + vars.newsLimit;
      $.ajax({
        url: opt.ajaxUrl + params,
        success: function(news) {
          var moreNews = $(news.data);
          vars.newsLimit = news.limit;
          vars.newsOffset = news.offset;

          moreNews.insertBefore(loadmoreWrap);
          if(news.destination) {
            moreNews.find('.contextual-links a').each(function() {
              this.href = this.href.replace(/(destination=)[^\&]+/, '$1' + news.destination);
            });
          }
          if (!!news.flag) {
            loadmoreBtn.addClass(opt.hideClass);
            ($.isFunction(successCallback)) && successCallback(true);
          } else {
            ($.isFunction(successCallback)) && successCallback(false);
          }

          elem.find('.' + newArticleClass).each(function() {
            $(this)
              .removeClass(newArticleClass)
              .sharing();
          });

          // Get Addthis social sharing scripts and reinit buttons.
          if (window.addthis){
            window.addthis = null;
          }
          $.getScript( sharingScript , function() { addthis.init(); });

          setTimeout(function(){
            // Set timeout in case lately added elements.
            if ($.isFunction(Drupal.behaviors.contextualLinks.attach)) {
              Drupal.behaviors.contextualLinks.attach();
            }
          }, 500);

          Site.onAjaxSuccessHandle();
        }
      });
    };

    loadmoreBtn.on('click.' + pluginName, function(e){
      e.preventDefault();
      loadNewsAjax.call(that);
    });

    // CHECKING ANCHOR LINK WHEN USER GO FROM SOCIAL NETWORK
    // E.G: domain_name/news#article-1
    function scrollToArticle(stop) {
      var article = $(articleId);

      if (articleId === '' || articleId === '#') {
       return false;
      }

      if (!article.length) {
        (!stop) && loadNewsAjax.call(that, scrollToArticle);
      } else {
        setTimeout(function(){
          $('html, body').scrollTop(article.offset().top);
        }, 500);
      }
    }
    scrollToArticle(false);
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          opt = this.options;

      this.vars = {
        loadmoreBtn: that.element.find(opt.loadmoreClass),
        loadmoreWrap: null,
        items: that.element.find(opt.itemClass),
        newsLimit: opt.limit,
        newsOffset: opt.offset
      }
      this.vars.loadmoreWrap = this.vars.loadmoreBtn.closest(opt.loadmoreWrap);

      (opt.loadMode === 'showhide')
        ? setShowHideLoadmore.call(this)
        : setAjaxLoadMore.call(this);
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
      }
    });
  };

  $.fn[pluginName].defaults = {
    loadMode: 'ajax', // Including show/hide or ajax mode
    hideClass: 'hidden',
    itemClass: '.news-block',
    loadmoreClass: '.btn-viewmore',
    loadmoreWrap: '.text-center',
    ajaxUrl: 'assets/datas/news.json',
    newArticleClass: 'new',
    limit: 2,
    offset: 0
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name navigation
 *  @description Navigation toggle and sub navigations
 *  @version 1.0
 *  @options
 *  switchSelector: 'header .btn-menu',
    closeSelector: 'header .btn-close',
    duration: 300,
    subNavItem: '[data-subnav]',
    subNavList: '[data-subnav-list]',
    overlaySelector: '.overlay-navigation',
    inactiveLeft: '-75%',
    activeLeft: '0'
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'navigation',
      win = $(window),
      body = $('body'),
      htmlElm = $('html');

  var setSwitchNav = function() {
    var opt = this.options,
        that = this,
        elem = this.element,
        duration = opt.duration;
    $(opt.switchSelector).on('click', function() {
      if (Site.isMobile()) {
        showNav.call(that);
      }
    });

    that.vars.closeBtn.on('click.' + pluginName, function(){
      hideNav.call(that);
    });
    $(opt.overlaySelector).on('click.' + pluginName, function() {
      hideNav.call(that);
    });
  }

  var showNav = function() {
    var opt = this.options,
        that = this,
        elem = this.element,
        activeClass = opt.activeClass,
        duration = opt.duration;

    // IOS scrolling
    htmlElm.addClass('height-fixed');
    body.addClass('nav-show');

    TweenMax.to(elem, 0.5, {
      x: that.vars.navWidth,
      ease: Quad.easeOut,
      onComplete: function(){
        elem
          .attr('style', '')
          .css({left: opt.activeLeft})
          .addClass(activeClass);
        // Check cookie-notice popup issue

        function checkCookiePopup() {
          var cookieBanner = $('.cc_banner-wrapper.cloned'),
              bannerH = cookieBanner.outerHeight();
          if (cookieBanner.length) {
            elem.css({ marginTop: bannerH})
            that.vars.closeBtn.css({marginTop: bannerH})
          } else {
            elem.css({ marginTop: 'auto'});
            that.vars.closeBtn.attr('style', '');
          }
        }
        win
          .off('resize.cookieBannerNavAffect')
          .on('resize.cookieBannerNavAffect', function(){
            checkCookiePopup();
          })
          .trigger('resize.cookieBannerNavAffect');

        that.vars.closeBtn.addClass(activeClass);
      }
    })
    $(opt.overlaySelector).fadeIn(duration);
  };

  var hideNav = function() {
    var opt = this.options,
        that = this,
        elem = this.element,
        activeClass = opt.activeClass,
        duration = opt.duration;
    elem
      .removeClass(activeClass)
      .attr('style', '');
    that.vars.closeBtn.removeClass(activeClass);

    body.removeClass('nav-show');
    htmlElm.removeClass('height-fixed');

    TweenMax.to(elem, 0.5, {
      x: - that.vars.navWidth,
      ease: Quad.easeOut,
      onComplete: function() {
        elem
          .attr('style', '')
        closeSubNavs.call(that);
        win
          .trigger('resize.cookieBannerNavAffect')
          .off('resize.cookieBannerNavAffect');
      }
    });
    $(opt.overlaySelector).fadeOut(duration);
  };

  var setSubNav = function() {
    var that = this,
        opt = this.options,
        vars = this.vars,
        duration = opt.duration,
        subNavItem = vars.subNavItem,
        linkNavItem = vars.linkNavItem,
        activeClass = opt.activeClass,
        isMobile = Site.isMobile(),
        elem = this.element;

    if (isMobile) {
      subNavItem.closest('li').removeClass(activeClass);
      linkNavItem.closest('li').removeClass(activeClass);
    } else {
      subNavItem.closest('li').filter('.' + opt.curActiveClass).addClass(activeClass);
      linkNavItem.closest('li').filter('.' + opt.curActiveClass).addClass(activeClass);
    }

    function hideHandle(item) {
      var title = item.closest('li');
      if ((!title.hasClass(opt.curActiveClass) && !isMobile) || isMobile) {
        title.removeClass(activeClass);
      }
      title.find(opt.subNavList).removeClass(activeClass)
            .stop().slideUp(duration);
    }
    function showHandle(item) {
      var menuItem = item.closest('li'),
          subNavList = menuItem.find(opt.subNavList);

      subNavItem.removeClass(activeClass)
        .closest('li').each(function(){
          var item = $(this);
          if (!item.hasClass(opt.curActiveClass) && !isMobile || isMobile) {
            item.removeClass(activeClass)
          }
          item.find(opt.subNavList).stop().slideUp(duration);
        });

      if (isMobile) {
        menuItem.addClass(activeClass);
        subNavList.addClass(activeClass).stop().show();
        TweenMax.from(subNavList, 0.5,
        {
          height: 0
        });
      } else {
        menuItem.addClass(activeClass);
        subNavList.stop().slideDown(duration);
      }

    }
    linkNavItem.closest('li')
      .off('mouseenter.' + pluginName + ', mouseover.' + pluginName)
      .on('mouseenter.' + pluginName + ', mouseover.' + pluginName, function(e){
        if (!isMobile) {
          $(this).addClass(activeClass);
          e.preventDefault();
        }
      })
      .off('mouseleave.' + pluginName)
      .on('mouseleave.' + pluginName, function(e){
        var item = $(this);
        if (!isMobile && !item.hasClass(opt.curActiveClass)) {
          $(this).removeClass(activeClass);
          e.preventDefault();
        }
      });
    subNavItem.closest('li')
      .off('mouseenter.' + pluginName)
      .on('mouseenter.' + pluginName, function(e){
        if (!isMobile) {
          showHandle($(this).find(opt.subNavItem));
        }
      })
      .off('mouseleave.' + pluginName)
      .on('mouseleave.' + pluginName, function(e){
        if (!isMobile) {
          hideHandle($(this).find(opt.subNavItem));
        }
      });
    subNavItem
      .off('click.' + pluginName)
      .on('click.' + pluginName, function(e){
          if (isMobile) {
            (!$(this).closest('li').hasClass(activeClass)) ? showHandle($(this)) : hideHandle($(this));
          }
          e.preventDefault();
      });
  };

  var closeSubNavs = function(callback) {
    var opt = this.options,
        activeClass = opt.activeClass,
        elem = this.element;
    this.vars.subNavItem
      .closest('li' + ((!Site.isMobile()) ? ('not(.' + opt.curActiveClass) : '')).removeClass(activeClass);
    this.vars.subNavList.removeClass(activeClass).attr('style', '');
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          opt = this.options,
          elem = this.element;

      this.vars = {
        subNavItem: elem.find(opt.subNavItem),
        menuItem: elem.find(opt.menuItem),
        closeBtn: $(opt.closeSelector),
        linkNavItem: elem.find('nav > ul > li > a:not(' + opt.subNavItem + ')'),
        subNavList: elem.find(opt.subNavList),
        navWidth: elem.outerWidth()
      };

      setSwitchNav.call(this);
      setSubNav.call(this);
      win.on('resize.' + pluginName, function() {
        that.vars.navWidth = elem.outerWidth();
        if (Site.changeScreenMode()) {
          setSubNav.call(that);
          hideNav.call(that);
        }
      });
    },
    hideNavigation: function() {
      hideNav.call(this);
    },
    destroy: function() {
      var elm = this.element,
          opt = this.options;
      $.removeData(this.element[0], pluginName);
      elm.find('.' + opt.groupClass).show();
      elm.find('.' + opt.renderClass).removeClass('hide');
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
    switchSelector: 'header .btn-menu',
    closeSelector: '.nav-close',
    duration: 300,
    menuItem: '.menu-bar > ul > li a:not([data-subnav])',
    subNavItem: '[data-subnav]',
    subNavList: '[data-subnav-list]',
    overlaySelector: '.overlay-navigation',
    curActiveClass: 'current',
    inactiveLeft: '-75%',
    activeLeft: '0',
    activeClass: 'active'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name placeholder
 *  @description This plugin is used for add placeholder to input-fields (default pladeholder doesnot support IE9)
 *  @version 1.0
 *  @options
 *  checkIn: ['click', 'focus'],
    checkOut: ['focusout']
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'placeholder';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          opt = this.options,
          elem = this.element,
          checkInEvents = '',
          checkOutEvents = '',
          textElm = $('label[for="' + elem.attr('id') + '"]');

      opt.checkIn.forEach(function(e) {
        checkInEvents += ((checkInEvents !== '') ? ', ' : '') + e + '.' + pluginName;
      });
      opt.checkOut.forEach(function(e){
        checkOutEvents += e + '.' + pluginName;
      });

      elem
        .val('')
        .on(checkInEvents, function() {
          textElm.addClass('hidden');
        })
        .on(checkOutEvents, function() {
          ($(this).val() !== '') ? textElm.addClass('hidden') : textElm.removeClass('hidden');
        });
    },
    resetField: function() {
      var elem = this.element;
      elem.val('');
      $('label[for="' + elem.attr('id') + '"]').removeClass('hidden');
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
      }
    });
  };

  $.fn[pluginName].defaults = {
    checkIn: ['click', 'focus'],
    checkOut: ['focusout']
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name popup
 *  @description This plugin is used to show/hide popups
 *  @version 1.0
 *  @options
    target: '.popin-newsletter',
    closeBtn: '.btn-close-popin',
    hideClass: 'hidden',
    overlaySel: '.overlay',
    defaultBlock: '.default-block',
    contentBlock: '.content-block'
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'popin',
      winElm = $(window);

  var hidePopin = function() {
    var that = this,
        target = this.vars.targetElm;

    if (!TweenMax.isTweening(target)) {
      TweenMax.to(target, 0.75, {
        y: -100,
        opacity: 0,
        onComplete: function(){
          target
            .addClass(that.options.hideClass)
            .attr('style', '');
          setBodyFixed.call(that, true);
          winElm.trigger('popinClose');
          winElm.trigger('resize.popinHeightAffect');

          if (typeof that.options.afterHideCallback === 'function') {
            that.options.afterHideCallback();
          }
        }
      });
    }
  };

  var setPopinLeft = function() {
    var target = this.vars.targetElm;
    if (!Site.isCustomMobile()) {
      target.css({
        left: (winElm.width() - target.outerWidth()) / 2
      });
    } else {
      // target.attr('style', '');
      target.css('left', '');
    }
  };

  var setDefaultView = function(elem) {
    var opt = this.options,
        defaultClass = opt.defaultBlock,
        defaultBlock = elem.find(defaultClass),
        contentClass = opt.contentBlock;
    if (!defaultBlock.is(':visible')) {
      elem.find(contentClass).not(defaultClass).hide();
      defaultBlock
        .show()
        .find('.error-form').removeClass('error-form').end()
        .find('.error').removeClass('error').end()
        .find('.error-text').remove().end()
        .find('[data-placeholder]')['placeholder']('resetField');
    }
  };

  var showPopin = function() {
    var that = this,
        opt = this.options,
        target = this.vars.targetElm,
        isMobile = Site.isMobile();
    target.removeClass(opt.hideClass);

    if (typeof opt.beforeShowCallback === 'function') {
      opt.beforeShowCallback();
    }

    function mobileHandle() {
      $('[data-navigation]')['navigation']('hideNavigation', true);
    }

    function checkOutOfView() {
      var paddingTop = 80,
          targetTop = target.offset().top;
      if (winElm.scrollTop() > targetTop) {
        $('html, body').animate({
          scrollTop: targetTop - paddingTop
        });
      }
    }


    function checkPopinHeight() {
      if (Site.isIos() && Site.isMobile()) {
        target.css({
          height: winElm.height(),
          bottom: 'auto'
        });
      } else {
        target.attr('style', '');
      }
    }

    winElm
      .off('resize.popinHeightAffect')
      .on('resize.popinHeightAffect', function() {
        checkPopinHeight();
      }).trigger('resize.popinHeightAffect');

    winElm
      .off('resize.checkOverlay' + pluginName)
      .on('resize.checkOverlay' + pluginName, function(){
        setBodyFixed.call(that);
        setPopinLeft.call(that);
      });
    (isMobile) ? mobileHandle() : setPopinLeft.call(this);

    if (!TweenMax.isTweening(target)) {
      setDefaultView.call(that, target);
      checkOutOfView();
      TweenMax.fromTo(target, 0.75,
      {
        y: -100,
        opacity: 0
      },
      {
        y: 0,
        opacity: 1,
        onComplete: function() {
          target.css({
            opacity: '',
            transform: '',
          });

          winElm.trigger('resize.popinHeightAffect');
          winElm.trigger('resize.checkOverlay' + pluginName);

          (isMobile) && setBodyFixed.call(that);
        }
      });
    }
  };

  var setBodyFixed = function(force) {
    var body = $('body'),
        htmlElm = $('html');
    if (!Site.isMobile() || force || !this.vars.targetElm.is(':visible')) {
      htmlElm.removeClass('height-fixed');
      body.removeClass('body-fixed');
    } else {
      htmlElm.addClass('height-fixed');
      body.addClass('body-fixed');
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
          opt = this.options;

      this.vars = {
        targetElm: $(opt.target),
        overlay: $(opt.overlaySel)
      }

      this.element.on('click.' + pluginName, function(e){
        e.preventDefault();
        showPopin.call(that);
      });

      this.vars.targetElm.find(opt.closeBtn).on('click', function(e){
        e.preventDefault();
        hidePopin.call(that);
      });

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
      }
    });
  };

  $.fn[pluginName].defaults = {
    target: '.popin-newsletter',
    closeBtn: '.btn-close-popin',
    hideClass: 'hidden',
    overlaySel: '.overlay',
    defaultBlock: '.default-block',
    contentBlock: '.content-block',
    beforeShowCallback: '',
    afterHideCallback: ''
  };

  $(function() {
    var cookieCloneBlock = '';
    $('[data-' + pluginName + ']')[pluginName]({
      beforeShowCallback: function() {
        if (0 === cookieCloneBlock.length) {
          cookieCloneBlock = $('.cc_banner-wrapper.cloned');
        }
        if (!Site.isMobile()) { return; }
        cookieCloneBlock.addClass('hidden');
      },
      afterHideCallback: function() {
        if (0 === cookieCloneBlock.length) {
          cookieCloneBlock = $('.cc_banner-wrapper.cloned');
        }
        if (!Site.isMobile()) { return; }
        cookieCloneBlock.removeClass('hidden');
      }
    });

    winElm.on('resize orientationchange', function() {
      if (0 === cookieCloneBlock.length) {
        cookieCloneBlock = $('.cc_banner-wrapper.cloned');
      }
      if (!Site.isMobile()) {
        cookieCloneBlock.removeClass('hidden');
      }
      else {
        var popinShowed = $('.popin:not(.hidden)');
        if (popinShowed.length) {
          cookieCloneBlock.addClass('hidden');
        } else {
          cookieCloneBlock.removeClass('hidden');
        }
      }
    })
  });

}(jQuery, window));

/**
 *  @name sharing
 *  @description This plugin is only used for showing or hideing sharing button. About the sharing activities, Addthis will handle it.
 *  @version 1.0
 *  @options
    shareToggle: '.btn-share',
    shareWrap: '.social-share'
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'sharing';

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          elem = this.element,
          opt = this.options,
          shareWrap = opt.shareWrap,
          shareWrapElm = elem.find(shareWrap);

      elem.find(opt.shareToggle)
        .on('click.' + pluginName, function(e){
          e.preventDefault();
          shareWrapElm.slideToggle();
        });

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
      }
    });
  };

  $.fn[pluginName].defaults = {
    shareToggle: '.btn-share',
    shareWrap: '.social-share'
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name slider
 *  @description This plugin will using slick slider and extend it with specific options that serve Babybel pages
 *  @version 1.0
 *  @options
 *  mode: 'full',
    fade: true,
    carouselFade: false,
    slide: 'li',
    autoplay: true,
    delay: 5000,
    showNum: 3,
    dots: true,
    infinite: false,
    onlyMobile: false,
    moveby: 1
 *  @methods
 *    init
 *    destroy
 */

;(function($, window) {
  'use strict';

  var pluginName = 'slider',
      win = $(window);

  var checkMobileDots = function(opt) {
    if (opt.mobileDots) {
      opt.dots = (!Site.isMobile()) ? false : true;
    }
  };

  var setNavBtnPosition = function() {
    var elem = this.element,
        opt = this.options,
        padding = 10,
        elemTop = elem.offset().top,
        contenTop = elem.find('.wrap-content').offset().top,
        dots = elem.find('ul.slick-dots'),
        top = contenTop - elemTop - padding;

    (Site.isMobile()) ? dots.css({ top: top }) : dots.css({ top: '' });
  };

  var checkNavBtn = function() {
    var that = this,
        opt = this.options;
    if (opt.setNavPosition) {
      setNavBtnPosition.call(that);

      // One more checking for a lately setted sizes.s
      setTimeout(function(){
        setNavBtnPosition.call(that);
      }, 300);

      win
        .off('resize.setNavPos' + pluginName)
        .on('resize.setNavPos' + pluginName, function(){
          setNavBtnPosition.call(that);
        });
    }
  };

  var initFullSlider = function() {
    var that = this,
        opt = this.options,
        vars = this.vars,
        elem = this.element;

    if (vars.slideInit) {
      unsetSlickCarousel.call(this);
    }

    checkMobileDots(opt);

    elem.on('init', function(){
      checkNavBtn.call(that);
    });

    elem.slick({
      slide: opt.slide,
      fade: opt.fade,
      dots: opt.dots,
      arrows: opt.arrows,
      infinite: opt.infinite,
      autoplay: opt.autoplay,
      autoplaySpeed: opt.delay,
      swipe: opt.swipe
    });

    this.vars.slideInit = true;
  };

  var checkCarouselEvents = function() {
    var that = this,
        elem = this.element,
        vars = this.vars,
        opt = this.options;

    win.on('resize.' + pluginName, function() {
      clearTimeout(vars.timer);
      vars.timer = setTimeout(function() {
        var isMobile = Site.isMobile();
        (elem.data('tab-content') !== undefined && Site.isRealResize()) && elem['tab-content']('collapseContent');

        if (isMobile) {
          vars.realShowNum = opt.showNum;
          opt.showNum = opt.showMobileNum;
          setSlickCarousel.call(that);
        } else {
          opt.showNum = vars.realShowNum;
          (opt.onlyMobile) ? unsetSlickCarousel.call(that) : setSlickCarousel.call(that);
        }
      }, 400);
    });
  };

  var cloneDotNavOutside = function() {
    var elem = this.element,
        opt = this.options,
        vars = this.vars,
        slickDotsSel = opt.slickDotsSel,
        dots = elem.find(slickDotsSel),
        outsideDots = elem.next(slickDotsSel);

    if (outsideDots.length) {
      outsideDots.remove();
    }
    vars.slideContainer.append(dots);
  };

  var setArrowTopBy = function(container) {
    var elem = this.element,
        containerElm = elem.closest(container),
        arrows = elem.find('button.slick-arrow'),
        sliderTop = elem.offset().top - containerElm.offset().top;
    if (!Site.isMobile()) {
      elem.find('.slick-slide img').each(function(){
        var img = $(this);
        if (!img.height()) {
          img.get(0).onload = function(){
            arrows.css({
              top: sliderTop + (img.height() / 2) + 'px'
            });
          }
        } else {
          arrows.css({
            top: sliderTop + (img.height() / 2) + 'px'
          });
        }
      });
    }
  }

  var setSlickCarousel = function() {
    var that = this,
        opt = this.options,
        elem = this.element,
        vars = this.vars,
        isMobile = Site.isMobile(),
        setArrowTop = opt.setArrowTop;

    if (vars.slideInit) {
      unsetSlickCarousel.call(this);
    }

    checkMobileDots(opt);
    elem.slick({
      dots: opt.dots,
      slide: opt.slide,
      arrows: opt.arrows,
      fade: opt.carouselFade,
      autoplay: opt.autoplay,
      autoplaySpeed: opt.delay,
      infinite: opt.infinite,
      slidesToShow: opt.showNum,
      slidesToScroll: opt.moveby,
      swipe: opt.swipe
    });

    var moreBtn = elem.find('.item.cta-seemore:not(.slick-cloned)').eq(0);
    if (isMobile && moreBtn.length) {
      elem.slick('slickRemove', moreBtn.data('slick-index'), false);
    } else if (!isMobile && 0 !== vars.seeMoreBtn.length) {
      elem.slick('slickAdd', vars.seeMoreBtn[0], 5, 3);
    }

    function setArrowHeight(onResize) {
      if (Site.isMobile()) {
        var img = elem.find('.slick-slide.slick-active').find('img').get(0);
        var h = 0;
        if (onResize === undefined) {
          img.onload = function() {
            elem.find('button.slick-arrow').height($(this).height());
          }
        }
        setTimeout(function(){
          h = elem.find('.slick-slide.slick-active').find('img').height();
          elem.find('button.slick-arrow').height(h);
        }, 90);
      }
    }

    if (elem.data('tab-content') !== undefined || opt.setArrowHeight) {
      setArrowHeight();
      // Set slick-arrows height
      elem.on('init', function(){
        setArrowHeight();
      });
      win.on('resize.' + pluginName, function(){
        setArrowHeight(true);
      });
    }

    elem.on('init.checkNavBtn', function(){
      checkNavBtn.call(that);
    });

    setTimeout(function() {
      if (setArrowTop !== null) {
        setArrowTopBy.call(that, setArrowTop);
        win.on('resize.setArrowTop' + pluginName, function(){
          setArrowTopBy.call(that, setArrowTop);
        });
      }
    }, 400);

    if (elem.data('tab-content') !== undefined) {
      // If this slider is applied plugin "tab-content". It will hide tab-content when change slide
      elem.on('afterChange.' + pluginName, function(e, slick, curSlide){
        if (curSlide !== vars.curSlide) {
          elem['tab-content']('collapseContent');
          vars.curSlide = curSlide;
        }
      });
    }

    vars.slideInit = true;
  };

  var unsetSlickCarousel = function() {
    var vars = this.vars,
        opt = this.options,
        elem = this.element;
    if (vars.slideInit) {
      if (this.options.cloneDots) {
        vars.slideContainer.find('>' + opt.slickDotsSel).remove();
      }
      elem.slick('unslick');
      vars.slideInit = false;
    }
  };

  var initCarouselSlider = function() {
    var opt = this.options,
        elem = this.element,
        fade = false,
        isMobile = Site.isMobile();

    this.vars.seeMoreBtn = elem.find('.item.cta-seemore').eq(0);
    this.vars.seeMoreBtnIdx = this.vars.seeMoreBtn.index();

    if (isMobile) {
      this.vars.realShowNum = opt.showNum;
      opt.showNum = opt.showMobileNum;
      this.vars.seeMoreBtn.remove();
    }
    if ((!isMobile && !opt.onlyMobile) || isMobile) {
      setSlickCarousel.call(this, elem, opt);
    }

    checkCarouselEvents.call(this);
  };

  var initSlider = function() {
    var that = this,
        opt = this.options;

    switch (opt.mode) {
      case 'full':
        initFullSlider.call(that);
        break;
      case 'carousel':
        initCarouselSlider.call(that);
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
          opt = this.options;

      this.vars = {
        slideInit: false,
        realShowNum: 0,
        curSlide: 0,
        timer: null,
        slideContainer: that.element.parent('div')
      };

      if (opt.cloneDots) {
        this.element.on('init', function(){
          cloneDotNavOutside.call(that);
        });
      }
      initSlider.call(this);
    },
    destroy: function() {
      this.element.slick('unslick');
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
    mode: 'full',
    slickDotsSel: 'ul.slick-dots',
    fade: true,
    carouselFade: false,
    slide: 'li',
    arrows: true,
    autoplay: true,
    swipe: true,
    delay: 5000,
    showNum: 3,
    showMobileNum: 1,
    dots: true,
    mobileDots: false,
    cloneDots: false,
    infinite: true,
    onlyMobile: false,
    setNavPosition: false,
    setArrowHeight: false,
    setArrowTop: null,
    moveby: 1
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));

/**
 *  @name step-show
 *  @description This plugin is used to show up steps one by one when user scroll the screen
 *  @version 1.0
 *  @options
    animateDuration: 0.5,
    mobileAnimateDuration: 1,
    timeoutShow: 100,
    offsetDiff: 50,
    item: '.item'
 *  @methods
 */

;(function($, window) {
  'use strict';

  var pluginName = 'step-show',
      win = $(window),
      isIE9 = Site.isIe9(),
      body = $('body');

  var initSteps = function(){
    var that = this,
        opt = this.options,
        animateDuration = opt.animateDuration,
        namespace = pluginName + Math.random();
    win.on('scroll.' + namespace, function() {
      var listItem = that.vars.items.not('.inited').filter(':visible'),
          topPos = (window.innerHeight ? window.innerHeight : win.height()) + win.scrollTop(),
          timeout = opt.timeoutShow;

      if(body.data('scrolling')) {
        return;
      }

      if (Site.isMobile()) {
        animateDuration = opt.mobileAnimateDuration;
      }

      listItem.each(function() {
        var item = $(this);
        if(!item.hasClass('inited')) {
          if(item.offset().top + opt.offsetDiff < topPos ) {
            item.addClass('inited');
            TweenMax.fromTo(item, animateDuration,
            {
              opacity: 0,
              y: 100
            },
            {
              opacity: 1,
              y: 0,
              onComplete: function() {
                item
                  .attr('style', '')
                  .addClass('showed')
              }
            })
            timeout += opt.timeoutShow;
          }
        }
      });
    }).trigger('scroll.' + namespace);
  };

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  Plugin.prototype = {
    init: function() {
      var that = this,
          opt = this.options;

      this.vars = {
        items: $(opt.item),
        animateDuration: 0.5
      }

      $('html, body').scrollTop(0);
      initSteps.call(this);

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
      }
    });
  };

  $.fn[pluginName].defaults = {
    animateDuration: 0.5,
    mobileAnimateDuration: 1,
    timeoutShow: 100,
    offsetDiff: 50,
    item: '.item'
  };

  $.easing.jswing = $.easing.swing;

  $.extend($.easing, {
    easeOutCubic: function (x, t, b, c, d) {
      return c*((t=t/d-1)*t*t + 1) + b;
    }
  });

  $(function() {
    if(!isIE9) {
      $('html').addClass('not-ie9');
    }
    setTimeout(function() {
      $('[data-' + pluginName + ']')[pluginName]();
    }, 1000);
  });

}(jQuery, window));

/**
 *  @name tabs content
 *  @description This plugin used to expand/collapse tab contents
 *  @version 1.0
 *  @options
 *  activeClass: 'active',
    tabItem: 'li.item:not(.slick-cloned)',
    allTabItems: 'li.item', // Including slick-clone items
    contentItem: '.tabs-content',
    contentInner: '.tabs-panel',
    closeBtnClass: '.btn-panel-close',
    itemPerLine: 4,
    standardItemPerLine: 4,
    duration: 0.6,
    collapseDuration: 0.1,
    slideUpDuration: 0.4,
    slideUpDistance: -80,
    setArrows: true
 *  @methods
 *    init
 *    destroy
 *    collapseContent
 */

;(function($, window) {
  'use strict';

  var pluginName = 'tab-content',
      win = $(window);

  var isOdd = function(num) {
    return (num % 2) !== 0;
  }

  var setTrianglePosition = function(){
    var that = this,
        vars = this.vars,
        opt = this.options,
        itemPerLine = opt.itemPerLine,
        itemPerLineRatio = opt.standardItemPerLine / itemPerLine,
        contElm = vars.contentItemElm,
        contNum = contElm.length,
        numLine = Math.ceil(contNum / itemPerLine),
        lastLineNum = contNum % itemPerLine;

    function addArrowClass(item, type, ind){
      item.addClass(type + '-' + ind);
    }

    contElm.each(function(){
      var item = $(this),
          ind = contElm.index(item) + 1,
          indOnLine = ind % itemPerLine,
          lineNum = Math.ceil(ind / itemPerLine);

      indOnLine = (indOnLine === 0) ? itemPerLine : indOnLine;

      function setItemClass(item, itemNum) {
        var className = isOdd(itemNum) ? 'odd' : 'even';
        addArrowClass(item, className, indOnLine * itemPerLineRatio);
      }

      if (lineNum < numLine) {
        setItemClass(item, itemPerLine);
      } else {
        switch (lastLineNum) {
          case 1: indOnLine = 2;break; // Will be odd-2
          case 2: indOnLine = indOnLine + 1;break; // Will be even-2 and even-4
        }
        setItemClass(item, lastLineNum);
      }
    });
  };

  var setTabPadBot = function(tab, padBot){
    var overBackground = 32;
    padBot = (padBot === '') ? 0 : (padBot + overBackground);
    TweenMax.to(tab, this.options.slideUpDuration, {
      css: {paddingBottom: padBot},
      onComplete: function(){
        (!padBot) && tab.css({'padding-bottom': ''});
      }
    });
  };

  var checkContentOutOfView = function(tab, content) {
    var contentTop = content.offset().top,
        differDis = 100,
        moveUpDis = 350,
        winH = win.height(),
        winBottom = win.scrollTop() + winH;

    if (winBottom < contentTop + differDis) {
      $('body, html').animate({
        scrollTop: contentTop - (winH - moveUpDis)
      }, 450);
    }
  };

  var toggleTabContent = function(tab) {
    var that = this,
        opt = this.options,
        tabID = tab.data('tab-id'),
        activeClass = opt.activeClass,
        duration = opt.duration,
        slideUpDistance = opt.slideUpDistance,
        vars = this.vars,
        contentItems = vars.contentItemElm,
        tabItems = vars.tabItemElm,
        targetContentWrap = contentItems.filter('[data-id="' + tabID + '"]'),
        targetContent = targetContentWrap.find(opt.contentInner),
        contentInner = null;

    contentItems = contentItems.filter(':not([data-id="' + tabID + '"])');

    if (targetContent.hasClass(activeClass)) {
      targetContentWrap.show().removeClass(activeClass);
      targetContent.removeClass(activeClass);
      setTabPadBot.call(that, tab, '');

      TweenMax.to(targetContent, opt.slideUpDuration, {
        y: slideUpDistance,
        opacity: 0,
        ease: Power3.easeIn,
        onComplete: function(){
          targetContentWrap.hide();
        }
      });
    } else {
      contentInner = contentItems.find(opt.contentInner);
      setTabPadBot.call(that, tabItems, '');
      contentItems.removeClass(activeClass);
      TweenMax.to(contentInner, opt.duration, {
        opacity: 0,
        y: slideUpDistance,
        onComplete: function() {
          contentInner.hide();
          contentInner
            .removeClass(activeClass)
            .closest(opt.contentItem).hide().removeClass(activeClass);
        }
      });

      targetContentWrap.show();
      targetContent.show();
      targetContent.addClass(activeClass);
      setTabPadBot.call(that, tab, targetContentWrap.outerHeight());
      TweenMax.fromTo(targetContent, opt.duration, {
        y: slideUpDistance,
        opacity: 0
      },
      {
        y: 0,
        opacity: 1,
        ease: Power1.easeIn,
        onComplete: function(){
          if (!Site.isMobile()) {
            checkContentOutOfView.call(that, tab, targetContentWrap);
          }
          targetContentWrap.addClass(activeClass);
          setTabPadBot.call(that, tab, targetContentWrap.outerHeight());
        }
      });
    }
  };

  var collapseTabContent = function(onResize) {
    var that = this,
        vars = this.vars,
        opt = this.options,
        elem = this.element,
        contentItems = vars.contentItemElm,
        tabItems = vars.tabItemElm,
        visibleContent = contentItems.find(opt.contentInner),
        activeClass = opt.activeClass;
    contentItems.removeClass(activeClass);

    if (onResize !== undefined) {
      tabItems = elem.find(opt.allTabItems);
      contentItems = elem.find(opt.contentItem);
    }

    if (!visibleContent.length) {
      setTabPadBot.call(that, tabItems, '');
    } else {
      setTabPadBot.call(that, tabItems, '');
      visibleContent.removeClass(activeClass);
      TweenMax.to(visibleContent, opt.collapseDuration, {
        opacity: 0,
        y: opt.slideUpDistance,
        ease: Power3.easeIn,
        onComplete: function(){
          setTabPadBot.call(that, tabItems, '');
          contentItems.hide();
        }
      });
    }
  };

  var bindTabContents = function() {
    var that = this,
        vars = this.vars,
        opt = this.options,
        elem = this.element;
    vars.tabItemElm.find('> a').on('click.' + pluginName, function(e){
        e.preventDefault();
        toggleTabContent.call(that, $(this).closest(opt.tabItem));
      });
    vars.contentItemElm.find(opt.closeBtnClass).on('click', function(e){
      e.preventDefault();
      collapseTabContent.call(that);
    });

    // Setting position of triangle
    if (opt.setArrows) {
      setTrianglePosition.call(this);
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
          elem = this.element,
          opt = this.options,
          tabItemElm = elem.find(opt.tabItem),
          namespace = null;

      this.vars = {
        tabItemElm: tabItemElm,
        contentItemElm: tabItemElm.find(opt.contentItem),
        namespace: pluginName + Math.random() * 1000
      };
      namespace = this.vars.namespace;
      win
        .off('resize.' + namespace)
        .on('resize.' + namespace, function(){
          if (Site.isRealResize()) {
            collapseTabContent.call(that, true);
          }
        });

      bindTabContents.call(this);
    },
    destroy: function() {

    },
    collapseContent: function() {
      collapseTabContent.call(this);
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
    activeClass: 'active',
    tabItem: 'li.item:not(.slick-cloned)',
    allTabItems: 'li.item', // Including slick-clone items
    contentItem: '.tabs-content',
    contentInner: '.tabs-panel',
    closeBtnClass: '.btn-panel-close',
    itemPerLine: 4,
    standardItemPerLine: 4,
    duration: 0.6,
    collapseDuration: 0.1,
    slideUpDuration: 0.4,
    slideUpDistance: -80,
    setArrows: true
  };

  $(function() {
    $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));


// MOVE THIS TO A SPECIFIC JS FILE: expandable
/**
 *  @name video-control
 *  @description Video component controller
 *  @version 1.0
 *  @options
 *  playerContainer: '.main-video',
    overlayPlayBtn: 'a.btn-play',
    thumbContainer: '.thumbnail',
    thumbSelector: '.item',
    getVideoIdFrom: 'data',
    videoIdProp: 'video-id',
    loadmoreClass: 'btn-seemore',
    activeClass: 'active',
    videoAutoplay: true,
    videoShowinfo: false,
    related: false,
    videoWrapperTemplate: '<div class="embed-responsive embed-responsive-16by9"></div>',
    embedVideoTemplate: '<iframe type="text/html" src="https://www.youtube.com/embed/{{id}}?autoplay={{autoplay}}&showinfo={{showinfo}}&rel={{related}}" allowfullscreen/>'
 *  @methods
 *    init
 *    destroy
 */

;(function($, window) {
  'use strict';

  var pluginName = 'video-control',
      win = $(window);

  var loadNewVideo = function(videoID, target) {
    var elem = this.element,
        opt = this.options,
        videoPlayer = elem.find(opt.playerContainer),
        autoplay = target.data('autoplay'),
        showinfo = target.data('showinfo'),
        related = target.data('related'),
        videoParams = {
          id: videoID,
          autoplay: (autoplay !== undefined) ? (+ autoplay) : (+ opt.videoAutoplay),
          showinfo: (showinfo !== undefined) ? (+ showinfo) : (+ opt.videoShowinfo),
          related: (related !== undefined) ? (+ related) : (+ opt.related)
        },
        videoTemplate = Handlebars.compile(opt.embedVideoTemplate),
        embedVideo = videoTemplate(videoParams),
        videoWrapper = $(opt.videoWrapperTemplate);

    videoWrapper.html(embedVideo);
    videoPlayer
      .html('')
      .append(videoWrapper);
  };

  var initOverlay = function() {
    var opt = this.options,
        that = this;
    this.element.find(opt.overlayPlayBtn).on('click.' + pluginName, function(e){
      var playBtn = $(this);
      loadNewVideo.call(that, playBtn[opt.getVideoIdFrom](opt.videoIdProp), playBtn);
      e.preventDefault();
    });
  };

  var bindingVideoController = function() {
    var that = this,
        elem = this.element,
        opt = this.options,
        activeClass = opt.activeClass,
        thumbSelector = opt.thumbSelector,
        thumbItems = elem.find(opt.thumbContainer + ' ' + thumbSelector),
        thumbAnchors = thumbItems.find('a');

    thumbAnchors.on('click.' + pluginName, function(e){
      var self = $(this),
          thumbItem = self.closest(thumbSelector),
          videoID = self[opt.getVideoIdFrom](opt.videoIdProp);

      if (videoID !== undefined && !thumbItem.hasClass(activeClass)) {
        loadNewVideo.call(that, videoID, self);
        thumbItems.removeClass(activeClass);
        thumbItem.addClass(activeClass);
      }
      if (!self.hasClass(opt.loadmoreClass)) {
        e.preventDefault();
      }
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
          opt = this.options;

      initOverlay.call(this);
      bindingVideoController.call(this);
    },
    destroy: function() {
      var elm = this.element;
      // Need to update if necessary
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
    playerContainer: '.main-video',
    overlayPlayBtn: 'a.btn-play',
    thumbContainer: '.thumbnail',
    thumbSelector: '.item',
    getVideoIdFrom: 'data',
    videoIdProp: 'video-id',
    loadmoreClass: 'btn-seemore',
    activeClass: 'active',
    videoAutoplay: true,
    videoShowinfo: false,
    related: false,
    videoWrapperTemplate: '<div class="embed-responsive embed-responsive-16by9"></div>',
    embedVideoTemplate: '<iframe type="text/html" src="https://www.youtube.com/embed/{{id}}?autoplay={{autoplay}}&showinfo={{showinfo}}&rel={{related}}" allowfullscreen/>'
  };

  $(function() {
    win.on(Site.events.AJAX_SUCCESS + '.video-control', function() {
      $('[data-' + pluginName + ']')[pluginName]();
    }).trigger(Site.events.AJAX_SUCCESS + '.video-control');
  });

}(jQuery, window));
