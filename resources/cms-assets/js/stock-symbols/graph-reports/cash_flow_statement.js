$(document).ready(function () {
    var cashflowsChart = Highcharts.chart({
        chart: {
            type: 'column',
            renderTo: 'cash-flows-statement-container'
        },
        title: {
            text: 'Lưu chuyển tiền thuần từ HĐKD, đầu tư và tài chính'
        },
        subtitle: {
            text: 'CFO, CFI, CFF'
        },
        xAxis: {
            title: {
                text: 'Period',                   
            },
            type: 'category',
            crosshair: true,
        },
        yAxis: [
            {
                title: {
                    text: 'Tỷ VND'
                },
                crosshair: true,
            },
        ],
        series: [
            {
                name: 'Luu chuyển tiền thuần từ hoạt động kinh doanh',
                yAxis: 0,
                data: []
            },
            {
                name: 'Luu chuyển tiền thuần từ hoạt động đầu tư',
                yAxis: 0,
                data: []
            },
            {
                name: 'Luu chuyển tiền thuần từ hoạt động tài chính',
                yAxis: 0,
                data: []
            },
            {
                name: 'Lưu chuyển tiền thuần trong kỳ',
                yAxis: 0,
                data: []
            },
            {
                name: 'Tiền và tương đương tiền cuối kỳ',
                yAxis: 0,
                data: []
            },
        ]
    });
    cashflowsChart.series[0].setData(cfoData);
    cashflowsChart.series[1].setData(cfiData);
    cashflowsChart.series[2].setData(cffData);
    cashflowsChart.series[3].setData(cashMovingData);
    cashflowsChart.series[4].setData(cashEndData);
});