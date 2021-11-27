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
								<h4>{{__('Manage User Video Posts')}}</h4>
							</div>
						</div>
					</div>
					<form action="{{route('videos.list', $request->user_id)}}" method="GET">
						<div class="widget-content widget-content-area">
							<div class="row">
								<div class="col-md-3">
									<input type="text" name="search" maxlength="32" class="form-control mb-3 mb-md-0" placeholder="Search Video Post" value="{{$request->search}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
								</div>
								<div class="col-md-3">
									<select name="admin_status" class="form-control">
										<option value="">--Select Admin Approval--</option>
										@foreach(config('constant.ADMIN_STATUS') as $value => $key)
											<option {{ old('admin_status', isset($request) ? $request->admin_status : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3">
									<input type="date" name="posted" class="form-control mb-3 mb-md-0" placeholder="Post Date" value="{{$request->posted}}">
								</div>
								<!-- <div class="col-md-3">
									<input type="text" name="video_details" maxlength="50" class="form-control mb-3 mb-md-0" placeholder="Video Post Details" value="{{$request->video_details}}"> 
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
										@if(empty($user_id))<th>Added By</th>@endif
										<th>Video Post Title</th>
										<th>Video Post Details</th>
										<th>Status</th>
										<th>Admin Approval</th>
										<th>Create Date</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@if(count($record_list) > 0)
										@foreach($record_list as $record)
											<tr>
												@if(empty($user_id))<td>{{$record->user_data->full_name}}</td>@endif
												<td>{{$record->video_title}}</td>
												<td>{{$record->video_details}}</td>
												<td>@if($record->video_status==106)Closed @elseif($record->video_status==107)Solved @else Open @endif</td>
												<td>
													@if($record->admin_status==108)
														<select name="admin_status" class="video_admin_status" data-video_id="{{$record->video_id}}">
															@foreach(config('constant.ADMIN_STATUS') as $value => $key)
																<option {{ old('admin_status', isset($record) ? $record->admin_status : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
															@endforeach
														</select>
													@else
														@foreach(config('constant.ADMIN_STATUS') as $value => $key)
															{{ (isset($record) ? $record->admin_status : '') == $key ? ucwords(strtolower($value)) : ''}}
														@endforeach
													@endif
												</td>
												<td>{{date('d F, Y', strtotime($record->created_at))}}</td>
												<td class="text-center">
													<ul class="table-controls">
														<li>
															<a href="{{route('videos.view',base64_encode($record->video_id))}}" data-toggle="tooltip" data-placement="top" title="View">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
															</a>
														</li>
													</ul>
												</td>
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