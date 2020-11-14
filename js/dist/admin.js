module.exports =
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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./admin.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./admin.js":
/*!******************!*\
  !*** ./admin.js ***!
  \******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _src_admin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/admin */ "./src/admin/index.js");
/* empty/unused harmony star reexport */

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return _inheritsLoose; });
function _inheritsLoose(subClass, superClass) {
  subClass.prototype = Object.create(superClass.prototype);
  subClass.prototype.constructor = subClass;
  subClass.__proto__ = superClass;
}

/***/ }),

/***/ "./src/admin/addSettingsPage.js":
/*!**************************************!*\
  !*** ./src/admin/addSettingsPage.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var flarum_extend__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flarum/extend */ "flarum/extend");
/* harmony import */ var flarum_extend__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flarum_extend__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var flarum_components_AdminNav__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/components/AdminNav */ "flarum/components/AdminNav");
/* harmony import */ var flarum_components_AdminNav__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_components_AdminNav__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_AdminLinkButton__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/AdminLinkButton */ "flarum/components/AdminLinkButton");
/* harmony import */ var flarum_components_AdminLinkButton__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_AdminLinkButton__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_SettingsPage__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/SettingsPage */ "./src/admin/components/SettingsPage.js");




/* harmony default export */ __webpack_exports__["default"] = (function () {
  app.routes['reflar-doorman'] = {
    path: '/reflar/doorman',
    component: _components_SettingsPage__WEBPACK_IMPORTED_MODULE_3__["default"]
  };

  app.extensionSettings['reflar-doorman'] = function () {
    return m.route.get(app.route('reflar-doorman'));
  };

  Object(flarum_extend__WEBPACK_IMPORTED_MODULE_0__["extend"])(flarum_components_AdminNav__WEBPACK_IMPORTED_MODULE_1___default.a.prototype, 'items', function (items) {
    items.add('reflar-doorman', flarum_components_AdminLinkButton__WEBPACK_IMPORTED_MODULE_2___default.a.component({
      href: app.route('reflar-doorman'),
      icon: 'fa fa-door-closed',
      description: app.translator.trans('reflar-doorman.admin.nav.desc')
    }, 'Doorman'));
  });
});

/***/ }),

/***/ "./src/admin/components/DoormanSettingsListItem.js":
/*!*********************************************************!*\
  !*** ./src/admin/components/DoormanSettingsListItem.js ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DoormanSettingsListItem; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/Component */ "flarum/Component");
/* harmony import */ var flarum_Component__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_Component__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/Button */ "flarum/components/Button");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Button__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_components_Badge__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/components/Badge */ "flarum/components/Badge");
/* harmony import */ var flarum_components_Badge__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Badge__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var flarum_components_Select__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/components/Select */ "flarum/components/Select");
/* harmony import */ var flarum_components_Select__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Select__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var flarum_components_Switch__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! flarum/components/Switch */ "flarum/components/Switch");
/* harmony import */ var flarum_components_Switch__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Switch__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _InviteCodeModal__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./InviteCodeModal */ "./src/admin/components/InviteCodeModal.js");
/* harmony import */ var flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! flarum/utils/withAttr */ "flarum/utils/withAttr");
/* harmony import */ var flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_7__);









