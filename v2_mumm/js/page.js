(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
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
    AJAX_SUCCESS: 'load-ajax-success'
  };

  var checkMobile = function() {
    return window.innerWidth <= mobileMaxWidth;
  };

  var freezeMenu = function(){
    htmlBody.addClass('freeze');
  };

  var unfreezeMenu = function(){
    var blocks = $('[data-popup]:visible, .overlay:visible');
    if (0 === blocks.length) {
      htmlBody.removeClass('freeze');
    }
  };

  var freezePage = function() {
    body.addClass('freeze');
  }
  var unfreezePage = function() {
    var blocks = $('[data-popup]:visible, .overlay:visible');
    if (0 === blocks.length) {
      body.removeClass('freeze');
    }
  }

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
    events: GlobalEvents
  };



})(jQuery, window);

jQuery(function($) {
  window.Site.correctSliderPos();
  $(window).on('load',function() {
    if($('html').hasClass('android')){
      $('.grayscale').each(function(){
        var el = $(this);
        el.addClass('img_grayscale').insertBefore(el).queue(function(){
          el.dequeue();
          el.attr('src', window.Site.grayscale(el.attr('src')));
        });
      });
    }
  });
});

},{}]},{},[1]);
