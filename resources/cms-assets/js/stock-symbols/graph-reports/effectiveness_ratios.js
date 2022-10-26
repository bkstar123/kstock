$(document).ready(function () {
    var effectivenessChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'effectiveness-ratio-container'
        },
        title: {
            text: 'Các chỉ số hiệu quả hoạt động liên quan đến chu kỳ vận động vốn lưu động'
        },
        subtitle: {
            text: 'Operation effectiveness ratios related to non-cash working capital'
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
    var otherEffectivenessChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'other-effectiveness-ratio-container'
        },
        title: {
            text: 'Các chỉ số hiệu quả hoạt động liên quan đến sử dụng tài sản, tài sản cố định và vốn chủ sở hữu'
        },
        subtitle: {
            text: 'Operation effectiveness ratios related to assets and equities'
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
                text: 'Vòng'
            },
            crosshair: true,
        },
        series: [
            {
                name: 'Vòng quay tổng tài sản',
                data: []
            },
            {
                name: 'Vòng quay tài sản cố định',
                data: []
            },
            {
                name: 'Vòng quay VCSH',
                data: []
            }
        ]
    });
    effectivenessChart.series[0].setData(averageCollectionPeriodData);
    effectivenessChart.series[1].setData(averageAgeOfInventoryData);
    effectivenessChart.series[2].setData(averageAccountPayableDurationData);
    effectivenessChart.series[3].setData(cashConversionCycleData);

    otherEffectivenessChart.series[0].setData(totalAssetTurnoverData);
    otherEffectivenessChart.series[1].setData(fixedAssetTurnoverData);
    otherEffectivenessChart.series[2].setData(equityTurnoverData);
});