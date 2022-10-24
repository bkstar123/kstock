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
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số sinh lời</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="roaa-container"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="roea-container"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="ros-container"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="gpm-container"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="rota-container"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="ebit-margin-container"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="roce-container"></div>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số thanh toán</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="liquidity-container"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="interest-coverage-ratio-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số dòng tiền</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="cashflow-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số CAPEX</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="cfo-to-capex-container"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="capex-to-net-profit-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số hiệu quả hoạt động</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="effectiveness-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Các biểu đồ tài chính khác</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="revenue-net-profit-container"></div>
                                            </div>
                                        </div>
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
<script src="{{ url('/js/vendor/highcharts/highcharts.js') }}"></script>
<script src="{{ url('/js/vendor/highcharts/themes/default.js') }}"></script>
<script type="text/javascript">
    // Chi so sinh loi
    var roaaData = @json($financial_statement->analysis_report->getItem('ROAA')->getValues());
    var roeaData = @json($financial_statement->analysis_report->getItem('ROEA')->getValues());
    var rosData = @json($financial_statement->analysis_report->getItem('ROS2')->getValues());
    var gpmData = @json($financial_statement->analysis_report->getItem('Gross profit margin')->getValues());
    var rotaData = @json($financial_statement->analysis_report->getItem('ROTA')->getValues());
    var ebitMarginData = @json($financial_statement->analysis_report->getItem('EBIT margin')->getValues());
    var roceData = @json($financial_statement->analysis_report->getItem('ROCE')->getValues());

    // Chi so thanh toan
    var overallSolvencyRatioData = @json($financial_statement->analysis_report->getItem('Overall Solvency Ratio')->getValues());
    var currentRatioData = @json($financial_statement->analysis_report->getItem('Current Ratio')->getValues());
    var quickRatioData = @json($financial_statement->analysis_report->getItem('Quick Ratio 1')->getValues());
    var quickRatio2Data = @json($financial_statement->analysis_report->getItem('Quick Ratio 2')->getValues());
    var cashRatioData = @json($financial_statement->analysis_report->getItem('Cash Ratio')->getValues());
    var interestCoverageRatioData = @json($financial_statement->analysis_report->getItem('Interest Coverage Ratio')->getValues());

    // Chi so dong tien
    var cfoToRevenueData = @json($financial_statement->analysis_report->getItem('CFO/Revenue')->getValues());
    var fcfToRevenueData = @json($financial_statement->analysis_report->getItem('FCF/Revenue')->getValues());

    // Chi so CAPEX
    var cfoToCapex = @json($financial_statement->analysis_report->getItem('CFO/CAPEX')->getValues());
    var capexToNetProfitData = @json($financial_statement->analysis_report->getItem('CAPEX/NetProfit')->getValues());

    // Chi so hieu qua hoat dong
    var averageCollectionPeriodData = @json($financial_statement->analysis_report->getItem('Average Collection Period')->getValues());
    var averageAgeOfInventoryData = @json($financial_statement->analysis_report->getItem('Average Age of Inventory')->getValues());
    var averageAccountPayableDurationData = @json($financial_statement->analysis_report->getItem('Average Account Payable Duration')->getValues());
    var cashConversionCycleData = @json($financial_statement->analysis_report->getItem('Cash Conversion Cycle')->getValues());

    // Cac thong tin tai chinh khac
    var revenueData = @json(array_map(function($value) {
        $value[1] = readVietnameseDongForHuman($value[1]);
        return $value;
    }, $financial_statement->income_statement->getItem('3')->getValues()));
    var earningsAfterTaxParentCompanyData = @json(array_map(function($value) {
        $value[1] = readVietnameseDongForHuman($value[1]);
        return $value;
    }, $financial_statement->income_statement->getItem('21')->getValues()));
</script>
<script src="/js/stock-symbols/graph_report.min.js"></script>
@endpush