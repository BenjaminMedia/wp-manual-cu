(function() {
  'use strict';
  var $, Banners;

  $ = jQuery;

  Banners = (function() {
    function Banners() {
      var lazyLoadSetting;
      lazyLoadSetting = $('meta[name="banner-lazyload"]').attr('content');
      this.bannerReloadFrequency = parseInt($('meta[name="banner-reload-frequency"]').attr('content'));
      this.countSlideChange = 0;
      this.startTime = Date.now();
      this.savedTime = this.startTime;
      this.adBlockIsChecked = false;
      if (lazyLoadSetting != null) {
        this.lazyLoad = JSON.parse(lazyLoadSetting);
      } else {
        this.lazyLoad = false;
      }
      this.init();
    }

    Banners.prototype.init = function() {
      var pageReady;
      $(window).load((function(_this) {
        return function() {
          _this.$bannerLarge = $('[data-banner-md-lg]');
          _this.$bannerSmall = $('[data-banner-sm]');
          _this.$bannerExtraSmall = $('[data-banner-xs]');
          _this.$gallery = $('[data-init="gallery-horizontal"]');
          _this.uuid = EAS_uuid();
          console.log('UUID: ' + _this.uuid);
          return _this.cleanDuplicatedCodes();
        };
      })(this));
      if (this.lazyLoad) {
        pageReady = false;
        $(window).load((function(_this) {
          return function() {
            if ($.breakpoints() === 'md' || $.breakpoints() === 'lg') {
              _this.$gallery.find('[data-banner-target]').attr('data-banner-target', false);
            }
            _this.insertInView();
            return pageReady = true;
          };
        })(this));
        $(document).on('interval-scroll', (function(_this) {
          return function() {
            if (pageReady) {
              return _this.insertInView();
            }
          };
        })(this));
        return $(document).on('horizontal-gallery-slide-change', (function(_this) {
          return function() {
            if (pageReady) {
              return _this.lazyLoadGallery();
            }
          };
        })(this));
      } else {
        return $(window).load((function(_this) {
          return function() {
            return _this.insertAll();
          };
        })(this));
      }
    };

    Banners.prototype.cleanDuplicatedCodes = function() {
      var self;
      self = this;
      return this.findBanners().each(function() {
        var $target, code;
        code = JSON.stringify($(this).data('bannerCode'));
        $target = $("[data-banner-code='" + code + "']");
        console.log(code);
        if ($target.length > 1 && code.indexOf(',') < 0) {
          return self.addUnderscoreIdsToDuplicates($target, code);
        }
      });
    };

    Banners.prototype.addUnderscoreIdsToDuplicates = function($target, code) {
      return $target.each(function(index) {
        var id;
        id = index + 1;
        return $(this).attr('data-banner-code', code + '_' + id);
      });
    };

    Banners.prototype.insertInView = function() {
      var e, error, scrollDistance, self;
      self = this;
      scrollDistance = $(window).scrollTop() + $(window).height() + 800;
      try {
        return this.findBanners().each(function() {
          var $target;
          $target = $(this);
          if ($target.offset().top < scrollDistance) {
            return self.prepareBanner($target);
          }
        });
      } catch (error) {
        e = error;
        return console.error("Unable to find any banner positions");
      }
    };

    Banners.prototype.insertAll = function() {
      var e, error, self;
      self = this;
      try {
        return this.findBanners().each(function() {
          return self.prepareBanner($(this));
        });
      } catch (error) {
        e = error;
        return console.error("Unable to find any banner positions");
      }
    };

    Banners.prototype.findBanners = function() {
      if ($.breakpoints() === 'md' || $.breakpoints() === 'lg') {
        return this.$bannerLarge.find('[data-banner-target]').not('[data-banner-target="false"]');
      } else if ($.breakpoints() === 'sm') {
        return this.$bannerSmall.find('[data-banner-target]').not('[data-banner-target="false"]');
      } else if ($.breakpoints() === 'xs') {
        return this.$bannerExtraSmall.find('[data-banner-target]').not('[data-banner-target="false"]');
      }
    };

    Banners.prototype.prepareBanner = function($target) {
      var code, codeArray;
      code = $target.data('banner-code');
      console.log(code);
      codeArray = code.toString().split(',');
      $target.attr('data-banner-target', false);
      this.placeIframeBanner($target, codeArray[0]);
      return this.shiftCodeArray(codeArray);
    };

    Banners.prototype.generateParameters = function() {
      var category, categoryParams, cxenseParams, url;
      cxenseParams = eas.hlp.getCxProfileCookieData();
      category = $('meta[name="banner-category"]').attr('content');
      url = window.location.protocol + "//" + window.location.host + window.location.pathname;
      if (category != null) {
        categoryParams = "&cat=" + category;
      } else {
        categoryParams = '';
      }
      return ("cre=mu&js=y&target=_blank&url=" + url + "&pageviewid=" + this.uuid) + categoryParams + cxenseParams;
    };

    Banners.prototype.placeIframeBanner = function($target, code) {
      var id;
      id = "banner-" + (Math.floor((Math.random() * 999999999) + 1));
      $target.attr('id', id).empty().parent().addClass('text-center');
      if ($target.parent().data('wallpaper-banner') != null) {
        $('body').removeAttr('style');
      }
      if (code) {
        EAS_load_fif(id, "/emediate/EAS_fif.html", "http://eas4.emediate.eu/eas?cu=" + code + "&" + (this.generateParameters()), 0, 0);
      } else {
        $target.hide();
      }
      return this.checkIframeStatus($target, code);
    };

    Banners.prototype.checkIframeStatus = function($target, code) {
      var $iframe;
      $iframe = $target.find('iframe').eq(0);
      return $iframe.load((function(_this) {
        return function() {
          var $content;
          $content = $iframe.contents();
          if ($content.find('img, a, div, canvas, object, iframe, embed')[0] || $target.children().length > 1) {
            $target.parent().siblings('[data-continue-reading]').show();
          } else {
            $target.hide();
          }
          if (!_this.adBlockIsChecked) {
            _this.adBlockIsChecked = true;
            if ($content.find("body").html().length) {
              return _this.adBlockDetection(true);
            } else {
              return _this.adBlockDetection(false);
            }
          }
        };
      })(this));
    };

    Banners.prototype.shiftCodeArray = function(codeArray) {
      var $target;
      $target = $("[data-banner-code='" + codeArray + "']");
      codeArray.shift();
      return $target.attr('data-banner-code', codeArray.join(","));
    };

    Banners.prototype.lazyLoadGallery = function() {
      this.uuid = EAS_uuid();
      this.$gallery.find('[data-active-slide=true] [data-banner-target]').attr('data-banner-target', true);
      this.insertInView();
      return this.updateGalleryHorseshoe();
    };

    Banners.prototype.updateGalleryHorseshoe = function() {
      if (this.bannerReloadFrequency) {
        this.countSlideChange++;
        if (this.countSlideChange % this.bannerReloadFrequency === 0 && this.coolDown() === true && ($.breakpoints() === 'md' || $.breakpoints() === 'lg')) {
          this.uuid = EAS_uuid();
          $('[data-banner-md-lg] [data-banner-target]').attr('data-banner-target', true);
          $('[data-top-banner] [data-banner-target]').attr('data-banner-target', true);
          $('[data-active-slide] [data-banner-target]').attr('data-banner-target', false);
          this.countSlideChange = 0;
          return $.delay(0, (function(_this) {
            return function() {
              return _this.insertInView();
            };
          })(this));
        }
      }
    };

    Banners.prototype.coolDown = function() {
      if (Date.now() - 5000 > this.savedTime) {
        this.savedTime = Date.now();
        return true;
      }
    };

    Banners.prototype.adBlockDetection = function(adsAreLoaded) {
      if (adsAreLoaded) {
        dataLayer.push({
          'event': 'ads-are-loaded',
          'top-banner-load-time': Date.now() - this.startTime
        });
        return console.info("Ads are loaded", Date.now() - this.startTime);
      } else {
        dataLayer.push({
          'event': 'ads-are-blocked'
        });
        return console.error("Ads are blocked");
      }
    };

    return Banners;

  })();

  window.Banners = new Banners();

}).call(this);

(function() {
  (function($) {
    var Breakpoint;
    Breakpoint = function(element, options) {
      this.options = $.extend({}, Breakpoint.DEFAULTS, options);
      this.bindEvent();
    };
    Breakpoint.DEFAULTS = {
      xs: 480,
      sm: 768,
      md: 1025,
      lg: 1200
    };
    Breakpoint.prototype.bindEvent = function() {
      var breakpoint, self;
      self = this;
      breakpoint = 'xs';
      breakpoint = self.detect($(window).width());
      return breakpoint;
    };
    Breakpoint.prototype.detect = function(width) {
      var o;
      o = this.options;
      if (o.lg <= width) {
        return 'lg';
      }
      if (o.md <= width && o.lg >= width) {
        return 'md';
      }
      if (o.sm <= width && o.md > width) {
        return 'sm';
      }
      if (o.sm > width) {
        return 'xs';
      }
    };
    $.breakpoints = function(data) {
      var $object;
      $object = new Breakpoint(this);
      return $object.bindEvent(data);
    };
  })(jQuery);

}).call(this);

//# sourceMappingURL=banners.js.map