var DoormanSettingsListItem =
/*#__PURE__*/
function (_Component) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(DoormanSettingsListItem, _Component);

  function DoormanSettingsListItem() {
    return _Component.apply(this, arguments) || this;
  }

  var _proto = DoormanSettingsListItem.prototype;

  _proto.view = function view() {
    this.doorkey = this.attrs.doorkey;
    this.doorkeys = this.attrs.doorkeys;
    var remaining = this.doorkey.maxUses() - this.doorkey.uses();
    return m("div", {
      className: "DoormanSettingsListItem"
    }, m("div", {
      className: "DoormanSettingsListItem-inputs"
    }, m("input", {
      className: "FormControl Doorkey-key",
      type: "text",
      disabled: true,
      value: this.doorkey.key(),
      placeholder: app.translator.trans('reflar-doorman.admin.page.doorkey.key'),
      onchange: flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_7___default()('value', this.updateKey.bind(this, this.doorkey))
    }), flarum_components_Select__WEBPACK_IMPORTED_MODULE_4___default.a.component({
      options: this.getGroupsForInput(),
      className: 'Doorkey-select',
      onchange: this.updateGroupId.bind(this, this.doorkey),
      value: this.doorkey.groupId() || 3
    }), m("input", {
      className: "FormControl Doorkey-maxUses",
      value: this.doorkey.maxUses() || '0',
      type: "number",
      placeholder: app.translator.trans('reflar-doorman.admin.page.doorkey.max_uses'),
      onchange: flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_7___default()('value', this.updateMaxUses.bind(this, this.doorkey))
    }), flarum_components_Switch__WEBPACK_IMPORTED_MODULE_5___default.a.component({
      state: this.doorkey.activates() || false,
      onchange: this.updateActivates.bind(this, this.doorkey),
      className: 'Doorkey-switch'
    })), flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default.a.component({
      type: 'button',
      className: 'Button Button--warning Doorkey-button',
      icon: 'fa fa-envelope',
      onclick: this.showModal.bind(this)
    }), flarum_components_Button__WEBPACK_IMPORTED_MODULE_2___default.a.component({
      type: 'button',
      className: 'Button Button--warning Doorkey-button',
      icon: 'fa fa-times',
      onclick: this.deleteDoorkey.bind(this, this.doorkey)
    }), this.doorkey.maxUses() === this.doorkey.uses() ? flarum_components_Badge__WEBPACK_IMPORTED_MODULE_3___default.a.component({
      className: 'Doorkey-badge',
      icon: 'fas fa-user-slash',
      label: app.translator.trans('reflar-doorman.admin.page.doorkey.warning')
    }) : this.doorkey.uses() !== 0 ? m("div", null, m("h3", {
      className: "Doorkey-left"
    }, app.translator.transChoice('reflar-doorman.admin.page.doorkey.used_times', remaining, {
      remaining: remaining
    }).join(''))) : '');
  };

  _proto.showModal = function showModal() {
    app.modal.show(_InviteCodeModal__WEBPACK_IMPORTED_MODULE_6__["default"], {
      doorkey: this.doorkey
    });
  };

  _proto.oncreate = function oncreate(vnode) {
    $('.fa-exclamation-cricle').tooltip({
      container: 'body'
    });
  };

  _proto.getGroupsForInput = function getGroupsForInput() {
    var options = [];
    app.store.all('groups').map(function (group) {
      if (group.nameSingular() === 'Guest') {
        return;
      }

      options[group.id()] = group.nameSingular();
    });
    return options;
  };

  _proto.updateKey = function updateKey(doorkey, key) {
    doorkey.save({
      key: key
    });
  };

  _proto.updateGroupId = function updateGroupId(doorkey, groupId) {
    doorkey.save({
      groupId: groupId
    });
  };

  _proto.updateMaxUses = function updateMaxUses(doorkey, maxUses) {
    doorkey.save({
      maxUses: maxUses
    });
  };

  _proto.updateActivates = function updateActivates(doorkey, activates) {
    doorkey.save({
      activates: activates
    });
  };

  _proto.deleteDoorkey = function deleteDoorkey(doorkeyToDelete) {
    var _this = this;

    doorkeyToDelete.delete();
    this.doorkeys.some(function (doorkey, i) {
      if (doorkey.data.id === doorkeyToDelete.data.id) {
        _this.doorkeys.splice(i, 1);

        return true;
      }
    });
  };

  return DoormanSettingsListItem;
}(flarum_Component__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/admin/components/InviteCodeModal.js":
/*!*************************************************!*\
  !*** ./src/admin/components/InviteCodeModal.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return InviteCodeModal; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_components_Alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/components/Alert */ "flarum/components/Alert");
/* harmony import */ var flarum_components_Alert__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Alert__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_Modal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/Modal */ "flarum/components/Modal");
/* harmony import */ var flarum_components_Modal__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Modal__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! flarum/components/Button */ "flarum/components/Button");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Button__WEBPACK_IMPORTED_MODULE_3__);





