webpackJsonp([6],{

/***/ 200:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(201);


/***/ }),

/***/ 201:
/***/ (function(module, exports) {


var vmConfirm = new Vue({
    el: '#confirm',
    data: {
        message: ''
    },
    methods: {
        /**
         * 削除確認ダイアログ
         * @param event
         */
        confirm: function (_confirm) {
            function confirm(_x) {
                return _confirm.apply(this, arguments);
            }

            confirm.toString = function () {
                return _confirm.toString();
            };

            return confirm;
        }(function (event) {
            if (confirm(this.message)) {
                // 削除実行
            } else {
                // キャンセル
                event.preventDefault();
            }
        })
    }
});

// イベント登録
window.addEventListener('load', function () {
    appInit(function () {
        vmConfirm.message = i18next.t('confirm');
    });
});

/***/ })

},[200]);