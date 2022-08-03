@extends('cms.layouts.master')
@section('title', "$financial_statement->symbol financial statement")

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
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="balance-statement">
                        <table>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Value</th>
                            </tr>
                            @foreach($financial_statement->balance_statement->getItems() as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->values[0]['value'] }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="tab-pane" id="income-statement">
                        Income Statement
                    </div>
                    <div class="tab-pane" id="cash-flow-statement">
                        Cash Flow Statement
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection