@extends('cms.layouts.master')
@section('title', 'Settings')

@section('content')
<div class="row">
	<div class="col-md-3">
		<div class="card card-primary">
            <ul class="nav flex-column nav-tabs">
                <li class="nav-item">
                	<a class="nav-link active" href="#thirdParty" data-toggle="tab">
                		Third party authentication
                	</a>
                </li>
            </ul>
        </div>
	</div>
	<div class="col-md-9">
		<div class="tab-content">
            <div class="tab-pane active" id="thirdParty">
                <div class="card">
				    <div class="card-header">
					    <h3>Third party authentication</h3>
					</div>
					<div class="card-body">
					    <form action="{{ route('cms.settings.update') }}" method="POST">
					        @csrf
					        <div class="form-group">
					        	<label for="api_endpoint">API Endpoint</label>
					        	<input class="form-control" 
					        	       type="text" 
					        	       placeholder="Enter the url of the API service"
					        	       id="api_endpoint"
					        	       name="api_endpoint"
					        	       value="{{ config('settings.api_endpoint') }}" />
					        </div>
					        <div class="form-group">
					        	<label for="api_token">API Token</label>
					        	<textarea class="form-control" 
					        	          placeholder="Enter the API token"
					        	          rows="10"
					        	          id="api_token"
					        	          name="api_token">{{ config('settings.api_token') }}</textarea>
					        </div>
					        <div class="col-12 text-right">
                                <button class="btn btn-success" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                                </button>
                            </div>
					    </form>
					</div>
				</div>
            </div>
        </div>
	</div>
</div>
@endsection