/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.$window = exports.$doc = exports.$body = exports.$ = void 0;
exports.csGetCookie = csGetCookie;
exports.csSetCookie = csSetCookie;
exports.csThrottleScroll = csThrottleScroll;
exports.wndW = exports.wndH = exports.docH = exports.csco = void 0;
// Create csco object.
var csco = {
  addAction: function addAction(x, y, z) {
    return;
  }
};
exports.csco = csco;

if ('undefined' !== typeof wp && 'undefined' !== typeof wp.hooks) {
  csco.addAction = wp.hooks.addAction;
}
/**
 * Window size
 */


var $ = jQuery;
exports.$ = $;
var $window = $(window);
exports.$window = $window;
var $doc = $(document);
exports.$doc = $doc;
var $body = $('body');
exports.$body = $body;
var wndW = 0;
exports.wndW = wndW;
var wndH = 0;
exports.wndH = wndH;
var docH = 0;
exports.docH = docH;

function csGetWndSize() {
  exports.wndW = wndW = $window.width();
  exports.wndH = wndH = $window.height();
  exports.docH = docH = $doc.height();
}

$window.on('resize load orientationchange', csGetWndSize);
csGetWndSize();
/**
 * Throttle scroll
 * thanks: https://jsfiddle.net/mariusc23/s6mLJ/31/
 */

var csHideOnScrollList = [];
var csDidScroll;
var csLastST = 0;
$window.on('scroll load resize orientationchange', function () {
  if (csHideOnScrollList.length) {
    csDidScroll = true;
  }
});

function csHasScrolled() {
  var ST = $window.scrollTop();
  var type = null;

  if (ST > csLastST) {
    type = 'down';
  } else if (ST < csLastST) {
    type = 'up';
  } else {
    type = 'none';
  }

  if (ST === 0) {
    type = 'start';
  } else if (ST >= docH - wndH) {
    type = 'end';
  }

  csHideOnScrollList.forEach(function (item) {
    if (typeof item === 'function') {
      item(type, ST, csLastST, $window);
    }
  });
  csLastST = ST;
}

setInterval(function () {
  if (csDidScroll) {
    csDidScroll = false;
    window.requestAnimationFrame(csHasScrolled);
  }
}, 250);

function csThrottleScroll(callback) {
  csHideOnScrollList.push(callback);
}
/**
 * In Viewport checker
 */


$.fn.isInViewport = function () {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop + $(this).outerHeight();
  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};
/**
 * Cookies
 */