var InviteCodeModal =
/*#__PURE__*/
function (_Modal) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(InviteCodeModal, _Modal);

  function InviteCodeModal() {
    return _Modal.apply(this, arguments) || this;
  }

  var _proto = InviteCodeModal.prototype;

  _proto.oninit = function oninit(vnode) {
    _Modal.prototype.oninit.call(this, vnode);

    this.emails = [];
    this.doorkey = this.attrs.doorkey;
    this.success = false;
  };

  _proto.className = function className() {
    return 'InviteCodeModal Modal--small';
  };

  _proto.title = function title() {
    return app.translator.trans('reflar-doorman.admin.modal.title');
  };

  _proto.oncreate = function oncreate(vnode) {
    var _this = this;

    _Modal.prototype.oncreate.call(this, vnode);

    $('#EmailInput').off().on('keydown', function (e) {
      if (e.keyCode === 13 || e.keyCode === 188 || e.keyCode === 32) {
        e.preventDefault();

        _this.addEmails();
      }
    });
  };

  _proto.content = function content() {
    var _this2 = this;

    return m("div", {
      className: "Modal-body"
    }, m("h3", null, app.translator.trans('reflar-doorman.admin.modal.group', {
      group: app.store.getById('groups', this.doorkey.groupId()).nameSingular()
    })), m("div", {
      className: "helpText"
    }, app.translator.trans('reflar-doorman.admin.modal.help')), m("div", {
      className: "Form Form--centered"
    }, m("div", {
      className: "Form-group"
    }, m("input", {
      type: "text",
      name: "text",
      id: "EmailInput",
      className: "FormControl",
      placeholder: app.translator.trans('reflar-doorman.admin.modal.placeholder'),
      disabled: this.loading
    })), m("div", {
      className: "Form-group"
    }, m("ul", null, this.emails.map(function (email, i) {
      return m("li", {
        className: "emailListItem"
      }, m("p", null, email), flarum_components_Button__WEBPACK_IMPORTED_MODULE_3___default.a.component({
        className: 'Button',
        loading: _this2.loading,
        icon: 'fas fa-times',
        onclick: _this2.removeEmail.bind(_this2, i)
      }));
    }))), m("div", {
      className: "Form-group"
    }, flarum_components_Button__WEBPACK_IMPORTED_MODULE_3___default.a.component({
      className: 'Button Button--primary Button--block',
      loading: this.loading,
      onclick: this.send.bind(this),
      disabled: this.emails.length === 0
    }, app.translator.trans('reflar-doorman.admin.modal.send')))));
  };

  _proto.addEmails = function addEmails() {
    var _this3 = this;

    this.alert = null;
    m.redraw();
    this.badEmails = [];
    var value = $('#EmailInput').val();
    value.split(/[ ,]+/).map(function (email) {
      if (!_this3.emails.includes(email)) {
        if (_this3.emails.length + 1 > _this3.doorkey.data.attributes.maxUses) {
          _this3.alert = ({
            type: 'error'
          }, app.translator.trans('reflar-doorman.admin.modal.max_use_conflict'));
          m.redraw();
        } else {
          if (_this3.validateEmail(email)) {
            _this3.emails.push(email);

            $('#EmailInput').val('');
            m.redraw();
          } else {
            _this3.badEmails.push(email);

            _this3.alert = ({
              type: 'error'
            }, app.translator.trans('reflar-doorman.admin.modal.invalid_emails', {
              emails: _this3.badEmails.join(', ')
            }));
            m.redraw();
          }
        }
      }
    });
  };

  _proto.validateEmail = function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  };

  _proto.removeEmail = function removeEmail(i) {
    this.emails.splice(i, 1);
  };

  _proto.send = function send(e) {
    e.preventDefault();
    this.alert = null;
    this.loading = true;
    app.request({
      method: 'POST',
      url: app.forum.attribute('apiUrl') + '/reflar/doorkeys/invites',
      body: {
        emails: this.emails,
        doorkeyId: this.doorkey.data.id
      }
    }).then(function () {
      app.modal.close();
      app.alerts.show({
        type: 'success'
      }, app.translator.trans('reflar-doorman.admin.modal.success'));
    });
  };

  return InviteCodeModal;
}(flarum_components_Modal__WEBPACK_IMPORTED_MODULE_2___default.a);



/***/ }),

/***/ "./src/admin/components/SettingsPage.js":
/*!**********************************************!*\
  !*** ./src/admin/components/SettingsPage.js ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return DoormanSettingsPage; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_components_Page__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/components/Page */ "flarum/components/Page");
