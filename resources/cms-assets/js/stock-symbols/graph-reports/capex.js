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
    var cfoToCapexChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'cfo-to-capex-container'
        },
        title: {
            text: ' Dòng tiền thuần hoạt động kinh doanh / CAPEX'
        },
        subtitle: {
            text: 'CFO/CAPEX'
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
                name: 'CFO/CAPEX',
                data: []
            },
        ]
    });
    var capexToNetProfitChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'capex-to-net-profit-container'
        },
        title: {
            text: ' CAPEX / Lợi nhuận ròng'
        },
        subtitle: {
            text: 'CFO/Net Profit'
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
                name: 'CAPEX/Lợi nhuận ròng',
                data: []
            },
        ]
    });
    cfoToCapexChart.series[0].setData(cfoToCapex);
    capexToNetProfitChart.series[0].setData(capexToNetProfitData);
});