function csGetCookie(name) {
  var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function csSetCookie(name, value) {
  var props = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  props = {
    path: '/'
  };

  if (props.expires instanceof Date) {
    props.expires = props.expires.toUTCString();
  }

  var updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (var optionKey in props) {
    updatedCookie += "; " + optionKey;
    var optionValue = props[optionKey];

    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

/* Vaarta native carousel owns legacy Webpack module 2. */
__webpack_require__(3);
__webpack_require__(4);
__webpack_require__(5);
__webpack_require__(6);
__webpack_require__(7);
__webpack_require__(8);
/* Vaarta native load-more owns legacy Webpack module 9. */
__webpack_require__(10);
/* Vaarta native masonry owns legacy Webpack module 11. */
__webpack_require__(12);
/* Vaarta native navigation owns legacy Webpack module 13. */
__webpack_require__(14);
__webpack_require__(15);
__webpack_require__(16);
__webpack_require__(17);
__webpack_require__(18);
__webpack_require__(19);
module.exports = __webpack_require__(20);


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

(function () {
  function initCarousel() {
    /**
     * Wide Carousel Type 1
     */
    (0, _utility.$)('.cnvs-block-posts-layout-wide-type-1 ').each(function (indexBlock, objectBlock) {
      (0, _utility.$)(objectBlock).imagesLoaded(function (instance) {
        var rtl = _utility.$body.hasClass('rtl') ? true : false; // Loop.

        (0, _utility.$)(instance.elements).each(function (index, el) {
          var objectSlider = (0, _utility.$)(el).find('.cs-carousel__items');
          var $current; // Point.

          var point = function point() {
            var points = [340, 370, 480, 576, 640, 768, 1020, 1200, 1280, 1434, 1584, 1780, 1920];
            var current = 0;

            for (var i in points) {
              if (window.innerWidth >= points[i]) {
                current = points[i];
              }
            }

            return current;
          }; // Get columns.


          var carouselColumns = parseInt(window.getComputedStyle((0, _utility.$)(objectBlock)[0]).getPropertyValue('--cs-carousel-columns')); // Get data.

          var autoPlay = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('autoplay'),
              pageDots = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('pagedots'),
              wrapAround = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('wraparound');
          var settings = {
            cellAlign: rtl ? 'right' : 'left',
            autoPlay: autoPlay ? 5000 : false,
            prevNextButtons: false,
            rightToLeft: rtl,
            wrapAround: wrapAround ? true : false,
            pageDots: pageDots ? true : false,
            resize: true
          };
          (0, _utility.$)(objectSlider).flickity(settings);
          var flkty = (0, _utility.$)(objectSlider).data('flickity');
          var $prev = (0, _utility.$)(objectBlock).find('.cs-carousel__arrow-previous');
          var $next = (0, _utility.$)(objectBlock).find('.cs-carousel__arrow-next');
          var elCount = (0, _utility.$)(objectSlider).find('.cs-carousel__cell').length;

          if (elCount >= carouselColumns + 1) {
            (0, _utility.$)(objectSlider).flickity(settings);
          } else {
            (0, _utility.$)(objectSlider).flickity('destroy');
          } // Set current point();


          $current = point();

          function updateCounter() {
            var carouselCurrentWrapper = (0, _utility.$)(objectBlock).find('.cs-carousel__counters'),
                carouselCurrentCounter = (0, _utility.$)(objectBlock).find('.cs-carousel__counters-current'),
                carouselTotalCounter = (0, _utility.$)(objectBlock).find('.cs-carousel__counters-total');
            var slideNumber = flkty.selectedIndex + 1,
                totalNumber = flkty.slides.length;
            carouselCurrentCounter.text(slideNumber);
            carouselTotalCounter.text(totalNumber);
            carouselCurrentWrapper.addClass('cs-carousel__counters-visible');
          }

          updateCounter();
          (0, _utility.$)(objectSlider).on('change.flickity', updateCounter); // Resize.

          (0, _utility.$)(window).resize(function () {
            var carouselColumnsResize = parseInt(window.getComputedStyle((0, _utility.$)(objectBlock)[0]).getPropertyValue('--cs-carousel-columns'));

            if ($current !== point() && elCount >= carouselColumnsResize + 1) {
              (0, _utility.$)(objectSlider).flickity(settings);
              $current = point();

              if ((0, _utility.$)(objectSlider).flickity(settings)) {
                (0, _utility.$)(objectSlider).flickity('destroy');
                (0, _utility.$)(objectSlider).flickity(settings);
              }
            } else if ($current !== point() && elCount <= carouselColumnsResize && (0, _utility.$)(objectSlider).flickity(settings)) {
              (0, _utility.$)(objectSlider).flickity('destroy');
              $current = point();
            }
          }); // Select the previous slide.

          $prev.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'next' : 'previous';
            (0, _utility.$)(objectSlider).flickity(type);
          }); // Select the next slide.

          $next.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'previous' : 'next';
            (0, _utility.$)(objectSlider).flickity(type);
          });

          if (!settings.wrapAround) {
            (0, _utility.$)(objectSlider).on('select.flickity', function () {
              // enable/disable previous/next buttons
              if (!flkty.slides[flkty.selectedIndex - 1]) {
                $prev.addClass('disabled');
                $next.removeClass('disabled'); // <-- remove disabled from the next
              } else if (!flkty.slides[flkty.selectedIndex + 1]) {
                $next.addClass('disabled');
                $prev.removeClass('disabled'); //<-- remove disabled from the prev
              } else {
                $prev.removeClass('disabled');
                $next.removeClass('disabled');
              }
            });
          }
        });
      });
    });
    /**
     * Large Carousel Type 1
     */

    (0, _utility.$)('.cnvs-block-posts-layout-large-type-1').each(function (indexBlock, objectBlock) {
      (0, _utility.$)(objectBlock).imagesLoaded(function (instance) {
        var rtl = _utility.$body.hasClass('rtl') ? true : false; // Loop.

        (0, _utility.$)(instance.elements).each(function (index, el) {
          var objectSlider = (0, _utility.$)(el).find('.cs-carousel__items');
          var $current; // Point.

          var point = function point() {
            var points = [340, 370, 480, 576, 640, 768, 1020, 1200, 1280, 1434, 1584, 1780, 1920];
            var current = 0;

            for (var i in points) {
              if (window.innerWidth >= points[i]) {
                current = points[i];
              }
            }

            return current;
          }; // Get columns.


          var carouselColumns = parseInt(window.getComputedStyle((0, _utility.$)(objectBlock)[0]).getPropertyValue('--cs-carousel-columns')); // Get data.

          var autoPlay = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('autoplay'),
              pageDots = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('pagedots'),
              wrapAround = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('wraparound'),
              groupCells = (0, _utility.$)(objectBlock).find('.cs-flickity-init').data('groupcells');
          var settings = {
            wrapAround: wrapAround ? true : false,
            groupCells: groupCells ? true : false,
            autoPlay: autoPlay ? 5000 : false,
            prevNextButtons: false,
            pageDots: pageDots ? true : false,
            rightToLeft: rtl,
            resize: true,
            selectedAttraction: 0.006,
            friction: 0.14
          };

          if (settings.groupCells) {
            settings.groupCells = carouselColumns;
            (0, _utility.$)(objectSlider).addClass('cs-groupcells-active');
          }

          (0, _utility.$)(objectSlider).flickity(settings);
          var flkty = (0, _utility.$)(objectSlider).data('flickity');
          var $prev = (0, _utility.$)(objectBlock).find('.cs-carousel__arrow-previous');
          var $next = (0, _utility.$)(objectBlock).find('.cs-carousel__arrow-next');
          var elCount = (0, _utility.$)(objectSlider).find('.cs-carousel__cell').length;

          if (elCount >= carouselColumns + 1) {
            (0, _utility.$)(objectSlider).flickity(settings);
          } else {
            (0, _utility.$)(objectSlider).flickity('destroy');
          } // Set current point();


          $current = point();
          var carouselCurrentWrapper = (0, _utility.$)('.cs-carousel__counters'),
              carouselCurrentCounter = document.querySelector('.cs-carousel__counters-current'),
              carouselTotalCounter = document.querySelector('.cs-carousel__counters-total');

          function updateCounter() {
            var slideNumber = flkty.selectedIndex + 1,
                totalNumber = flkty.slides.length;
            carouselCurrentCounter.textContent = slideNumber;
            carouselTotalCounter.textContent = totalNumber;
            carouselCurrentWrapper.addClass('cs-carousel__counters-visible');
          }

          updateCounter();
          flkty.on('select', updateCounter); // Resize.

          (0, _utility.$)(window).resize(function () {
            var carouselColumnsResize = parseInt(window.getComputedStyle((0, _utility.$)(objectBlock)[0]).getPropertyValue('--cs-carousel-columns'));

            if ($current !== point() && elCount >= carouselColumnsResize + 1) {
              if (settings.groupCells) {
                settings.groupCells = carouselColumnsResize;
              }

              (0, _utility.$)(objectSlider).flickity(settings);
              $current = point();

              if ((0, _utility.$)(objectSlider).flickity(settings)) {
                (0, _utility.$)(objectSlider).flickity('destroy');

                if (settings.groupCells) {
                  settings.groupCells = carouselColumnsResize;
                }

                (0, _utility.$)(objectSlider).flickity(settings);
              }
            } else if ($current !== point() && elCount <= carouselColumnsResize && (0, _utility.$)(objectSlider).flickity(settings)) {
              (0, _utility.$)(objectSlider).flickity('destroy');
              $current = point();
            }
          }); // Select the previous slide.

          $prev.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'next' : 'previous';
            (0, _utility.$)(objectSlider).flickity(type);
          }); // Select the next slide.

          $next.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'previous' : 'next';
            (0, _utility.$)(objectSlider).flickity(type);
          });

          if (!settings.wrapAround) {
            (0, _utility.$)(objectSlider).on('select.flickity', function () {
              // enable/disable previous/next buttons
              if (!flkty.slides[flkty.selectedIndex - 1]) {
                $prev.addClass('disabled');
                $next.removeClass('disabled'); // <-- remove disabled from the next
              } else if (!flkty.slides[flkty.selectedIndex + 1]) {
                $next.addClass('disabled');
                $prev.removeClass('disabled'); //<-- remove disabled from the prev
              } else {
                $prev.removeClass('disabled');
                $next.removeClass('disabled');
              }
            });
          }
        });
      });
    });
  }

  function initTwitterWidgetCarousel() {
    /*Twitter Carousel*/
    (0, _utility.$)('.cs-twitter-carousel').each(function (indexBlock, objectBlock) {
      (0, _utility.$)(objectBlock).imagesLoaded(function (instance) {
        var rtl = _utility.$body.hasClass('rtl') ? true : false; // Loop.

        (0, _utility.$)(instance.elements).each(function (index, el) {
          var objectSlider = (0, _utility.$)(el).find('.cs-twitter-carousel__items'); // Get data.

          var autoPlay = (0, _utility.$)(objectBlock).data('autoplay'),
              wrapAround = (0, _utility.$)(objectBlock).data('wraparound');
          var settings = {
            cellAlign: rtl ? 'right' : 'left',
            wrapAround: wrapAround ? true : false,
            autoPlay: autoPlay ? 5000 : false,
            prevNextButtons: false,
            pageDots: true,
            rightToLeft: rtl,
            resize: true
          };
          (0, _utility.$)(objectSlider).flickity(settings);
          var flkty = (0, _utility.$)(objectSlider).data('flickity');
          var $prev = (0, _utility.$)(objectBlock).find('.carousel-previous');
          var $next = (0, _utility.$)(objectBlock).find('.carousel-next');
          var elCount = (0, _utility.$)(objectSlider).find('.cs-twitter-carousel__cell').length;

          if (elCount >= 2) {
            (0, _utility.$)(objectSlider).flickity(settings);
          } else {
            (0, _utility.$)(objectSlider).flickity('destroy');
          } // Select the previous slide.


          $prev.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'next' : 'previous';
            (0, _utility.$)(objectSlider).flickity(type);
          }); // Select the next slide.

          $next.on('click', function (event) {
            event.preventDefault();
            var type = rtl ? 'previous' : 'next';
            (0, _utility.$)(objectSlider).flickity(type);
          });

          if (!settings.wrapAround) {
            (0, _utility.$)(objectSlider).on('select.flickity', function () {
              // enable/disable previous/next buttons
              if (!flkty.slides[flkty.selectedIndex - 1]) {
                $prev.addClass('disabled');
                $next.removeClass('disabled'); // <-- remove disabled from the next
              } else if (!flkty.slides[flkty.selectedIndex + 1]) {
                $next.addClass('disabled');
                $prev.removeClass('disabled'); //<-- remove disabled from the prev
              } else {
                $prev.removeClass('disabled');
                $next.removeClass('disabled');
              }
            });
          }
        });
      });
    });
  }

  function initInstagramWidgetCarousel() {
    /**
     * Instagram Widget Slider
     */
    (0, _utility.$)('.pk-instagram-template-carousel .pk-instagram-items-carousel').imagesLoaded(function (instance) {
      // Set unique id.
      var requestId; // Set rtl status.

      var rtl = (0, _utility.$)('body').hasClass('rtl') ? true : false;
      (0, _utility.$)(instance.elements).each(function (index, el) {
        var mainTicker = new Flickity(el, {
          freeScroll: true,
          accessibility: true,
          resize: true,
          wrapAround: true,
          prevNextButtons: false,
          pageDots: false,
          percentPosition: true,
          setGallerySize: true,
          adaptiveHeight: true,
          rightToLeft: rtl,
          on: {
            ready: function ready() {
              (0, _utility.$)(el).addClass('is-animate');
            }
          }
        });
        mainTicker.initAnimation = false; // Set initial position to be 0

        mainTicker.x = 0; // Main function that 'plays' the marquee.

        function flickity_play() {
          // Set the decrement of position x
          mainTicker.x = mainTicker.x - 0.25; // Settle position into the slider

          mainTicker.settle(mainTicker.x); // Set the requestId to the local letiable

          requestId = window.requestAnimationFrame(flickity_play);
        } // Main function to cancel the animation.


        function flickity_pause() {
          if (requestId) {
            // Cancel the animation.
            window.cancelAnimationFrame(requestId);
            requestId = undefined;
          }
        } // Main function init


        function flickity_init() {
          // The monitor.
          var isInView = (0, _utility.$)(el).isInViewport();

          if (isInView) {
            if (!mainTicker.initAnimation) {
              flickity_play();
              mainTicker.initAnimation = true;
            }
          } else {
            flickity_pause();
            mainTicker.initAnimation = false;
          }
        } // Document scroll.


        (0, _utility.$)(window).on('load resize scroll', function () {
          flickity_init();
        }); // Document ready.

        (0, _utility.$)(document).ready(function () {
          flickity_init();
        });
      });
    });
  }

  function initInstagramWidgetCarouselFull() {
    /**
     * Instagram Widget Slider
     */
    (0, _utility.$)('.pk-instagram-template-carousel-full .pk-instagram-items-carousel-full').imagesLoaded(function (instance) {
      // Set unique id.
      var requestId; // Set rtl status.

      var rtl = (0, _utility.$)('body').hasClass('rtl') ? true : false;
      (0, _utility.$)(instance.elements).each(function (index, el) {
        var mainTicker = new Flickity(el, {
          freeScroll: true,
          accessibility: true,
          resize: true,
          wrapAround: true,
          prevNextButtons: false,
          pageDots: false,
          percentPosition: true,
          setGallerySize: true,
          adaptiveHeight: true,
          rightToLeft: rtl,
          on: {
            ready: function ready() {
              (0, _utility.$)(el).addClass('is-animate');
            }
          }
        });
        mainTicker.initAnimation = false; // Set initial position to be 0

        mainTicker.x = 0; // Main function that 'plays' the marquee.

        function flickity_play() {
          // Set the decrement of position x
          mainTicker.x = mainTicker.x - 0.25; // Settle position into the slider

          mainTicker.settle(mainTicker.x); // Set the requestId to the local letiable

          requestId = window.requestAnimationFrame(flickity_play);
        } // Main function to cancel the animation.


        function flickity_pause() {
          if (requestId) {
            // Cancel the animation.
            window.cancelAnimationFrame(requestId);
            requestId = undefined;
          }
        } // Main function init


        function flickity_init() {
          // The monitor.
          var isInView = (0, _utility.$)(el).isInViewport();

          if (isInView) {
            if (!mainTicker.initAnimation) {
              flickity_play();
              mainTicker.initAnimation = true;
            }
          } else {
            flickity_pause();
            mainTicker.initAnimation = false;
          }
        } // Document scroll.


        (0, _utility.$)(window).on('load resize scroll', function () {
          flickity_init();
        }); // Document ready.

        (0, _utility.$)(document).ready(function () {
          flickity_init();
        });
      });
    });
  }

  initCarousel();
  initTwitterWidgetCarousel();
  initInstagramWidgetCarousel();
  initInstagramWidgetCarouselFull();
  (0, _utility.$)(document).ready(function () {
    (0, _utility.$)(document.body).on('post-load', function () {
      initCarousel();
      initTwitterWidgetCarousel();
      initInstagramWidgetCarousel();
      initInstagramWidgetCarouselFull();
    });

    _utility.csco.addAction('canvas.components.serverSideRender.onChange', 'init-carousel', function (props) {
      if ('canvas/posts' === props.block) {
        initCarousel();
        initTwitterWidgetCarousel();
        initInstagramWidgetCarousel();
        initInstagramWidgetCarouselFull();
      }
    });
  });
})();

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Comments Dropdown */
(function () {
  (0, _utility.$)(document).on('click', '.cs-entry__comments-show button', function (e) {
    (0, _utility.$)('.cs-entry__comments-collapse').show();
    (0, _utility.$)('.cs-entry__comments-show').remove();
  });
})();

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Hover entry */
(function () {
  var buttonCopy = (0, _utility.$)('.cs-entry__after-share-buttons-copy');
  var buttonCopyIcon = (0, _utility.$)('.cs-entry__after-share-buttons-copy .cs-icon');

  function copyToClipboard() {
    var inputCopy = (0, _utility.$)('.cs-entry__after-share-buttons-text');
    inputCopy.select();
    document.execCommand("copy");
    buttonCopyIcon.removeClass('cs-icon-copy').addClass('cs-icon-check');
    setTimeout(function () {
      buttonCopyIcon.removeClass('cs-icon-check').addClass('cs-icon-copy');
      inputCopy.blur();
    }, 2000);
  }

  buttonCopy.on('click', function () {
    copyToClipboard();
  });
})();

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Detect Aligment */
(function () {
  var ticking = false;

  var update = function update() {
    // Sidebar.
    // -----------------------------------.
    (0, _utility.$)('.cs-site-primary').each(function () {
      var content = (0, _utility.$)(this).find('.entry-content');
      var sidebar = (0, _utility.$)(this).find('.cs-entry__metabar-inner'); // Vars offset.

      var offsetTop = 20;
      var offsetBottom = -20; // Search elements.

      var elements = [];
      elements.push('> .alignfull');
      elements.push('> .alignwide');
      var layouts = (0, _utility.$)(content).find(elements.join(','));

      if (0 === sidebar.length) {
        return;
      }

      if (0 === layouts.length) {
        return;
      }

      var disabled = false; // Get sidebar values.

      var sidebarTop = (0, _utility.$)(sidebar).offset().top;
      var sidebarHeight = (0, _utility.$)(sidebar).outerHeight(true);

      for (var i = 0; i < (0, _utility.$)(layouts).length; ++i) {
        if ('none' === (0, _utility.$)(layouts[i]).css('transform')) {
          continue;
        } // Get layout values.


        var layoutTop = (0, _utility.$)(layouts[i]).offset().top;
        var layoutHeight = (0, _utility.$)(layouts[i]).outerHeight(true); // Calc points.

        var pointTop = layoutTop - offsetTop;
        var pointBottom = layoutTop + layoutHeight + offsetBottom; // Detect sidebar location.

        if (sidebarTop + sidebarHeight >= pointTop && sidebarTop <= pointBottom) {
          disabled = true;
        }
      }

      if (disabled) {
        (0, _utility.$)(sidebar).css('opacity', '0');
      } else {
        (0, _utility.$)(sidebar).css('opacity', '1');
      }
    }); // Ticking.

    ticking = false;
  };

  var requestTick = function requestTick() {
    if (!ticking) {
      window.requestAnimationFrame(update);
      ticking = true;
    }
  };

  var onProcess = function onProcess() {
    requestTick();
  };

  (0, _utility.$)(window).on('scroll', onProcess);
  (0, _utility.$)(window).on('resize', onProcess);
  (0, _utility.$)(window).on('image-load', onProcess);
  (0, _utility.$)(window).on('post-load', onProcess);
})();

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Full Screen Menu */
(function () {
  var columns = (0, _utility.$)(".cs-fullscreen-menu__nav-col");
  var menuLevel = 0;
  var timeout = [];

  _utility.$.fn.responsiveNav = function () {
    this.removeClass('menu-item-expanded');

    if (this.prev().hasClass('submenu-visible')) {
      this.prev().removeClass('submenu-visible').slideUp(350);
      this.parent().removeClass('menu-item-expanded');
    } else {
      this.parent().parent().find('.menu-item .sub-menu').removeClass('submenu-visible').slideUp(350);
      this.parent().parent().find('.menu-item-expanded').removeClass('menu-item-expanded');
      this.prev().toggleClass('submenu-visible').hide().slideToggle(350);
      this.parent().toggleClass('menu-item-expanded');
    }
  };

  (0, _utility.$)(document).ready(function (e) {
    (0, _utility.$)('.cs-fullscreen-menu__nav-inner > .menu-item-has-children > .sub-menu > .menu-item-has-children > .sub-menu .menu-item-has-children').each(function (e) {
      (0, _utility.$)(this).append('<span></span>');
    });
  });
  (0, _utility.$)(document).on('click', '.cs-fullscreen-menu__nav-col-last > .sub-menu > .menu-item-has-children > span', function (e) {
    e.preventDefault();
    (0, _utility.$)(this).responsiveNav();
  });
  (0, _utility.$)(document).on('click', '.cs-fullscreen-menu__nav-col-last > .sub-menu > .menu-item-has-children > a', function (e) {
    if ('#' === (0, _utility.$)(this).attr('href')) {
      e.preventDefault();
      (0, _utility.$)(this).next().next().responsiveNav();
    }
  });
  (0, _utility.$)(document).on('mouseenter', '.cs-fullscreen-menu .menu-item', function (e) {
    var submenu = (0, _utility.$)(this).children('.sub-menu').clone();

    if ((0, _utility.$)(this).parents(".cs-fullscreen-menu__nav-inner").length > 0) {
      menuLevel = 1;
    } else if ((0, _utility.$)(this).parents(".cs-fullscreen-menu__nav-col-first").length > 0) {
      menuLevel = 2;
    } else if ((0, _utility.$)(this).parents(".cs-fullscreen-menu__nav-col-last").length > 0) {
      menuLevel = 3;
    }

    if (submenu.length > 0) {
      for (var i = 0; i < menuLevel; i++) {
        clearTimeout(timeout[i]);
      }
    }

    (0, _utility.$)(columns[menuLevel - 1]).html(submenu).addClass("visible");
  });
  (0, _utility.$)(document).on('mouseenter', '.cs-fullscreen-menu__nav-col, .cs-fullscreen-menu__nav-inner', function (e) {
    if ((0, _utility.$)(this).hasClass("cs-fullscreen-menu__nav-inner")) {
      menuLevel = 1;
    } else if ((0, _utility.$)(this).hasClass("cs-fullscreen-menu__nav-col-first")) {
      menuLevel = 2;
    } else if ((0, _utility.$)(this).hasClass("cs-fullscreen-menu__nav-col-last")) {
      menuLevel = 3;
    }

    for (var i = 0; i < menuLevel; i++) {
      clearTimeout(timeout[i]);
    }
  });
  (0, _utility.$)(document).on('mouseleave', '.cs-fullscreen-menu__nav-col, .cs-fullscreen-menu__nav-inner', function (e) {
    timeout[0] = setTimeout(function () {
      (0, _utility.$)(columns[0]).removeClass('visible');
    }, 200);
    timeout[1] = setTimeout(function () {
      (0, _utility.$)(columns[1]).removeClass('visible');
    }, 200);
  });
})();

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Fullscreen */
(function () {
  (0, _utility.$)('.cs-header__fullscreen-menu-toggle').on('click', function (e) {
    e.preventDefault();
    (0, _utility.$)(this).toggleClass('active');

    _utility.$body.toggleClass('cs-fullscreen-menu-active');

    if ((0, _utility.$)('.cs-search').is(":visible")) {
      (0, _utility.$)('.cs-search').slideUp();
    }
  });
  (0, _utility.$)('.cs-fullscreen-menu__header-toggle').on('click', function (e) {
    e.preventDefault();
    (0, _utility.$)('.cs-header__fullscreen-menu-toggle').removeClass('active');

    _utility.$body.toggleClass('cs-fullscreen-menu-active');
  });
})();

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Hover entry */
(function () {
  var $entryType = (0, _utility.$)('.cs-block-posts-layout-tile-hover .cs-entry__outer'),
      isHovered = false;

  function process(el) {
    var currentWidth = window.innerWidth,
        maxWidth = 1020,
        $el = null;

    if (el) {
      $el = (0, _utility.$)(el);
    } else {
      $el = $entryType;
    }

    if (currentWidth < maxWidth) {
      $entryType.attr('data-scheme', 'inverse');
    } else {
      $entryType.removeAttr('data-scheme');

      if (isHovered) {
        $el.attr('data-scheme', 'inverse');
      } else {
        $entryType.removeAttr('data-scheme');
      }
    }
  }

  $entryType.hover(function () {
    isHovered = true;
    process(this);
  }, function () {
    isHovered = false;
    process(this);
  });

  _utility.$window.resize(function () {
    process();
  });

  process();
})();

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

if ('undefined' === typeof window.load_more_query) {
  window.load_more_query = [];
}
/**
 * Get next posts
 */


function csco_ajax_get_posts(object) {
  var container = (0, _utility.$)(object).closest('.cs-posts-area');
  var settings = (0, _utility.$)(object).data('settings');
  var page = (0, _utility.$)(object).data('page');
  (0, _utility.$)(object).data('loading', true); // Set button text to Load More.

  (0, _utility.$)(object).addClass('loading');
  var data = {
    action: 'csco_ajax_load_more',
    page: page,
    posts_per_page: settings.posts_per_page,
    query_data: settings.query_data,
    attributes: settings.attributes,
    options: settings.options,
    _ajax_nonce: settings.nonce
  }; // Request Url.

  var csco_pagination_url;

  if ('ajax_restapi' === settings.type) {
    csco_pagination_url = settings.rest_url;
  } else {
    csco_pagination_url = settings.url;
  } // Send Request.


  _utility.$.post(csco_pagination_url, data, function (res) {
    if (res.success) {
      // Get the posts.
      var data = (0, _utility.$)(res.data.content); // Check if there're any posts.

      if (data.length) {
        data.imagesLoaded(function () {
          // Append new posts to full, list, grid and masonry archives.
          if ((0, _utility.$)(container).find('.cs-posts-area__masonry').length > 0) {
            (0, _utility.$)(container).find('.cs-posts-area__masonry').colcade('append', data);
          } else if ((0, _utility.$)(container).find('.cs-block-posts-layout-masonry-type-1').length > 0) {
            (0, _utility.$)(container).find('.cs-block-posts-layout-masonry-type-1').colcade('append', data);
          } else {
            (0, _utility.$)(container).find('.cs-posts-area__main').append(data);
          } // WP Post Load trigger.


          (0, _utility.$)(document.body).trigger('post-load'); // Reinit Facebook widgets.

          if ((0, _utility.$)('#fb-root').length && 'object' === (typeof FB === "undefined" ? "undefined" : _typeof(FB))) {
            FB.XFBML.parse();
          } // Set button text to Load More.


          (0, _utility.$)(object).removeClass('loading'); // Increment a page.

          page = page + 1;
          (0, _utility.$)(object).data('page', page); // Set the loading state.

          (0, _utility.$)(object).data('loading', false);
        });
      } // Remove Button on Posts End.


      if (res.data.posts_end || !data.length) {
        // Remove Load More button.
        (0, _utility.$)(object).remove();
      }
    } else {// console.log(res);
    }
  }).fail(function (xhr, textStatus, e) {// console.log(xhr.responseText);
  });
}
/**
 * Initialization Load More
 */


