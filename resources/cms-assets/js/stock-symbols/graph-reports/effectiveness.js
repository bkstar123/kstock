$(document).ready(function () {
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