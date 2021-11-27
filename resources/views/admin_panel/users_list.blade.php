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
								<h4>{{__('Manage Users')}}</h4>
							</div>
						</div>
					</div>
					<form action="{{route('users.index')}}" method="GET">
						<div class="widget-content widget-content-area">
							<div class="row">
								<div class="col-md-3">
									<input type="text" maxlength="32" class="form-control mb-3 mb-md-0" name="user_name" placeholder="User Name" value="{{$request->user_name}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
								</div>
								<div class="col-md-3">
									<input type="text" maxlength="50" class="form-control mb-3 mb-md-0" name="email_address" placeholder="Email Address" value="{{$request->email_address}}"> 
								</div>
								<div class="col-md-3">
									<input type="text" maxlength="9" class="form-control mb-3 mb-md-0" name="mobile_number" placeholder="Mobile Number" value="{{$request->mobile_number}}" onkeypress="return IsNumber(event, this.value, '9')"> 
								</div>
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
										<th>Name</th>
										<th>Email Address</th>
										<th>Mobile Number</th>
										<th>Profile Photo</th>
										<th>Reg. Date</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@if(count($record_list) > 0)
										@foreach($record_list as $record)
											<tr>
												<td>{{$record->full_name}}</td>
												<td>{{$record->email_address}}</td>
												<td>{{$record->mobile_number}}</td>
												<td>
													@if(!empty($record->user_image))
														<img src="{{asset('storage/user_images')}}/{{$record->user_image}}" alt="user img" width="100" />
													@else
														<span class="order_model"><b>Pending</b></span>
													@endif
												</td>
												<td>{{date('d F, Y', strtotime($record->created_at))}}</td>
												<td class="text-center">
													<ul class="table-controls">
														<li>
															<a href="{{route('users.profile',base64_encode($record->user_id))}}" data-toggle="tooltip" data-placement="top" title="View">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
															</a>
														</li>
														<!-- <li>
															<a href="{{route('users.edit',base64_encode($record->user_id))}}" data-toggle="tooltip" data-placement="top" title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
															</a>
														</li>
														<li>
															<form action="{{route('users.destroy',$record->user_id)}}" method="POST">
																@csrf
																@method('DELETE')
																<buttton type="submit" class="delete-user" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
															</form>
														</li> -->
														<li><a href="{{route('posts.list',base64_encode($record->user_id))}}" data-toggle="tooltip" data-placement="top" title="View General Post"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list text-primary"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg></a></li>
														<li><a href="{{route('videos.list',base64_encode($record->user_id))}}" data-toggle="tooltip" data-placement="top" title="View Video Post"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video text-primary"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></a></li>
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