function csco_load_more_init(infinite) {
  (0, _utility.$)('.cs-posts-area').each(function () {
    if ((0, _utility.$)(this).data('init')) {
      return;
    }

    var csco_ajax_settings;

    if ((0, _utility.$)(this).hasClass('cs-posts-area-posts') && typeof csco_ajax_pagination !== 'undefined') {
      csco_ajax_settings = csco_ajax_pagination;
    }

    var archive_data = (0, _utility.$)(this).data('posts-area');

    if (archive_data) {
      csco_ajax_settings = JSON.parse(window.atob(archive_data));
    }

    if (csco_ajax_settings) {
      if (!infinite && csco_ajax_settings.infinite_load) {
        return;
      } // Add load more button.


      (0, _utility.$)(this).append('<div class="cs-posts-area__pagination"><button class="cs-load-more"><span class="cs-button-label">' + csco_ajax_settings.translation.load_more + '</span><span class="cs-button-arrow"><span class="cs-loader-button"></span></button></div>'); // Set load more settings.

      (0, _utility.$)(this).find('.cs-load-more').data('settings', csco_ajax_settings);
      (0, _utility.$)(this).find('.cs-load-more').data('page', 2);
      (0, _utility.$)(this).find('.cs-load-more').data('loading', false);
      (0, _utility.$)(this).find('.cs-load-more').data('scrollHandling', {
        allow: _utility.$.parseJSON(csco_ajax_settings.infinite_load),
        delay: 400
      });
    }

    (0, _utility.$)(this).data('init', true);
  });
}

csco_load_more_init(true);

_utility.csco.addAction('canvas.components.serverSideRender.onChange', 'posts-init-loadmore', function (props) {
  if ('canvas/posts' === props.block) {
    csco_load_more_init(false);
  }
}); // On Scroll Event.


(0, _utility.$)(window).scroll(function () {
  (0, _utility.$)('.cs-posts-area .cs-load-more').each(function () {
    var loading = (0, _utility.$)(this).data('loading');
    var scrollHandling = (0, _utility.$)(this).data('scrollHandling');

    if ('undefined' === typeof scrollHandling) {
      return;
    }

    if ((0, _utility.$)(this).length && !loading && scrollHandling.allow) {
      scrollHandling.allow = false;
      (0, _utility.$)(this).data('scrollHandling', scrollHandling);
      var object = this;
      setTimeout(function () {
        var scrollHandling = (0, _utility.$)(object).data('scrollHandling');

        if ('undefined' === typeof scrollHandling) {
          return;
        }

        scrollHandling.allow = true;
        (0, _utility.$)(object).data('scrollHandling', scrollHandling);
      }, scrollHandling.delay);
      var offset = (0, _utility.$)(this).offset().top - (0, _utility.$)(window).scrollTop();

      if (4000 > offset) {
        csco_ajax_get_posts(this);
      }
    }
  });
}); // On Click Event.

(0, _utility.$)('body').on('click', '.cs-load-more', function () {
  var loading = (0, _utility.$)(this).data('loading');

  if (!loading) {
    csco_ajax_get_posts(this);
  }
});

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

/**
 * Check if Load Nextpost is defined by the wp_localize_script
 */
if (typeof csco_ajax_nextpost !== 'undefined') {
  var objNextparent = (0, _utility.$)('.cs-site-primary > .cs-site-content'),
      objNextsect = '.cs-nextpost-section',
      objNextpost = null,
      currentNTitle = document.title,
      currentNLink = window.location.href,
      loadingNextpost = false,
      scrollNextpost = {
    allow: true,
    reallow: function reallow() {
      scrollNextpost.allow = true;
    },
    delay: 400 //(milliseconds) adjust to the highest acceptable value

  }; // Init.

  if (csco_ajax_nextpost.next_post) {
    (0, _utility.$)(objNextparent).after('<div class="cs-nextpost-inner"></div>');
    objNextpost = (0, _utility.$)('.cs-nextpost-inner');
  }
}
/**
 * Get next post
 */


function csco_ajax_get_nextpost() {
  loadingNextpost = true; // Set class loading.

  var data = {
    action: 'csco_ajax_load_nextpost',
    not_in: csco_ajax_nextpost.not_in,
    current_user: csco_ajax_nextpost.current_user,
    nonce: csco_ajax_nextpost.nonce,
    next_post: csco_ajax_nextpost.next_post
  }; // Request Url.

  var csco_ajax_nextpost_url;

  if ('ajax_restapi' === csco_ajax_nextpost.type) {
    csco_ajax_nextpost_url = csco_ajax_nextpost.rest_url;
  } else {
    csco_ajax_nextpost_url = csco_ajax_nextpost.url;
  } // Send Request.


  _utility.$.post(csco_ajax_nextpost_url, data, function (res) {
    csco_ajax_nextpost.next_post = false;

    if (res.success) {
      // Get the posts.
      var data = (0, _utility.$)(res.data.content); // Check if there're any posts.

      if (data.length) {
        // Set the loading state.
        loadingNextpost = false; // Set not_in.

        csco_ajax_nextpost.not_in = res.data.not_in; // Set next data.

        csco_ajax_nextpost.next_post = res.data.next_post; // Remove loader.

        (0, _utility.$)(objNextpost).siblings('.cs-nextpost-loading').remove(); // Append new post.

        (0, _utility.$)(objNextpost).append(data); // Reinit facebook.

        if ((0, _utility.$)('#fb-root').length && 'object' === (typeof FB === "undefined" ? "undefined" : _typeof(FB))) {
          FB.XFBML.parse();
        }

        (0, _utility.$)(document.body).trigger('post-load');
      }
    } else {// console.log(res);
    }
  }).fail(function (xhr, textStatus, e) {// console.log(xhr.responseText);
  });
}
/**
 * Check if Load Nextpost is defined by the wp_localize_script
 */


