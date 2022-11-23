$(document).ready(function () {
    var financialLeverageChart = Highcharts.chart({
        chart: {
            type: 'spline',
            renderTo: 'financial-leverage-container'
        },
        title: {
            text: 'Các chỉ số đòn bẩy tài chính'
        },
        subtitle: {
            text: 'Financial leverage ratios'
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
                name: 'Tổng nợ vay / Vốn chủ sở hữu (Hệ số nợ vay)',
                data: []
            },
            {
                name: 'Tổng nợ vay ròng / Vốn chủ sở hữu (Hệ số nợ vay ròng)',
                data: []
            },
            {
                name: 'Tổng nợ vay dài hạn / Vốn chủ sở hữu (Hệ số nợ vay dài hạn)',
                data: []
            },
            {
                name: 'Đòn bẩy tài chính (Tổng tài sản / VCSH)',
                data: []
            },
            {
                name: 'Đòn bẩy tài chính bình quân (Tổng tài sản bình quân / VCSH bình quân)',
                data: []
            },
            {
                name: 'Nợ vay ngắn hạn / Nợ vay',
                data: []
            },
            {
                name: 'Nợ vay ngắn hạn / Nợ ngắn hạn',
                data: []
            },
            {
                name: 'Nợ vay dài hạn / Nợ dài hạn',
                data: []
            },
            {
                name: 'Nợ vay / Tổng nợ',
                data: []
            },
            {
                name: 'Tổng nợ / Tổng tài sản',
                data: []
            },
            {
                name: 'Nợ ngắn hạn / Tổng nợ',
                data: []
            },
        ]
    });
    financialLeverageChart.series[0].setData(debtToEquitiesData);
    financialLeverageChart.series[1].setData(netDebtToEquitiesData);
    financialLeverageChart.series[2].setData(longTermDebtToEquityData);
    financialLeverageChart.series[3].setData(financialLeverageData);
    financialLeverageChart.series[4].setData(averageFinancialLeverageData);
    financialLeverageChart.series[5].setData(currrentDebtsToTotalDebtsData);
    financialLeverageChart.series[6].setData(currentDebtsToCurrentLiabilitiesData);
    financialLeverageChart.series[7].setData(longTermDebtsToLongTermLiabilitiesData);
    financialLeverageChart.series[8].setData(debtsToLiabilitiesData);
    financialLeverageChart.series[9].setData(liabilitiesToAssetsData);
    financialLeverageChart.series[10].setData(currentLiabilitiesToTotalLiabilitiesData);
});