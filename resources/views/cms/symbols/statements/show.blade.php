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
                                @if(config('settings.display_statement_item_code') == 'on')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->balance_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'on')
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
                                @if(config('settings.display_statement_item_code') == 'on')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->income_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'on')
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
                                @if(config('settings.display_statement_item_code') == 'on')
                                    <th>Code</th>
                                @endif
                                <th>Name</th>
                                <th>Value (Tỷ VND)</th>
                            </tr>
                            @foreach($financial_statement->cash_flow_statement->getItems() as $item)
                            <tr>
                                @if(config('settings.display_statement_item_code') == 'on')
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
                                                <div id="roaa-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="roea-container" style="width:100%;"></div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="ros-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="gpm-container" style="width:100%;"></div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="rota-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="ebit-margin-container" style="width:100%;"></div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="roce-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="ebitda-margin-container" style="width:100%;"></div>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div><hr>
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
                                                <div id="liquidity-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="interest-coverage-ratio-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
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
                                                <div id="cash-flow-ratio-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
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
                                                <div id="cfo-to-capex-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="capex-to-net-profit-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số hiệu quả hoạt động</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="effectiveness-ratio-container" style="width:100%;"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="other-effectiveness-ratio-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Chỉ số đòn bẩy tài chính</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="financial-leverage-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Báo cáo kết quả kinh doanh</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="income-statement-container" style="width:100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Báo cáo lưu chuyển tiền tệ</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="cash-flows-statement-container" style="width:100%;"></div>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="important-constituent-cash-flows-container" style="width:100%;"></div>
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
<script src="{{ url('/js/vendor/highcharts/themes/' . config('settings.graph_theme') . '.js') }}"></script>
<script type="text/javascript">
// Cac chi so tai chinh
@if(!empty($financial_statement->analysis_report))
    // Chi so sinh loi
    var roaaData = @json($financial_statement->analysis_report->getItem('ROAA')->getValues());
    var roaData = @json($financial_statement->analysis_report->getItem('ROA')->getValues());
    var roeaData = @json($financial_statement->analysis_report->getItem('ROEA')->getValues());
    var roeData = @json($financial_statement->analysis_report->getItem('ROE')->getValues());
    var rosData = @json($financial_statement->analysis_report->getItem('ROS')->getValues());
    var ros2Data = @json($financial_statement->analysis_report->getItem('ROS2')->getValues());
    var gpmData = @json($financial_statement->analysis_report->getItem('Gross profit margin')->getValues());
    var rotaData = @json($financial_statement->analysis_report->getItem('ROTA')->getValues());
    var ebitMarginData = @json($financial_statement->analysis_report->getItem('EBIT margin')->getValues());
    var roceData = @json($financial_statement->analysis_report->getItem('ROCE')->getValues());
    var ebitda1Data = @json($financial_statement->analysis_report->getItem('EBITDA margin 1')->getValues());
    var ebitda2Data = @json($financial_statement->analysis_report->getItem('EBITDA margin 2')->getValues());

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
    var fcfToCfoData = @json($financial_statement->analysis_report->getItem('FCF/CFO')->getValues());

    // Chi so CAPEX
    var cfoToCapex = @json($financial_statement->analysis_report->getItem('CFO/CAPEX')->getValues());
    var capexToNetProfitData = @json($financial_statement->analysis_report->getItem('CAPEX/NetProfit')->getValues());

    // Chi so hieu qua hoat dong
    var averageCollectionPeriodData = @json($financial_statement->analysis_report->getItem('Average Collection Period')->getValues());
    var averageAgeOfInventoryData = @json($financial_statement->analysis_report->getItem('Average Age of Inventory')->getValues());
    var averageAccountPayableDurationData = @json($financial_statement->analysis_report->getItem('Average Account Payable Duration')->getValues());
    var cashConversionCycleData = @json($financial_statement->analysis_report->getItem('Cash Conversion Cycle')->getValues());
    var totalAssetTurnoverData = @json($financial_statement->analysis_report->getItem('Total Asset Turnover Ratio')->getValues());
    var fixedAssetTurnoverData = @json($financial_statement->analysis_report->getItem('Fixed Asset Turnover Ratio')->getValues());
    var equityTurnoverData = @json($financial_statement->analysis_report->getItem('Equity Turnover Ratio')->getValues());

    // Chi so don bay tai chinh
    var debtToEquitiesData = @json($financial_statement->analysis_report->getItem('Debts/Equities')->getValues());
    var netDebtToEquitiesData = @json($financial_statement->analysis_report->getItem('Net Debts/Equities')->getValues());
    var longTermDebtToEquityData = @json($financial_statement->analysis_report->getItem('Long Term Debts/Equities')->getValues());
    var financialLeverageData = @json($financial_statement->analysis_report->getItem('Total Assets/Equities')->getValues());
    var averageFinancialLeverageData = @json($financial_statement->analysis_report->getItem('Average Total Assets/Average Equities')->getValues());

    // Bao cao ket qua HDKD
    @if(!empty($financial_statement->income_statement))
        var revenueData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('3')->getValues()));
        var earningsAfterTaxParentCompanyData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('21')->getValues()));
        var grossProfitData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('5')->getValues()));
        var cogsData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('4')->getValues()));
        var financialExpenseData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('7')->getValues()));
        var sellingExpenseData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('9')->getValues()));
        var generalAdminExpenseData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('10')->getValues()));
        var eBTData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('15')->getValues()));
        var financialRevenueData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('6')->getValues()));
        var interestExpenseData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->income_statement->getItem('701')->getValues()));
        var operatingProfitToEBTData = @json($financial_statement->analysis_report->getItem('Operating Profit/EBT')->getValues());
    @endif

    //Bao cao luu chuyen tien te
    @if(!empty($financial_statement->cash_flow_statement))
        var cfoData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('104')->getValues()));
        var cfiData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('212')->getValues()));
        var cffData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('311')->getValues()));
        var cashMovingData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('4')->getValues()));
        var cashEndData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('7')->getValues()));

        var deprecationData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('10201')->getValues()));
        var receivableAccountChangenData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('10301')->getValues()));
        var inventoryAccountChangenData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('10302')->getValues()));
        var payableAccountChangenData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('10303')->getValues()));
        var payForCapexData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('201')->getValues()));
        var receiveFromCapexData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('202')->getValues()));
        var payForDebtPrincipalxData = @json(array_map(function($value) {
            $value[1] = readVietnameseDongForHuman($value[1]);
            return $value;
        }, $financial_statement->cash_flow_statement->getItem('304')->getValues()));
    @endif
@endif
</script>
<script src="/js/stock-symbols/graph_report.min.js"></script>
@endpush