if (typeof csco_ajax_nextpost !== 'undefined') {
  // On Scroll Event.
  (0, _utility.$)(window).scroll(function () {
    var scrollTop = (0, _utility.$)(window).scrollTop(); // Init nextpost.

    if (csco_ajax_nextpost.next_post) {
      if (objNextpost.length && !loadingNextpost && scrollNextpost.allow) {
        scrollNextpost.allow = false;
        setTimeout(scrollNextpost.reallow, scrollNextpost.delay); // Calc current offset.

        var offset = objNextpost.offset().top + objNextpost.innerHeight() - scrollTop; // Load nextpost.

        if (4000 > offset) {
          (0, _utility.$)(objNextpost).after('<div class="cs-nextpost-loading"></div>');
          csco_ajax_get_nextpost();
        }
      }
    } // Reset browser data link.


    var objFirst = (0, _utility.$)(objNextsect).first();

    if (objFirst.length) {
      var firstTop = (0, _utility.$)(objFirst).offset().top; // If there has been a change.

      if (scrollTop < firstTop && window.location.href !== currentNLink) {
        document.title = currentNTitle;
        window.history.pushState(null, currentNTitle, currentNLink);
      }
    } // Set browser data link.


    (0, _utility.$)(objNextsect).each(function (index, elem) {
      var elemTop = (0, _utility.$)(elem).offset().top;
      var elemHeight = (0, _utility.$)(elem).innerHeight();

      if (scrollTop > elemTop && scrollTop < elemTop + elemHeight) {
        // If there has been a change.
        if (window.location.href !== (0, _utility.$)(elem).data('url')) {
          // New title.
          document.title = (0, _utility.$)(elem).data('title'); // New link.

          window.history.pushState(null, (0, _utility.$)(elem).data('title'), (0, _utility.$)(elem).data('url')); // Google Analytics.

          if (typeof gtag === 'function' && _typeof(window.gaData) === 'object') {
            var trackingId = Object.keys(window.gaData)[0];

            if (trackingId) {
              gtag('config', trackingId, {
                'page_title': (0, _utility.$)(elem).data('title'),
                'page_location': (0, _utility.$)(elem).data('url')
              });
              gtag('event', 'page_view', {
                'send_to': trackingId
              });
            }
          }
        }
      }
    });
  });
}

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

(function () {
  function initMasonry() {
    (0, _utility.$)('.cs-posts-area__masonry, .cs-block-posts-layout-masonry-type-1').each(function (index, block) {
      (0, _utility.$)(block).append("<div class=\"cs-posts-area__masonry-col cs-posts-area__masonry-col-1\"></div>\n\t\t\t\t<div class=\"cs-posts-area__masonry-col cs-posts-area__masonry-col-2\"></div>\n\t\t\t\t<div class=\"cs-posts-area__masonry-col cs-posts-area__masonry-col-3\"></div>\n\t\t\t\t<div class=\"cs-posts-area__masonry-col cs-posts-area__masonry-col-4\"></div>");
      (0, _utility.$)(block).colcade({
        columns: '.cs-posts-area__masonry-col',
        items: '.cs-posts-area-card'
      });
    });
  }

  (0, _utility.$)(document).ready(function () {
    initMasonry();

    _utility.csco.addAction('canvas.components.serverSideRender.onChange', 'init-carousel', function (props) {
      if ('canvas/posts' === props.block) {
        initMasonry();
      }
    });
  });
})();

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Mega Menu */
(function () {
  /*
  * Load Mega Menu Posts
  */
  function cscoLoadMenuPosts(menuItem) {
    var dataTerm = menuItem.children('a').data('term'),
        dataPosts = menuItem.children('a').data('posts'),
        dataNumberposts = menuItem.children('a').data('numberposts'),
        menuContainer,
        postsContainer; // Containers.

    if (menuItem.hasClass('cs-mega-menu-term')) {
      menuContainer = menuItem;
      postsContainer = menuContainer.find('.cs-mm__posts');
    }

    if (menuItem.hasClass('cs-mega-menu-posts')) {
      menuContainer = menuItem;
      postsContainer = menuContainer.find('.cs-mm__posts');
    }

    if (menuItem.hasClass('cs-mega-menu-child-term')) {
      menuContainer = menuItem.closest('.sub-menu');
      postsContainer = menuContainer.find('.cs-mm__posts[data-term="' + dataTerm + '"]');
    } // Check Menu Container.


    if (!menuContainer || typeof menuContainer === 'undefined') {
      return false;
    } // Check Container.


    if (!postsContainer || typeof postsContainer === 'undefined') {
      return false;
    } // Set Active.


    menuContainer.find('.menu-item, .cs-mm__posts').removeClass('cs-active-item');
    menuItem.addClass('cs-active-item');

    if (postsContainer) {
      postsContainer.addClass('cs-active-item');
    } // Check Loading.


    if (menuItem.hasClass('cs-mm-loading') || menuItem.hasClass('loaded')) {
      return false;
    } // Create Data.


    var data = {
      'term': dataTerm,
      'posts': dataPosts,
      'per_page': dataNumberposts
    };

    if ('undefined' === typeof csco_mega_menu) {
      return;
    } // Get Results.


    _utility.$.ajax({
      url: csco_mega_menu.rest_url,
      type: 'GET',
      data: data,
      global: false,
      async: true,
      beforeSend: function beforeSend() {
        menuItem.addClass('cs-mm-loading');
        postsContainer.addClass('cs-mm-loading');
      },
      success: function success(res) {
        if (res.status && 'success' === res.status) {
          // Set the loaded state.
          menuItem.addClass('loaded');
          postsContainer.addClass('loaded'); // Check if there're any posts.

          if (res.content && res.content.length) {
            (0, _utility.$)(res.content).imagesLoaded(function () {
              // Append Data.
              postsContainer.html(res.content);
            });
          }
        }
      },
      complete: function complete() {
        // Set the loading state.
        menuItem.removeClass('cs-mm-loading');
        postsContainer.removeClass('cs-mm-loading');
      }
    });
  }
  /*
  * Get First Tab
  */


  function cscoGetFirstTab(container) {
    var firstTab = false;
    container.find('.cs-mega-menu-child').each(function (index, el) {
      if ((0, _utility.$)(el).hasClass('cs-mega-menu-child')) {
        firstTab = (0, _utility.$)(el);
        return false;
      }
    });
    return firstTab;
  }
  /*
  * Menu on document ready
  */


  (0, _utility.$)(document).ready(function () {
    /*
    * Get Menu Posts on Hover
    */
    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-posts').on('mouseenter', function () {
      cscoLoadMenuPosts((0, _utility.$)(this));
    });
    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-term').on('mouseenter', function () {
      cscoLoadMenuPosts((0, _utility.$)(this));
    });
    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-child').on('mouseenter', function () {
      cscoLoadMenuPosts((0, _utility.$)(this));
    });
    /*
    * Load First Tab on Mega Menu Hover
    */

    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-terms').on('mouseenter', function () {
      var tab = cscoGetFirstTab((0, _utility.$)(this));

      if (tab) {
        cscoLoadMenuPosts(tab);
      }
    });
  });
  /*
  * Load First Tab on Navbar Ready.
  */

  (0, _utility.$)(document, '.cs-header__nav').ready(function () {
    var tab = false; // Autoload First Tab.

    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-terms').each(function (index, el) {
      tab = cscoGetFirstTab((0, _utility.$)(this));

      if (tab) {
        cscoLoadMenuPosts(tab);
      }
    }); // Autoload Posts.

    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-posts').each(function (index, el) {
      cscoLoadMenuPosts((0, _utility.$)(this));
    }); // Autoload Term.

    (0, _utility.$)('.cs-header__nav .menu-item.cs-mega-menu-term').each(function (index, el) {
      cscoLoadMenuPosts((0, _utility.$)(this));
    });
  });
})();

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Navigation */
var cscoNavigation = {};

