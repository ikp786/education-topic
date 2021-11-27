@extends('admin_panel.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row layout-top-spacing">
			<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
				@include('admin_panel.inc.validation_message')
				@include('admin_panel.inc.auth_message')
				<div class="statbox widget box box-shadow mb-1">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>{{__('Manage Users Subscription')}}</h4>
							</div>
						</div>
					</div>
					<form action="{{route('subscription.index')}}" method="GET">
						<div class="widget-content widget-content-area">
							<div class="row">
								<div class="col-md-3">
									<select name="user_id" class="form-control mb-3 mb-md-0">
										<option value="">--Select User--</option>
										@foreach($users as $user)
											<option {{ old('user_id', isset($request) ? $request->user_id : '') == $user->user_id ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3">
									<select name="mockup_id" class="form-control mb-3 mb-md-0">
										<option value="">--Select Mockup--</option>
										@foreach($mockups as $mockup)
											<option {{ old('mockup_id', isset($request) ? $request->mockup_id : '') == $mockup->mockup_id ? 'selected' : ''}} value="{{$mockup->mockup_id}}">{{$mockup->mockup_title}}</option>
										@endforeach
									</select>
								</div>
								<!-- <div class="col-md-3">
									<input type="text" name="search" maxlength="32" class="form-control mb-3 mb-md-0" placeholder="Search Post" value="{{$request->search}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
								</div> -->
								<div class="col-md-3 d-flex">
									<button class="btn btn-primary mr-3" type="submit">
										Filter
									</button>
									<button class="btn btn-danger" type="button" id="ClearFilter">
										Clear Filter
									</button>
								</div>

							</div>
						</div>
					</form>
				</div>
				<div class="statbox widget box box-shadow">
					<div class="widget-content widget-content-area">
						<div class="table-responsive">
							<table class="table table-bordered mb-4 table-hover">
								<thead>
									<tr>
										<th>UserName</th>
										<th>Mockup Title</th>
										<th>Transaction Id</th>
										<th>Create Date</th>
										<!-- <th class="text-center">Action</th> -->
									</tr>
								</thead>
								<tbody>
									@if(count($record_list) > 0)
										@foreach($record_list as $record)
											<tr>
												<td>{{$record->user_data->full_name}}</td>
												<td>{{$record->mockup_data->mockup_title}}</td>
												<td>{{$record->stripe_txn_id}}</td>
												<td>{{date('d F, Y', strtotime($record->created_at))}}</td>
											</tr>
										@endforeach
									@else
										<tr><td colspan="6" align="center"><strong>No record's found</strong></td></tr>
									@endif
								</tbody>
							</table>
						</div>
						<div class="paginating-container pagination-solid justify-content-end">
							{{$record_list->appends($request->all())->render('vendor.pagination.custom')}}
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection  