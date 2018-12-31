/**
 * メッセージボックス
 */
// TODO: 未使用
Vue.component('message-box', require('./components/MessageBox'));
const messageBox = new Vue({
    el: '#message-box',
    data: {
        showModal: true
    }
});