(function () {
  var $this;
  cscoNavigation = {
    /** Initialize */
    init: function init(e) {
      if ((0, _utility.$)('body').hasClass('wp-admin')) {
        return;
      }

      var headerStretch = (0, _utility.$)('.cs-navbar-smart-enabled .cs-header-stretch');

      if (headerStretch.length > 0) {
        (0, _utility.$)('.cs-site-inner').prepend("<div class=\"cs-header-stretch-copy\"> ".concat(headerStretch.html(), " </div>"));

        if (headerStretch.hasClass('cs-header-one')) {
          (0, _utility.$)('.cs-header-stretch-copy').addClass('cs-header-one');
        }

        if (headerStretch.hasClass('cs-header-two')) {
          (0, _utility.$)('.cs-header-stretch-copy').addClass('cs-header-two');
        }

        if (headerStretch.hasClass('cs-header-three')) {
          (0, _utility.$)('.cs-header-stretch-copy').addClass('cs-header-three');
        }

        if (headerStretch.hasClass('cs-header-four')) {
          (0, _utility.$)('.cs-header-stretch-copy').addClass('cs-header-four');
        }
      }

      $this = cscoNavigation; // Init events.

      $this.events(e);
    },

    /** Events */
    events: function events(e) {
      // DOM Load
      document.addEventListener('DOMContentLoaded', function (e) {
        $this.smartLevels(e);
        $this.adaptTablet(e);
        $this.stickyScroll(e);
      }); // Resize

      window.addEventListener('resize', function (e) {
        $this.smartLevels(e);
        $this.adaptTablet(e);
        $this.stickyScroll(e);
      });
    },

    /** Smart multi-Level menu */
    smartLevels: function smartLevels(e) {
      var windowWidth = _utility.$window.width(); // Reset Calc.


      (0, _utility.$)('.cs-header__nav-inner li').removeClass('cs-sm__level');
      (0, _utility.$)('.cs-header__nav-inner li').removeClass('cs-sm-position-left cs-sm-position-right');
      (0, _utility.$)('.cs-header__nav-inner li .sub-menu').removeClass('cs-mm__position-init'); // Set Settings.

      (0, _utility.$)('.cs-header__nav-inner > li.menu-item').not('.cs-mm').each(function (index, parent) {
        var position = 'cs-sm-position-right'; //right

        var objPrevWidth = 0;
        (0, _utility.$)(parent).find('.sub-menu').each(function (index, el) {
          // Reset child levels.
          (0, _utility.$)(el).parent().next('li').addClass('cs-sm__level');

          if ((0, _utility.$)(el).parent().hasClass('cs-sm__level')) {
            (0, _utility.$)(el).parent().removeClass('cs-mm-level');
            position = 'cs-sm-position-right'; //right

            objPrevWidth = 0;
          } // Find out position items.


          var offset = (0, _utility.$)(el).offset();
          var objOffset = offset.left;

          if ('cs-sm-position-right' === position && (0, _utility.$)(el).outerWidth() + objOffset > windowWidth) {
            position = 'cs-sm-position-left';
          }

          if ('cs-sm-position-left' === position && objOffset - ((0, _utility.$)(el).outerWidth() + objPrevWidth) < 0) {
            position = 'cs-sm-position-right'; //right
          }

          objPrevWidth = (0, _utility.$)(el).outerWidth();
          (0, _utility.$)(el).addClass('cs-sm-position-init').parent().addClass(position);
        });
      });
    },

    /** Adapting nav bar for tablet */
    adaptTablet: function adaptTablet(e) {
      // Click outside.
      (0, _utility.$)(document).on('touchstart', function (e) {
        if (!(0, _utility.$)(e.target).closest('.cs-header__nav-inner').length) {
          (0, _utility.$)('.cs-header__nav-inner .menu-item-has-children').removeClass('submenu-visible');
        } else {
          (0, _utility.$)(e.target).parents('.menu-item').siblings().find('.menu-item').removeClass('submenu-visible');
          (0, _utility.$)(e.target).parents('.menu-item').siblings().closest('.menu-item').removeClass('submenu-visible');
        }
      });
      (0, _utility.$)('.cs-header__nav-inner .menu-item-has-children').each(function (e) {
        // Reset class.
        (0, _utility.$)(this).removeClass('submenu-visible'); // Remove expanded.

        (0, _utility.$)(this).find('> a > .expanded').remove(); // Add a caret.

        if ('ontouchstart' in document.documentElement) {
          (0, _utility.$)(this).find('> a').append('<span class="expanded"></span>');
        } // Check touch device.


        (0, _utility.$)(this).addClass('ontouchstart' in document.documentElement ? 'touch-device' : '');
        (0, _utility.$)('> a .expanded', this).on('touchstart', function (e) {
          e.preventDefault();
          (0, _utility.$)(this).closest('.menu-item-has-children').toggleClass('submenu-visible');
        });

        if ('#' === (0, _utility.$)('> a', this).attr('href')) {
          (0, _utility.$)('> a', this).on('touchstart', function (e) {
            e.preventDefault();

            if (!(0, _utility.$)(e.target).hasClass('expanded')) {
              (0, _utility.$)(this).closest('.menu-item-has-children').toggleClass('submenu-visible');
            }
          });
        }
      });
    },

    /** Make nav bar sticky */
    stickyScroll: function stickyScroll(e) {
      // Get css variables
      var headerLargeHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-initial-height')),
          headerCompactHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height')),
          headerPadding = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-padding')),
          headerTopbar = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-topbar-height')); //Get header elements

      var headerSmart = (0, _utility.$)('.cs-navbar-smart-enabled .cs-header, .cs-navbar-sticky-enabled .cs-header'),
          headerBefore = (0, _utility.$)('.cs-header-before'),
          headerStretch = (0, _utility.$)('.cs-navbar-smart-enabled .cs-header-stretch'),
          headerCopy = (0, _utility.$)('.cs-header-stretch-copy'),
          wpAdminBar = (0, _utility.$)('#wpadminbar'),
          headerSearch = (0, _utility.$)('.cs-search'); // Difference beetween small and big sizes of stretch header

      var headerDelta;

      if (headerStretch.length > 0) {
        headerDelta = headerLargeHeight - headerCompactHeight;
      } else {
        headerDelta = 0;
      } // Adminbar sizes


      var wpAdminBarHeight;

      if (wpAdminBar.length > 0) {
        wpAdminBarHeight = wpAdminBar.outerHeight();
      } else {
        wpAdminBarHeight = 0;
      } // Header smart start position.


      var smartStart;

      if (headerBefore.length > 0) {
        smartStart = headerBefore.offset().top;
      } else {
        if (headerSmart.length > 0) {
          smartStart = headerSmart.offset().top + wpAdminBarHeight;
        } else {
          smartStart = wpAdminBarHeight;
        }
      } // Set values to hide.


      var scrollPoint = 200,
          scrollPrev = 200,
          scrollUpAmount = 0;
      (0, _utility.$)(window).scroll(function () {
        var scrolled = (0, _utility.$)(window).scrollTop(),
            headerSmartPosition = headerSmart.length > 0 ? headerSmart.offset().top : 0;

        if (scrolled > smartStart + headerDelta + scrollPoint + 10 && scrolled > scrollPrev) {
          if (headerStretch.length === 0) {
            if (scrolled > smartStart + headerLargeHeight + 200 + (headerPadding || 0) + (headerTopbar || 0)) {
              headerSmart.removeClass('cs-header-smart-visible');
            }
          }

          if (headerStretch.length > 0 && scrolled > smartStart + headerDelta + headerLargeHeight + (headerPadding || 0) + (headerTopbar || 0)) {
            headerCopy.removeClass('cs-header-smart-visible');
          }

          headerSearch.slideUp();
          (0, _utility.$)(document).trigger('sticky-nav-hide');
        } else {
          if (scrollUpAmount >= scrollPoint || scrolled === 0) {
            if (headerStretch.length > 0) {
              if (scrolled > smartStart + headerDelta + headerLargeHeight + (headerPadding || 0) + (headerTopbar || 0)) {
                headerCopy.addClass('cs-header-smart-visible');
                (0, _utility.$)(document).trigger('sticky-nav-visible');
              } else if (scrolled < smartStart + headerDelta + headerLargeHeight + (headerPadding || 0) + (headerTopbar || 0)) {
                headerCopy.removeClass('cs-header-smart-visible');
                (0, _utility.$)(document).trigger('sticky-nav-hide');
              }
            } else {
              headerSmart.addClass('cs-header-smart-visible');
              (0, _utility.$)(document).trigger('sticky-nav-visible');
            }
          }
        }

        if (headerSmart.length > 0) {
          if (headerStretch.length === 0) {
            if (scrolled > smartStart + headerLargeHeight + (headerPadding || 0) + (headerTopbar || 0)) {
              headerSmart.addClass('cs-scroll-sticky');

              _utility.$body.addClass('cs-header-scroll-sticky');
            } else if (headerSmartPosition <= smartStart) {
              headerSmart.removeClass('cs-scroll-sticky').removeClass('cs-header-smart-visible');

              _utility.$body.removeClass('cs-header-scroll-sticky');

              (0, _utility.$)(document).trigger('sticky-nav-hide');
            }
          }
        }

        if (scrolled < scrollPrev) {
          scrollUpAmount += scrollPrev - scrolled;
        } else {
          scrollUpAmount = 0;
        }

        if (wpAdminBar.length > 0 && _utility.wndW <= 600 && scrolled >= wpAdminBarHeight) {
          (0, _utility.$)(document).trigger('adminbar-mobile-scrolled');
        } else {
          (0, _utility.$)(document).trigger('adminbar-mobile-no-scrolled');
        }

        scrollPrev = scrolled;
      });
    }
  };
})(); // Initialize.


cscoNavigation.init();

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Offcanvas */
(function () {
  (0, _utility.$)('.cs-header__offcanvas-toggle, .cs-site-overlay, .cs-offcanvas__toggle').on('click', function (e) {
    e.preventDefault(); // Transition.

    if (!_utility.$body.hasClass('cs-offcanvas-active')) {
      _utility.$body.addClass('cs-offcanvas-transition');
    } else {
      setTimeout(function () {
        _utility.$body.removeClass('cs-offcanvas-transition');
      }, 400);
    } // Toogle offcanvas.


    _utility.$body.toggleClass('cs-offcanvas-active');
  });
})();

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Hover player control */
(function () {
  (0, _utility.$)('.cs-player-control').hover(function () {
    (0, _utility.$)(this).siblings('.cs-player-control').css('opacity', '0.5');
  }, function () {
    (0, _utility.$)(this).siblings('.cs-player-control').css('opacity', '1');
  });
})();

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Color Scheme Toogle */
var cscoDarkMode = {};

