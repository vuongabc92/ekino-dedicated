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