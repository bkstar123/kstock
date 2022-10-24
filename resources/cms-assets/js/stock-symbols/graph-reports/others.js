$(document).ready(function () {
    var revenueChart = Highcharts.chart({
        chart: {
            type: 'column',
            renderTo: 'revenue-net-profit-container'
        },
        title: {
            text: ' Doanh thu thuần - LNST của cổ đông công ty mẹ'
        },
        subtitle: {
            text: 'Revenue - Earnings after tax of parent company'
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
                text: 'Tỷ VND'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'Doanh thu thuần',
                data: []
            },
            {
                name: 'LNST của cổ đông công ty mẹ',
                data: []
            },
        ]
    });
    revenueChart.series[0].setData(revenueData);
    revenueChart.series[1].setData(earningsAfterTaxParentCompanyData);
});