(function () {
  var $this;
  cscoDarkMode = {
    /** Initialize */
    init: function init(e) {
      $this = cscoDarkMode; // Init events.

      $this.events(e);
    },

    /** Events */
    events: function events(e) {
      if ((0, _utility.$)('body').hasClass('wp-admin')) {
        return;
      } // DOM Load


      window.addEventListener('load', function (e) {
        $this.initMode(e);
      });
      window.matchMedia('(prefers-color-scheme: dark)').addListener(function (e) {
        $this.initMode(e);
      }); // Switch

      (0, _utility.$)(document).on('click', '.cs-site-scheme-toggle', function (e) {
        $this.changeMode(e);
      });
    },

    /** Detect Color Scheme */
    detectColorScheme: function detectColorScheme(color) {
      var level = 190; // Set alpha channel.

      var alpha = 1;
      var rgba = [255, 255, 255];
      var color_rgba = false; // Trim color.

      color = color.trim(); // If HEX format.

      if ('#' === color[0]) {
        // Remove '#' from start.
        color = color.replace('#', '').trim();

        if (3 === color.length) {
          color = color[0] + color[0] + color[1] + color[1] + color[2] + color[2];
        }

        rgba[0] = parseInt(color.substr(0, 2), 16);
        rgba[1] = parseInt(color.substr(2, 2), 16);
        rgba[2] = parseInt(color.substr(4, 2), 16);
      } else if (color_rgba = color.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i)) {
        // Convert RGB or RGBA.
        rgba[0] = parseInt(color_rgba[1]);
        rgba[1] = parseInt(color_rgba[2]);
        rgba[2] = parseInt(color_rgba[3]);

        if (color_rgba[4] !== undefined) {
          alpha = parseFloat(color_rgba[4]);
        }
      } // Apply alpha channel.


      rgba.forEach(function myFunction(channel, key, stack) {
        stack[key] = String(channel + Math.ceil((255 - channel) * (1 - alpha))).padStart(2, '0');
      }); // Set default scheme.

      var scheme = 'default'; // Get brightness.

      var brightness = (rgba[0] * 299 + rgba[1] * 587 + rgba[2] * 114) / 1000; // If color gray.

      if (rgba[0] === rgba[1] && rgba[1] === rgba[2]) {
        if (brightness < level) {
          scheme = 'dark';
        }
      } else {
        if (brightness < level) {
          scheme = 'inverse';
        }
      }

      return scheme;
    },

    /** Set Individual Scheme */
    setIndividualScheme: function setIndividualScheme() {
      var list = {
        'body': '--cs-color-site-background',
        '.cs-topbar': '--cs-color-topbar-background',
        '.cs-header': '--cs-color-header-background',
        '.cs-header__nav-inner .sub-menu': '--cs-color-submenu-background',
        '.cs-header__multi-column-container': '--cs-color-submenu-background',
        '.cs-header__widgets': '--cs-color-submenu-background',
        '.cs-offcanvas__header': '--cs-color-header-background',
        '.cs-search': '--cs-color-search-background',
        '.cs-footer': '--cs-color-footer-background',
        '.cs-fullscreen-menu': '--cs-color-fullscreen-menu-background',
        '.cs-header__featured-column-container': '--cs-color-featured-column-background'
      };

      for (var key in list) {
        if ((0, _utility.$)(key).length <= 0) {
          continue;
        }
        /* jshint ignore:start */


        (0, _utility.$)(key).each(function (index, element) {
          var color = window.getComputedStyle((0, _utility.$)(element)[0]).getPropertyValue(list[key]);
          var scheme = $this.detectColorScheme(color);
          (0, _utility.$)(element).attr('data-scheme', scheme);
        });
        /* jshint ignore:end */
      }
    },

    /** Init Mode */
    initMode: function initMode(e) {
      // Get system scheme.
      var systemSchema = 'default';

      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        systemSchema = 'dark';
      }

      (0, _utility.csSetCookie)('_color_system_schema', systemSchema, {
        expires: 2592000
      }); // Set site scheme.

      var siteScheme = 'default';

      switch (csLocalize.siteSchemeMode) {
        case 'dark':
          siteScheme = 'dark';
          break;

        case 'light':
          siteScheme = 'default';
          break;

        case 'system':
          siteScheme = systemSchema;
          break;
      }

      if (csLocalize.siteSchemeToogle) {
        if ('default' === (0, _utility.csGetCookie)('_color_schema')) {
          siteScheme = 'default';
        }

        if ('dark' === (0, _utility.csGetCookie)('_color_schema')) {
          siteScheme = 'dark';
        }
      } // Change site scheme


      if (siteScheme !== _utility.$body.attr('data-site-scheme')) {
        $this.changeScheme(siteScheme, false);
      }
    },

    /** Change Mode */
    changeMode: function changeMode(e) {
      if ('dark' === _utility.$body.attr('data-site-scheme')) {
        $this.changeScheme('default', true);
      } else {
        $this.changeScheme('dark', true);
      }
    },

    /** Change Scheme */
    changeScheme: function changeScheme(scheme, cookie) {
      _utility.$body.addClass('cs-scheme-toggled');

      _utility.$body.attr('data-site-scheme', scheme);

      $this.setIndividualScheme();

      if (cookie) {
        (0, _utility.csSetCookie)('_color_schema', scheme, {
          expires: 2592000
        });
        (0, _utility.csSetCookie)('_color_system_schema', null, {
          expires: 2592000
        });
      }

      setTimeout(function () {
        _utility.$body.removeClass('cs-scheme-toggled');
      }, 100);
    }
  };
})(); // Initialize.


