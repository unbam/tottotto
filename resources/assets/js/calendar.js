
const moment = require('moment');
require('fullcalendar');

// カレンダー
let calender = function() {
    $('#calendar').fullCalendar({
        themeSystem: 'bootstrap4',
        defaultView: 'month',
        height: window.innerHeight - 100,
        header: {
            left: 'title',
            center: '',
            right: 'prevYear,prev,today,next,nextYear posts search'
        },
        views: {
            month: {
                titleFormat: i18next.t('month_format'),
                eventLimit: false
            },
            agenda: {
                titleFormat: i18next.t('agenda_format'),
                allDayText: i18next.t('allday'),
                slotLabelFormat: 'HH:mm'
            },
            week:{
                columnFormat: 'M/D（ddd）'
            }
        },
        dayNames: [
            i18next.t('sunday'),
            i18next.t('monday'),
            i18next.t('tuesday'),
            i18next.t('wednesday'),
            i18next.t('thursday'),
            i18next.t('friday'),
            i18next.t('saturday')
        ],
        dayNamesShort: [
            i18next.t('sun'),
            i18next.t('mon'),
            i18next.t('tue'),
            i18next.t('wed'),
            i18next.t('thu'),
            i18next.t('fri'),
            i18next.t('sat')
        ],
        buttonText: {
            today: i18next.t('today'),
            month: i18next.t('month'),
            week: i18next.t('week'),
            day: i18next.t('day')
        },
        fixedWeekCount: false,
        timezone: 'local',
        navLinks: true,
        timeFormat: 'HH:mm',
        theme: false,
        editable: true,
        eventLimit: true,
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '/post/get-month-posts-json',
                dataType: 'json',
                data: {
                    start: start.format('YYYY-MM-DD'),
                    end: moment(end).subtract(1, 'd').format('YYYY-MM-DD'), // 1日減算
                    keyword: $('#keyword').val(),
                    tagIds: $('#tag').val(),
                    statusId: $('#status').val(),
                    categoryId: $('#category').val(),
                    userId: $('#author').val()
                },
                success: function(doc) {
                    var events = [];
                    $(doc).each(function() {
                        events.push({
                            post_id: $(this).attr('post_id'),
                            title: $(this).attr('title'),
                            start: $(this).attr('start'),
                            color: $(this).attr('color')
                        });
                    });
                    callback(events);
                }
            });
        },
        eventRender: function(event, element) {
            element.hide().fadeIn(500);
        },
        eventClick: function(calEvent, jsEvent, view) {
            jsEvent.stopPropagation();

            // 投稿表示画面に遷移
            window.location.href = '/post/view/' + calEvent.post_id;
        },
        dayClick: function(date, jsEvent, view) {
            jsEvent.stopPropagation();

            // 投稿追加画面に遷移
            window.location.href = '/post/add?date=' + date.format('YYYY-MM-DD');
        },
        customButtons: {
            // fc-posts-button
            posts: {
                click: function() {
                    // 投稿一覧画面に遷移
                    window.location.href = '/post/list';
                }
            },
            // fc-search-button
            search: {
                click: function() {
                    $('#collapse-search').toggle(500, function() {
                        // アイコン表示の変更
                        if($(this).is(':visible')) {
                            $('#toggle-search').removeClass('fa-chevron-down');
                            $('#toggle-search').addClass('fa-chevron-up');
                        }
                        else {
                            $('#toggle-search').removeClass('fa-chevron-up');
                            $('#toggle-search').addClass('fa-chevron-down');
                        }

                        $('#toggle').val($(this).is(':visible') ? 1 : 0);
                    });
                }
            }
        },
        windowResize: function () {
            $('#calendar').fullCalendar('option', 'height', window.innerHeight - 100);
        }
    });
};

// イベント登録
window.addEventListener('load', function() {

    // app.jsのコールバック関数
    appInit(function() {

        // 検索フォームの表示
        if($('#toggle').val() == 1) {
            $('#collapse-search').show(500);
        }

        // カレンダーオブジェクト生成
        calender();

        // カレンダーオブジェクト生成後に要素をカスタマイズ

        // カレンダーのボタンのクラス追加
        $('.btn').addClass('btn-sm btn-outline-primary');

        // カスタムボタン内にアイコンと文字追加
        $('.fc-posts-button').html('<i class="fas fa-list-ul"></i>' + i18next.t('list'));
        $('.fc-search-button').html('<i class="fas fa-chevron-down" id="toggle-search"></i>' + i18next.t('search'));

        // 検索フォームをカレンダー内に埋め込む
        $('<div class="fc-search"></div>').insertAfter('.fc-header-toolbar');
        $('#collapse-search').appendTo('.fc-search');
    });
});


