"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); Object.defineProperty(subClass, "prototype", { writable: false }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

/**
 * Editor Wrapper
 */
function csEditorWrapper() {
  var Component = wp.element.Component;
  var registerPlugin = wp.plugins.registerPlugin;
  var _wp$data = wp.data,
      select = _wp$data.select,
      subscribe = _wp$data.subscribe;
  var registerBlockStyle = wp.blocks.registerBlockStyle;
  var __ = wp.i18n.__;
  var cscoGutenberg = {};

  (function () {
    var $this;
    cscoGutenberg = {
      /*
      * Variables
      */
      wrapper: false,
      content: false,
      template: null,
      singularLayout: null,

      /*
      * Initialize
      */
      init: function init(e) {
        $this = cscoGutenberg; // Find wrapper and content elements.

        $this.content = document.querySelector('.block-editor-editor-skeleton__content, .interface-interface-skeleton__content');
        $this.wrapper = document.querySelector('.editor-styles-wrapper'); // Init events.

        if ('undefined' === typeof window.cscoGutenbergInit) {
          $this.events(e);
          window.cscoGutenbergInit = true;
        }
      },

      /*
      * Events
      */
      events: function events(e) {
        // Update singular layout.
        subscribe(function () {
          var meta = select('core/editor').getEditedPostAttribute('meta');

          if ('object' === _typeof(meta) && meta['csco_singular_sidebar']) {
            var newSingularLayout = meta['csco_singular_sidebar'];

            if (newSingularLayout !== $this.singularLayout) {
              $this.singularLayout = newSingularLayout;
              $this.changeLayout();
            }
          }
        }); // Update template.

        subscribe(function () {
          var newTemplate = select('core/editor').getEditedPostAttribute('template');

          if (newTemplate !== $this.template) {
            $this.template = newTemplate;
            $this.initPageTemplate();
            $this.changeLayout();
          }
        }); // Update Breakpoints during resize.

        window.addEventListener('resize', function (e) {
          $this.initBreakpoints();
          $this.initChanges();
        }); // Update Breakpoints.

        var observer = new MutationObserver(function (mutations) {
          mutations.forEach(function (mutation) {
            if (mutation.oldValue !== mutation.target.classList.value) {
              $this.initBreakpoints();
              $this.initChanges();
            }
          });
        });
        observer.observe(document.getElementsByTagName('body')[0], {
          attributes: true,
          subtree: false,
          attributeOldValue: true,
          attributeFilter: ["class"]
        });
        observer.observe(document.getElementsByClassName('edit-post-layout')[0], {
          attributes: true,
          subtree: false,
          attributeOldValue: true,
          attributeFilter: ["class"]
        });
      },

      /*
      * Get page template
      */
      getPageTemplate: function getPageTemplate() {
        return select('core/editor').getEditedPostAttribute('template');
      },

      /*
      * Initialize changes
      */
      initChanges: function initChanges() {
        setTimeout(function () {
          document.body.dispatchEvent(new Event('editor-render'));
        }, 200);
      },

      /*
      * Initialize page template
      */
      initPageTemplate: function initPageTemplate() {
        if ('template-canvas-fullwidth.php' === $this.getPageTemplate()) {
          document.body.classList.add('template-canvas-fullwidth');
        } else {
          document.body.classList.remove('template-canvas-fullwidth');
        }
      },

      /*
      * Initialize the breakpoints system
      */
      initBreakpoints: function initBreakpoints() {
        if ('undefined' === typeof $this) {
          return;
        }

        if (!$this.wrapper || !$this.content) {
          return;
        } // Default breakpoints that should apply to all observed
        // elements that don't define their own custom breakpoints.


        var breakpoints = {
          'cs-breakpoint-up-576px': 576,
          'cs-breakpoint-up-768px': 768,
          'cs-breakpoint-up-1020px': 1020,
          'cs-breakpoint-up-1200px': 1200,
          'cs-breakpoint-up-1280px': 1280,
          'cs-breakpoint-up-1434px': 1434,
          'cs-breakpoint-up-1584px': 1584,
          'cs-breakpoint-up-1780px': 1780,
          'cs-breakpoint-up-1920px': 1920
        }; // Update the matching breakpoints on the observed element.

        Object.keys(breakpoints).forEach(function (breakpoint) {
          var minWidth = breakpoints[breakpoint];

          if ($this.wrapper.clientWidth >= minWidth) {
            $this.content.classList.add(breakpoint);
          } else {
            $this.content.classList.remove(breakpoint);
          }
        });
      },

      /**
       * Init page layout.
       */
      initLayout: function initLayout() {
        if ('undefined' === typeof $this || !$this.wrapper) {
          return;
        }

        $this.wrapper.classList.add('cs-editor-styles-wrapper');

        if ('template-canvas-fullwidth.php' === $this.getPageTemplate()) {
          $this.wrapper.classList.add('cs-sidebar-disabled');
        } else {
          $this.wrapper.classList.add(cscoGWrapper.page_layout);
        }

        $this.wrapper.classList.add(cscoGWrapper.post_type);
        $this.wrapper.classList.add(cscoGWrapper.post_sidebar);
        $this.wrapper.classList.add(cscoGWrapper.section_heading);
      },

      /**
       * Get new page layout.
       */
      newLayout: function newLayout(layout) {
        if ('right' === layout || 'left' === layout) {
          return 'cs-sidebar-enabled';
        } else if ('disabled' === layout) {
          return 'cs-sidebar-disabled';
        } else {
          return cscoGWrapper.default_layout;
        }
      },

      /**
       * Update when page layout has changed.
       */
      changeLayout: function changeLayout() {
        if ('undefined' === typeof $this || !$this.wrapper) {
          return;
        }

        var layout = $this.singularLayout;

        if ('template-canvas-fullwidth.php' === $this.getPageTemplate()) {
          layout = 'disabled';
        }

        if ($this.newLayout(layout) === cscoGWrapper.page_layout) {
          return;
        }

        $this.wrapper.classList.remove('cs-sidebar-enabled');
        $this.wrapper.classList.remove('cs-sidebar-disabled');

        if ('right' === layout || 'left' === layout) {
          cscoGWrapper.page_layout = 'cs-sidebar-enabled';
          $this.wrapper.classList.add('cs-sidebar-enabled');
        } else if ('disabled' === layout) {
          cscoGWrapper.page_layout = 'cs-sidebar-disabled';
          $this.wrapper.classList.add('cs-sidebar-disabled');
        } else {
          cscoGWrapper.page_layout = cscoGWrapper.default_layout;
          $this.wrapper.classList.add(cscoGWrapper.default_layout);
        }

        $this.initChanges();
      }
    };
  })();

  var cscoGutenbergInit = /*#__PURE__*/function (_Component) {
    _inherits(cscoGutenbergInit, _Component);

    var _super = _createSuper(cscoGutenbergInit);

    function cscoGutenbergInit() {
      _classCallCheck(this, cscoGutenbergInit);

      return _super.apply(this, arguments);
    }

    _createClass(cscoGutenbergInit, [{
      key: "componentDidMount",
      value:
      /**
       * Add initial class.
       */
      function componentDidMount() {
        // Initialize.
        cscoGutenberg.init(); // Initialize Page Template.

        cscoGutenberg.initPageTemplate(); // Initialize Page Layout.

        cscoGutenberg.initLayout(); // Initialize Breakpoints

        cscoGutenberg.initBreakpoints();
      }
    }, {
      key: "componentDidUpdate",
      value: function componentDidUpdate() {
        // Initialize.
        cscoGutenberg.init(); // Initialize Page Template.

        cscoGutenberg.initPageTemplate(); // Update Page Layout.

        cscoGutenberg.initLayout(); // Update Breakpoints

        cscoGutenberg.initBreakpoints();
      }
    }, {
      key: "render",
      value: function render() {
        return null;
      }
    }]);

    return cscoGutenbergInit;
  }(Component);

  registerPlugin('csco-editor-wrapper', {
    render: cscoGutenbergInit
  });
  registerBlockStyle('core/heading', {
    name: 'cs-heading-group',
    label: __('Heading of Group', 'caards')
  });
  registerBlockStyle('core/heading', {
    name: 'cs-heading-sidebar',
    label: __('Heading of Sidebar', 'caards')
  });
  registerBlockStyle('core/image', {
    name: 'cs-image-overflow-hidden',
    label: __('Overflow Hidden', 'caards')
  });
  registerBlockStyle('core/list', {
    name: 'cs-list-styled-positive-circle-1',
    label: __('Positive Circle 1', 'caards')
  });
  registerBlockStyle('core/list', {
    name: 'cs-list-styled-positive-circle-2',
    label: __('Positive Circle 2', 'caards')
  });
}

csEditorWrapper();