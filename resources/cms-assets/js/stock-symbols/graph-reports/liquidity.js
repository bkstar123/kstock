$(document).ready(function () {
    var liquidityChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'liquidity-container'
        },
        title: {
            text: 'Các hệ số thanh toán'
        },
        subtitle: {
            text: 'Liquidity/Solvency Ratios'
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
                text: 'Lần'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'Hệ số thanh toán tổng quát',
                data: []
            },
            {
                name: 'Hệ số thanh toán hiện hành',
                data: []
            },
            {
                name: 'Hệ số thanh toán nhanh (giảm trừ hàng tồn kho)',
                data: []
            },
            {
                name: 'Hệ số thanh toán nhanh (giảm trừ hàng tồn kho và các khoản phải thu)',
                data: []
            },
            {
                name: 'Hệ số thanh toán tiền mặt',
                data: []
            },
        ]
    });

    var interestCoverageRatioChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'interest-coverage-ratio-container'
        },
        title: {
            text: 'Hệ số chi trả lãi vay'
        },
        subtitle: {
            text: 'Interest Coverage Ratio'
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
                text: 'Lần'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'Hệ số chi trả lãi vay',
                data: []
            },
        ]
    });

    liquidityChart.series[0].setData(overallSolvencyRatioData);
    liquidityChart.series[1].setData(currentRatioData);
    liquidityChart.series[2].setData(quickRatioData);
    liquidityChart.series[3].setData(quickRatio2Data);
    liquidityChart.series[4].setData(cashRatioData);
    interestCoverageRatioChart.series[0].setData(interestCoverageRatioData);
});