/* harmony import */ var flarum_components_Page__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Page__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/components/LoadingIndicator */ "flarum/components/LoadingIndicator");
/* harmony import */ var flarum_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _DoormanSettingsListItem__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./DoormanSettingsListItem */ "./src/admin/components/DoormanSettingsListItem.js");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! flarum/components/Button */ "flarum/components/Button");
/* harmony import */ var flarum_components_Button__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Button__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var flarum_components_Select__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! flarum/components/Select */ "flarum/components/Select");
/* harmony import */ var flarum_components_Select__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Select__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var flarum_components_Switch__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! flarum/components/Switch */ "flarum/components/Switch");
/* harmony import */ var flarum_components_Switch__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(flarum_components_Switch__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var flarum_app__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! flarum/app */ "flarum/app");
/* harmony import */ var flarum_app__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(flarum_app__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var flarum_utils_saveSettings__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! flarum/utils/saveSettings */ "flarum/utils/saveSettings");
/* harmony import */ var flarum_utils_saveSettings__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_saveSettings__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! flarum/utils/Stream */ "flarum/utils/Stream");
/* harmony import */ var flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! flarum/utils/withAttr */ "flarum/utils/withAttr");
/* harmony import */ var flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_10__);












var DoormanSettingsPage =
/*#__PURE__*/
function (_Page) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(DoormanSettingsPage, _Page);

  function DoormanSettingsPage() {
    return _Page.apply(this, arguments) || this;
  }

  var _proto = DoormanSettingsPage.prototype;

  _proto.oninit = function oninit(vnode) {
    _Page.prototype.oninit.call(this, vnode);

    this.loading = false;
    this.switcherLoading = false;
    this.doorkeys = flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.store.all('doorkeys');
    this.isOptional = flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.data.settings['reflar.doorman.allowPublic'];
    this.doorkey = {
      key: flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9___default()(this.generateRandomKey()),
      groupId: flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9___default()(3),
      maxUses: flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9___default()(10),
      activates: flarum_utils_Stream__WEBPACK_IMPORTED_MODULE_9___default()(false)
    };
  };

  _proto.view = function view() {
    var _this = this;

    return m("div", {
      className: "container Doorkey-container"
    }, m("h1", null, "Doorman"), this.loading ? m(flarum_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_2___default.a, null) : '', m("div", {
      className: "Doorkeys-title"
    }, m("h2", null, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.title')), m("div", {
      className: "helpText"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.help.key')), m("div", {
      className: "helpText"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.help.group')), m("div", {
      className: "helpText"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.help.max')), m("div", {
      className: "helpText"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.help.activates'))), m("div", {
      className: "Doorkeys-fieldLabels"
    }, m("h3", {
      className: "key"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.heading.key')), m("h3", {
      className: "group"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.heading.group')), m("h3", {
      className: "maxUses"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.heading.max_uses')), m("h3", {
      className: "activate"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.heading.activate'))), m("div", {
      className: "Doorkeys"
    }, this.doorkeys.map(function (doorkey) {
      return _DoormanSettingsListItem__WEBPACK_IMPORTED_MODULE_3__["default"].component({
        doorkey: doorkey,
        doorkeys: _this.doorkeys
      });
    })), m("div", {
      className: "Doorkeys-new"
    }, m("div", {
      className: "Doorkeys-newInputs"
    }, m("input", {
      className: "FormControl Doorkey-key",
      type: "text",
      value: this.doorkey.key(),
      placeholder: flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.key'),
      oninput: flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_10___default()('value', this.doorkey.key)
    }), flarum_components_Select__WEBPACK_IMPORTED_MODULE_5___default.a.component({
      options: this.getGroupsForInput(),
      className: 'Doorkey-select',
      onchange: this.doorkey.groupId,
      value: this.doorkey.groupId()
    }), m("input", {
      className: "FormControl Doorkey-maxUses",
      value: this.doorkey.maxUses(),
      type: "number",
      placeholder: flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.max_uses'),
      oninput: flarum_utils_withAttr__WEBPACK_IMPORTED_MODULE_10___default()('value', this.doorkey.maxUses)
    }), flarum_components_Switch__WEBPACK_IMPORTED_MODULE_6___default.a.component({
      state: this.doorkey.activates() || false,
      onchange: this.doorkey.activates,
      className: 'Doorkey-switch'
    })), flarum_components_Button__WEBPACK_IMPORTED_MODULE_4___default.a.component({
      type: 'button',
      className: 'Button Button--warning Doorkey-button',
      icon: 'fa fa-plus',
      onclick: this.createDoorkey.bind(this)
    })), m("div", {
      className: "Doorkey-allowPublic"
    }, m("h2", null, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.allow-public.title')), this.switcherLoading ? m(flarum_components_LoadingIndicator__WEBPACK_IMPORTED_MODULE_2___default.a, null) : m(flarum_components_Switch__WEBPACK_IMPORTED_MODULE_6___default.a, {
      state: this.isOptional,
      onchange: this.toggleOptional.bind(this),
      className: "AllowPublic-switch"
    }, flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.translator.trans('reflar-doorman.admin.page.doorkey.allow-public.switch-label'))));
  };

  _proto.getGroupsForInput = function getGroupsForInput() {
    var options = [];
    flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.store.all('groups').map(function (group) {
      if (group.nameSingular() === 'Guest') {
        return;
      }

      options[group.id()] = group.nameSingular();
    });
    return options;
  };

  _proto.generateRandomKey = function generateRandomKey() {
    return Array(8 + 1).join((Math.random().toString(36) + '00000000000000000').slice(2, 18)).slice(0, 8);
  };

  _proto.createDoorkey = function createDoorkey() {
    var _this2 = this;

    flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.store.createRecord('doorkeys').save({
      key: this.doorkey.key(),
      groupId: this.doorkey.groupId(),
      maxUses: this.doorkey.maxUses(),
      activates: this.doorkey.activates()
    }).then(function (doorkey) {
      _this2.doorkey.key(_this2.generateRandomKey());

      _this2.doorkey.groupId(3);

      _this2.doorkey.maxUses(10);

      _this2.doorkey.activates('');

      _this2.doorkeys.push(doorkey);

      m.redraw();
    });
  };

  _proto.toggleOptional = function toggleOptional() {
    var _this3 = this;

    this.switcherLoading = true;
    var settings = {
      'reflar.doorman.allowPublic': JSON.stringify(!this.isOptional)
    };
    flarum_utils_saveSettings__WEBPACK_IMPORTED_MODULE_8___default()(settings).then(function () {
      _this3.isOptional = JSON.parse(flarum_app__WEBPACK_IMPORTED_MODULE_7___default.a.data.settings['reflar.doorman.allowPublic']);
    }).catch(function () {}).then(function () {
      _this3.switcherLoading = false;
      m.redraw();
    });
  };

  return DoormanSettingsPage;
}(flarum_components_Page__WEBPACK_IMPORTED_MODULE_1___default.a);



