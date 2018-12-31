webpackJsonp([7],{

/***/ 204:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(205);


/***/ }),

/***/ 205:
/***/ (function(module, exports) {


var vmLang = new Vue({
    el: '#lang-page',
    data: {
        lang: 'ja'
    },
    mounted: function mounted() {
        this.lang = this.$refs.lang.dataset.value;
    },
    methods: {
        /**
         * 言語変更イベント
         * @param event
         */
        changeLanguage: function changeLanguage(event) {
            //console.log('changeLanguage:' + this.lang);
            i18next.changeLanguage(this.lang);
        }
    }
});

/***/ })

},[204]);