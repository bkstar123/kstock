@extends('cms.layouts.master')
@if(!empty($financial_statement->quarter))
    @section('title', "$financial_statement->symbol Báo cáo tài chính Q$financial_statement->quarter-$financial_statement->year")
@else
    @section('title', "$financial_statement->symbol Báo cáo tài chính $financial_statement->year (Năm)")
@endif

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" 
                           href="#balance-statement" 
                           data-toggle="tab">
                            Bảng cân đối kế toán
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#income-statement" 
                           data-toggle="tab">
                            Báo cáo kết quả kinh doanh
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#cash-flow-statement" 
                           data-toggle="tab">
                            Báo cáo lưu chuyển tiền tệ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#analysis-report" 
                           data-toggle="tab">
                            Phân tích các chỉ số tài chính
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#graphs" 
                           data-toggle="tab">
                            Biểu đồ
                        </a>
                    </li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="balance-statement">
                        @if(!empty($financial_statement->balance_statement))
                        <table>
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->balance_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <td>{{ $item->id }}</td>
                                @endif
                                <td>{{ $item->name }}</td>
                                <td>{{ readVietnameseDongForHuman($item->getValue($financial_statement->year, $financial_statement->quarter)) }}</td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        No balance statement found
                        @endif
                    </div>
                    <div class="tab-pane" id="income-statement">
                        @if(!empty($financial_statement->income_statement))
                        <table>
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->income_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <td>{{ $item->id }}</td>
                                @endif
                                <td>{{ $item->name }}</td>
                                <td>{{ readVietnameseDongForHuman($item->getValue($financial_statement->year, $financial_statement->quarter)) }}</td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        No Income statement found
                        @endif
                    </div>
                    <div class="tab-pane" id="cash-flow-statement">
                        @if(!empty($financial_statement->cash_flow_statement))
                        <table>
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->cash_flow_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'yes')
                                    <td>{{ $item->id }}</td>
                                @endif
                                <td>{{ $item->name }}</td>
                                <td>{{ readVietnameseDongForHuman($item->getValue($financial_statement->year, $financial_statement->quarter)) }}</td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        No Income statement found
                        @endif
                    </div>
                    <div class="tab-pane" id="analysis-report">
                        @if(!empty($financial_statement->analysis_report))
                            @foreach(array_unique($financial_statement->analysis_report->getItems()->pluck('group')->toArray()) as $group)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ $group }}</h3>
                                            </div>
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Chỉ số tài chính</th>
                                                            <th>Giá trị</th>
                                                            <th>Đơn vị</th>
                                                            <th>Mô tả</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($financial_statement->analysis_report->getItems()->where('group', $group) as $item)
                                                            <tr>
                                                                <td>{!! $item->name !!}</td>
                                                                <td>
                                                                    <div class="card-body table-responsive p-0">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    @foreach(Arr::pluck($item->values, 'period') as $period)
                                                                                        <th>{{ $period }}</th>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    @foreach(Arr::pluck($item->values, 'value') as $value)
                                                                                        <td>{{ $value }}</td>
                                                                                    @endforeach
                                                                                </tr>
                                                                            </tbody> 
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @if($item->unit == 'scalar')
                                                                        Lần
                                                                    @elseif($item->unit == 'cycles')
                                                                        Vòng
                                                                    @elseif($item->unit == 'days')
                                                                        Ngày
                                                                    @else
                                                                        {{ $item->unit }}
                                                                    @endif
                                                                </td>
                                                                <td>{!! $item->description !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        No analysis report found
                        @endif
                    </div>
                    <div class="tab-pane" id="graphs">
                        @if(!empty($financial_statement->analysis_report))
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Chỉ số sinh lời</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="roaa-container"></div>
                                    <div id="roea-container"></div>
                                    <div id="ros-container"></div>
                                    <div id="gpm-container"></div>
                                    <div id="rota-container"></div>
                                    <div id="ebit-margin-container"></div>
                                    <div id="roce-container"></div>
                                </div>
                            </div>
                        </div>
                        @else
                        No graphs to be shown
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scriptBottom')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        Highcharts.theme = {
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', 
                     '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                backgroundColor: {
                    linearGradient: [0, 0, 500, 500],
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
        roaaChart.series[0].setData(@json($financial_statement->analysis_report->getItem('ROAA')->getValues()));
        roeaChart.series[0].setData(@json($financial_statement->analysis_report->getItem('ROEA')->getValues()));
        rosChart.series[0].setData(@json($financial_statement->analysis_report->getItem('ROS2')->getValues()));
        gpmChart.series[0].setData(@json($financial_statement->analysis_report->getItem('Gross profit margin')->getValues()));
        rotaChart.series[0].setData(@json($financial_statement->analysis_report->getItem('ROTA')->getValues()));
        ebitMarginChart.series[0].setData(@json($financial_statement->analysis_report->getItem('EBIT margin')->getValues()));
        roceChart.series[0].setData(@json($financial_statement->analysis_report->getItem('ROCE')->getValues()));
    });
</script>
@endpush