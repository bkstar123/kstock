$(document).ready(function () {
    var cashflowChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'cashflow-container'
        },
        title: {
            text: ' Hệ số dòng tiền thuần hoạt động kinh doanh, dòng tiền tự do trên doanh thu thuần'
        },
        subtitle: {
            text: 'CFO/Revenue - FCF/Revenue'
        },
        xAxis: {
            title: {
                text: 'Period',                   
            },
            type: 'category',
            crosshair: true,
        },
        yAxis: {
            title: {
                text: '%'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'CFO/Doanh thu thuần',
                data: []
            },
            {
                name: 'FCF/Doanh thu thuần',
                data: []
            }
        ]
    });
    cashflowChart.series[0].setData(cfoToRevenueData);
    cashflowChart.series[1].setData(fcfToRevenueData);
});