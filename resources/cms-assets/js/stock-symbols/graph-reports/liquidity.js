$(document).ready(function () {
    Highcharts.theme = {
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        chart: {
            backgroundColor: {
                linearGradient: [500, 500, 500, 500],
                stops: [
                    [0, 'rgb(255, 255, 255)'],
                    [1, 'rgb(240, 240, 255)']
                ]
            },
        },
        title: {
            style: {
                color: '#000',
                font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        subtitle: {
            style: {
                color: '#666666',
                font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        legend: {
            itemStyle: {
                font: '9pt Trebuchet MS, Verdana, sans-serif',
                color: 'black'
            },
            itemHoverStyle:{
                color: 'gray'
            }   
        }
    };
    Highcharts.setOptions(Highcharts.theme);
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