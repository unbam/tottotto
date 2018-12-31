
const vmConfirm = new Vue({
    el: '#confirm',
    data: {
      message: ''
    },
    methods: {
        /**
         * 削除確認ダイアログ
         * @param event
         */
        confirm: function(event) {
            if(confirm(this.message)) {
                // 削除実行
            }
            else{
                // キャンセル
                event.preventDefault();
            }
        }
    }
});

// イベント登録
window.addEventListener('load', function() {
    appInit(function() {
        vmConfirm.message = i18next.t('confirm');
    });
});