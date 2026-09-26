"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

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

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * Register Panel
 */
function csRegisterPanels() {
  var __ = wp.i18n.__;
  var compose = wp.compose.compose;
  var Component = wp.element.Component;
  var _wp$components = wp.components,
      SelectControl = _wp$components.SelectControl,
      CheckboxControl = _wp$components.CheckboxControl,
      ToggleControl = _wp$components.ToggleControl,
      TextControl = _wp$components.TextControl,
      RangeControl = _wp$components.RangeControl;
  var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
  var _wp$data = wp.data,
      withSelect = _wp$data.withSelect,
      withDispatch = _wp$data.withDispatch;
  var registerPlugin = wp.plugins.registerPlugin; // Fetch the post meta.

  var applyWithSelect = withSelect(function (select) {
    var _select = select('core/editor'),
        getEditedPostAttribute = _select.getEditedPostAttribute;

    return {
      meta: getEditedPostAttribute('meta')
    };
  }); // Provide method to update post meta.

  var applyWithDispatch = withDispatch(function (dispatch, _ref) {
    var meta = _ref.meta;

    var _dispatch = dispatch('core/editor'),
        editPost = _dispatch.editPost;

    return {
      updateMeta: function updateMeta(newMeta) {
        editPost({
          meta: _objectSpread(_objectSpread({}, meta), newMeta)
        });
      }
    };
  });
  /**
   * ==================================
   * Layout Options
   * ==================================
   */

  if (csPanelsData.enabledLayoutOptions) {
    var csThemeLayoutOptions = /*#__PURE__*/function (_Component) {
      _inherits(csThemeLayoutOptions, _Component);

      var _super = _createSuper(csThemeLayoutOptions);

      function csThemeLayoutOptions() {
        _classCallCheck(this, csThemeLayoutOptions);

        return _super.apply(this, arguments);
      }

      _createClass(csThemeLayoutOptions, [{
        key: "render",
        value: function render() {
          var _this$props = this.props,
              _this$props$meta = _this$props.meta;
          _this$props$meta = _this$props$meta === void 0 ? {} : _this$props$meta;
          var csco_singular_sidebar = _this$props$meta.csco_singular_sidebar,
              csco_page_header_type = _this$props$meta.csco_page_header_type,
              csco_appearance_masonry = _this$props$meta.csco_appearance_masonry,
              csco_page_load_nextpost = _this$props$meta.csco_page_load_nextpost,
              updateMeta = _this$props.updateMeta;
          return /*#__PURE__*/React.createElement(PluginDocumentSettingPanel, {
            title: __("Layout Options", "caards")
          }, csPanelsData.singularSidebar ? /*#__PURE__*/React.createElement(SelectControl, {
            label: __('Sidebar', 'caards'),
            value: csco_singular_sidebar,
            onChange: function onChange(value) {
              updateMeta({
                csco_singular_sidebar: value || 'default'
              });
            },
            options: csPanelsData.singularSidebar
          }) : null, csPanelsData.pageHeaderType ? /*#__PURE__*/React.createElement(SelectControl, {
            label: __('Page Header Type', 'caards'),
            value: csco_page_header_type,
            onChange: function onChange(value) {
              updateMeta({
                csco_page_header_type: value || 'default'
              });
            },
            options: csPanelsData.pageHeaderType
          }) : null, csPanelsData.pageLoadNextpost ? /*#__PURE__*/React.createElement(SelectControl, {
            label: __('Auto Load Next Post', 'caards'),
            value: csco_page_load_nextpost,
            onChange: function onChange(value) {
              updateMeta({
                csco_page_load_nextpost: value || 'default'
              });
            },
            options: csPanelsData.pageLoadNextpost
          }) : null);
        }
      }]);

      return csThemeLayoutOptions;
    }(Component); // Combine the higher-order components.


    var render = compose([applyWithSelect, applyWithDispatch])(csThemeLayoutOptions); // Register panel.

    registerPlugin('cs-theme-layout-options', {
      icon: false,
      render: render
    });
  }
  /**
   * ==================================
   * Video Background
   * ==================================
   */


  if (csPanelsData.enabledVideoOptions) {
    var csThemeVideoOptions = /*#__PURE__*/function (_Component2) {
      _inherits(csThemeVideoOptions, _Component2);

      var _super2 = _createSuper(csThemeVideoOptions);

      function csThemeVideoOptions() {
        _classCallCheck(this, csThemeVideoOptions);

        return _super2.apply(this, arguments);
      }

      _createClass(csThemeVideoOptions, [{
        key: "render",
        value: function render() {
          var _this$props2 = this.props,
              _this$props2$meta = _this$props2.meta;
          _this$props2$meta = _this$props2$meta === void 0 ? {} : _this$props2$meta;
          var csco_post_video_location = _this$props2$meta.csco_post_video_location,
              csco_post_video_location_hash = _this$props2$meta.csco_post_video_location_hash,
              csco_post_video_url = _this$props2$meta.csco_post_video_url,
              csco_post_video_bg_start_time = _this$props2$meta.csco_post_video_bg_start_time,
              csco_post_video_bg_end_time = _this$props2$meta.csco_post_video_bg_end_time,
              updateMeta = _this$props2.updateMeta;
          return /*#__PURE__*/React.createElement(PluginDocumentSettingPanel, {
            title: __("Video Background", "caards")
          }, /*#__PURE__*/React.createElement("p", null, __('Location', 'caards')), /*#__PURE__*/React.createElement("ul", null, csPanelsData.videoLocationList.map(function (item) {
            var isChecked = (csco_post_video_location || []).indexOf(item.value) !== -1 ? true : false;
            return /*#__PURE__*/React.createElement("li", null, /*#__PURE__*/React.createElement(CheckboxControl, {
              label: item.label,
              checked: isChecked,
              onChange: function onChange(value) {
                var list = csco_post_video_location || [];

                if (value && list.indexOf(item.value) === -1) {
                  list.push(item.value);
                }

                if (!value && list.indexOf(item.value) !== -1) {
                  list.splice(list.indexOf(item.value), 1);
                }

                updateMeta({
                  csco_post_video_location: list || []
                });
                updateMeta({
                  csco_post_video_location_hash: String(Math.random().toString(36).substring(2) + Date.now().toString(36))
                });
              },
              value: item.value
            }));
          })), /*#__PURE__*/React.createElement(TextControl, {
            label: __('YouTube URL', 'caards'),
            value: csco_post_video_url,
            onChange: function onChange(value) {
              updateMeta({
                csco_post_video_url: value || ''
              });
            }
          }), /*#__PURE__*/React.createElement(RangeControl, {
            label: __('Start Time (sec)', 'caards'),
            value: csco_post_video_bg_start_time,
            onChange: function onChange(value) {
              updateMeta({
                csco_post_video_bg_start_time: value || 0
              });
            },
            step: 1,
            min: 0,
            max: 10000
          }), /*#__PURE__*/React.createElement(RangeControl, {
            label: __('End Time (sec)', 'caards'),
            value: csco_post_video_bg_end_time,
            onChange: function onChange(value) {
              updateMeta({
                csco_post_video_bg_end_time: value || 0
              });
            },
            step: 1,
            min: 0,
            max: 10000
          }));
        }
      }]);

      return csThemeVideoOptions;
    }(Component); // Combine the higher-order components.


    var _render = compose([applyWithSelect, applyWithDispatch])(csThemeVideoOptions); // Register panel.


    registerPlugin('cs-theme-video-options', {
      icon: false,
      render: _render
    });
  }
}

csRegisterPanels();