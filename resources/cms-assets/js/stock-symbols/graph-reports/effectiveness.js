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
    var effectivenessChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'effectiveness-container'
        },
        title: {
            text: 'Các hệ số hiệu quả hoạt động liên quan đến các vòng quay tiền mặt'
        },
        subtitle: {
            text: 'Operation Effectiveness Ratios'
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
                text: 'Ngày'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'Thời gian thu tiền khách hàng bình quân',
                data: []
            },
            {
                name: 'Thời gian tồn kho bình quân',
                data: []
            },
            {
                name: 'Thời gian trả tiền nhà cung cấp bình quân',
                data: []
            },
            {
                name: 'Chu kỳ chuyển đổi tiền mặt',
                data: []
            },
        ]
    });
    effectivenessChart.series[0].setData(averageCollectionPeriodData);
    effectivenessChart.series[1].setData(averageAgeOfInventoryData);
    effectivenessChart.series[2].setData(averageAccountPayableDurationData);
    effectivenessChart.series[3].setData(cashConversionCycleData);
});