
const vmLang = new Vue({
    el: '#lang-page',
    data: {
        lang: 'ja'
    },
    mounted: function() {
        this.lang = this.$refs.lang.dataset.value;
    },
    methods: {
        /**
         * 言語変更イベント
         * @param event
         */
        changeLanguage: function(event) {
            //console.log('changeLanguage:' + this.lang);
            i18next.changeLanguage(this.lang);
        }
    }
});
