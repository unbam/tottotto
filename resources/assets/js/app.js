
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const i18next = require('i18next');
const Backend = require('i18next-xhr-backend');

// TODO: リソース分ける(/public/localesを使う)
// フロントエンド側言語設定
i18next
    .use(Backend)
    .init({
        fallbackLng: 'en',
        debug: false,
        resources: {
            en: {
                translation: {
                    'month_format' : 'MMMM YYYY',
                    'agenda_format' : 'MMMM D, YYYY',
                    'jan' : 'Jan',
                    'feb' : 'Feb',
                    'mar' : 'Meb',
                    'apr' : 'Apr',
                    'may' : 'May',
                    'jun' : 'Jun',
                    'jul' : 'Jul',
                    'aug' : 'Aug',
                    'sep' : 'Sep',
                    'oct' : 'Oct',
                    'nov' : 'Nov',
                    'dec' : 'Dec',
                    'allday' : 'All-Day',
                    'sunday': 'Sunday',
                    'monday': 'Monday',
                    'tuesday': 'Tuesday',
                    'wednesday': 'Wednesday',
                    'thursday': 'Thursday',
                    'friday': 'Friday',
                    'saturday': 'Saturday',
                    'sun': 'Sun',
                    'mon': 'Mon',
                    'tue': 'Tue',
                    'wed': 'Wed',
                    'thu': 'Thu',
                    'fri': 'Fri',
                    'sat': 'Sat',
                    'today': 'Today',
                    'month': 'Month',
                    'week': 'Week',
                    'day': 'Day',
                    'list': 'List',
                    'search': 'Search',
                    'confirm': 'Do you really want to delete?'
                }
            },
            ja: {
                translation: {
                    'month_format' : 'YYYY年 M月',
                    'agenda_format' : 'YYYY年 M月 D日',
                    'jan' : '1月',
                    'feb' : '2月',
                    'mar' : '3月',
                    'apr' : '4月',
                    'may' : '5月',
                    'jun' : '6月',
                    'jul' : '7月',
                    'aug' : '8月',
                    'sep' : '9月',
                    'oct' : '10月',
                    'nov' : '11月',
                    'dec' : '12月',
                    'allday' : '終日',
                    'sunday': '日曜日',
                    'monday': '月曜日',
                    'tuesday': '火曜日',
                    'wednesday': '水曜日',
                    'thursday': '木曜日',
                    'friday': '金曜日',
                    'saturday': '土曜日',
                    'sun': '日',
                    'mon': '月',
                    'tue': '火',
                    'wed': '水',
                    'thu': '木',
                    'fri': '金',
                    'sat': '土',
                    'today': '今日',
                    'month': '月',
                    'week': '週',
                    'day': '日',
                    'list': 'リスト表示',
                    'search': '検索',
                    'confirm': '本当に削除しますか？'
                }
            }
        }
    });

window.i18next = i18next;

$(function() {

    let appInit = function(callback){
        $.ajax({
            type: 'get',
            url: '/get-locale',
        }).
        done(function(data){
            //console.log(data);

            // 言語設定
            i18next.changeLanguage(data);

            // コールバック
            callback(data);
        }).
        fail(function(XMLHttpRequest, textStatus, errorThrown){
            console.log(textStatus + '\n' + errorThrown);
        });
    };

    // グローバルオブジェクトとして保持
    window.appInit = appInit;

    // Alertのフェードアウト
    window.setTimeout("$('#flash_message').fadeOut()", 4000);

    resize();
});

$(window).resize(function(){
    resize();
});

/**
 * ウィンドウリサイズ
 */
function resize() {
    let w = $(window).width();
    let x = 768;
    if(w <= x) {
        $('#side-nav').removeClass('flex-column');
    }
    else {
        $('#side-nav').addClass('flex-column');
    }
}