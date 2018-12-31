
const Chart = require('chart.js');

let monthlyChart = function() {

    // 月間記事数
    let monthTotalCount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    // 月間記事数の取得
    let getMonthTotal = function(){
        $.ajax({
            dataType: 'json',
            url: '/settings/dashboard/get-month-total-json'
        }).done(function(data) {
            $(data).each(function() {
                let index = Number(($(this).attr('month')).substring(4, 6) - 1);
                monthTotalCount[index] = $(this).attr('count');
            });

            chart.data.datasets[0].data = monthTotalCount;
            chart.update();
        }).fail(function() {
            console.log('[ERROR] getMonthTotal');
        });
    };

    // 月間記事数の折れ線グラフの生成
    let line = document.getElementById('monthly-chart').getContext('2d');
    line.canvas.height = 80;
    let chart = new Chart(line, {
        type: 'line',
        data: {
            labels: [
                i18next.t('jan'),
                i18next.t('feb'),
                i18next.t('mar'),
                i18next.t('apr'),
                i18next.t('may'),
                i18next.t('jun'),
                i18next.t('jul'),
                i18next.t('aug'),
                i18next.t('sep'),
                i18next.t('oct'),
                i18next.t('nov'),
                i18next.t('dec')
            ],
            datasets: [
                {
                    backgroundColor: '#B84D45',
                    borderColor: '#B84D45',
                    data: monthTotalCount,   // ajax
                    fill: false,
                    lineTension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                fontSize: 15,
                text: '月間記事数'
            },
            animation: {
                duration: 2500
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        stepSize: 5
                    }
                }]
            },
            lineTension: 1
        }
    });

    getMonthTotal();
};

let categoryChart = function() {

    // カテゴリごとの年間記事数の取得
    let getCategoryTotal = function(){
        $.ajax({
            dataType: 'json',
            url: '/settings/dashboard/get-category-total-json'
        }).done(function(data) {
            let label = [];
            let count = [];
            $(data).each(function() {
                label.push($(this).attr('name'));
                count.push($(this).attr('count'));
            });

            chart.data.labels = label;
            chart.data.datasets[0].data = count;
            chart.update();
        }).fail(function() {
            console.log('[ERROR] getCategoryTotal');
        });
    };

    let chart = new Chart($('#category-chart'), {
        type: 'horizontalBar',
        data: {
            labels: [],   // ajax
            datasets: [{
                data: [],   // ajax
                backgroundColor: 'rgba(184, 77, 69, 0.5)',
                borderColor: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false,
                fontSize: 15,
                text: 'カテゴリごとの記事数'
            },
            animation: {
                duration: 1000
            },
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        stepSize: 5
                    }
                }]
            }
        }
    });

    getCategoryTotal();
};

let tagChart = function() {

    // タグごとの年間記事数の取得
    let getTagTotal = function(){
        $.ajax({
            dataType: 'json',
            url: '/settings/dashboard/get-tag-total-json'
        }).done(function(data) {
            let label = [];
            let count = [];
            let background_color = [];
            $(data).each(function() {
                label.push($(this).attr('name'));
                background_color.push($(this).attr('background_color'));
                count.push($(this).attr('count'));
            });

            chart.data.labels = label;
            chart.data.datasets[0].data = count;
            chart.data.datasets[0].backgroundColor = background_color;
            chart.update();
        }).fail(function() {
            console.log('[ERROR] getTagTotal');
        });
    };

    let chart = new Chart($('#tag-chart'), {
        type: 'pie',
        data: {
            labels: [],   // ajax
            datasets: [{
                data: [],   // ajax
                backgroundColor: [],   // ajax
                borderColor: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
                display: false,
                fontSize: 15,
                text: 'タグごとの記事数'
            },
            animation: {
                duration: 2500
            },
            legend: {
                position: "bottom"
            }
        }
    });

    getTagTotal();
};

// イベント登録
window.addEventListener('load', function() {

    // app.jsのコールバック関数
    appInit(function() {
        monthlyChart();
        categoryChart();
        tagChart();
    });
});
