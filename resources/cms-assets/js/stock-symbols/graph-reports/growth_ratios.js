$(document).ready(function () {
    var growthChart = Highcharts.chart({
        chart: {
            type: 'column',
            renderTo: 'growthQoQ-container'
        },
        title: {
            text: 'Các chỉ số tăng trưởng so với quý liền kề (QoQ)'
        },
        subtitle: {
            text: 'Growth ratios (QoQ)'
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
                name: 'Tăng trưởng doanh thu thuần QoQ',
                data: []
            },
            {
                name: 'Tăng trưởng hàng tồn kho QoQ',
                data: []
            },
            {
                name: 'Tăng trưởng giá vốn bán hàng QoQ',
                data: []
            },
            {
                name: 'Tăng trưởng lợi nhuận gộp QoQ',
                data: []
            },
            {
                name: 'Tăng trưởng chi phí hoạt động QoQ',
                data: []
            },
        ]
    });
    growthChart.series[0].setData(revenueGrowthQoQData);
    growthChart.series[1].setData(inventoryGrowthQoQData);
    growthChart.series[2].setData(cogsGrowthQoQData);
    growthChart.series[3].setData(grossProfitGrowthQoQData);
    growthChart.series[4].setData(operatingExpenseGrowthQoQData);
});