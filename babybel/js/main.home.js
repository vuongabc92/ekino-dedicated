(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
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

},{}]},{},[1]);