cscoDarkMode.init();

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Search Dropdown */
(function () {
  var focusSearchTimeout;
  (0, _utility.$)('.cs-header__search-toggle').click(function (e) {
    if (!(0, _utility.$)('.cs-search').is(":visible")) {
      focusSearchTimeout = setTimeout(function () {
        (0, _utility.$)('.cs-search .cs-search__input').focus();
      }, 300);
    } else {
      clearTimeout(focusSearchTimeout);
    }

    if (_utility.$body.hasClass('cs-search-type-two')) {
      (0, _utility.$)('.cs-search').stop().fadeIn();

      _utility.$body.addClass('cs-search-type-two-visible');
    } else {
      (0, _utility.$)('.cs-search').stop().fadeToggle();
    }

    e.preventDefault();
  });
  (0, _utility.$)('.cs-search__input').keypress(function (e) {
    if (13 === e.which) {
      (0, _utility.$)(this).closest('form').submit();
      return false;
    }
  });
  (0, _utility.$)('.cs-search__close').click(function (e) {
    (0, _utility.$)('.cs-search').fadeOut();

    _utility.$body.removeClass('cs-search-type-two-visible');

    e.preventDefault();
    clearTimeout(focusSearchTimeout);
  });
})();

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Sticky Sidebar */
(function () {
  var stickyElementsSmart = [],
      stickyElements = [];
  stickyElementsSmart.push('.cs-navbar-smart-enabled .cs-entry__metabar-inner');
  stickyElementsSmart.push('.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled.cs-stick-to-top .cs-sidebar__inner');
  stickyElementsSmart.push('.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled.cs-stick-last .cs-sidebar__inner .widget:last-child');
  stickyElementsSmart.push('.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled .cnvs-block-section-sidebar-sticky-top .cnvs-block-section-sidebar-inner');
  stickyElementsSmart.push('.cs-sticky-sidebar-enabled.cs-navbar-smart-enabled .cnvs-block-section-sidebar-sticky-top-last-block .cnvs-block-section-sidebar-inner > :last-child');
  stickyElements.push('.cs-navbar-sticky-enabled .cs-entry__metabar-inner');
  stickyElements.push('.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled.cs-stick-to-top .cs-sidebar__inner');
  stickyElements.push('.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled.cs-stick-last .cs-sidebar__inner .widget:last-child');
  stickyElements.push('.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled .cnvs-block-section-sidebar-sticky-top .cnvs-block-section-sidebar-inner');
  stickyElements.push('.cs-sticky-sidebar-enabled.cs-navbar-sticky-enabled .cnvs-block-section-sidebar-sticky-top-last-block .cnvs-block-section-sidebar-inner > :last-child');

  _utility.$doc.ready(function () {
    var headerStick = (0, _utility.$)('.cs-header'),
        wpAdminBar = (0, _utility.$)('#wpadminbar'),
        wpAdminBarHeight = wpAdminBar.outerHeight(),
        headerStretch = (0, _utility.$)('.cs-header-stretch'),
        headerSmart = (0, _utility.$)('.cs-navbar-smart-enabled .cs-header'),
        headerStretchHeight = headerSmart.length > 0 ? parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height')) : headerStick.outerHeight(),
        headerStickHeight = headerSmart.length > 0 ? parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height')) : headerStick.outerHeight(),
        headerScrollHeight = 0,
        allHeight = (headerStickHeight || 0) + (wpAdminBarHeight || 0) + 20,
        windowWidth = (0, _utility.$)(window).width(); // Sticky sidebar for mozilla.

    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
      stickyElementsSmart.push('.cs-sticky-sidebar-enabled.cs-stick-to-bottom .cs-sidebar__inner');
      stickyElements.push('.cs-sticky-sidebar-enabled.cs-stick-to-bottom .cs-sidebar__inner');
    } // Join elements.


    stickyElementsSmart = stickyElementsSmart.join(',');
    stickyElements = stickyElements.join(','); // header scroll show

    _utility.$doc.on('entry-header-scrolled', function () {
      headerScrollHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height'));
    }); // header scroll hide


    _utility.$doc.on('entry-header-no-scrolled', function () {
      headerScrollHeight = 0;
    }); // Sticky nav visible.


    _utility.$doc.on('sticky-nav-visible', function () {
      headerStickHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height'));

      if (headerStretchHeight) {
        allHeight = (headerStretchHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      } else {
        allHeight = (headerStickHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      }

      (0, _utility.$)(stickyElementsSmart).css('top', allHeight + 'px'); // alert(allHeight);
    }); // Sticky nav hide.


    _utility.$doc.on('sticky-nav-hide', function () {
      headerStickHeight = 0;
      allHeight = (headerStickHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      (0, _utility.$)(stickyElementsSmart).css('top', allHeight + 'px');
    });

    _utility.$doc.on('stretch-nav-to-small', function () {
      headerStretchHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-height'));

      if (headerStretchHeight) {
        allHeight = (headerStretchHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      } else {
        allHeight = (headerStickHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      }

      if (headerStretch.hasClass("cs-scroll-sticky") && !headerStretch.hasClass("cs-scroll-active")) {
        (0, _utility.$)(stickyElementsSmart).css('top', allHeight + 'px');
      }
    });

    _utility.$doc.on('stretch-nav-to-big', function () {
      headerStretchHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--cs-header-initial-height'));
    }); // Add top style


    if (_utility.$body.hasClass('cs-navbar-smart-enabled') && windowWidth >= 1020) {
      if (headerStretchHeight) {
        allHeight = (headerStretchHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      } else {
        allHeight = (headerStickHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      }

      (0, _utility.$)(stickyElementsSmart).css('top', allHeight + 'px');
    } else if (_utility.$body.hasClass('cs-navbar-sticky-enabled') && windowWidth >= 1020) {
      if (headerStretchHeight) {
        allHeight = (headerStretchHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      } else {
        allHeight = (headerStickHeight || 0) + (headerScrollHeight || 0) + (wpAdminBarHeight || 0) + 20;
      }

      (0, _utility.$)(stickyElements).css('top', allHeight + 'px');
    } // Remove top style rafter resize


    _utility.$window.resize(function () {
      var windowWidthResize = _utility.$window.width();

      if (windowWidthResize < 1020) {
        (0, _utility.$)(stickyElements).removeAttr('style');
        (0, _utility.$)(stickyElementsSmart).removeAttr('style');
      }
    });
  });
})();
/*cs-navbar-sticky-enabled cs-navbar-smart-enabled*/

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Video Background */
(function () {
  var initAPI = false;
  var process = false;
  var contex = [];
  var players = [];
  var attrs = []; // Create deferred object

  var YTdeferred = _utility.$.Deferred();

  window.onYouTubePlayerAPIReady = function () {
    // Resolve when youtube callback is called
    // passing YT as a parameter.
    YTdeferred.resolve(window.YT);
  }; // Embedding youtube iframe api.


  function embedYoutubeAPI() {
    var tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  } // Video rescale.


  function rescaleVideoBackground() {
    (0, _utility.$)('.cs-video-init').each(function () {
      var w = (0, _utility.$)(this).parent().width();
      var h = (0, _utility.$)(this).parent().height();
      var hideControl = 400;
      var id = (0, _utility.$)(this).attr('data-uid');

      if (w / h > 16 / 9) {
        players[id].setSize(w, w / 16 * 9 + hideControl);
      } else {
        players[id].setSize(h / 9 * 16, h + hideControl);
      }
    });
  } // Init video background.


  function initVideoBackground() {
    if ((0, _utility.$)('body').hasClass('wp-admin')) {
      return;
    }

    if (process) {
      return;
    }

    process = true; // Smart init API.

    if (!initAPI) {
      var elements = (0, _utility.$)('.cs-video-wrapper[data-video-id]');

      if (elements.length) {
        embedYoutubeAPI();
        initAPI = true;
      }
    }

    if (!initAPI) {
      process = false;
      return;
    } // Whenever youtube callback was called = deferred resolved
    // your custom function will be executed with YT as an argument.


    YTdeferred.done(function (YT) {
      (0, _utility.$)('.cs-video-inner').each(function () {
        // The state.
        var isInit = (0, _utility.$)(this).hasClass('cs-video-init');
        var id = null; // Generate unique ID.

        if (!isInit) {
          id = Math.random().toString(36).substr(2, 9);
        } else {
          id = (0, _utility.$)(this).attr('data-uid');
        } // Create contex.


        contex[id] = this; // The actived.

        var isActive = (0, _utility.$)(contex[id]).hasClass('active'); // The monitor.

        var isInView = (0, _utility.$)(contex[id]).isInViewport(); // Initialization.

        if (isInView && !isInit) {
          // Add init class.
          (0, _utility.$)(contex[id]).addClass('cs-video-init'); // Add unique ID.

          (0, _utility.$)(contex[id]).attr('data-uid', id); // Get video attrs.

          var videoID = (0, _utility.$)(contex[id]).parent().data('video-id');
          var videoStart = (0, _utility.$)(contex[id]).parent().data('video-start');
          var videoEnd = (0, _utility.$)(contex[id]).parent().data('video-end'); // Check video id.

          if (typeof videoID === 'undefined' || !videoID) {
            return;
          } // Video attrs.


          attrs[id] = {
            'videoId': videoID,
            'startSeconds': videoStart,
            'endSeconds': videoEnd,
            'suggestedQuality': 'hd720'
          }; // Creating a player.

          players[id] = new YT.Player(contex[id], {
            playerVars: {
              autoplay: 0,
              autohide: 1,
              modestbranding: 1,
              rel: 0,
              showinfo: 0,
              controls: 0,
              disablekb: 1,
              enablejsapi: 0,
              iv_load_policy: 3,
              playsinline: 1,
              loop: 1
            },
            events: {
              'onReady': function onReady() {
                players[id].loadVideoById(attrs[id]);
                players[id].mute();
              },
              'onStateChange': function onStateChange(e) {
                if (e.data === 1) {
                  (0, _utility.$)(contex[id]).parents('.cs-overlay, .cs-video-wrap').addClass('cs-video-bg-init');
                  (0, _utility.$)(contex[id]).addClass('active');
                } else if (e.data === 0) {
                  players[id].seekTo(attrs[id].startSeconds);
                }
              }
            }
          });
          rescaleVideoBackground();
        } // Pause and play.


        var control = (0, _utility.$)(contex[id]).parents('.cs-overlay, .cs-video-wrap').find('.cs-player-state');

        if (isActive && isInit && !(0, _utility.$)(control).hasClass('cs-player-upause')) {
          if (isInView && (0, _utility.$)(control).hasClass('cs-player-play')) {
            // Change icon.
            (0, _utility.$)(control).removeClass('cs-player-play').addClass('cs-player-pause'); // Pause video.

            players[id].playVideo();
          }

          if (!isInView && (0, _utility.$)(control).hasClass('cs-player-pause')) {
            // Change icon.
            (0, _utility.$)(control).removeClass('cs-player-pause').addClass('cs-player-play'); // Pause video.

            players[id].pauseVideo();
          }
        }
      });
    });
    process = false;
  } // State Control.


  _utility.$doc.on('click', '.cs-player-state', function () {
    var container = (0, _utility.$)(this).parents('.cs-overlay, .cs-video-wrap').find('.cs-video-inner');
    var id = (0, _utility.$)(container).attr('data-uid');
    (0, _utility.$)(this).toggleClass('cs-player-pause cs-player-play');

    if ((0, _utility.$)(this).hasClass('cs-player-pause')) {
      (0, _utility.$)(this).removeClass('cs-player-upause');
      players[id].playVideo();
    } else {
      (0, _utility.$)(this).addClass('cs-player-upause');
      players[id].pauseVideo();
    }
  }); // Stop Control.


  _utility.$doc.on('click', '.cs-player-stop', function () {
    var container = (0, _utility.$)(this).parents('.cs-overlay, .cs-video-wrap').find('.cs-video-inner');
    var id = (0, _utility.$)(container).attr('data-uid');
    (0, _utility.$)(this).siblings('.cs-player-state').removeClass('cs-player-pause').addClass('cs-player-play');
    (0, _utility.$)(this).siblings('.cs-player-state').addClass('cs-player-upause');
    players[id].pauseVideo();
  }); // Volume Control.


  _utility.$doc.on('click', '.cs-player-volume', function () {
    var container = (0, _utility.$)(this).parents('.cs-overlay, .cs-video-wrap').find('.cs-video-inner');
    var id = (0, _utility.$)(container).attr('data-uid');
    (0, _utility.$)(this).toggleClass('cs-player-mute cs-player-unmute');

    if ((0, _utility.$)(this).hasClass('cs-player-unmute')) {
      players[id].unMute();
    } else {
      players[id].mute();
    }
  }); // Document scroll.


  _utility.$window.on('load scroll resize scrollstop', function () {
    initVideoBackground();
  }); // Document ready.


  _utility.$doc.ready(function () {
    initVideoBackground();
  }); // Post load.


  _utility.$body.on('post-load', function () {
    initVideoBackground();
  }); // Document resize.


  _utility.$window.on('resize', function () {
    rescaleVideoBackground();
  }); // Init.


  initVideoBackground();
})();

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _utility = __webpack_require__(0);

/** ----------------------------------------------------------------------------
 * Widget Nav Menu */
(function () {
  _utility.$.fn.responsiveNav = function () {
    this.removeClass('menu-item-expanded');

    if (this.prev().hasClass('submenu-visible')) {
      this.prev().removeClass('submenu-visible').slideUp(350);
      this.parent().removeClass('menu-item-expanded');
    } else {
      this.parent().parent().find('.menu-item .sub-menu').removeClass('submenu-visible').slideUp(350);
      this.parent().parent().find('.menu-item-expanded').removeClass('menu-item-expanded');
      this.prev().toggleClass('submenu-visible').hide().slideToggle(350);
      this.parent().toggleClass('menu-item-expanded');
    }
  }; //
  // Navigation Menu Widget
  //


  (0, _utility.$)(document).ready(function (e) {
    (0, _utility.$)('.widget_nav_menu .menu-item-has-children').each(function (e) {
      // Add a caret.
      (0, _utility.$)(this).append('<span></span>'); // Fire responsiveNav() when clicking a caret.

      (0, _utility.$)('> span', this).on('click', function (e) {
        e.preventDefault();
        (0, _utility.$)(this).responsiveNav();
      }); // Fire responsiveNav() when clicking a parent item with # href attribute.

      if ('#' === (0, _utility.$)('> a', this).attr('href')) {
        (0, _utility.$)('> a', this).on('click', function (e) {
          e.preventDefault();
          (0, _utility.$)(this).next().next().responsiveNav();
        });
      }
    });
  });
})();

/***/ })
/******/ ]);