/***/ }),

/***/ "./src/admin/index.js":
/*!****************************!*\
  !*** ./src/admin/index.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var flarum_app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! flarum/app */ "flarum/app");
/* harmony import */ var flarum_app__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(flarum_app__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _addSettingsPage__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addSettingsPage */ "./src/admin/addSettingsPage.js");
/* harmony import */ var _models_Doorkey__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./models/Doorkey */ "./src/admin/models/Doorkey.js");



flarum_app__WEBPACK_IMPORTED_MODULE_0___default.a.initializers.add('reflar-doorman', function () {
  flarum_app__WEBPACK_IMPORTED_MODULE_0___default.a.store.models.doorkeys = _models_Doorkey__WEBPACK_IMPORTED_MODULE_2__["default"];
  Object(_addSettingsPage__WEBPACK_IMPORTED_MODULE_1__["default"])();
});

/***/ }),

/***/ "./src/admin/models/Doorkey.js":
/*!*************************************!*\
  !*** ./src/admin/models/Doorkey.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Doorkey; });
/* harmony import */ var _babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/esm/inheritsLoose */ "./node_modules/@babel/runtime/helpers/esm/inheritsLoose.js");
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flarum/Model */ "flarum/Model");
/* harmony import */ var flarum_Model__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flarum_Model__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var flarum_utils_mixin__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! flarum/utils/mixin */ "flarum/utils/mixin");
/* harmony import */ var flarum_utils_mixin__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(flarum_utils_mixin__WEBPACK_IMPORTED_MODULE_2__);




