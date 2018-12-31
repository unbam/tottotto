
require('bootstrap-select');

// イベント登録
window.addEventListener('load', function() {

    // app.jsのコールバック関数
    appInit(function() {
        $('.selectpicker').selectpicker();
    });
});
