webpackJsonp([5],{

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(203);


/***/ }),

/***/ 203:
/***/ (function(module, exports) {


var vmTag = new Vue({
    el: '#tag-page',
    data: {
        tagStyle: {
            'font-size': '1em',
            color: '#fff',
            'background-color': '#000'
        },
        tagText: 'Tag'
    },
    mounted: function mounted() {
        this.tagText = this.$refs.text.dataset.value;
        this.tagStyle.color = this.$refs.color.dataset.value;
        this.tagStyle["background-color"] = this.$refs.bgColor.dataset.value;
    },
    methods: {
        /**
         * タグ文字列入力イベント
         * @param event
         */
        changeTagText: function changeTagText(event) {
            this.tagText = event.target.value;
        },

        /**
         * タグ文字色変更イベント
         * @param event
         */
        changeTagColor: function changeTagColor(event) {
            this.tagStyle.color = event.target.value;
        },

        /**
         * タグ背景色変更イベント
         */
        changeTagBackgroundColor: function changeTagBackgroundColor(event) {
            this.tagStyle["background-color"] = event.target.value;
        }
    }
});

/***/ })

},[202]);