var Doorkey =
/*#__PURE__*/
function (_mixin) {
  Object(_babel_runtime_helpers_esm_inheritsLoose__WEBPACK_IMPORTED_MODULE_0__["default"])(Doorkey, _mixin);

  function Doorkey() {
    return _mixin.apply(this, arguments) || this;
  }

  var _proto = Doorkey.prototype;

  _proto.apiEndpoint = function apiEndpoint() {
    return "/reflar/doorkeys" + (this.exists ? "/" + this.data.id : '');
  };

  return Doorkey;
}(flarum_utils_mixin__WEBPACK_IMPORTED_MODULE_2___default()(flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a, {
  id: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('id'),
  key: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('key'),
  groupId: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('groupId'),
  maxUses: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('maxUses'),
  uses: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('uses'),
  activates: flarum_Model__WEBPACK_IMPORTED_MODULE_1___default.a.attribute('activates')
}));



/***/ }),

/***/ "flarum/Component":
/*!**************************************************!*\
  !*** external "flarum.core.compat['Component']" ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['Component'];

/***/ }),

/***/ "flarum/Model":
/*!**********************************************!*\
  !*** external "flarum.core.compat['Model']" ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['Model'];

/***/ }),

/***/ "flarum/app":
/*!********************************************!*\
  !*** external "flarum.core.compat['app']" ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['app'];

/***/ }),

/***/ "flarum/components/AdminLinkButton":
/*!*******************************************************************!*\
  !*** external "flarum.core.compat['components/AdminLinkButton']" ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/AdminLinkButton'];

/***/ }),

/***/ "flarum/components/AdminNav":
/*!************************************************************!*\
  !*** external "flarum.core.compat['components/AdminNav']" ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/AdminNav'];

/***/ }),

/***/ "flarum/components/Alert":
/*!*********************************************************!*\
  !*** external "flarum.core.compat['components/Alert']" ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Alert'];

/***/ }),

/***/ "flarum/components/Badge":
/*!*********************************************************!*\
  !*** external "flarum.core.compat['components/Badge']" ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Badge'];

/***/ }),

/***/ "flarum/components/Button":
/*!**********************************************************!*\
  !*** external "flarum.core.compat['components/Button']" ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Button'];

/***/ }),

/***/ "flarum/components/LoadingIndicator":
/*!********************************************************************!*\
  !*** external "flarum.core.compat['components/LoadingIndicator']" ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/LoadingIndicator'];

/***/ }),

/***/ "flarum/components/Modal":
/*!*********************************************************!*\
  !*** external "flarum.core.compat['components/Modal']" ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Modal'];

/***/ }),

/***/ "flarum/components/Page":
/*!********************************************************!*\
  !*** external "flarum.core.compat['components/Page']" ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Page'];

/***/ }),

/***/ "flarum/components/Select":
/*!**********************************************************!*\
  !*** external "flarum.core.compat['components/Select']" ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Select'];

/***/ }),

/***/ "flarum/components/Switch":
/*!**********************************************************!*\
  !*** external "flarum.core.compat['components/Switch']" ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['components/Switch'];

/***/ }),

/***/ "flarum/extend":
/*!***********************************************!*\
  !*** external "flarum.core.compat['extend']" ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['extend'];

/***/ }),

/***/ "flarum/utils/Stream":
/*!*****************************************************!*\
  !*** external "flarum.core.compat['utils/Stream']" ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['utils/Stream'];

/***/ }),

/***/ "flarum/utils/mixin":
/*!****************************************************!*\
  !*** external "flarum.core.compat['utils/mixin']" ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['utils/mixin'];

/***/ }),

/***/ "flarum/utils/saveSettings":
/*!***********************************************************!*\
  !*** external "flarum.core.compat['utils/saveSettings']" ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['utils/saveSettings'];

/***/ }),

/***/ "flarum/utils/withAttr":
/*!*******************************************************!*\
  !*** external "flarum.core.compat['utils/withAttr']" ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = flarum.core.compat['utils/withAttr'];

/***/ })

/******/ });
//# sourceMappingURL=admin.js.map