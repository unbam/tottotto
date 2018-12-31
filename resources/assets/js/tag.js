
const vmTag = new Vue({
    el: '#tag-page',
    data: {
        tagStyle: {
            'font-size': '1em',
            color: '#fff',
            'background-color': '#000'
        },
        tagText: 'Tag'
    },
    mounted: function() {
        this.tagText = this.$refs.text.dataset.value;
        this.tagStyle.color = this.$refs.color.dataset.value;
        this.tagStyle["background-color"] = this.$refs.bgColor.dataset.value;
    },
    methods: {
        /**
         * タグ文字列入力イベント
         * @param event
         */
        changeTagText: function(event) {
            this.tagText = event.target.value;
        },

        /**
         * タグ文字色変更イベント
         * @param event
         */
        changeTagColor: function(event) {
            this.tagStyle.color = event.target.value;
        },

        /**
         * タグ背景色変更イベント
         */
        changeTagBackgroundColor: function(event) {
            this.tagStyle["background-color"] = event.target.value;
        }
    }
});
