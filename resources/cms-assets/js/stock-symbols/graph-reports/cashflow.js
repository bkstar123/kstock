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