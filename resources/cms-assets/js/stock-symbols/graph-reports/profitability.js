$(document).ready(function () {
    var roaaChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'roaa-container'
        },
        title: {
            text: 'Tỷ suất lợi nhuận trên tổng tài sản bình quân'
        },
        subtitle: {
            text: 'ROAA'
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
                name: 'Tỷ suất lợi nhuận trên tổng tài sản bình quân (ROAA)',
                data: []
            }
        ]
    });
    var roeaChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'roea-container'
        },
        title: {
            text: 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân'
        },
        subtitle: {
            text: 'ROEA'
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
                name: 'Tỷ suất lợi nhuận trên vốn chủ sở hữu bình quân (ROEA)',
                data: []
            }
        ]
    });
    var rosChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'ros-container'
        },
        title: {
            text: 'Tỷ suất lợi nhuận ròng của cổ đông công ty mẹ'
        },
        subtitle: {
            text: 'ROS'
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
                name: 'Tỷ suất lợi nhuận ròng của cổ đông công ty mẹ (ROS)',
                data: []
            }
        ]
    });
    var gpmChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'gpm-container'
        },
        title: {
            text: 'Biên lợi nhuận gộp'
        },
        subtitle: {
            text: 'GPM'
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
                name: 'Biên lợi nhuận gộp (GPM)',
                data: []
            }
        ]
    });
    var rotaChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'rota-container'
        },
        title: {
            text: 'Tỷ suất lợi nhuận trước thuế và lãi vay trên tổng tài sản bình quân'
        },
        subtitle: {
            text: 'ROTA'
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
                name: 'Tỷ suất lợi nhuận trước thuế và lãi vay trên tổng tài sản bình quân (ROTA)',
                data: []
            }
        ]
    });
    var ebitMarginChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'ebit-margin-container'
        },
        title: {
            text: 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần'
        },
        subtitle: {
            text: 'EBIT / Doanh thu thuần'
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
               name: 'Biên lợi nhuận trước thuế và lãi vay trên doanh thu thuần',
               data: []
           }
       ]
    });
    var roceChart = Highcharts.chart({
        chart: {
            type: 'line',
            renderTo: 'roce-container'
        },
        title: {
            text: 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân'
        },
        subtitle: {
            text: 'ROCE'
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
               name: 'Tỷ suất lợi nhuận trên vốn dài hạn bình quân (ROCE)',
               data: []
           }
        ]
    });
    roaaChart.series[0].setData(roaaData);
    roeaChart.series[0].setData(roeaData);
    rosChart.series[0].setData(rosData);
    gpmChart.series[0].setData(gpmData);
    rotaChart.series[0].setData(rotaData);
    ebitMarginChart.series[0].setData(ebitMarginData);
    roceChart.series[0].setData(roceData);
});