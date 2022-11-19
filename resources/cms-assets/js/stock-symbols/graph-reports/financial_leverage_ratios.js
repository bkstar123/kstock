$(document).ready(function () {
    var financialLeverageChart = Highcharts.chart({
        chart: {
            type: 'spline',
            renderTo: 'financial-leverage-container'
        },
        title: {
            text: 'Cấu trúc nợ, nợ vay và nguồn vốn'
        },
        subtitle: {
            text: 'Liabilities, debts and equities'
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
        ]
    });
    financialLeverageChart.series[0].setData(debtToEquitiesData);
    financialLeverageChart.series[1].setData(netDebtToEquitiesData);
    financialLeverageChart.series[2].setData(longTermDebtToEquityData);
    financialLeverageChart.series[3].setData(financialLeverageData);
    financialLeverageChart.series[4].setData(averageFinancialLeverageData);
});