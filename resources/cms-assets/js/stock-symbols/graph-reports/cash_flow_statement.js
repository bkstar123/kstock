$(document).ready(function () {
    var cashflowsChart = Highcharts.chart({
        chart: {
            type: 'column',
            renderTo: 'cash-flows-statement-container'
        },
        title: {
            text: 'Lưu chuyển tiền thuần từ HĐKD, đầu tư và tài chính'
        },
        subtitle: {
            text: 'CFO, CFI, CFF'
        },
        xAxis: {
            title: {
                text: 'Period',                   
            },
            type: 'category',
            crosshair: true,
        },
        yAxis: [
            {
                title: {
                    text: 'Tỷ VND'
                },
                crosshair: true,
            },
        ],
        series: [
            {
                name: 'Luu chuyển tiền thuần từ hoạt động kinh doanh',
                yAxis: 0,
                data: []
            },
            {
                name: 'Luu chuyển tiền thuần từ hoạt động đầu tư',
                yAxis: 0,
                data: []
            },
            {
                name: 'Luu chuyển tiền thuần từ hoạt động tài chính',
                yAxis: 0,
                data: []
            },
            {
                name: 'Lưu chuyển tiền thuần trong kỳ',
                yAxis: 0,
                data: []
            },
            {
                name: 'Tiền và tương đương tiền cuối kỳ',
                yAxis: 0,
                data: []
            },
        ]
    });

    var componentCashflowsChart = Highcharts.chart({
        chart: {
            type: 'column',
            renderTo: 'important-constituent-cash-flows-container'
        },
        title: {
            text: 'Một số của thành phần quan trọng trong dòng tiền HĐKD, dòng tiền đầu tư và dòng tiền tài chính'
        },
        subtitle: {
            text: 'Some important constituent cash flows in CFO, CFI, and CFF'
        },
        xAxis: {
            title: {
                text: 'Period',                   
            },
            type: 'category',
            crosshair: true,
        },
        yAxis: [
            {
                title: {
                    text: 'Tỷ VND'
                },
                crosshair: true,
            },
        ],
        series: [
            {
                name: 'Khấu hao tài sản cố định',
                yAxis: 0,
                data: []
            },
            {
                name: 'Thay đổi các khoản phải thu',
                yAxis: 0,
                data: []
            },
            {
                name: 'Thay đổi hàng tồn kho',
                yAxis: 0,
                data: []
            },
            {
                name: 'Thay đổi các khoản phải trả',
                yAxis: 0,
                data: []
            },
            {
                name: 'Tiền chi để mua sắm, xây dựng TSCĐ và các tài sản dài hạn khác',
                yAxis: 0,
                data: []
            },
            {
                name: 'Tiền thu từ thanh lý, nhượng bán TSCĐ và các tài sản dài hạn khác',
                yAxis: 0,
                data: []
            },
            {
                name: 'Tiền chi trả nợ gốc vay',
                yAxis: 0,
                data: []
            },
        ]
    });
    cashflowsChart.series[0].setData(cfoData);
    cashflowsChart.series[1].setData(cfiData);
    cashflowsChart.series[2].setData(cffData);
    cashflowsChart.series[3].setData(cashMovingData);
    cashflowsChart.series[4].setData(cashEndData);

    componentCashflowsChart.series[0].setData(deprecationData);
    componentCashflowsChart.series[1].setData(receivableAccountChangenData);
    componentCashflowsChart.series[2].setData(inventoryAccountChangenData);
    componentCashflowsChart.series[3].setData(payableAccountChangenData);
    componentCashflowsChart.series[4].setData(payForCapexData);
    componentCashflowsChart.series[5].setData(receiveFromCapexData);
    componentCashflowsChart.series[6].setData(payForDebtPrincipalxData);
});