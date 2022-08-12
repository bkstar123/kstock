@extends('cms.layouts.master')
@if(!empty($financial_statement->quarter))
    @section('title', "$financial_statement->symbol financial statement Q$financial_statement->quarter-$financial_statement->year")
@else
    @section('title', "$financial_statement->symbol financial statement $financial_statement->year (Yearly)")
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
                            Balance Statement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#income-statement" 
                           data-toggle="tab">
                            Income Statement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#cash-flow-statement" 
                           data-toggle="tab">
                            Cash Flow Statement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                           href="#analysis-report" 
                           data-toggle="tab">
                            Analysis Report
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
                                                            <th>Indicator</th>
                                                            <th>Value</th>
                                                            <th>Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($financial_statement->analysis_report->getItems()->where('group', $group) as $item)
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->value }}</td>
                                                                <td>{{ $item->description }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection